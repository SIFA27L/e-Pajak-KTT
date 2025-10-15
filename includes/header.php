<!-- Load i18n before other scripts -->
<script src="assets/js/i18n.js"></script>

<!-- Session Manager for auto-logout -->
<script>
    // Mark this as a protected page
    var isProtectedPage = true;
</script>
<script src="assets/js/session-manager.js"></script>

<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <?php
            // Get current page
            $current_page = basename($_SERVER['PHP_SELF']);
            
            // Map page to translation key
            $page_titles = [
                'dashboard.php' => 'dashboard.title',
                'jenis_pajak.php' => 'tax.title',
                'pembayaran.php' => 'payment.title',
                'riwayat.php' => 'history.title',
                'laporan.php' => 'report.title',
                'profile.php' => 'profile.title',
                'users.php' => 'users.title'
            ];
            
            // Default Indonesian titles
            $default_titles = [
                'dashboard.php' => 'Dashboard',
                'jenis_pajak.php' => 'Jenis Pajak Indonesia',
                'pembayaran.php' => 'Pembayaran Pajak',
                'riwayat.php' => 'Riwayat Pembayaran',
                'laporan.php' => 'Laporan Pembayaran Pajak',
                'profile.php' => 'Profil Saya',
                'users.php' => 'Kelola Pengguna'
            ];
            
            $i18n_key = $page_titles[$current_page] ?? '';
            $default_title = $default_titles[$current_page] ?? ucfirst(str_replace('.php', '', $current_page));
            ?>
            <h2 <?php if ($i18n_key) echo 'data-i18n="' . $i18n_key . '"'; ?>><?php echo $default_title; ?></h2>
        </div>
    </div>

    <div class="header-right">
        <div class="datetime-display" id="datetimeDisplay">
            <i class="fas fa-calendar-alt"></i>
            <span id="currentDateTime"></span>
        </div>

        <div class="header-actions">
            <div class="user-menu" id="userMenuToggle">
                <div class="user-avatar-small">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span><?php echo $_SESSION['full_name']; ?></span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>

            <!-- User Dropdown Menu -->
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="dropdown-user-info">
                        <strong><?php echo $_SESSION['full_name']; ?></strong>
                        <span class="user-email"><?php echo $_SESSION['email'] ?? 'user@example.com'; ?></span>
                        <span class="user-role badge badge-<?php echo $_SESSION['role'] === 'superadmin' ? 'danger' : 'info'; ?>">
                            <?php echo ucfirst($_SESSION['role']); ?>
                        </span>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <!-- Language Selector -->
                <div class="dropdown-section">
                    <div class="section-label">
                        <i class="fas fa-globe"></i>
                        <span data-i18n="dropdown.language">Bahasa</span>
                    </div>
                    <div class="language-selector">
                        <button class="lang-btn active" data-lang="id">
                            <img src="https://flagcdn.com/w40/id.png" alt="Indonesia" class="flag-icon">
                            <span>Indonesia</span>
                        </button>
                        <button class="lang-btn" data-lang="en">
                            <img src="https://flagcdn.com/w40/gb.png" alt="English" class="flag-icon">
                            <span>English</span>
                        </button>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <!-- Menu Items -->
                <div class="dropdown-menu-items">
                    <a href="profile.php" class="dropdown-item">
                        <i class="fas fa-user-edit"></i>
                        <span data-i18n="dropdown.edit_profile">Edit Profil</span>
                    </a>
                    <a href="logout.php" class="dropdown-item logout-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span data-i18n="dropdown.logout">Keluar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Date Time Update
    function updateDateTime() {
        const now = new Date();
        const lang = localStorage.getItem('language') || 'id';
        
        const daysID = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const daysEN = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const monthsID = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const monthsEN = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];
        
        const days = lang === 'id' ? daysID : daysEN;
        const months = lang === 'id' ? monthsID : monthsEN;
        
        const dayName = days[now.getDay()];
        const day = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const dateTimeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes}:${seconds} WIB`;
        const dateTimeElement = document.getElementById('currentDateTime');
        if (dateTimeElement) {
            dateTimeElement.textContent = dateTimeString;
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Global functions for dropdown
    function openDropdown() {
        const userDropdown = document.getElementById('userDropdown');
        const userMenuToggle = document.getElementById('userMenuToggle');
        if (userDropdown && userMenuToggle) {
            userDropdown.classList.add('active');
            userMenuToggle.classList.add('active');
        }
    }

    function closeDropdown() {
        const userDropdown = document.getElementById('userDropdown');
        const userMenuToggle = document.getElementById('userMenuToggle');
        if (userDropdown && userMenuToggle) {
            userDropdown.classList.remove('active');
            userMenuToggle.classList.remove('active');
        }
    }

    // User Dropdown Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuToggle && userDropdown) {
            // Toggle dropdown when clicking user menu
            userMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = userDropdown.classList.contains('active');
                
                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            });

            // Prevent dropdown from closing when clicking inside it (except on links)
            userDropdown.addEventListener('click', function(e) {
                // Allow links to work but don't close dropdown for language buttons
                if (e.target.closest('.lang-btn')) {
                    e.stopPropagation();
                }
                // Close dropdown if clicking on navigation links
                if (e.target.closest('a')) {
                    closeDropdown();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Add click handlers to language buttons
            const langButtons = document.querySelectorAll('.lang-btn');
            langButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const lang = this.dataset.lang;
                    changeLanguage(lang);
                });
            });
        }

        // Initialize language from localStorage
        const savedLang = localStorage.getItem('language') || 'id';
        setActiveLanguage(savedLang);
        
        // Update page content with i18n
        if (window.i18n) {
            window.i18n.updatePageContent();
        }
    });

    // Change Language Function using i18n
    function changeLanguage(lang) {
        if (window.i18n) {
            window.i18n.setLanguage(lang);
            setActiveLanguage(lang);
            updateDateTime(); // Update date time with new language
            
            // Show toast notification
            const message = window.i18n.t('msg.language_changed');
            showToast(message, 'success');
            
            // Close dropdown after changing language
            closeDropdown();
        }
    }

    function setActiveLanguage(lang) {
        const langButtons = document.querySelectorAll('.lang-btn');
        langButtons.forEach(btn => {
            if (btn.dataset.lang === lang) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    // Simple Toast Notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }
</script>
