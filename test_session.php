<?php
/**
 * Test Session Timeout - For Development Only
 * Reduces timeout to 2 minutes for quick testing
 * WARNING: Delete this file in production!
 */

session_start();

// Override timeout for testing (2 minutes = 120 seconds)
define('SESSION_TIMEOUT_TEST', 120); // 2 minutes
define('WARNING_TIME_TEST', 30);      // Warning at 30 seconds before timeout

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_required'] = 'Anda harus login terlebih dahulu.';
    header("Location: login.php");
    exit();
}

// Initialize last activity
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Check session timeout
$inactive_time = time() - $_SESSION['LAST_ACTIVITY'];
if ($inactive_time > SESSION_TIMEOUT_TEST) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['timeout_message'] = 'Sesi Anda telah habis karena tidak aktif. Silakan login kembali.';
    header("Location: login.php");
    exit();
}

// Update last activity
$_SESSION['LAST_ACTIVITY'] = time();

// Calculate remaining time
$remaining_time = SESSION_TIMEOUT_TEST - $inactive_time;
$remaining_minutes = floor($remaining_time / 60);
$remaining_seconds = $remaining_time % 60;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Test Session Timeout - KTT Indonesia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .test-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .test-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .test-header h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .test-header p {
            color: #666;
            font-size: 1.1em;
        }

        .warning-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .warning-box i {
            font-size: 2em;
            color: #ff9800;
        }

        .warning-box div {
            flex: 1;
        }

        .warning-box h3 {
            color: #856404;
            margin-bottom: 5px;
        }

        .warning-box p {
            color: #856404;
            margin: 0;
        }

        .status-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .status-item:last-child {
            margin-bottom: 0;
        }

        .status-label {
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-label i {
            color: #667eea;
        }

        .status-value {
            font-size: 1.2em;
            font-weight: 700;
            color: #667eea;
        }

        .status-value.warning {
            color: #ff9800;
        }

        .status-value.danger {
            color: #f44336;
        }

        .instructions {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .instructions h3 {
            color: #1976d2;
            margin-bottom: 15px;
        }

        .instructions ol {
            margin-left: 20px;
            color: #555;
        }

        .instructions li {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: #4caf50;
            color: white;
        }

        .btn-success:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #f44336;
            color: white;
        }

        .btn-danger:hover {
            background: #da190b;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .test-container {
                padding: 25px;
            }

            .test-header h1 {
                font-size: 1.5em;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1><i class="fas fa-vial"></i> Session Timeout Test</h1>
            <p>Testing dengan timeout 2 menit (120 detik)</p>
        </div>

        <div class="warning-box">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <h3>WARNING: Development Mode Only!</h3>
                <p>File ini hanya untuk testing. Hapus file ini sebelum production!</p>
            </div>
        </div>

        <div class="status-box">
            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-user"></i>
                    <span>User Login</span>
                </div>
                <div class="status-value">
                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                </div>
            </div>

            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-clock"></i>
                    <span>Session Timeout</span>
                </div>
                <div class="status-value">
                    <?php echo SESSION_TIMEOUT_TEST; ?> detik (2 menit)
                </div>
            </div>

            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-bell"></i>
                    <span>Warning Time</span>
                </div>
                <div class="status-value warning">
                    <?php echo WARNING_TIME_TEST; ?> detik sebelum timeout
                </div>
            </div>

            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Waktu Tersisa</span>
                </div>
                <div class="status-value <?php echo $remaining_time <= WARNING_TIME_TEST ? 'danger' : ''; ?>" id="remaining-time">
                    <?php printf("%02d:%02d", $remaining_minutes, $remaining_seconds); ?>
                </div>
            </div>

            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-history"></i>
                    <span>Last Activity</span>
                </div>
                <div class="status-value" id="last-activity">
                    <?php echo date('H:i:s', $_SESSION['LAST_ACTIVITY']); ?>
                </div>
            </div>
        </div>

        <div class="instructions">
            <h3><i class="fas fa-clipboard-list"></i> Cara Testing:</h3>
            <ol>
                <li><strong>Test Auto-Logout:</strong> Jangan lakukan apa-apa selama 2 menit, sistem akan otomatis logout</li>
                <li><strong>Test Warning Modal:</strong> Tunggu hingga 30 detik terakhir, modal warning akan muncul</li>
                <li><strong>Test Continue Session:</strong> Klik tombol "Continue Session" pada modal untuk reset timer</li>
                <li><strong>Test Activity Tracking:</strong> Gerakkan mouse, scroll, atau ketik untuk reset timer</li>
                <li><strong>Test Browser Cache:</strong> Logout, lalu tekan tombol back pada browser (harus redirect ke login)</li>
                <li><strong>Test Logout Message:</strong> Perhatikan pesan yang muncul setelah timeout atau manual logout</li>
            </ol>
        </div>

        <div class="button-group">
            <button class="btn btn-success" onclick="simulateActivity()">
                <i class="fas fa-hand-pointer"></i>
                Simulate Activity
            </button>
            <button class="btn btn-primary" onclick="location.href='dashboard.php'">
                <i class="fas fa-home"></i>
                Ke Dashboard
            </button>
            <button class="btn btn-danger" onclick="location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </div>

    <!-- Load Session Manager with Test Configuration -->
    <script>
        // Test configuration
        const isProtectedPage = true;
        const testMode = true;
    </script>
    <script src="assets/js/session-manager.js"></script>
    
    <!-- Override session manager with test settings -->
    <script>
        // Destroy default instance
        if (window.sessionManager) {
            window.sessionManager.destroy();
        }

        // Create test instance with 2 minute timeout
        window.sessionManager = new SessionManager({
            timeout: <?php echo SESSION_TIMEOUT_TEST; ?>,      // 2 minutes
            warningTime: <?php echo WARNING_TIME_TEST; ?>,     // 30 seconds before
            checkInterval: 5000    // Check every 5 seconds for faster response
        });

        // Update remaining time display
        setInterval(() => {
            fetch('ping_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const currentTime = Math.floor(Date.now() / 1000);
                        const lastActivity = data.timestamp;
                        const inactive = currentTime - lastActivity;
                        const remaining = <?php echo SESSION_TIMEOUT_TEST; ?> - inactive;
                        
                        const minutes = Math.floor(remaining / 60);
                        const seconds = remaining % 60;
                        
                        const timeDisplay = document.getElementById('remaining-time');
                        timeDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                        
                        // Update color based on remaining time
                        if (remaining <= <?php echo WARNING_TIME_TEST; ?>) {
                            timeDisplay.classList.add('danger');
                        } else {
                            timeDisplay.classList.remove('danger');
                        }

                        // Update last activity
                        const lastActivityDisplay = document.getElementById('last-activity');
                        const lastActivityDate = new Date(lastActivity * 1000);
                        lastActivityDisplay.textContent = lastActivityDate.toLocaleTimeString('id-ID');
                    }
                })
                .catch(error => console.error('Error updating time:', error));
        }, 1000); // Update every second

        // Simulate activity function
        function simulateActivity() {
            if (window.sessionManager) {
                window.sessionManager.updateActivity();
                alert('Activity disimulasikan! Timer direset.');
            }
        }

        console.log('%c⚠️ SESSION TIMEOUT TEST MODE ⚠️', 'color: orange; font-size: 20px; font-weight: bold;');
        console.log('Timeout: <?php echo SESSION_TIMEOUT_TEST; ?> seconds (2 minutes)');
        console.log('Warning: <?php echo WARNING_TIME_TEST; ?> seconds before timeout');
        console.log('Check interval: 5 seconds');
    </script>
</body>
</html>
