<?php
    require '../../function/functions.php';
    $id=$_GET["id"];
    
    if(removeUser($id)>0){
        echo "
            <script>
            alert('Data Gagal Dihapus');
            document.location.href='userData.php';
            </script> 
        ";
    }else{
            echo "
                <script>
                document.location.href='userData.php';
                </script> 
            ";
    }
?>