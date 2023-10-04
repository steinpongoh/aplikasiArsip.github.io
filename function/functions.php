<?php
include 'koneksi.php';

function query($query) {
    global $koneksi;
    $result=mysqli_query($koneksi,$query);
    $rows=[];
    while($row=mysqli_fetch_assoc($result)){
        $rows[]=$row;
    }
    return $rows;
}

function addArsip($data, $file){
    global $koneksi;
    $direktori='../../assets/files/';
    $deskripsi=$data["deskripsi"];
    $kategori=$data["kategori"];
    $fileName=$file["fileName"]["name"];
    move_uploaded_file($file["fileName"]["tmp_name"],$direktori.$fileName);

    $queryAdd="INSERT INTO file_arsip VALUES ('','$deskripsi','$kategori','$fileName')";
    mysqli_query($koneksi, $queryAdd);
    return mysqli_affected_rows($koneksi);
}

function addKategori($data){
    global $koneksi;
    $kategori_name=$data["kategori_name"];
    $queryAddKategori="INSERT INTO kategori_arsip VALUES ('','$kategori_name')";
    mysqli_query($koneksi, $queryAddKategori);
    return mysqli_affected_rows($koneksi);
}

function remove($id){
    global $koneksi;
    mysqli_query($koneksi,"DELETE FROM file_arsip WHERE id_arsip=$id");
}

function removeUser($id){
    global $koneksi;
    mysqli_query($koneksi,"DELETE FROM user WHERE id_user=$id");
}

function removeKategori($id){
    global $koneksi;
    try{
        mysqli_query($koneksi, "DELETE FROM kategori_arsip WHERE id_kategori=$id");
    }catch(Throwable $catchKategoriFatalError){
        echo '<script>alert("Tidak dapat menghapus kategori yang memiliki file arsip di dalamnya")</script>';
    }
    
}

function search($keyword){

    $querySearch="SELECT * FROM `file_arsip`, `kategori_arsip`
    WHERE file_arsip.kategori=kategori_arsip.id_kategori 
    AND deskripsi LIKE '%$keyword%'";

    return query($querySearch);
} 

function tambahUser($data){
    global $koneksi;
    $nama=$data["NamaUser"];
    $username=strtolower(stripslashes($data["username"]));
    $password=mysqli_real_escape_string($koneksi, $data["password"]);
    $password=password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($koneksi, "INSERT INTO user VALUES('','$nama','$username','$password')");
    return mysqli_affected_rows($koneksi);
}

function ubahArsip($data, $file){
    global $koneksi;
    $direktori='../../assets/files/';
    $id=$data["id"];
    $deskripsi=$data["deskripsi"];
    $kategori=$data["kategori"];
    if(isset($_POST["kategori"]) != ""){
        $kategori=$data["kategori"];
    }else{
        $kategori=$data["oldKategori"];
    }

    if(isset($_POST["fileName"])!=""){
        $fileName=$file["fileName"]["name"];
    } else {
        $fileName=$data["oldFile"];
    };


    move_uploaded_file($file["fileName"]["tmp_name"],$direktori.$fileName);
    $queryUbah="UPDATE file_arsip SET deskripsi = '$deskripsi',
                                    kategori = '$kategori',
                                    file_arsip = '$fileName'
                                WHERE id_arsip = '$id'";
    mysqli_query($koneksi, $queryUbah);
    return mysqli_affected_rows($koneksi);
}

function ubahKategori($data){
    global $koneksi;
    $id=$data["id"];
    $kategori_name=$data["kategori_name"];
    $queryAddKategori="UPDATE kategori_arsip SET kategori_name = '$kategori_name' WHERE id_kategori = '$id'";
    mysqli_query($koneksi, $queryAddKategori);
    return mysqli_affected_rows($koneksi);
}
