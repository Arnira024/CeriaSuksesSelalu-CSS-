<?php
include 'db.php';

$sql = "SELECT t.id, s.train_name, s.departure_time, p.amount, p.method, p.status, p.ticket_id, p.amount as total, COUNT(t.id) as quantity
  FROM tickets t
  JOIN schedules s ON t.schedule_id = s.id
  JOIN payments p ON t.id = p.ticket_id
  GROUP BY p.ticket_id
  ORDER BY p.paid_at DESC";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
