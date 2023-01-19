<?php
            session_start();
            // Includes DB File
            include 'includes/db.php';
            
            if(isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $hash_password = md5($password);

                // Query
                $query = "SELECT * FROM admin_account WHERE admin_name = '$username' AND admin_password = '$hash_password'";
                $result = mysqli_query($conn, $query);
                // if
                if(mysqli_num_rows($result) == 1) {
                    $_SESSION['customerName'] = $_POST['username'];
                    $success = "Login Berhasil!";
                    echo"<script>document.location='index.php?dashboard';</script>";
                }
                // else
                else{
                    $error = "Nama dan Password Salah";
                }
            }
            
        ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <form class="form-form" action="" method="post">
                <span class="text-danger"><?php if (isset($success)) echo $success; ?></span>
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
    <script src="assets/js/main.js"></script>
    <!-- Scripts End -->
</body>

</html>