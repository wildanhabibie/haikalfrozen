                    <?php
            // menambahkan Header
            include 'includes/header.php';

             $currentUser = $_SESSION['customerName'];
             // mengecek jika tidak ada user yang pergi ke homepage
             if(!isset($currentUser)){
                echo"<script>document.location='index.php';</script>";
             }

             $query = "SELECT * FROM users WHERE username='$currentUser'";
             $result = mysqli_query($conn,$query);
             $row = mysqli_fetch_array($result);
 
             $user_email = $row['email'];
             $user_image = $row['user_image'];
             $hidden_image = $user_image;
            ?>

                    <!-- Main Start -->
                    <main id="main">
                        <!-- Account Start -->
                        <div class="account-container">
                            <div class="account-row">
                                <h3 class="account-title">Akun Saya</h3>
                            </div>
                            <div class="account-row">
                                <div class="account-col">
                                    <h4 class="account-order">
                                        Pesanan Saya
                                    </h4>
                                         <?php
                                        // fetch semua kustomer dari DB

                                        $per_page = 12; //setiap page ada 12 produk
                                        if(isset($_GET['page'])){
                                            $page = $_GET['page'];
                                        } else {
                                            $page = 1;
                                        }

                                        $i = 0;
                                        
                                        $start_from = ($page - 1) * $per_page;
                                        $ip_add = getUserIP();
                                        $query_order = "SELECT * FROM orders WHERE user_ip='$ip_add' GROUP BY invoice_no ORDER BY 1 DESC LIMIT $start_from, $per_page";
                                        $result_order = mysqli_query($conn, $query_order);

                                        $count = mysqli_num_rows($result_order);
                                        if($count == 0){
                                            echo"
                                            <div class='no_found'>
                                            <h4 class='no_found_title'>saat ini tidak ada pesanan!</h4></div>
                                            ";
                                        } else {
                                        ?>
                                    <div class="all-orders">
                                    <?php
                                    while($row_order = mysqli_fetch_array($result_order)){
                                        $order_id = $row_order['invoice_no'];

                                        $i++;
                                    ?>
                                    <div class="all-orders-group">
                                        <span><?php echo $i?>. Order ID : <?php echo $order_id?></span>
                                        <div class="account-action">
                                            <a href="order.php?order_no=<?php echo $order_id?>"><i class="fa fa-eye"></i></a>
                                            <a href="account.php?del_no=<?php echo $order_id?>"><i class="fa fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                        ?>
                                        </div>
                                    <!-- Pagination Start -->
                                    <div class="admin-pagination">
                                        <ul>
                                            <?php
                                            $query_all = "SELECT * FROM orders WHERE user_ip='$ip_add'";
                                            $result_all = mysqli_query($conn, $query_all);
                                            $total_record = mysqli_num_rows($result_all);
                                            $total_page = ceil($total_record / $per_page);
                                        ?>


                                            <?php if($page == 1): ?>
                                            <?php else: ?>
                                            <li class='pagination-menu-item'>
                                                <a href='account.php?page=<?php echo ($page - 1) ?>'
                                                    class='pagination-menu-link'>Prev</a>
                                            </li>

                                            <?php if($page > 2): ?>
                                            <li class='pagination-menu-item'>
                                                <a href='account.php?page=1' class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                                            </li>
                                            <?php endif ?>

                                            <?php if($page > 3): ?>
                                            <li class='pagination-menu-item'>
                                                <a class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                                            </li>
                                            <?php endif ?>

                                            <?php endif ?>
                                            <?php if($page - 1 > 0): ?>
                                            <li class='pagination-menu-item '>
                                                <a href='account.php?page=<?php echo $page - 1 ?>'
                                                    class='pagination-menu-link <?php echo $_GET['page'] == "$page  - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                                            </li>
                                            <?php endif ?>
                                            <li class='pagination-menu-item'>
                                                <a class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?>'><?php echo $page?></a>
                                            </li>

                                            <?php if ($page + 1 < $total_page): ?>
                                            <li
                                                class='pagination-menu-item '>
                                                <a href='account.php?page=<?php echo $page + 1 ?>' class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'>
                                                    <?php echo $page + 1 ?></a>
                                            </li>
                                            <?php endif ?>

                                            <?php if ($page < $total_page): ?>
                                            <?php if($page < $total_page - 2): ?>
                                            <li class='pagination-menu-item'>
                                                <a class='pagination-menu-link <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>...</a>
                                            </li>
                                            <?php endif ?>
                                            <li class='pagination-menu-item'>
                                                <a href='account.php?page=<?php echo $total_page?>'
                                                    class='pagination-menu-link <?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'><?php echo $total_page ?></a>
                                            </li>
                                            <li class='pagination-menu-item'>
                                                <a href='account.php?page=<?php echo ($page + 1) ?>'
                                                    class='pagination-menu-link'>Next</a>
                                            </li>
                                            <?php endif ?>
                                        </ul>
                                    </div>
                                    <!-- pagination end -->

                                <?php 
                                    }
                                ?>
                                <?php
                        
                        //delete item
                        if(isset($_GET['del_no'])){
                            include("includes/delete_order.php");
                        }

                        ?>
                                </div>
                                <div class="account-col">
                                    <h4 class="account-settings">
                                        Pengaturan Akun
                                    </h4>
                                    <div class="forms">
                                        <span class="text-danger">
                                            <?php if (isset($update_mess)) echo $update_mess; ?></span>
                                        <span class="text-danger">
                                            <?php if (isset($r_pass_err)) echo $r_pass_err; ?></span>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="account-groups">
                                                <?php 
                                                if(!empty($user_image)){
                                                    echo "<img src='assets/images/customers/$user_image'alt='$currentUser'>";
                                                } else {
                                                    echo "<img src='assets/images/customers/user.png'alt='$currentUser'>";
                                                }
                                                ?>
                                                <input type="file" name="image" value="" class="custom-file-input">
                                                <input type="hidden" value="<?php echo $hidden_image ?>">
                                            </div>
                                            <div class="account-groups">
                                                <label for="name">Name</label>
                                                <input class="account-input" name="username" type="text" id="name"
                                                    value="<?php echo $currentUser; ?>">
                                            </div>
                                            <div class="account-groups">
                                                <label for="email">Email</label>
                                                <input class="account-input" name="email" type="email" id="email"
                                                    value="<?php echo $user_email;?>">
                                            </div>
                                            <div class="account-groups"><label for="password">Password</label>
                                                <input class="account-input" type="password" name="password"
                                                    id="password" required>
                                            </div>
                                            <div class="account-groups">
                                                <label for="c_password">tulis ulang password</label>
                                                <input class="account-input" type="password" name="r_password"
                                                    id="c_password" required>
                                            </div>
                                            <button name="update" class="account-btn">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Account End -->
                    </main>
                    <!-- Main End -->
                    <?php
            // menambahkan Footer
            include 'includes/footer.php';
            //  update informasi user
            if(isset($_POST['update'])) {

            $userIP = getUserIP();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $r_password = $_POST['r_password'];

            $hash_pass = md5($password);
            $r_hash_pass = md5($r_password);

            if($password == $r_password){

            $image = $_FILES['image']['name'];
            $temp_image = $_FILES['image']['tmp_name'];

            if(isset($temp_image) && $temp_image != ""){
                // ketika saya ingin merubah foto profile
                 move_uploaded_file($temp_image, "assets/images/customers/$image");
                
                $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$hash_pass', user_image = '$image', date = NOW() WHERE username = '$currentUser'";

                $run_update = mysqli_query($conn, $update_query);

                if($run_update){
                    $update_mess = "Update Sukses!";
                    session_destroy();
                    echo"<script>document.location='login.php'</script>";
                }

            } else {
                //ketika saya tidak ingin merubah foto profil
                $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$hash_pass', user_image = '$hidden_image', date = NOW() WHERE username = '$currentUser'";

                $run_update = mysqli_query($conn, $update_query);

                if($run_update){
                    $update_mess = "Update Sukses!";
                    session_destroy();
                    echo"<script>document.location='login.php'</script>";
                }

            }
            
            } else {
                $r_pass_err = "Password Baru dan Konfirmasi tidak Cocok!";
            }
        }  
            
        ?>