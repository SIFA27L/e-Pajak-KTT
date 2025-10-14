# Sistem Pembayaran Pajak KTT Indonesia

Website pembayaran pajak online yang modern, aman, dan user-friendly untuk memudahkan wajib pajak dalam melakukan pembayaran pajak secara online.

## 🚀 Fitur Utama

### Untuk User (Wajib Pajak)
- ✅ **Registrasi & Login** - Sistem autentikasi yang aman
- ✅ **Dashboard** - Statistik pembayaran dengan chart interaktif
- ✅ **Pembayaran Pajak** - Multiple metode pembayaran (Transfer Bank, Virtual Account, E-Wallet, Kartu Kredit)
- ✅ **Riwayat Pembayaran** - Tracking semua transaksi pembayaran
- ✅ **Jenis Pajak** - Informasi lengkap berbagai jenis pajak Indonesia
- ✅ **Laporan** - Generate laporan PDF (Bulanan, Tahunan, Custom)
- ✅ **Profil Management** - Edit profil dan ubah password

### Untuk Superadmin
- ✅ **Full Dashboard Access** - Monitoring semua transaksi
- ✅ **User Management** - Kelola semua user
- ✅ **Report Overview** - Laporan keseluruhan sistem

## 💻 Teknologi

- **Backend:** PHP 7.4+ dengan PDO
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Charts:** Chart.js
- **Icons:** Font Awesome 6
- **Fonts:** Google Fonts (Inter)

## 📦 Instalasi

### Prasyarat
- XAMPP/WAMP/LAMP dengan PHP 7.4+
- MySQL 5.7+
- Web Browser modern

### Langkah Instalasi

1. **Clone atau Download Project**
   ```bash
   git clone [url-repository]
   ```
   Atau copy folder ke `htdocs` (XAMPP) atau `www` (WAMP)

2. **Setup Database**
   - Buka phpMyAdmin (http://localhost/phpmyadmin)
   - Import file `database.sql`
   - Database `epajak_ktt` akan otomatis terbuat

3. **Konfigurasi Database**
   Edit file `config/database.php` jika perlu:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'epajak_ktt');
   ```

4. **Jalankan Aplikasi**
   - Buka browser
   - Akses: `http://localhost/e-commerce/`
   - Otomatis redirect ke halaman login

## 👤 Akun Default

### Superadmin
- **Username:** `superadmin`
- **Email:** `superadmin@kttindonesia.com`
- **Password:** `admin123`
- **NPWP:** `01.234.567.8-901.000`

> ⚠️ **Penting:** Segera ubah password default setelah login pertama kali!

## 📊 Jenis Pajak yang Didukung

1. **PPh 21** - Pajak Penghasilan Pasal 21
2. **PPh 22** - Pajak Penghasilan Pasal 22
3. **PPh 23** - Pajak Penghasilan Pasal 23
4. **PPh 25** - Pajak Penghasilan Pasal 25
5. **PPh 29** - Pajak Penghasilan Pasal 29
6. **PPN** - Pajak Pertambahan Nilai (11%)
7. **PPnBM** - Pajak Penjualan Barang Mewah
8. **PBB** - Pajak Bumi dan Bangunan

## 🎨 Design Features

- **Modern & Elegant** - Desain minimalis dengan gradient purple
- **Responsive** - Mobile-friendly design
- **Sidebar Navigation** - Smooth sliding sidebar dengan overlay
- **Real-time Clock** - Menampilkan tanggal dan waktu Indonesia
- **Interactive Charts** - Visualisasi data dengan Chart.js
- **Smooth Animations** - Hover effects dan transitions
- **Color Palette:**
  - Primary: #667eea (Purple)
  - Secondary: #764ba2 (Dark Purple)
  - Accent Colors: Gradient combinations

## 📁 Struktur Project

```
e-commerce/
├── assets/
│   └── css/
│       └── style.css          # Main stylesheet
├── config/
│   ├── config.php             # General configuration
│   └── database.php           # Database connection
├── includes/
│   ├── header.php             # Header dengan datetime
│   ├── sidebar.php            # Sidebar navigation
│   └── footer.php             # Footer dengan info kontak
├── uploads/                    # Upload directory
├── database.sql               # Database schema
├── index.php                  # Entry point (redirect to login)
├── login.php                  # Login page
├── register.php               # Registration page
├── process_login.php          # Login handler
├── process_register.php       # Registration handler
├── dashboard.php              # Main dashboard
├── pembayaran.php             # Payment form
├── process_payment.php        # Payment handler
├── riwayat.php                # Payment history
├── jenis_pajak.php            # Tax types info
├── laporan.php                # Reports page
├── generate_report.php        # Report generator
├── profile.php                # User profile
├── logout.php                 # Logout handler
└── README.md                  # This file
```

## 🔒 Keamanan

- ✅ Password hashing dengan `password_hash()` PHP
- ✅ Prepared statements untuk mencegah SQL Injection
- ✅ Session management yang aman
- ✅ Input sanitization
- ✅ CSRF protection ready
- ✅ XSS prevention

## 🌐 API Integration Ready

Sistem sudah siap diintegrasikan dengan:
- Payment Gateway (Midtrans, Xendit, dll)
- SMS Gateway untuk notifikasi
- Email service untuk konfirmasi
- DJP Online API (jika tersedia)

## 📱 Browser Support

- ✅ Chrome (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Edge (Latest)
- ✅ Mobile Browsers

## 🎯 Cara Penggunaan

### Untuk User Baru
1. Klik "Daftar Sekarang" di halaman login
2. Isi form registrasi dengan lengkap (NPWP, NIK wajib)
3. Login dengan username/email dan password
4. Akses dashboard untuk melihat statistik
5. Pilih menu "Pembayaran Pajak" untuk bayar
6. Pilih jenis pajak dan isi data pembayaran
7. Klik "Proses Pembayaran"
8. Lihat riwayat di menu "Riwayat Pembayaran"

### Generate Laporan
1. Buka menu "Laporan"
2. Pilih jenis laporan (Bulanan/Tahunan/Custom)
3. Isi periode yang diinginkan
4. Klik "Generate PDF"
5. Print atau save as PDF

## 🛠️ Troubleshooting

### Database Connection Error
- Pastikan MySQL service running
- Cek kredensial di `config/database.php`
- Pastikan database sudah diimport

### Session Error
- Pastikan `session.save_path` writable
- Clear browser cache dan cookies

### Login Gagal
- Cek username dan password
- Pastikan akun status 'active'

## 📞 Informasi Kontak PT KTT Indonesia

- **Alamat:** Jl. Sudirman No. 123, Jakarta Pusat 10220, Indonesia
- **Telepon:** (021) 1234-5678
- **Email:** info@kttindonesia.com
- **Website:** www.kttindonesia.com
- **Jam Operasional:**
  - Senin - Jumat: 08:00 - 17:00 WIB
  - Sabtu: 08:00 - 12:00 WIB
  - Minggu & Libur: Tutup

## 📝 License

© 2025 PT KTT Indonesia. All Rights Reserved.

## 👨‍💻 Developer

Developed with ❤️ by KTT Indonesia IT Team

---

**Catatan:** Sistem ini dibuat untuk keperluan edukasi dan demo. Untuk implementasi production, disarankan menambahkan:
- SSL Certificate (HTTPS)
- Enhanced security measures
- Email verification
- Real payment gateway integration
- Backup & recovery system
- Logging system
- Rate limiting
- CAPTCHA untuk login/register
