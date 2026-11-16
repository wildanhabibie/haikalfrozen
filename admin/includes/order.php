<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

$order_id = isset($_GET['order_no']) ? db_esc($_GET['order_no']) : '';
$result = q("SELECT * FROM orders WHERE invoice_no = '$order_id' ORDER BY id");
if ($order_id === '' || q_count($result) == 0) {
    redirect('../index.php?orders');
}

$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}
$user_name = $items[0]['user_name'];
$user_email = $items[0]['user_email'];
$user_phone = $items[0]['user_phone'];
$user_address = $items[0]['user_address'];
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
                <h2 class="order-title">Pesanan dari <?php echo e($user_name) ?></h2>
            </div>
            <div class="order-row">
                <div class="order-col">
                    <div class="order-group">
                        <span>Full Name </span>
                        <h4><?php echo e($user_name) ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Email </span>
                        <h4><?php echo e($user_email) ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Telepon </span>
                        <h4><?php echo e($user_phone) ?></h4>
                    </div>
                    <div class="order-group">
                        <span>Alamat </span>
                        <h4><?php echo nl2br(e($user_address)) ?></h4>
                    </div>
                </div>
                <div class="order-col">
                    <div class="order-group">
                        <span>No Pesanan </span>
                        <h4><?php echo e($order_id) ?></h4>
                    </div>
                    <?php
                    $total = 0;
                    foreach ($items as $item) {
                        $sub_total = $item['product_price'] * $item['product_quantity'];
                        $total += $sub_total;
                        ?>
                        <div class="orders-group">
                            <div class="order-group">
                                <span>Nama Produk</span>
                                <h4><?php echo e($item['product_name']) ?></h4>
                            </div>
                            <div class="order-group">
                                <span>Harga Produk</span>
                                <h4><?php echo rupiah($item['product_price']) ?> x <?php echo (int) $item['product_quantity'] ?></h4>
                            </div>
                            <div class="order-group">
                                <span>Jenis Produk</span>
                                <h4><?php echo e($item['product_jenis']) ?></h4>
                            </div>
                            <div class="order-group">
                                <span>Ukuran Produk</span>
                                <h4><?php echo e($item['product_size']) ?></h4>
                            </div>
                        </div>
                        <?php
                    }
                    // ongkir 20%
                    $reduced_price = $total * 20 / 100;
                    $totalPrice = $total + $reduced_price;
                    ?>
                </div>
            </div>
            <div class="order-row">
                <div class="order-group">
                    <span>Total</span>
                    <h4><?php echo rupiah($total) ?></h4>
                </div>
                <div class="order-group">
                    <span>Ongkir 20.00%</span>
                    <h4><?php echo rupiah($reduced_price) ?></h4>
                </div>
                <div class="order-group">
                    <span>Total dengan Ongkir</span>
                    <h4><?php echo rupiah($totalPrice) ?></h4>
                </div>
            </div>
            <div class="order-row">
                <a href="deleteOrder.php?order_del=<?php echo urlencode($order_id) ?>" onclick="return confirm('Hapus pesanan ini?')">Hapus Pesanan <i class="fa fa-trash-alt"></i></a>
                <a href="downloadOrder.php?order_no=<?php echo urlencode($order_id) ?>" target="_blank">Download PDF <i class="fa-solid fa-file-pdf"></i></a>
            </div>
        </div>

        <!-- Order End -->
    </main>
    <!-- Main End -->
    <!-- Scripts Start -->
    <script src="../assets/fonts/font_awesome/js/all.js"></script>
    <!-- Scripts End -->
</body>

</html>
