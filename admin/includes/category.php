<?php

    //Tambah Kategori
    if(isset($_POST['add'])){
        $category_name = $_POST['name'];
        
        $query = "INSERT INTO category (category_name, date) VALUES ('$category_name', NOW())";
        $result = mysqli_query($conn, $query);
        if($result){
            $message_success = "Kategori baru sudah ditambahkan!";
            echo"<script>document.location='index.php?category';</script>";
        } else {
            $message_error = "Tidak ada kategori yang ditambahkan!";
        }
    }
?>
<div class="admin">
    <div class="admin-row">
        <h4 class="admin-title">Admin / <i class="fa-solid fa-list-check"></i> Kategori</h4>
    </div>
    <div class="admin-row">
        <!-- Menambahkan Kategori Start -->
        <h4 class="admin-add">Tambahkan Kategori</h4>
        <div class="admin-add-col">
            <form action="" method="post">
                <div class="admin-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" require>
                    <span class="text-success"><?php if (isset($message_success)) echo $message_success; ?></span>
                    <span class="text-danger"><?php if (isset($message_error)) echo $message_error; ?>
                </div>
                <div class="admin-group-btn">
                    <button name="add">Tambahkan Kategori</button>
                </div>
            </form>
        </div>
        <!-- Menambahkan Kategori End -->
    </div>
    <div class="admin-row">
        <!-- Show All Kategori Start -->
        <div class="admin-cards">
            <?php 
            
                //fetch semua kategori
                $query = "SELECT * FROM category ORDER BY 1 DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_array($result)) {
                    
                    $id = $row['id'];
                    $name = $row['category_name'];

            ?>

            <div class="admin-card category">
                <div class="admin-header">
                    <h5 class="admin-subtitle"><?php echo $name ?></h5>
                </div>
                <div class="admin-footer">
                    <div class="admin-content">
                        <a href="includes/delete_category.php?delete_cat=<?php echo $id; ?>"><i
                                class="fa fa-trash-alt"></i></a>
                        <a href="includes/update_category.php?update_cat=<?php echo $id; ?>"><i
                                class="fa fa-pencil"></i></a>
                    </div>
                </div>
            </div>

            <?php
            }

            ?>
        </div>
    </div>
    <!-- Show All Kategori Start -->
</div>
</div>