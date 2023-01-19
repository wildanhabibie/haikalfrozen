<?php

    include "db.php";

    //Delete Kategori
    if(isset($_GET['jenis_id'])){
        $jenis_id = $_GET['jenis_id'];

        $delete_jenis = "DELETE FROM jenis WHERE jenis_rand = '$jenis_id'";
        $result_delete = mysqli_query($conn, $delete_jenis);

        if($result_delete){
            echo "<script>alert('Jenis Dihapus!')</script>";
            echo "<script>window.open('../index.php?products','_self')</script>";
        }
    }
?>