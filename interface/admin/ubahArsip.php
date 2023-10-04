<?php
include '../../function/functions.php';

$id = $_GET["id"];
$arsip = query("SELECT * FROM file_arsip, kategori_arsip WHERE file_arsip.kategori=kategori_arsip.id_kategori AND id_arsip='$id'")[0];

if (isset($_POST["formSubmit"])) {
    if (ubahArsip($_POST, $_FILES) > 0) {
        echo '<script>alert("Data Berhasil Diubah")
        document.location.href="arsip.php"</script>';
    } else {
        echo '<script>alert("Data Gagal Diubah")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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

<body>
    <div style="display:flex;" class="popup-background">
        <div class="popup">
            <div class="head">Ubah File Arsip</div>
            <form class="popupWindowForm" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $arsip["id_arsip"] ?>">
                <input type="hidden" name="oldFile" id="oldFile" value="<?= $arsip["file_arsip"]?>">
                <input type="hidden" name="oldKategori" id="oldKategori" value="<?=$arsip["kategori_name"]?>"> 
                <label for="file">
                    <div class="inputFileWrapper">
                        <img src="../../assets/img/uploadIcon.png" alt="">
                        <input value="<?= $arsip["file_arsip"]?>" id="file" type="file" name="fileName" autocomplete="off">
                    </div>
                </label>
                <div class="nameWrapper">
                    <label style="margin-bottom:5px;">Nama Berkas</label>
                    <input value="<?= $arsip["deskripsi"]?>" type="text" name="deskripsi" autocomplete="off" required>
                </div>
                <div class="kategoriWrapper">
                    <label style="margin-bottom:5px;">Kategori Berkas</label>
                    <select name="kategori" id="kategori" required>
                        <option hidden value="<?= $arsip["kategori"]; ?>"><?= $arsip["kategori_name"]; ?></option>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kategori_arsip") or die(mysqli_error($koneksi));
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<option value=$data[id_kategori]>$data[kategori_name]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="windowButton">
                    <input type="submit" name="formSubmit" value="Ubah">
                    <button type="button" id="closeTambah" onclick="document.location.href='arsip.php'">Close</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>