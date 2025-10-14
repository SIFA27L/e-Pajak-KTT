<?php
require_once 'config/config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis_pajak_id = sanitize($_POST['jenis_pajak_id']);
    $npwp = sanitize($_POST['npwp']);
    $masa_pajak = sanitize($_POST['masa_pajak']);
    $tahun_pajak = sanitize($_POST['tahun_pajak']);
    $jumlah_pajak = floatval($_POST['jumlah_pajak']);
    $denda = floatval($_POST['denda']);
    $total_bayar = floatval($_POST['total_bayar']);
    $metode_pembayaran = sanitize($_POST['metode_pembayaran']);
    $keterangan = sanitize($_POST['keterangan']);
    
    // Determine user_id based on payment_for (for admin)
    $user_id = $_SESSION['user_id'];
    $payment_for_other = false;
    
    if (isAdmin() && isset($_POST['payment_for'])) {
        $payment_for = sanitize($_POST['payment_for']);
        
        if ($payment_for === 'other_user' && !empty($_POST['selected_user_id'])) {
            // Admin paying for another user
            $user_id = intval($_POST['selected_user_id']);
            $payment_for_other = true;
        } else if ($payment_for === 'manual') {
            // Admin using manual NPWP (keep current user_id but use provided NPWP)
            $payment_for_other = true;
        }
        // If 'self', use current user_id
    }

    // Validation
    if (empty($jenis_pajak_id) || empty($npwp) || empty($masa_pajak) || empty($tahun_pajak) || 
        $jumlah_pajak <= 0 || empty($metode_pembayaran)) {
        echo json_encode(['success' => false, 'message' => 'Semua field wajib harus diisi!']);
        exit();
    }
    
    // Validate NPWP format (15-16 digits)
    if (!preg_match('/^[0-9]{15,16}$/', str_replace(['.', '-'], '', $npwp))) {
        echo json_encode(['success' => false, 'message' => 'Format NPWP tidak valid! NPWP harus berisi 15-16 digit angka.']);
        exit();
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Generate nomor pembayaran
        $nomorPembayaran = generateNomorPembayaran();

        // Insert pembayaran
        $stmt = $conn->prepare("INSERT INTO pembayaran_pajak 
                                (user_id, jenis_pajak_id, nomor_pembayaran, npwp, masa_pajak, tahun_pajak, 
                                 jumlah_pajak, denda, total_bayar, metode_pembayaran, keterangan, status_pembayaran, tanggal_pembayaran) 
                                VALUES 
                                (:user_id, :jenis_pajak_id, :nomor_pembayaran, :npwp, :masa_pajak, :tahun_pajak, 
                                 :jumlah_pajak, :denda, :total_bayar, :metode_pembayaran, :keterangan, 'berhasil', NOW())");
        
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':jenis_pajak_id', $jenis_pajak_id);
        $stmt->bindParam(':nomor_pembayaran', $nomorPembayaran);
        $stmt->bindParam(':npwp', $npwp);
        $stmt->bindParam(':masa_pajak', $masa_pajak);
        $stmt->bindParam(':tahun_pajak', $tahun_pajak);
        $stmt->bindParam(':jumlah_pajak', $jumlah_pajak);
        $stmt->bindParam(':denda', $denda);
        $stmt->bindParam(':total_bayar', $total_bayar);
        $stmt->bindParam(':metode_pembayaran', $metode_pembayaran);
        $stmt->bindParam(':keterangan', $keterangan);

        if ($stmt->execute()) {
            // Create notification for the user whose payment is being processed
            $notifStmt = $conn->prepare("INSERT INTO notifikasi (user_id, judul, pesan, tipe) 
                                          VALUES (:user_id, :judul, :pesan, 'success')");
            $judul = "Pembayaran Berhasil";
            
            if ($payment_for_other && isAdmin()) {
                $pesan = "Pembayaran pajak dengan nomor $nomorPembayaran untuk NPWP $npwp telah berhasil diproses oleh admin.";
            } else {
                $pesan = "Pembayaran pajak dengan nomor $nomorPembayaran telah berhasil diproses.";
            }
            
            $notifStmt->bindParam(':user_id', $user_id);
            $notifStmt->bindParam(':judul', $judul);
            $notifStmt->bindParam(':pesan', $pesan);
            $notifStmt->execute();
            
            // Also notify the admin who processed it (if different)
            if ($payment_for_other && $_SESSION['user_id'] != $user_id) {
                $adminNotifStmt = $conn->prepare("INSERT INTO notifikasi (user_id, judul, pesan, tipe) 
                                                   VALUES (:user_id, :judul, :pesan, 'success')");
                $adminJudul = "Pembayaran Berhasil Diproses";
                $adminPesan = "Anda telah berhasil memproses pembayaran dengan nomor $nomorPembayaran untuk NPWP $npwp.";
                $admin_user_id = $_SESSION['user_id'];
                $adminNotifStmt->bindParam(':user_id', $admin_user_id);
                $adminNotifStmt->bindParam(':judul', $adminJudul);
                $adminNotifStmt->bindParam(':pesan', $adminPesan);
                $adminNotifStmt->execute();
            }

            echo json_encode([
                'success' => true,
                'message' => 'Pembayaran berhasil! Nomor pembayaran: ' . $nomorPembayaran,
                'nomor_pembayaran' => $nomorPembayaran
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal memproses pembayaran. Silakan coba lagi.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
