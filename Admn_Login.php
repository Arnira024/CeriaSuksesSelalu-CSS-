<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi user admin
    if ($email === 'admin@kai.co.id' && $password === 'admin123') {
        // Simpan session
        $_SESSION['admin'] = true;

        // Redirect ke halaman dashboard admin (misalnya Admn_Beranda.html)
        header("Location: Admn_Beranda.html");
        exit;
    } else {
        // Salah, kirim alert & redirect balik ke login
        echo "<script>
            alert('Username atau sandi salah!');
            window.location.href = 'Admn_Login.html';
        </script>";
        exit;
    }
} else {
    // Jika akses langsung tanpa POST
    header("Location: Admn_Login.html");
    exit;
}
?>
