<?php
    require_once "../koneksi.php";
    require_once "../query/pelanggan.php";
    require_once "../query/pembayaranclass.php";

    session_start();

    $db = (new Database())->connection();
    $pelanggan = new Pelanggan($db);

    if(isset($_GET['delete'])) {
        $pelanggan->id_pelanggan = $_GET['delete'];
        $pelanggan->delete();
        header("location:view_akunadmin.php");
        exit;
    }

    $data = $pelanggan->readAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profil - EsKrim Happy</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="20x20" />

    <style>
    
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 30px;
        justify-content: center;
        }

        .pembeli-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 280px;
        padding: 20px;
        transition: transform 0.3s ease;
        }

        .pembeli-card:hover {
        transform: translateY(-5px);
        }

        .pembeli-card h3 {
        margin-bottom: 10px;
        color: #5A3E2B;
        font-size: 20px;
        }

        .pembeli-card p {
        margin: 4px 0;
        color: #333;
        font-size: 14px;
        }

        .pembeli-card p strong {
        color: #866042;
        }

        .action a {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 14px;
        background-color: #EBD3BE;
        color: #5A3E2B;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        }

        .action a:hover {
        background-color: #d3b39a;
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
            <div class="card-container">
                <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="pembeli-card">
                <h3><?php echo $row['username']; ?></h3>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Telepon:</strong> <?php echo $row['telepon']; ?></p>
                <p><strong>Alamat :</strong> <?php echo $row['alamat']; ?></p>
                <div class="action">
                    <a href="view_akunadmin.php?delete=<?php echo $row['id_pelanggan']; ?>" onclick="return confirm('Yakin ingin menghapus pembeli ini?')">Hapus</a>
                </div>
                </div>
            <?php endwhile; ?>
            </div>
        </main>
    </div>
    <footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>
</body>
</html>