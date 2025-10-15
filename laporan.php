<?php
require_once 'config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .report-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .report-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .report-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
        }

        .report-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .report-desc {
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .btn-generate {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn-generate:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 data-i18n="report.title">Laporan Pembayaran Pajak</h1>
                <p data-i18n="report.subtitle">Generate laporan pembayaran pajak Anda dalam berbagai format</p>
            </div>

            <div class="report-options">
                <!-- Laporan Bulanan -->
                <div class="report-card">
                    <div class="report-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="report-title" data-i18n="report.monthly_title">Laporan Bulanan</div>
                    <div class="report-desc" data-i18n="report.monthly_desc">Generate laporan pembayaran pajak per bulan</div>
                    
                    <form action="generate_report.php" method="POST" target="_blank">
                        <input type="hidden" name="type" value="monthly">
                        
                        <div class="form-group">
                            <label data-i18n="report.month">Bulan</label>
                            <select class="form-control" name="month" required>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo $i == date('n') ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label data-i18n="report.year">Tahun</label>
                            <select class="form-control" name="year" required>
                                <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn-generate">
                            <i class="fas fa-download"></i> <span data-i18n="report.generate_pdf">Generate PDF</span>
                        </button>
                    </form>
                </div>

                <!-- Laporan Tahunan -->
                <div class="report-card">
                    <div class="report-icon" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="report-title" data-i18n="report.yearly_title">Laporan Tahunan</div>
                    <div class="report-desc" data-i18n="report.yearly_desc">Generate laporan pembayaran pajak per tahun</div>
                    
                    <form action="generate_report.php" method="POST" target="_blank">
                        <input type="hidden" name="type" value="yearly">
                        
                        <div class="form-group">
                            <label data-i18n="report.year">Tahun</label>
                            <select class="form-control" name="year" required>
                                <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn-generate" style="margin-top: 76px;">
                            <i class="fas fa-download"></i> <span data-i18n="report.generate_pdf">Generate PDF</span>
                        </button>
                    </form>
                </div>

                <!-- Laporan Custom -->
                <div class="report-card">
                    <div class="report-icon" style="background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);">
                        <i class="fas fa-filter"></i>
                    </div>
                    <div class="report-title" data-i18n="report.custom_title">Laporan Custom</div>
                    <div class="report-desc" data-i18n="report.custom_desc">Generate laporan dengan periode custom</div>
                    
                    <form action="generate_report.php" method="POST" target="_blank">
                        <input type="hidden" name="type" value="custom">
                        
                        <div class="form-group">
                            <label data-i18n="report.start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>

                        <div class="form-group">
                            <label data-i18n="report.end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>

                        <button type="submit" class="btn-generate">
                            <i class="fas fa-download"></i> <span data-i18n="report.generate_pdf">Generate PDF</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="table-card" style="margin-top: 30px;">
                <div class="table-header">
                    <h3><i class="fas fa-chart-bar"></i> Ringkasan Statistik</h3>
                </div>
                
                <?php
                // Get statistics
                $query = "SELECT 
                            COUNT(*) as total_transaksi,
                            SUM(total_bayar) as total_pembayaran,
                            AVG(total_bayar) as rata_rata,
                            MAX(total_bayar) as tertinggi
                          FROM pembayaran_pajak 
                          WHERE status_pembayaran = 'berhasil'";
                
                if ($role !== 'superadmin') {
                    $query .= " AND user_id = :user_id";
                }
                
                $stmt = $conn->prepare($query);
                if ($role !== 'superadmin') {
                    $stmt->bindParam(':user_id', $userId);
                }
                $stmt->execute();
                $stats = $stmt->fetch();
                ?>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo number_format($stats['total_transaksi']); ?></h3>
                            <p>Total Transaksi</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo formatRupiah($stats['total_pembayaran']); ?></h3>
                            <p>Total Pembayaran</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo formatRupiah($stats['rata_rata']); ?></h3>
                            <p>Rata-rata Pembayaran</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%);">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo formatRupiah($stats['tertinggi']); ?></h3>
                            <p>Pembayaran Tertinggi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>
