/**
 * AJAX Implementation for Dashboard
 * Auto-refresh stats, real-time updates
 */

document.addEventListener('DOMContentLoaded', function() {
    let refreshInterval = null;
    const AUTO_REFRESH_INTERVAL = 30000; // 30 seconds

    /**
     * Load dashboard stats
     */
    async function loadDashboardStats() {
        const result = await ajax.get('ajax-api.php?action=get_stats', {
            showLoading: false
        });

        if (result.success) {
            updateStatsDisplay(result.data);
        }
    }

    /**
     * Update stats display
     */
    function updateStatsDisplay(stats) {
        // Update total users (admin only)
        const totalUsersEl = document.getElementById('stat-total-users');
        if (totalUsersEl && stats.total_users !== undefined) {
            animateValue(totalUsersEl, stats.total_users);
        }

        // Update total payments
        const totalPaymentsEl = document.getElementById('stat-total-payments');
        if (totalPaymentsEl && stats.total_payments !== undefined) {
            animateValue(totalPaymentsEl, stats.total_payments);
        }

        // Update total revenue (admin) or total paid (user)
        const totalRevenueEl = document.getElementById('stat-total-revenue');
        if (totalRevenueEl && stats.total_revenue !== undefined) {
            animateValue(totalRevenueEl, stats.total_revenue, true);
        }

        const totalPaidEl = document.getElementById('stat-total-paid');
        if (totalPaidEl && stats.total_paid !== undefined) {
            animateValue(totalPaidEl, stats.total_paid, true);
        }

        // Update pending payments
        const pendingPaymentsEl = document.getElementById('stat-pending-payments');
        if (pendingPaymentsEl && stats.pending_payments !== undefined) {
            animateValue(pendingPaymentsEl, stats.pending_payments);
        }

        // Add pulse effect
        document.querySelectorAll('.stat-card').forEach(card => {
            card.classList.add('pulse');
            setTimeout(() => card.classList.remove('pulse'), 600);
        });
    }

    /**
     * Animate value change
     */
    function animateValue(element, targetValue, isCurrency = false) {
        const currentValue = parseInt(element.textContent.replace(/[^0-9]/g, '')) || 0;
        
        if (currentValue === targetValue) return;

        const duration = 1000;
        const stepTime = 30;
        const steps = duration / stepTime;
        const increment = (targetValue - currentValue) / steps;
        let current = currentValue;
        let step = 0;

        const timer = setInterval(() => {
            step++;
            current += increment;

            if (step >= steps) {
                current = targetValue;
                clearInterval(timer);
            }

            if (isCurrency) {
                element.textContent = formatRupiah(Math.round(current));
            } else {
                element.textContent = Math.round(current).toLocaleString('id-ID');
            }
        }, stepTime);
    }

    /**
     * Format Rupiah
     */
    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    /**
     * Start auto-refresh
     */
    function startAutoRefresh() {
        if (refreshInterval) return;

        refreshInterval = setInterval(() => {
            loadDashboardStats();
            showRefreshIndicator();
        }, AUTO_REFRESH_INTERVAL);

        console.log('Auto-refresh started:', AUTO_REFRESH_INTERVAL + 'ms');
    }

    /**
     * Stop auto-refresh
     */
    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
            console.log('Auto-refresh stopped');
        }
    }

    /**
     * Show refresh indicator
     */
    function showRefreshIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'refresh-indicator';
        indicator.innerHTML = '<i class="fas fa-sync-alt"></i> Data diperbarui';
        document.body.appendChild(indicator);

        setTimeout(() => indicator.classList.add('show'), 100);
        setTimeout(() => {
            indicator.classList.remove('show');
            setTimeout(() => indicator.remove(), 300);
        }, 2000);
    }

    /**
     * Manual refresh button
     */
    const refreshBtn = document.getElementById('refreshStats');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.classList.add('spinning');
            loadDashboardStats();
            setTimeout(() => this.classList.remove('spinning'), 1000);
        });
    }

    // Initialize
    loadDashboardStats();
    startAutoRefresh();

    // Stop refresh when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
            loadDashboardStats();
        }
    });

    // Expose functions globally
    window.dashboardAjax = {
        loadStats: loadDashboardStats,
        startAutoRefresh,
        stopAutoRefresh
    };
});

/**
 * Load recent payments for dashboard
 */
async function loadRecentPayments() {
    const container = document.getElementById('recentPayments');
    if (!container) return;

    const result = await ajax.get('ajax-api.php?action=get_payments&limit=5', {
        showLoading: false
    });

    if (result.success) {
        renderRecentPayments(result.data.payments, container);
    }
}

/**
 * Render recent payments
 */
function renderRecentPayments(payments, container) {
    if (payments.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">Belum ada pembayaran</p>';
        return;
    }

    let html = '<div class="recent-payments-list">';
    
    payments.forEach(payment => {
        const statusClass = {
            'berhasil': 'success',
            'pending': 'warning',
            'gagal': 'danger',
            'dibatalkan': 'secondary'
        }[payment.status_pembayaran] || 'secondary';

        html += `
            <div class="payment-item">
                <div class="payment-info">
                    <strong>${payment.nomor_pembayaran}</strong>
                    <span class="payment-tax">${payment.nama_pajak}</span>
                    <span class="payment-date">${formatDate(payment.created_at)}</span>
                </div>
                <div class="payment-amount">
                    <strong>${formatRupiah(payment.total_bayar)}</strong>
                    <span class="badge badge-${statusClass}">${payment.status_pembayaran}</span>
                </div>
            </div>
        `;
    });

    html += '</div>';
    container.innerHTML = html;
}

/**
 * Format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
}

/**
 * Format Rupiah
 */
function formatRupiah(amount) {
    return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
}

// Add CSS for refresh indicator
const style = document.createElement('style');
style.textContent = `
    .refresh-indicator {
        position: fixed;
        top: 80px;
        right: -300px;
        background: #0ea5e9;
        color: white;
        padding: 12px 20px;
        border-radius: 8px 0 0 8px;
        box-shadow: -2px 2px 10px rgba(0, 0, 0, 0.2);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 9997;
        transition: right 0.3s ease;
    }

    .refresh-indicator.show {
        right: 0;
    }

    .refresh-indicator i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .spinning {
        animation: spin 1s linear infinite;
    }

    .recent-payments-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .payment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid #0ea5e9;
    }

    .payment-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .payment-tax {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .payment-date {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .payment-amount {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    @media (max-width: 768px) {
        .refresh-indicator {
            top: 70px;
            font-size: 0.85rem;
            padding: 10px 16px;
        }

        .payment-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .payment-amount {
            align-items: flex-start;
        }
    }
`;
document.head.appendChild(style);
