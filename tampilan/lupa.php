<?php
session_start();
require_once "../koneksi.php";

$db = (new Database())->connection();

$error = "";
$sukses = "";

if (!isset($_POST['step'])) {
    $_SESSION['step'] = 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'];

    if ($step === '1') {
        $email = $_POST['email'];
        $stmt = $db->prepare("SELECT * FROM t_pelanggan WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['otp_email'] = $email;
            $_SESSION['otp_code'] = rand(100000, 999999);
            $sukses = "Kode OTP Anda: " . $_SESSION['otp_code'];
            $_SESSION['step'] = 2;
        } else {
            $error = "Email tidak ditemukan!";
        }

    } elseif ($step === '2') {
        $otp_input = $_POST['otp'];
        if ($otp_input == $_SESSION['otp_code']) {
            $_SESSION['step'] = 3;
            $sukses = "OTP berhasil diverifikasi!";
        } else {
            $error = "OTP salah. Coba lagi!";
        }

    } elseif ($step === '3') {
        $password = $_POST['password'];
        $conf = $_POST['konfirmasi'];

        if ($password !== $conf) {
            $error = "Konfirmasi sandi tidak cocok.";
        } else {
            $stmt = $db->prepare("UPDATE t_pelanggan SET password = ? WHERE email = ?");
            $stmt->execute([$password, $_SESSION['otp_email']]);

            $sukses = "Password berhasil diubah. Silakan login kembali.";
            session_destroy();
            header("Location: login.php");
            exit;
        }
    }
}

$currentStep = $_SESSION['step'] ?? 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password - EsKrim Happy</title>
  <link rel="icon" href="../gambar/logoeskrimm.png" sizes="16x16">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/style1.css" />
  <link rel="stylesheet" href="../css/pwstyle.css" />
  <style>
    
  </style>
</head>
<body class="login-page">
    <div class="main-container">
  <div class="logo">
    <img src="../gambar/logoeskrimm.png" alt="Logo">
    <h1>EsKrim Happy</h1>
  </div>

  <div class="form-container">
    <h2 style="text-align:center;">Lupa Password</h2>

    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($sukses): ?>
      <div class="sukses"><?= $sukses ?></div>
    <?php endif; ?>

    <?php if ($currentStep == 1): ?>
      <form method="post">
        <input type="hidden" name="step" value="1">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" required>
        </div>
        <button type="submit">Kirim OTP</button>
      </form>

    <?php elseif ($currentStep == 2): ?>
      <form method="post">
        <input type="hidden" name="step" value="2">
        <div class="form-group">
          <label>Masukkan Kode OTP</label>
          <input type="text" name="otp" maxlength="6" required>
        </div>
        <button type="submit">Verifikasi</button>
      </form>

    <?php elseif ($currentStep == 3): ?>
      <form method="post">
        <input type="hidden" name="step" value="3">
        <div class="form-group">
          <label>Password Baru</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-group">
          <label>Konfirmasi Password</label>
          <input type="password" name="konfirmasi" required>
        </div>
        <button type="submit">Simpan Password</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
