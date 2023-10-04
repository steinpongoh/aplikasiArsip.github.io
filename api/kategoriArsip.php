<?php
require_once '../function/koneksi.php';
$myArray=array();
if($query=mysqli_query($koneksi,"SELECT * FROM kategori_arsip   ")){
    while($row = $query->fetch_array(MYSQLI_ASSOC)){
        $myArray[]=$row;
    };
    mysqli_close($koneksi);
    echo json_encode($myArray);
};
?>