<?php
// Detect if we're in a subfolder (pages, api, auth) to adjust paths
$currentDir = dirname($_SERVER['SCRIPT_FILENAME']);
$rootDir = dirname(__DIR__);
$isInSubfolder = ($currentDir != $rootDir);
$pathPrefix = $isInSubfolder ? '../' : '';
?>
<div class="sidebar" id="sidebar">
    <!-- Restore sidebar state immediately to prevent flash -->
    <script>
        (function() {
            if (window.innerWidth > 1024) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    document.getElementById('sidebar').classList.add('collapsed');
                    // Main content will be updated when DOM is ready
                }
            }
            // Enable transitions after page fully loaded to prevent flash/swinging
            setTimeout(function() {
                document.getElementById('sidebar').classList.add('transition-enabled');
                document.body.classList.add('page-loaded');
            }, 100);
        })();
    </script>
    
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-landmark"></i>
            <span class="logo-text">KTT Indonesia</span>
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
                <a href="<?php echo $pathPrefix; ?>pages/dashboard.php" data-i18n-title="menu.dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span data-i18n="menu.dashboard">Dashboard</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'pembayaran.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/pembayaran.php" data-i18n-title="menu.payment">
                    <i class="fas fa-money-bill-wave"></i>
                    <span data-i18n="menu.payment">Pembayaran</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/riwayat.php" data-i18n-title="menu.history">
                    <i class="fas fa-history"></i>
                    <span data-i18n="menu.history">Riwayat</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'jenis_pajak.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/jenis_pajak.php" data-i18n-title="menu.tax_types">
                    <i class="fas fa-list-alt"></i>
                    <span data-i18n="menu.tax_types">Jenis Pajak</span>
                </a>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/laporan.php" data-i18n-title="menu.report">
                    <i class="fas fa-file-alt"></i>
                    <span data-i18n="menu.report">Laporan</span>
                </a>
            </li>

            <?php if (isAdmin()): ?>
            <li class="menu-separator">
                <span data-i18n="menu.admin_section">ADMINISTRATOR</span>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/users.php" data-i18n-title="menu.users">
                    <i class="fas fa-users"></i>
                    <span data-i18n="menu.users">Kelola Pengguna</span>
                </a>
            </li>
            <?php endif; ?>

            <li class="menu-separator">
                <span data-i18n="menu.account_section">AKUN</span>
            </li>

            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                <a href="<?php echo $pathPrefix; ?>pages/profile.php" data-i18n-title="menu.profile">
                    <i class="fas fa-user-cog"></i>
                    <span data-i18n="menu.profile">Profil Saya</span>
                </a>
            </li>

            <li>
                <a href="<?php echo $pathPrefix; ?>auth/logout.php" data-i18n-title="menu.logout" onclick="return confirm(window.i18n ? window.i18n.t('msg.confirm_logout') : 'Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span data-i18n="menu.logout">Keluar</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    // Tunggu sampai semua DOM selesai loading
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua elemen yang diperlukan
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const mainContent = document.querySelector('.main-content');

        // Debug: Cek apakah elemen ditemukan
        console.log('Sidebar initialized:', {
            sidebar: !!sidebar,
            sidebarToggle: !!sidebarToggle,
            sidebarOverlay: !!sidebarOverlay,
            menuToggle: !!menuToggle,
            mainContent: !!mainContent
        });

        // Pastikan semua elemen ada
        if (!sidebar || !sidebarToggle || !sidebarOverlay || !mainContent) {
            console.error('Sidebar elements not found!');
            return;
        }

        // Toggle untuk mobile (overlay mode) dan desktop (collapsed mode)
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Menu toggle clicked, window width:', window.innerWidth);
                
                if (window.innerWidth <= 1024) {
                    // Mobile: Tampilkan sebagai overlay
                    sidebar.classList.add('active');
                    sidebarOverlay.classList.add('active');
                    console.log('Mobile mode: Sidebar opened');
                } else {
                    // Desktop: Toggle collapse
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                    
                    // Simpan state di localStorage
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                    console.log('Desktop mode: Sidebar collapsed =', isCollapsed);
                }
            });
        } else {
            console.warn('Menu toggle button not found!');
        }

        // Tutup sidebar di mobile (tombol X)
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            console.log('Sidebar closed via toggle button');
        });

        // Tutup sidebar di mobile (klik overlay)
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            console.log('Sidebar closed via overlay click');
        });

        // Update main-content class to match sidebar state (sidebar itself already restored via inline script)
        if (window.innerWidth > 1024) {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('sidebar-collapsed');
                console.log('Updated main-content for collapsed state');
            }
        }

        // Handle resize window
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                // Desktop mode: tutup overlay jika ada
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                
                // Restore collapsed state dari localStorage
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('sidebar-collapsed');
                }
            } else {
                // Mobile mode: hapus collapsed class
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('sidebar-collapsed');
            }
        });

        console.log('Sidebar script initialized successfully!');
    });
</script>
