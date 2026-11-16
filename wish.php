<?php
require_once 'includes/init.php';

// menghapus produk dari wish list
if (isset($_GET['delete_wish'])) {
    include 'includes/delete_wish.php';
}

// menambahkan Header
include 'includes/header.php';
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
                                    // semua produk di wish list pengunjung ini
                                    $ip_add = db_esc(getUserIP());
                                    $result = q("SELECT p.* FROM wish w JOIN products p ON p.id = w.product_id
                                                 WHERE w.ip_add = '$ip_add' ORDER BY w.id DESC");

                                    if (q_count($result) == 0) {
                                        echo "<h3 class='no_carts'>Anda tidak memiliki item di daftar Wish!</h3>";
                                    }
                                    while ($result && $row = mysqli_fetch_assoc($result)) {
                                        render_product_card($row, null);
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
              
          </main>
          <!-- Main End -->


          <?php
            // menambahkan Footer
            include 'includes/footer.php'
        ?>