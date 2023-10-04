<?php
require_once '../../function/koneksi.php';
include '../../function/functions.php';

if(isset($_POST["submit"])){
    if(addArsip($_POST, $_FILES)>0){
        echo "
            <script>
            alert('Data Berhasil Ditambahkan');
            document.location.href='arsip.php';
            </script> 
        ";
    }else{
        echo "gagal";
    };
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Arsip</title>
    </head>
    <body>
        <h2>Upload File</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <ul>
                <li>
                    <label>Pilih Berkas</label>
                    <input type="file" name="fileName" autocomplete="off">
                </li>
                <li>
                    <label>Nama Berkas</label>
                    <input type="text" name="deskripsi" autocomplete="off">
                </li>
                <li>
                    <label>Kategori Berkas</label>
                    <select name="kategori" id="kategori">
                    <option hidden>Kategori</option>
                        <?php
                        $query=mysqli_query($koneksi,"SELECT * FROM kategori_arsip") or die (mysqli_error($koneksi));
                        while($data=mysqli_fetch_array($query)){
                            echo "<option value=$data[id_kategori]>$data[kategori_name]</option>";
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <input type="submit" name="submit" value="Upload PDF">
                </li>
            </ul>
        </form>
    </body>
</html> 