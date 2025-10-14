<?php
session_start();

// Check logout reason
$reason = isset($_GET['reason']) ? $_GET['reason'] : '';

// Set appropriate message based on reason
if ($reason === 'timeout') {
    $_SESSION['timeout_message'] = 'Sesi Anda telah habis karena tidak aktif. Silakan login kembali.';
} else {
    $_SESSION['logout_message'] = 'Anda telah berhasil logout.';
}

// Destroy session
session_destroy();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Redirect to login
header("Location: login.php");
exit();
?>
