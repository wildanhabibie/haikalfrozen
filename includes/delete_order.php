<?php
// menghapus pesanan dari halaman akun (hanya milik pengunjung ini)
if (isset($_GET['del_no'])) {
    $del_id = db_esc($_GET['del_no']);
    $ip_add = db_esc(getUserIP());

    if (q("DELETE FROM orders WHERE invoice_no = '$del_id' AND user_ip = '$ip_add'")) {
        redirect('account.php', 'Pesanan telah dihapus');
    }
}
