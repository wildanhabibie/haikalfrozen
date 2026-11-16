<?php
require_once __DIR__ . '/init.php';
require_admin('../login.php');

// user yang akan diupdate
$user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;
$result = q("SELECT * FROM users WHERE id = '$user_id'");
$row = $result ? mysqli_fetch_assoc($result) : null;
if (!$row) {
    redirect('../index.php?users', 'User tidak ditemukan!');
}
$customer_name = $row['username'];
$customer_email = $row['email'];
$customer_pass = $row['password'];
$customer_block = (int) $row['user_block'];
$customer_image = $row['user_image'];

// update informasi user
if (isset($_POST['update'])) {
    $username = db_esc($_POST['name']);
    $email = db_esc($_POST['email']);
    $password = $_POST['password'];

    // password hanya diganti kalau diisi
    $hash_pass = db_esc($password !== '' ? hash_password($password) : $customer_pass);

    // foto baru (opsional)
    $new_image = save_uploaded_image('image', CUSTOMER_IMG_DIR);
    $image = db_esc($new_image !== null ? $new_image : $customer_image);

    if ($username === '') {
        $update_mess = "Nama user tidak boleh kosong!";
    } elseif (q_count(q("SELECT id FROM users WHERE username = '$username' AND id <> '$user_id'")) > 0) {
        $update_mess = "Username sudah dipakai user lain!";
    } elseif (q("UPDATE users SET username = '$username', email = '$email', password = '$hash_pass',
                 user_image = '$image', date = NOW() WHERE id = '$user_id'")) {
        redirect('../index.php?users', 'Update Sukses!');
    } else {
        $update_mess = "Update gagal!";
    }
}

// Blokir / buka blokir user
if (isset($_POST['block'])) {
    $new_block = $customer_block === 1 ? 0 : 1;
    if (q("UPDATE users SET user_block = '$new_block' WHERE id = '$user_id'")) {
        redirect("update_user.php?user_id=$user_id", $new_block ? 'User diblokir!' : 'User tidak diblokir!');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link Start -->
    <link rel="stylesheet" href="../assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Link End -->
</head>

<body>
    <!-- Main Start -->
    <main id="main">
        <!-- Order Start -->
        <div class="order-container">
            <div class="order-row">
                <a href="../index.php?users" class="order-back"><i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="delete_user.php?user_id=<?php echo $user_id; ?>" class="delete_product" onclick="return confirm('Hapus user ini?')">Hapus User <i
                        class="fa fa-trash-alt"></i></a>
                <h2 class="order-title">Update User</h2>
            </div>
            <div class="order-row update">
                <span class="text-danger user">
                    <?php if (isset($update_mess)) echo e($update_mess); ?></span>
                <form action="update_user.php?user_id=<?php echo $user_id ?>" method="post" enctype="multipart/form-data">
                    <div class="admin-group">
                        <label for="name">Nama User</label>
                        <input type="text" name="name" id="name" value="<?php echo e($customer_name); ?>" required>
                    </div>
                    <div class="admin-group">
                        <label for="email">Email User</label>
                        <input type="email" name="email" id="email" value="<?php echo e($customer_email); ?>">
                    </div>
                    <div class="admin-group">
                        <label for="image">User Image</label>
                        <?php $avatar = !empty($customer_image) ? $customer_image : 'user.png'; ?>
                        <img src="../../assets/images/customers/<?php echo e($avatar) ?>" alt="<?php echo e($customer_name) ?>">
                        <input type="file" name="image" id="user_image" class="custom-file-input">
                    </div>
                    <div class="admin-group">
                        <label for="password">Password User</label>
                        <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diganti">
                    </div>
                    <div class="admin-group">
                        <?php
                        if($customer_block == 1){
                            echo "<label for='block'>User sedang diblokir</label>
                            <button name='block' class='block-btn' formnovalidate><i class='fa-solid fa-ban'></i>Unblock
                            </button>";
                        } else {
                            echo "<label for='block'>Blokir User</label>
                            <button name='block' class='block-btn' formnovalidate><i class='fa-solid fa-ban'></i>Block
                            </button>";
                        }
                        ?>
                    </div>
                    <div class="admin-group-btn custom">
                        <button name="update">Update User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order End -->
    </main>
    <!-- Main End -->
    <!-- Scripts Start -->
    <script src="../assets/js/jquery/jquery.min.js"></script>
    <script src="../assets/fonts/font_awesome/js/all.js"></script>
    <!-- Scripts End -->
</body>

</html>