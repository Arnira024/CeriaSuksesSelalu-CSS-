<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil JSON
    $data = json_decode(file_get_contents('php://input'), true);

    $train_id = $data['train_id'] ?? '';
    $train_name = $data['train_name'] ?? '';
    $route = $data['route'] ?? '';
    $status = $data['status'] ?? '';
    $delay_minutes = isset($data['delay']) ? (int)$data['delay'] : 0;
    $current_station = $data['current_station'] ?? '';
    $next_station = $data['next_station'] ?? '';
    $departure_time = $data['departure_time'] ?? null;
    $arrival_time = $data['arrival_time'] ?? null;

    // Validasi wajib
    if (empty($train_id) || empty($status) || empty($current_station) || empty($departure_time)) {
        echo json_encode(['success' => false, 'message' => 'Field wajib belum lengkap.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO train_tracking 
        (train_id, train_name, route, status, delay, current_station, next_station, departure_time, arrival_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssissss", 
        $train_id, $train_name, $route, $status, $delay_minutes, 
        $current_station, $next_station, $departure_time, $arrival_time
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data tracking berhasil disimpan.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid.']);
}
