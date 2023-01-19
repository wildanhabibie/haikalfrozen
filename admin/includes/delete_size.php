<?php

    include "db.php";

    //Delete Kategori
    if(isset($_GET['size_id'])){
        $size_id = $_GET['size_id'];

        $delete_size = "DELETE FROM sizes WHERE size_rand = '$size_id'";
        $result_delete = mysqli_query($conn, $delete_size);

        if($result_delete){
            echo "<script>alert('Ukuran Dihapus!')</script>";
            echo "<script>window.open('../index.php?products','_self')</script>";
        }
    }
?>