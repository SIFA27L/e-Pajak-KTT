-- Script untuk menghapus akun superadmin lama
-- Jalankan file ini untuk membersihkan akun admin lama
-- Setelah itu, register ulang dengan kode akses: KTTIND25

USE epajak_ktt;

-- Hapus akun superadmin lama
DELETE FROM users WHERE username = 'superadmin' OR role = 'superadmin';

-- Informasi
SELECT 'Akun superadmin telah dihapus. Silakan register dengan kode akses: KTTIND25' AS status;
