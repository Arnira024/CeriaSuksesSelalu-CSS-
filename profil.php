<?php
session_start();
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo "Anda belum login.";
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

$user = $result->fetch_assoc();
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const name = <?php echo json_encode($user['name']); ?>;
  const email = <?php echo json_encode($user['email']); ?>;
  const phone = <?php echo json_encode($user['phone']); ?>;
  const gender = <?php echo json_encode($user['gender']); ?>;
  const dob = <?php echo json_encode($user['dob']); ?>;
  const createdAt = <?php echo json_encode(date("d F Y", strtotime($user['created_at']))); ?>;

  document.getElementById("profileName").textContent = name;
  document.getElementById("viewFullName").textContent = name;
  document.getElementById("viewEmail").textContent = email;
  document.getElementById("viewPhone").textContent = phone;
  document.getElementById("viewGender").textContent = gender;
  document.getElementById("viewDob").textContent = new Date(dob).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'});
  document.getElementById("joinDate").textContent = createdAt;

  document.getElementById("editFullName").value = name;
  document.getElementById("editEmail").value = email;
  document.getElementById("editPhone").value = phone;
  document.getElementById("editGender").value = gender;
  document.getElementById("editDob").value = dob;
});
</script>
