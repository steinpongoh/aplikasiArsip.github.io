<?php
require '../../function/functions.php';
require '../../function/koneksi.php';

$queryUser = query("SELECT * FROM user");

if (isset($_POST['tambah'])) {
    if (tambahUser($_POST) > 0) {
        echo "
        <script>
        document.location.href='userData.php';
        </script> 
    ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../../assets/img/Logo-GMIM.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip GMIM</title>
    <link rel="stylesheet" href="../../assets/font/font.css">
    <link rel="stylesheet" href="../../css/admin/userData.css">
    <link rel="stylesheet" href="../../css/page-transition.css">
</head>

<body>
    <div style="width:100%;">
        <button class="addUserButton" id="tambahDataUser" name="tambahDataUser">Tambah</button>
    </div>
    <header class="userHeader">
        <button class="backButton" onclick="document.location='arsip.php'">
            <div></div>
        </button>
        <div class="textContainer">
            <h2>Data User</h2>
        </div>
    </header>
    <div class="userPopupBackground">
        <div class="tambahUser">
            <div class="head">Tambah User</div>
            <form action="" method="POST" enctype="multipart/form-data">
            
                <div class="nameWrapper">
                    <label>Nama Lengkap</label>
                    <input type="text" id="NamaUser" name="NamaUser" autocomplete="off">
                </div>
                <div class="nameWrapper">
                    <label>Username</label>
                    <input type="text" id="username" name="username" autocomplete="off">
                </div>
                <div class="nameWrapper">
                    <label>Password</label>
                    <input type="password" id="password" name="password" autocomplete="off">
                </div>
                <div class="windowButton">
                    <input type="submit" id="tambah" name="tambah" value="Tambah">
                    <button class="closeButton" name="close" id="close">Close</button>
                </div>
            </form>
        </div>
    </div>
    <table class="userTable">
        <thead>
            <td>No</td>
            <td>Nama</td>
            <td>Username</td>
            <td>Password</td>
            <td></td>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($queryUser as $catch) : ?>
            <tbody>
                <td><?= $i; ?></td>
                <td><?= $catch['nama'] ?></td>
                <td><?= $catch['username'] ?></td>
                <td><?= substr($catch['password'], 0, 10) ?>...</td>
                <td>
                    <a href="hapusUser.php?id=<?= $catch["id_user"]; ?>">
                        <div class="removeButton"></div>
                    </a>
                </td>
            </tbody>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    <script src="tambahUser.js"></script>
</body>

</html>