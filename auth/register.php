<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="register.title">Register - KTT Indonesia Tax Payment System</title>
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
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
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
            background: radial-gradient(circle, rgba(2, 132, 199, 0.1) 0%, transparent 70%);
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

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 0 1px rgba(0, 0, 0, 0.05);
            overflow: visible;
            max-width: 950px;
            width: 100%;
            padding: 50px 60px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .register-header h1 {
            color: #1e293b;
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .register-header p {
            color: #64748b;
            font-size: 1rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: #e74c3c;
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
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            background: white;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .btn-register {
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
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .register-footer {
            text-align: center;
            margin-top: 25px;
            color: #64748b;
        }

        .register-footer a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
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
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .register-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 data-i18n="register.heading">Daftar Akun Baru</h1>
            <p data-i18n="register.subtitle">Lengkapi data di bawah untuk membuat akun pembayaran pajak</p>
        </div>

        <div id="alert" class="alert"></div>

        <form id="registerForm" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name"><span data-i18n="register.full_name">Nama Lengkap</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="full_name" name="full_name" data-i18n-placeholder="register.full_name_placeholder" placeholder="Nama lengkap sesuai KTP" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username"><span data-i18n="register.username">Username</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" class="form-control" id="username" name="username" data-i18n-placeholder="register.username_placeholder" placeholder="Username unik" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email"><span data-i18n="register.email">Email</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email" data-i18n-placeholder="register.email_placeholder" placeholder="email@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone"><span data-i18n="register.phone">No. Telepon</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="tel" class="form-control" id="phone" name="phone" data-i18n-placeholder="register.phone_placeholder" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="npwp"><span data-i18n="register.npwp">NPWP</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" class="form-control" id="npwp" name="npwp" data-i18n-placeholder="register.npwp_placeholder" placeholder="00.000.000.0-000.000" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nik"><span data-i18n="register.nik">NIK</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card-alt"></i>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="16" data-i18n-placeholder="register.nik_placeholder" placeholder="16 digit NIK" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address"><span data-i18n="register.address">Alamat</span> <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-map-marker-alt"></i>
                    <textarea class="form-control" id="address" name="address" data-i18n-placeholder="register.address_placeholder" placeholder="Alamat lengkap" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password"><span data-i18n="register.password">Password</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" data-i18n-placeholder="register.password_placeholder" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password"><span data-i18n="register.confirm_password">Konfirmasi Password</span> <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" data-i18n-placeholder="register.confirm_password_placeholder" placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="admin_code"><span data-i18n="register.admin_code">Kode Akses Admin</span> <span style="color: #64748b; font-weight: 400;" data-i18n="register.optional">(Opsional)</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-key"></i>
                    <input type="text" class="form-control" id="admin_code" name="admin_code" data-i18n-placeholder="register.admin_code_placeholder" placeholder="Kosongkan jika mendaftar sebagai user biasa">
                </div>
                <small style="color: #64748b; font-size: 0.85rem; margin-top: 5px; display: block;">
                    <i class="fas fa-info-circle"></i> <span data-i18n="register.admin_code_hint">Masukkan kode akses khusus untuk mendaftar sebagai admin</span>
                </small>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> <span data-i18n="register.button">Daftar Sekarang</span>
            </button>
        </form>

        <div class="register-footer">
            <span data-i18n="register.have_account">Sudah punya akun?</span> <a href="login.php" data-i18n="register.login_link">Login di sini</a>
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

    <script src="../assets/js/translations.js"></script>
    <script>
        // Initialize i18n for register page
        const registerTranslations = {
            id: {
                'register.title': 'Register - KTT Indonesia Tax Payment System',
                'register.heading': 'Daftar Akun Baru',
                'register.subtitle': 'Lengkapi data di bawah untuk membuat akun pembayaran pajak',
                'register.full_name': 'Nama Lengkap',
                'register.full_name_placeholder': 'Nama lengkap sesuai KTP',
                'register.username': 'Username',
                'register.username_placeholder': 'Username unik',
                'register.email': 'Email',
                'register.email_placeholder': 'email@example.com',
                'register.phone': 'No. Telepon',
                'register.phone_placeholder': '08xxxxxxxxxx',
                'register.npwp': 'NPWP',
                'register.npwp_placeholder': '00.000.000.0-000.000',
                'register.nik': 'NIK',
                'register.nik_placeholder': '16 digit NIK',
                'register.address': 'Alamat',
                'register.address_placeholder': 'Alamat lengkap',
                'register.password': 'Password',
                'register.password_placeholder': 'Minimal 6 karakter',
                'register.confirm_password': 'Konfirmasi Password',
                'register.confirm_password_placeholder': 'Ulangi password',
                'register.admin_code': 'Kode Akses Admin',
                'register.optional': '(Opsional)',
                'register.admin_code_placeholder': 'Kosongkan jika mendaftar sebagai user biasa',
                'register.admin_code_hint': 'Masukkan kode akses khusus untuk mendaftar sebagai admin',
                'register.button': 'Daftar Sekarang',
                'register.have_account': 'Sudah punya akun?',
                'register.login_link': 'Login di sini',
                'register.error_password_mismatch': 'Password dan konfirmasi password tidak cocok!',
                'register.error_generic': 'Terjadi kesalahan. Silakan coba lagi.'
            },
            en: {
                'register.title': 'Register - KTT Indonesia Tax Payment System',
                'register.heading': 'Create New Account',
                'register.subtitle': 'Complete the form below to create your tax payment account',
                'register.full_name': 'Full Name',
                'register.full_name_placeholder': 'Full name as per ID card',
                'register.username': 'Username',
                'register.username_placeholder': 'Unique username',
                'register.email': 'Email',
                'register.email_placeholder': 'email@example.com',
                'register.phone': 'Phone Number',
                'register.phone_placeholder': '08xxxxxxxxxx',
                'register.npwp': 'Tax ID (NPWP)',
                'register.npwp_placeholder': '00.000.000.0-000.000',
                'register.nik': 'ID Number (NIK)',
                'register.nik_placeholder': '16 digit ID number',
                'register.address': 'Address',
                'register.address_placeholder': 'Complete address',
                'register.password': 'Password',
                'register.password_placeholder': 'Minimum 6 characters',
                'register.confirm_password': 'Confirm Password',
                'register.confirm_password_placeholder': 'Repeat password',
                'register.admin_code': 'Admin Access Code',
                'register.optional': '(Optional)',
                'register.admin_code_placeholder': 'Leave blank to register as regular user',
                'register.admin_code_hint': 'Enter special access code to register as admin',
                'register.button': 'Register Now',
                'register.have_account': 'Already have an account?',
                'register.login_link': 'Login here',
                'register.error_password_mismatch': 'Password and confirm password do not match!',
                'register.error_generic': 'An error occurred. Please try again.'
            }
        };

        // Merge with global translations if exists
        if (typeof translations !== 'undefined') {
            Object.keys(registerTranslations).forEach(lang => {
                translations[lang] = {
                    ...translations[lang],
                    ...registerTranslations[lang]
                };
            });
        } else {
            window.translations = registerTranslations;
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

        // Register form submission
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const alertDiv = document.getElementById('alert');
            
            if (password !== confirmPassword) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.textContent = translate('register.error_password_mismatch', currentLang);
                return;
            }

            const formData = new FormData(this);
            
            try {
                const response = await fetch('process_register.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = result.message;
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    alertDiv.className = 'alert alert-error';
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = result.message;
                }
            } catch (error) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.textContent = translate('register.error_generic', currentLang);
            }
        });

        // Format NPWP
        document.getElementById('npwp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 15) value = value.substr(0, 15);
            
            let formatted = '';
            if (value.length > 0) formatted += value.substr(0, 2);
            if (value.length > 2) formatted += '.' + value.substr(2, 3);
            if (value.length > 5) formatted += '.' + value.substr(5, 3);
            if (value.length > 8) formatted += '.' + value.substr(8, 1);
            if (value.length > 9) formatted += '-' + value.substr(9, 3);
            if (value.length > 12) formatted += '.' + value.substr(12, 3);
            
            e.target.value = formatted;
        });

        // NIK only numbers
        document.getElementById('nik').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>
