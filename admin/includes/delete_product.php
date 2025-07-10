<?php

    include "db.php";

    //Delete Kategori
    if(isset($_GET['pro_id'])){
        $product_id = $_GET['pro_id'];

        //  untuk menghapus gambar
        $select_img = "SELECT * FROM products WHERE id = '$product_id'";
        $result_img = mysqli_query($conn, $select_img);
        $row = mysqli_fetch_array($result_img);

        // hapus gambar
        unlink("../assets/images/products/".$row['product_image']);
        unlink("../assets/images/products/".$row['product_image1']);
        unlink("../assets/images/products/".$row['product_image2']);
        unlink("../assets/images/products/".$row['product_image3']);

         $delete_product = "DELETE FROM products WHERE id='$product_id'";
        $result_delete = mysqli_query($conn, $delete_product);

        if($result_delete){
            echo "<script>alert('Produk Dihapus!')</script>";
            echo "<script>window.open('../index.php?products', '_self')</script>";
        }
    }
?>