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
            $page = current_page();
            $start_from = ($page - 1) * $per_page;
            $result = q("SELECT * FROM users ORDER BY id DESC LIMIT $start_from, $per_page");

            $count = q_count($result);
            if($count == 0){
                echo"
                <div class='no_found'>
                <h4 class='no_found_title'>saat ini tidak ada users!</h4></div>
                ";
            } else {
        ?>
        <div class="admin-cards">
            <?php

            while($row = mysqli_fetch_assoc($result)){
                $user_id = (int) $row['id'];
                $username = e($row['username']);
                $user_image = e($row['user_image']);
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
                        <a href="includes/delete_user.php?user_id=<?php echo $user_id; ?>" onclick="return confirm('Hapus user ini?')"><i
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
        <?php
            $total_record = q_count(q("SELECT id FROM users"));
            render_pagination('index.php?users&', $page, (int) ceil($total_record / $per_page));
        ?>
        <?php 
            }
        ?>
    </div>
</div>