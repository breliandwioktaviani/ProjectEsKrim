<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_otp = htmlspecialchars($_POST['otp']);

    $otp_asli = $_SESSION['otp'] ?? '123456';

    if ($input_otp === $otp_asli) {
        header("Location: editpw.php");
        exit;
    } else {
        $error = "Kode OTP salah atau sudah kadaluarsa.";
    }
}

if (!isset($_SESSION['otp'])) {
    $_SESSION['otp'] = '123456'; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP - EsKrim Happy</title>
    <link rel="icon" href="./gambar/logoesrimm.png">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="../css/pwstyle.css">
    <style>
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .form-actions input {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #866042;
            color: white;
            cursor: pointer;
            font-size: 13px;
        }

        .form-actions input:hover {
            background-color: #705132;
        }
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

                <?php if (!empty($error)): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <label for="otp">Kode OTP</label>
                    <input type="text" name="otp" id="otp" maxlength="6" required placeholder="Masukkan 6 digit kode">

                    <div class="form-actions">
                    <input type="submit" value="Verifikasi">
                    </div>
                </form>
            </div>
    </div>
</body>
</html>