<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM schedules WHERE id = $id");
    $jadwal = mysqli_fetch_assoc($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_name = $_POST['train_name'];
    $rute = $_POST['rute'];
    $departure_station_id = $_POST['departure_station_id'];
    $arrival_station_id = $_POST['arrival_station_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];

    mysqli_query($conn, "UPDATE schedules SET 
        train_name='$train_name', 
        rute='$rute', 
        departure_station_id='$departure_station_id', 
        arrival_station_id='$arrival_station_id', 
        departure_time='$departure_time', 
        arrival_time='$arrival_time', 
        price='$price' 
        WHERE id=$id");

    header("Location: Admn_Penjadwalan.html");
    exit;
}
?>

<h2>Edit Jadwal</h2>
<form method="POST">
    <label>Nama Kereta</label><br>
    <input type="text" name="train_name" value="<?= $jadwal['train_name'] ?>" required><br>

    <label>Rute</label><br>
    <input type="text" name="rute" value="<?= $jadwal['rute'] ?>" required><br>

    <label>ID Stasiun Keberangkatan</label><br>
    <input type="number" name="departure_station_id" value="<?= $jadwal['departure_station_id'] ?>" required><br>

    <label>ID Stasiun Kedatangan</label><br>
    <input type="number" name="arrival_station_id" value="<?= $jadwal['arrival_station_id'] ?>" required><br>

    <label>Waktu Keberangkatan</label><br>
    <input type="datetime-local" name="departure_time" value="<?= date('Y-m-d\TH:i', strtotime($jadwal['departure_time'])) ?>" required><br>

    <label>Waktu Kedatangan</label><br>
    <input type="datetime-local" name="arrival_time" value="<?= date('Y-m-d\TH:i', strtotime($jadwal['arrival_time'])) ?>" required><br>

    <label>Harga</label><br>
    <input type="number" name="price" value="<?= $jadwal['price'] ?>" required><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
