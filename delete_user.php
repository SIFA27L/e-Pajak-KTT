<?php
require_once 'config/config.php';

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

if (!isset($input['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID tidak ditemukan']);
    exit();
}

$user_id = (int)$input['user_id'];

// Prevent admin from deleting their own account
if ($user_id == $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Anda tidak dapat menghapus akun Anda sendiri!']);
    exit();
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Delete user (CASCADE will automatically delete related records)
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'User berhasil dihapus!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus user'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>
