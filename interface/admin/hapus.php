<?php
    require '../../function/functions.php';
    $id=$_GET["id"];
    
    if(remove($id)>0){
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