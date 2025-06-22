<?php
include 'db.php';
$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM schedules WHERE id=$id");
$row = $result->fetch_assoc();
echo json_encode($row);
?>
