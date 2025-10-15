<?php
/**
 * Session Ping Handler
 * Keeps session alive when user is active
 */

session_start();

// Update last activity timestamp
if (isset($_SESSION['user_id'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
    
    // Return success
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Session updated',
        'timestamp' => time()
    ]);
} else {
    // No active session
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'No active session'
    ]);
}
?>
