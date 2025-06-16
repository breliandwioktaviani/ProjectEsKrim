<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - EsKrim Happy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #fef6f0;
        }

        header {
            background-color: #EBD3BE;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .logo-container h1 {
            font-size: 24px;
            color: #333;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .hero {
            padding: 80px 40px;
            text-align: center;
        }

        .hero h2 {
            font-size: 36px;
            color: #444;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="gambar/logoeskrimm.png" alt="Logo"> 
        <h1>ESKRIM HAPPY</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="tampilan/login.php">Login</a></li>
        </ul>
    </nav>
</header>

<div class="hero">
    <h2>Selamat Datang di ESKRIM HAPPY</h2>
    <p>Temukan berbagai pilihan es krim yang menyegarkan! Mulai dari rasa klasik hingga rasa unik yang menggugah selera. Yuk mulai jelajahi menu kami dan tambahkan es krim favoritmu ke keranjang!</p>
</div>

<footer>
    @2025 Eskrim Happy - Lezat dan Enak
  </footer>
</body>
</html>
