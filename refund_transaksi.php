<?php
include 'db.php';

header('Content-Type: application/json');

// Cek apakah ada parameter ID
if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
    exit;
}

$id = intval($_GET['id']);

// Hapus data transaksi dari tabel
$sql = "DELETE FROM transactions WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil dihapus dari database']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal hapus transaksi: ' . $conn->error]);
}

$conn->close();
?>
