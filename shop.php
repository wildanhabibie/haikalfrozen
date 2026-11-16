<?php
require_once 'includes/init.php';

// menambah produk ke wish list
if (isset($_GET['add_wish'])) {
    add_to_wish($_GET['add_wish'], 'shop.php');
}

// menambahkan Header
include 'includes/header.php';
?>

          <!-- Main Start -->
          <main id="main">
              <div class="shop-container">
                  <!-- Sidebar Start -->
                  <div class="sidebar" id="sidebar">
                      <nav class="sidebar-content">
                          <!-- Filters Content Start  -->
                          <div class="sidebar-filters">
                              <div class="sidebar-filter">
                                  <h2 class="sidebar-category">Kategori</h2>
                                  <!-- mendapatkan Kategori -->
                                  <?php 
                                  getShopCategory();
                                  ?>
                              </div>
                              <div class="sidebar-filter">
                                  <h2 class="sidebar-category">SubKategori</h2>
                                  <a href="#" class="sidebar-category-link">Ayam</a>
                                  <a href="#" class="sidebar-category-link">Sapi</a>
                                  <a href="#" class="sidebar-category-link">Ikan</a>
                                  <a href="#" class="sidebar-category-link">Olahan</a>
                              </div>
                              <div class="sidebar-filter">
                                  <h2 class="sidebar-category">Ukuran</h2>
                                  <a href="#" class="sidebar-category-link">Sedang</a>
                                  <a href="#" class="sidebar-category-link">Besar</a>
                              </div>
                              <div class="sidebar-filter">
                                  <h2 class="sidebar-category">Harga</h2>
                                  <div class="range-slider">
                                      <span>
                                          <input type="number" value="0" min="0" max="500">
                                          <input type="number" value="0" min="0" max="500">
                                      </span>
                                      <input value="0" min="0" max="500" step="10" type="range">
                                      <input value="0" min="0" max="500" step="10" type="range">
                                  </div>
                              </div>
                          </div>
                          <!-- Filters Content End -->
                      </nav>
                  </div>
                  <!-- Sidebar End -->

                  <!-- Main Content for Products Start -->
                  <div class="shop-container-products">
                      <div class="shop-row-products">
                          <div class="shop-col-products">
                              
                          <div class="sidebar-toggle" id="sidebar-toggle">
                                  <!-- Icon for Filter Open and Close Start -->
                                  <i class="fa-solid fa-filter"></i>
                                  <!-- Icon for Filter Open and Close End -->
                              </div>
                              <?php $sort_base = isset($_GET['cat']) ? 'shop.php?cat=' . (int) $_GET['cat'] . '&' : 'shop.php?'; ?>
                              <div class="drop-down">
                                  <div class="selected">
                                      <a href="#"><span>Pilih</span></a>
                                  </div>
                                  <div class="options">
                                      <ul>
                                          <li><a href="<?php echo $sort_base ?>sort=a-z">Nama A-Z</a></li>
                                          <li><a href="<?php echo $sort_base ?>sort=z-a">Nama Z-A</a></li>
                                          <li><a href="<?php echo $sort_base ?>sort=price-asc">Harga Termurah</a></li>
                                          <li><a href="<?php echo $sort_base ?>sort=price-desc">Harga Termahal</a></li>
                                          <li><a href="<?php echo $sort_base ?>sort=date-asc">Terlama</a></li>
                                          <li><a href="<?php echo $sort_base ?>sort=date-desc">Terbaru</a></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                          <div class="shop-col-products">
                              <!-- Shop Products Start -->
                              <?php
                              // mendapatkan produk (semua / sesuai kategori ?cat=)
                              getShopProducts();
                              ?>

                              <!-- Shop Products End -->

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
                                                                  alt=""></a></li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_1.png"
                                                                  alt=""></a></li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_2.png"
                                                                  alt=""></a></li>
                                                      <li><a><img src="assets/images/product_images/gorengan_1_3.png"
                                                                  alt=""></a></li>
                                                  </ul>
                                              </div>
                                              <div class="carousel">
                                                  <div class="image-large">
                                                      <ul>
                                                          <li><a><img src="assets/images/product_images/gorengan_1.png"
                                                                      alt=""></a></li>
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
                                                      <p class="product-desc">tetes air rasta
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
                          </div>
                        </div>

                  </div>
                  <!-- Main Content for Products End -->
              </div>
          </main>
          <!-- Main End -->
          <?php
            // menambahkan Footer
            include 'includes/footer.php';
?>