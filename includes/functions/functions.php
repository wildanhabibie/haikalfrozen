            <?php

                //For User IP
                function getUserIP()
                {
                    switch (true) {
                        case(!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
                        case(!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
                        case(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER ['HTTP_X_FORWARDED_FOR'];
                        default : return $_SERVER['REMOTE_ADDR'];
                    }
                }

                    //Menghitung jumlah produk untuk cart
                    function item(){
                        global $conn;
                        $ip_add = getUserIP();
                        $query_item = "SELECT * FROM cart WHERE ip_add = '$ip_add'";
                        $result_item = mysqli_query($conn, $query_item);
                        $count = mysqli_num_rows($result_item);
                        echo $count;
                    }

                    //Menghitung jumlah produk untuk wish
                    function itemWish(){
                        global $conn;
                        $ip_address = getUserIP();
                        $query_itemWish = "SELECT * FROM wish WHERE ip_add = '$ip_address'";
                        $result_itemWish = mysqli_query($conn, $query_itemWish);
                        $countWish = mysqli_num_rows($result_itemWish);
                        echo $countWish;
                    }

                    // Get Shop Category
                    function getShopCategory() {

                        global $conn;

                        $query = "SELECT * FROM category";
                        $result = mysqli_query($conn, $query);
                        echo"
                            <a href='shop.php' class='sidebar-category-link'>Semua</a>
                        ";
                        while($row = mysqli_fetch_array($result)) {
                            $category_id = $row['id'];
                            $category_name = $row['category_name'];

                            echo "
                            
                                <a href='shop.php?cat=$category_id' class='sidebar-category-link'>$category_name</a>
                            
                            ";
                        }

                    }


                    // For Get All Products = Shop Page
                    function getAllProducts()
                    {

                     global $conn;
                    // untuk mendapat produk dari database untuk shop
                    if(!isset($_GET['cat'])){

                        $per_page = 12;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        } else {
                        $page = 1;
                    }

                $i = 0;

                $start_from = ($page - 1) * $per_page;

                $get_product = "SELECT * FROM products ORDER BY 1 DESC LIMIT $start_from, $per_page";
                $run_product = mysqli_query($conn, $get_product);

                $count = mysqli_num_rows($run_product);
                if($count == 0){
                    echo "
                        <div class='no_found'>
                            <h3 class='no_found_title'>Saat ini tidak ada produk!</h3>
                        </div>
                    ";
                } else {
                ?>
                    <!--Product Start -->
                    <div class="cards">
                <?php
                        while ($row = mysqli_fetch_array($run_product)) {
                            $product_id = $row['id'];
                            $product_name = $row['product_name'];
                            $product_desc = $row['product_desc'];
                            $product_price = $row['product_price'];
                            $product_image = $row['product_image'];
                            $query_rev = "SELECT * FROM reviews WHERE review_product_id = '$product_id'";
                            $result_rev = mysqli_query($conn, $query_rev);
                            $count_rev = mysqli_num_rows($result_rev);
                            // echo $count;

                            //get sum
                            $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$product_id'";
                            $result_sum = mysqli_query($conn, $get_sum);
                            $row = mysqli_fetch_assoc($result_sum);

                            $sub_total = $row['totalStar'];
                            // echo $sub_total
                        
                        echo " <a href='product.php?pro_id=$product_id'>
                                <div class='card_container'>
                            <div class='card_top_section'>
                            <img class='card-img' src='assets/images/product_images/$product_image'>
                            <div class='card_top_section_icons'>
                                <div>
                                    <form action='shop.php?add_wish=<?php echo $product_id ?>' method='post'>
                                    <button class='add_wish' type='submit'><i class='far fa-heart'></i></button>
                                    </form>
                                </div>
                                <div>
                                        <a href='product.php?pro_id=$product_id'><i class='fas fa-shopping-basket'></i></a>
                                    </div>
                                    <div class='hide-div'>
                                        <a class='btn-view'><i class='fas fa-eye'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class='card_body_section'>
                                <p>$product_name</p>
                                <span>$product_desc</span>
                            </div> 
                            <div>
                            <div class='rating-section'>
                                <div class='stars-rating'>
                            ";

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
                        echo"
                            </div>
                            <div class='c-price'>
                                    <span>Rp. $product_price</span>
                            </div>
                            </div>
                        </div>
                        </div>
                            </a>"
                        ;
                        }


                        ?> 
                        </div> 
                        <!-- Product end -->
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
                        <a href='shop.php?page=<?php echo ($page - 1) ?>'
                            class='pagination-menu-link'>Prev</a>
                    </li>

                    <?php if($page > 2): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?page=1' class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                    </li>
                    <?php endif ?>

                    <?php if($page > 3): ?>
                    <li class='pagination-menu-item'>
                        <a class='pagination-menu-link<?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                    </li>
                    <?php endif ?>

                    <?php endif ?>
                    <?php if($page - 1 > 0): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?page=<?php echo $page - 1 ?>' class='pagination-menu-link <?php echo $_GET ['page'] == "$page - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                    </li>
                    <?php endif ?>
                    <li class='pagination-menu-item'>
                        <a class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?> '><?php echo $page ?></a>
                    </li>

                    <?php if ($page + 1 < $total_page): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?page=<?php echo $page + 1 ?>' class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'><?php echo $page + 1 ?></a> 
                    </li>
                    <?php endif ?>

                    <?php if ($page < $total_page): ?>
                    <?php if($page < $total_page - 2): ?>
                    <li class='pagination-menu-item'>
                    <a class='pagination-menu-link' <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>...</a>
                    </li>
                    <?php endif ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?page=<?php echo $total_page?>' class='pagination-menu-link'><?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'></a>
                    </li>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?page=<?php echo ($page + 1) ?>' class='pagination-menu-link'>Next</a>
                    </li>
                    <?php endif ?>
                    </ul>
                    </div>
                    <!-- pagination end -->
                        <?php
                        }
                    }
                }

                        //GetFilterProducts
                        function getFilterProducts(){

                            global $conn;
                            if(isset($_GET['cat'])){
                                $filter_id = $_GET['cat'];

                                $per_page = 12;
                                if(isset($_GET['page'])){
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }

                                $i = 0;

                                $start_from = ($page - 1) * $per_page;

                                $get_product = "SELECT * FROM products WHERE category_id = '$filter_id' ORDER BY 1 DESC LIMIT $start_from, $per_page";
                                $run_product = mysqli_query($conn, $get_product);

                                $count = mysqli_num_rows($run_product);
                                if ($count == 0) {
                                    echo "
                                        <div class='no_found'>
                                            <h3 class='no_found_title'>Tidak ada Produk tersedia saat ini!</h3>
                                        </div>
                                    ";
                                } else {
                            ?>
                                    <!-- Product Start -->
                                    <div class="cards">
                                <?php
                                while ($row = mysqli_fetch_array($run_product)) {
                                    $product_id = $row['id'];
                                    $product_name = $row['product_name'];
                                    $product_desc = $row['product_desc'];
                                    $product_price = $row['product_price'];
                                    $product_image = $row['product_image'];

                                    $query_rev = "SELECT * FROM reviews WHERE review_product_id = '$product_id'";
                                    $result_rev = mysqli_query($conn, $query_rev);
                                    $count_rev = mysqli_num_rows($result_rev);
                                    // echo $count;

                                    //get sum
                                    $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$product_id'";
                                    $result_sum = mysqli_query($conn, $get_sum);
                                    $row = mysqli_fetch_assoc($result_sum);

                                    $sub_total = $row['totalStar'];
                                    // echo $sub_total

                                    echo "
                                    <a href='product.php?pro_id=$product_id'>
                                    <div class='card_container'>
                                        <div class='card_top_section'>
                                                    <img class='card-img' src='assets/images/product_images/$product_image'>
                                            <div class='card_top_section_icons'>
                                                <div>
                                                    <form action='shop.php/add_wish=$product_id' method='post'>
                                                    <button class='add_wish' type='submit'><i class='far fa-heart'></i></button>>
                                                    </form>
                                                </div>
                                                <div>
                                                    <a href='shop.php?add_cart=$product_id'><i class='far fa-shopping-basket'></i></a>
                                                </div>
                                                <div class='hide-div'>
                                                    <a class='btn-view'><i class='fas fa-eye'></i></a>
                                                                </div>
                                                            </div>
                                                    </div>
                                                        <div class='card_body_section'>
                                                            <p>$product_name</p>
                                                            <span>$product_desc</span>
                                                        </div> 
                                                        <div>
                                                                <div class='rating-section'>
                                                                    <div class='stars-rating'>
                                            ";

                                                        if ($count_rev === 0) {
                                                            $count_rev = 1;

                                                            $total_star = $sub_total / $count_rev;
                                                                                                
                                                            if ($total_star === 0) {
                                                                echo "<div class='review-number'>Belum ada review sekarang.</div>";
                                                            }

                                                            } else {
                                                                $total_star = $sub_total / $count_rev;
                                                                if ($total_star <= 0.5) {
                                                                    echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <span>$total_star out of 5</span>    
                                                                ";
                                                                } elseif ($total_star <= 1) {
                                                                    echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <span>$total_star out of 5</span>  
                                                                ";
                                                                } elseif ($total_star <= 1.5) {
                                                                    echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star-half-alt rating-with-color'></i>
                                                                <span>$total_star out of 5</span>     
                                                                ";

                                                                } elseif ($total_star <= 2) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <span>$total_star out of 5</span>
                                                                ";
                                                                } elseif ($total_star <= 2.5) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star-half-alt rating-with-color'></i> 
                                                                <span>$total_star out of 5</span>    
                                                                ";
                                                                } elseif ($total_star <= 3) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <span>$total_star out of 5</span>  
                                                                ";
                                                                } elseif ($total_star <= 3.5) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star-half-alt rating-with-color'></i>   
                                                                <span>$total_star out of 5</span> 
                                                                ";
                                                                } elseif ($total_star <= 4) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <span>$total_star out of 5</span>   
                                                                ";
                                                                } elseif ($total_star <= 4.5) {
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star-half-alt rating-with-color'></i>     
                                                                <span>$total_star out of 5</span> 
                                                                ";
                                                                } elseif ($total_star <= 5) {
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
                                                echo"
                                                        </div>
                                                        <div class='c-price'>
                                                            <span>Rp. $product_price</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </a>                              
                                                                        
                                ";
                            }

                            ?>
                            </div>
                            <!-- product end -->

                            <div class="admin-pagination">
                <ul>
                    <?php
                    $query = "SELECT * FROM products WHERE category_id = '$filter_id'";
                    $result = mysqli_query($conn, $query);
                    $total_record = mysqli_num_rows($result);
                    $total_page = ceil($total_record / $per_page);
                ?>


                    <?php if($page == 1): ?>
                    <?php else: ?>
                    <li class='pagination-menu-item'>
                        <a href='a href='shop.php?cat=<?php echo $filter_id ?>&page=<?php echo ($page - 1) ?>'
                            class='pagination-menu-link'>Prev</a>
                    </li>

                    <?php if($page > 2): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?cat=<?php echo $filter_id ?>&page=1' class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                    </li>
                    <?php endif ?>

                    <?php if($page > 3): ?>
                    <li class='pagination-menu-item'>
                        <a class='pagination-menu-link<?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                    </li>
                    <?php endif ?>

                    <?php endif ?>
                    <?php if($page - 1 > 0): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?cat=<?php echo $filter_id ?>&page - 1 ?>' class='pagination-menu-link <?php echo $_GET ['page'] == "$page - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                    </li>
                    <?php endif ?>
                    <li class='pagination-menu-item'>
                        <a class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?> '><?php echo $page ?></a>
                    </li>

                    <?php if ($page + 1 < $total_page): ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?cat=<?php echo $filter_id ?>&page + 1 ?>' class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'><?php echo $page + 1 ?></a> 
                    </li>
                    <?php endif ?>

                    <?php if ($page < $total_page): ?>
                    <?php if($page < $total_page - 2): ?>
                    <li class='pagination-menu-item'>
                    <a class='pagination-menu-link' <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>...</a>
                    </li>
                    <?php endif ?>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?cat=<?php echo $filter_id ?>&page=<?php echo $total_page?>' class='pagination-menu-link'><?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'></a>
                    </li>
                    <li class='pagination-menu-item'>
                        <a href='shop.php?cat=<?php echo $filter_id ?>&page=<?php echo ($page + 1) ?>' class='pagination-menu-link'>Next</a>
                    </li>
                    <?php endif ?>
                    </ul>
                    </div>
                   <!-- pagination end -->
                            <?php
                    }
                }

                 }
            ?>