<?php
// Tambah produk
if (isset($_POST['add'])) {
    $product_name = db_esc($_POST['name']);
    $category_id = (int) $_POST['category'];
    $product_price = (float) str_replace(',', '.', $_POST['price']);
    $product_desc = db_esc($_POST['desc']);

    // nama kategori ikut disimpan (ditampilkan di halaman produk)
    $cat = q("SELECT category_name FROM category WHERE id = '$category_id'");
    $cat_row = $cat ? mysqli_fetch_assoc($cat) : null;
    $category_name = db_esc($cat_row ? $cat_row['category_name'] : '');

    // gambar disimpan di assets/images/product_images (folder yang dipakai toko)
    $images = [];
    foreach (['file', 'file1', 'file2', 'file3'] as $field) {
        $images[] = db_esc((string) save_uploaded_image($field, PRODUCT_IMG_DIR));
    }

    if ($product_name === '' || $product_price <= 0) {
        $message_error = "Nama dan harga produk wajib diisi!";
    } elseif ($images[0] === '') {
        $message_error = "Gambar produk utama wajib diupload (jpg/png/gif/webp)!";
    } else {
        $ok = q("INSERT INTO products (category_id, category_name, product_name, product_price, product_desc, product_image, product_image1, product_image2, product_image3, date)
                 VALUES ('$category_id', '$category_name', '$product_name', '$product_price', '$product_desc', '$images[0]', '$images[1]', '$images[2]', '$images[3]', NOW())");
        if ($ok) {
            redirect('index.php?products', 'Produk ditambahkan!');
        }
        $message_error = "Produk gagal ditambahkan!";
    }
}
?>
    <div class="admin">
        <div class="admin-row">
            <h4 class="admin-title">Admin / <i class="fa-brands fa-product-hunt"> </i> Produk</h4>
        </div>
        <div class="admin-row">
            <!-- Menambah Produk Start -->
            <h4 class="admin-add">Tambahkan Produk</h4>
            <div class="admin-add-col">
                <form action="index.php?products" method="post" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="admin-group">
                        <label for="category">Kategori Produk</label>
                        <div class="ui-dropdown">
                            <select id="category" name="category" required>
                                <?php
                                // semua kategori
                                $result = q("SELECT * FROM category ORDER BY category_name");
                                while ($result && $row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . (int) $row['id'] . "'>" . e($row['category_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="admin-group">
                        <label for="price">Harga Produk (dalam ribuan, contoh: 25 = Rp25.000)</label>
                        <input type="number" step="0.001" min="0" name="price" id="price" required>
                    </div>
                    <div class="admin-group">
                        <label for="desc">Deskripsi Produk</label>
                        <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk</label>
                        <input type="file" name="file" id="file" class="file" accept="image/*" required>
                    </div>
                    <div class="admin-group">
                        <label for="file1">Gambar Produk 1</label>
                        <input type="file" name="file1" id="file1" class="file" accept="image/*">
                    </div>
                    <div class="admin-group">
                        <label for="file2">Gambar Produk 2</label>
                        <input type="file" name="file2" id="file2" class="file" accept="image/*">
                    </div>
                    <div class="admin-group">
                        <label for="file3">Gambar Produk 3</label>
                        <input type="file" name="file3" id="file3" class="file" accept="image/*">
                    </div>
                    <span class="text-danger"><?php if (isset($message_error)) echo e($message_error); ?></span>
                    <div class="admin-group-btn">
                        <button name="add">Tambahkan Produk</button>
                    </div>
                </form>
            </div>
            <!-- Menambah Produk End -->
        </div>
        <div class="admin-row">
            <!-- Show Semua Produk -->
            <?php
            $per_page = 12; // setiap page ada 12 produk
            $page = current_page();
            $start_from = ($page - 1) * $per_page;

            $result = q("SELECT * FROM products ORDER BY id DESC LIMIT $start_from, $per_page");
            if (q_count($result) == 0) {
                echo "
                <div class='no_found'>
                <h4 class='no_found_title'>saat ini tidak ada produk!</h4></div>
                ";
            } else {
            ?>
            <div class="admin-cards">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $pro_id = (int) $row['id'];
                    $pro_name = e($row['product_name']);
                    $pro_image = e($row['product_image']);
                    $pro_desc = e(mb_substr((string) $row['product_desc'], 0, 40));
                ?>
                <div class="admin-card">
                    <div class="admin-header">
                        <h5 class="admin-subtitle"><?php echo $pro_name ?></h5>
                    </div>
                    <div class="admin-body">
                        <div class="admin-content image">
                            <img src="../assets/images/product_images/<?php echo $pro_image ?>" alt="<?php echo $pro_name ?>">
                        </div>
                        <div class="admin-content">
                            <p class="admin-desc"><?php echo $pro_desc ?></p>
                        </div>
                        <div class="admin-content price">
                            <span class="admin-price"><?php echo rupiah($row['product_price']) ?></span>
                        </div>
                    </div>
                    <div class="admin-footer">
                        <div class="admin-content">
                            <a href="includes/delete_product.php?pro_id=<?php echo $pro_id; ?>" onclick="return confirm('Hapus produk ini?')"><i
                                    class="fa fa-trash-alt"></i></a>
                            <a href="includes/update_product.php?pro_id=<?php echo $pro_id; ?>"><i
                                    class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <!-- Show Semua Produk End -->
            </div>
            <?php
                $total_record = q_count(q("SELECT id FROM products"));
                render_pagination('index.php?products&', $page, (int) ceil($total_record / $per_page));
            }
            ?>
        </div>
    </div>
