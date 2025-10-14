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
        'menu.profile': 'Profil Saya',
        'menu.users': 'Kelola Pengguna',
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
        'tax.title': 'Jenis Pajak',
        'tax.pbb': 'PBB (Pajak Bumi & Bangunan)',
        'tax.pbb_desc': 'Pajak atas tanah dan bangunan',
        'tax.vehicle': 'Pajak Kendaraan Bermotor',
        'tax.vehicle_desc': 'Pajak kendaraan bermotor tahunan',
        'tax.income': 'Pajak Penghasilan',
        'tax.income_desc': 'Pajak penghasilan pribadi/badan',
        'tax.business': 'Pajak Usaha',
        'tax.business_desc': 'Pajak untuk kegiatan usaha',
        'tax.pay_now': 'Bayar Pajak Sekarang',
        'tax.details': 'Detail',
        
        // Payment (Pembayaran)
        'payment.title': 'Pembayaran Pajak',
        'payment.select_tax': 'Pilih Jenis Pajak',
        'payment.choose_tax': 'Pilih jenis pajak',
        'payment.tax_amount': 'Jumlah Pajak',
        'payment.enter_amount': 'Masukkan jumlah',
        'payment.payment_method': 'Metode Pembayaran',
        'payment.bank_transfer': 'Transfer Bank',
        'payment.ewallet': 'E-Wallet',
        'payment.credit_card': 'Kartu Kredit',
        'payment.notes': 'Catatan',
        'payment.optional_notes': 'Catatan tambahan (opsional)',
        'payment.submit': 'Bayar Sekarang',
        'payment.cancel': 'Batal',
        'payment.processing': 'Memproses...',
        
        // History (Riwayat)
        'history.title': 'Riwayat Pembayaran',
        'history.no_data': 'Belum ada data pembayaran',
        'history.date': 'Tanggal',
        'history.tax_type': 'Jenis Pajak',
        'history.amount': 'Jumlah',
        'history.status': 'Status',
        'history.action': 'Aksi',
        'history.view_detail': 'Lihat Detail',
        'history.download_receipt': 'Unduh Bukti',
        'history.filter_all': 'Semua',
        'history.filter_paid': 'Lunas',
        'history.filter_unpaid': 'Belum Lunas',
        'history.filter_pending': 'Menunggu',
        
        // Report (Laporan)
        'report.title': 'Laporan Pajak',
        'report.generate': 'Buat Laporan',
        'report.period': 'Periode',
        'report.start_date': 'Tanggal Mulai',
        'report.end_date': 'Tanggal Akhir',
        'report.format': 'Format',
        'report.download': 'Unduh Laporan',
        'report.monthly': 'Bulanan',
        'report.yearly': 'Tahunan',
        'report.custom': 'Kustom',
        
        // Profile (Profil)
        'profile.title': 'Profil Saya',
        'profile.personal_info': 'Informasi Pribadi',
        'profile.full_name': 'Nama Lengkap',
        'profile.email': 'Email',
        'profile.phone': 'Nomor Telepon',
        'profile.address': 'Alamat',
        'profile.id_number': 'NIK',
        'profile.tax_number': 'NPWP',
        'profile.change_password': 'Ubah Password',
        'profile.old_password': 'Password Lama',
        'profile.new_password': 'Password Baru',
        'profile.confirm_password': 'Konfirmasi Password',
        'profile.save': 'Simpan Perubahan',
        'profile.cancel': 'Batal',
        
        // Users Management (Kelola Pengguna)
        'users.title': 'Kelola Pengguna',
        'users.add_new': 'Tambah Pengguna',
        'users.search': 'Cari pengguna...',
        'users.name': 'Nama',
        'users.email': 'Email',
        'users.role': 'Role',
        'users.status': 'Status',
        'users.action': 'Aksi',
        'users.edit': 'Edit',
        'users.delete': 'Hapus',
        'users.active': 'Aktif',
        'users.inactive': 'Nonaktif',
        'users.admin': 'Admin',
        'users.user': 'User',
        
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
        'menu.profile': 'My Profile',
        'menu.users': 'User Management',
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
        'tax.title': 'Tax Types',
        'tax.pbb': 'Property Tax',
        'tax.pbb_desc': 'Tax on land and buildings',
        'tax.vehicle': 'Vehicle Tax',
        'tax.vehicle_desc': 'Annual motor vehicle tax',
        'tax.income': 'Income Tax',
        'tax.income_desc': 'Personal/corporate income tax',
        'tax.business': 'Business Tax',
        'tax.business_desc': 'Tax for business activities',
        'tax.pay_now': 'Pay Tax Now',
        'tax.details': 'Details',
        
        // Payment
        'payment.title': 'Tax Payment',
        'payment.select_tax': 'Select Tax Type',
        'payment.choose_tax': 'Choose tax type',
        'payment.tax_amount': 'Tax Amount',
        'payment.enter_amount': 'Enter amount',
        'payment.payment_method': 'Payment Method',
        'payment.bank_transfer': 'Bank Transfer',
        'payment.ewallet': 'E-Wallet',
        'payment.credit_card': 'Credit Card',
        'payment.notes': 'Notes',
        'payment.optional_notes': 'Additional notes (optional)',
        'payment.submit': 'Pay Now',
        'payment.cancel': 'Cancel',
        'payment.processing': 'Processing...',
        
        // History
        'history.title': 'Payment History',
        'history.no_data': 'No payment data yet',
        'history.date': 'Date',
        'history.tax_type': 'Tax Type',
        'history.amount': 'Amount',
        'history.status': 'Status',
        'history.action': 'Action',
        'history.view_detail': 'View Detail',
        'history.download_receipt': 'Download Receipt',
        'history.filter_all': 'All',
        'history.filter_paid': 'Paid',
        'history.filter_unpaid': 'Unpaid',
        'history.filter_pending': 'Pending',
        
        // Report
        'report.title': 'Tax Report',
        'report.generate': 'Generate Report',
        'report.period': 'Period',
        'report.start_date': 'Start Date',
        'report.end_date': 'End Date',
        'report.format': 'Format',
        'report.download': 'Download Report',
        'report.monthly': 'Monthly',
        'report.yearly': 'Yearly',
        'report.custom': 'Custom',
        
        // Profile
        'profile.title': 'My Profile',
        'profile.personal_info': 'Personal Information',
        'profile.full_name': 'Full Name',
        'profile.email': 'Email',
        'profile.phone': 'Phone Number',
        'profile.address': 'Address',
        'profile.id_number': 'ID Number',
        'profile.tax_number': 'Tax Number',
        'profile.change_password': 'Change Password',
        'profile.old_password': 'Old Password',
        'profile.new_password': 'New Password',
        'profile.confirm_password': 'Confirm Password',
        'profile.save': 'Save Changes',
        'profile.cancel': 'Cancel',
        
        // Users Management
        'users.title': 'User Management',
        'users.add_new': 'Add User',
        'users.search': 'Search users...',
        'users.name': 'Name',
        'users.email': 'Email',
        'users.role': 'Role',
        'users.status': 'Status',
        'users.action': 'Action',
        'users.edit': 'Edit',
        'users.delete': 'Delete',
        'users.active': 'Active',
        'users.inactive': 'Inactive',
        'users.admin': 'Admin',
        'users.user': 'User',
        
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
                // Keep icons if present
                const icon = element.querySelector('i');
                if (icon) {
                    element.innerHTML = '';
                    element.appendChild(icon.cloneNode(true));
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

// Auto-update content on page load
document.addEventListener('DOMContentLoaded', function() {
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
});

// Export for module systems (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = I18n;
}
