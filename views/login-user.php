<?php
session_start();
require '../function/koneksi.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result=mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result)===1){   
        $row=mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            $_SESSION["login"]=true;
            header("Location: ../interface/user/arsip.php");
        }else{
            echo "<script>alert('Username atau Password Salah');</script>";
        }
    }else{
        echo "<script>alert('Username atau Password Salah');</script>";
    }
} 

?>


<!DOCTYPE html>
<html>

<head>
    <title>Arsip GMIM</title>
    <link rel="icon" href="../assets/img/logo-GMIM.png" type="image/x-icon">
    <!-- TODO: CSS Link -->
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/page-transition.css">
    <!-- TODO: Google Fonts Link -->
    <link rel="stylesheet" href="../assets/font/font.css">
<body>
    <div class="background">
        <div class="card-container">
            <div class="card-login">
                <img src="../assets/img/Logo-GMIM.png">
                <h1 style="color:white; margin-bottom:1%;">Login User</h1>
                <p style="color:white; margin-bottom:12%;">Silahkan Login Untuk Mengakses Arsip</p>
                <form action="" method="post">
                    <input type="text" id="username" name="username" placeholder="Username" autocomplete="off">
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
                    <div class="belowButton">
                        <button class="button"type="submit" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>