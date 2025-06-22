<?php
$servername = "localhost";
$username = "username_db";
$password = "password_db";
$dbname = "db.php";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>