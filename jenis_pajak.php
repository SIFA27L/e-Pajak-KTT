<?php
require_once 'config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();

// Get jenis pajak
$stmt = $conn->prepare("SELECT * FROM jenis_pajak ORDER BY nama_pajak");
$stmt->execute();
$jenisPajak = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Pajak - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .pajak-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .pajak-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 5px solid #10b981;
        }

        .pajak-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .pajak-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .pajak-code {
            font-size: 1.3rem;
            font-weight: 700;
            color: #059669;
        }

        .pajak-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .pajak-desc {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .pajak-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .pajak-rate {
            font-size: 1.5rem;
            font-weight: 700;
            color: #10b981;
        }

        .info-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .info-section h3 {
            color: #059669;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-section ul {
            list-style: none;
            padding: 0;
        }

        .info-section li {
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-section li:last-child {
            border-bottom: none;
        }

        .info-section li i {
            color: #10b981;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 data-i18n="tax.title">Jenis Pajak Indonesia</h1>
                <p data-i18n="tax.subtitle">Informasi lengkap tentang berbagai jenis pajak yang tersedia</p>
            </div>

            <div class="info-section">
                <h3><i class="fas fa-info-circle"></i> <span data-i18n="tax.info_title">Informasi Pajak Indonesia</span></h3>
                <ul>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span data-i18n="tax.info_1">Semua warga negara Indonesia yang memiliki penghasilan di atas PTKP (Penghasilan Tidak Kena Pajak) wajib membayar pajak</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span data-i18n="tax.info_2">Pajak dapat dibayarkan secara online melalui sistem e-Billing Direktorat Jenderal Pajak</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span data-i18n="tax.info_3">Pastikan NPWP Anda aktif dan valid sebelum melakukan pembayaran</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span data-i18n="tax.info_4">Simpan bukti pembayaran pajak Anda sebagai arsip dan bukti pelaporan</span>
                    </li>
                </ul>
            </div>

            <div class="pajak-grid">
                <?php foreach ($jenisPajak as $pajak): ?>
                <div class="pajak-card" data-tax-code="<?php echo $pajak['kode_pajak']; ?>">
                    <div class="pajak-header">
                        <div class="pajak-code"><?php echo $pajak['kode_pajak']; ?></div>
                        <span class="badge <?php echo $pajak['status'] == 'active' ? 'badge-success' : 'badge-secondary'; ?>">
                            <?php echo ucfirst($pajak['status']); ?>
                        </span>
                    </div>
                    <div class="pajak-title" data-i18n-dynamic="tax_name"><?php echo $pajak['nama_pajak']; ?></div>
                    <div class="pajak-desc" data-i18n-dynamic="tax_desc"><?php echo $pajak['deskripsi']; ?></div>
                    <div class="pajak-info">
                        <div>
                            <?php if ($pajak['persentase'] > 0): ?>
                            <span class="pajak-rate"><?php echo number_format($pajak['persentase'], 2); ?>%</span>
                            <?php else: ?>
                            <span style="color: #6b7280; font-size: 0.9rem;" data-i18n="tax.as_regulated">Sesuai Ketentuan</span>
                            <?php endif; ?>
                        </div>
                        <button class="btn-primary" onclick="window.location.href='pembayaran.php?tax_id=<?php echo $pajak['id']; ?>'">
                            <i class="fas fa-arrow-right"></i> <span data-i18n="tax.pay_now">Bayar</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="info-section" style="margin-top: 30px;">
                <h3><i class="fas fa-book"></i> <span data-i18n="tax.regulations_title">Ketentuan Umum Perpajakan</span></h3>
                <ul>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPh 21:</strong> <span data-i18n="tax.reg_pph21">Dipotong oleh pemberi kerja setiap bulan dari gaji/upah karyawan</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPh 22:</strong> <span data-i18n="tax.reg_pph22">Dipungut atas kegiatan impor atau pembelian barang tertentu</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPh 23:</strong> <span data-i18n="tax.reg_pph23">Dipotong atas penghasilan dari modal, penyerahan jasa, atau hadiah dan penghargaan</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPh 25:</strong> <span data-i18n="tax.reg_pph25">Angsuran pajak yang dibayar sendiri setiap bulan</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPh 29:</strong> <span data-i18n="tax.reg_pph29">Pelunasan kekurangan pembayaran pajak saat pelaporan SPT Tahunan</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPN:</strong> <span data-i18n="tax.reg_ppn">Pajak yang dikenakan atas transaksi jual beli barang dan jasa kena pajak</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PPnBM:</strong> <span data-i18n="tax.reg_ppnbm">Pajak tambahan untuk barang-barang mewah tertentu</span></span>
                    </li>
                    <li>
                        <i class="fas fa-angle-right"></i>
                        <span><strong>PBB:</strong> <span data-i18n="tax.reg_pbb">Pajak tahunan atas kepemilikan tanah dan bangunan</span></span>
                    </li>
                </ul>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>
