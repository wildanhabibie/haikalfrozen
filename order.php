          <?php
            // menambahkan Header
            include 'includes/header.php';

            // memeriksa halaman order jika ada,kalau tidak ada maka langsung menuju ke homepage
            if (!isset($_GET['order_no'])) {
            echo "<script>window.open('index.php', '_self');</script>";
            }else if(isset($_GET['order_no'])){
                // jika tidak ada order akan diarahkan ke homepage
                $check_id = $_GET['order_no'];
                $ip_add = getUserIP();
                $check_order = "SELECT * FROM orders WHERE user_ip='$ip_add' AND invoice_no = '$check_id'";
                $query_order = mysqli_query($conn, $check_order);
                $count = mysqli_num_rows($query_order);
                if($count == 0){
                    echo"<script>window.open('index.php','_self');</script>";
                }
            }
            
            // mendapatkan semua dari orders
            if(isset($_GET['order_no'])){

                $order_id = $_GET['order_no'];
                $ip_add = getUserIP();

                $query = "SELECT * FROM orders WHERE user_ip='$ip_add' AND invoice_no = '$order_id'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);

                $user_name = $row['user_name'];
                $user_email = $row['user_email'];
                $user_phone = $row['user_phone'];
                $user_address = $row['user_address'];

            }

            ?>

          <!-- Main Start -->
          <main id="main">
              <!-- Order Start -->
              <div class="order-container">
                  <div class="order-row">
                      <h2 class="order-title">Halo <?php echo $user_name ?></h2>
                      <p class="order-subtitle">Terimakasih sudah memesan di tempat kami. anda dapat melihat pesanan
                          anda di bawah.</p>
                  </div>
                  <div class="order-row">
                      <div class="order-col">
                          <div class="order-group">
                              <span>Nama Lengkap </span>
                              <h4><?php echo $user_name ?></h4>
                          </div>
                          <div class="order-group">
                              <span>Email </span>
                              <h4><?php echo $user_email ?></h4>
                          </div>
                          <div class="order-group">
                              <span>Telepon </span>
                              <h4><?php echo $user_phone ?></h4>
                          </div>
                          <div class="order-group">
                              <span>Alamat </span>
                              <h4><?php echo $user_address ?></h4>
                          </div>
                      </div>
                      <div class="order-col">
                          <div class="order-group">
                              <span>No Pesanan </span>
                              <h4><?php echo $order_id ?></h4>
                          </div>
                          <?php 
                          // mendapatkan semua dari orders
                            if(isset($_GET['order_no'])){

                                $order_id = $_GET['order_no'];
                                $ip_add = getUserIP();

                                $total = 0;

                                $query_all = "SELECT * FROM orders WHERE user_ip='$ip_add' AND invoice_no = '$order_id'";
                                $result_all = mysqli_query($conn, $query_all);
                                while($row_all = mysqli_fetch_array($result_all)) {
                                    $product_id = $row['product_id'];
                                    $product_name = $row['product_name'];
                                    $product_price = $row['product_price'];
                                    $product_quantity = $row['product_quantity'];
                                    $product_size = $row['product_size'];
                                    $product_jenis = $row['product_jenis'];
                                    
                                    $sub_total = $product_price * $product_quantity;
                                    $total += $sub_total;

                                    ?>
                                    <div class="orders-group">
                                    <div class="order-group">
                                        <span>Nama Produk</span>
                                        <h4><?php echo $product_name ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Harga Produk</span>
                                        <h4>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Jenis Produk</span>
                                        <h4><?php echo $product_jenis ?></h4>
                                    </div>
                                    <div class="order-group">
                                        <span>Ukuran Produk</span>
                                        <h4><?php echo $product_size ?></h4>
                                    </div>
                                </div>
                                    <?php
                                
                                }
                            }
                          ?>
                          
                      </div>
                      </div>
                      <div class="order-row">
                        <div class="order-group">
                            <span>Total</span>
                            <h4>Rp.<?php echo number_format((float)$product_price, 3, '.', '') ?></h4>
                        </div>
                        <div class="order-group">
                        <?php
                        //Dikurangi 20%
                        $reduced_price = (($total / 100)* 20);
                        ?>
                            <span>20.00%</span>
                            <h4>Rp.<?php echo number_format((float)$reduced_price, 3, '.', '') ?></h4>
                        </div>
                        <div class="order-group">
                        <?php
                            //Number format - tiga desimal
                            $totalPrice= (($total / 100)* 20) + $total;
                            ?>
                            <span>total dengan VAT</span>
                            <h4>Rp.<?php echo number_format((float)$totalPrice, 3, '.', '') ?></h4>
                        </div>
                      </div>
                      <div class="order-row">
                        <a href="includes/downloadOrder.php?order_no=<?php echo $invoice_no ?>" target="_blank">Download ke PDF<i class="fa-solid fa-file-pdf"></i></a>
                      </div>
          </main>
          <!-- Main End -->


          <?php
            // menambahkan Footer
            include 'includes/footer.php'
        ?>