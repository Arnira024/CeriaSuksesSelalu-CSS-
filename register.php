<?php
include 'db.php';
session_start();

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone    = $_POST['phone_number'];
$role     = 'user'; // default role user

// Cek dulu apakah email sudah terdaftar
$cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    echo "Email sudah terdaftar! Silakan gunakan email lain.";
    header("Refresh: 2; url=register.html");
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (name, email, password, phone_number, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $password, $phone, $role);

if ($stmt->execute()) {
    $user_id = $conn->insert_id;
    $_SESSION['IdUser'] = $user_id;
    $_SESSION['RoleAktif'] = $role;

    echo "Registrasi berhasil!...";
    header("Refresh: 2; url=beranda.html");
    exit;
} else {
    echo "Gagal registrasi: " . $stmt->error;
}
?>
