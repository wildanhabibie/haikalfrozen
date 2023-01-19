                    <?php
            // menambahkan Header
            include 'includes/header.php';
            
            if(isset($_SESSION['customerName'])) {
                $currentUser = $_SESSION['customerName'];

                $query = "SELECT * FROM users WHERE username = '$currentUser'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);

                $user_email = $row['email'];
                $user_image = $row['user_image'];
            }

            if(isset($_GET['pro_id'])){
                $product_id = $_GET['pro_id'];

                $query = "SELECT * FROM products WHERE id= '$product_id'";
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

            // Add to Cart
            if(isset($_GET['add_cart'])){
                $ip_address = getUserIp();
                $id_product = $_GET['add_cart'];
                $product_size = $_POST['size'];
                $product_jenis = $_POST['jenis'];
                $product_quantity = $_POST['quantity'];

                // mengecek produk jika sudah ada di cart
                $check = "SELECT * FROM cart WHERE ip_add = '$ip_address' AND product_id = '$id_product'";
                $run_check = mysqli_query($conn, $check);

                // jika ada
                if(mysqli_num_rows($run_check) > 0){
                    
                    echo "<script>alert('Produk ini sudah ada di keranjang!')</script>";
                    echo "<script>window.open('product.php?pro_id=$product_id', '_self')</script>";
                
                } else {

                    // jika ditambahkan ke keranjang kosong
                    $query_add = "INSERT INTO cart (ip_add, product_id, product_size, product_jenis, product_quantity, date) VALUES ('$ip_address', '$id_product', '$product_size', '$product_jenis', '$product_quantity', now())";

                    $query_run = mysqli_query($conn, $query_add);
                    echo "<script>alert('Produk berhasil ditambahkan ke keranjang!')</script>";
                    echo "<script>window.open('cart.php', '_self')</script>";
                
                }
            }
            ?>
                    <!-- Main Start -->
                    <main id="main">
                        <div class="product-container">
                            <form action="product.php?add_cart=<?php echo $product_id ?>" method="post">
                                <div class="product-row">
                                    <div class="product-col">
                                        <h2 class="product-name"><?php echo $product_name ?></h2>
                                        <span class="product-category"><?php echo $category_name ?></span>
                                        <div class="reviews">
                                            <div class="reviews-star">
                                                <!-- Reviews dari Database -->
                                                <?php
                                                    if(isset($_GET['pro_id'])){
                                                        $review_id = $_GET['pro_id'];

                                                        $query = "SELECT * FROM reviews WHERE review_product_id = '$review_id'";
                                                        $result = mysqli_query($conn, $query);
                                                        $count = mysqli_num_rows($result);
                                                        // echo $count;

                                                        //get sum
                                                        $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$review_id' ";
                                                        $result_sum = mysqli_query($conn, $get_sum);
                                                        $row = mysqli_fetch_assoc($result_sum);

                                                        $sub_total = $row['totalStar'];
                                                        // echo $sub_total;

                                                        if($count === 0){

                                                            $count = 1;

                                                            
                                                            $total_star = $sub_total / $count;

                                                            if($total_star === 0){

                                                                echo "<div class='reviews-number'>Belum ada komentar sekarang.</div>"; //tidak bisa dibagi 0

                                                            }

                                                            } else {
                                                                $total_star = $sub_total / $count;

                                                                    if($total_star <= 0.5){
                                                                        echo "
                                                                        <i class='fas fa-star-half-alt rating-with-color'></i>
                                                                            ";
                                                                    } elseif($total_star <= 1){
                                                                            echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            ";
                                                                    } elseif($total_star <= 1.5){
                                                                        echo "
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star-half-alt rating-with-color'></i>     
                                                                            ";
                                                                    } elseif($total_star <= 2){
                                                                            echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>

                                                                            ";
                                                                     } elseif($total_star <= 2.5){
                                                                        echo "
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star-half-alt rating-with-color'></i>      
                                                                            ";
                                                                    } elseif($total_star <= 3){
                                                                            echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                             <i class='fas fa-star rating-with-color'></i>
      
                                                                            ";
                                                                     } elseif($total_star <= 3.5){
                                                                        echo "
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star rating-with-color'></i>
                                                                        <i class='fas fa-star-half-alt rating-with-color'></i>       
                                                                            ";
                                                                    } elseif($total_star <= 4){
                                                                            echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
  
                                                                            ";
                                                                     } elseif($total_star <= 4.5){
                                                                        echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star-half-alt rating-with-color'></i>     
    
                                                                            ";
                                                                    } elseif($total_star <= 5){
                                                                            echo "
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>
                                                                            <i class='fas fa-star rating-with-color'></i>

                                                                            ";
                                                                            }
                                                                }
                                                        }
                                                ?>
                                            </div>
                                            <?php
                                                $query = "SELECT review_rate FROM reviews WHERE review_product_id = '$review_id'";
                                                $result = mysqli_query($conn, $query);
                                                $count = mysqli_num_rows($result);
                                            ?>
                                            <div class="reviews-number">(<?php echo $count ?> Reviews)</div>
                                        </div>
                                        <h1 class="product-price"><sup>Rp</sup><?php echo $product_price ?></h1>
                                    </div>
                                    <div class="product-col">
                                        <button class="product-add" name="add" type="submit">Tambah Ke Keranjang</button>
                                    </div>
                                </div>
                                <div class="product-row">
                                    <div class="product-col">
                                        <p class="product-description">
                                            <?php echo $product_desc ?></p>
                                        <div class="product-options">
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Jenis
                                                </h4>
                                                <div class="product-option-div">
                                                    <?php
                                                    // Mendapat Jenis
                                                    if(isset($_GET['pro_id'])) {
                                                        $jenis_product = $_GET['pro_id'];

                                                        $query = "SELECT * FROM jenis WHERE product_id = '$jenis_product'";
                                                        $result = mysqli_query($conn, $query);
                                                        $count = mysqli_num_rows($result);
                                                        
                                                        if($count === 0){
                                                            echo "<p>tidak tersedia jenis di produk ini!</p>";
                                                        }
                                                        else {

                                                            while($row = mysqli_fetch_assoc($result)) {

                                                                $jenis_name = $row['jenis_name'];
    
                                                                echo "
                                                                <label for='$jenis_name'>
                                                                <input type='radio' name='jenis' id='$jenis_name' value='$jenis_name' required />
                                                                <span>$jenis_name</span>
                                                                </label>
                                                                
                                                                ";
    
                                                            }
                                                        }                                                        
                                                    }
                                                    
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Ukuran
                                                </h4>
                                                <div class="product-option-div">
                                                <?php
                                                    // Mendapat size
                                                    if(isset($_GET['pro_id'])) {
                                                        $sizes_product = $_GET['pro_id'];

                                                        $query = "SELECT * FROM sizes WHERE product_id = '$sizes_product'";
                                                        $result = mysqli_query($conn, $query);
                                                        $count = mysqli_num_rows($result);
                                                        
                                                        if($count === 0){
                                                            echo "<p>tidak tersedia ukuran di produk ini!</p>";
                                                        }
                                                        else {

                                                            while($row = mysqli_fetch_assoc($result)) {

                                                                $size_name = $row['product_size'];
    
                                                                echo "
                                                                <label for='$size_name'>
                                                                    <input type='radio' value='$size_name' id='$size_name' name='size' required />
                                                                    <span>$size_name</span>
                                                                </label>
                                                                ";
    
                                                            }
                                                        }                                                        
                                                    }

                                                    ?>                 
                                                </div>
                                            </div>
                                            <div class="product-option">
                                                <h4 class="product-option-title">
                                                    Jumlah
                                                </h4>
                                                <div class="product-option-div">
                                                    <input type="number" name="quantity" min="1" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-col right">
                                        <div class="mini-carousel">
                                            <ul class="mini-item">
                                                <li><a><img src="assets/images/product_images/<?php echo $product_image ?>"
                                                            alt="<?php echo $product_name ?>"></a>
                                                </li>
                                                <li><a><img src="assets/images/product_images/<?php echo $product_image1 ?>"
                                                            alt="<?php echo $product_name ?>"></a></li>
                                                <li><a><img src="assets/images/product_images/<?php echo $product_image2 ?>"
                                                            alt="<?php echo $product_name ?>"></a></li>
                                                <li><a><img src="assets/images/product_images/<?php echo $product_image3 ?>"
                                                            alt="<?php echo $product_name ?>"></a></li>
                                            </ul>
                                        </div>
                                        <div class="carousel">
                                            <div class="image-large">
                                                <ul>
                                                    <li><a><img src="assets/images/product_images/<?php echo $product_image ?>"
                                                                alt="<?php echo $product_name ?>"></a></li>
                                                    <li><a><img src="assets/images/product_images/<?php echo $product_image1 ?>"
                                                                alt="<?php echo $product_name ?>"></a>
                                                    </li>
                                                    <li><a><img src="assets/images/product_images/<?php echo $product_image2 ?>"
                                                                alt="<?php echo $product_name ?>"></a>
                                                    </li>
                                                    <li><a><img src="assets/images/product_images/<?php echo $product_image3 ?>"
                                                                alt="<?php echo $product_name ?>"></a>
                                                    </li>
                                                </ul>
                                                <a class="prev">Prev</a>
                                                <a class="next">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="reviews-container">
                                <div class="reviews-col">
                                    <h2 class="reviews-title"><?php echo $count ?> Review untuk "<?php echo $product_name ?>"</h2>
                                    <?php
                                    if(isset($_GET['pro_id'])){
                                        $review_id = $_GET['pro_id'];

                                        $query = "SELECT * FROM reviews WHERE review_product_id = '$review_id'";
                                        $result = mysqli_query($conn, $query);
                                        $count = mysqli_num_rows($result);
                                        // echo $count;

                                        //get sum
                                        $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE review_product_id = '$review_id'";
                                        $result_sum = mysqli_query($conn, $get_sum);
                                        $row = mysqli_fetch_assoc($result_sum);

                                        $sub_total = $row['totalStar'];
                                        // echo $sub_total;

                                        if($count === 0){

                                            $count = 1;

                                            
                                            $total_star = $sub_total / $count;

                                            if($total_star === 0){

                                                echo "<div class='reviews-number'>Belum ada komentar sekarang.</div>"; //tidak bisa dibagi 0

                                            } 
                                            } else {
                                                
                                                while($row = mysqli_fetch_assoc($result)) {

                                                    $r_product_name = $row['review_product_name'];
                                                    $r_message = $row['review_message'];
                                                    $r_name = $row['review_name'];

                                                    $upper_name = ucfirst($r_name);

                                                    $r_date = $row['review_date'];
                                                    $r_rate = $row['review_rate'];
                                                    $r_image = $row['review_image'];

                                                    echo "
                                                    <div class='reviews-content-div'>
                                                    <div class='reviews-content-left'>";
                                                    if(!empty($r_image)){
                                                        echo "<img src='assets/images/customers/$user_image' alt=$r_name>";
                                                    } else {
                                                        echo "<img src='assets/images/customers/user.png'alt=$r_name>";
                                                    }
                                                        echo "
                                                    </div>
                                                    <div class='reviews-content-right'>
                                                        <div class='reviews-content-top'>
                                                            <p class='reviews-customer'>$upper_name</p>
                                                            <span class='reviews-date'> - $r_date </span>
                                                        </div>
                                                        <div class='reviews-content-middle'>
                                                         ";
                                                         if($r_rate <= 0.5){
                                                            echo "
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>
                                                                ";
                                                        } elseif($r_rate <= 1){
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                ";
                                                                } elseif($r_rate <= 1.5){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>     
                                                                ";
                                                        } elseif($r_rate <= 2){
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>

                                                                ";
                                                                } elseif($r_rate <= 2.5){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>      
                                                                ";
                                                        } elseif($r_rate <= 3){
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                 <i class='fas fa-star rating-with-color'></i>

                                                                ";
                                                                } elseif($r_rate <= 3.5){
                                                            echo "
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star rating-with-color'></i>
                                                            <i class='fas fa-star-half-alt rating-with-color'></i>       
                                                                ";
                                                        } elseif($r_rate <= 4){
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>

                                                                ";
                                                                } elseif($r_rate <= 4.5){
                                                            echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star-half-alt rating-with-color'></i>     

                                                                ";
                                                        } elseif($r_rate <= 5){
                                                                echo "
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>
                                                                <i class='fas fa-star rating-with-color'></i>

                                                                ";
                                                                }
                                                         echo"
                                                        </div>
                                                        <div class='reviews-content-bottom'>
                                                            <p class='reviews-customer-message'>$r_message</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                    ";

                                                }

                                                }
                                        }
                                    ?>
                                </div>
                                <div class="reviews-col">
                                <?php
                    if (isset($_SESSION['customerName'])) {
                        
                    }
                    ?>
                                    <h2 class="reviews-title">Tinggalkan Komentar</h2>
                                    <span class="reviews-subtitle">Email anda tidak akan dipublikasikan. Kolom yang harus diisi ditandai *</span>
                                    <?php
                                        //sebelum menambahkan rate untuk produk
                                        if(isset($_POST['revadd'])){

                                            $rating = $_POST['rating'];
                                            $message = $_POST['revmessage'];
                                            $name= $_POST['revname'];
                                            $email = $_POST['revemail'];
                                        
                                            $query = "INSERT INTO reviews (review_product_id,review_product_name,review_rate,review_message,review_name,review_image,review_email,review_date) VALUES('$product_id','$product_name','$rating','$message','$name','$user_image','$email',now())";
                                            $result = mysqli_query($conn, $query);

                                            if($result){
                                                $messageRate = "Anda sukses mengomentari produk!";
                                                echo"<script>document.location='product.php?pro_id=$product_id';</script>";
                                            }
                                        }
                                    ?>
                                    
                                    <form action="" class="revform" method="post">
                                    <span class="text-success"><?php if (isset($messageRate)) echo $messageRate; ?></span>
                                        <div class="reviews-group">
                                            <div class="rateyo" id="rating"
                                                data-rateyo-rating="4"
                                                data-rateyo-num-stars="5"
                                                data-rateyo-score="3"
                                                data-rateyo-star-width="23px"
                                                data-rateyo-rated-fill="#001e28">
                                            </div>
                                            <input type="hidden" name="rating" required>
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Review Anda*</h4>
                                            <textarea name="revmessage" cols="28" rows="8" required></textarea>
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Nama Anda*</h4>
                                            <input type="text" name="revname" value="<?php echo $currentUser ?>" required></input>
                                        </div>
                                        <div class="reviews-group">
                                            <h4 class="reviews-group-title">Email Anda*</h4>
                                            <input type="email" name="revemail" value="<?php echo $user_email ?>" required></input>
                                        </div>
                                        <div class="reviews-button">
                                            <button name="revadd">Publish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                        </main>
                    <!-- Main End -->


                    <?php
            // menambahkan Footer
            include 'includes/footer.php'
        ?>