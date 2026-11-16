<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus Kategori
if (isset($_GET['delete_cat'])) {
    $category_id = (int) $_GET['delete_cat'];

    if (q("DELETE FROM category WHERE id = '$category_id'")) {
        redirect('../index.php?category', 'Kategori Dihapus!');
    }
}
redirect('../index.php?category');
