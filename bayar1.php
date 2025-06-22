<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id']) || empty($data['akun']) || empty($data['nominal'])) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Misal update status transaksi
$id = $data['id'];
$query = "UPDATE transactions SET status='completed' WHERE id=$id";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal update database']);
}
?>
