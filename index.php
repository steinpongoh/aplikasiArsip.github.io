<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Arsip GMIM</title>
    <link rel="icon" href=" assets/img/logo-GMIM.png" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/page-transition.css">
    <link rel="stylesheet" href="assets/font/font.css">
</head>

<body>
    <div class="background">
        <header>
            <img src="../assets/img/logoGMIM.png" alt="">
        </header>
        <div class="page-container">
            <section class="select-login">
                <div>
                    <h2 style="font-size: 185%;">Sistem Pengarsipan Digital</h2>
                    <p>Bidang Data, Informatika dan Litbang Sinode GMIM</p>
                </div>
                <div class="buttonContainer">
                        <button onclick="window.location.href='views/login-admin.php'">Login Admin</button>
                        <button onclick="window.location.href='views/login-user.php'">Login User</button>
                </div>
            </section>
        </div>
    </div>
</body>

</html>