<?php
require_once 'config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Get riwayat pembayaran
$query = "SELECT p.*, j.nama_pajak, j.kode_pajak, u.full_name 
          FROM pembayaran_pajak p 
          JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
          JOIN users u ON p.user_id = u.id";

if ($role !== 'superadmin') {
    $query .= " WHERE p.user_id = :user_id";
}

$query .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$payments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-bar input,
        .filter-bar select {
            padding: 10px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .filter-bar input {
            flex: 1;
            min-width: 250px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 0.9rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .btn-sm:hover {
            opacity: 0.8;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-download {
            background: #10b981;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            margin-bottom: 10px;
        }

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
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
        }

        .detail-value {
            color: #6b7280;
        }

        /* Button payment action base */
        .btn-payment-action {
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        /* Responsive button optimization for mobile */
        @media (max-width: 768px) {
            .btn-payment-action,
            .empty-state .btn-primary {
                padding: 8px 12px !important;
                font-size: 0.85rem !important;
                max-width: 200px;
                min-width: auto;
                width: auto;
                height: auto;
                line-height: 1.3;
            }

            .btn-payment-action i,
            .empty-state .btn-primary i {
                font-size: 0.85rem;
            }

            .filter-bar .btn-primary {
                padding: 8px 12px !important;
                font-size: 0.85rem !important;
                width: auto;
                flex-shrink: 0;
            }

            .filter-bar {
                padding: 15px;
                justify-content: center;
            }

            .empty-state i.fa-inbox {
                font-size: 3rem;
            }
        }

        @media (max-width: 480px) {
            .btn-payment-action,
            .empty-state .btn-primary {
                padding: 7px 10px !important;
                font-size: 0.78rem !important;
                max-width: 170px;
                gap: 5px;
            }

            .btn-payment-action i,
            .empty-state .btn-primary i {
                font-size: 0.78rem;
            }

            .filter-bar .btn-primary {
                padding: 7px 10px !important;
                font-size: 0.78rem !important;
            }

            .empty-state h3 {
                font-size: 1.1rem;
            }

            .empty-state p {
                font-size: 0.85rem;
            }

            .empty-state i.fa-inbox {
                font-size: 2.5rem;
            }
        }

        /* Landscape mobile optimization */
        @media (max-width: 1024px) and (orientation: landscape) {
            .btn-payment-action,
            .empty-state .btn-primary {
                padding: 7px 12px !important;
                font-size: 0.8rem !important;
                max-width: 200px;
            }

            .btn-payment-action i,
            .empty-state .btn-primary i {
                font-size: 0.8rem;
            }

            .filter-bar .btn-primary {
                padding: 7px 12px !important;
                font-size: 0.8rem !important;
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
                <h1>Riwayat Pembayaran</h1>
                <p>Lihat semua riwayat pembayaran pajak Anda</p>
            </div>

            <div class="filter-bar">
                <input type="text" id="searchInput" placeholder="Cari nomor pembayaran, NPWP...">
                <select id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="berhasil">Berhasil</option>
                    <option value="pending">Pending</option>
                    <option value="gagal">Gagal</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                <button class="btn-primary" onclick="window.location.href='pembayaran.php'">
                    <i class="fas fa-plus"></i> Pembayaran Baru
                </button>
            </div>

            <div class="table-card">
                <?php if (count($payments) > 0): ?>
                <div class="table-responsive">
                    <table class="data-table" id="paymentsTable">
                        <thead>
                            <tr>
                                <th>No. Pembayaran</th>
                                <?php if ($role === 'superadmin'): ?>
                                <th>Nama Wajib Pajak</th>
                                <?php endif; ?>
                                <th>Jenis Pajak</th>
                                <th>NPWP</th>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><strong><?php echo $payment['nomor_pembayaran']; ?></strong></td>
                                <?php if ($role === 'superadmin'): ?>
                                <td><?php echo $payment['full_name']; ?></td>
                                <?php endif; ?>
                                <td>
                                    <span class="badge badge-info"><?php echo $payment['kode_pajak']; ?></span>
                                    <?php echo $payment['nama_pajak']; ?>
                                </td>
                                <td><?php echo $payment['npwp']; ?></td>
                                <td><?php echo $payment['masa_pajak'] . ' ' . $payment['tahun_pajak']; ?></td>
                                <td><strong><?php echo formatRupiah($payment['total_bayar']); ?></strong></td>
                                <td><?php echo str_replace('_', ' ', ucwords($payment['metode_pembayaran'], '_')); ?></td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    switch($payment['status_pembayaran']) {
                                        case 'berhasil': $statusClass = 'badge-success'; break;
                                        case 'pending': $statusClass = 'badge-warning'; break;
                                        case 'gagal': $statusClass = 'badge-danger'; break;
                                        case 'dibatalkan': $statusClass = 'badge-secondary'; break;
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($payment['status_pembayaran']); ?>
                                    </span>
                                </td>
                                <td><?php echo $payment['tanggal_pembayaran'] ? formatDateTime($payment['tanggal_pembayaran']) : formatDateTime($payment['created_at']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-sm btn-view" onclick="viewDetail(<?php echo htmlspecialchars(json_encode($payment)); ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-sm btn-download" onclick="downloadReceipt('<?php echo $payment['id']; ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Riwayat Pembayaran</h3>
                    <p>Anda belum melakukan pembayaran pajak. Klik tombol di bawah untuk melakukan pembayaran.</p>
                    <button class="btn-primary btn-payment-action" onclick="window.location.href='pembayaran.php'">
                        <i class="fas fa-plus"></i> Bayar Pajak Sekarang
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- Detail Modal -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-invoice"></i> Detail Pembayaran</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
        function viewDetail(payment) {
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
                    <span class="detail-value"><span class="badge badge-info">${payment.kode_pajak}</span> ${payment.nama_pajak}</span>
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
                    <span class="detail-value"><span class="badge ${statusClass[payment.status_pembayaran]}">${payment.status_pembayaran.toUpperCase()}</span></span>
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

        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        function downloadReceipt(id) {
            window.open('download_receipt.php?id=' + id, '_blank');
        }

        // Search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('paymentsTable');

        if (searchInput && table) {
            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        }

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchSearch = text.includes(searchTerm);
                const matchStatus = !statusValue || text.includes(statusValue);

                row.style.display = matchSearch && matchStatus ? '' : 'none';
            });
        }
    </script>
</body>
</html>
