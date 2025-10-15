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

$user_id = (int)$_POST['user_id'];
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$phone = sanitize($_POST['phone']);
$role = sanitize($_POST['role']);

// Validation
if (empty($full_name) || empty($email) || empty($phone) || empty($role)) {
    echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid!']);
    exit();
}

if (!in_array($role, ['user', 'admin'])) {
    echo json_encode(['success' => false, 'message' => 'Role tidak valid!']);
    exit();
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Check if email already exists for other users
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :user_id");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email sudah digunakan oleh user lain!']);
        exit();
    }

    // Update user
    $stmt = $conn->prepare("UPDATE users SET full_name = :full_name, email = :email, phone = :phone, role = :role WHERE id = :user_id");
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Data user berhasil diupdate!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengupdate data user'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>
