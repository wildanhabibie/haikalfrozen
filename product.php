<?php
require_once 'includes/init.php';

// Data user yang sedang login (untuk mengisi form review otomatis)
$user_email = '';
$user_image = '';
if (!empty($currentUser)) {
    $safe_user = db_esc($currentUser);
    $result = q("SELECT * FROM users WHERE username = '$safe_user'");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $user_email = $row['email'];
        $user_image = $row['user_image'];
    }
}

// Produk yang dibuka
$product_id = isset($_GET['pro_id']) ? (int) $_GET['pro_id'] : 0;
$result = q("SELECT * FROM products WHERE id = '$product_id'");
$product = $result ? mysqli_fetch_assoc($result) : null;
if (!$product) {
    redirect('shop.php', 'Produk tidak ditemukan!');
}

$product_name = $product['product_name'];
$category_name = $product['category_name'];
$product_price = $product['product_price'];
$product_desc = $product['product_desc'];
$product_images = array_values(array_filter([
    $product['product_image'],
    $product['product_image1'],
    $product['product_image2'],
    $product['product_image3'],
]));

// Tambah ke keranjang
if (isset($_POST['add'])) {
    $ip_address = db_esc(getUserIP());
    $product_size = db_esc(isset($_POST['size']) ? $_POST['size'] : '');
    $product_jenis = db_esc(isset($_POST['jenis']) ? $_POST['jenis'] : '');
    $product_quantity = max(1, (int) (isset($_POST['quantity']) ? $_POST['quantity'] : 1));

    // mengecek produk jika sudah ada di keranjang
    $check = q("SELECT id FROM cart WHERE ip_add = '$ip_address' AND product_id = '$product_id'");
    if (q_count($check) > 0) {
        redirect("product.php?pro_id=$product_id", 'Produk ini sudah ada di keranjang!');
    }

    q("INSERT INTO cart (ip_add, product_id, product_size, product_jenis, product_quantity, date)
       VALUES ('$ip_address', '$product_id', '$product_size', '$product_jenis', '$product_quantity', NOW())");
    redirect('cart.php', 'Produk berhasil ditambahkan ke keranjang!');
}

// Menambahkan review
if (isset($_POST['revadd'])) {
    $rating = (float) (isset($_POST['rating']) ? $_POST['rating'] : 0);
    $rating = max(0.5, min(5, $rating));
    $message = db_esc($_POST['revmessage']);
    $name = db_esc($_POST['revname']);
    $email = db_esc($_POST['revemail']);
    $safe_product_name = db_esc($product_name);
    $safe_image = db_esc($user_image);

    $ok = q("INSERT INTO reviews (review_product_id, review_product_name, review_rate, review_message, review_name, review_image, review_email, review_date)
             VALUES ('$product_id', '$safe_product_name', '$rating', '$message', '$name', '$safe_image', '$email', NOW())");
    if ($ok) {
        redirect("product.php?pro_id=$product_id", 'Anda sukses mengomentari produk!');
    }
    $messageRate = 'Review gagal disimpan, coba lagi!';
}

list($avg_rating, $review_count) = product_rating($product_id);

// menambahkan Header
include 'includes/header.php';
?>
                    <!-- Main Start -->
                    <main id="main">
                        <div class="product-container">
                            <form action="product.php?pro_id=<?php echo $product_id ?>" method="post">
                                <div class="product-row">
                                    <div class="product-col">
                                        <h2 class="product-name"><?php echo e($product_name) ?></h2>
                                        <span class="product-category"><?php echo e($category_name) ?></span>
                                        <div class="reviews">
                                            <div class="reviews-star">
                                                <!-- Reviews dari Database -->
                                                <?php
                                                if ($review_count === 0) {
                                                    echo "<div class='reviews-number'>Belum ada komentar sekarang.</div>";
                                                } else {
                                                    echo stars_html($avg_rating);
                                                }
                                                ?>
                                            </div>
                                            <div class="reviews-number">(<?php echo $review_count ?> Reviews)</div>
                                        </div>
                                        <h1 class="product-price"><?php echo rupiah($product_price) ?></h1>
                                    </div>
                                    <div class="product-col">
                                        <button class="product-add" name="add" type="submit">Tambah Ke Keranjang</button>
                                    </div>
                                </div>
                                <div class="product-row">
                                    <div class="product-col">
                                        <p class="product-description">
                                            <?php echo nl2br(e($product_desc)) ?></p>
                                        <div class="product-options">
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Jenis
                                                </h4>
                                                <div class="product-option-div">
                                                    <?php
                                                    // Mendapat Jenis
                                                    $result = q("SELECT * FROM jenis WHERE product_id = '$product_id'");
                                                    if (q_count($result) === 0) {
                                                        echo "<p>tidak tersedia jenis di produk ini!</p>";
                                                    } else {
                                                        $n = 0;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $jenis_name = e($row['jenis_name']);
                                                            $input_id = 'jenis_' . (++$n);
                                                            echo "
                                                            <label for='$input_id'>
                                                                <input type='radio' name='jenis' id='$input_id' value='$jenis_name' required />
                                                                <span>$jenis_name</span>
                                                            </label>
                                                            ";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Ukuran
                                                </h4>
                                                <div class="product-option-div">
                                                    <?php
                                                    // Mendapat ukuran
                                                    $result = q("SELECT * FROM sizes WHERE product_id = '$product_id'");
                                                    if (q_count($result) === 0) {
                                                        echo "<p>tidak tersedia ukuran di produk ini!</p>";
                                                    } else {
                                                        $n = 0;
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $size_name = e($row['product_size']);
                                                            $input_id = 'size_' . (++$n);
                                                            echo "
                                                            <label for='$input_id'>
                                                                <input type='radio' value='$size_name' id='$input_id' name='size' required />
                                                                <span>$size_name</span>
                                                            </label>
                                                            ";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Jumlah
                                                </h4>
                                                <div class="product-option-div">
                                                    <input type="number" name="quantity" min="1" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-col right">
                                        <div class="mini-carousel">
                                            <ul class="mini-item">
                                                <?php foreach ($product_images as $img): ?>
                                                <li><a><img src="assets/images/product_images/<?php echo e($img) ?>" alt="<?php echo e($product_name) ?>"></a></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                        <div class="carousel">
                                            <div class="image-large">
                                                <ul>
                                                    <?php foreach ($product_images as $img): ?>
                                                    <li><a><img src="assets/images/product_images/<?php echo e($img) ?>" alt="<?php echo e($product_name) ?>"></a></li>
                                                    <?php endforeach ?>
                                                </ul>
                                                <?php if (count($product_images) > 1): ?>
                                                <a class="prev">Prev</a>
                                                <a class="next">Next</a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="reviews-container">
                                <div class="reviews-col">
                                    <h2 class="reviews-title"><?php echo $review_count ?> Review untuk "<?php echo e($product_name) ?>"</h2>
                                    <?php
                                    $result = q("SELECT * FROM reviews WHERE review_product_id = '$product_id' ORDER BY id DESC");
                                    if (q_count($result) === 0) {
                                        echo "<div class='reviews-number'>Belum ada komentar sekarang.</div>";
                                    } else {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $r_name = e(ucfirst($row['review_name']));
                                            $r_date = e($row['review_date']);
                                            $r_message = nl2br(e($row['review_message']));
                                            $r_image = !empty($row['review_image']) ? e($row['review_image']) : 'user.png';
                                            ?>
                                            <div class='reviews-content-div'>
                                                <div class='reviews-content-left'>
                                                    <img src='assets/images/customers/<?php echo $r_image ?>' alt='<?php echo $r_name ?>'>
                                                </div>
                                                <div class='reviews-content-right'>
                                                    <div class='reviews-content-top'>
                                                        <p class='reviews-customer'><?php echo $r_name ?></p>
                                                        <span class='reviews-date'> - <?php echo $r_date ?> </span>
                                                    </div>
                                                    <div class='reviews-content-middle'>
                                                        <?php echo stars_html($row['review_rate']) ?>
                                                    </div>
                                                    <div class='reviews-content-bottom'>
                                                        <p class='reviews-customer-message'><?php echo $r_message ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="reviews-col">
                                    <h2 class="reviews-title">Tinggalkan Komentar</h2>
                                    <span class="reviews-subtitle">Email anda tidak akan dipublikasikan. Kolom yang harus diisi ditandai *</span>

                                    <form action="product.php?pro_id=<?php echo $product_id ?>" class="revform" method="post">
                                        <span class="text-success"><?php if (isset($messageRate)) echo e($messageRate); ?></span>
                                        <div class="reviews-group">
                                            <div class="rateyo" id="rating"
                                                data-rateyo-rating="4"
                                                data-rateyo-num-stars="5"
                                                data-rateyo-star-width="23px"
                                                data-rateyo-rated-fill="#001e28">
                                            </div>
                                            <input type="hidden" name="rating" value="4">
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Review Anda*</h4>
                                            <textarea name="revmessage" cols="28" rows="8" required></textarea>
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Nama Anda*</h4>
                                            <input type="text" name="revname" value="<?php echo e($currentUser) ?>" required>
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Email Anda*</h4>
                                            <input type="email" name="revemail" value="<?php echo e($user_email) ?>" required>
                                        </div>
                                        <div class="reviews-button">
                                            <button name="revadd">Publish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                        </main>
                    <!-- Main End -->

<?php
// menambahkan Footer
include 'includes/footer.php';
