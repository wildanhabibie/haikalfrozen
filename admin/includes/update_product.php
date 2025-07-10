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
    if(isset($_GET['pro_id'])){
        $product_id = $_GET['pro_id'];
        
        $query = "SELECT * FROM products WHERE id = '$product_id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

         $product_name = $row['product_name'];
         $category_name = $row['category_name'];
         $product_price = $row['product_price'];
         $product_desc = $row['product_desc'];
         $product_image = $row['product_image'];
         $product_image1 = $row['product_image1'];
         $product_image2 = $row['product_image2'];
         $product_image3 = $row['product_image3'];
    }

    if(isset($_POST['update'])) {

            $pro_name = $_POST['name'];
         $cat_name = $_POST['category'];
         $pro_price = $_POST['price'];
         $pro_desc = $_POST['desc'];
         
         $pro_image = $_FILES['file']['name'];
         $pro_image1 = $_FILES['file1']['name'];
         $pro_image2 = $_FILES['file2']['name'];
         $pro_image3 = $_FILES['file3']['name'];

        $temp_image = $_FILES['file']['tmp_name'];
        $temp_image1 = $_FILES['file1']['tmp_name'];
        $temp_image2 = $_FILES['file2']['tmp_name'];
        $temp_image3 = $_FILES['file3']['tmp_name'];

        move_uploaded_file($temp_image, "../assets/images/products/$product_image");
        move_uploaded_file($temp_image1, "../assets/images/products/$product_image1");
        move_uploaded_file($temp_image2, "../assets/images/products/$product_image2");
        move_uploaded_file($temp_image3, "../assets/images/products/$product_image3");

        $update_query = "UPDATE products SET product_name='$pro_name', category_name = '$cat_name', product_price ='$pro_price',
        product_desc = '$pro_desc', product_image = '$pro_image', product_image1 = '$pro_image1', product_image2 = '$pro_image2',
        product_image3 = '$pro_image3', date= NOW() WHERE id = '$product_id'";
        
        $run_update = mysqli_query($conn, $update_query);

            if($run_update){
                $update_mess = "Update Sukses!";
                echo"<script>document.location='../index.php?products';</script>";
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
                <a href="../index.php?products" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_product.php?pro_id=<?php echo $product_id; ?>" class="delete_product">Hapus Produk
                    <i class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update Produk</h2>
            </div>
            <div class="order-row update">
                <span class="text-success">
                    <?php if (isset($update_mess)) echo $update_mess; ?></span>
                <form method="post" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="name" id="name" value="<?php echo $product_name ?>">
                    </div>
                    <div class="admin-group">
                        <label for="category">Kategori Produk</label>
                        <div class="ui-dropdown">
                            <select id="category" name="category">
                                <option value="<?php echo $category_name ?>"><?php echo $category_name ?></option>
                                <?php
                                    $query = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_array($result)){
                                        
                                        $cat_id = $row['id'];
                                        $cat_name = $row['category_name'];
                                        echo "<option value='$cat_id'>$cat_name</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="admin-group">
                        <label for="price">Harga Produk</label>
                        <input type="text" name="price" id="price" value="<?php echo $product_price ?>">
                    </div>
                    <div class="admin-group">
                        <label for="desc">Deskripsi Produk</label>
                        <textarea name="desc" id="desc" cols="30" rows="10"><?php echo $product_desc ?></textarea>
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk 1</label>
                        <input type="file" name="file" id="file" class="file">
                        <input type="hidden" value="<?php echo $product_image ?>">
                        <img src="../assets/images/products/<?php echo $product_image ?>" class="img-update"
                            alt="<?php echo $product_name ?>">
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk 2</label>
                        <input type="file" name="file1" id="file" class="file">
                        <input type="hidden" value="<?php echo $product_image1 ?>">
                        <img src="../assets/images/products/<?php echo $product_image1 ?>" class="img-update"
                            alt="<?php echo $product_name ?>">
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk 3</label>
                        <input type="file" name="file2" id="file" class="file">
                        <input type="hidden" value="<?php echo $product_image2 ?>">
                        <img src="../assets/images/products/<?php echo $product_image2 ?>" class="img-update"
                            alt="<?php echo $product_name ?>">
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk 4</label>
                        <input type="file" name="file3" id="file" class="file">
                        <input type="hidden" value="<?php echo $product_image3 ?>">
                        <img src="../assets/images/products/<?php echo $product_image3 ?>" class="img-update"
                            alt="<?php echo $product_name ?>">
                    </div>
                    <div class="admin-group-btn custom">
                        <button name="update">Update Produk</button>
                    </div>
                </form>
                <div class="attributes-group">
                    <h3>Tambah Atribut</h3>
                    <div class="attribute">
                        <a href="add_jenis.php?pro_id=<?php echo $product_id?>">Jenis</a>
                        <a href="add_size.php?pro_id=<?php echo $product_id?>">Ukuran</a>
                    </div>
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