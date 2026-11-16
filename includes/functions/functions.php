<?php

/* ==========================================================================
 * Helper umum
 * ======================================================================== */

// Escape output HTML (mencegah XSS)
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Escape string untuk query SQL
function db_esc($value)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim((string) $value));
}

// Menjalankan query; kalau gagal pesan error dicatat di log server
function q($sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        error_log('SQL error: ' . mysqli_error($conn) . ' | query: ' . $sql);
    }
    return $result;
}

// Jumlah baris hasil query (aman walaupun query gagal)
function q_count($result)
{
    return $result ? mysqli_num_rows($result) : 0;
}

// Pindah halaman lalu hentikan script
function redirect($url, $alert = null)
{
    if ($alert === null && !headers_sent()) {
        header('Location: ' . $url);
        exit;
    }
    echo '<script>';
    if ($alert !== null) {
        echo 'alert(' . json_encode($alert) . ');';
    }
    echo 'window.location.href=' . json_encode($url) . ';</script>';
    exit;
}

// Harga disimpan dalam ribuan rupiah (25 = Rp25.000)
function rupiah($value)
{
    return 'Rp' . number_format((float) $value * 1000, 0, ',', '.');
}

// Nomor halaman dari ?page=, minimal 1
function current_page()
{
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    return $page < 1 ? 1 : $page;
}

// Simpan file upload dengan nama unik; kembalikan nama file atau null
function save_uploaded_image($field, $target_dir)
{
    if (empty($_FILES[$field]['tmp_name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        return null;
    }
    $name = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME));
    $file = $name . '_' . time() . mt_rand(100, 999) . '.' . $ext;
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }
    if (move_uploaded_file($_FILES[$field]['tmp_name'], rtrim($target_dir, '/') . '/' . $file)) {
        return $file;
    }
    return null;
}

/**
 * Menyesuaikan database lama secara otomatis (sekali per session):
 * kolom products.category_id dibutuhkan untuk filter kategori di toko.
 */
function ensure_schema()
{
    if (!empty($_SESSION['schema_checked'])) {
        return;
    }
    $col = q("SHOW COLUMNS FROM products LIKE 'category_id'");
    if ($col && q_count($col) === 0) {
        q("ALTER TABLE products ADD COLUMN category_id INT NOT NULL DEFAULT 0 AFTER id");
        q("UPDATE products p JOIN category c ON c.category_name = p.category_name SET p.category_id = c.id");
    }
    // hash password_hash() panjangnya 60+ karakter; kolom lama mungkin VARCHAR(32)
    foreach (['users' => 'password', 'admin_account' => 'admin_password'] as $table => $column) {
        $info = q("SHOW COLUMNS FROM $table LIKE '$column'");
        $row = $info ? mysqli_fetch_assoc($info) : null;
        if ($row && preg_match('/char\((\d+)\)/i', $row['Type'], $m) && (int) $m[1] < 255) {
            q("ALTER TABLE $table MODIFY $column VARCHAR(255) NOT NULL");
        }
    }
    if ($col) {
        $_SESSION['schema_checked'] = true;
    }
}

/* ==========================================================================
 * Password
 * ======================================================================== */

// Hash password baru (bcrypt via password_hash)
function hash_password($plain)
{
    return password_hash((string) $plain, PASSWORD_DEFAULT);
}

// Cek password; masih menerima hash md5 lama dari database sebelumnya
function verify_password($plain, $stored)
{
    $stored = (string) $stored;
    if (password_get_info($stored)['algo']) {
        return password_verify((string) $plain, $stored);
    }
    return preg_match('/^[a-f0-9]{32}$/i', $stored) === 1
        && hash_equals(strtolower($stored), md5((string) $plain));
}

// true kalau hash masih md5 / perlu diperbarui ke algoritma terbaru
function password_needs_upgrade($stored)
{
    $stored = (string) $stored;
    return !password_get_info($stored)['algo'] || password_needs_rehash($stored, PASSWORD_DEFAULT);
}

/* ==========================================================================
 * Pengunjung
 * ======================================================================== */

// IP pengunjung (dipakai untuk keranjang, wish list dan pesanan)
function getUserIP()
{
    switch (true) {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        default:
            return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    }
}

