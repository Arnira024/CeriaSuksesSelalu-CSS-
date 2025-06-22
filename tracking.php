<?php
// tracking.php

header("Content-Type: application/json");
include 'db.php';

// Ambil jadwal kereta paling terbaru dari tabel schedules
$sql = "
  SELECT s.*, 
         st1.name AS departure_station,
         st2.name AS arrival_station
  FROM schedules s
  JOIN stations st1 ON s.departure_station_id = st1.id
  JOIN stations st2 ON s.arrival_station_id = st2.id
  ORDER BY departure_time DESC 
  LIMIT 1
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Logic: kalau sekarang sudah lewat arrival_time, maka status = arrived
    $arrivalTime = strtotime($row['arrival_time']);
    $now = time();
    $status = ($now >= $arrivalTime) ? "arrived" : "on_trip";

    $data = [
        "train_id" => $row['id'],
        "train_name" => $row['train_name'],
        "route" => $row['route_name'],
        "status" => $status,
        "current_station" => $row['departure_station'],
        "next_station" => $row['arrival_station'],
        "departure_time" => $row['departure_time'],
        "arrival_time" => $row['arrival_time'],
        "delay" => 0 // Bisa diatur kalau mau simulasi keterlambatan
    ];
    echo json_encode($data);

} else {
    echo json_encode(["error" => "Data jadwal tidak ditemukan"]);
}

$conn->close();
?>
