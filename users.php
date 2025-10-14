<?php
require_once 'config/config.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

$db = new Database();
$conn = $db->getConnection();

// Get all users
$stmt = $conn->prepare("SELECT id, username, email, full_name, role, npwp, nik, phone, status, created_at, last_login FROM users ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$stmt = $conn->prepare("SELECT 
    COUNT(*) as total_users,
    SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as total_admin,
    SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as total_user,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as total_active,
    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as total_inactive
FROM users");
$stmt->execute();
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$page_title = "Manajemen User";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .users-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon.admin {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .stat-icon.user {
            background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);
        }

        .stat-icon.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon.inactive {
            background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        }

        .stat-details h3 {
            font-size: 1.8rem;
            color: #1f2937;
            margin: 0;
        }

        .stat-details p {
            color: #6b7280;
            margin: 5px 0 0 0;
            font-size: 0.9rem;
        }

        .users-header {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: #10b981;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            border-color: #10b981;
            color: #10b981;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
        }

        .users-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table thead {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .users-table th,
        .users-table td {
            padding: 15px;
            text-align: left;
        }

        .users-table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .users-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .users-table tbody tr:hover {
            background: #f9fafb;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-details h4 {
            margin: 0;
            font-size: 0.95rem;
            color: #1f2937;
        }

        .user-details p {
            margin: 3px 0 0 0;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge.admin {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge.user {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .badge.active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #1e40af;
            color: white;
        }

        .btn-toggle {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-toggle:hover {
            background: #92400e;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #991b1b;
            color: white;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #1f2937;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .modal-close:hover {
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .alert.active {
            display: block;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="alert" id="alertBox"></div>

            <!-- Statistics Cards -->
            <div class="users-stats">
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($stats['total_users']); ?></h3>
                        <p data-i18n="users.total_users">Total User</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon admin">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($stats['total_admin']); ?></h3>
                        <p data-i18n="users.administrator">Administrator</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon user">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($stats['total_user']); ?></h3>
                        <p data-i18n="users.regular_user">User Biasa</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon active">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($stats['total_active']); ?></h3>
                        <p data-i18n="users.active">Aktif</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon inactive">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($stats['total_inactive']); ?></h3>
                        <p data-i18n="users.inactive">Nonaktif</p>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="users-header">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari user berdasarkan nama, email, atau NPWP..." data-i18n-placeholder="users.search_placeholder">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all" data-i18n="users.all">Semua</button>
                    <button class="filter-btn" data-filter="admin" data-i18n="users.admin">Admin</button>
                    <button class="filter-btn" data-filter="user" data-i18n="users.user">User</button>
                    <button class="filter-btn" data-filter="active" data-i18n="users.active">Aktif</button>
                    <button class="filter-btn" data-filter="inactive" data-i18n="users.inactive">Nonaktif</button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th data-i18n="users.user">User</th>
                            <th>NPWP</th>
                            <th data-i18n="users.phone">Telepon</th>
                            <th data-i18n="users.role">Role</th>
                            <th data-i18n="users.status">Status</th>
                            <th data-i18n="users.joined">Bergabung</th>
                            <th data-i18n="users.last_login">Login Terakhir</th>
                            <th data-i18n="users.action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php foreach ($users as $user): ?>
                        <tr data-role="<?php echo $user['role']; ?>" data-status="<?php echo $user['status']; ?>">
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                                    </div>
                                    <div class="user-details">
                                        <h4><?php echo htmlspecialchars($user['full_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['npwp']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td>
                                <span class="badge <?php echo $user['role']; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo $user['status']; ?>">
                                    <?php echo $user['status'] == 'active' ? 'Aktif' : 'Nonaktif'; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['last_login']): ?>
                                    <?php echo date('d/m/Y H:i', strtotime($user['last_login'])); ?>
                                <?php else: ?>
                                    <span style="color: #9ca3af;">Belum login</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-edit" onclick="editUser(<?php echo $user['id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn-action btn-toggle" onclick="toggleStatus(<?php echo $user['id']; ?>, '<?php echo $user['status']; ?>')">
                                        <i class="fas fa-power-off"></i>
                                        <?php echo $user['status'] == 'active' ? 'Nonaktifkan' : 'Aktifkan'; ?>
                                    </button>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <button class="btn-action btn-delete" onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['full_name']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit User</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="editForm">
                <input type="hidden" id="editUserId">
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" id="editFullName" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="editEmail" required>
                </div>

                <div class="form-group">
                    <label>Telepon</label>
                    <input type="tel" class="form-control" id="editPhone" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="editRole" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const rows = document.querySelectorAll('#usersTableBody tr');

                rows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else if (filter === 'admin' || filter === 'user') {
                        row.style.display = row.dataset.role === filter ? '' : 'none';
                    } else if (filter === 'active' || filter === 'inactive') {
                        row.style.display = row.dataset.status === filter ? '' : 'none';
                    }
                });
            });
        });

        // Edit user
        function editUser(userId) {
            fetch(`get_user.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('editUserId').value = data.user.id;
                        document.getElementById('editFullName').value = data.user.full_name;
                        document.getElementById('editEmail').value = data.user.email;
                        document.getElementById('editPhone').value = data.user.phone;
                        document.getElementById('editRole').value = data.user.role;
                        document.getElementById('editModal').classList.add('active');
                    }
                });
        }

        // Close modal
        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Submit edit form
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('user_id', document.getElementById('editUserId').value);
            formData.append('full_name', document.getElementById('editFullName').value);
            formData.append('email', document.getElementById('editEmail').value);
            formData.append('phone', document.getElementById('editPhone').value);
            formData.append('role', document.getElementById('editRole').value);

            try {
                const response = await fetch('update_user.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                showAlert(data.message, data.success ? 'success' : 'error');

                if (data.success) {
                    closeModal();
                    setTimeout(() => location.reload(), 1500);
                }
            } catch (error) {
                showAlert('Terjadi kesalahan sistem', 'error');
            }
        });

        // Toggle user status
        async function toggleStatus(userId, currentStatus) {
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            const action = newStatus === 'active' ? 'mengaktifkan' : 'menonaktifkan';

            if (!confirm(`Apakah Anda yakin ingin ${action} user ini?`)) return;

            try {
                const response = await fetch('toggle_user_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ user_id: userId, status: newStatus })
                });

                const data = await response.json();
                showAlert(data.message, data.success ? 'success' : 'error');

                if (data.success) {
                    setTimeout(() => location.reload(), 1500);
                }
            } catch (error) {
                showAlert('Terjadi kesalahan sistem', 'error');
            }
        }

        // Delete user
        async function deleteUser(userId, userName) {
            if (!confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\n\nPeringatan: Semua data pembayaran user ini juga akan terhapus!`)) return;

            try {
                const response = await fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ user_id: userId })
                });

                const data = await response.json();
                showAlert(data.message, data.success ? 'success' : 'error');

                if (data.success) {
                    setTimeout(() => location.reload(), 1500);
                }
            } catch (error) {
                showAlert('Terjadi kesalahan sistem', 'error');
            }
        }

        // Show alert
        function showAlert(message, type) {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = message;
            alertBox.className = `alert ${type} active`;
            
            setTimeout(() => {
                alertBox.classList.remove('active');
            }, 5000);
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
