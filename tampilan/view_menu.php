<?php
require_once "../koneksi.php";
require_once "../query/menuu.php";

session_start();

$db = (new Database())->connection();
$menu = new Menu($db);

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

if ($keyword) {
    $data = $menu->search($keyword); 
} else {
    $data = $menu->readAll(); 
}

if(isset($_GET['delete'])) {
        $menu->id_menu = $_GET['delete'];
        $menu->delete();
        header("location:view_menu.php");
        exit;
    }
    $data = $menu->readAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Eskrim Happy</title>
  <link rel="icon" type="image/png" href="../gambar/logoeskrimm.png" sizes="16x16" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/menustyle.css">

</head>
<body>
  <header>
    <div class="logo-container">
      <img src="../gambar/logoeskrimm.png" alt="Logo">
      <h2>ESKRIM HAPPY</h2>
    </div>
    <nav>
      <ul>
         <li><a href="beranda.php">Beranda</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="keranjang.php">Keranjang</a></li>
        <li><a href="pembayaran.php">Bayar</a></li>
        <?php if ($_SESSION['role'] === 'admin') : ?>
            <li> <a href="view_menu.php"> Input Menu </a></li>
            <li><a href="view_akunadmin.php">View Akun</a></li>
            <li><a href="riwayat_pembayaran.php">Pembayaran</a></li>
        <?php endif; ?>
        <li><a href="akun.php">Akun</a></li>
        <li><a href="logout.php">Keluar</a></li>
      </ul>
    </nav>
  </header>

  <form method="GET" action="menu.php" class="search-bar">
    <input type="text" name="keyword" placeholder="Cari menu es krim..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" class="search-bar input">
    <button type="submit" class="search-bar button">Cari</button>
  </form>

  <div class="action-buttons">
    <a href="inputmenu.php" class="inputbtn-link"> Input Menu </a>
  </div>

  <br>

  <div class="popup" id="popup">Produk telah ditambahkan ke keranjang!</div>

  <div class="product-list">
    <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)) : ?>

    <div class="product-item">
              <img src="../<?php echo htmlspecialchars($row['gambar_menu']); ?>" alt="<?php echo htmlspecialchars($row['nama_menu']); ?>">
              <div class="product-title"><?php echo htmlspecialchars($row['nama_menu']); ?></div>
              <div class="product-price">Rp<?= number_format($row['harga_menu'], 0, ',', '.') ?></div>
              <button class="add-button">Tambah</button>
              <div class="action-buttons">
              <a href="inputmenu.php?edit=<?php echo $row['id_menu']; ?>" class="btn-link">Edit</a>
              <a href="view_menu.php?delete=<?php echo $row['id_menu']; ?>" class="btn-link"
                onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
              </div>
    </div>
    <?php endwhile; ?>
  
  
  </div>

<br>
  <footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>

</body>
</html>