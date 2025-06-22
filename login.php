login.php

<?php
session_start();
include 'db.php';

// Cek apakah form dikirim pakai POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan info user ke session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: beranda_admin.html");
            exit;
        } else {
            header("Location: beranda.html"); // ← Halaman user
            exit;
        }
    } else {
        echo "Email atau password salah.";
    }
} else {
    // Kalau akses langsung ke login.php tanpa form
    header("Location: beranda.html");
    exit;
}
?>