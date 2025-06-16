<?php
require_once "../koneksi.php";
require_once "../query/pelanggan.php";

session_start();

$db = (new Database())->connection();
$pelanggan = new Pelanggan($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelanggan->id_pelanggan = $_POST['id_pelanggan'] ?? null;
    $pelanggan->email = $_POST['email'];
    $pelanggan->username = $_POST['username'];
    $pelanggan->alamat = $_POST['alamat'];
    $pelanggan->telepon = $_POST['telepon'];
    $pelanggan->password = $_POST['password'];

    if (isset($_FILES['gambar_akun']) && $_FILES['gambar_akun']['error'] === UPLOAD_ERR_OK) {
        $namaFile = basename($_FILES['gambar_akun']['name']);
        $tujuan = '../gambar/' . $namaFile;
        move_uploaded_file($_FILES['gambar_akun']['tmp_name'], $tujuan);
        $pelanggan->gambar_akun = 'gambar/' . $namaFile;
    } else {
        $pelanggan->gambar_akun = $_POST['gambar_lama'] ?? '';
    }

    if (!empty($_POST['isEdit'])) {
        $pelanggan->update();
        header("location:akun.php");
        exit;
    } else {
        $pelanggan->create();
        header("location:login.php");
        exit;
    }
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = $pelanggan->cari($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Akun - EsKrim Happy</title>
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="16x16">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style1.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #EBD3BE;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative; 
            margin-top: 0;
            left: 0;
            right: 0;
            width: 100%;
            margin: 0;
            box-sizing: border-box;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            width: 40px;
        }

        .logo-container h1 {
            font-size: 22px;
            font-weight: bold;
            color: #5A3E2B;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #5A3E2B;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            background-color: #C8A98D;
            color: white;
        }

        footer {
            width: 100%; 
            background-color: #866042;
            color: white;
            text-align: center;
            padding: 10px;
            font-style: italic;
            margin-top: auto; 
        }
    </style>
</head>
<body>

<?php if ($editData): ?>
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
            <li> <a href="view_menu.php"> Input Menu </a></li>
            <li><a href="view_akunadmin.php">View Akun</a></li>
            <li><a href="riwayat_pembayaran.php">Pembayaran</a></li>
        <?php endif; ?>
        <li><a href="akun.php">Akun</a></li>
        <li><a href="logout.php">Keluar</a></li>
      </ul>
    </nav>
  </header>

<?php endif; ?>

<br>
    
<body class="login-page">
    <div class="logo">
        <img src="../gambar/logoeskrimm.png" alt="Logo">
        <h1>EsKrim Happy</h1>
    </div>


<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend><?= $editData ? 'Edit Akun' : 'Daftar Akun' ?></legend>

            <?php if ($editData): ?>
                <input type="hidden" name="id_pelanggan" value="<?= $editData['id_pelanggan'] ?>">
                <input type="hidden" name="gambar_lama" value="<?= $editData['gambar_akun'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?= $editData['email'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $editData['username'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="<?= $editData['alamat'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="telepon">No. Telp</label>
                <input type="tel" name="telepon" id="telepon" value="<?= $editData['telepon'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?= $editData['password'] ?? '' ?>" required>
            </div>

            <?php if ($editData && !empty($editData['gambar_akun'])): ?>
                <div class="form-group">
                    <label>Profil Saat Ini:</label><br>
                    <img src="../<?= htmlspecialchars($editData['gambar_akun']) ?>" width="120">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="gambar_akun">Foto Profil</label>
                <input type="file" name="gambar_akun" id="gambar_akun" accept="image/*">
            </div>

            <?php if ($editData): ?>
                <input type="hidden" name="isEdit" value="1">
            <?php endif; ?>

            <div class="form-actions">
                <input type="submit" value="Kirim" style="width: 100px">
                <input type="reset" value="Batal" style="width: 100px">
            </div>
        </fieldset>
    </form>
</div>

<br>

<?php if ($editData): ?>
<footer>
    @2025 Eskrim Happy - Lezat dan Enak
</footer>
<?php endif; ?>

</body>
</html>
