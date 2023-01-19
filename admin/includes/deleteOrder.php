<?php

    include "db.php";

    //Delete Orders
    if(isset($_GET['order_del'])){
        $order_id = $_GET['order_del'];

        $delete_order = "DELETE FROM orders WHERE invoice_no='$order_id'";
        $result_delete = mysqli_query($conn, $delete_order);

        if($result_delete){
            echo "<script>alert('Orders Dihapus!')</script>";
            echo "<script>window.open('../index.php?orders', '_self')</script>";
        }
    }
?>