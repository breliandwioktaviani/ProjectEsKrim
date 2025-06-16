<?php
    require_once "../koneksi.php";
    require_once "../query/pelanggan.php";
    require_once "../query/pembayaranclass.php";

    session_start();

    $db = (new Database())->connection();

    $pembayaran = new Pembayaran($db);
    $pembayaran = $pembayaran->readAllPembayaranWithDetails();
    $pelanggan = new Pelanggan($db);

    if(isset($_GET['delete'])) {
        $pelanggan->id_pelanggan = $_GET['delete'];
        $pelanggan->delete();
        header("location:riwayat_pembayaran.php");
        exit;
    }

    $data = $pelanggan->readAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran - EsKrim Happy</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="20x20" />

    <style>
        .pembayaran-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 30px;
            justify-content: center;
        }

        .pembayaran-card {
            background-color: #fffdf8;
            border: 2px solid #f2e3d5;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            width: 300px;
            transition: transform 0.3s ease;
        }

        .pembayaran-card:hover {
            transform: scale(1.02);
        }

        .pembayaran-card h3 {
            margin-top: 0;
            color: #6b3e26;
        }

        .pembayaran-card p {
            margin: 6px 0;
            color: #333;
            font-size: 14px;
        }

        .menu-item {
            background-color: #fdf1e6;
            padding: 8px;
            margin: 6px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #444;
        }

        .total-harga {
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #a85b27;
            text-align: right;
        }

    </style>
</head>
<body onscroll="console.log(document.body.scrollLeft)">
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
    <div class="pembayaran-container">
    <?php 
    $grouped = [];
    while ($row = $pembayaran->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id_pembayaran'];
        if (!isset($grouped[$id])) {
            $grouped[$id] = [
                'nama' => $row['nama'],
                'items' => [],
                'total' => 0
            ];
        }
        $grouped[$id]['items'][] = [
            'nama_menu' => $row['nama_menu'],
            'jumlah_menu' => $row['jumlah_menu'],
            'hargasaatitu' => $row['hargasaatitu'],
            'subtotal' => $row['subtotal']
        ];
        $grouped[$id]['total'] += $row['subtotal'];
    }

    foreach ($grouped as $id => $data):
    ?>
      <div class="pembayaran-card">
        <h3>ID Transaksi: <?= $id ?></h3>
        <p><strong>Pembeli:</strong> <?= htmlspecialchars($data['nama']) ?></p>
        <?php foreach ($data['items'] as $item): ?>
          <div class="menu-item">
            <?= htmlspecialchars($item['nama_menu']) ?> - <?= $item['jumlah_menu'] ?> x Rp.<?= number_format($item['hargasaatitu'], 0, ',', '.') ?> <strong>Rp.<?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
          </div>
        <?php endforeach; ?>
        <div class="total-harga">Total: Rp.<?= number_format($data['total'], 0, ',', '.') ?></div>
      </div>
    <?php endforeach; ?>
    </div>
</main>

    </div>
    <footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>
</body>
</html>