<?php
            // menambahkan Header
            include 'includes/header.php';

            // jika keranjang kosong maka halaman checkout tidak akan diperlihatkan, langsung ke index.php
                $ip_address = getUserIP();

                $get_cart = "SELECT * FROM cart WHERE ip_add = '$ip_address'";
                $result_cart = mysqli_query($conn, $get_cart);
                $count_cart = mysqli_num_rows($result_cart);

                if($count_cart === 0) {

                    // langsung menuju halaman checkout
                    echo "<script>window.open('index.php','_self');</script>";

                }
            ?>

            <main id="main"> 
                <!-- Checkout Start -->
                <div class="checkout-container">
                    <div class="checkout-row">
                        <form action="" method="post">
                            <div class="checkout-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" id="name" required>
                            </div>
                            <div class="checkout-group">
                                <label for="name">Email</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="checkout-group">
                                <label for="name">Telepon</label>
                                <input type="phone" name="phone" id="phone" required>
                            </div>
                            <div class="checkout-group">
                                <label for="address">Alamat</label>
                                <textarea type="address" name="address" id="address" cols="30" rows="10" required></textarea>
                            </div>
                            <button name="order" class="checkout-order">Pesan Sekarang</button>
                        </form>
                    </div>
                </div>
                <!-- checkout end -->
            </main>
              <!-- main end -->

        <?php
        // includes Footer
        include 'includes/footer.php';

        // memesan produk
if (isset($_POST['order'])) {

    $ip = getUserIP();
    $invoice_no = mt_rand();
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "SELECT * FROM cart WHERE ip_add = '$ip'";
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($result)) {

        $product_id = $row['product_id'];
        $product_size = $row['product_size'];
        $product_jenis = $row['product_jenis'];
        $product_quantity = $row['product_quantity'];

        $total = 0;
        
        $get_product = "SELECT * FROM products WHERE id = '$product_id'";
        $result_product = mysqli_query($conn, $get_product);

        

    while ($row_product = mysqli_fetch_array($result_product)) {
        $product_name = $row_product['product_name'];
        $product_price = $row_product['product_price'];

        $sub_total = $product_price * $product_quantity;
        $total += $sub_total;

        // total harga dipotong ongkir
        $totalPrice= (($total / 100)* 20) + $total;
        $finishPrice = number_format((float)$totalPrice, 3, '.', '');

    // insert ke dalam tabel orders

        $insert_order = "INSERT INTO orders (user_ip, invoice_no, product_id, product_name, product_price, total_price, product_jenis, product_size, product_quantity, user_name, user_email, user_phone, user_address, date) VALUES ('$ip','$invoice_no', '$product_id', '$product_name', '$product_price', '$finishPrice','$product_jenis', '$product_size', '$product_quantity','$fullname','$email','$phone','$address', now())";

        $run_order=mysqli_query($conn, $insert_order);

            if ($run_order) {
                // jika menjalankan perintah daripada menghapus dari keranjang
                $delete_cart = "DELETE FROM cart WHERE ip_add='$ip'";
                $run_delete = mysqli_query($conn, $delete_cart);

                echo "<script>alert('Pesanan sudah diterima, terimakasih!');</script>";
                echo "<script>window.open('order.php?order_no=$invoice_no','_self');</script>";
            } else {
                // kalau gagal
                echo "<script>alert('Pesanan gagal, coba lagi!');</script>";
                echo "<script>window.open('checkout.php','_self');</script>";
                }
            }

        }
    }
    ?>
