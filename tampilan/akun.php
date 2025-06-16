<?php
    require_once "../koneksi.php";
    require_once "../query/pelanggan.php";
    session_start();

    $db = (new Database())->connection();
    $pelanggan = new Pelanggan($db);

    if(isset($_GET['delete'])) {
        $pelanggan->id_pelanggan = $_GET['delete'];
        $pelanggan->delete();
        header("location:akun.php");
        exit;
    }

    $data = $pelanggan->readById($_SESSION['id_pelanggan']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun - EsKrim Happy</title>
    <link rel="stylesheet" href="../css/akunstyle.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="20x20">

    <style>
        .nav-horizontal {
    display: flex;
    gap: 3px;
    list-style: none;
    padding: 0;
    margin-right: 59px;
    flex-wrap: nowrap;
    white-space: nowrap;
}

  .add-button {
    margin-top: 10px;
    background-color: #A06A42;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
  }

  .btn-link {
  color: white;
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 20px;
  font-size: 16px; 
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.btn-link:hover {
  background-color: #A06A42;
}s

.inputbtn-link {
  background-color: #A06A42;
  color: white;
  text-decoration: none;
  padding: 15px 25px;
  border-radius: 20px;
  font-size: 16px; 
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.kotak_akun {
    border: 1px solid #ccc;
    padding: 8px;
    padding-left: 40px;
    margin-top: 8px;
    margin-bottom: 15px;
    margin-left: 20px;
    margin-right: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    color: black;
  }

.info-profil {
    padding: 8px;
    padding-left: 20px;
    margin-top: 8px;
    margin-bottom: 15px;
    color: black;
    font-weight: bold;
  
  }

  .profil {
     display: flex;
     flex-direction: column;
     align-items: center; 
     margin: 20px 0;
  }
  
    </style>
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
            <li><a href="view_menu.php"> Input Menu </a></li>
            <li><a href="view_akunadmin.php">View Akun</a></li>
            <li><a href="riwayat_pembayaran.php">Pembayaran</a></li>
        <?php endif; ?>
        <li><a href="akun.php">Akun</a></li>
        <li><a href="logout.php">Keluar</a></li>
      </ul>
    </nav>
  </header>

        <main class="content">
                <h1 style="text-align : center; margin-left: 15px"> AKUN </h1>
            <section>
                <?php if ($row = $data->fetch(PDO::FETCH_ASSOC)) : ?>
                  <div class ="info">
                    <div class="profil">
                        <img src="../<?php echo htmlspecialchars($row['gambar_akun']); ?>" alt="<?php echo htmlspecialchars($row['id_pelanggan']); ?>" class="avatar">
                        <div class="add-button">
                            <a href="daftar.php?edit=<?php echo $row['id_pelanggan']; ?>" class="btn-link"> EDIT PROFIL </a>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div>
                        <label for="username" class="info-profil">Nama Akun</label> <br>
                        <div class="kotak_akun" id="username"><?php echo htmlspecialchars($row['username']); ?></div>
                    </div>
                    <div>
                        <label for="email" class="info-profil">Email</label>
                        <div class="kotak_akun" id="email"><?php echo htmlspecialchars($row['email']); ?></div>
                    </div>

                    <div>
                        <label for="telepon" class="info-profil">No HP</label>
                        <div class="kotak_akun" id="telepon"><?php echo htmlspecialchars($row['telepon']); ?></div>
                    </div>
                    <div>
                        <label for="alamat" class="info-profil">Alamat</label>
                        <div class="kotak_akun" id="alamat"><?php echo htmlspecialchars($row['alamat']); ?></div>
                    </div>
                <?php else: ?>
                    <p>Data tidak ditemukan.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <footer>
      @2025 Eskrim Happy - Lezat dan Enak
    </footer>
</body>
</html>