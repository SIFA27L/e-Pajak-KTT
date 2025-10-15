<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header("Location: ../pages/dashboard.php");
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
    <title data-i18n="login.title">Login - KTT Indonesia Tax Payment System</title>
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
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 0 1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
            display: flex;
            min-height: 620px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .login-left h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .login-left p {
            font-size: 1.05rem;
            line-height: 1.7;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
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
            color: #1e293b;
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #64748b;
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
            padding: 13px 15px 13px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            background: white;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #64748b;
        }

        .login-footer a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #0284c7;
            text-decoration: underline;
        }

        .language-switcher {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .lang-btn {
            padding: 8px 20px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lang-btn:hover {
            border-color: #0ea5e9;
            color: #0ea5e9;
            background: #f0f9ff;
        }

        .lang-btn.active {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .lang-btn i {
            font-size: 1rem;
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
            <div class="logo-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <h1 data-i18n="login.brand">KTT Indonesia</h1>
            <p data-i18n="login.description">Sistem Pembayaran Pajak Online yang Aman, Mudah, dan Terpercaya. Kelola pembayaran pajak Anda dengan efisien dan transparan.</p>
        </div>

        <div class="login-right">
            <div class="login-header">
                <h2 data-i18n="login.welcome">Selamat Datang</h2>
                <p data-i18n="login.subtitle">Silakan login untuk melanjutkan</p>
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
                    <label for="username" data-i18n="login.username_label">Username atau Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="username" name="username" data-i18n-placeholder="login.username_placeholder" placeholder="Masukkan username atau email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" data-i18n="login.password_label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" data-i18n-placeholder="login.password_placeholder" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> <span data-i18n="login.button">Masuk</span>
                </button>
            </form>

            <div class="login-footer">
                <span data-i18n="login.no_account">Belum punya akun?</span> <a href="register.php" data-i18n="login.register_link">Daftar Sekarang</a>
            </div>

            <div class="language-switcher">
                <button class="lang-btn active" data-lang="id">
                    <i class="fas fa-globe"></i> Indonesia
                </button>
                <button class="lang-btn" data-lang="en">
                    <i class="fas fa-globe"></i> English
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/translations.js"></script>
    <script>
        // Initialize i18n for login page
        const loginTranslations = {
            id: {
                'login.title': 'Login - KTT Indonesia Tax Payment System',
                'login.brand': 'KTT Indonesia',
                'login.description': 'Sistem Pembayaran Pajak Online yang Aman, Mudah, dan Terpercaya. Kelola pembayaran pajak Anda dengan efisien dan transparan.',
                'login.welcome': 'Selamat Datang',
                'login.subtitle': 'Silakan login untuk melanjutkan',
                'login.username_label': 'Username atau Email',
                'login.username_placeholder': 'Masukkan username atau email',
                'login.password_label': 'Password',
                'login.password_placeholder': 'Masukkan password',
                'login.button': 'Masuk',
                'login.no_account': 'Belum punya akun?',
                'login.register_link': 'Daftar Sekarang',
                'login.error_generic': 'Terjadi kesalahan. Silakan coba lagi.'
            },
            en: {
                'login.title': 'Login - KTT Indonesia Tax Payment System',
                'login.brand': 'KTT Indonesia',
                'login.description': 'Secure, Easy, and Trusted Online Tax Payment System. Manage your tax payments efficiently and transparently.',
                'login.welcome': 'Welcome Back',
                'login.subtitle': 'Please login to continue',
                'login.username_label': 'Username or Email',
                'login.username_placeholder': 'Enter username or email',
                'login.password_label': 'Password',
                'login.password_placeholder': 'Enter password',
                'login.button': 'Sign In',
                'login.no_account': "Don't have an account?",
                'login.register_link': 'Register Now',
                'login.error_generic': 'An error occurred. Please try again.'
            }
        };

        // Merge with global translations if exists
        if (typeof translations !== 'undefined') {
            Object.keys(loginTranslations).forEach(lang => {
                translations[lang] = {
                    ...translations[lang],
                    ...loginTranslations[lang]
                };
            });
        } else {
            window.translations = loginTranslations;
        }

        // Get saved language or default to 'id'
        let currentLang = localStorage.getItem('language') || 'id';

        function translate(key, lang) {
            return translations[lang] && translations[lang][key] ? translations[lang][key] : key;
        }

        function applyTranslations(lang) {
            // Translate elements with data-i18n attribute
            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                element.textContent = translate(key, lang);
            });

            // Translate placeholders
            document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
                const key = element.getAttribute('data-i18n-placeholder');
                element.placeholder = translate(key, lang);
            });

            // Update document title
            const titleElement = document.querySelector('title[data-i18n]');
            if (titleElement) {
                const key = titleElement.getAttribute('data-i18n');
                document.title = translate(key, lang);
            }

            // Update active language button
            document.querySelectorAll('.lang-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-lang') === lang) {
                    btn.classList.add('active');
                }
            });
        }

        // Apply translations on page load
        applyTranslations(currentLang);

        // Language switcher
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');
                currentLang = lang;
                localStorage.setItem('language', lang);
                applyTranslations(lang);
            });
        });

        // Login form submission
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
                        window.location.href = '../pages/dashboard.php';
                    }, 1000);
                } else {
                    alertDiv.className = 'alert alert-error';
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = result.message;
                }
            } catch (error) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.textContent = translate('login.error_generic', currentLang);
            }
        });
    </script>
</body>
</html>
