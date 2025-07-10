        <?php
            // menambahkan Header
            include 'includes/header.php';

            // pendaftaran User
            if(isset($_POST['register'])){

            $userip = getUserIP();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];

            // hashed password
            $hashed_pass = md5($password);
            $hashed_c_pass = md5($c_password);

            // Cek Email
            if ($email){
                $query = "SELECT * FROM users WHERE email = '$email' ";
                $result = mysqli_query($conn, $query);
                $count = mysqli_num_rows($result);

                if($count > 0){
                    $email_error = "Email Sudah Ada, Coba Lagi!";
                // echo "<script>alert('Email Sudah Ada, Coba Lagi!');</script>";
                // echo "<script>document.location='register.php';</script>";
                } else {
                    if(strlen($password )< 5){
                        $pass_error = "Password minimal harus 5 karakter";
                    } else {
                        // mengecek password == confirm_password
            if($hashed_pass == $hashed_c_pass){
                // masukkan ke dalam tabel users
                $query = "INSERT INTO users(user_ip, username, email, password, date) VALUES('$userip', '$username','$email','$hashed_pass', now())";
                $result = mysqli_query($conn, $query);

                if($result){
                // echo "<script>alert('Pendaftaran User Berhasil!');</script>";
                echo "<script>document.location='login.php';</script>";
                }
            
            }   else {
                $c_pass_error = "Password Tidak Sama, Coba Lagi!";
                // echo "<script>alert('Password Tidak Sama, Coba Lagi!');</script>";
                // echo "<script>document.location='register.php';</script>";
            }
                    }
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
                        <h2 class="form-title">Buat Akun</h2>
                    </div>
                    <form class="form-form" action="" method="post">
                        <div class="form-controls">
                            <label for="username">
                                Username
                            </label>
                            <input type="text" name="username" id="username" required>
                        </div>
                        <div class="form-controls">
                            <label for="email">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" required>
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
        ?>