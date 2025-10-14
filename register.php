<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KTT Indonesia Tax Payment System</title>
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

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            padding: 50px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header h1 {
            color: #333;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #666;
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

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .btn-register {
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
            margin-top: 20px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .register-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .register-footer a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: #047857;
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
            <h1>Daftar Akun Baru</h1>
            <p>Lengkapi data di bawah untuk membuat akun pembayaran pajak</p>
        </div>

        <div id="alert" class="alert"></div>

        <form id="registerForm" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">Nama Lengkap <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">No. Telepon <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="npwp">NPWP <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" class="form-control" id="npwp" name="npwp" placeholder="00.000.000.0-000.000" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nik">NIK <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card-alt"></i>
                        <input type="text" class="form-control" id="nik" name="nik" maxlength="16" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat <span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-map-marker-alt"></i>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="admin_code">Kode Akses Admin (Opsional)</label>
                <div class="input-wrapper">
                    <i class="fas fa-key"></i>
                    <input type="text" class="form-control" id="admin_code" name="admin_code" placeholder="Kosongkan jika mendaftar sebagai user biasa">
                </div>
                <small style="color: #666; font-size: 0.85rem; margin-top: 5px; display: block;">
                    <i class="fas fa-info-circle"></i> Masukkan kode akses khusus untuk mendaftar sebagai admin
                </small>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>
        </form>

        <div class="register-footer">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const alertDiv = document.getElementById('alert');
            
            if (password !== confirmPassword) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.textContent = 'Password dan konfirmasi password tidak cocok!';
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
                alertDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
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
