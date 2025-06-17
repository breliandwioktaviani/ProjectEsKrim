<?php
session_start(); 
require_once "../koneksi.php";
require_once "../query/pelanggan.php";

$database = new Database();
$conn = $database->connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];
 
    $stmt = $conn->prepare("SELECT id_pelanggan, username, password, role FROM t_pelanggan WHERE username = :username");
    $stmt->execute(['username' => $inputUser]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($user && $inputPass === $user['password']) {
        session_regenerate_id(true);
       $_SESSION['id_pelanggan'] = $user['id_pelanggan'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location:beranda.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - EsKrim Happy</title>
    <link rel="icon" href="../gambar/logoeskrimm.png" sizes="16x16">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style1.css">
    <style>
        
    </style>
</head>
<body>
    <body class="login-page">
    <div class="logo">
        <img src="../gambar/logoeskrimm.png" alt="Logo">
        <h1>EsKrim Happy</h1>
    </div>

    <div class="form-container">
        <form method="POST">
            <fieldset>
                <legend>Login</legend>

                <?php if (!empty($error)): ?>
                    <div class="error-message"><?= $error ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan Username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                    </div>
                </div>

                <div class="link-container">
                    <a href="../lupapassword.php">Lupa Password?</a> 
                    <a href="daftar.php">Buat akun baru</a>
                </div>

                <div class="form-actions">
                    <input type="submit" value="Masuk">
                </div>

            </fieldset>
        </form>
    </div>
      
</body>
</html>
