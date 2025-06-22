<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $train_name = $_POST['train_name'];
  $rute = $_POST['rute'];
  $departure_station_id = $_POST['departure_station_id'];
  $arrival_station_id = $_POST['arrival_station_id'];
  $departure_time = $_POST['departure_time'];
  $arrival_time = $_POST['arrival_time'];
  $price = $_POST['price'];

  $route_display = [
  'mandai-garongkong' => 'Mandai-Garongkong',
  'garongkong-mandai' => 'Garongkong-Mandai',
  'garongkong-mangilu' => 'Garongkong-Mangilu',
  'mangilu-garongkong' => 'Mangilu-Garongkong'
];

$route_name = $route_display[$rute] ?? $rute; // pastikan tidak null


  $route_name = $route_display[$rute] ?? $rute;

  $stmt = $conn->prepare("INSERT INTO schedules (train_name, route_name, departure_station_id, arrival_station_id, departure_time, arrival_time, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiissd", $train_name, $route_name, $departure_station_id, $arrival_station_id, $departure_time, $arrival_time, $price);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
?>
