<?php
/**
 * Session Ping Handler
 * Keeps session alive when user is active and checks session validity
 */

// Start session without config to avoid redirect
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // No active session
    http_response_code(401);
    echo json_encode([
        'status' => 'invalid',
        'message' => 'No active session'
    ]);
    exit();
}

// Check if session has expired based on last activity
$sessionTimeout = 300; // 5 minutes (same as config.php SESSION_TIMEOUT)

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $inactiveTime = time() - $_SESSION['LAST_ACTIVITY'];
    
    if ($inactiveTime > $sessionTimeout) {
        // Session expired
        session_unset();
        session_destroy();
        
        http_response_code(401);
        echo json_encode([
            'status' => 'expired',
            'message' => 'Session expired due to inactivity',
            'inactive_time' => $inactiveTime
        ]);
        exit();
    }
}

// Update last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();

// Return success
http_response_code(200);
echo json_encode([
    'status' => 'active',
    'message' => 'Session updated',
    'timestamp' => time(),
    'user_id' => $_SESSION['user_id']
]);
?>
