<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// produk yang diberi atribut
$pro_id = isset($_GET['pro_id']) ? (int) $_GET['pro_id'] : 0;
$result = q("SELECT * FROM products WHERE id = '$pro_id'");
$row = $result ? mysqli_fetch_assoc($result) : null;
if (!$row) {
    redirect('../index.php?products', 'Produk tidak ditemukan!');
}
$pro_name = e($row['product_name']);

// tambahkan jenis
if (isset($_POST['add'])) {
    $value = db_esc($_POST['jenis']);
    if ($value !== '') {
        q("INSERT INTO jenis (product_id, jenis_rand, jenis_name, date) VALUES ('$pro_id', 0, '$value', NOW())");
    }
    redirect("add_jenis.php?pro_id=$pro_id");
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
                <a href="update_product.php?pro_id=<?php echo $pro_id ?>" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="order-row attributes">
                <div class="attributes-col">
                    <h2>Tambahkan Jenis</h2>
                                        <form method="post" action="add_jenis.php?pro_id=<?php echo $pro_id ?>">
                        <input type="text" name="jenis" placeholder="Pilih jenis Disini" required>
                        <button class="" name="add">Tambah</button>
                    </form>
                </div>
                <div class="attributes-col">
                    <h2><?php echo $pro_name ?></h2>
                    <?php 
                    
                    $result = q("SELECT * FROM jenis WHERE product_id = '$pro_id' ORDER BY id");
                    $count = q_count($result);
                    if($count == 0){
                        echo "
                            <div class='no_found_title'>
                           <p>Tidak ada jenis yang tersedia di produk ini</p>
                            </div>
                        ";
                    } else {

                    ?>
                    <div class="attributes-groups">
                        <?php 
                        
                        while($row = mysqli_fetch_assoc($result)){
                            $product_id = $row['product_id'];
                            $product_jenis = e($row['jenis_name']);
                            $jenis_rand_id = (int) $row['id'];
                        
                        ?>
                        <div class="attribute-group">
                            <span><?php echo $product_jenis ?></span>
                            <a href="delete_jenis.php?jenis_id=<?php echo $jenis_rand_id ?>"><i
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
    <!-- Scripts End -->

    <?php 
    
     
    
    ?>


</body>

</html>