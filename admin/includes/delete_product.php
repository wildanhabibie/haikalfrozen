<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus produk beserta gambar, jenis, ukuran dan isi keranjang/wish terkait
if (isset($_GET['pro_id'])) {
    $product_id = (int) $_GET['pro_id'];

    $result = q("SELECT * FROM products WHERE id = '$product_id'");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    if ($row) {
        foreach (['product_image', 'product_image1', 'product_image2', 'product_image3'] as $column) {
            $file = PRODUCT_IMG_DIR . basename($row[$column]);
            if ($row[$column] !== '' && is_file($file)) {
                @unlink($file);
            }
        }
        q("DELETE FROM jenis WHERE product_id = '$product_id'");
        q("DELETE FROM sizes WHERE product_id = '$product_id'");
        q("DELETE FROM cart WHERE product_id = '$product_id'");
        q("DELETE FROM wish WHERE product_id = '$product_id'");
        if (q("DELETE FROM products WHERE id = '$product_id'")) {
            redirect('../index.php?products', 'Produk Dihapus!');
        }
    }
}
redirect('../index.php?products');
