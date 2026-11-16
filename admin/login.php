<?php
require_once __DIR__ . '/includes/init.php';

// sudah login? langsung ke dashboard
if (!empty($_SESSION['adminName'])) {
    redirect('index.php?dashboard');
}

if (isset($_POST['login'])) {
    $username = db_esc($_POST['username']);
    $hash_password = md5($_POST['password']);

    $result = q("SELECT * FROM admin_account WHERE admin_name = '$username' AND admin_password = '$hash_password'");
    if (q_count($result) == 1) {
        session_regenerate_id(true);
        // session admin terpisah dari session pelanggan
        $_SESSION['adminName'] = $_POST['username'];
        redirect('index.php?dashboard');
    }
    $error = "Nama dan Password Salah";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Link Start -->
    <link rel="stylesheet" href="../assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Link End -->
</head>

<body>
    <!-- login start -->
    <div class="form-container">
        <div class="form-row">
            <div class="form-header">
                <h2 class="form-title">Admin Login</h2>
            </div>
            <form class="form-form" action="login.php" method="post">
                <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                <div class="form-controls">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-controls">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button name="login">Login</button>
            </form>
        </div>
    </div>
    <!-- Login End -->
    <!-- Scripts Start -->
    <script src="assets/fonts/font_awesome/js/all.js"></script>
    <!-- Scripts End -->
</body>

</html>