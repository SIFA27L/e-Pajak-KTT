<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h4><i class="fas fa-landmark"></i> <?php echo COMPANY_NAME; ?></h4>
            <p data-i18n="footer.tagline">Sistem Pembayaran Pajak Online yang Aman dan Terpercaya</p>
        </div>

        <div class="footer-section">
            <h4><i class="fas fa-map-marker-alt"></i> <span data-i18n="footer.office_address">Alamat Kantor</span></h4>
            <p><?php echo COMPANY_ADDRESS; ?></p>
        </div>

        <div class="footer-section">
            <h4><i class="fas fa-phone"></i> <span data-i18n="footer.contact_us">Hubungi Kami</span></h4>
            <p>
                <i class="fas fa-phone-alt"></i> <?php echo COMPANY_PHONE; ?><br>
                <i class="fas fa-envelope"></i> <?php echo COMPANY_EMAIL; ?><br>
                <i class="fas fa-globe"></i> <?php echo COMPANY_WEBSITE; ?>
            </p>
        </div>

        <div class="footer-section">
            <h4><i class="fas fa-clock"></i> <span data-i18n="footer.operational_hours">Jam Operasional</span></h4>
            <p>
                <span data-i18n="footer.weekdays">Senin - Jumat</span>: 08:00 - 17:00 WIB<br>
                <span data-i18n="footer.saturday">Sabtu</span>: 08:00 - 12:00 WIB<br>
                <span data-i18n="footer.sunday">Minggu & Libur</span>: <span data-i18n="footer.closed">Tutup</span>
            </p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php echo COMPANY_NAME; ?>. <span data-i18n="footer.rights">All Rights Reserved</span>.</p>
        <p><span data-i18n="footer.developed">Developed with</span> <i class="fas fa-heart" style="color: #e74c3c;"></i> <span data-i18n="footer.by_team">by KTT Indonesia IT Team</span></p>
    </div>
</footer>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="logout-modal">
    <div class="logout-modal-content">
        <div class="logout-modal-header">
            <div class="logout-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 data-i18n="modal.logout_title">Konfirmasi Logout</h3>
        </div>
        <div class="logout-modal-body">
            <p data-i18n="modal.logout_message">Apakah Anda yakin ingin keluar dari sistem?</p>
            <p class="logout-info" data-i18n="modal.logout_info">Anda perlu login kembali untuk mengakses sistem.</p>
        </div>
        <div class="logout-modal-footer">
            <button type="button" class="btn-cancel" onclick="closeLogoutModal()" data-i18n="modal.cancel">Batal</button>
            <button type="button" class="btn-logout-confirm" onclick="confirmLogout()" data-i18n="modal.confirm_logout">Ya, Logout</button>
        </div>
    </div>
</div>

<style>
.logout-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.3s ease;
}

.logout-modal-content {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    margin: 10% auto;
    padding: 0;
    border-radius: 20px;
    max-width: 450px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.3s ease;
    overflow: hidden;
    border: 1px solid rgba(14, 165, 233, 0.2);
}

.logout-modal-header {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    padding: 30px;
    text-align: center;
    color: white;
}

.logout-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.logout-icon i {
    font-size: 36px;
    color: white;
}

.logout-modal-header h3 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.logout-modal-body {
    padding: 30px;
    text-align: center;
}

.logout-modal-body p {
    margin: 0 0 15px 0;
    font-size: 16px;
    color: #334155;
    line-height: 1.6;
}

.logout-info {
    font-size: 14px;
    color: #64748b;
    font-style: italic;
}

.logout-modal-footer {
    padding: 20px 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.logout-modal-footer button {
    flex: 1;
    padding: 14px 24px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
    border: 2px solid #e2e8f0;
}

.btn-cancel:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-logout-confirm {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-logout-confirm:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .logout-modal-content {
        margin: 20% 20px;
        max-width: 100%;
    }
    
    .logout-modal-footer {
        flex-direction: column;
    }
    
    .logout-modal-footer button {
        width: 100%;
    }
}
</style>

<script>
let logoutUrl = '';

function showLogoutModal(url) {
    logoutUrl = url;
    document.getElementById('logoutModal').style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Re-enable scrolling
    logoutUrl = '';
}

function confirmLogout() {
    if (logoutUrl) {
        window.location.href = logoutUrl;
    }
}

// Close modal when clicking outside
document.getElementById('logoutModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeLogoutModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLogoutModal();
    }
});
</script>