// Menghitung jumlah produk di keranjang
function item()
{
    $ip_add = db_esc(getUserIP());
    echo q_count(q("SELECT id FROM cart WHERE ip_add = '$ip_add'"));
}

// Menghitung jumlah produk di wish list
function itemWish()
{
    $ip_add = db_esc(getUserIP());
    echo q_count(q("SELECT id FROM wish WHERE ip_add = '$ip_add'"));
}

// Menambahkan produk ke wish list (dipakai index.php dan shop.php)
function add_to_wish($product_id, $back_page)
{
    $product_id = (int) $product_id;
    $ip_add = db_esc(getUserIP());

    $check = q("SELECT id FROM wish WHERE ip_add = '$ip_add' AND product_id = '$product_id'");
    if (q_count($check) > 0) {
        redirect($back_page, 'Produk sudah ditambahkan di daftar wish!');
    }
    q("INSERT INTO wish (ip_add, product_id, date) VALUES ('$ip_add', '$product_id', NOW())");
    redirect('wish.php', 'Produk ditambahkan ke daftar wish!');
}

/* ==========================================================================
 * Rating / bintang
 * ======================================================================== */

// [rata-rata, jumlah review] untuk sebuah produk
function product_rating($product_id)
{
    $product_id = (int) $product_id;
    $result = q("SELECT COUNT(*) AS total, COALESCE(AVG(review_rate), 0) AS rata
                 FROM reviews WHERE review_product_id = '$product_id'");
    $row = $result ? mysqli_fetch_assoc($result) : null;
    if (!$row) {
        return [0, 0];
    }
    return [round((float) $row['rata'], 1), (int) $row['total']];
}

// HTML ikon bintang untuk nilai 0 - 5 (kelipatan 0.5)
function stars_html($rate)
{
    $rate = max(0, min(5, round((float) $rate * 2) / 2));
    $html = '';
    $full = (int) floor($rate);
    for ($i = 0; $i < $full; $i++) {
        $html .= "<i class='fas fa-star rating-with-color'></i>";
    }
    if ($rate - $full >= 0.5) {
        $html .= "<i class='fas fa-star-half-alt rating-with-color'></i>";
    }
    return $html;
}

// Bintang + teks untuk kartu produk
function render_product_stars($product_id)
{
    list($avg, $count) = product_rating($product_id);
    if ($count === 0) {
        echo "<div class='review-number'>Belum ada review sekarang.</div>";
        return;
    }
    echo stars_html($avg) . "<span>$avg out of 5</span>";
}

/* ==========================================================================
 * Kartu produk & pagination
 * ======================================================================== */

/**
 * Menampilkan satu kartu produk.
 * $wish_action : halaman yang memproses ?add_wish= (index.php / shop.php),
 *                atau null untuk menampilkan tombol hapus (halaman wish).
 * $badge       : class tambahan (new-product / bestseller-product)
 */
function render_product_card($product, $wish_action = 'shop.php', $badge = '')
{
    $id = (int) $product['id'];
    $name = e($product['product_name']);
    $desc = e($product['product_desc']);
    $image = e($product['product_image']);
    $price = rupiah($product['product_price']);
    $link = "product.php?pro_id=$id";
    ?>
    <div class="card_container">
        <?php if ($badge) echo "<span class='" . e($badge) . "'></span>"; ?>
        <div class="card_top_section">
            <img class="card-img" src="assets/images/product_images/<?php echo $image ?>" alt="<?php echo $name ?>">
            <div class="card_top_section_icons">
                <?php if ($wish_action !== null): ?>
                <div class="wish-slot">
                    <form action="<?php echo e($wish_action) ?>?add_wish=<?php echo $id ?>" method="post">
                        <button class="add_wish" type="submit"><i class="far fa-heart"></i></button>
                    </form>
                </div>
                <?php endif ?>
                <div>
                    <a href="<?php echo $link ?>" title="Beli"><i class="fas fa-shopping-basket"></i></a>
                </div>
                <div>
                    <a href="<?php echo $link ?>" title="Lihat detail"><i class="fas fa-eye"></i></a>
                </div>
                <?php if ($wish_action === null): ?>
                <div>
                    <form action="wish.php?delete_wish=<?php echo $id ?>" method="post">
                        <button class="delete_wish" type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
                <?php endif ?>
            </div>
        </div>
        <a href="<?php echo $link ?>" class="card-link">
            <div class="card_body_section">
                <p><?php echo $name ?></p>
                <span><?php echo $desc ?></span>
            </div>
        </a>
        <div>
            <div class="rating-section">
                <div class="stars-rating">
                    <?php render_product_stars($id); ?>
                </div>
                <div class="c-price">
                    <span><?php echo $price ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Pagination: Prev 1 ... (n-1) n (n+1) ... last Next
 * $base_url sudah diakhiri '?' atau '&' (contoh: 'shop.php?cat=2&' atau 'shop.php?')
 */
function render_pagination($base_url, $page, $total_page)
{
    if ($total_page <= 1) {
        return;
    }
    $link = function ($p, $label = null, $active = false) use ($base_url) {
        $label = $label === null ? $p : $label;
        $class = 'pagination-menu-link' . ($active ? ' active' : '');
        return "<li class='pagination-menu-item'><a href='" . e($base_url) . "page=$p' class='$class'>$label</a></li>";
    };
    $dots = "<li class='pagination-menu-item'><a class='pagination-menu-link'>...</a></li>";

    echo "<div class='admin-pagination'><ul>";
    if ($page > 1) {
        echo $link($page - 1, 'Prev');
    }
    if ($page > 2) {
        echo $link(1);
    }
    if ($page > 3) {
        echo $dots;
    }
    if ($page > 1) {
        echo $link($page - 1);
    }
    echo $link($page, null, true);
    if ($page + 1 <= $total_page) {
        echo $link($page + 1);
    }
    if ($page + 2 < $total_page) {
        echo $dots;
    }
    if ($page + 1 < $total_page) {
        echo $link($total_page);
    }
    if ($page < $total_page) {
        echo $link($page + 1, 'Next');
    }
    echo "</ul></div>";
}

/* ==========================================================================
 * Halaman Toko
 * ======================================================================== */

// Daftar kategori di sidebar toko
function getShopCategory()
{
    $active = isset($_GET['cat']) ? (int) $_GET['cat'] : 0;
    $class = $active === 0 ? ' active-link' : '';
    echo "<a href='shop.php' class='sidebar-category-link$class'>Semua</a>";

    $result = q("SELECT * FROM category ORDER BY category_name");
    while ($result && $row = mysqli_fetch_assoc($result)) {
        $category_id = (int) $row['id'];
        $category_name = e($row['category_name']);
        $class = $active === $category_id ? ' active-link' : '';
        echo "<a href='shop.php?cat=$category_id' class='sidebar-category-link$class'>$category_name</a>";
    }
}

// Urutan produk dari ?sort=
function shop_order_by()
{
    $options = [
        'a-z' => 'product_name ASC',
        'z-a' => 'product_name DESC',
        'price-asc' => 'product_price ASC',
        'price-desc' => 'product_price DESC',
        'date-asc' => 'id ASC',
        'date-desc' => 'id DESC',
    ];
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    return isset($options[$sort]) ? $options[$sort] : 'id DESC';
}

/**
 * Menampilkan produk di halaman toko.
 * Tanpa ?cat= tampil semua produk, dengan ?cat=ID hanya produk kategori itu.
 */
function getShopProducts()
{
    $per_page = 12;
    $page = current_page();
    $start_from = ($page - 1) * $per_page;

    $where = '';
    $base_url = 'shop.php?';
    if (isset($_GET['cat']) && $_GET['cat'] !== '') {
        $filter_id = (int) $_GET['cat'];
        $where = "WHERE category_id = '$filter_id'";
        $base_url = "shop.php?cat=$filter_id&";
    }
    if (!empty($_GET['sort'])) {
        $base_url .= 'sort=' . urlencode($_GET['sort']) . '&';
    }

    $order = shop_order_by();
    $result = q("SELECT * FROM products $where ORDER BY $order LIMIT $start_from, $per_page");

    if (q_count($result) == 0) {
        echo "
            <div class='no_found'>
                <h3 class='no_found_title'>Saat ini tidak ada produk!</h3>
            </div>
        ";
        return;
    }

    echo '<div class="cards">';
    while ($row = mysqli_fetch_assoc($result)) {
        render_product_card($row, 'shop.php');
    }
    echo '</div>';

    $total_record = q_count(q("SELECT id FROM products $where"));
    render_pagination($base_url, $page, (int) ceil($total_record / $per_page));
}
