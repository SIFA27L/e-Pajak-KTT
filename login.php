<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Get messages
$timeout_message = isset($_SESSION['timeout_message']) ? $_SESSION['timeout_message'] : '';
$login_required = isset($_SESSION['login_required']) ? $_SESSION['login_required'] : '';
$logout_message = isset($_SESSION['logout_message']) ? $_SESSION['logout_message'] : '';

// Clear messages after displaying
unset($_SESSION['timeout_message']);
unset($_SESSION['login_required']);
unset($_SESSION['logout_message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login - KTT Indonesia Tax Payment System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            min-height: 600px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .login-left p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .login-right {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .login-footer a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #047857;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-left h1 {
                font-size: 2rem;
            }

            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h1>KTT Indonesia</h1>
            <p>Sistem Pembayaran Pajak Online yang Aman, Mudah, dan Terpercaya. Kelola pembayaran pajak Anda dengan efisien dan transparan.</p>
        </div>

        <div class="login-right">
            <div class="login-header">
                <h2>Selamat Datang</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            <div id="alert" class="alert"></div>

            <?php if (!empty($timeout_message)): ?>
            <div class="alert alert-warning" style="display: block;">
                <i class="fas fa-clock"></i>
                <?php echo htmlspecialchars($timeout_message); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($login_required)): ?>
            <div class="alert alert-info" style="display: block;">
                <i class="fas fa-info-circle"></i>
                <?php echo htmlspecialchars($login_required); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($logout_message)): ?>
            <div class="alert alert-success" style="display: block;">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($logout_message); ?>
            </div>
            <?php endif; ?>

            <form id="loginForm" method="POST">
                <div class="form-group">
                    <label for="username">Username atau Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="login-footer">
                Belum punya akun? <a href="register.php">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const alertDiv = document.getElementById('alert');
            
            try {
                const response = await fetch('process_login.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = result.message;
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1000);
                } else {
                    alertDiv.className = 'alert alert-error';
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = result.message;
                }
            } catch (error) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            }
        });
    </script>
</body>
</html>
