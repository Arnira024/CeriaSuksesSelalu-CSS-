<?php
header('Content-Type: application/json');
include 'db.php';

// Ambil data yang dikirim dari JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Escape data untuk mencegah SQL injection
$schedule_id = $conn->real_escape_string($data['schedule_id']);
$train_id = $conn->real_escape_string($data['train_id']);
$train_name = $conn->real_escape_string($data['train_name']);
$route = $conn->real_escape_string($data['route']);
$status = $conn->real_escape_string($data['status']);
$current_station = $conn->real_escape_string($data['current_station']);
$next_station = $conn->real_escape_string($data['next_station']);
$departure_time = $conn->real_escape_string($data['departure_time']);
$arrival_time = $conn->real_escape_string($data['arrival_time']);
$delay = intval($data['delay']);

// Query untuk update data jadwal
$sql = "UPDATE schedules SET
        train_name = '$train_name',
        route_name = '$route',
        departure_time = '$departure_time',
        arrival_time = '$arrival_time'
        WHERE id = '$schedule_id'";

if ($conn->query($sql)) {
    // Jika berhasil diupdate
    echo json_encode(['success' => true, 'message' => 'Jadwal berhasil diperbarui']);
} else {
    // Jika terjadi error
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
?>