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

        /* Accordion Styles */
        .accordion {
            margin-top: 20px;
        }

        .accordion-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .accordion-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            cursor: pointer;
            background: #f9fafb;
            transition: all 0.3s ease;
            user-select: none;
        }

        .accordion-header:hover {
            background: #f3f4f6;
        }

        .accordion-header.active {
            background: #ecfdf5;
            border-bottom: 1px solid #e5e7eb;
        }

        .accordion-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: #1f2937;
            font-size: 1.05rem;
        }

        .accordion-title strong {
            color: #059669;
            font-size: 1.1rem;
            min-width: 80px;
        }

        .accordion-icon {
            color: #059669;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 20px;
        }

        .accordion-content.active {
            max-height: 1000px;
            padding: 20px;
        }

        .accordion-detail {
            color: #4b5563;
            line-height: 1.8;
            font-size: 0.95rem;
        }

        .accordion-detail h4 {
            color: #059669;
            font-size: 1rem;
            margin: 15px 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .accordion-detail ul {
            list-style: none;
            padding-left: 0;
            margin: 10px 0;
        }

        .accordion-detail li {
            padding: 8px 0 8px 20px;
            position: relative;
        }

        .accordion-detail li:before {
            content: "→";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        .accordion-detail .highlight {
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 500;
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
                <?php foreach ($jenisPajak as $pajak): 
                    // Convert tax code to translation key format
                    // PPh21 -> pph_21, PPh22 -> pph_22, PPN -> ppn, PPnBM -> ppnbm, PBB -> pbb
                    $code = $pajak['kode_pajak'];
                    $taxCode = strtolower($code);
                    
                    // Add underscore between letters and numbers for PPh codes
                    if (preg_match('/^(pph)(\d+)$/i', $taxCode, $matches)) {
                        $taxCode = strtolower($matches[1]) . '_' . $matches[2];
                    }
                ?>
                <div class="pajak-card" data-tax-code="<?php echo $pajak['kode_pajak']; ?>">
                    <div class="pajak-header">
                        <div class="pajak-code"><?php echo $pajak['kode_pajak']; ?></div>
                        <span class="badge <?php echo $pajak['status'] == 'active' ? 'badge-success' : 'badge-secondary'; ?>">
                            <span data-i18n="status.<?php echo $pajak['status']; ?>"><?php echo ucfirst($pajak['status']); ?></span>
                        </span>
                    </div>
                    <div class="pajak-title" data-i18n="tax.<?php echo $taxCode; ?>_name"><?php echo $pajak['nama_pajak']; ?></div>
                    <div class="pajak-desc" data-i18n="tax.<?php echo $taxCode; ?>_desc"><?php echo $pajak['deskripsi']; ?></div>
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
                <p style="color: #6b7280; margin-bottom: 20px;"><span data-i18n="tax.regulations_subtitle">Klik pada setiap jenis pajak untuk melihat informasi detail</span></p>
                
                <div class="accordion">
                    <!-- PPh 21 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPh 21</strong>
                                <span data-i18n="tax.reg_pph21_title">Pajak Penghasilan Pasal 21</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pph21_detail">Pajak atas penghasilan berupa gaji, upah, honorarium, tunjangan, dan pembayaran lain yang diterima oleh pegawai, bukan pegawai, atau pensiunan.</p>
                                
                                <h4><i class="fas fa-users"></i> <span data-i18n="tax.subject_title">Subjek Pajak:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pph21_subject1">Pegawai tetap dan pegawai tidak tetap</li>
                                    <li data-i18n="tax.reg_pph21_subject2">Penerima pensiun dan mantan pegawai</li>
                                    <li data-i18n="tax.reg_pph21_subject3">Bukan pegawai yang menerima penghasilan</li>
                                </ul>

                                <h4><i class="fas fa-calculator"></i> <span data-i18n="tax.calculation_title">Cara Perhitungan:</span></h4>
                                <p data-i18n="tax.reg_pph21_calculation">Penghasilan bruto dikurangi dengan biaya jabatan (5%) dan iuran pensiun, kemudian dikurangi PTKP. Hasil tersebut dikalikan dengan tarif progresif PPh sesuai lapisan penghasilan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PPh 22 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPh 22</strong>
                                <span data-i18n="tax.reg_pph22_title">Pajak Penghasilan Pasal 22</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pph22_detail">Pajak yang dipungut oleh bendahara pemerintah, badan tertentu, atau wajib pajak badan tertentu atas pembelian barang.</p>
                                
                                <h4><i class="fas fa-building"></i> <span data-i18n="tax.object_title">Objek Pajak:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pph22_object1">Impor barang</li>
                                    <li data-i18n="tax.reg_pph22_object2">Pembelian barang oleh bendahara pemerintah</li>
                                    <li data-i18n="tax.reg_pph22_object3">Penjualan hasil produksi industri tertentu</li>
                                </ul>

                                <h4><i class="fas fa-percent"></i> <span data-i18n="tax.rate_title">Tarif:</span></h4>
                                <p data-i18n="tax.reg_pph22_rate">Bervariasi antara 0.25% - 7.5% tergantung jenis transaksi dan status wajib pajak (memiliki API atau tidak).</p>
                            </div>
                        </div>
                    </div>

                    <!-- PPh 23 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPh 23</strong>
                                <span data-i18n="tax.reg_pph23_title">Pajak Penghasilan Pasal 23</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pph23_detail">Pajak yang dipotong atas penghasilan yang berasal dari modal, penyerahan jasa, atau penyelenggaraan kegiatan selain yang telah dipotong PPh Pasal 21.</p>
                                
                                <h4><i class="fas fa-briefcase"></i> <span data-i18n="tax.services_title">Jenis Jasa:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pph23_service1">Jasa teknik, manajemen, konstruksi, dan konsultan</li>
                                    <li data-i18n="tax.reg_pph23_service2">Sewa dan penghasilan lain sehubungan dengan penggunaan harta</li>
                                    <li data-i18n="tax.reg_pph23_service3">Dividen, bunga, royalti, dan hadiah</li>
                                </ul>

                                <h4><i class="fas fa-percent"></i> <span data-i18n="tax.rate_title">Tarif:</span></h4>
                                <p data-i18n="tax.reg_pph23_rate">2% untuk jasa dan 15% untuk dividen, bunga, royalti, dan hadiah (kecuali yang dikecualikan).</p>
                            </div>
                        </div>
                    </div>

                    <!-- PPh 25 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPh 25</strong>
                                <span data-i18n="tax.reg_pph25_title">Pajak Penghasilan Pasal 25</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pph25_detail">Angsuran pajak yang harus dibayar sendiri oleh Wajib Pajak setiap bulan dalam tahun pajak berjalan.</p>
                                
                                <h4><i class="fas fa-calendar-check"></i> <span data-i18n="tax.payment_title">Pembayaran:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pph25_payment1">Dibayar setiap bulan paling lambat tanggal 15 bulan berikutnya</li>
                                    <li data-i18n="tax.reg_pph25_payment2">Besarnya dihitung dari PPh terutang tahun lalu dikurangi kredit pajak, dibagi 12</li>
                                    <li data-i18n="tax.reg_pph25_payment3">Dapat menggunakan tarif 0.5% dari omzet untuk WP kriteria tertentu</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- PPh 29 -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPh 29</strong>
                                <span data-i18n="tax.reg_pph29_title">Pajak Penghasilan Pasal 29</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pph29_detail">Kekurangan pembayaran pajak yang terutang dalam SPT Tahunan PPh, yaitu PPh terutang setelah dikurangi dengan kredit pajak (PPh Pasal 21, 22, 23, 24, dan angsuran PPh Pasal 25).</p>
                                
                                <h4><i class="fas fa-file-invoice"></i> <span data-i18n="tax.reporting_title">Pelaporan:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pph29_report1">Dibayar saat pelaporan SPT Tahunan PPh</li>
                                    <li data-i18n="tax.reg_pph29_report2">Batas waktu: 3 bulan setelah akhir tahun pajak untuk WP Orang Pribadi</li>
                                    <li data-i18n="tax.reg_pph29_report3">Batas waktu: 4 bulan setelah akhir tahun pajak untuk WP Badan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- PPN -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPN</strong>
                                <span data-i18n="tax.reg_ppn_title">Pajak Pertambahan Nilai</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_ppn_detail">Pajak yang dikenakan atas konsumsi Barang Kena Pajak (BKP) dan/atau Jasa Kena Pajak (JKP) di dalam Daerah Pabean.</p>
                                
                                <h4><i class="fas fa-shopping-cart"></i> <span data-i18n="tax.object_title">Objek Pajak:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_ppn_object1">Penyerahan BKP di dalam Daerah Pabean oleh Pengusaha</li>
                                    <li data-i18n="tax.reg_ppn_object2">Penyerahan JKP di dalam Daerah Pabean oleh Pengusaha</li>
                                    <li data-i18n="tax.reg_ppn_object3">Impor BKP</li>
                                    <li data-i18n="tax.reg_ppn_object4">Ekspor BKP/JKP oleh Pengusaha Kena Pajak</li>
                                </ul>

                                <h4><i class="fas fa-percent"></i> <span data-i18n="tax.rate_title">Tarif:</span></h4>
                                <p data-i18n="tax.reg_ppn_rate">11% (berlaku sejak 1 April 2022), dapat dinaikkan menjadi 12% dan maksimal 15%.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PPnBM -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PPnBM</strong>
                                <span data-i18n="tax.reg_ppnbm_title">Pajak Penjualan atas Barang Mewah</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_ppnbm_detail">Pajak yang dikenakan atas penyerahan atau impor Barang Kena Pajak yang tergolong mewah, baik yang dilakukan oleh produsen maupun diimpor.</p>
                                
                                <h4><i class="fas fa-gem"></i> <span data-i18n="tax.luxury_goods_title">Barang Mewah:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_ppnbm_goods1">Kendaraan bermotor dengan kapasitas isi silinder tertentu</li>
                                    <li data-i18n="tax.reg_ppnbm_goods2">Hunian mewah seperti apartemen, kondominium</li>
                                    <li data-i18n="tax.reg_ppnbm_goods3">Balon udara, pesawat, yacht, dan sejenisnya</li>
                                    <li data-i18n="tax.reg_ppnbm_goods4">Senjata api dan peluru, kecuali untuk keperluan negara</li>
                                </ul>

                                <h4><i class="fas fa-percent"></i> <span data-i18n="tax.rate_title">Tarif:</span></h4>
                                <p data-i18n="tax.reg_ppnbm_rate">Bervariasi antara 10% - 200% tergantung jenis barang mewah (berlaku di samping PPN).</p>
                            </div>
                        </div>
                    </div>

                    <!-- PBB -->
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <div class="accordion-title">
                                <strong>PBB</strong>
                                <span data-i18n="tax.reg_pbb_title">Pajak Bumi dan Bangunan</span>
                            </div>
                            <i class="fas fa-chevron-down accordion-icon"></i>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-detail">
                                <p data-i18n="tax.reg_pbb_detail">Pajak yang dikenakan atas kepemilikan atau pemanfaatan tanah dan/atau bangunan.</p>
                                
                                <h4><i class="fas fa-home"></i> <span data-i18n="tax.property_types_title">Jenis Properti:</span></h4>
                                <ul>
                                    <li data-i18n="tax.reg_pbb_type1">Sektor perkebunan, perhutanan, pertambangan</li>
                                    <li data-i18n="tax.reg_pbb_type2">Sektor perkotaan dan perdesaan</li>
                                    <li data-i18n="tax.reg_pbb_type3">Termasuk tanah kosong, bangunan, dan kompleks bangunan</li>
                                </ul>

                                <h4><i class="fas fa-calculator"></i> <span data-i18n="tax.calculation_title">Perhitungan:</span></h4>
                                <p data-i18n="tax.reg_pbb_calculation">PBB terutang = 0.5% x (NJOP - NJOPTKP). NJOP adalah Nilai Jual Objek Pajak, sedangkan NJOPTKP adalah Nilai Jual Objek Pajak Tidak Kena Pajak (minimal Rp 10 juta, ditetapkan per daerah).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Accordion functionality
                document.querySelectorAll('.accordion-header').forEach(header => {
                    header.addEventListener('click', function() {
                        const item = this.parentElement;
                        const content = this.nextElementSibling;
                        const isActive = this.classList.contains('active');
                        
                        // Close all other accordions
                        document.querySelectorAll('.accordion-header').forEach(h => {
                            h.classList.remove('active');
                            h.nextElementSibling.classList.remove('active');
                        });
                        
                        // Toggle current accordion
                        if (!isActive) {
                            this.classList.add('active');
                            content.classList.add('active');
                        }
                    });
                });
            </script>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>
