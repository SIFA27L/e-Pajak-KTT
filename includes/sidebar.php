<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-landmark"></i>
            <span>KTT Indonesia</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-info">
            <h4><?php echo $_SESSION['full_name']; ?></h4>
            <p><?php echo ucfirst($_SESSION['role']); ?></p>
        </div>
    </div>

    <nav class="sidebar-menu">
        <ul>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <a href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'pembayaran.php' ? 'active' : ''; ?>">
                <a href="pembayaran.php">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Pembayaran Pajak</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>">
                <a href="riwayat.php">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Pembayaran</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'jenis_pajak.php' ? 'active' : ''; ?>">
                <a href="jenis_pajak.php">
                    <i class="fas fa-list-alt"></i>
                    <span>Jenis Pajak</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>">
                <a href="laporan.php">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <?php if (isAdmin()): ?>
            <li class="menu-separator">
                <span>ADMINISTRATOR</span>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <a href="users.php">
                    <i class="fas fa-users"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
            <?php endif; ?>

            <li class="menu-separator">
                <span>AKUN</span>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                <a href="profile.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            <li>
                <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const menuToggle = document.getElementById('menuToggle');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        });
    }

    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
    });

    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
    });
</script>
