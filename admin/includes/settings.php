<?php
// Update Password admin
if (isset($_POST['update'])) {
    $admin_name = db_esc($_SESSION['adminName']);
    $res_admin = q("SELECT admin_password FROM admin_account WHERE admin_name = '$admin_name'");
    $admin_row = $res_admin ? mysqli_fetch_assoc($res_admin) : null;
    $new_password = $_POST['pass'];
    $r_password = $_POST['r_pass'];

    if ($new_password !== $r_password) {
        $r_pass_err = "Password baru dan konfirmasi password tidak cocok!";
    } elseif (strlen($new_password) < 5) {
        $r_pass_err = "Password baru minimal 5 karakter!";
    } elseif (!$admin_row || !verify_password($_POST['ol_pass'], $admin_row['admin_password'])) {
        $pass_err = "Password lama tidak cocok!";
    } else {
        $hash_new_pass = db_esc(hash_password($new_password));
        q("UPDATE admin_account SET admin_password = '$hash_new_pass' WHERE admin_name = '$admin_name'");
        unset($_SESSION['adminName']);
        redirect('login.php', 'Update Password Berhasil! Silakan login kembali.');
    }
}
?>

<div class="admin">
    <div class="admin-row">
        <h4 class="admin-title">Admin / <i class="fa-solid fa-gear"></i> Settings</h4>
    </div>
    <div class="admin-row">
        <!-- Rubah Data Admin Start -->
        <h4 class="admin-add">Rubah Data Admin</h4>
        <div class="admin-add-col">
            <form action="index.php?settings" method="post">
                <div class="admin-group">
                    <label for="ol_pass">Password Lama</label>
                    <input type="password" name="ol_pass" id="ol_pass" required>
                    <span class="text-danger"><?php if (isset($pass_err)) echo $pass_err; ?></span>
                </div>
                <div class="admin-group">
                    <label for="pass">Password Baru</label>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <div class="admin-group">
                    <label for="r_pass">Ulangi Password Baru</label>
                    <input type="password" name="r_pass" id="r_pass" required>
                    <span class="text-danger"><?php if (isset($r_pass_err)) echo $r_pass_err; ?></span>
                </div>
                <div class="admin-group-btn">
                    <button name="update">Update</button>
                </div>
            </form>
        </div>
        <!-- Rubah Data Admin -->
    </div>

</div>
