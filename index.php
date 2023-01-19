<?php
            // menambahkan Header
            include 'includes/header.php';

             $queryCat = "SELECT * FROM category";
             $resultCat = mysqli_query($conn, $queryCat);
             $rowCat = mysqli_fetch_array($resultCat);
            
             $cat_id = $rowCat['id'];
             $cat_name = $rowCat['category_name'];

            //  untuk menambah wish
            if(isset($_GET['add_wish'])){

                $wish_id = $_GET['add_wish'];
                $ip_add = getUserIP();
    
                $check_query = "SELECT * FROM wish WHERE product_id = '$wish_id'";
                $check_result = mysqli_query($conn, $check_query);
    
                // jika ada
                if (mysqli_num_rows($check_result) > 0) {
                    echo "<script>alert('Produk sudah ditambahkan di daftar wish!')</script>";
                    echo "<script>window.open('index.php', '_self')</script>";
                } else {
                    
                    //jika tidak ada lalu ditambahkan ke wish
                    $query_add = "INSERT INTO wish (ip_add, product_id, date) VALUES ('$ip_add', '$wish_id', now())";
    
                    $query_run = mysqli_query($conn, $query_add);
                    echo "<script>alert('Produk ditambahkan ke daftar wish!')</script>";
                    echo "<script>window.open('wish.php', '_self')</script>";
                }
    
                }
        ?>

        <!-- Main Start -->
        <main id="main">
            <!-- Kategori Produk Home Start -->

            <div id="category">
                <div class="category-row">
                    <!-- Kolom Kiri Start -->
                    <div class="category-col">
                        <img src="assets/images/category_images/nugget_2.png" alt="Nugget">
                        <div class="category-content">
                            <a href="shop.php?cat_id=<?php echo $cat_id ?>"><?php echo $cat_name ?></a>
                        </div>
                    </div>
                    <!-- Kolom Kiri End -->

                    <!-- Kolom Kanan Start -->
                    <div class="category-col">
                        <img src="assets/images/category_images/fishstick_1.png" alt="Gorengan">
                        <div class="category-content">
                            <a href="#">Gorengan</a>
                        </div>
                    </div>
                    <!-- Kolom Kanan End -->
                </div>
            </div>
            <!-- Kategori Produk Home End -->

            <!-- Banners start -->
            <div class="banners-container">
                <div class="banners-row">
                    <div class="banners-col">
                        <i class="fa-regular fa-face-smile-wink"></i>
                        <h5>Pelayanan Ramah</h5>
                    </div>
                    <div class="banners-col">
                        <i class="fa-solid fa-circle-check"></i>
                        <h5>Harga Terjangkau</h5>
                    </div>
                    <div class="banners-col">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <h5>Lengkap</h5>
                    </div>
                    <div class="banners-col">
                        <i class="fa-solid fa-location-pin"></i>
                        <h5>Lokasi dekat</h5>
                    </div>
                </div>
                <div class="banners-row-two">
                    <div class="banners-col-two">
                        <img src="assets/images/category_images/nugget_banners.png" alt="banners 1">
                    </div>
                    <div class="banners-col-two">
                        <div class="banners-div">
                            <div class="banners-content">
                                <p>Nikmatnya</p>
                                <h2>Makanan</h2>
                                <span>Dalam Kesederhanaan</span>
                            </div>
                            <a href="shop.php">produk terbaru <br> bulan ini</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banners end -->

            <!-- Produk Baru Start -->
            <div class="new-products">
                <div class="new-products-container">
                    <div class="new-products-row">
                        <div class="new-products-col">
                            <h2 class="new-products-title">Produk Terbaru</h2>
                        </div>
                        <div class="new-products-col">
                            <?php 
                            // fetch semua produk
                                $query = "SELECT * FROM products ORDER BY 1 DESC LIMIT 4";
                                $result = mysqli_query($conn, $query);
                                $count = mysqli_num_rows($result);

                            ?>
                            <div class="cards">
                                <?php 
                                    if($count == 0){
                                        echo "<h2 class='no-products'>Produk Belum Tersedia.</h2>";
                                    } else {

                                    while($row = mysqli_fetch_array($result)) {
                                        $product_id = $row['id'];
                                        $product_name = $row['product_name'];
                                        $product_desc = $row['product_desc'];
                                        $product_price = $row['product_price'];
                                        $product_image = $row['product_image'];

                                        $query_rev = "SELECT * FROM reviews WHERE review_product_id = '$product_id'";
                                        $result_rev = mysqli_query($conn, $query);
                                        $count_rev = mysqli_num_rows($result);
                                        // echo $count;

                                        // get sum
                                        $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$product_id'";
                                        $result_sum = mysqli_query($conn, $get_sum);
                                        $row = mysqli_fetch_assoc($result_sum);

                                        $sub_total = $row['totalStar'];
                                        //echo $sub_total;

                                ?>
                                <a href='product.php?pro_id=<?php echo $product_id ?>'>
                                <div class="card_container">
                                    <span class="new-product"></span>
                                    <div class="card_top_section">
                                        <img class="card-img" src="assets/images/product_images/<?php echo $product_image ?>">
                                        <div class="card_top_section_icons">
                                        <div>    
                                        <form action="index.php?add_wish=<?php echo $product_id ?>" method="post">
                                                <button class="add_wish" type="submit"><i class="far fa-heart"></i></button>
                                            </form>
                                            </div>
                                            <div>
                                                <a href="product.php?pro_id=<?php echo $product_id ?>"><i class="fas fa-shopping-basket"></i></a>
                                            </div>
                                            <div class="hide-div">
                                                <a class="btn-view"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card_body_section">
                                        <p><?php echo $product_name ?></p>
                                        <span><?php echo $product_desc ?></span>
                                    </div>
                                    <div>
                                        <div class="rating-section">
                                            <div class="stars-rating">
                                                <!-- taruh sini review star rating nanti -->
                                                <?php

                                                if($count_rev === 0){
                                                    $count_rev = 1;

                                                    $total_star = $sub_total / $count_rev;
                                                    if($total_star === 0){
                                                        echo "<div class='review-number'>Belum ada review sekarang.</div>";
                                                    }
                                                } else {
                                                    $total_star = $sub_total / $count_rev;
                                                    if($total_star <= 0.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>      
                                                            ";
                                                    } elseif($total_star <= 1){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 1.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 2){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>  
                                                            <span>$total_star out of 5</span>  
                                                            ";
                                                            } elseif($total_star <= 2.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 3){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 3.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>      
                                                            ";
                                                    } elseif($total_star <= 4){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 4.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 5){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>  
                                                            ";
                                                            }
                                                }
                                            ?>
                                            </div>
                                            <div class="c-price">
                                                <span>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </a>
                                <?php }
                                            }
                                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk Baru End -->

            <!-- Produk Bestsellers Start -->
            <div class=" bestsellers-products">
                <div class="bestsellers-products-container">
                    <div class="bestsellers-products-row">
                        <div class="bestsellers-products-col">
                            <h2 class="bestsellers-products-title">Produk Terlaris</h2>
                        </div>
                        <div class="bestsellers-products-col">
                            <?php 
                            // fetch semua produk
                                $query = "SELECT * FROM ORDERS GROUP BY product_id ORDER BY 1 DESC LIMIT 4";
                                $result = mysqli_query($conn, $query);
                                $count = mysqli_num_rows($result);
                            ?>
                            <div class="cards">
                                <?php 
                                 if($count == 0){
                                    echo "<h2 class='no-products'>Produk Belum Tersedia</h2>";
                                 } else {

                                    while($row = mysqli_fetch_array($result)) {
                                        $product_id = $row['product_id'];
                                        

                                        $query_rev = "SELECT * FROM reviews WHERE review_product_id = '$product_id'";
                                        $result_rev = mysqli_query($conn, $query);
                                        $count_rev = mysqli_num_rows($result);
                                        // echo $count;

                                        // get sum
                                        $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$product_id'";
                                        $result_sum = mysqli_query($conn, $get_sum);
                                        $row = mysqli_fetch_assoc($result_sum);

                                        $sub_total = $row['totalStar'];
                                        //echo $sub_total;

                                        $query_pro = "SELECT * FROM products WHERE id = '$product_id'";
                                        $result_pro = mysqli_query($conn, $query_pro);
                                        while($row_pro = mysqli_fetch_array($result_pro)){

                                            $product_name = $row_pro['product_name'];
                                            $product_image = $row_pro['product_image'];
                                            
                                            $product_desc = $row_pro['product_desc'];
                                            $product_price = $row_pro['product_price'];
                                            $category_name = $row_pro['category_name'];

                                        }
                               
                                ?>
                                <a href='product.php?pro_id=<?php echo $product_id ?>'>
                                <div class="card_container">
                                    <span class="bestseller-product"></span>
                                    <div class="card_top_section">
                                    <img class="card-img" src="./assets/images/product_images/<?php echo $product_image ?>">
                                        <div class="card_top_section_icons">
                                        <div>
                                        <form action="index.php?add_wish=<?php echo $product_id ?>" method="post">
                                        <button class="add_wish" type="submit"><i class="far fa-heart"></i></button>
                                            </form>
                                            </div>
                                            <div>
                                                <a href="product.php?pro_id=<?php echo $product_id ?>"><i class="fa-solid fa-bag-shopping"></i></a>
                                            </div>
                                            <div class="hide-div">
                                                <a class="btn-view"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card_body_section">
                                        <p><?php echo $product_name ?></p>
                                        <span><?php echo $product_desc ?></span>
                                    </div>
                                    <div>
                                    <div class="rating-section">
                                            <div class="stars-rating">
                                                <!-- taruh sini review star rating nanti -->
                                                <?php

                                                if($count_rev === 0){
                                                    $count_rev = 1;

                                                    $total_star = $sub_total / $count_rev;
                                                    if($total_star === 0){
                                                        echo "<div class='review-number'>Belum ada review sekarang.</div>";
                                                    }
                                                } else {
                                                    $total_star = $sub_total / $count_rev;
                                                    if($total_star <= 0.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>      
                                                            ";
                                                    } elseif($total_star <= 1){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 1.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 2){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>  
                                                            <span>$total_star out of 5</span>  
                                                            ";
                                                            } elseif($total_star <= 2.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 3){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 3.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>      
                                                            ";
                                                    } elseif($total_star <= 4){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>    
                                                            ";
                                                            } elseif($total_star <= 4.5){
                                                        echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                            <span>$total_star out of 5</span>       
                                                            ";
                                                    } elseif($total_star <= 5){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <span>$total_star out of 5</span>  
                                                            ";
                                                            }
                                                }
                                            ?>
                                            </div>
                                            <div class="c-price">
                                                <span>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                                <?php }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Produk Bestsellers End -->

            <!-- Modal PopUp atau Quickview untuk produk start -->
            <div class="quick-container">
                <div class="mask"></div>
                <!-- merubah tampilan warna background ketika di klik -->
                <div id="quick-view-pop-up">
                    <div class="quick-view-close">X</div> <!-- untuk menutup pop up -->
                    <div class="quick-view-row">
                        <div class="quick-view-col">
                            <div class="mini-carousel">
                                <ul class="mini-item">
                                    <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image ?>"></a></li>
                                    <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image1 ?>"></a></li>
                                    <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image2 ?>"></a></li>
                                    <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image3 ?>"></a></li>
                                </ul>
                            </div>
                            <div class="carousel">
                                <div class="image-large">
                                    <ul>
                                        <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image ?>"></a></li>
                                        <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image1 ?>"></a></li>
                                        <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image2 ?>"></a></li>
                                        <li><a><img class="card-img" src="assets/images/product_images/<?php echo $product_image3 ?>"></a></li>
                                    </ul>
                                    <a class="prev">Sebelumnya</a>
                                    <a class="next">Selanjutnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="quick-view-col">
                            <div class="detail">
                                <div class="product-details">
                                    <h3 class="product-name"><?php echo $product_name ?></h3>
                                    <span class="product-cat"><?php echo $category_name ?></span>
                                    <p class="product-desc"><?php echo $product_desc ?></p>
                                    <h2 class="product-price"><strong>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></strong></h2>
                                </div>
                                <div class="buttons">
                                    <div>
                                        <a href=""><i class="fa-solid fa-heart"></i></a>
                                    </div>
                                    <div>
                                        <a href=""><i class="fa-solid fa-bag-shopping"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal PopUp atau Quickview untuk produk end -->
            <!-- Testimonial Start -->
            <div class="opinion-container">
                <div class="opinion-row">
                    <div class="opinion-col">
                        <h2 class="opinion-title">Testimonial Konsumen</h2>
                    </div>
                    <div class="opinion-col">
                        <?php $query = "SELECT * FROM opinion ORDER BY 1 DESC LIMIT 4";
                        $result = mysqli_query($conn, $query);

                        $count = mysqli_num_rows($result);
                        if($count == 0){
                        echo"
                        <div class='no_found'>
                            <h4 class='no_found_title'>Saat ini tidak ada Testimonial!</h4>
                        </div>
                        ";
                        } else {
                            ?>
                        <div class="opinion-cards">
                            <div class="opinion-cards">
                                <?php

                            while($row = mysqli_fetch_array($result)){
                                $username = $row['user_name'];
                                $user_image = $row['user_image'];
                                $user_message = $row['user_message'];
                                $date = $row['date'];
                            ?>
                                <div class="opinion-card">
                                    <div class="opinion-card-header">
                                        <p class="opinion-date"><?php echo $date;?></p>
                                    </div>
                                    <div class="opinion-card-body">
                                        <p class="opinion-desc"><?php echo $user_message;?></p>
                                    </div>
                                    <div class="opinion-card-footer">
                                        <?php 
                                    if(!empty($user_image)){
                                        echo "<img src='assets/images/customers/$user_image' alt='$username' class='opinion-img'>";
                                    
                                    } else {
                                        echo "<img src='assets/images/customers/user.png' alt='$username' class='opinion-img'>";
                                    }
                                    ?>
                                        <span class="opinion-name"><?php echo $username;?></span>
                                    </div>
                                </div>
                                <?php 
                                }
                                }
                              ?>
                            </div>
                        </div>
                    </div>
                    <div class="opinion-col">
                        <a href="opinion.php" class="opinion-link">Lihat Semua</a>
                    </div>
                </div>
            </div>
            <!-- Testimonial End -->



        </main>
        <!-- Main End -->

        <?php
            // menambahkan Footer
            include 'includes/footer.php';
        ?>