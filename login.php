<?php
require_once 'includes/init.php';

// sudah login? langsung ke beranda
if (!empty($currentUser)) {
    redirect('index.php');
}

// login
if (isset($_POST['login'])) {
    $username = db_esc($_POST['username']);
    $result = q("SELECT * FROM users WHERE username = '$username'");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    if (!$row || !verify_password($_POST['password'], $row['password'])) {
        $error = "Username dan Password Salah!";
    } elseif ((int) $row['user_block'] === 1) {
        $error = "Akun ini diblokir!";
    } else {
        // hash md5 lama otomatis diganti dengan password_hash
        if (password_needs_upgrade($row['password'])) {
            $new_hash = db_esc(hash_password($_POST['password']));
            q("UPDATE users SET password = '$new_hash' WHERE id = '" . (int) $row['id'] . "'");
        }
        session_regenerate_id(true);
        $_SESSION['customerName'] = $row['username'];
        redirect('index.php');
    }
}

// menambahkan Header
include 'includes/header.php';
?>


<!-- Main Start -->
<main id="main">
    <!-- Login Start -->
    <div class="form-container">
        <div class="form-row">
            <div class="form-header">
                <h2 class="form-title">Masuk</h2>
            </div>
            <form class="form-form" action="login.php" method="post">
                <span class="text-danger"><?php if (isset($error)) echo e($error); ?></span>
                <div class="form-controls">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? e($_POST['username']) : '' ?>" required>
                </div>
                <div class="form-controls">
                    <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button name="login">Login</button>
            </form>
            <div class="form-footer">
                <span class="form-link">belum memiliki akun? <a href="register.php">Daftar</a></span>
            </div>
        </div>
    </div>
    <!-- Login ENd -->
</main>
<!-- Main End -->


<?php
// menambahkan Footer
include 'includes/footer.php';
