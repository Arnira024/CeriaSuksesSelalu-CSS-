<?php
// jadwal.php

include 'db.php'; // pastikan file koneksi ada

// Ambil jadwal dari tabel schedules
$query = "SELECT s.*, 
    st1.name AS departure_station, 
    st2.name AS arrival_station 
  FROM schedules s
  JOIN stations st1 ON s.departure_station_id = st1.id
  JOIN stations st2 ON s.arrival_station_id = st2.id";

$result = $conn->query($query);

$jadwal = [];
while ($row = $result->fetch_assoc()) {
  $jadwal[] = $row;
}

echo json_encode($jadwal);
?>
