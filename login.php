<?php
            // menambahkan Header
            include 'includes/header.php';

            // login
            if(isset($_POST['login'])){
                $username = $_POST['username'];
                $password = $_POST['password'];

                $hash_password = md5($password);

                //Query
                $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hash_password' ";
                $result = mysqli_query($conn , $query);
                $row = mysqli_fetch_array($result);

                $user_block = isset($row['user_block']) ? $row['user_block'] : '';

                //Check for block
                if($user_block == 1) {
                    $error = "Akun ini diblokir!";
                } else {
                     //if
                if(mysqli_num_rows($result) == 1){
                    $_SESSION['customerName'] = $_POST['username'];
                    echo"<script>document.location='index.php';</script>";
                } 
                //else
                else {
                    $error = "Username dan Password Salah!";
                }
                }
            }
            ?>


<!-- Main Start -->
<main id="main">
    <!-- Login Start -->
    <div class="form-container">
        <div class="form-row">
            <div class="form-header">
                <h2 class="form-title">Masuk</h2>
            </div>
            <form class="form-form" action="" method="post">
                <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                <div class="form-controls">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
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
            include 'includes/footer.php'
        ?>