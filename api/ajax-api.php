<?php
/**
 * AJAX API Handler
 * Handles all AJAX requests for e-Pajak KTT
 */

require_once '../config/config.php';

// Set JSON header
header('Content-Type: application/json');

// Check if request is AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Require login for all AJAX requests
requireLogin();

$db = new Database();
$conn = $db->getConnection();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

try {
    switch ($action) {
        
        // Get dashboard stats
        case 'get_stats':
            $stats = getDashboardStats($conn, $userId, $role);
            echo json_encode(['success' => true, 'data' => $stats]);
            break;

        // Get payment history
        case 'get_payments':
            $page = $_GET['page'] ?? 1;
            $limit = $_GET['limit'] ?? 10;
            $search = $_GET['search'] ?? '';
            $status = $_GET['status'] ?? '';
            
            $payments = getPayments($conn, $userId, $role, $page, $limit, $search, $status);
            echo json_encode(['success' => true, 'data' => $payments]);
            break;

        // Get payment detail
        case 'get_payment_detail':
            $paymentId = $_GET['id'] ?? 0;
            $payment = getPaymentDetail($conn, $paymentId, $userId, $role);
            
            if ($payment) {
                echo json_encode(['success' => true, 'data' => $payment]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Payment not found']);
            }
            break;

        // Get users list (admin only)
        case 'get_users':
            if ($role !== 'superadmin') {
                throw new Exception('Unauthorized access');
            }
            
            $page = $_GET['page'] ?? 1;
            $limit = $_GET['limit'] ?? 10;
            $search = $_GET['search'] ?? '';
            
            $users = getUsers($conn, $page, $limit, $search);
            echo json_encode(['success' => true, 'data' => $users]);
            break;

        // Toggle user status
        case 'toggle_user_status':
            if ($role !== 'superadmin') {
                throw new Exception('Unauthorized access');
            }
            
            $targetUserId = $_POST['user_id'] ?? 0;
            $result = toggleUserStatus($conn, $targetUserId);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Status berhasil diubah',
                'data' => $result
            ]);
            break;

        // Delete user
        case 'delete_user':
            if ($role !== 'superadmin') {
                throw new Exception('Unauthorized access');
            }
            
            $targetUserId = $_POST['user_id'] ?? 0;
            deleteUser($conn, $targetUserId);
            
            echo json_encode([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
            break;

        // Search payments
        case 'search_payments':
            $query = $_GET['q'] ?? '';
            $results = searchPayments($conn, $userId, $role, $query);
            echo json_encode(['success' => true, 'data' => $results]);
            break;

        // Get notifications
        case 'get_notifications':
            $notifications = getNotifications($conn, $userId);
            echo json_encode(['success' => true, 'data' => $notifications]);
            break;

        // Mark notification as read
        case 'mark_notification_read':
            $notifId = $_POST['id'] ?? 0;
            markNotificationRead($conn, $notifId, $userId);
            echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
            break;

        // Get jenis pajak
        case 'get_jenis_pajak':
            $query = "SELECT * FROM jenis_pajak WHERE status = 'aktif' ORDER BY nama_pajak ASC";
            $stmt = $conn->query($query);
            $jenisPajak = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $jenisPajak]);
            break;

        // Validate NPWP
        case 'validate_npwp':
            $npwp = $_POST['npwp'] ?? '';
            $isValid = validateNPWP($npwp);
            echo json_encode(['success' => true, 'valid' => $isValid]);
            break;

        // Calculate tax
        case 'calculate_tax':
            $jenisPajakId = $_POST['jenis_pajak_id'] ?? 0;
            $jumlahPajak = $_POST['jumlah_pajak'] ?? 0;
            $tanggalJatuhTempo = $_POST['tanggal_jatuh_tempo'] ?? '';
            
            $calculation = calculateTax($jumlahPajak, $tanggalJatuhTempo);
            echo json_encode(['success' => true, 'data' => $calculation]);
            break;

        default:
            throw new Exception('Invalid action');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Helper Functions

function getDashboardStats($conn, $userId, $role) {
    $stats = [];
    
    if ($role === 'superadmin') {
        // Total users
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users WHERE role != 'superadmin'");
        $stats['total_users'] = $stmt->fetch()['count'];
        
        // Total payments
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pembayaran_pajak");
        $stats['total_payments'] = $stmt->fetch()['count'];
        
        // Total revenue
        $stmt = $conn->query("SELECT SUM(total_bayar) as total FROM pembayaran_pajak WHERE status_pembayaran = 'berhasil'");
        $stats['total_revenue'] = $stmt->fetch()['total'] ?? 0;
        
        // Pending payments
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pembayaran_pajak WHERE status_pembayaran = 'pending'");
        $stats['pending_payments'] = $stmt->fetch()['count'];
        
    } else {
        // User stats
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM pembayaran_pajak WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['total_payments'] = $stmt->fetch()['count'];
        
        $stmt = $conn->prepare("SELECT SUM(total_bayar) as total FROM pembayaran_pajak WHERE user_id = ? AND status_pembayaran = 'berhasil'");
        $stmt->execute([$userId]);
        $stats['total_paid'] = $stmt->fetch()['total'] ?? 0;
        
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM pembayaran_pajak WHERE user_id = ? AND status_pembayaran = 'pending'");
        $stmt->execute([$userId]);
        $stats['pending_payments'] = $stmt->fetch()['count'];
    }
    
    return $stats;
}

function getPayments($conn, $userId, $role, $page, $limit, $search, $status) {
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT p.*, j.nama_pajak, j.kode_pajak, u.full_name 
              FROM pembayaran_pajak p 
              JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
              JOIN users u ON p.user_id = u.id";
    
    $where = [];
    $params = [];
    
    if ($role !== 'superadmin') {
        $where[] = "p.user_id = ?";
        $params[] = $userId;
    }
    
    if ($search) {
        $where[] = "(p.nomor_pembayaran LIKE ? OR p.npwp LIKE ? OR u.full_name LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    if ($status) {
        $where[] = "p.status_pembayaran = ?";
        $params[] = $status;
    }
    
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    $query .= " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM pembayaran_pajak p 
                   JOIN users u ON p.user_id = u.id";
    if (!empty($where)) {
        $countQuery .= " WHERE " . implode(" AND ", array_slice($where, 0, count($where)));
    }
    
    $stmt = $conn->prepare($countQuery);
    $stmt->execute(array_slice($params, 0, count($params) - 2));
    $total = $stmt->fetch()['total'];
    
    return [
        'payments' => $payments,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => ceil($total / $limit)
    ];
}

function getPaymentDetail($conn, $paymentId, $userId, $role) {
    $query = "SELECT p.*, j.nama_pajak, j.kode_pajak, u.full_name, u.email 
              FROM pembayaran_pajak p 
              JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
              JOIN users u ON p.user_id = u.id
              WHERE p.id = ?";
    
    if ($role !== 'superadmin') {
        $query .= " AND p.user_id = ?";
    }
    
    $stmt = $conn->prepare($query);
    
    if ($role !== 'superadmin') {
        $stmt->execute([$paymentId, $userId]);
    } else {
        $stmt->execute([$paymentId]);
    }
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUsers($conn, $page, $limit, $search) {
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT id, full_name, email, npwp, phone, role, status, created_at 
              FROM users WHERE role != 'superadmin'";
    
    $params = [];
    
    if ($search) {
        $query .= " AND (full_name LIKE ? OR email LIKE ? OR npwp LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM users WHERE role != 'superadmin'";
    if ($search) {
        $countQuery .= " AND (full_name LIKE ? OR email LIKE ? OR npwp LIKE ?)";
    }
    
    $stmt = $conn->prepare($countQuery);
    if ($search) {
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    } else {
        $stmt->execute();
    }
    $total = $stmt->fetch()['total'];
    
    return [
        'users' => $users,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => ceil($total / $limit)
    ];
}

function toggleUserStatus($conn, $userId) {
    $stmt = $conn->prepare("UPDATE users SET status = IF(status = 'aktif', 'nonaktif', 'aktif') WHERE id = ?");
    $stmt->execute([$userId]);
    
    $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function deleteUser($conn, $userId) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'superadmin'");
    $stmt->execute([$userId]);
}

function searchPayments($conn, $userId, $role, $query) {
    $sql = "SELECT p.*, j.nama_pajak, j.kode_pajak 
            FROM pembayaran_pajak p 
            JOIN jenis_pajak j ON p.jenis_pajak_id = j.id
            WHERE (p.nomor_pembayaran LIKE ? OR p.npwp LIKE ?)";
    
    if ($role !== 'superadmin') {
        $sql .= " AND p.user_id = ?";
    }
    
    $sql .= " LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$query%";
    
    if ($role !== 'superadmin') {
        $stmt->execute([$searchTerm, $searchTerm, $userId]);
    } else {
        $stmt->execute([$searchTerm, $searchTerm]);
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNotifications($conn, $userId) {
    // Placeholder - implement notifications table if needed
    return [];
}

function markNotificationRead($conn, $notifId, $userId) {
    // Placeholder - implement notifications table if needed
    return true;
}

function validateNPWP($npwp) {
    // Remove non-numeric characters
    $npwp = preg_replace('/[^0-9]/', '', $npwp);
    
    // NPWP should be 15 digits
    return strlen($npwp) === 15;
}

function calculateTax($jumlahPajak, $tanggalJatuhTempo) {
    $denda = 0;
    $today = date('Y-m-d');
    
    if ($tanggalJatuhTempo < $today) {
        $days = (strtotime($today) - strtotime($tanggalJatuhTempo)) / 86400;
        $months = ceil($days / 30);
        // 2% per bulan
        $denda = $jumlahPajak * 0.02 * $months;
    }
    
    return [
        'jumlah_pajak' => $jumlahPajak,
        'denda' => $denda,
        'total_bayar' => $jumlahPajak + $denda,
        'is_late' => $tanggalJatuhTempo < $today
    ];
}
