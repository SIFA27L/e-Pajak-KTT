/**
 * i18n (Internationalization) System
 * e-Pajak KTT Indonesia
 * 
 * Menangani translasi bahasa Indonesia dan English
 * untuk seluruh aplikasi
 */

// ========================================
// TRANSLATION DATA
// ========================================

const translations = {
    id: {
        // Header
        'header.greeting': 'Selamat Datang',
        'header.datetime': 'Tanggal & Waktu',
        'header.user': 'Pengguna',
        
        // Sidebar Menu
        'menu.dashboard': 'Dashboard',
        'menu.tax_types': 'Jenis Pajak',
        'menu.payment': 'Pembayaran',
        'menu.history': 'Riwayat',
        'menu.report': 'Laporan',
        'menu.admin_section': 'ADMINISTRATOR',
        'menu.users': 'Kelola Pengguna',
        'menu.account_section': 'AKUN',
        'menu.profile': 'Profil Saya',
        'menu.logout': 'Keluar',
        
        // User Dropdown
        'dropdown.language': 'Bahasa',
        'dropdown.edit_profile': 'Edit Profil',
        'dropdown.logout': 'Keluar',
        'dropdown.settings': 'Pengaturan',
        
        // Dashboard
        'dashboard.title': 'Dashboard',
        'dashboard.welcome': 'Selamat Datang di e-Pajak KTT',
        'dashboard.total_tax': 'Total Pajak',
        'dashboard.paid': 'Lunas',
        'dashboard.unpaid': 'Belum Lunas',
        'dashboard.pending': 'Menunggu',
        'dashboard.total_payment': 'Total Pembayaran',
        'dashboard.total_amount': 'Total Nominal',
        'dashboard.this_month': 'Bulan Ini',
        'dashboard.this_year': 'Tahun Ini',
        'dashboard.recent_payments': 'Pembayaran Terbaru',
        'dashboard.view_all': 'Lihat Semua',
        'dashboard.monthly_stats': 'Statistik Pembayaran Bulanan',
        'dashboard.tax_distribution': 'Distribusi Jenis Pajak',
        'dashboard.payment_no': 'No. Pembayaran',
        'dashboard.period': 'Periode',
        
        // Tax Types (Jenis Pajak)
        'tax.title': 'Jenis Pajak Indonesia',
        'tax.subtitle': 'Informasi lengkap tentang berbagai jenis pajak yang tersedia',
        'tax.info_title': 'Informasi Pajak Indonesia',
        'tax.info_1': 'Semua warga negara Indonesia yang memiliki penghasilan di atas PTKP (Penghasilan Tidak Kena Pajak) wajib membayar pajak',
        'tax.info_2': 'Pajak dapat dibayarkan secara online melalui sistem e-Billing Direktorat Jenderal Pajak',
        'tax.info_3': 'Pastikan NPWP Anda aktif dan valid sebelum melakukan pembayaran',
        'tax.info_4': 'Simpan bukti pembayaran pajak Anda sebagai arsip dan bukti pelaporan',
        'tax.as_regulated': 'Sesuai Ketentuan',
        'tax.pay_now': 'Bayar',
        
        // Tax Card Names and Descriptions
        'tax.pph_21_name': 'PPh Pasal 21',
        'tax.pph_21_desc': 'Pajak atas penghasilan berupa gaji, upah, honorarium, dan tunjangan',
        'tax.pph_22_name': 'PPh Pasal 22',
        'tax.pph_22_desc': 'Pajak yang dipungut atas kegiatan impor atau pembelian barang',
        'tax.pph_23_name': 'PPh Pasal 23',
        'tax.pph_23_desc': 'Pajak atas penghasilan dari modal, penyerahan jasa, atau hadiah',
        'tax.pph_25_name': 'PPh Pasal 25',
        'tax.pph_25_desc': 'Angsuran pajak penghasilan yang dibayar sendiri setiap bulan',
        'tax.pph_29_name': 'PPh Pasal 29',
        'tax.pph_29_desc': 'Pelunasan kekurangan pembayaran pajak pada akhir tahun',
        'tax.ppn_name': 'PPN (Pajak Pertambahan Nilai)',
        'tax.ppn_desc': 'Pajak atas konsumsi barang dan jasa kena pajak',
        'tax.ppnbm_name': 'PPnBM',
        'tax.ppnbm_desc': 'Pajak tambahan atas barang-barang mewah tertentu',
        'tax.pbb_name': 'PBB (Pajak Bumi dan Bangunan)',
        'tax.pbb_desc': 'Pajak atas kepemilikan atau pemanfaatan tanah dan bangunan',
        
        // Tax Regulations Accordion
        'tax.regulations_title': 'Ketentuan Umum Perpajakan',
        'tax.regulations_subtitle': 'Klik pada setiap jenis pajak untuk melihat informasi detail',
        
        // Common Section Titles
        'tax.subject_title': 'Subjek Pajak:',
        'tax.object_title': 'Objek Pajak:',
        'tax.calculation_title': 'Cara Perhitungan:',
        'tax.rate_title': 'Tarif:',
        'tax.services_title': 'Jenis Jasa:',
        'tax.payment_title': 'Pembayaran:',
        'tax.reporting_title': 'Pelaporan:',
        'tax.luxury_goods_title': 'Barang Mewah:',
        'tax.property_types_title': 'Jenis Properti:',
        
        // PPh 21 Details
        'tax.reg_pph21_title': 'Pajak Penghasilan Pasal 21',
        'tax.reg_pph21_detail': 'Pajak atas penghasilan berupa gaji, upah, honorarium, tunjangan, dan pembayaran lain yang diterima oleh pegawai, bukan pegawai, atau pensiunan.',
        'tax.reg_pph21_subject1': 'Pegawai tetap dan pegawai tidak tetap',
        'tax.reg_pph21_subject2': 'Penerima pensiun dan mantan pegawai',
        'tax.reg_pph21_subject3': 'Bukan pegawai yang menerima penghasilan',
        'tax.reg_pph21_calculation': 'Penghasilan bruto dikurangi dengan biaya jabatan (5%) dan iuran pensiun, kemudian dikurangi PTKP. Hasil tersebut dikalikan dengan tarif progresif PPh sesuai lapisan penghasilan.',
        
        // PPh 22 Details
        'tax.reg_pph22_title': 'Pajak Penghasilan Pasal 22',
        'tax.reg_pph22_detail': 'Pajak yang dipungut oleh bendahara pemerintah, badan tertentu, atau wajib pajak badan tertentu atas pembelian barang.',
        'tax.reg_pph22_object1': 'Impor barang',
        'tax.reg_pph22_object2': 'Pembelian barang oleh bendahara pemerintah',
        'tax.reg_pph22_object3': 'Penjualan hasil produksi industri tertentu',
        'tax.reg_pph22_rate': 'Bervariasi antara 0.25% - 7.5% tergantung jenis transaksi dan status wajib pajak (memiliki API atau tidak).',
        
        // PPh 23 Details
        'tax.reg_pph23_title': 'Pajak Penghasilan Pasal 23',
        'tax.reg_pph23_detail': 'Pajak yang dipotong atas penghasilan yang berasal dari modal, penyerahan jasa, atau penyelenggaraan kegiatan selain yang telah dipotong PPh Pasal 21.',
        'tax.reg_pph23_service1': 'Jasa teknik, manajemen, konstruksi, dan konsultan',
        'tax.reg_pph23_service2': 'Sewa dan penghasilan lain sehubungan dengan penggunaan harta',
        'tax.reg_pph23_service3': 'Dividen, bunga, royalti, dan hadiah',
        'tax.reg_pph23_rate': '2% untuk jasa dan 15% untuk dividen, bunga, royalti, dan hadiah (kecuali yang dikecualikan).',
        
        // PPh 25 Details
        'tax.reg_pph25_title': 'Pajak Penghasilan Pasal 25',
        'tax.reg_pph25_detail': 'Angsuran pajak yang harus dibayar sendiri oleh Wajib Pajak setiap bulan dalam tahun pajak berjalan.',
        'tax.reg_pph25_payment1': 'Dibayar setiap bulan paling lambat tanggal 15 bulan berikutnya',
        'tax.reg_pph25_payment2': 'Besarnya dihitung dari PPh terutang tahun lalu dikurangi kredit pajak, dibagi 12',
        'tax.reg_pph25_payment3': 'Dapat menggunakan tarif 0.5% dari omzet untuk WP kriteria tertentu',
        
        // PPh 29 Details
        'tax.reg_pph29_title': 'Pajak Penghasilan Pasal 29',
        'tax.reg_pph29_detail': 'Kekurangan pembayaran pajak yang terutang dalam SPT Tahunan PPh, yaitu PPh terutang setelah dikurangi dengan kredit pajak (PPh Pasal 21, 22, 23, 24, dan angsuran PPh Pasal 25).',
        'tax.reg_pph29_report1': 'Dibayar saat pelaporan SPT Tahunan PPh',
        'tax.reg_pph29_report2': 'Batas waktu: 3 bulan setelah akhir tahun pajak untuk WP Orang Pribadi',
        'tax.reg_pph29_report3': 'Batas waktu: 4 bulan setelah akhir tahun pajak untuk WP Badan',
        
        // PPN Details
        'tax.reg_ppn_title': 'Pajak Pertambahan Nilai',
        'tax.reg_ppn_detail': 'Pajak yang dikenakan atas konsumsi Barang Kena Pajak (BKP) dan/atau Jasa Kena Pajak (JKP) di dalam Daerah Pabean.',
        'tax.reg_ppn_object1': 'Penyerahan BKP di dalam Daerah Pabean oleh Pengusaha',
        'tax.reg_ppn_object2': 'Penyerahan JKP di dalam Daerah Pabean oleh Pengusaha',
        'tax.reg_ppn_object3': 'Impor BKP',
        'tax.reg_ppn_object4': 'Ekspor BKP/JKP oleh Pengusaha Kena Pajak',
        'tax.reg_ppn_rate': '11% (berlaku sejak 1 April 2022), dapat dinaikkan menjadi 12% dan maksimal 15%.',
        
        // PPnBM Details
        'tax.reg_ppnbm_title': 'Pajak Penjualan atas Barang Mewah',
        'tax.reg_ppnbm_detail': 'Pajak yang dikenakan atas penyerahan atau impor Barang Kena Pajak yang tergolong mewah, baik yang dilakukan oleh produsen maupun diimpor.',
        'tax.reg_ppnbm_goods1': 'Kendaraan bermotor dengan kapasitas isi silinder tertentu',
        'tax.reg_ppnbm_goods2': 'Hunian mewah seperti apartemen, kondominium',
        'tax.reg_ppnbm_goods3': 'Balon udara, pesawat, yacht, dan sejenisnya',
        'tax.reg_ppnbm_goods4': 'Senjata api dan peluru, kecuali untuk keperluan negara',
        'tax.reg_ppnbm_rate': 'Bervariasi antara 10% - 200% tergantung jenis barang mewah (berlaku di samping PPN).',
        
        // PBB Details
        'tax.reg_pbb_title': 'Pajak Bumi dan Bangunan',
        'tax.reg_pbb_detail': 'Pajak yang dikenakan atas kepemilikan atau pemanfaatan tanah dan/atau bangunan.',
        'tax.reg_pbb_type1': 'Sektor perkebunan, perhutanan, pertambangan',
        'tax.reg_pbb_type2': 'Sektor perkotaan dan perdesaan',
        'tax.reg_pbb_type3': 'Termasuk tanah kosong, bangunan, dan kompleks bangunan',
        'tax.reg_pbb_calculation': 'PBB terutang = 0.5% x (NJOP - NJOPTKP). NJOP adalah Nilai Jual Objek Pajak, sedangkan NJOPTKP adalah Nilai Jual Objek Pajak Tidak Kena Pajak (minimal Rp 10 juta, ditetapkan per daerah).',
        'tax.pbb': 'PBB (Pajak Bumi & Bangunan)',
        'tax.pbb_desc': 'Pajak atas tanah dan bangunan',
        'tax.vehicle': 'Pajak Kendaraan Bermotor',
        'tax.vehicle_desc': 'Pajak kendaraan bermotor tahunan',
        'tax.income': 'Pajak Penghasilan',
        'tax.income_desc': 'Pajak penghasilan pribadi/badan',
        'tax.business': 'Pajak Usaha',
        'tax.business_desc': 'Pajak untuk kegiatan usaha',
        'tax.pay_now': 'Bayar',
        'tax.details': 'Detail',
        
        // Payment (Pembayaran)
        'payment.title': 'Pembayaran Pajak',
        'payment.subtitle': 'Lakukan pembayaran pajak Anda dengan mudah dan aman',
        'payment.info': 'Informasi',
        'payment.info_text': 'Pastikan semua data yang Anda masukkan sudah benar. Pembayaran yang sudah diproses tidak dapat dibatalkan.',
        'payment.tax_data': 'Data Pajak',
        'payment.select_tax': 'Jenis Pajak',
        'payment.choose_tax': 'Pilih Jenis Pajak',
        'payment.npwp_placeholder': 'NPWP akan terisi otomatis atau input manual',
        'payment.tax_year': 'Tahun Pajak',
        'payment.tax_period': 'Masa Pajak',
        'payment.choose_period': 'Pilih Masa Pajak',
        'payment.tax_amount': 'Jumlah Pajak',
        'payment.tax_amount_label': 'Jumlah Pajak (Rp)',
        'payment.penalty': 'Denda (Rp)',
        'payment.enter_amount': 'Masukkan jumlah',
        'payment.payment_method': 'Metode Pembayaran',
        'payment.payment_method_title': 'Metode Pembayaran',
        'payment.choose_method': 'Pilih Metode Pembayaran',
        'payment.select_method': 'Pilih Metode',
        'payment.bank_transfer': 'Transfer Bank',
        'payment.virtual_account': 'Virtual Account',
        'payment.ewallet': 'E-Wallet',
        'payment.ewallet_detail': 'E-Wallet (OVO, GoPay, Dana)',
        'payment.credit_card': 'Kartu Kredit',
        'payment.notes': 'Catatan',
        'payment.notes_label': 'Keterangan (Opsional)',
        'payment.notes_placeholder': 'Catatan tambahan (opsional)',
        'payment.optional_notes': 'Catatan tambahan (opsional)',
        'payment.total_payment': 'Total Pembayaran:',
        'payment.process_payment': 'Proses Pembayaran',
        'payment.submit': 'Bayar Sekarang',
        'payment.cancel': 'Batal',
        'payment.processing': 'Memproses...',
        'payment.for_user': 'Pembayaran untuk',
        'payment.select_user': 'Pilih Pengguna',
        'payment.choose_user': 'Pilih Pengguna',
        'payment.or_manual': 'Atau Input Manual NPWP',
        'payment.manual_npwp': 'Input NPWP Manual',
        'payment.enter_npwp': 'Masukkan NPWP',
        
        // History (Riwayat)
        'history.title': 'Riwayat Pembayaran',
        'history.subtitle': 'Lihat semua riwayat pembayaran pajak Anda',
        'history.search_placeholder': 'Cari nomor pembayaran, NPWP...',
        'history.all_status': 'Semua Status',
        'history.status_success': 'Berhasil',
        'history.status_pending': 'Pending',
        'history.status_failed': 'Gagal',
        'history.status_cancelled': 'Dibatalkan',
        'history.new_payment': 'Pembayaran Baru',
        'history.payment_no': 'No. Pembayaran',
        'history.taxpayer_name': 'Nama Wajib Pajak',
        'history.tax_type': 'Jenis Pajak',
        'history.period': 'Periode',
        'history.total': 'Total',
        'history.method': 'Metode',
        'history.status': 'Status',
        'history.date': 'Tanggal',
        'history.action': 'Aksi',
        'history.no_history_title': 'Belum Ada Riwayat Pembayaran',
        'history.no_history_text': 'Anda belum melakukan pembayaran pajak. Klik tombol di bawah untuk melakukan pembayaran.',
        'history.pay_now': 'Bayar Pajak Sekarang',
        'history.payment_detail': 'Detail Pembayaran',
        'history.no_data': 'Belum ada data pembayaran',
        'history.amount': 'Jumlah',
        'history.view_detail': 'Lihat Detail',
        'history.download_receipt': 'Unduh Bukti',
        'history.filter_all': 'Semua',
        'history.filter_paid': 'Lunas',
        'history.filter_unpaid': 'Belum Lunas',
        'history.filter_pending': 'Menunggu',
        
        // Report (Laporan)
        'report.title': 'Laporan Pembayaran Pajak',
        'report.subtitle': 'Generate laporan pembayaran pajak Anda dalam berbagai format',
        'report.page_title': 'Laporan - KTT Indonesia',
        'report.statistics_summary': 'Ringkasan Statistik',
        'report.total_transactions': 'Total Transaksi',
        'report.total_payments': 'Total Pembayaran',
        'report.average_payment': 'Rata-rata Pembayaran',
        'report.highest_payment': 'Pembayaran Tertinggi',
        'report.monthly_title': 'Laporan Bulanan',
        'report.monthly_desc': 'Generate laporan pembayaran pajak per bulan',
        'report.yearly_title': 'Laporan Tahunan',
        'report.yearly_desc': 'Generate laporan pembayaran pajak per tahun',
        'report.custom_title': 'Laporan Custom',
        'report.custom_desc': 'Generate laporan dengan periode custom',
        'report.month': 'Bulan',
        'report.year': 'Tahun',
        'report.start_date': 'Tanggal Mulai',
        'report.end_date': 'Tanggal Akhir',
        'report.generate_pdf': 'Generate PDF',
        'report.generate': 'Buat Laporan',
        'report.period': 'Periode',
        'report.format': 'Format',
        'report.download': 'Unduh Laporan',
        'report.monthly': 'Bulanan',
        'report.yearly': 'Tahunan',
        'report.custom': 'Kustom',
        
        // Profile (Profil)
        'profile.title': 'Profil Saya',
        'profile.subtitle': 'Kelola informasi profil dan keamanan akun Anda',
        'profile.personal_info': 'Informasi Profil',
        'profile.security': 'Keamanan',
        'profile.member_since': 'Bergabung sejak',
        'profile.username': 'Username',
        'profile.full_name': 'Nama Lengkap',
        'profile.email': 'Email',
        'profile.phone': 'No. Telepon',
        'profile.address': 'Alamat',
        'profile.id_number': 'NIK',
        'profile.tax_number': 'NPWP',
        'profile.change_password': 'Ubah Password',
        'profile.change_password_btn': 'Ubah Password',
        'profile.old_password': 'Password Lama',
        'profile.new_password': 'Password Baru',
        'profile.confirm_password': 'Konfirmasi Password Baru',
        'profile.save': 'Simpan Perubahan',
        'profile.cancel': 'Batal',
        
        // Users Management (Kelola Pengguna)
        'users.title': 'Kelola Pengguna',
        'users.total_users': 'Total User',
        'users.administrator': 'Administrator',
        'users.regular_user': 'User Biasa',
        'users.active': 'Aktif',
        'users.inactive': 'Nonaktif',
        'users.all': 'Semua',
        'users.admin': 'Admin',
        'users.user': 'User',
        'users.phone': 'Telepon',
        'users.joined': 'Bergabung',
        'users.last_login': 'Login Terakhir',
        'users.search_placeholder': 'Cari user berdasarkan nama, email, atau NPWP...',
        'users.add_new': 'Tambah Pengguna',
        'users.search': 'Cari pengguna...',
        'users.name': 'Nama',
        'users.email': 'Email',
        'users.role': 'Role',
        'users.status': 'Status',
        'users.action': 'Aksi',
        'users.edit': 'Edit',
        'users.delete': 'Hapus',
        
        // Months
        'month.january': 'Januari',
        'month.february': 'Februari',
        'month.march': 'Maret',
        'month.april': 'April',
        'month.may': 'Mei',
        'month.june': 'Juni',
        'month.july': 'Juli',
        'month.august': 'Agustus',
        'month.september': 'September',
        'month.october': 'Oktober',
        'month.november': 'November',
        'month.december': 'Desember',
        
        // Status
        'status.success': 'Berhasil',
        'status.paid': 'Lunas',
        'status.unpaid': 'Belum Lunas',
        'status.pending': 'Menunggu',
        'status.cancelled': 'Dibatalkan',
        'status.processing': 'Diproses',
        'status.active': 'Aktif',
        'status.inactive': 'Nonaktif',
        
        // Buttons
        'btn.save': 'Simpan',
        'btn.cancel': 'Batal',
        'btn.edit': 'Edit',
        'btn.delete': 'Hapus',
        'btn.submit': 'Kirim',
        'btn.search': 'Cari',
        'btn.filter': 'Filter',
        'btn.download': 'Unduh',
        'btn.print': 'Cetak',
        'btn.back': 'Kembali',
        'btn.next': 'Selanjutnya',
        'btn.previous': 'Sebelumnya',
        'btn.close': 'Tutup',
        'btn.confirm': 'Konfirmasi',
        
        // Messages
        'msg.success': 'Operasi berhasil',
        'msg.error': 'Terjadi kesalahan',
        'msg.loading': 'Memuat...',
        'msg.no_data': 'Tidak ada data',
        'msg.confirm_delete': 'Apakah Anda yakin ingin menghapus?',
        'msg.confirm_logout': 'Apakah Anda yakin ingin keluar?',
        'msg.payment_success': 'Pembayaran berhasil',
        'msg.payment_failed': 'Pembayaran gagal',
        'msg.language_changed': 'Bahasa diubah ke Indonesia',
        
        // Date & Time
        'time.monday': 'Senin',
        'time.tuesday': 'Selasa',
        'time.wednesday': 'Rabu',
        'time.thursday': 'Kamis',
        'time.friday': 'Jumat',
        'time.saturday': 'Sabtu',
        'time.sunday': 'Minggu',
        'time.january': 'Januari',
        'time.february': 'Februari',
        'time.march': 'Maret',
        'time.april': 'April',
        'time.may': 'Mei',
        'time.june': 'Juni',
        'time.july': 'Juli',
        'time.august': 'Agustus',
        'time.september': 'September',
        'time.october': 'Oktober',
        'time.november': 'November',
        'time.december': 'Desember',
        
        // Footer
        'footer.tagline': 'Sistem Pembayaran Pajak Online yang Aman dan Terpercaya',
        'footer.office_address': 'Alamat Kantor',
        'footer.contact_us': 'Hubungi Kami',
        'footer.operational_hours': 'Jam Operasional',
        'footer.weekdays': 'Senin - Jumat',
        'footer.saturday': 'Sabtu',
        'footer.sunday': 'Minggu & Libur',
        'footer.closed': 'Tutup',
        'footer.rights': 'All Rights Reserved',
        'footer.developed': 'Developed with',
        'footer.by_team': 'by KTT Indonesia IT Team',
        'footer.copyright': '© 2025 e-Pajak KTT. Semua hak dilindungi.',
        'footer.version': 'Versi',
        'footer.contact': 'Kontak',
        'footer.help': 'Bantuan',
        'footer.terms': 'Syarat & Ketentuan',
        'footer.privacy': 'Kebijakan Privasi',
    },
    
    en: {
        // Header
        'header.greeting': 'Welcome',
        'header.datetime': 'Date & Time',
        'header.user': 'User',
        
        // Sidebar Menu
        'menu.dashboard': 'Dashboard',
        'menu.tax_types': 'Tax Types',
        'menu.payment': 'Payment',
        'menu.history': 'History',
        'menu.report': 'Report',
        'menu.admin_section': 'ADMINISTRATOR',
        'menu.users': 'User Management',
        'menu.account_section': 'ACCOUNT',
        'menu.profile': 'My Profile',
        'menu.logout': 'Logout',
        
        // User Dropdown
        'dropdown.language': 'Language',
        'dropdown.edit_profile': 'Edit Profile',
        'dropdown.logout': 'Logout',
        'dropdown.settings': 'Settings',
        
        // Dashboard
        'dashboard.title': 'Dashboard',
        'dashboard.welcome': 'Welcome to e-Pajak KTT',
        'dashboard.total_tax': 'Total Tax',
        'dashboard.paid': 'Paid',
        'dashboard.unpaid': 'Unpaid',
        'dashboard.pending': 'Pending',
        'dashboard.total_payment': 'Total Payment',
        'dashboard.total_amount': 'Total Amount',
        'dashboard.this_month': 'This Month',
        'dashboard.this_year': 'This Year',
        'dashboard.recent_payments': 'Recent Payments',
        'dashboard.view_all': 'View All',
        'dashboard.monthly_stats': 'Monthly Payment Statistics',
        'dashboard.tax_distribution': 'Tax Type Distribution',
        'dashboard.payment_no': 'Payment No.',
        'dashboard.period': 'Period',
        
        // Tax Types
        'tax.title': 'Indonesian Tax Types',
        'tax.subtitle': 'Complete information about various available tax types',
        'tax.info_title': 'Indonesian Tax Information',
        'tax.info_1': 'All Indonesian citizens who have income above PTKP (Non-Taxable Income) are required to pay taxes',
        'tax.info_2': 'Taxes can be paid online through the Directorate General of Taxes e-Billing system',
        'tax.info_3': 'Make sure your NPWP is active and valid before making payment',
        'tax.info_4': 'Keep your tax payment receipt as an archive and proof of reporting',
        'tax.as_regulated': 'As Regulated',
        'tax.pay_now': 'Pay',
        
        // Tax Card Names and Descriptions
        'tax.pph_21_name': 'Income Tax Article 21',
        'tax.pph_21_desc': 'Tax on income in the form of salaries, wages, honorariums, and allowances',
        'tax.pph_22_name': 'Income Tax Article 22',
        'tax.pph_22_desc': 'Tax collected on import activities or purchase of goods',
        'tax.pph_23_name': 'Income Tax Article 23',
        'tax.pph_23_desc': 'Tax on income from capital, service delivery, or prizes',
        'tax.pph_25_name': 'Income Tax Article 25',
        'tax.pph_25_desc': 'Monthly income tax installment paid by taxpayer',
        'tax.pph_29_name': 'Income Tax Article 29',
        'tax.pph_29_desc': 'Settlement of tax payment shortfall at year end',
        'tax.ppn_name': 'VAT (Value Added Tax)',
        'tax.ppn_desc': 'Tax on consumption of taxable goods and services',
        'tax.ppnbm_name': 'Luxury Goods Sales Tax',
        'tax.ppnbm_desc': 'Additional tax on certain luxury goods',
        'tax.pbb_name': 'Property Tax',
        'tax.pbb_desc': 'Tax on ownership or utilization of land and buildings',
        
        // Tax Regulations Accordion
        'tax.regulations_title': 'General Tax Regulations',
        'tax.regulations_subtitle': 'Click on each tax type to view detailed information',
        
        // Common Section Titles
        'tax.subject_title': 'Tax Subject:',
        'tax.object_title': 'Tax Object:',
        'tax.calculation_title': 'Calculation Method:',
        'tax.rate_title': 'Rate:',
        'tax.services_title': 'Service Types:',
        'tax.payment_title': 'Payment:',
        'tax.reporting_title': 'Reporting:',
        'tax.luxury_goods_title': 'Luxury Goods:',
        'tax.property_types_title': 'Property Types:',
        
        // PPh 21 Details
        'tax.reg_pph21_title': 'Income Tax Article 21',
        'tax.reg_pph21_detail': 'Tax on income in the form of salaries, wages, honorariums, allowances, and other payments received by employees, non-employees, or pensioners.',
        'tax.reg_pph21_subject1': 'Permanent and non-permanent employees',
        'tax.reg_pph21_subject2': 'Pension recipients and former employees',
        'tax.reg_pph21_subject3': 'Non-employees receiving income',
        'tax.reg_pph21_calculation': 'Gross income is reduced by position costs (5%) and pension contributions, then reduced by PTKP. The result is multiplied by the progressive income tax rate according to income layers.',
        
        // PPh 22 Details
        'tax.reg_pph22_title': 'Income Tax Article 22',
        'tax.reg_pph22_detail': 'Tax collected by government treasurers, certain entities, or certain corporate taxpayers on the purchase of goods.',
        'tax.reg_pph22_object1': 'Imported goods',
        'tax.reg_pph22_object2': 'Purchase of goods by government treasurers',
        'tax.reg_pph22_object3': 'Sale of certain industrial production results',
        'tax.reg_pph22_rate': 'Varies between 0.25% - 7.5% depending on transaction type and taxpayer status (has API or not).',
        
        // PPh 23 Details
        'tax.reg_pph23_title': 'Income Tax Article 23',
        'tax.reg_pph23_detail': 'Tax withheld on income derived from capital, delivery of services, or conducting activities other than those already withheld under Article 21.',
        'tax.reg_pph23_service1': 'Technical, management, construction, and consulting services',
        'tax.reg_pph23_service2': 'Rent and other income related to property use',
        'tax.reg_pph23_service3': 'Dividends, interest, royalties, and prizes',
        'tax.reg_pph23_rate': '2% for services and 15% for dividends, interest, royalties, and prizes (except those exempted).',
        
        // PPh 25 Details
        'tax.reg_pph25_title': 'Income Tax Article 25',
        'tax.reg_pph25_detail': 'Tax installment that must be paid by the taxpayer every month during the current tax year.',
        'tax.reg_pph25_payment1': 'Paid monthly no later than the 15th of the following month',
        'tax.reg_pph25_payment2': 'Amount calculated from last year\'s tax payable minus tax credits, divided by 12',
        'tax.reg_pph25_payment3': 'Can use a rate of 0.5% of turnover for taxpayers with certain criteria',
        
        // PPh 29 Details
        'tax.reg_pph29_title': 'Income Tax Article 29',
        'tax.reg_pph29_detail': 'Tax payment shortfall owed in the Annual Income Tax Return, namely tax payable after being reduced by tax credits (Income Tax Articles 21, 22, 23, 24, and installments of Income Tax Article 25).',
        'tax.reg_pph29_report1': 'Paid when filing Annual Income Tax Return',
        'tax.reg_pph29_report2': 'Deadline: 3 months after the end of the tax year for Individual Taxpayers',
        'tax.reg_pph29_report3': 'Deadline: 4 months after the end of the tax year for Corporate Taxpayers',
        
        // PPN Details
        'tax.reg_ppn_title': 'Value Added Tax',
        'tax.reg_ppn_detail': 'Tax imposed on the consumption of Taxable Goods (BKP) and/or Taxable Services (JKP) within the Customs Area.',
        'tax.reg_ppn_object1': 'Delivery of BKP within the Customs Area by Entrepreneurs',
        'tax.reg_ppn_object2': 'Delivery of JKP within the Customs Area by Entrepreneurs',
        'tax.reg_ppn_object3': 'Import of BKP',
        'tax.reg_ppn_object4': 'Export of BKP/JKP by Taxable Entrepreneurs',
        'tax.reg_ppn_rate': '11% (effective April 1, 2022), can be increased to 12% and maximum 15%.',
        
        // PPnBM Details
        'tax.reg_ppnbm_title': 'Luxury Goods Sales Tax',
        'tax.reg_ppnbm_detail': 'Tax imposed on the delivery or import of Taxable Goods classified as luxury, both by producers and importers.',
        'tax.reg_ppnbm_goods1': 'Motor vehicles with certain cylinder capacity',
        'tax.reg_ppnbm_goods2': 'Luxury residences such as apartments, condominiums',
        'tax.reg_ppnbm_goods3': 'Hot air balloons, aircraft, yachts, and the like',
        'tax.reg_ppnbm_goods4': 'Firearms and bullets, except for state purposes',
        'tax.reg_ppnbm_rate': 'Varies between 10% - 200% depending on the type of luxury goods (applies in addition to VAT).',
        
        // PBB Details
        'tax.reg_pbb_title': 'Land and Building Tax',
        'tax.reg_pbb_detail': 'Tax imposed on the ownership or utilization of land and/or buildings.',
        'tax.reg_pbb_type1': 'Plantation, forestry, mining sectors',
        'tax.reg_pbb_type2': 'Urban and rural sectors',
        'tax.reg_pbb_type3': 'Including vacant land, buildings, and building complexes',
        'tax.reg_pbb_calculation': 'Property tax payable = 0.5% x (NJOP - NJOPTKP). NJOP is the Sales Value of Tax Object, while NJOPTKP is the Sales Value of Non-Taxable Tax Object (minimum IDR 10 million, determined per region).',
        'tax.details': 'Details',
        
        // Payment
        'payment.title': 'Tax Payment',
        'payment.subtitle': 'Pay your taxes easily and securely',
        'payment.info': 'Information',
        'payment.info_text': 'Make sure all the data you enter is correct. Processed payments cannot be cancelled.',
        'payment.tax_data': 'Tax Data',
        'payment.select_tax': 'Tax Type',
        'payment.choose_tax': 'Select Tax Type',
        'payment.npwp_placeholder': 'NPWP will be filled automatically or manual input',
        'payment.tax_year': 'Tax Year',
        'payment.tax_period': 'Tax Period',
        'payment.choose_period': 'Select Tax Period',
        'payment.tax_amount': 'Tax Amount',
        'payment.tax_amount_label': 'Tax Amount (Rp)',
        'payment.penalty': 'Penalty (Rp)',
        'payment.enter_amount': 'Enter amount',
        'payment.payment_method': 'Payment Method',
        'payment.payment_method_title': 'Payment Method',
        'payment.choose_method': 'Select Payment Method',
        'payment.select_method': 'Select Method',
        'payment.bank_transfer': 'Bank Transfer',
        'payment.virtual_account': 'Virtual Account',
        'payment.ewallet': 'E-Wallet',
        'payment.ewallet_detail': 'E-Wallet (OVO, GoPay, Dana)',
        'payment.credit_card': 'Credit Card',
        'payment.notes': 'Notes',
        'payment.notes_label': 'Notes (Optional)',
        'payment.notes_placeholder': 'Additional notes (optional)',
        'payment.optional_notes': 'Additional notes (optional)',
        'payment.total_payment': 'Total Payment:',
        'payment.process_payment': 'Process Payment',
        'payment.submit': 'Pay Now',
        'payment.cancel': 'Cancel',
        'payment.processing': 'Processing...',
        'payment.for_user': 'Payment for',
        'payment.select_user': 'Select User',
        'payment.choose_user': 'Select User',
        'payment.or_manual': 'Or Manual NPWP Input',
        'payment.manual_npwp': 'Manual NPWP Input',
        'payment.enter_npwp': 'Enter NPWP',
        
        // Months
        'month.january': 'January',
        'month.february': 'February',
        'month.march': 'March',
        'month.april': 'April',
        'month.may': 'May',
        'month.june': 'June',
        'month.july': 'July',
        'month.august': 'August',
        'month.september': 'September',
        'month.october': 'October',
        'month.november': 'November',
        'month.december': 'December',
        
        // History
        'history.title': 'Payment History',
        'history.subtitle': 'View all your tax payment history',
        'history.search_placeholder': 'Search payment number, Tax ID...',
        'history.all_status': 'All Status',
        'history.status_success': 'Success',
        'history.status_pending': 'Pending',
        'history.status_failed': 'Failed',
        'history.status_cancelled': 'Cancelled',
        'history.new_payment': 'New Payment',
        'history.payment_no': 'Payment No.',
        'history.taxpayer_name': 'Taxpayer Name',
        'history.tax_type': 'Tax Type',
        'history.period': 'Period',
        'history.total': 'Total',
        'history.method': 'Method',
        'history.status': 'Status',
        'history.date': 'Date',
        'history.action': 'Action',
        'history.no_history_title': 'No Payment History',
        'history.no_history_text': 'You have not made any tax payments yet. Click the button below to make a payment.',
        'history.pay_now': 'Pay Tax Now',
        'history.payment_detail': 'Payment Detail',
        'history.no_data': 'No payment data yet',
        'history.amount': 'Amount',
        'history.view_detail': 'View Detail',
        'history.download_receipt': 'Download Receipt',
        'history.filter_all': 'All',
        'history.filter_paid': 'Paid',
        'history.filter_unpaid': 'Unpaid',
        'history.filter_pending': 'Pending',
        
        // Report
        'report.title': 'Tax Payment Report',
        'report.subtitle': 'Generate your tax payment reports in various formats',
        'report.page_title': 'Report - KTT Indonesia',
        'report.statistics_summary': 'Statistics Summary',
        'report.total_transactions': 'Total Transactions',
        'report.total_payments': 'Total Payments',
        'report.average_payment': 'Average Payment',
        'report.highest_payment': 'Highest Payment',
        'report.monthly_title': 'Monthly Report',
        'report.monthly_desc': 'Generate monthly tax payment report',
        'report.yearly_title': 'Yearly Report',
        'report.yearly_desc': 'Generate yearly tax payment report',
        'report.custom_title': 'Custom Report',
        'report.custom_desc': 'Generate report with custom period',
        'report.month': 'Month',
        'report.year': 'Year',
        'report.start_date': 'Start Date',
        'report.end_date': 'End Date',
        'report.generate_pdf': 'Generate PDF',
        'report.generate': 'Generate Report',
        'report.period': 'Period',
        'report.format': 'Format',
        'report.download': 'Download Report',
        'report.monthly': 'Monthly',
        'report.yearly': 'Yearly',
        'report.custom': 'Custom',
        
        // Profile
        'profile.title': 'My Profile',
        'profile.subtitle': 'Manage your profile information and account security',
        'profile.personal_info': 'Profile Information',
        'profile.security': 'Security',
        'profile.member_since': 'Member since',
        'profile.username': 'Username',
        'profile.full_name': 'Full Name',
        'profile.email': 'Email',
        'profile.phone': 'Phone Number',
        'profile.address': 'Address',
        'profile.id_number': 'ID Number',
        'profile.tax_number': 'Tax Number',
        'profile.change_password': 'Change Password',
        'profile.change_password_btn': 'Change Password',
        'profile.old_password': 'Old Password',
        'profile.new_password': 'New Password',
        'profile.confirm_password': 'Confirm New Password',
        'profile.save': 'Save Changes',
        'profile.cancel': 'Cancel',
        
        // Users Management
        'users.title': 'User Management',
        'users.total_users': 'Total Users',
        'users.administrator': 'Administrator',
        'users.regular_user': 'Regular User',
        'users.active': 'Active',
        'users.inactive': 'Inactive',
        'users.all': 'All',
        'users.admin': 'Admin',
        'users.user': 'User',
        'users.phone': 'Phone',
        'users.joined': 'Joined',
        'users.last_login': 'Last Login',
        'users.search_placeholder': 'Search user by name, email, or Tax ID...',
        'users.add_new': 'Add User',
        'users.search': 'Search users...',
        'users.name': 'Name',
        'users.email': 'Email',
        'users.role': 'Role',
        'users.status': 'Status',
        'users.action': 'Action',
        'users.edit': 'Edit',
        'users.delete': 'Delete',
        
        // Status
        'status.success': 'Success',
        'status.paid': 'Paid',
        'status.unpaid': 'Unpaid',
        'status.pending': 'Pending',
        'status.cancelled': 'Cancelled',
        'status.processing': 'Processing',
        'status.active': 'Active',
        'status.inactive': 'Inactive',
        
        // Buttons
        'btn.save': 'Save',
        'btn.cancel': 'Cancel',
        'btn.edit': 'Edit',
        'btn.delete': 'Delete',
        'btn.submit': 'Submit',
        'btn.search': 'Search',
        'btn.filter': 'Filter',
        'btn.download': 'Download',
        'btn.print': 'Print',
        'btn.back': 'Back',
        'btn.next': 'Next',
        'btn.previous': 'Previous',
        'btn.close': 'Close',
        'btn.confirm': 'Confirm',
        
        // Messages
        'msg.success': 'Operation successful',
        'msg.error': 'An error occurred',
        'msg.loading': 'Loading...',
        'msg.no_data': 'No data available',
        'msg.confirm_delete': 'Are you sure you want to delete?',
        'msg.confirm_logout': 'Are you sure you want to logout?',
        'msg.payment_success': 'Payment successful',
        'msg.payment_failed': 'Payment failed',
        'msg.language_changed': 'Language changed to English',
        
        // Date & Time
        'time.monday': 'Monday',
        'time.tuesday': 'Tuesday',
        'time.wednesday': 'Wednesday',
        'time.thursday': 'Thursday',
        'time.friday': 'Friday',
        'time.saturday': 'Saturday',
        'time.sunday': 'Sunday',
        'time.january': 'January',
        'time.february': 'February',
        'time.march': 'March',
        'time.april': 'April',
        'time.may': 'May',
        'time.june': 'June',
        'time.july': 'July',
        'time.august': 'August',
        'time.september': 'September',
        'time.october': 'October',
        'time.november': 'November',
        'time.december': 'December',
        
        // Footer
        'footer.tagline': 'Secure and Trusted Online Tax Payment System',
        'footer.office_address': 'Office Address',
        'footer.contact_us': 'Contact Us',
        'footer.operational_hours': 'Operational Hours',
        'footer.weekdays': 'Monday - Friday',
        'footer.saturday': 'Saturday',
        'footer.sunday': 'Sunday & Holidays',
        'footer.closed': 'Closed',
        'footer.rights': 'All Rights Reserved',
        'footer.developed': 'Developed with',
        'footer.by_team': 'by KTT Indonesia IT Team',
        'footer.copyright': '© 2025 e-Pajak KTT. All rights reserved.',
        'footer.version': 'Version',
        'footer.contact': 'Contact',
        'footer.help': 'Help',
        'footer.terms': 'Terms & Conditions',
        'footer.privacy': 'Privacy Policy',
    }
};

