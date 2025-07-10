<?php

// menghapus produk dari wish
if(isset($_GET['delete_wish']))
    $del_id = $_GET['delete_wish'];

    $del_product = "DELETE FROM wish WHERE product_id = '$del_id'";
    $del_res = mysqli_query($conn, $del_product);

    if($del_res){

        echo "<script>alert('Produk telah dihapus dari daftar wish!')</script>";
        echo "<script>window.open('wish.php', '_self')</script>";


    }
?>