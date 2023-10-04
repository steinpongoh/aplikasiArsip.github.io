<?php
require '../../function/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip GMIM</title>
    <link rel="stylesheet" href="../../css/admin/view.css">
    <link rel="icon" href="../../assets/img/Logo-GMIM.png" type="image/x-icon">
</head>
<body>
    <div>
        <?php
            require '../../function/koneksi.php';
            $kode_dokumen=$_GET['id'];
            $query=mysqli_query($koneksi,"SELECT * FROM file_arsip WHERE file_arsip.id_arsip='$kode_dokumen' ORDER BY file_arsip.id_arsip ASC");
            while($b=mysqli_fetch_array($query)){
        ?>
            <embed src="../../assets/files/<?php echo $b['file_arsip']?>">
        <?php
            }
        ?>
    </div>
</body>
</html>