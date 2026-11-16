<?php
require_once 'includes/init.php';

$ip = db_esc(getUserIP());

// jika keranjang kosong maka halaman checkout tidak ditampilkan
$result_cart = q("SELECT c.*, p.product_name, p.product_price
                  FROM cart c JOIN products p ON p.id = c.product_id
                  WHERE c.ip_add = '$ip'");
if (q_count($result_cart) === 0) {
    redirect('index.php');
}

// memesan produk
if (isset($_POST['order'])) {
    $invoice_no = mt_rand(100000000, 2147483647);
    $fullname = db_esc($_POST['name']);
    $email = db_esc($_POST['email']);
    $phone = db_esc($_POST['phone']);
    $address = db_esc($_POST['address']);

    $all_ok = true;
    while ($row = mysqli_fetch_assoc($result_cart)) {
        $product_id = (int) $row['product_id'];
        $product_size = db_esc($row['product_size']);
        $product_jenis = db_esc($row['product_jenis']);
        $product_quantity = (int) $row['product_quantity'];
        $product_name = db_esc($row['product_name']);
        $product_price = (float) $row['product_price'];

        // total per produk + ongkir 20%
        $sub_total = $product_price * $product_quantity;
        $finishPrice = $sub_total + ($sub_total * 20 / 100);

        // insert ke dalam tabel orders
        $ok = q("INSERT INTO orders (user_ip, invoice_no, product_id, product_name, product_price, total_price, product_jenis, product_size, product_quantity, user_name, user_email, user_phone, user_address, date)
                 VALUES ('$ip', '$invoice_no', '$product_id', '$product_name', '$product_price', '$finishPrice', '$product_jenis', '$product_size', '$product_quantity', '$fullname', '$email', '$phone', '$address', NOW())");
        if (!$ok) {
            $all_ok = false;
        }
    }

    if ($all_ok) {
        // pesanan masuk, kosongkan keranjang
        q("DELETE FROM cart WHERE ip_add = '$ip'");
        redirect("order.php?order_no=$invoice_no", 'Pesanan sudah diterima, terimakasih!');
    }
    // kalau gagal, hapus pesanan yang setengah jadi
    q("DELETE FROM orders WHERE invoice_no = '$invoice_no'");
    redirect('checkout.php', 'Pesanan gagal, coba lagi!');
}

// menambahkan Header
include 'includes/header.php';
?>

            <main id="main"> 
                <!-- Checkout Start -->
                <div class="checkout-container">
                    <div class="checkout-row">
                        <form action="checkout.php" method="post">
                            <div class="checkout-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" id="name" required>
                            </div>
                            <div class="checkout-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="checkout-group">
                                <label for="phone">Telepon</label>
                                <input type="tel" name="phone" id="phone" required>
                            </div>
                            <div class="checkout-group">
                                <label for="address">Alamat</label>
                                <textarea name="address" id="address" cols="30" rows="10" required></textarea>
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
