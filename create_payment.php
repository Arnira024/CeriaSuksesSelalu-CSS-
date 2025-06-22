<?php
header("Content-Type: application/json");
include 'db.php';

// Tripay API KEY dan Merchant Code
$apiKey = 'ISI_DENGAN_API_KEY_MU';
$merchantCode = 'ISI_DENGAN_MERCHANT_CODE_MU';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

// Ambil transaksi dari DB
$stmt = $conn->prepare("SELECT * FROM transactions WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$payload = [
  'method' => 'DANA',  // bisa OVO, QRIS, dll
  'merchant_ref' => 'INV' . time(),
  'amount' => $row['total'],
  'customer_name' => $row['name'],
  'customer_email' => 'user@example.com',
  'customer_phone' => $row['telp'],
  'order_items' => [
    [
      'sku' => 'TIKET',
      'name' => 'Pembelian Tiket',
      'price' => $row['total'],
      'quantity' => 1
    ]
  ],
  'callback_url' => 'https://domainmu.com/callback.php',
  'return_url' => 'https://domainmu.com/sukses.html'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://tripay.co.id/api/transaction/create");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Authorization: Bearer ".$apiKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
