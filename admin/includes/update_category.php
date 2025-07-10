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

    // untuk mengupdate category
    if(isset($_GET['update_cat'])){
        $category_id = $_GET['update_cat'];
        
        $query = "SELECT * FROM category WHERE id = '$category_id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        $category_name = $row['category_name'];
    }

    //update category
            if(isset($_POST['update'])) {

            $cat_name = $_POST['name'];

            $update_query = "UPDATE category SET category_name = '$cat_name', date = NOW() WHERE id = '$category_id'";

            $run_update = mysqli_query($conn, $update_query);

            if($run_update){
                $update_mess = "Update Sukses!";
                echo"<script>document.location='../index.php?category';</script>";
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
                <a href="../index.php?category" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_category.php?delete_cat=<?php echo $category_id; ?>" class="delete_product">Hapus
                    Kategori
                    <i class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update Kategori</h2>
            </div>
            <div class="order-row update">
                <span class="text-success">
                    <?php if (isset($update_mess)) echo $update_mess; ?></span>
                <form action="" method="post">
                    <div class="admin-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="name" id="name" value="<?php echo $category_name; ?>">
                    </div>
                    <div class="admin-group-btn custom">
                        <button name="update">Update Kategori</button>
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