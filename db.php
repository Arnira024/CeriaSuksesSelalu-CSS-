<?php
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP
$dbname = "tiket_kereta";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>