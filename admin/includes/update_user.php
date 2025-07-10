<?php

    // menambahkan file database

    include "db.php";
    
    session_start();

    // memberi tahu iseet admin
    if(isset($_SESSION['customerName'])){
     $currentUser = $_SESSION['customerName'];
    } else {
        echo"<script>document.location='../login.php';</script>";
    }

    // untuk mengupdate user
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        
        $query = "SELECT * FROM users WHERE id = '$user_id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        $userIP = $row['user_ip'];
        $customer_name = $row['username'];
        $customer_email = $row['email'];
        $customer_pass = $row['password'];
        $customer_block = $row['user_block'];

        $customer_image = $row['user_image'];
        $hidden_image = $customer_image;
    }

    //update user
    //  update informasi user
            if(isset($_POST['update'])) {

            $username = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $hash_pass = md5($password);

            $image = $_FILES['image']['name'];
            $temp_image = $_FILES['image']['tmp_name'];

            //check password sama
            if(isset($password) && $password !=""){

                if(isset($temp_image) && $temp_image != ""){

                    // ketika saya ingin merubah foto profile
                    move_uploaded_file($temp_image, "../../assets/images/customers/$image");
                    
                    $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$hash_pass', 
                    user_image = '$image', date = NOW() WHERE id = '$user_id'";

                    $run_update = mysqli_query($conn, $update_query);

                    if($run_update){
                        $update_mess = "Update Sukses!";
                    }

                } else {
                    //ketika saya tidak ingin merubah foto profil
                    $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$hash_pass', 
                    user_image = '$hidden_image', date = NOW() WHERE id = '$user_id'";

                    $run_update = mysqli_query($conn, $update_query);

                    if($run_update){
                        $update_mess = "Update Sukses!";
                    }

            }

            echo"<script>document.location='../index.php?users';</script>";
            
            } else {

            if(isset($temp_image) && $temp_image != ""){
                // ketika saya ingin merubah foto profile
                 move_uploaded_file($temp_image, "../../assets/images/customers/$image");
                
                $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$customer_pass', 
                user_image = '$image', date = NOW() WHERE id = '$user_id'";

                $run_update = mysqli_query($conn, $update_query);

                if($run_update){
                    $update_mess = "Update Sukses!";
                }

            } else {
                //ketika saya tidak ingin merubah foto profil
                $update_query = "UPDATE users SET user_ip='$userIP', username = '$username', email = '$email', password = '$customer_pass', 
                user_image = '$hidden_image', date = NOW() WHERE id = '$user_id'";

                $run_update = mysqli_query($conn, $update_query);

                if($run_update){
                    $update_mess = "Update Sukses!";
                    
                }

            }
            echo"<script>document.location='../index.php?users';</script>";
            }
        }
        //Block User
        if(isset($_POST['block'])){
            
            if($customer_block == 0){
                $update_block = "UPDATE users SET user_block='1' WHERE id = '$user_id'";
                $result_block = mysqli_query($conn, $update_block);

                if($result_block) {
                    $update_mess = "User diblokir!";
                }
            } else {
                $update_block = "UPDATE users SET user_block='0' WHERE id = '$user_id'";
                $result_block = mysqli_query($conn, $update_block);
                
                if($result_block) {
                    $update_mess = "User tidak diblokir!";
                }
            }

        }  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link Start -->
    <link rel="stylesheet" href="../assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Link End -->
</head>

<body>
    <!-- Main Start -->
    <main id="main">
        <!-- Order Start -->
        <div class="order-container">
            <div class="order-row">
                <a href="../index.php?users" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_user.php?user_id=<?php echo $user_id; ?>" class="delete_product">Hapus User <i
                        class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update User</h2>
            </div>
            <div class="order-row update">
                <span class="text-danger user">
                    <?php if (isset($update_mess)) echo $update_mess; ?></span>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama User</label>
                        <input type="text" name="name" id="name" value="<?php echo $customer_name; ?>">
                    </div>
                    <div class="admin-group">
                        <label for="email">Email User</label>
                        <input type="text" name="email" id="email" value="<?php echo $customer_email; ?>">
                    </div>
                    <div class="admin-group">
                        <label for="image">User Image</label>
                        <?php 
                            // mengecek jika gambar user kelihatan atau tidak
                            if(!empty($customer_image)) {
                                echo "<img src='../../assets/images/customers/$customer_image' alt='$customer_name'>";
                            } else {
                                echo "<img src='../../assets/images/customers/user.png' alt='$customer_name'>";
                            }
                    ?>
                        <input type="file" name="image" id="user_image" class="custom-file-input">
                        <input type="hidden" value="<?php echo $hidden_image; ?>">
                    </div>
                    <div class="admin-group">
                        <label for="password">Password User</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="admin-group">
                        <?php
                        if($customer_block == 0){
                            echo "<label for='block'>Unblokir User</label>
                            <button name='block' class='block-btn'><i class='fa-solid fa-ban'></i>Unblock
                            </button>";
                        } else {
                            echo "<label for='block'>Blokir User</label>
                            <button name='block' class='block-btn'><i class='fa-solid fa-ban'></i>Block
                            </button>";
                        }
                        ?>
                    </div>
                    <div class="admin-group-btn custom">
                        <button name="update">Update User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order End -->
    </main>
    <!-- Main End -->
    <!-- Scripts Start -->
    <script src="../assets/js/jquery/jquery.min.js"></script>
    <script src="../assets/fonts/font_awesome/js/all.js"></script>
    <script src="../assets/js/main.js"></script>
    <!-- Scripts End -->
</body>

</html>