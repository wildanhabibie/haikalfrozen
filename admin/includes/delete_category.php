<?php

    include "db.php";

    //Delete Kategori
    if(isset($_GET['delete_cat'])){
        $category_id = $_GET['delete_cat'];

        $delete_category = "DELETE FROM category WHERE id='$category_id'";
        $result_delete = mysqli_query($conn, $delete_category);

        if($result_delete){
            echo "<script>alert('Kategori Dihapus!')</script>";
            echo "<script>window.open('../index.php?category', '_self')</script>";
        }
    }
?>