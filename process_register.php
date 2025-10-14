<?php
require_once 'config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $npwp = sanitize($_POST['npwp']);
    $nik = sanitize($_POST['nik']);
    $address = sanitize($_POST['address']);
    $password = $_POST['password'];
    $admin_code = isset($_POST['admin_code']) ? sanitize($_POST['admin_code']) : '';

    // Tentukan role berdasarkan kode akses
    $role = 'user'; // Default role
    if (!empty($admin_code) && $admin_code === 'KTTIND25') {
        $role = 'admin';
    }

    // Validation
    if (empty($full_name) || empty($username) || empty($email) || empty($phone) || 
        empty($npwp) || empty($nik) || empty($address) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Format email tidak valid!']);
        exit();
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter!']);
        exit();
    }

    if (strlen($nik) != 16) {
        echo json_encode(['success' => false, 'message' => 'NIK harus 16 digit!']);
        exit();
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Username sudah digunakan!']);
            exit();
        }

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar!']);
            exit();
        }

        // Check if NPWP exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE npwp = :npwp");
        $stmt->bindParam(':npwp', $npwp);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'NPWP sudah terdaftar!']);
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user dengan role yang sesuai
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, npwp, nik, phone, address, role, status) 
                                VALUES (:username, :email, :password, :full_name, :npwp, :nik, :phone, :address, :role, 'active')");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':npwp', $npwp);
        $stmt->bindParam(':nik', $nik);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            $successMessage = $role === 'admin' 
                ? 'Pendaftaran sebagai ADMIN berhasil! Silakan login.' 
                : 'Pendaftaran berhasil! Silakan login.';
            
            echo json_encode([
                'success' => true,
                'message' => $successMessage
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal mendaftar. Silakan coba lagi.'
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
