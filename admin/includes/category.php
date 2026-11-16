<?php
// Tambah Kategori
if (isset($_POST['add'])) {
    $category_name = db_esc($_POST['name']);

    if ($category_name !== '' && q("INSERT INTO category (category_name, date) VALUES ('$category_name', NOW())")) {
        redirect('index.php?category');
    }
    $message_error = "Tidak ada kategori yang ditambahkan!";
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
            <form action="index.php?category" method="post">
                <div class="admin-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" required>
                                        <span class="text-danger"><?php if (isset($message_error)) echo $message_error; ?></span>
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
                $result = q("SELECT * FROM category ORDER BY id DESC");

                while ($result && $row = mysqli_fetch_assoc($result)) {
                    $id = (int) $row['id'];
                    $name = e($row['category_name']);

            ?>

            <div class="admin-card category">
                <div class="admin-header">
                    <h5 class="admin-subtitle"><?php echo $name ?></h5>
                </div>
                <div class="admin-footer">
                    <div class="admin-content">
                        <a href="includes/delete_category.php?delete_cat=<?php echo $id; ?>" onclick="return confirm('Hapus kategori ini?')"><i
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
