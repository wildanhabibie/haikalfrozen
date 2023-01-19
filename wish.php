          <?php
            // menambahkan Header
            include 'includes/header.php'
            ?>

          <!-- Main Start -->
          <main id="main">

              <!-- Wish List Start -->
              <div class="wish-container">
                  <div class="wish-row">
                      <div class="wish-col">
                          <h3 class="wish-title">Daftar Keinginan</h3>
                      </div>
                  </div>
                  <div class="wish-row">
                      <div class="wish-col">
                          <div class="wish-cards">
                                    <?php 
                                        //mendapatkan semua produk untuk keranjang
                                        $ip_add = getUserIP();
                                        $query = "SELECT * FROM wish WHERE ip_add = '$ip_add'";
                                        $result = mysqli_query($conn, $query);
                                        $count = mysqli_num_rows($result);

                                        while($row = mysqli_fetch_array($result)){
                                            
                                            $product_id = $row['product_id'];

                                            $query_pro = "SELECT * FROM products WHERE id = '$product_id'";
                                            $result_pro = mysqli_query($conn, $query_pro);

                                            while($row_pro = mysqli_fetch_array($result_pro)){
                                                $product_image = $row_pro['product_image'];
                                                $product_price = $row_pro['product_price'];
                                                $product_name = $row_pro['product_name'];
                                                $product_desc = $row_pro['product_desc'];
                                            }

                                            $query_rev = "SELECT * FROM reviews WHERE review_product_id = '$product_id'";
                                            $result_rev = mysqli_query($conn, $query_rev);
                                            $count_rev = mysqli_num_rows($result_rev);
                                            //echo $count;

                                            //get sum
                                            $get_sum = "SELECT SUM(review_rate) AS totalStar FROM reviews WHERE
                                            review_product_id = '$product_id'";
                                            $result_sum = mysqli_query($conn, $get_sum);
                                            $row = mysqli_fetch_assoc($result_sum);

                                            $sub_total = $row['totalStar'];
                                            //echo $sub_total;

                                ?>
                                <a href="product.php?pro_id=<?php echo $product_id ?>">
                                    <div class="card_container">
                                        <div class="card_top_section">
                                          <img class="card-img" src="assets/images/product_images/<?php echo $product_image ?>">
                                          <div class="card_top_section_icons">
                                              <div>
                                                  <a href="product.php?pro_id=<?php echo $product_id ?>"><i class="fas fa-shopping-basket"></i></a>
                                              </div>
                                              <div class="hide-div">
                                                  <a class="btn-view"><i class="fa-solid fa-eye"></i></a>
                                              </div>
                                              <div>
                                              <form action="wish.php?delete_wish=<?php echo $product_id ?>" method="post">
                                                <button class="delete_wish" type="submit"><i class="fa-solid fa-trash"></i></button>
                                            </form>
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

                                                if($count_rev === 0) {
                                                    $count_rev = 1;

                                                    $total_star = $sub_total / $count_rev;
                                                    
                                                    if($total_star === 0){
                                                        echo "<div class='review-number'>Belum ada review sekarang.</div>";
                                                    }
                                                    } else {
                                                    $total_star = $sub_total / $count_rev;
                                                    if($total_star <= 0.5){
                                                        echo "
                                                            <i class='far fa-star rating-with-color'></i>
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
                                              <span>Rp. <?php echo $product_price ?></span>
                                          </div>
                                      </div>
                                  </div>
                                    </div>
                              </a>
                              <?php
                                        }

                                        if($count == 0){
                                            echo "<h3 class='no_carts'>Anda tidak memiliki item di daftar Wish!</h3>";
                                        }
                                    ?>
                          </div>

                          <!-- Modal PopUp atau Quickview untuk produk start -->
                          <div class="quick-container">
                              <div class="mask"></div> <!-- merubah tampilan warna background ketika di klik -->
                              <div id="quick-view-pop-up">
                                  <div class="quick-view-close">X</div> <!-- untuk menutup pop up -->
                                  <div class="quick-view-row">
                                      <div class="quick-view-col">
                                          <div class="mini-carousel">
                                              <ul class="mini-item">
                                                  <li><a><img src="assets/images/product_images/gorengan_1.png"
                                                              alt=""></a>
                                                  </li>
                                                  <li><a><img src="assets/images/product_images/gorengan_1_1.png"
                                                              alt=""></a>
                                                  </li>
                                                  <li><a><img src="assets/images/product_images/gorengan_1_2.png"
                                                              alt=""></a>
                                                  </li>
                                                  <li><a><img src="assets/images/product_images/gorengan_1_3.png"
                                                              alt=""></a>
                                                  </li>
                                              </ul>
                                          </div>
                                          <div class="carousel">
                                              <div class="image-large">
                                                  <ul>
                                                      <li><a><img src="assets/images/product_images/gorengan_1.png"
                                                                  alt=""></a>
                                                      </li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_1.png"
                                                                  alt=""></a>
                                                      </li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_2.png"
                                                                  alt=""></a>
                                                      </li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_3.png"
                                                                  alt=""></a>
                                                      </li>
                                                  </ul>
                                                  <a class="prev">Prev</a>
                                                  <a class="next">Next</a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="quick-view-col">
                                          <div class="detail">
                                              <div class="product-details">
                                                  <h3 class="product-name">Produk 2</h3>
                                                  <span class="product-cat">Gorengan</span>
                                                  <p class="product-desc">Lore ipsum dolor sit amet, consectetur
                                                      adipisicing elit.
                                                      Incidunt minima nisi totam vero, neque quia. Asperiores rerum
                                                      nemo placeat,
                                                      laudantium molestias vel id rem eveniet! Inventore veniam
                                                      autem animi maiores.
                                                  </p>
                                                  <h2 class="product-price"><strong>Rp25.000</strong></h2>
                                              </div>
                                              <div class="buttons">
                                                  <div>
                                                      <a href=""><i class="fa-solid fa-bag-shopping"></i></a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                     <!-- popUp Modal end -->
                      </div>
                   </div>
                   </div>           
              <!-- Wish List End -->
              
              <?php 
              //menghapus wish list
              if(isset($_GET['delete_wish'])){
                include("includes/delete_wish.php");
              }
              ?>
          </main>
          <!-- Main End -->


          <?php
            // menambahkan Footer
            include 'includes/footer.php'
        ?>