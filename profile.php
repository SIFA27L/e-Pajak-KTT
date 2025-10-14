<?php
require_once 'config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();
$userId = $_SESSION['user_id'];

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    
    try {
        $updateStmt = $conn->prepare("UPDATE users SET full_name = :full_name, email = :email, 
                                       phone = :phone, address = :address WHERE id = :id");
        $updateStmt->bindParam(':full_name', $full_name);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':phone', $phone);
        $updateStmt->bindParam(':address', $address);
        $updateStmt->bindParam(':id', $userId);
        
        if ($updateStmt->execute()) {
            $message = 'Profil berhasil diperbarui!';
            $messageType = 'success';
            $_SESSION['full_name'] = $full_name;
            $_SESSION['email'] = $email;
            
            // Refresh user data
            $stmt->execute();
            $user = $stmt->fetch();
        }
    } catch (PDOException $e) {
        $message = 'Gagal memperbarui profil: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
                $stmt->bindParam(':password', $hashed);
                $stmt->bindParam(':id', $userId);
                
                if ($stmt->execute()) {
                    $message = 'Password berhasil diubah!';
                    $messageType = 'success';
                }
            } else {
                $message = 'Password minimal 6 karakter!';
                $messageType = 'error';
            }
        } else {
            $message = 'Password baru tidak cocok!';
            $messageType = 'error';
        }
    } else {
        $message = 'Password lama salah!';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .profile-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 25px;
        }

        .profile-sidebar {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            height: fit-content;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 3.5rem;
            color: white;
        }

        .profile-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .profile-role {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #10b981;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .profile-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
        }

        .tab {
            padding: 12px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: #10b981;
            border-bottom-color: #10b981;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 data-i18n="profile.title">Profil Saya</h1>
                <p data-i18n="profile.subtitle">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <div class="profile-container">
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="profile-name"><?php echo $user['full_name']; ?></div>
                    <div class="profile-role">
                        <span class="badge badge-info"><?php echo ucfirst($user['role']); ?></span>
                    </div>
                    <div style="margin: 15px 0; padding: 15px; background: #f9fafb; border-radius: 10px;">
                        <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">NPWP</div>
                        <div style="font-weight: 600; color: #1f2937;"><?php echo $user['npwp']; ?></div>
                    </div>
                    <div style="font-size: 0.85rem; color: #6b7280;">
                        <i class="fas fa-calendar"></i> <span data-i18n="profile.member_since">Bergabung sejak</span><br>
                        <strong><?php echo formatDate($user['created_at']); ?></strong>
                    </div>
                </div>

                <div class="profile-content">
                    <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <?php echo $message; ?>
                    </div>
                    <?php endif; ?>

                    <div class="tabs">
                        <button class="tab active" onclick="showTab('profile')">
                            <i class="fas fa-user"></i>
                            <span data-i18n="profile.personal_info">Informasi Profil</span>
                        </button>
                        <button class="tab" onclick="showTab('security')">
                            <i class="fas fa-lock"></i>
                            <span data-i18n="profile.security">Keamanan</span>
                        </button>
                    </div>

                    <div id="profile" class="tab-content active">
                        <form method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label data-i18n="profile.username">Username</label>
                                    <input type="text" class="form-control" value="<?php echo $user['username']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label data-i18n="profile.id_number">NIK</label>
                                    <input type="text" class="form-control" value="<?php echo $user['nik']; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label data-i18n="profile.full_name">Nama Lengkap</label>
                                <input type="text" class="form-control" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label data-i18n="profile.email">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label data-i18n="profile.phone">No. Telepon</label>
                                    <input type="tel" class="form-control" name="phone" value="<?php echo $user['phone']; ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label data-i18n="profile.address">Alamat</label>
                                <textarea class="form-control" name="address" rows="3" required><?php echo $user['address']; ?></textarea>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                <span data-i18n="profile.save">Simpan Perubahan</span>
                            </button>
                        </form>
                    </div>

                    <div id="security" class="tab-content">
                        <form method="POST">
                            <input type="hidden" name="change_password" value="1">
                            
                            <div class="form-group">
                                <label data-i18n="profile.old_password">Password Lama</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label data-i18n="profile.new_password">Password Baru</label>
                                <input type="password" class="form-control" name="new_password" required>
                            </div>

                            <div class="form-group">
                                <label data-i18n="profile.confirm_password">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-key"></i>
                                <span data-i18n="profile.change_password_btn">Ubah Password</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        }
    </script>
</body>
</html>
