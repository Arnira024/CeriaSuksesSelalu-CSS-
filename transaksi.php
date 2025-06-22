<?php
header('Content-Type: application/json');
include 'db.php'; // pastikan file ini berisi koneksi ke database

$sql = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'customer_name' => $row['customer_name'],
            'customer_phone' => $row['customer_phone'],
            'ticket_quantity' => $row['ticket_quantity'],
            'payment_method' => $row['payment_method'],
            'total_amount' => $row['total_amount'],
            'created_at' => $row['created_at'],
            'status' => $row['status']
        ];
    }
}

echo json_encode($data);

$conn->close();
?>
