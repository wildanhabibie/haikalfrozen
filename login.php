<?php
require_once 'includes/init.php';

// sudah login? langsung ke beranda
if (!empty($currentUser)) {
    redirect('index.php');
}

// login
if (isset($_POST['login'])) {
    $username = db_esc($_POST['username']);
    $hash_password = md5($_POST['password']);

    $result = q("SELECT * FROM users WHERE username = '$username' AND password = '$hash_password'");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    if (!$row) {
        $error = "Username dan Password Salah!";
    } elseif ((int) $row['user_block'] === 1) {
        $error = "Akun ini diblokir!";
    } else {
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
