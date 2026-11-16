<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus ukuran produk
if (isset($_GET['size_id'])) {
    $size_id = (int) $_GET['size_id'];

    $result = q("SELECT product_id FROM sizes WHERE id = '$size_id'");
    $row = $result ? mysqli_fetch_assoc($result) : null;
    if ($row && q("DELETE FROM sizes WHERE id = '$size_id'")) {
        redirect('add_size.php?pro_id=' . (int) $row['product_id'], 'Ukuran Dihapus!');
    }
}
redirect('../index.php?products');
