<?php
session_start();
include 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['IdUser'])) {
    header("Location: login.php");
    exit();
}

$IdUser = $_SESSION['IdUser'];
$stmt = $conn->prepare("SELECT name, email, phone_number, role, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $IdUser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna - Kereta Api Sulawesi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --biru-tua: #003366;
      --biru-semi-tua: #00509e;
      --biru-medium: #0077cc;
      --biru-muda: #66b2ff;
      --biru-sangat-muda: #cce5ff;
      --biru-super-muda: #e6f2ff;
      --putih: #ffffff;
      --hijau: #28a745;
      --hijau-muda: #4ade80;
      --merah: #dc3545;
      --kuning: #ffc107;
      --shadow: 0 4px 12px rgba(0, 51, 102, 0.15);
      --shadow-hover: 0 6px 16px rgba(0, 83, 161, 0.25);
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e6f2ff, #b3d9ff);
      color: var(--biru-tua);
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 0;
      animation: gradientAnimation 20s ease infinite;
      background-size: 200% 200%;
    }
    
    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    /* Navigation */
    .navbar {
      background: linear-gradient(to right, var(--biru-tua), var(--biru-semi-tua));
      padding: 1rem 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .logo-img {
      height: 50px;
      width: auto;
      background: linear-gradient(45deg, var(--putih), var(--biru-sangat-muda));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: var(--biru-tua);
      padding: 0 15px;
      font-size: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .logo-text {
      color: var(--putih);
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: 1px;
    }
    
    .nav-links {
      display: flex;
      gap: 1.8rem;
      list-style: none;
    }
    
    .nav-links a {
      color: var(--putih);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem 0;
      position: relative;
      transition: all 0.3s;
      cursor: pointer;
      display: flex;
      align-items: center;
      font-size: 1.1rem;
    }
    
    .nav-links a:hover {
      color: var(--biru-muda);
      transform: translateY(-2px);
    }
    
    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 3px;
      background-color: var(--biru-muda);
      transition: width 0.3s;
    }
    
    .nav-links a:hover::after {
      width: 100%;
    }
    
    .nav-links a i {
      margin-right: 8px;
      font-size: 1.2rem;
    }
    
    .logout-btn {
      background: linear-gradient(to right, var(--merah), #e63946);
      padding: 10px 20px;
      border-radius: 30px;
      transition: all 0.3s;
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }
    
    .logout-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }
    
    .menu-toggle {
      display: none;
      flex-direction: column;
      cursor: pointer;
      z-index: 110;
    }
    
    .menu-toggle span {
      height: 3px;
      width: 28px;
      background-color: var(--putih);
      margin: 4px 0;
      transition: all 0.3s;
      border-radius: 2px;
    }
    
    /* Main Content */
    .main-content {
      flex: 1;
      padding: 2rem 5%;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 120px);
    }
    
    .profile-container {
      width: 100%;
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.97);
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
      position: relative;
      display: flex;
      flex-direction: column;
      animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .profile-header {
      background: linear-gradient(135deg, var(--biru-semi-tua), var(--biru-tua));
      padding: 2.5rem 2rem;
      text-align: center;
      color: var(--putih);
      position: relative;
      overflow: hidden;
    }
    
    .profile-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200"><rect width="200" height="200" fill="%23003066" opacity="0.1"/><path d="M30,30 L170,170 M170,30 L30,170" stroke="white" stroke-width="2" opacity="0.1"/></svg>');
      opacity: 0.1;
    }
    
    .profile-avatar-container {
      position: relative;
      display: inline-block;
      margin-bottom: 1.5rem;
    }
    
    .profile-avatar {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid var(--putih);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      background: linear-gradient(135deg, var(--biru-semi-tua), var(--biru-tua));
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 2;
    }
    
    .profile-avatar i {
      font-size: 4rem;
      color: var(--putih);
      opacity: 0.9;
    }
    
    .profile-info {
      position: relative;
      z-index: 1;
    }
    
    .profile-info h1 {
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
      font-weight: 700;
    }
    
    .profile-info p {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 0.5rem;
    }
    
    .profile-badge {
      display: inline-block;
      background: linear-gradient(to right, var(--hijau), #2ecc71);
      color: white;
      padding: 8px 20px;
      border-radius: 30px;
      font-size: 1rem;
      margin-top: 15px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    .train-icon {
      position: absolute;
      bottom: 20px;
      right: 30px;
      font-size: 2.5rem;
      color: rgba(255, 255, 255, 0.25);
      z-index: 0;
    }
    
    .profile-body {
      padding: 2.5rem;
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
    }
    
    .profile-section {
      flex: 1;
      min-width: 280px;
    }
    
    .section-title {
      color: var(--biru-semi-tua);
      font-size: 1.4rem;
      margin-bottom: 1.5rem;
      padding-bottom: 12px;
      border-bottom: 3px solid var(--biru-sangat-muda);
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 600;
    }
    
    .section-title i {
      font-size: 1.3rem;
      background: var(--biru-super-muda);
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--biru-semi-tua);
    }
    
    .detail-row {
      display: flex;
      margin-bottom: 1.2rem;
      padding: 14px;
      border-radius: 12px;
      transition: all 0.3s;
      background: var(--biru-super-muda);
      align-items: center;
    }
    
    .detail-row:hover {
      transform: translateX(5px);
      background: var(--biru-sangat-muda);
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
    }
    
    .detail-label {
      width: 160px;
      font-weight: 600;
      color: var(--biru-semi-tua);
      display: flex;
      align-items: center;
      font-size: 1.1rem;
    }
    
    .detail-label i {
      margin-right: 12px;
      width: 25px;
      text-align: center;
      font-size: 1.2rem;
    }
    
    .detail-value {
      flex: 1;
      color: #333;
      font-weight: 500;
      font-size: 1.1rem;
    }
    
    .edit-btn {
      background: linear-gradient(to right, var(--biru-medium), var(--biru-semi-tua));
      color: white;
      border: none;
      padding: 14px 30px;
      border-radius: 50px;
      cursor: pointer;
      font-size: 1.1rem;
      transition: all 0.3s;
      margin-top: 20px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: var(--shadow);
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .edit-btn:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-hover);
    }
    
    .edit-btn:active {
      transform: translateY(-1px);
    }
    
    /* Footer */
    footer {
      background: linear-gradient(to right, var(--biru-tua), var(--biru-semi-tua));
      color: var(--putih);
      text-align: center;
      padding: 2rem;
      margin-top: auto;
    }
    
    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    
    .footer-links {
      display: flex;
      justify-content: center;
      gap: 2.5rem;
      flex-wrap: wrap;
      margin-bottom: 1.5rem;
    }
    
    .footer-links a {
      color: var(--putih);
      text-decoration: none;
      transition: all 0.3s;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .footer-links a:hover {
      color: var(--biru-muda);
      transform: translateY(-2px);
    }
    
    .footer-info {
      font-size: 1rem;
      opacity: 0.9;
      line-height: 1.7;
    }
    
    .footer-info p {
      margin-bottom: 8px;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
      .profile-body {
        flex-direction: column;
        gap: 2.5rem;
      }
      
      .detail-row {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }
      
      .detail-label {
        width: 100%;
        margin-bottom: 5px;
      }
    }
    
    @media (max-width: 768px) {
      .navbar {
        padding: 0.8rem 5%;
      }
      
      .nav-links {
        position: fixed;
        top: 0;
        left: -100%;
        width: 80%;
        height: 100vh;
        background: linear-gradient(to bottom, var(--biru-tua), var(--biru-semi-tua));
        flex-direction: column;
        align-items: flex-start;
        padding: 100px 30px 30px;
        transition: left 0.4s;
        gap: 1.2rem;
        z-index: 90;
      }
      
      .nav-links.active {
        left: 0;
      }
      
      .menu-toggle {
        display: flex;
      }
      
      .menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
      }
      
      .menu-toggle.active span:nth-child(2) {
        opacity: 0;
      }
      
      .menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
      }
      
      .footer-links {
        flex-direction: column;
        gap: 1.2rem;
      }
      
      .profile-header {
        padding: 1.8rem 1.5rem;
      }
      
      .profile-body {
        padding: 1.8rem;
      }
      
      .nav-links a {
        font-size: 1.2rem;
        padding: 10px 0;
      }
    }
    
    @media (max-width: 480px) {
      .logo-text {
        font-size: 1.2rem;
      }
      
      .profile-info h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-container">
      <img src="navbar.jpg" alt="Logo Kereta Sulsel" class="logo-img" />
    </div>
    
    
    <div class="menu-toggle" id="mobile-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
    
    <ul class="nav-links" id="nav-links">
      <li><a href="beranda.html"><i class="fas fa-home"></i> Beranda</a></li>
      <li><a href="jadwal.html"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
      <li><a href="transaksi.php"><i class="fas fa-receipt"></i> Transaksi</a></li>
      <li><a href="tracking.php"><i class="fas fa-map-marked-alt"></i> Tracking</a></li>
      <li><a href="User_Profil.php" class="active"><i class="fas fa-user"></i> Akun</a></li>
      <li><a href="login.html" onclick="logout()" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-avatar">
          <i class="fas fa-user"></i>
        </div>
        <div class="profile-info">
          <h1><?php echo htmlspecialchars($user['name']); ?></h1>
          <p>Member sejak <?php echo date('d M Y', strtotime($user['created_at'] ?? '2025-06-01')); ?></p>
          <div class="profile-badge">Member Sejuk</div>
        </div>
        <div class="train-icon">
          <i class="fas fa-train"></i>
        </div>
      </div>
      
      <div class="profile-body">
        <div class="profile-section">
          <h2 class="section-title"><i class="fas fa-user-circle"></i> Informasi Pribadi</h2>
          
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-user"></i> Nama Lengkap
            </div>
            <div class="detail-value"><?php echo htmlspecialchars($user['name']); ?></div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-envelope"></i> Email
            </div>
            <div class="detail-value"><?php echo htmlspecialchars($user['email']); ?></div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-phone"></i> No. Telepon
            </div>
            <div class="detail-value"><?php echo htmlspecialchars($user['phone_number']); ?></div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-user-tag"></i> Role
            </div>
            <div class="detail-value"><?php echo htmlspecialchars($user['role']); ?></div>
          </div>
        </div>
        
        <div class="profile-section">
          <h2 class="section-title"><i class="fas fa-ticket-alt"></i> Keanggotaan</h2>
          
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-badge-check"></i> Status
            </div>
            <div class="detail-value">Aktif</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-crown"></i> Tipe Member
            </div>
            <div class="detail-value">Sejuk</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-calendar-day"></i> Tanggal Bergabung
            </div>
            <div class="detail-value"><?php echo date('d M Y', strtotime($user['created_at'] ?? '2025-06-01')); ?></div>
          </div>
          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-star"></i> Poin
            </div>
            <div class="detail-value">125 poin</div>
          </div>
          

          <div class="detail-row">
            <div class="detail-label">
              <i class="fas fa-sign-in-alt"></i> Terakhir Login
            </div>
            <div class="detail-value"><?php echo date('d M Y, H:i') ?> WITA</div>
          </div>
          
          <button class="edit-btn">
            <i class="fas fa-edit"></i> Edit Profil
          </button>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-links">
        <a href="#"><i class="fas fa-info-circle"></i> Tentang Kami</a>
        <a href="#"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a>
        <a href="#"><i class="fas fa-file-contract"></i> Syarat dan Ketentuan</a>
        <a href="#"><i class="fas fa-phone-alt"></i> Hubungi Kami</a>
      </div>
      <div class="footer-info">
        <p>PT Kereta Api Sulawesi Selatan - Menghubungkan Seluruh Sulawesi dengan Layanan Kereta Api Terbaik</p>
        <p>&copy; 2025 PT Kereta Api Sulawesi Selatan. All Rights Reserved.</p>
        <p>Layanan Pelanggan: 24.24.24 | Email: Kareta@gmail.com</p>
      </div>
    </div>
  </footer>

  <script>
    // Mobile menu toggle
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');
    
    mobileMenu.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });

    // Animasi tombol edit
    const editBtn = document.querySelector('.edit-btn');
    if (editBtn) {
      editBtn.addEventListener('mouseenter', () => {
        editBtn.style.transform = 'translateY(-3px)';
      });
      
      editBtn.addEventListener('mouseleave', () => {
        editBtn.style.transform = 'translateY(0)';
      });
    }
  </script>
</body>
</html>