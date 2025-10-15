<?php
require_once '../config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();

// Get statistics
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Total Pembayaran
$query = "SELECT COUNT(*) as total FROM pembayaran_pajak";
if ($role !== 'superadmin') {
    $query .= " WHERE user_id = :user_id";
}
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$totalPembayaran = $stmt->fetch()['total'];

// Total Berhasil
$query = "SELECT COUNT(*) as total FROM pembayaran_pajak WHERE status_pembayaran = 'berhasil'";
if ($role !== 'superadmin') {
    $query .= " AND user_id = :user_id";
}
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$totalBerhasil = $stmt->fetch()['total'];

// Total Nominal
$query = "SELECT COALESCE(SUM(total_bayar), 0) as total FROM pembayaran_pajak WHERE status_pembayaran = 'berhasil'";
if ($role !== 'superadmin') {
    $query .= " AND user_id = :user_id";
}
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$totalNominal = $stmt->fetch()['total'];

// Pending
$query = "SELECT COUNT(*) as total FROM pembayaran_pajak WHERE status_pembayaran = 'pending'";
if ($role !== 'superadmin') {
    $query .= " AND user_id = :user_id";
}
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$totalPending = $stmt->fetch()['total'];

// Recent Payments
$query = "SELECT p.*, j.nama_pajak, j.kode_pajak, u.full_name 
          FROM pembayaran_pajak p 
          JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
          JOIN users u ON p.user_id = u.id";
if ($role !== 'superadmin') {
    $query .= " WHERE p.user_id = :user_id";
}
$query .= " ORDER BY p.created_at DESC LIMIT 10";
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$recentPayments = $stmt->fetchAll();

// Chart Data - Monthly
$query = "SELECT 
            DATE_FORMAT(tanggal_pembayaran, '%Y-%m') as bulan,
            SUM(total_bayar) as total
          FROM pembayaran_pajak 
          WHERE status_pembayaran = 'berhasil' 
          AND tanggal_pembayaran >= DATE_SUB(NOW(), INTERVAL 6 MONTH)";
if ($role !== 'superadmin') {
    $query .= " AND user_id = :user_id";
}
$query .= " GROUP BY DATE_FORMAT(tanggal_pembayaran, '%Y-%m') ORDER BY bulan";
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$monthlyData = $stmt->fetchAll();

// Pajak Type Distribution
$query = "SELECT 
            j.nama_pajak,
            COUNT(*) as jumlah,
            SUM(p.total_bayar) as total
          FROM pembayaran_pajak p
          JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
          WHERE p.status_pembayaran = 'berhasil'";
if ($role !== 'superadmin') {
    $query .= " AND p.user_id = :user_id";
}
$query .= " GROUP BY j.id ORDER BY total DESC LIMIT 5";
$stmt = $conn->prepare($query);
if ($role !== 'superadmin') {
    $stmt->bindParam(':user_id', $userId);
}
$stmt->execute();
$pajakDistribution = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 data-i18n="dashboard.title">Dashboard</h1>
                <p data-i18n="dashboard.welcome">Selamat datang di Sistem Pembayaran Pajak KTT Indonesia</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($totalPembayaran); ?></h3>
                        <p data-i18n="dashboard.total_payment">Total Pembayaran</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($totalBerhasil); ?></h3>
                        <p data-i18n="dashboard.paid">Pembayaran Berhasil</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo formatRupiah($totalNominal); ?></h3>
                        <p data-i18n="dashboard.total_amount">Total Nominal</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($totalPending); ?></h3>
                        <p data-i18n="dashboard.pending">Menunggu Pembayaran</p>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="chart-grid">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 data-i18n="dashboard.monthly_stats">Statistik Pembayaran Bulanan</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 data-i18n="dashboard.tax_distribution">Distribusi Jenis Pajak</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="pajakChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Payments Table -->
            <div class="table-card">
                <div class="table-header">
                    <h3 data-i18n="dashboard.recent_payments">Pembayaran Terbaru</h3>
                    <a href="pembayaran.php" class="btn-primary">
                        <span data-i18n="dashboard.view_all">Lihat Semua</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th data-i18n="dashboard.payment_no">No. Pembayaran</th>
                                <?php if ($role === 'superadmin'): ?>
                                <th data-i18n="users.name">Nama</th>
                                <?php endif; ?>
                                <th data-i18n="history.tax_type">Jenis Pajak</th>
                                <th>NPWP</th>
                                <th data-i18n="dashboard.period">Periode</th>
                                <th data-i18n="history.amount">Jumlah</th>
                                <th data-i18n="history.status">Status</th>
                                <th data-i18n="history.date">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPayments as $payment): ?>
                            <tr>
                                <td><?php echo $payment['nomor_pembayaran']; ?></td>
                                <?php if ($role === 'superadmin'): ?>
                                <td><?php echo $payment['full_name']; ?></td>
                                <?php endif; ?>
                                <td>
                                    <span class="badge badge-info"><?php echo $payment['kode_pajak']; ?></span>
                                    <?php echo $payment['nama_pajak']; ?>
                                </td>
                                <td><?php echo $payment['npwp']; ?></td>
                                <td><?php echo $payment['masa_pajak'] . ' ' . $payment['tahun_pajak']; ?></td>
                                <td><?php echo formatRupiah($payment['total_bayar']); ?></td>
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
                                <td><?php echo $payment['tanggal_pembayaran'] ? formatDateTime($payment['tanggal_pembayaran']) : '-'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>
    </div>

    <script>
        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthlyData, 'bulan')); ?>,
                datasets: [{
                    label: 'Total Pembayaran',
                    data: <?php echo json_encode(array_column($monthlyData, 'total')); ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Pajak Distribution Chart
        const pajakCtx = document.getElementById('pajakChart').getContext('2d');
        const pajakChart = new Chart(pajakCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($pajakDistribution, 'nama_pajak')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($pajakDistribution, 'total')); ?>,
                    backgroundColor: [
                        '#10b981',
                        '#34d399',
                        '#6ee7b7',
                        '#a7f3d0',
                        '#d1fae5'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
