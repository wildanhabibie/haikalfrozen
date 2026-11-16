<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// produk yang akan diupdate
$product_id = isset($_GET['pro_id']) ? (int) $_GET['pro_id'] : 0;
$result = q("SELECT * FROM products WHERE id = '$product_id'");
$product = $result ? mysqli_fetch_assoc($result) : null;
if (!$product) {
    redirect('../index.php?products', 'Produk tidak ditemukan!');
}

if (isset($_POST['update'])) {
    $pro_name = db_esc($_POST['name']);
    $category_id = (int) $_POST['category'];
    $pro_price = (float) str_replace(',', '.', $_POST['price']);
    $pro_desc = db_esc($_POST['desc']);

    $cat = q("SELECT category_name FROM category WHERE id = '$category_id'");
    $cat_row = $cat ? mysqli_fetch_assoc($cat) : null;
    $cat_name = db_esc($cat_row ? $cat_row['category_name'] : $product['category_name']);

    // gambar lama tetap dipakai kalau tidak ada gambar baru yang diupload
    $columns = ['file' => 'product_image', 'file1' => 'product_image1', 'file2' => 'product_image2', 'file3' => 'product_image3'];
    $images = [];
    foreach ($columns as $field => $column) {
        $new = save_uploaded_image($field, PRODUCT_IMG_DIR);
        if ($new !== null) {
            if ($product[$column] !== '' && is_file(PRODUCT_IMG_DIR . basename($product[$column]))) {
                @unlink(PRODUCT_IMG_DIR . basename($product[$column]));
            }
            $images[$column] = db_esc($new);
        } else {
            $images[$column] = db_esc($product[$column]);
        }
    }

    $ok = q("UPDATE products SET product_name = '$pro_name', category_id = '$category_id', category_name = '$cat_name',
             product_price = '$pro_price', product_desc = '$pro_desc',
             product_image = '{$images['product_image']}', product_image1 = '{$images['product_image1']}',
             product_image2 = '{$images['product_image2']}', product_image3 = '{$images['product_image3']}',
             date = NOW() WHERE id = '$product_id'");
    if ($ok) {
        redirect('../index.php?products', 'Update Sukses!');
    }
    $update_mess = "Update gagal!";
}

$product_name = e($product['product_name']);
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
                <a href="../index.php?products" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_product.php?pro_id=<?php echo $product_id; ?>" class="delete_product" onclick="return confirm('Hapus produk ini?')">Hapus Produk
                    <i class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update Produk</h2>
            </div>
            <div class="order-row update">
                <span class="text-success">
                    <?php if (isset($update_mess)) echo e($update_mess); ?></span>
                <form method="post" action="update_product.php?pro_id=<?php echo $product_id ?>" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="name" id="name" value="<?php echo $product_name ?>" required>
                    </div>
                    <div class="admin-group">
                        <label for="category">Kategori Produk</label>
                        <div class="ui-dropdown">
                            <select id="category" name="category">
                                <?php
                                $result = q("SELECT * FROM category ORDER BY category_name");
                                while ($result && $row = mysqli_fetch_assoc($result)) {
                                    $cat_id = (int) $row['id'];
                                    $selected = ($cat_id === (int) $product['category_id']
                                        || (!$product['category_id'] && $row['category_name'] === $product['category_name'])) ? ' selected' : '';
                                    echo "<option value='$cat_id'$selected>" . e($row['category_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="admin-group">
                        <label for="price">Harga Produk (dalam ribuan, contoh: 25 = Rp25.000)</label>
                        <input type="number" step="0.001" min="0" name="price" id="price" value="<?php echo e((float) $product['product_price']) ?>" required>
                    </div>
                    <div class="admin-group">
                        <label for="desc">Deskripsi Produk</label>
                        <textarea name="desc" id="desc" cols="30" rows="10"><?php echo e($product['product_desc']) ?></textarea>
                    </div>
                    <?php
                    $fields = ['file' => 'product_image', 'file1' => 'product_image1', 'file2' => 'product_image2', 'file3' => 'product_image3'];
                    $n = 0;
                    foreach ($fields as $field => $column):
                        $n++;
                    ?>
                    <div class="admin-group">
                        <label for="<?php echo $field ?>">Gambar Produk <?php echo $n ?></label>
                        <input type="file" name="<?php echo $field ?>" id="<?php echo $field ?>" class="file" accept="image/*">
                        <?php if ($product[$column] !== ''): ?>
                        <img src="../../assets/images/product_images/<?php echo e($product[$column]) ?>" class="img-update"
                            alt="<?php echo $product_name ?>">
                        <?php endif ?>
                    </div>
                    <?php endforeach ?>
                    <div class="admin-group-btn custom">
                        <button name="update">Update Produk</button>
                    </div>
                </form>
                <div class="attributes-group">
                    <h3>Tambah Atribut</h3>
                    <div class="attribute">
                        <a href="add_jenis.php?pro_id=<?php echo $product_id ?>">Jenis</a>
                        <a href="add_size.php?pro_id=<?php echo $product_id ?>">Ukuran</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order End -->
    </main>
    <!-- Main End -->
    <!-- Scripts Start -->
    <script src="../assets/js/jquery/jquery.min.js"></script>
    <script src="../assets/fonts/font_awesome/js/all.js"></script>
    <!-- Scripts End -->
</body>

</html>
