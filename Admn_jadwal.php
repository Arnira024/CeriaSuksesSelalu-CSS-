<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;
  $route_name = $_POST['rute']; // tetap dari form input 'rute'
  $train_name = $_POST['train_name'];
  $dep_station = $_POST['departure_station_id'];
  $arr_station = $_POST['arrival_station_id'];
  $dep_time = $_POST['departure_time'];
  $arr_time = $_POST['arrival_time'];
  $price = $_POST['price'];

  if ($id) {
    // UPDATE
    $sql = "UPDATE schedules SET 
      route_name='$route_name',
      train_name='$train_name',
      departure_station_id=$dep_station,
      arrival_station_id=$arr_station,
      departure_time='$dep_time',
      arrival_time='$arr_time',
      price=$price 
      WHERE id=$id";
  } else {
    // INSERT
    $sql = "INSERT INTO schedules 
      (route_name, train_name, departure_station_id, arrival_station_id, departure_time, arrival_time, price)
      VALUES 
      ('$route_name', '$train_name', $dep_station, $arr_station, '$dep_time', '$arr_time', $price)";
  }

  if ($conn->query($sql)) {
    header('Location: Admn_Penjadwalan.html');
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
