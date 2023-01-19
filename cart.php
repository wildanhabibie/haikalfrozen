<?php
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
                                        //mendapatkan semua produk untuk keranjang
                                        $ip_add = getUserIP();
                                        $query = "SELECT * FROM cart WHERE ip_add = '$ip_add'";
                                        $result = mysqli_query($conn, $query);
                                        $count = mysqli_num_rows($result);

                                        $total = 0;

                                        while($row = mysqli_fetch_array($result)){
                                            
                                            $product_id = $row['product_id'];
                                            $product_size = $row['product_size'];
                                            $product_jenis = $row['product_jenis'];
                                            $product_quantity = $row['product_quantity'];

                                            $query_pro = "SELECT * FROM products WHERE id = '$product_id'";
                                            $result_pro = mysqli_query($conn, $query_pro);

                                            while($row_pro = mysqli_fetch_array($result_pro)){
                                                $product_image = $row_pro['product_image'];
                                                $product_price = $row_pro['product_price'];
                                                $product_name = $row_pro['product_name'];
                                                $sub_total = $product_price * $product_quantity;
                                                $total += $sub_total;
                                            }

                                            ?>
                                            <div class="cart-body">
                                        <div class="cart-div">
                                            <a href="product.php">
                                                <img src="assets/images/product_images/<?php echo $product_image ?>" alt="<?php echo $product_name ?>">
                                                <span><?php echo $product_name ?></span>
                                            </a>
                                        </div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_quantity ?></span></div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_jenis ?></span></div>
                                        <div class="cart-div"><span class="quantity"><?php echo $product_size ?></span></div>
                                        <div class="cart-div"><span class="price-product">Rp.<?php echo number_format((float)$sub_total, 3, '.', '') ?></span></div>
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
                                                <h3 class="total-text">Rp.<?php echo number_format((float)$total, 3, '.', '') ?></h3>
                                            </div>
                                            <div>
                                                <?php
                                                //Dikurangi 20%
                                                $reduced_price = (($total / 100)* 20);
                                                ?>
                                                <h3 class="total-text">Ditambah Pajak Ongkir 20.00%</h3>
                                                <h3 class="total-text">Rp.<?php echo number_format((float)$reduced_price, 3, '.', ''); ?></h3>
                                            </div>
                                        </div>
                                        <div class="cart-footer-div">
                                            <div>
                                                <?php
                                                //Number format - tiga desimal
                                                $totalPrice= (($total / 100)* 20) + $total;
                                                ?>
                                            <h3 class="total-text">Total dengan Ongkir :</h3>
                                            <h3 class="total-text">Rp.<?php echo number_format((float)$totalPrice, 3, '.', ''); ?></h3>
                                            </div>
                                            <div>
                                                <form action="" method="post">
                                                <button name="checkout" class="cart-checkout">Beli</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cart End -->
                        <?php
                        
                        //delete item
                        if(isset($_GET['delete_item'])){
                            include("includes/delete_item.php");
                        }

                        ?>
                    </main>
                    <!-- Main End -->
                    <?php
                    
            // menambahkan Footer
            include 'includes/footer.php';

            // checkout
            if(isset($_POST['checkout'])){

                $ip_address = getUserIP();

                $get_cart = "SELECT * FROM cart WHERE ip_add = '$ip_address'";
                $result_cart = mysqli_query($conn, $get_cart);
                $count_cart = mysqli_num_rows($result_cart);

                if($count_cart === 0) {

                    echo "<script>alert('Mohon tambahkan produk ke keranjang!');</script>";
                    echo "<script>window.open('shop.php','_self');</script>";

                } else {

                    // langsung menuju halaman checkout
                    echo "<script>window.open('checkout.php','_self');</script>";

                }

            }
        ?>