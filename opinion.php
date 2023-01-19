          <?php
            // menambahkan Header
            include 'includes/header.php';

            if(isset($_SESSION['customerName'])){
                $currentUser = $_SESSION['customerName'];
                
                $query = "SELECT * FROM users WHERE username = '$currentUser'";
                $result = mysqli_query($conn, $query);
                
                $row = mysqli_fetch_array($result);
                $user_image = $row['user_image'];
            }

            
            //Add Opinion
            if(isset($_POST['add'])){
                $userip = getUserIP();
                $message = $_POST['message'];

                $query = "INSERT INTO opinion (user_ip, user_name, user_image, user_message, date) VALUES('$userip', '$currentUser','$user_image','$message', now())";
                $result = mysqli_query($conn, $query);

                if($result){
                    $message = "Komentar sudah ditambahkan!";
                    echo"<script>document.location='opinion.php';</script>";
                }
            }


            ?>

          <!-- Main Start -->
          <main id="main">

              <!-- Opinion Start -->
              <div class="opinion-container">
                  <h2 class="opinion-title">
                      bagi kami anda adalah raja!
                  </h2>
                  <?php
                  if(isset($_SESSION['customerName'])){
                    ?>
                  <div class="opinion-row">
                      <form action="" method="post">
                          <div class="form-opinion">
                              <label for="opinion">Opini Anda</label>
                              <textarea name="message" id="opinion" cols="30" rows="10" required></textarea>
                          </div>
                          <span class="text-success"><?php if(isset($message)) echo $message;?></span>
                          <button name="add" class="btn-opinion">Tambahkan</button>
                      </form>
                  </div>
                  <div class="opinion-row">
                      <div class="opinion-col">
                          <?php
                        
                            $per_page = 12; //setiap page ada 12 komentar
                          if(isset($_GET['page'])){
                          $page = $_GET['page'];
                          } else {
                          $page = 1;
                          }

                          $start_from = ($page - 1) * $per_page;
                          $query = "SELECT * FROM opinion ORDER BY 1 DESC LIMIT $start_from, $per_page";
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
                              ?>
                          </div>
                      </div>
                  </div>
                  <!-- Show All Users Start End -->
                  <!-- pagination start -->
                  <div class="admin-pagination">
                      <ul>
                          <?php
                                $query = "SELECT * FROM opinion";
                                $result = mysqli_query($conn, $query);
                                $total_record = mysqli_num_rows($result);
                                 $total_page = ceil($total_record / $per_page);
                            ?>
                          <?php if($page == 1): ?>
                          <?php else: ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo ($page - 1) ?>' class='pagination-menu-link'>Prev</a>
                          </li>

                          <?php if($page > 2): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=1'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                          </li>
                          <?php endif ?>

                          <?php if($page > 3): ?>
                          <li class='pagination-menu-item'>
                              <a
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                          </li>
                          <?php endif ?>

                          <?php endif ?>
                          <?php if($page - 1 > 0): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $page - 1 ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                          </li>
                          <?php endif ?>
                          <li class='pagination-menu-item'>
                              <a
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?>'><?php echo $page?></a>
                          </li>

                          <?php if ($page + 1 < $total_page): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $page + 1 ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'>
                                  <?php echo $page + 1 ?></a>
                          </li>
                          <?php endif ?>

                          <?php if ($page < $total_page): ?>
                          <?php if($page < $total_page - 2): ?>
                          <li class='pagination-menu-item
                            <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>
                              <a class='pagination-menu-link'>...</a>
                          </li>
                          <?php endif ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $total_page ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'><?php echo $total_page ?></a>
                          </li>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo ($page + 1) ?>'
                                  class='pagination-menu-link '>Next</a>
                          </li>
                          <?php endif ?>
                      </ul>
                  </div>
                  <!-- pagination end -->
                  <?php 
                    }
                    ?>


                  <?php
                    } else {
                     
                   ?>

                  <div class="opinion-row">
                      <div class="opinion-col">
                          <?php
                        
                            $per_page = 12; //setiap page ada 12 komentar
                          if(isset($_GET['page'])){
                          $page = $_GET['page'];
                          } else {
                          $page = 1;
                          }

                          $start_from = ($page - 1) * $per_page;
                          $query = "SELECT * FROM opinion ORDER BY 1 DESC LIMIT $start_from, $per_page";
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
                              ?>
                          </div>
                      </div>
                  </div>
                  <!-- Show All Users Start End -->
                  <!-- pagination start -->
                  <div class="admin-pagination">
                      <ul>
                          <?php
                                $query = "SELECT * FROM opinion";
                                $result = mysqli_query($conn, $query);
                                $total_record = mysqli_num_rows($result);
                                 $total_page = ceil($total_record / $per_page);
                            ?>
                          <?php if($page == 1): ?>
                          <?php else: ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo ($page - 1) ?>' class='pagination-menu-link'>Prev</a>
                          </li>

                          <?php if($page > 2): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=1'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                          </li>
                          <?php endif ?>

                          <?php if($page > 3): ?>
                          <li class='pagination-menu-item'>
                              <a
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                          </li>
                          <?php endif ?>

                          <?php endif ?>
                          <?php if($page - 1 > 0): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $page - 1 ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page  - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                          </li>
                          <?php endif ?>
                          <li class='pagination-menu-item'>
                              <a
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?>'><?php echo $page?></a>
                          </li>

                          <?php if ($page + 1 < $total_page): ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $page + 1 ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'>
                                  <?php echo $page + 1 ?></a>
                          </li>
                          <?php endif ?>

                          <?php if ($page < $total_page): ?>
                          <?php if($page < $total_page - 2): ?>
                          <li class='pagination-menu-item
                            <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>
                              <a class='pagination-menu-link'>...</a>
                          </li>
                          <?php endif ?>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo $total_page ?>'
                                  class='pagination-menu-link <?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'><?php echo $total_page ?></a>
                          </li>
                          <li class='pagination-menu-item'>
                              <a href='opinion.php?page=<?php echo ($page + 1) ?>'
                                  class='pagination-menu-link '>Next</a>
                          </li>
                          <?php endif ?>
                      </ul>
                  </div>
                  <!-- pagination end -->
                  <?php 
                    }
                    ?>


                  <?php
                    }
                    ?>

              </div>
              <!-- Opinion End -->
          </main>
          <!-- Main End -->


          <?php
            // menambahkan Footer
            include 'includes/footer.php';

        ?>