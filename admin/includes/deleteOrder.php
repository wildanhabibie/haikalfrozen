<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus pesanan
if (isset($_GET['order_del'])) {
    $order_id = db_esc($_GET['order_del']);

    if (q("DELETE FROM orders WHERE invoice_no = '$order_id'")) {
        redirect('../index.php?orders', 'Pesanan Dihapus!');
    }
}
redirect('../index.php?orders');
