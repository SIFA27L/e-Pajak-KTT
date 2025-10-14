-- Database untuk Sistem Pembayaran Pajak KTT Indonesia
-- Created: 2025-10-14

CREATE DATABASE IF NOT EXISTS `e-pajak_ktt` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `e-pajak_ktt`;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('superadmin', 'admin', 'user') DEFAULT 'user',
    npwp VARCHAR(20),
    nik VARCHAR(20),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB;

-- Tabel Jenis Pajak
CREATE TABLE IF NOT EXISTS jenis_pajak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_pajak VARCHAR(10) UNIQUE NOT NULL,
    nama_pajak VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    persentase DECIMAL(5,2),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel Pembayaran Pajak
CREATE TABLE IF NOT EXISTS pembayaran_pajak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jenis_pajak_id INT NOT NULL,
    nomor_pembayaran VARCHAR(50) UNIQUE NOT NULL,
    npwp VARCHAR(20) NOT NULL,
    masa_pajak VARCHAR(20) NOT NULL,
    tahun_pajak YEAR NOT NULL,
    jumlah_pajak DECIMAL(15,2) NOT NULL,
    denda DECIMAL(15,2) DEFAULT 0,
    total_bayar DECIMAL(15,2) NOT NULL,
    metode_pembayaran ENUM('transfer_bank', 'virtual_account', 'e_wallet', 'kartu_kredit') NOT NULL,
    nomor_referensi VARCHAR(100),
    status_pembayaran ENUM('pending', 'berhasil', 'gagal', 'dibatalkan') DEFAULT 'pending',
    tanggal_pembayaran TIMESTAMP NULL,
    bukti_pembayaran VARCHAR(255),
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (jenis_pajak_id) REFERENCES jenis_pajak(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabel Notifikasi
CREATE TABLE IF NOT EXISTS notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    pesan TEXT NOT NULL,
    tipe ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabel Laporan
CREATE TABLE IF NOT EXISTS laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jenis_laporan VARCHAR(50) NOT NULL,
    periode_awal DATE NOT NULL,
    periode_akhir DATE NOT NULL,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert Superadmin (Password: admin123)
-- Note: Password sudah di-hash dengan password_hash() PHP
INSERT INTO users (username, email, password, full_name, role, npwp, nik, phone, address, status) VALUES
('superadmin', 'superadmin@kttindonesia.com', '$2y$10$vHwLBqcE5n0rQVGKgKXrHu.8s1PqE3DZZ0OqR1P6P9hJH.yqB.yGy', 'Super Administrator KTT', 'superadmin', '01.234.567.8-901.000', '3175012345678901', '021-12345678', 'Jakarta Pusat', 'active');

-- Insert Data Jenis Pajak Indonesia
INSERT INTO jenis_pajak (kode_pajak, nama_pajak, deskripsi, persentase, status) VALUES
('PPh21', 'Pajak Penghasilan Pasal 21', 'Pajak atas penghasilan berupa gaji, upah, honorarium, tunjangan dan pembayaran lain', 5.00, 'active'),
('PPh22', 'Pajak Penghasilan Pasal 22', 'Pajak yang dipungut oleh bendaharawan pemerintah, badan-badan tertentu', 1.50, 'active'),
('PPh23', 'Pajak Penghasilan Pasal 23', 'Pajak yang dipotong atas penghasilan dari modal, penyerahan jasa, atau hadiah', 2.00, 'active'),
('PPh25', 'Pajak Penghasilan Pasal 25', 'Angsuran pajak penghasilan yang harus dibayar sendiri oleh Wajib Pajak', 0.00, 'active'),
('PPh29', 'Pajak Penghasilan Pasal 29', 'Pajak penghasilan kurang bayar yang tercantum dalam SPT Tahunan', 0.00, 'active'),
('PPN', 'Pajak Pertambahan Nilai', 'Pajak yang dikenakan atas konsumsi Barang Kena Pajak atau Jasa Kena Pajak di dalam Daerah Pabean', 11.00, 'active'),
('PPnBM', 'Pajak Penjualan Barang Mewah', 'Pajak yang dikenakan atas konsumsi Barang Kena Pajak yang tergolong mewah', 0.00, 'active'),
('PBB', 'Pajak Bumi dan Bangunan', 'Pajak yang dikenakan atas kepemilikan atau pemanfaatan tanah dan/atau bangunan', 0.50, 'active');

-- Insert Sample Data Pembayaran untuk Demo
INSERT INTO pembayaran_pajak (user_id, jenis_pajak_id, nomor_pembayaran, npwp, masa_pajak, tahun_pajak, jumlah_pajak, denda, total_bayar, metode_pembayaran, status_pembayaran, tanggal_pembayaran) VALUES
(1, 1, 'INV-2025-001', '01.234.567.8-901.000', 'Januari', 2025, 5000000.00, 0.00, 5000000.00, 'transfer_bank', 'berhasil', '2025-01-15 10:30:00'),
(1, 6, 'INV-2025-002', '01.234.567.8-901.000', 'Januari', 2025, 11000000.00, 0.00, 11000000.00, 'virtual_account', 'berhasil', '2025-02-10 14:20:00'),
(1, 1, 'INV-2025-003', '01.234.567.8-901.000', 'Februari', 2025, 5200000.00, 0.00, 5200000.00, 'transfer_bank', 'berhasil', '2025-02-15 09:15:00'),
(1, 8, 'INV-2025-004', '01.234.567.8-901.000', 'Maret', 2025, 2500000.00, 0.00, 2500000.00, 'e_wallet', 'berhasil', '2025-03-20 16:45:00'),
(1, 6, 'INV-2025-005', '01.234.567.8-901.000', 'Februari', 2025, 12000000.00, 0.00, 12000000.00, 'virtual_account', 'berhasil', '2025-03-10 11:00:00');

-- Create Indexes untuk performa
CREATE INDEX idx_user_role ON users(role);
CREATE INDEX idx_pembayaran_status ON pembayaran_pajak(status_pembayaran);
CREATE INDEX idx_pembayaran_tanggal ON pembayaran_pajak(tanggal_pembayaran);
CREATE INDEX idx_pembayaran_user ON pembayaran_pajak(user_id);
CREATE INDEX idx_notifikasi_user ON notifikasi(user_id, is_read);
