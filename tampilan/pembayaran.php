<?php
session_start();
require_once "../koneksi.php";
require_once "../query/keranjangclass.php";
require_once "../query/pembayaranclass.php";
require_once "../query/pelanggan.php";


$db = (new Database())->connection();
$id_pelanggan = $_SESSION['id_pelanggan'];
$pelanggan = new Pelanggan($db);

$keranjang = new Keranjang($db);
$stmt = $keranjang->getByUser($id_pelanggan);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pembayaran = new Pembayaran($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $metode = $_POST['metode'] ?? '';

    // Hitung total seluruh belanja
    $totalCheckout = 0;
    foreach ($items as $item) {
        $totalCheckout += $item['harga_menu'] * $item['jumlah_menu'];
    }

    // Buat transaksi utama dan ambil idtransaksi
    $id_pembayaran = $pembayaran->createMainPembayaran($id_pelanggan, $totalCheckout);

    // Simpan semua item ke tabel transaksi_detail
    foreach ($items as $item) {
    $pembayaran->addDetail(
        $id_pembayaran,
        $item['id_menu'],
        $item['jumlah_menu'],
        $item['harga_menu']
    );
}


    // Hapus isi keranjang setelah checkout
    $db->prepare("DELETE FROM t_keranjang WHERE id_pelanggan = ?")->execute([$id_pelanggan]);

    header("Location: beranda.php?status=checkout_berhasil");
    exit;
}

$data = $pelanggan->readById($_SESSION['id_pelanggan']);
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> Pembayaran - EsKrim Happy </title>
   <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/pembayaranstyle.css" />
  <link rel="icon" href="../gambar/logoeskrimm.png" sizes="20x20" />
  <style>
    
  </style>
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

    <main class="content">
      <h1>PEMBAYARAN</h1>
      <div class="checkout-container">
        <section id="checkout-items">
          <section class="checkout-list">
  <?php
  $totalCheckout = 0;
  foreach ($items as $item):
    $subtotal = $item['harga_menu'] * $item['jumlah_menu'];
    $totalCheckout += $subtotal;
  ?>
  
  <?php endforeach; ?>
</section>
        </section>

        <div class="summary">
    <h3>Ringkasan Pesanan:</h3>
    <?php foreach ($items as $item): ?>
      <p><?= $item['jumlah_menu'] ?> x <?= htmlspecialchars($item['nama_menu']) ?> = Rp <?= number_format($item['jumlah_menu'] * $item['harga_menu'], 0, ',', '.') ?></p>
    <?php endforeach; ?>
    <p><strong>Total: Rp <?= number_format($totalCheckout, 0, ',', '.') ?></strong></p>
  </div>

        <?php if ($row = $data->fetch(PDO::FETCH_ASSOC)) : ?>
        <form class="payment-form" method="POST">
          <label for="nama">Nama Lengkap</label>
         <input type="text" id="username" name="username" required value="<?= htmlspecialchars($row['username'] ?? '') ?>" />

          <label for="alamat">Alamat Pengiriman</label>
         <input type="text" id="alamat" name="alamat" required value="<?= htmlspecialchars($row['alamat'] ?? '') ?>"/>

          <label for="metode">Metode Pembayaran</label>
          <select id="metode" name="metode" required>
            <option value="">--Pilih Metode--</option>
            <option value="cod">COD (Bayar di Tempat)</option>
            <option value="transfer">Transfer Bank</option>
          </select>

          <button type="submit" class="pay-btn">Bayar Sekarang</button>

        </form>
      </div>
      <?php else: ?>
                    <p>Data tidak ditemukan.</p>
                <?php endif; ?>
    </main>

    <footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>
</body>
  </html>