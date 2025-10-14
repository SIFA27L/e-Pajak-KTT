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
    $user_id = $_SESSION['user_id'];

    // Validation
    if (empty($jenis_pajak_id) || empty($npwp) || empty($masa_pajak) || empty($tahun_pajak) || 
        $jumlah_pajak <= 0 || empty($metode_pembayaran)) {
        echo json_encode(['success' => false, 'message' => 'Semua field wajib harus diisi!']);
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
            // Create notification
            $notifStmt = $conn->prepare("INSERT INTO notifikasi (user_id, judul, pesan, tipe) 
                                          VALUES (:user_id, :judul, :pesan, 'success')");
            $judul = "Pembayaran Berhasil";
            $pesan = "Pembayaran pajak dengan nomor $nomorPembayaran telah berhasil diproses.";
            $notifStmt->bindParam(':user_id', $user_id);
            $notifStmt->bindParam(':judul', $judul);
            $notifStmt->bindParam(':pesan', $pesan);
            $notifStmt->execute();

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
