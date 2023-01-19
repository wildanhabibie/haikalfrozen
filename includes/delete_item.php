<?php

// menghapus produk dari keranjang
if(isset($_GET['delete_item']))
    $del_id = $_GET['delete_item'];

    $del_product = "DELETE FROM cart WHERE product_id = '$del_id'";
    $del_res = mysqli_query($conn, $del_product);

    if($del_res){

        echo "<script>alert('Produk telah dihapus dari keranjang!')</script>";
        echo "<script>window.open('cart.php', '_self')</script>";


    }
?>