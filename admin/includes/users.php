<div class="admin">
    <div class="admin-row">
        <h4 class="admin-title">Admin / <i class="fa-solid fa-users"></i> Users</h4>
    </div>
    <div class="admin-row">
        <!-- Show semua Users Start -->
        <h4 class="admin-add">Semua Users</h4>
    </div>
    <div class="admin-row">
        <!-- Show semua users start -->
        <?php
            // fetch semua kustomer dari DB

            $per_page = 12; //setiap page ada 12 user
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $start_from = ($page - 1) * $per_page;
            $query = "SELECT * FROM users ORDER BY 1 DESC LIMIT $start_from, $per_page";
            $result = mysqli_query($conn, $query);

            $count = mysqli_num_rows($result);
            if($count == 0){
                echo"
                <div class='no_found'>
                <h4 class='no_found_title'>saat ini tidak ada users!</h4></div>
                ";
            } else {
        ?>
        <div class="admin-cards">
            <?php

            while($row = mysqli_fetch_array($result)){
                $user_id = $row['id'];
                $username = $row['username'];
                $user_image = $row['user_image'];
            ?>
            <div class="admin-card">
                <div class="admin-body">
                    <div class="admin-content image">
                        <?php 
                         if(!empty($user_image)){
                        echo "<img src='../assets/images/customers/$user_image' alt='$username'>";
                        } else {
                        echo "<img src='../assets/images/customers/user.png' alt='$username'>";
                        }
                        ?>
                    </div>
                    <div class="admin-content">
                        <p class="admin-desc"><?php echo $username ?></p>
                    </div>
                </div>
                <div class="admin-footer users">
                    <div class="admin-content">
                        <a href="includes/delete_user.php?user_id=<?php echo $user_id; ?>"><i
                                class="fa fa-trash-alt"></i></a>
                        <a href="includes/update_user.php?user_id=<?php echo $user_id; ?>"><i
                                class="fa fa-pencil"></i></a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <!-- Show All Users Start End -->
        <div class="admin-pagination">
            <ul>
                <?php
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($conn, $query);
                    $total_record = mysqli_num_rows($result);
                    $total_page = ceil($total_record / $per_page);
                ?>


                <?php if($page == 1): ?>
                <?php else: ?>
                <li class='pagination-menu-item'>
                    <a href='index.php?users&page=<?php echo ($page - 1) ?>' class='pagination-menu-link'>Prev</a>
                </li>

                <?php if($page > 2): ?>
                <li class='pagination-menu-item '>
                    <a href='index.php?users&page=1'
                        class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 2" ? "active" : ""; ?>'>1</a>
                </li>
                <?php endif ?>

                <?php if($page > 3): ?>
                <li class='pagination-menu-item '>
                    <a class='pagination-menu-link <?php echo $_GET['page'] == "$page  > 3" ? "active" : ""; ?>'>...</a>
                </li>
                <?php endif ?>

                <?php endif ?>
                <?php if($page - 1 > 0): ?>
                <li class='pagination-menu-item'>
                    <a href='index.php?users&page=<?php echo $page - 1 ?>'
                        class='pagination-menu-link <?php echo $_GET['page'] == "$page  - 1 > 0" ? "active" : ""; ?>'><?php echo $page - 1 ?></a>
                </li>
                <?php endif ?>
                <li class='pagination-menu-item'>
                    <a
                        class='pagination-menu-link <?php echo $_GET['page'] == "$page" ? "active" : ""; ?>'><?php echo $page?></a>
                </li>

                <?php if ($page + 1 < $total_page): ?>
                <li class='pagination-menu-item'>
                    <a href='index.php?user&page=<?php echo $page + 1 ?>'
                        class='pagination-menu-link <?php echo $_GET['page'] == "$page + 1 < $total_page" ? "active" : ""; ?>'>
                        <?php echo $page + 1 ?></a>
                </li>
                <?php endif ?>

                <?php if ($page < $total_page): ?>
                <?php if($page < $total_page - 2): ?>
                <li class='pagination-menu-item'>
                    <a
                        class='pagination-menu-link <?php echo $_GET['page'] == "$page < $total_page - 2" ? "active" : ""; ?>'>...</a>
                </li>
                <?php endif ?>
                <li class='pagination-menu-item '>
                    <a href='index.php?users&page=<?php echo $total_page ?>'
                        class='pagination-menu-link <?php echo $_GET['page'] == "$total_page" ? "active" : ""; ?>'><?php echo $total_page ?></a>
                </li>
                <li class='pagination-menu-item'>
                    <a href='index.php?users&page=<?php echo ($page + 1) ?>' class='pagination-menu-link'>Next</a>
                </li>
                <?php endif ?>
            </ul>
        </div>
        <!-- pagination end -->
        <?php 
            }
        ?>
    </div>
</div>