<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus jenis produk
if (isset($_GET['jenis_id'])) {
    $jenis_id = (int) $_GET['jenis_id'];

    $result = q("SELECT product_id FROM jenis WHERE id = '$jenis_id'");
    $row = $result ? mysqli_fetch_assoc($result) : null;
    if ($row && q("DELETE FROM jenis WHERE id = '$jenis_id'")) {
        redirect('add_jenis.php?pro_id=' . (int) $row['product_id'], 'Jenis Dihapus!');
    }
}
redirect('../index.php?products');
