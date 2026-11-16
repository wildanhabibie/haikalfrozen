<?php
require_once 'includes/init.php';

// harus login dulu
if (empty($currentUser)) {
    redirect('login.php');
}

// hapus pesanan
if (isset($_GET['del_no'])) {
    include 'includes/delete_order.php';
}

$safe_user = db_esc($currentUser);
$result = q("SELECT * FROM users WHERE username = '$safe_user'");
$row = $result ? mysqli_fetch_assoc($result) : null;
if (!$row) {
    // akun sudah dihapus/diganti namanya
    unset($_SESSION['customerName']);
    redirect('login.php');
}
$user_id = (int) $row['id'];
$user_email = $row['email'];
$user_image = $row['user_image'];

// update informasi user
if (isset($_POST['update'])) {
    $username = db_esc($_POST['username']);
    $email = db_esc($_POST['email']);
    $password = $_POST['password'];
    $r_password = $_POST['r_password'];

    if ($password !== $r_password) {
        $r_pass_err = "Password Baru dan Konfirmasi tidak Cocok!";
    } elseif (strlen($password) < 5) {
        $r_pass_err = "Password minimal harus 5 karakter";
    } elseif ($username === '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $r_pass_err = "Nama dan email harus diisi dengan benar!";
    } elseif (q_count(q("SELECT id FROM users WHERE username = '$username' AND id <> '$user_id'")) > 0) {
        $r_pass_err = "Username sudah dipakai orang lain!";
    } else {
        $userIP = db_esc(getUserIP());
        $hash_pass = db_esc(hash_password($password));

        // foto profil baru (opsional)
        $new_image = save_uploaded_image('image', __DIR__ . '/assets/images/customers/');
        $image = db_esc($new_image !== null ? $new_image : $user_image);

        $ok = q("UPDATE users SET user_ip = '$userIP', username = '$username', email = '$email',
                 password = '$hash_pass', user_image = '$image', date = NOW() WHERE id = '$user_id'");
        if ($ok) {
            // login ulang dengan data baru
            unset($_SESSION['customerName']);
            redirect('login.php', 'Update Sukses! Silakan login kembali.');
        }
        $r_pass_err = "Update gagal, coba lagi!";
    }
}

// menambahkan Header
include 'includes/header.php';
?>

                    <!-- Main Start -->
                    <main id="main">
                        <!-- Account Start -->
                        <div class="account-container">
                            <div class="account-row">
                                <h3 class="account-title">Akun Saya</h3>
                            </div>
                            <div class="account-row">
                                <div class="account-col">
                                    <h4 class="account-order">
                                        Pesanan Saya
                                    </h4>
                                    <?php
                                    // pesanan milik pengunjung ini
                                    $per_page = 12;
                                    $page = current_page();
                                    $start_from = ($page - 1) * $per_page;
                                    $ip_add = db_esc(getUserIP());

                                    $result_order = q("SELECT invoice_no, MAX(id) AS last_id FROM orders
                                                       WHERE user_ip = '$ip_add' GROUP BY invoice_no
                                                       ORDER BY last_id DESC LIMIT $start_from, $per_page");

                                    if (q_count($result_order) == 0) {
                                        echo "
                                        <div class='no_found'>
                                        <h4 class='no_found_title'>saat ini tidak ada pesanan!</h4></div>
                                        ";
                                    } else {
                                        $i = $start_from;
                                    ?>
                                    <div class="all-orders">
                                    <?php
                                    while ($row_order = mysqli_fetch_assoc($result_order)) {
                                        $order_id = e($row_order['invoice_no']);
                                        $i++;
                                    ?>
                                    <div class="all-orders-group">
                                        <span><?php echo $i ?>. Order ID : <?php echo $order_id ?></span>
                                        <div class="account-action">
                                            <a href="order.php?order_no=<?php echo $order_id ?>"><i class="fa fa-eye"></i></a>
                                            <a href="account.php?del_no=<?php echo $order_id ?>" onclick="return confirm('Hapus pesanan ini?')"><i class="fa fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
                                        $total_record = q_count(q("SELECT DISTINCT invoice_no FROM orders WHERE user_ip = '$ip_add'"));
                                        render_pagination('account.php?', $page, (int) ceil($total_record / $per_page));
                                    }
                                    ?>
                                </div>
                                <div class="account-col">
                                    <h4 class="account-settings">
                                        Pengaturan Akun
                                    </h4>
                                    <div class="forms">
                                        <span class="text-danger">
                                            <?php if (isset($update_mess)) echo e($update_mess); ?></span>
                                        <span class="text-danger">
                                            <?php if (isset($r_pass_err)) echo e($r_pass_err); ?></span>
                                        <form action="account.php" method="post" enctype="multipart/form-data">
                                            <div class="account-groups">
                                                <?php $avatar = !empty($user_image) ? $user_image : 'user.png'; ?>
                                                <img src="assets/images/customers/<?php echo e($avatar) ?>" alt="<?php echo e($currentUser) ?>">
                                                <input type="file" name="image" accept="image/*" class="custom-file-input">
                                            </div>
                                            <div class="account-groups">
                                                <label for="name">Name</label>
                                                <input class="account-input" name="username" type="text" id="name"
                                                    value="<?php echo e($currentUser); ?>">
                                            </div>
                                            <div class="account-groups">
                                                <label for="email">Email</label>
                                                <input class="account-input" name="email" type="email" id="email"
                                                    value="<?php echo e($user_email); ?>">
                                            </div>
                                            <div class="account-groups"><label for="password">Password</label>
                                                <input class="account-input" type="password" name="password"
                                                    id="password" required>
                                            </div>
                                            <div class="account-groups">
                                                <label for="c_password">tulis ulang password</label>
                                                <input class="account-input" type="password" name="r_password"
                                                    id="c_password" required>
                                            </div>
                                            <button name="update" class="account-btn">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Account End -->
                    </main>
                    <!-- Main End -->
<?php
// menambahkan Footer
include 'includes/footer.php';
