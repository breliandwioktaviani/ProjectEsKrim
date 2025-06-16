<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title> Logout </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-image: url('../gambar/bg.png');
            padding: 20px;
        }

        .logout-box {
            max-width: 400px;
            background: white;
            padding: 30px;
            margin: 60px auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }

        .logout-box h2 {
            margin-bottom: 15px;
        }

        .logout-box a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: pink;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: #866042;
        }

        .logout-box a:hover {
            background-color: #866042;
        }
    </style>
</head>
<body>

    <div class="logout-box">
        <h2>Anda telah berhasil logout.</h2>
        <p>Terima kasih telah menggunakan sistem kami.</p>
        <a href="login.php">Login Kembali</a>
    </div>

</body>
</html>