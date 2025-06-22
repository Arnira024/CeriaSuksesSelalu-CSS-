<?php
include 'db.php';
$result = $conn->query("SELECT * FROM schedules");
$jadwal = [];
while ($row = $result->fetch_assoc()) {
  $jadwal[] = $row;
}
echo json_encode($jadwal);
?>
