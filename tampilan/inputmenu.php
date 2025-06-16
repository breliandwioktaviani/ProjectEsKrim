<?php
require_once "../koneksi.php";
require_once "../query/menuu.php";

session_start();

$db = (new Database())->connection();
$menu = new Menu($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $menu->id_menu = $_POST['id_menu'] ?? null;
    $menu->nama_menu = $_POST['nama_menu'];
    $menu->harga_menu = $_POST['harga_menu'];

    if (isset($_FILES['gambar_menu']) && $_FILES['gambar_menu']['error'] === UPLOAD_ERR_OK) {
        $namaFile = basename($_FILES['gambar_menu']['name']);
        $tujuan = '../gambar/' . $namaFile;
        move_uploaded_file($_FILES['gambar_menu']['tmp_name'], $tujuan);
        $menu->gambar_menu = 'gambar/' . $namaFile;
    } else {

        $menu->gambar_menu = $_POST['gambar_lama'] ?? '';
    }

    if(!empty($_POST['isEdit'])){
        $menu->update();
    }else {
        $menu->create();
    }
    header("location:view_menu.php");
    exit;
}

$editData = null;

if (isset($_GET['edit'])){
    $editData = $menu->cari($_GET['edit']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title> Input Menu - EsKrim Happy </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleinput.css">
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

    <main class="page-wrapper">
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend> Input Menu </legend>

                <?php if ($editData): ?>
                        <input type="hidden" name="id_menu" value="<?= $editData['id_menu'] ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $editData['gambar_menu'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama"> Nama Menu </label>
                    <input type="text" name="nama_menu" id="nama_menu" value="<?= $editData['nama_menu'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="harga"> Harga Menu </label>
                    <input type="text" name="harga_menu" id="harga_menu" value="<?= $editData['harga_menu'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <?php if ($editData && !empty($editData['gambar_menu'])): ?>
                    <div class="form-group">
                        <label>Gambar Saat Ini:</label><br>
                        <img src="../<?= htmlspecialchars($editData['gambar_menu']) ?>" alt="Gambar Menu" width="150">
                    </div>
                    <?php endif; ?>

                    <label for="gambar"> Gambar Menu </label>
                    <input type="file" accept="gambar/*" name="gambar_menu" id="gambar_menu" value="<?= $editData['gambar_menu'] ?? '' ?>" >
                </div>

                <?php if ($editData): ?>
                    <input type="hidden" name="isEdit" value="1">
                <?php endif; ?>

                <div class="form-actions">
                    <input type="submit" value="<?= $editData ? 'Kirim' : 'Kirim' ?>">
                    <input type="reset" value="Batal">
                </div>
            </fieldset>
        </form>
    </div>
    </main>

<footer>
   2025 EsKrim Happy · Lezat dan Enak
</footer>

</body>
</html>