<?php
include 'db.php';

// Query tabel transactions
$sql = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
