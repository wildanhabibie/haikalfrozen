<?php
require_once 'includes/init.php';

// hapus item dari keranjang
if (isset($_GET['delete_item'])) {
    include 'includes/delete_item.php';
}

// checkout
if (isset($_POST['checkout'])) {
    $ip_address = db_esc(getUserIP());
    $count_cart = q_count(q("SELECT id FROM cart WHERE ip_add = '$ip_address'"));

    if ($count_cart === 0) {
        redirect('shop.php', 'Mohon tambahkan produk ke keranjang!');
    }
    // langsung menuju halaman checkout
    redirect('checkout.php');
}

// menambahkan Header
include 'includes/header.php';
?>

                    <!-- Main Start -->
                    <main id="main">
                        <!-- Cart Start -->
                        <div class="cart-container">
                            <div class="cart-row">
                                <h2 class="cart-title"><?php item(); ?> Barang di keranjang anda</h2>
                            </div>
                            <div class="cart-row">
                                <div class="cart-content">
                                    <div class="cart-header">
                                        <div class="cart-div">
                                            <h4 class="cart-items">Produk</h4>
                                        </div>
                                        <div class="cart-div">
                                            <h4 class="cart-items">Jumlah</h4>
                                        </div>
                                        <div class="cart-div">
                                            <h4 class="cart-items">Jenis</h4>
                                        </div>
                                        <div class="cart-div">
                                            <h4 class="cart-items">Ukuran</h4>
                                        </div>
                                        <div class="cart-div">
                                            <h4 class="cart-items">Harga</h4>
                                        </div>
                                        <div class="cart-div"></div>
                                    </div>
                                    <?php
                                        // semua produk di keranjang pengunjung ini
                                        $ip_add = db_esc(getUserIP());
                                        $result = q("SELECT c.*, p.product_name, p.product_price, p.product_image
                                                     FROM cart c JOIN products p ON p.id = c.product_id
                                                     WHERE c.ip_add = '$ip_add' ORDER BY c.id");
                                        $count = q_count($result);

                                        $total = 0;

                                        while ($result && $row = mysqli_fetch_assoc($result)) {
                                            $product_id = (int) $row['product_id'];
                                            $product_size = e($row['product_size']);
                                            $product_jenis = e($row['product_jenis']);
                                            $product_quantity = (int) $row['product_quantity'];
                                            $product_image = e($row['product_image']);
                                            $product_name = e($row['product_name']);
                                            $sub_total = $row['product_price'] * $product_quantity;
                                            $total += $sub_total;
                                            ?>
                                            <div class="cart-body">
                                        <div class="cart-div">
                                            <a href="product.php?pro_id=<?php echo $product_id ?>">
                                                <img src="assets/images/product_images/<?php echo $product_image ?>" alt="<?php echo $product_name ?>">
                                                <span><?php echo $product_name ?></span>
                                            </a>
                                        </div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_quantity ?></span></div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_jenis ?></span></div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_size ?></span></div>
                                        <div class="cart-div"><span class="price-product"><?php echo rupiah($sub_total) ?></span></div>
                                        <div class="cart-div">
                                            <a href="cart.php?delete_item=<?php echo $product_id ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                            <?php
                                        }

                                        if($count == 0){
                                            echo "<h3 class='no_carts'>Anda tidak memiliki item di keranjang!</h3>";
                                        }
                                    ?>

                                    <div class="cart-footer">
                                        <div class="cart-footer-div">
                                            <div>
                                                <h3 class="total-text">Harga Total :</h3>
                                                <h3 class="total-text"><?php echo rupiah($total) ?></h3>
                                            </div>
                                            <div>
                                                <?php
                                                // ongkir 20%
                                                $reduced_price = (($total / 100)* 20);
                                                ?>
                                                <h3 class="total-text">Ditambah Pajak Ongkir 20.00%</h3>
                                                <h3 class="total-text"><?php echo rupiah($reduced_price) ?></h3>
                                            </div>
                                        </div>
                                        <div class="cart-footer-div">
                                            <div>
                                                <?php
                                                // total + ongkir
                                                $totalPrice= (($total / 100)* 20) + $total;
                                                ?>
                                            <h3 class="total-text">Total dengan Ongkir :</h3>
                                            <h3 class="total-text"><?php echo rupiah($totalPrice) ?></h3>
                                            </div>
                                            <div>
                                                <form action="cart.php" method="post">
                                                <button name="checkout" class="cart-checkout">Beli</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cart End -->
                    </main>
                    <!-- Main End -->
                    <?php
                    
            // menambahkan Footer
            include 'includes/footer.php';
