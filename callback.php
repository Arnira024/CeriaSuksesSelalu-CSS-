<?php
// callback.php
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validasi signature kalau mau
if ($data['status'] === 'PAID') {
  // Update transaksi di database jadi completed
  include 'db.php';
  $merchant_ref = $data['merchant_ref'];
  $stmt = $conn->prepare("UPDATE transactions SET status='completed' WHERE merchant_ref=?");
  $stmt->bind_param("s", $merchant_ref);
  $stmt->execute();
}
?>
