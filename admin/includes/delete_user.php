<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// Hapus User
if (isset($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id'];

    $result = q("SELECT * FROM users WHERE id = '$user_id'");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    if ($row) {
        // hapus foto profil
        $file = CUSTOMER_IMG_DIR . basename($row['user_image']);
        if ($row['user_image'] !== '' && $row['user_image'] !== 'user.png' && is_file($file)) {
            @unlink($file);
        }
        if (q("DELETE FROM users WHERE id = '$user_id'")) {
            redirect('../index.php?users', 'User Dihapus!');
        }
    }
}
redirect('../index.php?users');
