<?php
require_once '../config/config.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['user_id']) || !isset($input['status'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit();
}

$user_id = (int)$input['user_id'];
$status = $input['status'];

// Validation
if (!in_array($status, ['active', 'inactive'])) {
    echo json_encode(['success' => false, 'message' => 'Status tidak valid!']);
    exit();
}

// Prevent admin from deactivating their own account
if ($user_id == $_SESSION['user_id'] && $status === 'inactive') {
    echo json_encode(['success' => false, 'message' => 'Anda tidak dapat menonaktifkan akun Anda sendiri!']);
    exit();
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :user_id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        $message = $status === 'active' ? 'User berhasil diaktifkan!' : 'User berhasil dinonaktifkan!';
        echo json_encode([
            'success' => true,
            'message' => $message
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengubah status user'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>
