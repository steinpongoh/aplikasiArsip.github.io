<?php
    
    require '../../function/functions.php';
    $code=$_GET["code"];
    if(removeKategori($code)>0){
        echo "
        <script>
        alert('Data Gagal Dihapus');
        document.location.href='arsip.php';
        </script> 
    ";
    }else{
        echo "
            <script>
            document.location.href='arsip.php';
            </script> 
        ";
    }
?>