// ========================================
// i18n CLASS
// ========================================

class I18n {
    constructor() {
        this.currentLang = this.getStoredLanguage();
        this.translations = translations;
    }

    /**
     * Get stored language from localStorage
     */
    getStoredLanguage() {
        return localStorage.getItem('language') || 'id';
    }

    /**
     * Set language and save to localStorage
     */
    setLanguage(lang) {
        if (lang !== 'id' && lang !== 'en') {
            console.error('Invalid language code. Use "id" or "en"');
            return;
        }
        
        this.currentLang = lang;
        localStorage.setItem('language', lang);
        this.updatePageContent();
        this.triggerLanguageChangeEvent();
    }

    /**
     * Get current language
     */
    getCurrentLanguage() {
        return this.currentLang;
    }

    /**
     * Translate a key
     */
    t(key, fallback = null) {
        const lang = this.currentLang;
        
        if (this.translations[lang] && this.translations[lang][key]) {
            return this.translations[lang][key];
        }
        
        // Fallback to Indonesian if English translation not found
        if (lang === 'en' && this.translations['id'][key]) {
            return this.translations['id'][key];
        }
        
        // Return fallback or key itself
        return fallback || key;
    }

    /**
     * Update all page content with data-i18n attribute
     */
    updatePageContent() {
        // Update elements with data-i18n attribute
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            const translation = this.t(key);
            
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = translation;
            } else {
                // Check if element has direct icon children
                const hasDirectIcon = Array.from(element.childNodes).some(
                    node => node.nodeType === 1 && node.tagName === 'I'
                );
                
                if (hasDirectIcon) {
                    // Preserve all icon elements
                    const icons = Array.from(element.children).filter(child => child.tagName === 'I');
                    element.innerHTML = '';
                    icons.forEach(icon => element.appendChild(icon));
                    element.appendChild(document.createTextNode(' ' + translation));
                } else {
                    element.textContent = translation;
                }
            }
        });

        // Update elements with data-i18n-placeholder attribute
        document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
            const key = element.getAttribute('data-i18n-placeholder');
            element.placeholder = this.t(key);
        });

        // Update elements with data-i18n-title attribute
        document.querySelectorAll('[data-i18n-title]').forEach(element => {
            const key = element.getAttribute('data-i18n-title');
            element.title = this.t(key);
        });

        // Update elements with data-i18n-value attribute
        document.querySelectorAll('[data-i18n-value]').forEach(element => {
            const key = element.getAttribute('data-i18n-value');
            element.value = this.t(key);
        });

        // Update page title if has data-i18n attribute
        const titleElement = document.querySelector('title[data-i18n]');
        if (titleElement) {
            const key = titleElement.getAttribute('data-i18n');
            document.title = this.t(key);
        }
    }

    /**
     * Trigger custom event when language changes
     */
    triggerLanguageChangeEvent() {
        const event = new CustomEvent('languageChanged', {
            detail: { language: this.currentLang }
        });
        document.dispatchEvent(event);
    }

    /**
     * Get translated month name
     */
    getMonthName(monthIndex) {
        const months = [
            'january', 'february', 'march', 'april', 'may', 'june',
            'july', 'august', 'september', 'october', 'november', 'december'
        ];
        return this.t(`time.${months[monthIndex]}`);
    }

    /**
     * Get translated day name
     */
    getDayName(dayIndex) {
        const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        return this.t(`time.${days[dayIndex]}`);
    }

    /**
     * Format date with current language
     */
    formatDate(date) {
        const d = new Date(date);
        const dayName = this.getDayName(d.getDay());
        const day = d.getDate();
        const monthName = this.getMonthName(d.getMonth());
        const year = d.getFullYear();
        
        return `${dayName}, ${day} ${monthName} ${year}`;
    }

    /**
     * Format datetime with current language
     */
    formatDateTime(date) {
        const d = new Date(date);
        const formattedDate = this.formatDate(d);
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');
        
        return `${formattedDate} ${hours}:${minutes}`;
    }
}

// ========================================
// INITIALIZE
// ========================================

// Create global instance
window.i18n = new I18n();

// Apply translations as soon as script loads (before DOMContentLoaded)
// This prevents flickering/glitching
if (document.readyState === 'loading') {
    // If still loading, wait for interactive state
    document.addEventListener('DOMContentLoaded', initializeI18n);
} else {
    // DOM is already loaded, initialize immediately
    initializeI18n();
}

function initializeI18n() {
    // Update content immediately
    window.i18n.updatePageContent();
    
    // Set active language button in dropdown
    const currentLang = window.i18n.getCurrentLanguage();
    document.querySelectorAll('.lang-btn').forEach(btn => {
        if (btn.dataset.lang === currentLang) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

// Also run a quick update immediately for early-loaded elements
setTimeout(() => {
    if (window.i18n) {
        window.i18n.updatePageContent();
    }
}, 0);

// Export for module systems (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = I18n;
}
