<?php

 include "db.php";
if (!isset($_GET['order_no'])) {
    echo "<script>window.open('../index.php', '_self');</script>";
    }else if(isset($_GET['order_no'])){
        // jika tidak ada order akan diarahkan ke homepage
        $check_id = $_GET['order_no'];
        $check_order = "SELECT * FROM orders WHERE invoice_no = '$check_id'";
        $query_order = mysqli_query($conn, $check_order);
        $count = mysqli_num_rows($query_order);
        if($count == 0){
            echo"<script>window.open('../index.php','_self');</script>";
        }
    }
    
    // mendapatkan semua dari orders
    if(isset($_GET['order_no'])){

        $order_id = $_GET['order_no'];

        $query = "SELECT * FROM orders WHERE invoice_no = '$order_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        $user_name = $row['user_name'];
        $user_email = $row['user_email'];
        $user_phone = $row['user_phone'];
        $user_address = $row['user_address'];

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link Start -->
    <link rel="stylesheet" href="../assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Link End -->
</head>

<body>
    <!-- Main Start -->
    <main id="main">
        <!-- Order Start -->
        <div class="order-container">
            <div class="order-row">
                <a href="../index.php?orders" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <h2 class="order-title">Pesanan dari <php echo $user_name ?></h2>
            </div>
            <div class="order-row">
                <div class="order-col">
                    <div class="order-group">
                        <span>Full Name </span>
                        <h4><?php echo $user_name ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Email </span>
                        <h4><?php echo $user_email ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Telepon </span>
                        <h4><php echo $user_phone ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Alamat </span>
                        <h4><?php echo $user_address ?></h4>
                    </div>
                </div>
                <div class="order-col">
                    <div class="order-group">
                        <span>No Pesanan </span>
                        <h4><?php echo $order_id ?></h4>
                    </div>
                    <?php 
                          // mendapatkan semua dari orders
                            if(isset($_GET['order_no'])){

                                $order_id = $_GET['order_no'];
                                $total = 0;

                                $query_all = "SELECT * FROM orders WHERE invoice_no = '$order_id'";
                                $result_all = mysqli_query($conn, $query_all);
                                while($row_all = mysqli_fetch_array($result_all)) {
                                    $product_id = $row['product_id'];
                                    $product_name = $row['product_name'];
                                    $product_price = $row['product_price'];
                                    $product_quantity = $row['product_quantity'];
                                    $product_size = $row['product_size'];
                                    $product_jenis = $row['product_jenis'];
                                    
                                    $sub_total = $product_price * $product_quantity;
                                    $total += $sub_total;

                                    ?>
                                    <div class="orders-group">
                                    <div class="order-group">
                                        <span>Nama Produk</span>
                                        <h4><?php echo $product_name ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Harga Produk</span>
                                        <h4>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Jenis Produk</span>
                                        <h4><?php echo $product_jenis ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Ukuran Produk</span>
                                        <h4><?php echo $product_size ?></h4>
                                    </div>
                                </div>
                                    <?php
                                
                                }
                            }
                          ?>
                </div>
            </div>
            <div class="order-row">
            <div class="order-group">
                            <span>Total</span>
                            <h4>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></h4>
                        </div>
                        <div class="order-group">
                        <?php
                        //Dikurangi 20%
                        $reduced_price = (($total / 100)* 20);
                        ?>
                            <span>20.00%</span>
                            <h4>Rp.<?php echo number_format((float)$reduced_price, 3, '.', '') ?></h4>
                        </div>
                        <div class="order-group">
                        <?php
                            //Number format - tiga desimal
                            $totalPrice= (($total / 100)* 20) + $total;
                            ?>
                            <span>total dengan VAT</span>
                            <h4>Rp.<?php echo number_format((float)$totalPrice, 3, '.', '') ?></h4>
                        </div>
            </div>
            <div class="order-row">
                <a href="deleteOrder.php?order_del=<?php echo $order_id ?>">Hapus Pesanan <i class="fa fa-trash-alt"></i></a>
                <a href="downloadOrder.php?order_no=<?php echo $order_id ?>" target="_blank">Download PDF <i class="fa-solid fa-file-pdf"></i></a>
            </div>
        </div>

        <!-- Order End -->
    </main>
    <!-- Main End -->
    <!-- Scripts Start -->
    <script src="assets/fonts/font_awesome/js/all.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Scripts End -->
</body>

</html>