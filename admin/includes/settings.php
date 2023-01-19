<?php 
    //Update Password
    if (isset($_POST['update'])) {
        $old_password = $_POST['ol_pass'];
        $new_password = $_POST['pass'];
        $r_password = $_POST['r_pass'];

        $hash_old_pass = md5($old_password);
        $hash_new_pass = md5($new_password);
        $hash_r_pass = md5($r_password);

        // cek if
        if($new_password == $r_password){
            $query = "SELECT * FROM admin_account WHERE admin_password = '$hash_old_pass'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);

            if($count > 0) {
                $query = "UPDATE admin_account SET admin_password = '$hash_new_pass'";
                mysqli_query($conn, $query);
                $pass_mess = "Update Password Berhasil!";
                session_destroy();
                echo"<script>document.location='login.php';</script>";
            } else {
                $pass_err = "Password lama tidak cocok!";
            }
        } else {
            $r_pass_err = "Password baru dan konfirmasi password tidak cocok!";
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
            <form action="" method="post">
                <span class="text-danger"><?php if (isset($pass_mess)) echo $pass_mess; ?></span>
                <div class="admin-group">
                    <label for="ol_pass">Password Lama</label>
                    <input type="password" name="ol_pass" id="ol_pass">
                    <span class="text-danger"><?php if (isset($pass_err)) echo $pass_err; ?></span>
                </div>
                <div class="admin-group">
                    <label for="pass">Password Baru</label>
                    <input type="password" name="pass" id="pass">
                </div>
                <div class="admin-group">
                    <label for="r_pass">Ulangi Password Baru</label>
                    <input type="password" name="r_pass" id="r_pass">
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
</div>