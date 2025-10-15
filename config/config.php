<?php
// General Configuration
session_start();

// Helper function to get path to login
function getLoginPath() {
    $currentDir = dirname($_SERVER['SCRIPT_FILENAME']);
    $rootDir = dirname(__DIR__);
    $isInSubfolder = ($currentDir != $rootDir);
    return $isInSubfolder ? '../auth/login.php' : 'auth/login.php';
}

// Session Timeout Configuration (in seconds)
define('SESSION_TIMEOUT', 300); 
// Check session timeout
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $inactive_time = time() - $_SESSION['LAST_ACTIVITY'];
    if ($inactive_time > SESSION_TIMEOUT) {
        // Session expired
        session_unset();
        session_destroy();
        
        // Set flash message for timeout
        session_start();
        $_SESSION['timeout_message'] = 'Sesi Anda telah berakhir karena tidak aktif. Silakan login kembali.';
        header("Location: " . getLoginPath());
        exit();
    }
}

// Update last activity time
if (isset($_SESSION['user_id'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Prevent browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Base URL
define('BASE_URL', 'http://localhost/e-commerce/');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Company Information
define('COMPANY_NAME', 'PT KTT Indonesia');
define('COMPANY_SHORT', 'KTT Indonesia');
define('COMPANY_ADDRESS', 'Jl. Nangka, Tanjung Barat, Jakarta Selatan, 12530, Indonesia');
define('COMPANY_PHONE', '0851 7531 0587');
define('COMPANY_EMAIL', 'info@kttindonesia.com');
define('COMPANY_WEBSITE', 'www.kttindonesia.com');

// Upload Configuration
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB

// Pagination
define('ITEMS_PER_PAGE', 10);

// Include Database
require_once __DIR__ . '/database.php';

// Helper Functions
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    // Prevent browser cache on protected pages
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    
    if (!isLoggedIn()) {
        // Clear any existing session data
        session_unset();
        session_destroy();
        
        // Start new session for message
        session_start();
        $_SESSION['login_required'] = 'Silakan login untuk mengakses halaman ini.';
        
        header("Location: " . getLoginPath());
        exit();
    }
}

function isSuperAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin';
}

function isAdmin() {
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin');
}

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

function formatDateTime($datetime, $format = 'd/m/Y H:i') {
    return date($format, strtotime($datetime));
}

function generateNomorPembayaran() {
    return 'INV-' . date('Y') . '-' . strtoupper(substr(uniqid(), -8));
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
