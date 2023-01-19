<?php 
// menambahkan file database

    include "db.php";
    
    session_start();

     // mendapatkan ID produk
    if(isset($_GET['pro_id'])){
        $pro_id = $_GET['pro_id'];

        $query = "SELECT * FROM products WHERE id = '$pro_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $pro_name = $row['product_name'];

    }

    // memberi tahu iseet admin
    if(isset($_SESSION['customerName'])){
     $currentUser = $_SESSION['customerName'];
    } else {
        echo"<script>document.location='../login.php';</script>";
    }

      //tambahkan ukuran
    if(isset($_POST['add'])) {
        $pro_size = $_POST['size'];

        $size_rand = rand(0, 100);

        $query = "INSERT into sizes (product_id, size_rand, product_size, date) VALUES ('$pro_id', '$size_rand', '$pro_size', NOW())";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Ukuran ditambahkan!";
            echo"<script>document.location='add_size.php?pro_id=$pro_id';</script>";
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
        <!-- Attributes page Start -->
        <div class="order-container">
            <div class="order-row">
                <a href="../index.php?products" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="order-row attributes">
                <div class="attributes-col">
                    <h2>Tambahkan Ukuran</h2>
                    <span class="text-success attributes"><?php if (isset($message)) echo $message;?></span>
                    <form method="post">
                        <input type="text" name="size" placeholder="Pilih Ukuran Disini" required>
                        <button class="" name="add">Tambah</button>
                    </form>
                </div>
                <div class="attributes-col">
                    <h2><?php echo $pro_name ?></h2>
                    <?php 
                    
                    $query = "SELECT * from sizes where product_id = '$pro_id'";
                    $result = mysqli_query($conn, $query);

                    $count = mysqli_num_rows($result);
                    if($count == 0){
                        echo "
                            <div class='no_found_title'>
                           <p>Tidak ada ukuran yang tersedia di produk ini</p>
                            </div>
                        ";
                    } else {

                    ?>
                    <div class="attributes-groups">
                        <?php 
                        
                        while($row = mysqli_fetch_array($result)){
                            $product_id = $row['product_id'];
                            $product_size = $row['product_size'];
                            $size_rand_id = $row['size_rand'];
                        
                        ?>
                        <div class="attribute-group">
                            <span><?php echo $product_size ?></span>
                            <a href="delete_size.php?size_id=<?php echo $size_rand_id ?>"><i
                                    class="fa fa-trash-alt"></i></a>
                        </div>
                        <?php 
                            }
                        ?>
                    </div>
                    <?php
                    }
                    ?>
                </div>
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

    <?php 
    
     
    
    ?>


</body>

</html>