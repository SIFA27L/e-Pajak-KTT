<?php
require_once 'config/config.php';
requireLogin();

// Simple PDF generation (you can use TCPDF or similar library for better results)
$type = $_POST['type'];
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

$db = new Database();
$conn = $db->getConnection();

// Build query based on type
$query = "SELECT p.*, j.nama_pajak, j.kode_pajak, u.full_name 
          FROM pembayaran_pajak p 
          JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
          JOIN users u ON p.user_id = u.id
          WHERE p.status_pembayaran = 'berhasil'";

$params = [];

if ($role !== 'superadmin') {
    $query .= " AND p.user_id = :user_id";
    $params[':user_id'] = $userId;
}

switch ($type) {
    case 'monthly':
        $month = $_POST['month'];
        $year = $_POST['year'];
        $query .= " AND MONTH(p.tanggal_pembayaran) = :month AND YEAR(p.tanggal_pembayaran) = :year";
        $params[':month'] = $month;
        $params[':year'] = $year;
        $title = "Laporan Bulanan - " . date('F Y', mktime(0, 0, 0, $month, 1, $year));
        break;
    
    case 'yearly':
        $year = $_POST['year'];
        $query .= " AND YEAR(p.tanggal_pembayaran) = :year";
        $params[':year'] = $year;
        $title = "Laporan Tahunan - " . $year;
        break;
    
    case 'custom':
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $query .= " AND DATE(p.tanggal_pembayaran) BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $start_date;
        $params[':end_date'] = $end_date;
        $title = "Laporan Custom - " . formatDate($start_date) . " s/d " . formatDate($end_date);
        break;
}

$query .= " ORDER BY p.tanggal_pembayaran DESC";

$stmt = $conn->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$payments = $stmt->fetchAll();

// Calculate totals
$total = 0;
foreach ($payments as $payment) {
    $total += $payment['total_bayar'];
}

// Set headers for PDF download
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #10b981;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .total-row {
            font-weight: bold;
            background: #e5e7eb !important;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #666;
            font-size: 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 20px;">
        Print / Save as PDF
    </button>

    <div class="header">
        <h1>PT KTT INDONESIA</h1>
        <p>Sistem Pembayaran Pajak Online</p>
        <p>Jl. Sudirman No. 123, Jakarta Pusat 10220, Indonesia</p>
        <p>Telp: (021) 1234-5678 | Email: info@kttindonesia.com</p>
    </div>

    <h2 style="color: #10b981; border-bottom: 2px solid #10b981; padding-bottom: 10px;"><?php echo $title; ?></h2>

    <div class="info-box">
        <strong>Nama:</strong> <?php echo $_SESSION['full_name']; ?><br>
        <strong>NPWP:</strong> <?php echo $_SESSION['npwp']; ?><br>
        <strong>Tanggal Cetak:</strong> <?php echo date('d/m/Y H:i:s'); ?> WIB
    </div>

    <?php if (count($payments) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Pembayaran</th>
                <th>Jenis Pajak</th>
                <th>Masa Pajak</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($payments as $payment): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo formatDate($payment['tanggal_pembayaran']); ?></td>
                <td><?php echo $payment['nomor_pembayaran']; ?></td>
                <td><?php echo $payment['kode_pajak']; ?> - <?php echo $payment['nama_pajak']; ?></td>
                <td><?php echo $payment['masa_pajak']; ?> <?php echo $payment['tahun_pajak']; ?></td>
                <td><?php echo formatRupiah($payment['total_bayar']); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL:</td>
                <td><?php echo formatRupiah($total); ?></td>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <p style="text-align: center; padding: 40px; color: #999;">Tidak ada data pembayaran untuk periode ini.</p>
    <?php endif; ?>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Pembayaran Pajak KTT Indonesia</p>
        <p>&copy; <?php echo date('Y'); ?> PT KTT Indonesia. All Rights Reserved.</p>
    </div>
</body>
</html>
