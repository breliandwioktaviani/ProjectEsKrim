<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Beranda - EsKrim Happy</title>
  <link rel="icon" type="image/png" href="../gambar/logoeskrimm.png" sizes="16x16" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/berandastyle.css">
</head>
<body class="beranda-page">
  <header>
    <div class="logo-container">
      <img src="../gambar/logoeskrimm.png" alt="Logo Eskrim Happy">
      <h2>ESKRIM HAPPY</h2>
    </div>
    <nav>
      <ul>
        <li><a href="beranda.php">Beranda</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="keranjang.php">Keranjang</a></li>
        <li><a href="pembayaran.php">Bayar</a></li>
        <?php if ($_SESSION['role'] === 'admin') : ?>
            <li><a href="view_menu.php">Input Menu</a></li>
            <li><a href="view_akunadmin.php">View Akun</a></li>
            <li><a href="riwayat_pembayaran.php">Pembayaran</a></li>
        <?php endif; ?>
        <li><a href="akun.php">Akun</a></li>
        <li><a href="logout.php">Keluar</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <img src="../gambar/gbrhome.jpg" alt="Home Image" class="home-image" />

    <section class="gallery">
      <img src="../gambar/coklat.jpg" alt="Cone Ice Cream">
      <img src="../gambar/vanilla.jpg" alt="Vanilla Ice Cream">
      <img src="../gambar/strobery.jpeg" alt="Strawberry Ice Cream">
    </section>
  </main>

  <footer>
   2025 EsKrim Happy · Lezat dan Enak
  </footer>
</body>
</html>
