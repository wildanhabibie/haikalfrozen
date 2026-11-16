<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// kategori yang akan diupdate
$category_id = isset($_GET['update_cat']) ? (int) $_GET['update_cat'] : 0;
$result = q("SELECT * FROM category WHERE id = '$category_id'");
$row = $result ? mysqli_fetch_assoc($result) : null;
if (!$row) {
    redirect('../index.php?category', 'Kategori tidak ditemukan!');
}
$category_name = $row['category_name'];

// update category (nama kategori di produk ikut diganti)
if (isset($_POST['update'])) {
    $cat_name = db_esc($_POST['name']);
    if ($cat_name !== '' && q("UPDATE category SET category_name = '$cat_name', date = NOW() WHERE id = '$category_id'")) {
        q("UPDATE products SET category_name = '$cat_name' WHERE category_id = '$category_id'");
        redirect('../index.php?category', 'Update Sukses!');
    }
    $update_mess = "Update gagal!";
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
                <a href="../index.php?category" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_category.php?delete_cat=<?php echo $category_id; ?>" class="delete_product" onclick="return confirm('Hapus kategori ini?')">Hapus
                    Kategori
                    <i class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update Kategori</h2>
            </div>
            <div class="order-row update">
                <span class="text-success">
                    <?php if (isset($update_mess)) echo $update_mess; ?></span>
                <form action="update_category.php?update_cat=<?php echo $category_id ?>" method="post">
                    <div class="admin-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="name" id="name" value="<?php echo e($category_name); ?>" required>
                    </div>
                    <div class="admin-group-btn custom">
                        <button name="update">Update Kategori</button>
                    </div>
                </form>
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