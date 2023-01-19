    <?php

        // masukkan produk
        if(isset($_POST['add'])){
            
            $product_name = $_POST['name'];
            $product_category = $_POST['category'];
            $product_price = $_POST['price'];
            $product_desc = $_POST['desc'];
        
            $product_image = $_FILES['file']['name'];
            $product_image1 = $_FILES['file1']['name'];
            $product_image2 = $_FILES['file2']['name'];
            $product_image3 = $_FILES['file3']['name'];

            $tmp_product_image = $_FILES['file']['tmp_name'];
            $tmp_product_image1 = $_FILES['file1']['tmp_name'];
            $tmp_product_image2 = $_FILES['file2']['tmp_name'];
            $tmp_product_image3 = $_FILES['file3']['tmp_name'];
            
            move_uploaded_file($tmp_product_image, "assets/images/products/$product_image");
            move_uploaded_file($tmp_product_image1, "assets/images/products/$product_image1");
            move_uploaded_file($tmp_product_image2, "assets/images/products/$product_image2");
            move_uploaded_file($tmp_product_image3, "assets/images/products/$product_image3");
            
            $insert_query = "INSERT INTO products (product_name, category_name, product_price, product_desc, product_image, product_image1, product_image2, product_image3, date) VALUES ('$product_name', '$product_category', '$product_price', '$product_desc', '$product_image', '$product_image1', '$product_image2', '$product_image3', NOW())";
            $result = mysqli_query($conn, $insert_query);

            if($result){
                $message = "Produk ditambahkan!";
                echo"<script>document.location='index.php?products';</script>";
            }
        }                        
    ?>


    <div class="admin">
        <div class="admin-row">
            <h4 class="admin-title">Admin / <i class="fa-brands fa-product-hunt"> </i> Produk</h4>
        </div>
        <div class="admin-row">
            <!-- Menambah Produk Start -->
            <h4 class="admin-add">Tambahkan Produk</h4>
            <div class="admin-add-col">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="name" id="name">
                    </div>
                    <div class="admin-group">
                        <label for="category">Kategori Produk</label>
                        <div class="ui-dropdown">
                            <select id="category" name="category">
                                <?php 
                                    //fetch semua kategori
                                    $query = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_array($result)) {
                                        $name = $row['category_name'];

                                        
                                    ?>
                                <option value="<?php echo $name ?>"><?php echo $name ?></option>
                                <?php 
                                    
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="admin-group">
                        <label for="price">Harga Produk</label>
                        <input type="text" name="price" id="price" require>
                    </div>
                    <div class="admin-group">
                        <label for="desc">Deskripsi Produk</label>
                        <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="admin-group">
                        <label for="file">Gambar Produk</label>
                        <input type="file" name="file" id="file" class="file">
                    </div>
                    <div class="admin-group">
                        <label for="file1">Gambar Produk 1</label>
                        <input type="file" name="file1" id="file1" class="file">
                    </div>
                    <div class="admin-group">
                        <label for="file2">Gambar Produk 2</label>
                        <input type="file" name="file2" id="file2" class="file">
                    </div>
                    <div class="admin-group">
                        <label for="file3">Gambar Produk 3</label>
                        <input type="file" name="file3" id="file3" class="file">
                    </div>
                    <span class="text-success"><?php if (isset($message)) echo $message; ?></span>
                    <div class="admin-group-btn">
                        <button name="add">Tambahkan Produk</button>
                    </div>
                </form>
            </div>
            <!-- Menambah Produk End -->
        </div>
        <div class="admin-row">
            <!-- Show Semua Produk -->
            <?php
            // fetch semua kustomer dari DB

            $per_page = 12; //setiap page ada 12 produk
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $start_from = ($page - 1) * $per_page;
            $query = "SELECT * FROM products ORDER BY 1 DESC LIMIT $start_from, $per_page";
            $result = mysqli_query($conn, $query);

            $count = mysqli_num_rows($result);
            if($count == 0){
                echo"
                <div class='no_found'>
                <h4 class='no_found_title'>saat ini tidak ada produk!</h4></div>
                ";
            } else {
        ?>
            <div class="admin-cards">
                <?php
                    while($row = mysqli_fetch_array($result)){
                        $pro_id = $row['id'];
                        $pro_name = $row['product_name'];
                        $pro_image = $row['product_image'];
                        $pro_desc = $row['product_desc'];
                        $pro_price = $row['product_price'];
                    ?>
                <div class="admin-card">
                    <div class="admin-header">
                        <h5 class="admin-subtitle"><?php echo $pro_name ?></h5>
                    </div>
                    <div class="admin-body">
                        <div class="admin-content image">
                            <img src="assets/images/products/<?php echo $pro_image ?>" alt="<?php echo $pro_name ?>">
                        </div>
                        <div class="admin-content">
                            <p class="admin-desc"><?php echo substr($pro_desc, 0, 10) ?></p>
                        </div>
                        <div class="admin-content price">
                            <span class="admin-price">Rp.<?php echo $pro_price ?></span>
                        </div>
                    </div>
                    <div class="admin-footer">
                        <div class="admin-content">
                            <a href="includes/delete_product.php?pro_id=<?php echo $pro_id; ?>"><i
                                    class="fa fa-trash-alt"></i></a>
                            <a href="includes/update_product.php?pro_id=<?php echo $pro_id; ?>"><i
                                    class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>

                <!-- Show Semua Produk End -->
            </div>
            <!-- Pagination Start -->
            <div class="admin-pagination">
                <ul>
                    <?php
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($conn, $query);
                    $total_record = mysqli_num_rows($result);
                    $total_page = ceil($total_record / $per_page);
                ?>


                    <?php if($page == 1): ?>
                    <?php else: ?>
                    <li class='pagination-menu-item'>
                        <a href='index.php?products&page=<?php echo ($page - 1) ?>'
                            class='pagination-menu-link'>Prev</a>
                    </li>

                    <?php if($page > 2): ?>
                    <li class='pagination-menu-item'>
                        <a href='index.php?products&page=1' class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
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
                        <a href='index.php?products&page=<?php echo $page - 1 ?>'
                            class='pagination-menu-link <?php echo $_GET['page'] == "$page  - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                    </li>
                    <?php endif ?>
                    <li class='pagination-menu-item'>
                        <a class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?>'><?php echo $page?></a>
                    </li>

                    <?php if ($page + 1 < $total_page): ?>
                    <li
                        class='pagination-menu-item '>
                        <a href='index.php?products&page=<?php echo $page + 1 ?>' class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'>
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
                        <a href='index.php?products&page=<?php echo $total_page?>'
                            class='pagination-menu-link <?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'><?php echo $total_page ?></a>
                    </li>
                    <li class='pagination-menu-item'>
                        <a href='index.php?products&page=<?php echo ($page + 1) ?>'
                            class='pagination-menu-link'>Next</a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
            <!-- pagination end -->

            <?php 
                }
            ?>
        </div>