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
        <button style="margin-left:400px;" id="logoutButton" class="logoutButton" onclick="document.location='../../index.php'">
        <div class="logoutInfo">Logout</div>
        </button>
    </header>


    <!-- DATA TABLE -->

    <div class="left-section">
        <section class="leftSectionHeader">
            <img src="../../assets/img/arsipLogo.png" alt="">
            Arsip
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
                                <td><a class="userView" href="view.php?id=<?= $row["id_arsip"]; ?>"><?php echo $row["deskripsi"]; ?></a></td>
                                <td><?php echo $row["kategori_name"]; ?></td>
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
            <div class="filterHeader"> <img src="../../assets/img/sortingIcon.png" alt=""> Kategori Berkas 
            </div>
            <form class="filterForm" action="" method="post">
                <?php $o = 1; ?>
                <?php foreach ($kategoriBerkas as $catch) : ?>
                    <div class="buttonContainer">
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