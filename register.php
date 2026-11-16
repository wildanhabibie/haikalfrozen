<?php
require_once 'includes/init.php';

// pendaftaran User
if (isset($_POST['register'])) {
    $userip = db_esc(getUserIP());
    $username = db_esc($_POST['username']);
    $email = db_esc($_POST['email']);
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if ($username === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_error = "Username dan email harus diisi dengan benar!";
    } elseif (q_count(q("SELECT id FROM users WHERE email = '$email'")) > 0) {
        $email_error = "Email Sudah Ada, Coba Lagi!";
    } elseif (q_count(q("SELECT id FROM users WHERE username = '$username'")) > 0) {
        $email_error = "Username Sudah Dipakai, Coba Lagi!";
    } elseif (strlen($password) < 5) {
        $pass_error = "Password minimal harus 5 karakter";
    } elseif ($password !== $c_password) {
        $c_pass_error = "Password Tidak Sama, Coba Lagi!";
    } else {
        $hashed_pass = db_esc(hash_password($password));
        $ok = q("INSERT INTO users (user_ip, username, email, password, user_image, user_block, date)
                 VALUES ('$userip', '$username', '$email', '$hashed_pass', '', 0, NOW())");
        if ($ok) {
            redirect('login.php', 'Pendaftaran berhasil, silakan login.');
        }
        $email_error = "Pendaftaran gagal, coba lagi!";
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
                        <h2 class="form-title">Buat Akun</h2>
                    </div>
                    <form class="form-form" action="register.php" method="post">
                        <div class="form-controls">
                            <label for="username">
                                Username
                            </label>
                            <input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? e($_POST['username']) : '' ?>" required>
                        </div>
                        <div class="form-controls">
                            <label for="email">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? e($_POST['email']) : '' ?>" required>
                        </div>
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error;?></span>
                        <div class="form-controls">
                            <label for="password">
                                Kata Sandi
                            </label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <span class="text-danger"><?php if (isset($pass_error)) echo $pass_error;?></span>
                        <div class="form-controls">
                            <label for="c_password">
                                Konfirmasi Kata Sandi
                            </label>
                            <input type="password" name="c_password" id="c_password" required>
                        </div>
                        <span class="text-danger"><?php if (isset($c_pass_error)) echo $c_pass_error;?></span>
                        <button name="register">Daftar</button>
                    </form>
                    <div class="form-footer">
                        <span class="form-link">
                            Sudah memiliki akun? <a href="login.php">
                                Masuk
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Login ENd -->
        </main>
        <!-- Main End -->


        <?php
// menambahkan Footer
include 'includes/footer.php';
