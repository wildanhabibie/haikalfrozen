<?php
require_once 'includes/init.php';

// untuk menambah wish
if (isset($_GET['add_wish'])) {
    add_to_wish($_GET['add_wish'], 'index.php');
}

// dua kategori pertama untuk banner kategori di beranda
$home_categories = [];
$resultCat = q("SELECT * FROM category ORDER BY id LIMIT 2");
while ($resultCat && $rowCat = mysqli_fetch_assoc($resultCat)) {
    $home_categories[] = $rowCat;
}

// menambahkan Header
include 'includes/header.php';
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
                            <?php if (isset($home_categories[0])): ?>
                            <a href="shop.php?cat=<?php echo (int) $home_categories[0]['id'] ?>"><?php echo e($home_categories[0]['category_name']) ?></a>
                            <?php else: ?>
                            <a href="shop.php">Nugget</a>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Kolom Kiri End -->

                    <!-- Kolom Kanan Start -->
                    <div class="category-col">
                        <img src="assets/images/category_images/fishstick_1.png" alt="Gorengan">
                        <div class="category-content">
                            <?php if (isset($home_categories[1])): ?>
                            <a href="shop.php?cat=<?php echo (int) $home_categories[1]['id'] ?>"><?php echo e($home_categories[1]['category_name']) ?></a>
                            <?php else: ?>
                            <a href="shop.php">Gorengan</a>
                            <?php endif ?>
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
                            // 4 produk terbaru
                            $result = q("SELECT * FROM products ORDER BY id DESC LIMIT 4");
                            ?>
                            <div class="cards">
                                <?php
                                if (q_count($result) == 0) {
                                    echo "<h2 class='no-products'>Produk Belum Tersedia.</h2>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        render_product_card($row, 'index.php', 'new-product');
                                    }
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
                            // 4 produk yang paling banyak dipesan
                            $result = q("SELECT p.*, SUM(o.product_quantity) AS terjual
                                         FROM orders o JOIN products p ON p.id = o.product_id
                                         GROUP BY p.id ORDER BY terjual DESC LIMIT 4");
                            ?>
                            <div class="cards">
                                <?php
                                if (q_count($result) == 0) {
                                    echo "<h2 class='no-products'>Produk Belum Tersedia</h2>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        render_product_card($row, 'index.php', 'bestseller-product');
                                    }
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
                                    <li><a><img src="assets/images/product_images/gorengan_1.png" alt=""></a></li>
                                    <li><a><img src="assets/images/product_images/gorengan_1_1.png" alt=""></a></li>
                                    <li><a><img src="assets/images/product_images/gorengan_1_2.png" alt=""></a></li>
                                    <li><a><img src="assets/images/product_images/gorengan_1_3.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="carousel">
                                <div class="image-large">
                                    <ul>
                                        <li><a><img src="assets/images/product_images/gorengan_1.png" alt=""></a>
                                        </li>
                                        <li><a><img src="assets/images/product_images/gorengan_1_1.png" alt=""></a>
                                        </li>
                                        <li><a><img src="assets/images/product_images/gorengan_1_2.png" alt=""></a>
                                        </li>
                                        <li><a><img src="assets/images/product_images/gorengan_1_3.png" alt=""></a>
                                        </li>
                                    </ul>
                                    <a class="prev">Sebelumnya</a>
                                    <a class="next">Selanjutnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="quick-view-col">
                            <div class="detail">
                                <div class="product-details">
                                    <h3 class="product-name">Produk 2</h3>
                                    <span class="product-cat">Gorengan</span>
                                    <p class="product-desc">Lore ipsum dolor sit amet,
                                        consectetur adipisicing elit.
                                        Incidunt minima nisi totam vero, neque quia. Asperiores
                                        rerum nemo placeat,
                                        laudantium molestias vel id rem eveniet! Inventore
                                        veniam autem animi maiores.
                                    </p>
                                    <h2 class="product-price"><strong>Rp25.000</strong></h2>
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
                        <?php
                        $result = q("SELECT * FROM opinion ORDER BY id DESC LIMIT 4");
                        $count = q_count($result);
                        if($count == 0){
                        echo"
                        <div class='no_found'>
                            <h4 class='no_found_title'>Saat ini tidak ada Testimonial!</h4>
                        </div>
                        ";
                        } else {
                            ?>
                        <div class="opinion-cards">
                                <?php

                            while($row = mysqli_fetch_array($result)){
                                $username = e($row['user_name']);
                                $user_image = e($row['user_image']);
                                $user_message = nl2br(e($row['user_message']));
                                $date = e($row['date']);
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
                                ?>
                        </div>
                        <?php
                        }
                        ?>
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