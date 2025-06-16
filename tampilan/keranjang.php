<?php
session_start();

if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit;
}

require_once "../koneksi.php";
require_once "../query/keranjangclass.php";

$id_pelanggan = $_SESSION['id_pelanggan'];
$db = (new Database())->connection();
$keranjang = new Keranjang($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'] ?? null;

    // AJAX dari daftarmenu.php
    if (!isset($_POST['aksi']) && $id_menu) {
        $berhasil = $keranjang->add($id_pelanggan, $id_menu);
        if ($berhasil) {
            echo "Berhasil ditambahkan ke keranjang";
        } else {
            echo "Gagal menambahkan ke keranjang";
        }
        exit;
    }

    // Penanganan aksi tambah/kurang/hapus dari halaman keranjang
    if (isset($_POST['aksi']) && $id_menu) {
        $aksi = $_POST['aksi'];

        if ($aksi === 'hapus') {
            $keranjang->delete($id_pelanggan, $id_menu);
        } else {
            $stmt = $keranjang->getByUser($id_pelanggan);
            while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($item['id_menu'] == $id_menu) {
                    $jumlah_menu = $item['jumlah_menu'];
                    if ($aksi === 'tambah') {
                        $jumlah_menu++;
                    } elseif ($aksi === 'kurang' && $jumlah_menu > 1) {
                        $jumlah_menu--;
                    }
                    $keranjang->updateJumlah($id_pelanggan, $id_menu, $jumlah_menu);
                    break;
                }
            }
        }
        header("Location: keranjang.php");
        exit;
    }
    echo "Request tidak valid";
    exit;
}
$stmt = $keranjang->getByUser($id_pelanggan);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang - EsKrim Happy</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/keranjangstyle.css" />
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="20x20" />
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

            <main>
                <h1>Keranjang</h1>
                <?php 
                    $totalSemua = 0;
                    foreach ($items as $item): 
                    $subtotal = $item['harga_menu'] * $item['jumlah_menu'];
                    $totalSemua += $subtotal;
                ?>
                    <div class="keranjang-item">
  <img src="../<?= htmlspecialchars($item['gambar_menu']) ?>" width="80" alt="<?= htmlspecialchars($item['nama_menu']) ?>" />

  <div class="info-keranjang">
    <strong><?= htmlspecialchars($item['nama_menu']) ?></strong><br>
    
    <form method="POST" style="display:inline-block;">
        <input type="hidden" name="id_menu" value="<?= $item['id_menu'] ?>">
        <button type="submit" name="aksi" value="kurang">-</button>
    </form>
    <span><?= (int)$item['jumlah_menu'] ?></span>
    <form method="POST" style="display:inline-block;">
        <input type="hidden" name="id_menu" value="<?= $item['id_menu'] ?>">
        <button type="submit" name="aksi" value="tambah">+</button>
    </form>

    <br />
    Subtotal: Rp<?= number_format($subtotal, 0, ',', '.') ?>
  </div>

  <form method="POST" class="hapus-form">
    <input type="hidden" name="id_menu" value="<?= $item['id_menu'] ?>">
    <button type="submit" name="aksi" value="hapus" onclick="return confirm('Yakin ingin menghapus item ini dari keranjang?')">Hapus</button>
  </form>
</div>

                <?php endforeach; ?>
                <div class="checkout-container">
    <div class="checkout-box">
        <strong>Total: Rp<?= number_format($totalSemua, 0, ',', '.') ?></strong>
        <form action="pembayaran.php" method="GET">
            <button type="submit" class="checkout-btn">Checkout Sekarang</button>
        </form>
    </div>
</div>

            </main>
        </div>
    </div>

      <footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>
</body>
</html>