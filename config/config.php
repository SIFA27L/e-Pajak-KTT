<?php
// General Configuration
session_start();

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
    if (!isLoggedIn()) {
        redirect('login.php');
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
