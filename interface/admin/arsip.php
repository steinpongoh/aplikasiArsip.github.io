<?php
session_start();
include '../../function/koneksi.php';
include '../../function/functions.php';

$jumlahDataPerHalaman = 8;
$jumlahData = count(query("SELECT * FROM file_arsip, kategori_arsip WHERE file_arsip.kategori=kategori_arsip.id_kategori"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$jumlahLink = 2;
if ($halamanAktif > $jumlahLink) {
    $startNumber = $halamanAktif - $jumlahLink;
} else {
    $startNumber = 1;
}

if ($halamanAktif < ($jumlahHalaman - $jumlahLink)) {
    $endNumber = $halamanAktif + $jumlahLink;
} else {
    $endNumber = $jumlahHalaman;
}



$berkas = query("SELECT * FROM file_arsip, kategori_arsip WHERE file_arsip.kategori=kategori_arsip.id_kategori LIMIT $awalData,
$jumlahDataPerHalaman");
$kategoriBerkas = query("SELECT * FROM kategori_arsip");

$indexKategori = count(query("SELECT id_kategori FROM kategori_arsip"));
$jumlahDataKategori = array();


if (isset($_POST["searchButton"])) {
    $berkas = search($_POST['keyword']);
}
if (isset($_POST["reset"])) {
    $berkas = query("SELECT * FROM file_arsip, kategori_arsip WHERE file_arsip.kategori=kategori_arsip.id_kategori LIMIT $awalData, $jumlahDataPerHalaman");
} elseif (!isset($_SESSION["login"])) {
    header("Location:login-admin.php");
    exit;
} elseif (isset($_POST["formSubmit"])) {
    if (addArsip($_POST, $_FILES) > 0) {
        echo "
            <script>
            document.location.href='arsip.php';
            </script> 
        ";
    };
}

for ($i = 1; $i <= $indexKategori; $i++) {
    $castLoopIndex = (string)$i;
    $kategori = "kategori$castLoopIndex";
    if (isset($_POST["$kategori"])) {
        $berkas = query("SELECT * FROM file_arsip, kategori_arsip 
            WHERE file_arsip.kategori=kategori_arsip.id_kategori
            AND kategori='$castLoopIndex'");
    }

    $jumlahDataKategori[] = count(query("SELECT * FROM file_arsip, kategori_arsip 
        WHERE file_arsip.kategori=kategori_arsip.id_kategori
        AND kategori='$castLoopIndex'"));
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Arsip GMIM</title>
    <link rel="icon" href="../../assets/img/Logo-GMIM.png">
    <link rel="stylesheet" href="../../assets/font/font.css">
    <link rel="stylesheet" href="../../css/admin/arsip.css">
    <link rel="stylesheet" href="../../css/page-transition.css">
</head>

<body>
    <header class="arsipPageHeader">
        <div class="headerLogo"></div>
        <form action="" method="post">
            <div class="searchContainer">
                <input class="search" type="text" id="keyword" name="keyword" placeholder="Pencarian Surat Keterangan,Notulen,Laporan....." autocomplete="off">
                <button class="resetButton" type="submit" id="reset" name="reset"></button>
                <button class="searchButton" type="submit" id="searchButton" name="searchButton"></button>
            </div>
        </form>
        <button id="addUserButton" class="addUserButton" onclick="document.location='userData.php'">
        <div class="userInfo">Tambah Akun User</div>
        </button>
        <button id="logoutButton" class="logoutButton" onclick="document.location='../../index.php'">
        <div class="logoutInfo">Logout</div>
        </button>
    </header>

    <!-- POPUP WINDOW : Tambah arsip -->
    <div class="popup-background">
        <div class="popup">
            <div class="head">Upload File Arsip</div>
            <form class="popupWindowForm" action="" method="post" enctype="multipart/form-data">
                <label for="file">
                    <div class="inputFileWrapper">
                        <img src="../../assets/img/uploadIcon.png" alt="">
                        <input id="file" type="file" name="fileName" autocomplete="off" required>
                    </div>
                </label>
                <div class="nameWrapper">
                    <label style="margin-bottom:5px;">Nama Berkas</label>
                    <input type="text" name="deskripsi" autocomplete="off" required>
                </div>
                <div class="kategoriWrapper">
                    <label style="margin-bottom:5px;">Kategori Berkas</label>
                    <select name="kategori" id="kategori" required>
                        <option hiddens>Kategori</option>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kategori_arsip") or die(mysqli_error($koneksi));
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<option value=$data[id_kategori]>$data[kategori_name]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="windowButton">
                    <input type="submit" name="formSubmit" value="Upload PDF">
                    <button id="closeTambah">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- POPUP WINDOW : Tambah kategori -->
    <?php
    if (isset($_POST["kategoriSubmit"])) {
        if (addKategori($_POST) > 0) {
            echo "
                    <script>
                        document.location.href='arsip.php';
                    </script>
                ";
        }
    };
    ?>
    <div class="kategoriPopupBackground">
        <div class="kategoriPopupWindow">
            <div class="head">Tambah Kategori</div>
            <form class="popupWindowForm" action="" method="post" enctype="multipart/form-data">
                <div class="nameWrapper">
                    <label style="margin-bottom:5px;">Nama Kategori</label>
                    <input type="text" name="kategori_name" autocomplete="off" required>
                </div>
                <div class="windowButton">
                    <input type="submit" name="kategoriSubmit" value="Tambah">
                    <button id="closeKategoriTambah">Close</button>
                </div>
            </form>
        </div>
    </div>


    <!-- DATA TABLE -->

    <div class="left-section">
        <section class="leftSectionHeader">
            <img src="../../assets/img/arsipLogo.png" alt="">
            Arsip
            <button class="addButton" id="tambah" name="tambah"">
                <div></div>
            </button>
        </section>
        <table style=" border-collapse:collapse;">
                <tr class="thead">
                    <td>No</td>
                    <td>Nama File</td>
                    <td>Kategori File</td>
                    <td></td>
                </tr>
                <?php if (count($berkas) >= 1) : ?>
                    <?php $i = 1 + $awalData; ?>
                    <?php foreach ($berkas as $row) : ?>
                        <tbody>
                            <tr class="tbody">
                                <td><?= $i; ?></td>
                                <td><a class="viewLink" href="view.php?id=<?= $row["id_arsip"]; ?>"><?php echo $row["deskripsi"]; ?></a></td>
                                <td><?php echo $row["kategori_name"]; ?></td>
                                <td>
                                    <a href="hapus.php?id=<?= $row["id_arsip"]; ?>">
                                        <div class="removeButton"></div>
                                    </a>
                                    <a href="ubahArsip.php?id=<?= $row["id_arsip"]; ?>">
                                        <div class="ubahButton"></div>
                                    </a>
                                </td>
                                </a>
                            </tr>
                        </tbody>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tbody style="height:40px; font-size: 15px; font-weight:300; background-color:rgb(221, 221, 221);">
                        <td> </td>
                        <td> </td>
                        <td>Data Tidak Ditemukan</td>
                        <td> </td>
                    </tbody>
                <?php endif; ?>
                </table>
                <div class="tablePage">
                    <section>
                        <?php if ($halamanAktif > 1) : ?>
                            <a href="?page=<?= $halamanAktif - 1; ?>" style="text-decoration:none;">
                                <div class="pageButtonNextAndPrevious">Previous</div>
                            </a>
                        <?php endif; ?>
                    </section>
                    <section>
                        <?php for ($i = $startNumber; $i <= $endNumber; $i++) : ?>
                            <?php if ($i == $halamanAktif) : ?>
                                <a href="?page=<?= $i ?>" style="color:red;"><button class="paginationActive"><?= $i; ?></button></a>
                            <?php else : ?>
                                <a href="?page=<?= $i ?>"><button class="pagination"><?= $i; ?></button></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </section>
                    <section>
                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <a href="?page=<?= $halamanAktif + 1; ?>" style="text-decoration:none;">
                                <div class="pageButtonNextAndPrevious">Next</div>
                            </a>
                        <?php endif; ?>
                    </section>
                </div>
    </div>

    <section class="rightSection">
        <div class="filterDashboard">
            <div class="filterHeader"> <img src="../../assets/img/sortingIcon.png" alt=""> Kategori Berkas <button class="addFilterButton" id="tambahKategori" name="tambahKategori">
                    <div></div>
                </button>
            </div>
            <form class="filterForm" action="" method="post">
                <?php $o = 1; ?>
                <?php foreach ($kategoriBerkas as $catch) : ?>
                    <div class="buttonContainer">
                    <a href="hapusKategori.php?code=<?=$catch["id_kategori"]?>"><div class="remove"></div></a>
                    <a href="ubahKategori.php?code=<?=$catch["id_kategori"]?>"><div class="userEdit"></div></a>
                        <button class="kategoriButton" name="kategori<?= $o?>" id="kategori<?= $o ?>">
                            <?= $catch["kategori_name"] ?>
                            <div class="dataText"><?php echo $jumlahDataKategori[$o - 1] ?> files found</div>
                        </button>
                        <?php $o++ ?>
                    </div>
                <?php endforeach; ?>
            </form>
        </div>
    </section>
    <script src="arsip.js"></script>
</body>

</html>