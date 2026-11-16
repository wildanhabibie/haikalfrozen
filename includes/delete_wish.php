<?php
// menghapus produk dari wish list (hanya milik pengunjung ini)
if (isset($_GET['delete_wish'])) {
    $del_id = (int) $_GET['delete_wish'];
    $ip_add = db_esc(getUserIP());

    if (q("DELETE FROM wish WHERE product_id = '$del_id' AND ip_add = '$ip_add'")) {
        redirect('wish.php', 'Produk telah dihapus dari daftar wish!');
    }
}
