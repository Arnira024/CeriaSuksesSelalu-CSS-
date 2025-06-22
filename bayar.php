<?php
include 'db.php';

// Ambil JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (
    empty($data['jadwal']) ||
    empty($data['nama']) ||
    empty($data['telp']) ||
    empty($data['jumlah']) ||
    empty($data['metode']) ||
    empty($data['total'])
) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Data
$jadwal = $data['jadwal'];
$nama   = $data['nama'];
$telp   = $data['telp'];
$jumlah = intval($data['jumlah']);
$metode = $data['metode'];
$total  = floatval($data['total']);

// Simpan ke tabel transactions
try {
    $stmt = $conn->prepare("
        INSERT INTO transactions 
            (schedule_id, customer_name, customer_phone, ticket_quantity, payment_method, total_amount, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "issisd",
        $jadwal['id'],
        $nama,
        $telp,
        $jumlah,
        $metode,
        $total
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
