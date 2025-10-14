/**
 * AJAX Implementation for Riwayat Pembayaran
 * Real-time loading, search, pagination
 */

document.addEventListener('DOMContentLoaded', function() {
    const paymentsTable = document.getElementById('paymentsTable');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    if (!paymentsTable) return;

    let currentPage = 1;
    let currentSearch = '';
    let currentStatus = '';

    // Debounced search
    const debouncedSearch = ajax.debounce(() => {
        currentSearch = searchInput.value;
        currentPage = 1;
        loadPayments();
    }, 500);

    // Event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debouncedSearch);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            currentStatus = this.value;
            currentPage = 1;
            loadPayments();
        });
    }

    /**
     * Load payments via AJAX
     */
    async function loadPayments() {
        const tbody = paymentsTable.querySelector('tbody');
        if (!tbody) return;

        // Show skeleton loading
        showSkeletonLoader(tbody);

        const params = new URLSearchParams({
            action: 'get_payments',
            page: currentPage,
            limit: 10,
            search: currentSearch,
            status: currentStatus
        });

        const result = await ajax.get(`ajax-api.php?${params.toString()}`, {
            showLoading: false
        });

        if (result.success) {
            renderPayments(result.data);
        } else {
            showError(tbody, result.error);
        }
    }

    /**
     * Render payments table
     */
    function renderPayments(data) {
        const tbody = paymentsTable.querySelector('tbody');
        const { payments, total, page, total_pages } = data;

        if (payments.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="100%" class="ajax-empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Tidak Ada Data</h3>
                        <p>Tidak ada pembayaran yang sesuai dengan filter Anda.</p>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = '';
        payments.forEach(payment => {
            const row = createPaymentRow(payment);
            tbody.appendChild(row);
        });

        // Update pagination if exists
        updatePagination(page, total_pages);

        // Animate rows
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.classList.add('fade-in');
            }, index * 50);
        });
    }

    /**
     * Create payment table row
     */
    function createPaymentRow(payment) {
        const row = document.createElement('tr');
        row.style.opacity = '0';

        const statusClass = getStatusClass(payment.status_pembayaran);
        
        row.innerHTML = `
            <td><strong>${payment.nomor_pembayaran}</strong></td>
            ${payment.full_name ? `<td>${payment.full_name}</td>` : ''}
            <td>
                <span class="badge badge-info">${payment.kode_pajak}</span>
                ${payment.nama_pajak}
            </td>
            <td>${payment.npwp}</td>
            <td>${payment.masa_pajak} ${payment.tahun_pajak}</td>
            <td><strong>${formatRupiah(payment.total_bayar)}</strong></td>
            <td>${formatPaymentMethod(payment.metode_pembayaran)}</td>
            <td>
                <span class="badge ${statusClass}">
                    ${ucfirst(payment.status_pembayaran)}
                </span>
            </td>
            <td>${formatDateTime(payment.tanggal_pembayaran || payment.created_at)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-sm btn-view" onclick="viewPaymentDetail(${payment.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-sm btn-download" onclick="downloadReceipt('${payment.id}')">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </td>
        `;

        return row;
    }

    /**
     * Show skeleton loader
     */
    function showSkeletonLoader(tbody) {
        tbody.innerHTML = '';
        for (let i = 0; i < 5; i++) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
                <td><div class="skeleton skeleton-text"></div></td>
            `;
            tbody.appendChild(row);
        }
    }

    /**
     * Show error message
     */
    function showError(tbody, error) {
        tbody.innerHTML = `
            <tr>
                <td colspan="100%" class="ajax-error-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <h4>Terjadi Kesalahan</h4>
                    <p>${error}</p>
                    <button class="btn-primary" onclick="location.reload()">
                        <i class="fas fa-refresh"></i> Muat Ulang
                    </button>
                </td>
            </tr>
        `;
    }

    /**
     * Update pagination
     */
    function updatePagination(currentPage, totalPages) {
        const paginationContainer = document.getElementById('pagination');
        if (!paginationContainer || totalPages <= 1) return;

        let html = '<div class="pagination">';
        
        // Previous button
        if (currentPage > 1) {
            html += `<button class="page-btn" onclick="loadPage(${currentPage - 1})">
                        <i class="fas fa-chevron-left"></i>
                    </button>`;
        }

        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            html += `<button class="page-btn" onclick="loadPage(1)">1</button>`;
            if (startPage > 2) {
                html += '<span class="page-dots">...</span>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" 
                        onclick="loadPage(${i})">${i}</button>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += '<span class="page-dots">...</span>';
            }
            html += `<button class="page-btn" onclick="loadPage(${totalPages})">${totalPages}</button>`;
        }

        // Next button
        if (currentPage < totalPages) {
            html += `<button class="page-btn" onclick="loadPage(${currentPage + 1})">
                        <i class="fas fa-chevron-right"></i>
                    </button>`;
        }

        html += '</div>';
        paginationContainer.innerHTML = html;
    }

    // Expose loadPage globally
    window.loadPage = function(page) {
        currentPage = page;
        loadPayments();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Helper functions
    function getStatusClass(status) {
        const classes = {
            'berhasil': 'badge-success',
            'pending': 'badge-warning',
            'gagal': 'badge-danger',
            'dibatalkan': 'badge-secondary'
        };
        return classes[status] || 'badge-secondary';
    }

    function formatRupiah(amount) {
        return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
    }

    function formatPaymentMethod(method) {
        return method.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function formatDateTime(dateTime) {
        if (!dateTime) return '-';
        const date = new Date(dateTime);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});

/**
 * View payment detail via AJAX
 */
async function viewPaymentDetail(paymentId) {
    const result = await ajax.get(`ajax-api.php?action=get_payment_detail&id=${paymentId}`);

    if (result.success) {
        showPaymentModal(result.data);
    } else {
        ajax.showToast('Gagal memuat detail pembayaran', 'error');
    }
}

/**
 * Show payment modal
 */
function showPaymentModal(payment) {
    const modal = document.getElementById('detailModal');
    const modalBody = document.getElementById('modalBody');

    const statusClass = {
        'berhasil': 'badge-success',
        'pending': 'badge-warning',
        'gagal': 'badge-danger',
        'dibatalkan': 'badge-secondary'
    };

    modalBody.innerHTML = `
        <div class="detail-row">
            <span class="detail-label">Nomor Pembayaran:</span>
            <span class="detail-value"><strong>${payment.nomor_pembayaran}</strong></span>
        </div>
        ${payment.full_name ? `
        <div class="detail-row">
            <span class="detail-label">Nama Wajib Pajak:</span>
            <span class="detail-value">${payment.full_name}</span>
        </div>
        ` : ''}
        <div class="detail-row">
            <span class="detail-label">Jenis Pajak:</span>
            <span class="detail-value">
                <span class="badge badge-info">${payment.kode_pajak}</span> ${payment.nama_pajak}
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">NPWP:</span>
            <span class="detail-value">${payment.npwp}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Masa Pajak:</span>
            <span class="detail-value">${payment.masa_pajak} ${payment.tahun_pajak}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Jumlah Pajak:</span>
            <span class="detail-value">Rp ${parseFloat(payment.jumlah_pajak).toLocaleString('id-ID')}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Denda:</span>
            <span class="detail-value">Rp ${parseFloat(payment.denda).toLocaleString('id-ID')}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><strong>Total Bayar:</strong></span>
            <span class="detail-value"><strong>Rp ${parseFloat(payment.total_bayar).toLocaleString('id-ID')}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Metode Pembayaran:</span>
            <span class="detail-value">${payment.metode_pembayaran.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status:</span>
            <span class="detail-value">
                <span class="badge ${statusClass[payment.status_pembayaran]}">${payment.status_pembayaran.toUpperCase()}</span>
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tanggal Pembayaran:</span>
            <span class="detail-value">${payment.tanggal_pembayaran || payment.created_at}</span>
        </div>
        ${payment.keterangan ? `
        <div class="detail-row">
            <span class="detail-label">Keterangan:</span>
            <span class="detail-value">${payment.keterangan}</span>
        </div>
        ` : ''}
    `;

    modal.classList.add('active');
}

/**
 * Download receipt
 */
function downloadReceipt(id) {
    ajax.showToast('Memulai download...', 'info');
    window.open('download_receipt.php?id=' + id, '_blank');
}

/**
 * Close modal
 */
function closeModal() {
    document.getElementById('detailModal').classList.remove('active');
}
