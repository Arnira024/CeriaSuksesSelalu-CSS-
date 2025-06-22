<?php
include 'db.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM schedules WHERE id=$id");
echo "Berhasil dihapus!";
?>
