<?php
// menghapus produk dari keranjang (hanya milik pengunjung ini)
if (isset($_GET['delete_item'])) {
    $del_id = (int) $_GET['delete_item'];
    $ip_add = db_esc(getUserIP());

    if (q("DELETE FROM cart WHERE product_id = '$del_id' AND ip_add = '$ip_add'")) {
        redirect('cart.php', 'Produk telah dihapus dari keranjang!');
    }
}
