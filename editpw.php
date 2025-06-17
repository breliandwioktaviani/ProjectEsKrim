<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "koneksi.php";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password_baru'];
    $confirm_password = $_POST['konfirmasi_password'];

    if ($new_password !== $confirm_password) {
        $error = "Password dan konfirmasi tidak cocok.";
    } else {
        if (isset($_SESSION['email_reset'])) {
            $email = $_SESSION['email_reset'];
            $password = $new_password; 

            $conn = new mysqli("sql301.infinityfree.com", "if0_39243846", "JMXYJkynjY4JhG", "if0_39243846_db_eskrim");

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE t_pelanggan SET password=? WHERE email=?");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            $stmt->bind_param("ss", $password, $email);

            if ($stmt->execute()) {
                $success = "Password berhasil diupdate!";
                unset($_SESSION['email_reset']);
                session_destroy();
                header("Location: tampilan/login.php"); 
                exit;
            } else {
                $error = "Gagal memperbarui password: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            $error = "Session email tidak ditemukan. Silakan ulangi proses reset.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - EsKrim Happy</title>
    <link rel="icon" href="../gambar/logoeskrimm.png">
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

                <?php
                if (!empty($error)) echo "<div class='error'>$error</div>";
                if (!empty($success)) echo "<div class='success'>$success</div>";
                ?>

                <form method="POST">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" name="password_baru" id="password_baru" required>

                    <label for="konfirmasi_password">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" required>

                    <div class="form-actions">
                    <input type="submit" value="Simpan Password">
                    </div>
                </form>
            </div>
    </div>
</body>
</html>