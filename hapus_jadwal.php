<?php
include 'db.php';
if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  $conn->query("DELETE FROM schedules WHERE id = $id");
}
?>
