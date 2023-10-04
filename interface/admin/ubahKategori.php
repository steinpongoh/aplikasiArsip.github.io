<?php
include '../../function/functions.php';
include '../../function/koneksi.php';
$id=$_GET["code"];
$kategori=query("SELECT * FROM kategori_arsip WHERE id_kategori=$id")[0];

if (isset($_POST["kategoriSubmit"])) {
    if (ubahKategori($_POST) > 0) {
        echo "<script>alert('Data Berhasil Diubah')
        document.location.href='arsip.php'</script>";
    } else {
        echo "<script>alert('Data Gagal Diubah')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <head>
        <link rel="icon" href="../../assets/img/Logo-GMIM.png">
        <link rel="stylesheet" href="../../css/page-transition.css">
        <link rel="stylesheet" href="../../css/admin/arsip.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Arsip GMIM</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    </head>

</head>

<body>
    <div style="display:flex;" class="kategoriPopupBackground">
        <div class="kategoriPopupWindow">
            <div class="head">Tambah Kategori</div>
            <form class="popupWindowForm" action=" " method="post">
                <input type="hidden" value="<?= $kategori["id_kategori"]?>" id="id" name="id">
                <div class="nameWrapper">
                    <label style="margin-bottom:5px;">Nama Kategori</label>
                    <input value="<?= $kategori["kategori_name"]?>" type="text" name="kategori_name" id="kategori_name" autocomplete="off" required>
                </div>
                <div class="windowButton">
                    <input type="submit" name="kategoriSubmit" value="Ubah">
                    <button type="button" id="closeKategoriTambah" onclick="document.location.href='arsip.php'">Close</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>