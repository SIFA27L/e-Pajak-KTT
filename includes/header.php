<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <h2><?php echo ucfirst(str_replace('.php', '', basename($_SERVER['PHP_SELF']))); ?></h2>
        </div>
    </div>

    <div class="header-right">
        <div class="datetime-display" id="datetimeDisplay">
            <i class="fas fa-calendar-alt"></i>
            <span id="currentDateTime"></span>
        </div>

        <div class="header-actions">
            <div class="notification-btn">
                <i class="fas fa-bell"></i>
                <span class="badge-notification">3</span>
            </div>

            <div class="user-menu">
                <div class="user-avatar-small">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span><?php echo $_SESSION['full_name']; ?></span>
            </div>
        </div>
    </div>
</header>

<script>
    function updateDateTime() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const day = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const dateTimeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes}:${seconds} WIB`;
        document.getElementById('currentDateTime').textContent = dateTimeString;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
