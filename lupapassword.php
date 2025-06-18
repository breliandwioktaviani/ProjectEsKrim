<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $otp = strval(rand(100000, 999999));

    $_SESSION['otp'] = $otp;
    $_SESSION['email_reset'] = $email;
    $_SESSION['nama_reset'] = $username;

    $mail = new PHPMailer(true);
    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = emailname ;       
        $mail->Password   = password ;           
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

    
        $mail->setFrom( emailname , name );
        $mail->addAddress($email, $username);


        $mail->isHTML(true);
        $mail->Subject = "Kode OTP Verifikasi EsKrim Happy";
        $mail->Body    = "
            Halo <b>$nama</b>,<br><br>
            Kode OTP kamu adalah: <strong>$otp</strong><br><br>
            Jangan bagikan kode ini ke siapa pun.<br><br>
            Salam,<br>Tim EsKrim Happy
        ";

        $mail->send();
        header("Location: otp.php");
        exit;
    } catch (Exception $e) {
        $success = "<span style='color:red;'>Gagal mengirim email OTP. Error: {$mail->ErrorInfo}</span>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - ESKrim Happy</title>
    <link rel="icon" href="../gambar/logoeskrimm.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

                <?php if (!empty($success)): ?>
                    <div class="message"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST">
                    <label for="username">Nama Akun</label>
                    <input type="text" username="username" id="username" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>

                    <div class="form-actions">
                        <input type="submit" value="Kirim Permintaan">
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
