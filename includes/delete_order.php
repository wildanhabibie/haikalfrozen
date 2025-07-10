<?php

// menghapus produk dari order di halaman akun
if(isset($_GET['del_no']))
    $del_id = $_GET['del_no'];

    $del_product = "DELETE FROM orders WHERE invoice_no = '$del_id'";
    $del_res = mysqli_query($conn, $del_product);

    if($del_res){

        echo "<script>alert('Pesanan telah dihapus')</script>";
        echo "<script>window.open('account.php', '_self')</script>";


    }
?>