<div class="admin">
    <div class="admin-row">
        <!-- Semua Pesanan Start -->
        <h4 class="admin-title">Admin / <i class="fa-solid fa-repeat"></i> Pesanan</h4>
    </div>
    <div class="admin-row">
        <h4 class="admin-add">Semua Pesanan</h4>
        <div class="admin-add-col">
            <div class="admin-cards">
                <?php
                    $result = q("SELECT invoice_no, MAX(user_name) AS user_name, MAX(id) AS last_id
                                 FROM orders GROUP BY invoice_no ORDER BY last_id DESC");
                    $count = q_count($result);

                    if($count == 0){
                        echo "<h4>Tidak ada pesanan sekarang!</h4>";
                    }

                while ($result && $row = mysqli_fetch_assoc($result)) {
                    $invoice_no = e($row['invoice_no']);
                    $user_name = e($row['user_name']);

    ?>
                <div class="admin-card">
                    <div class="admin-header">
                        <h5 class="admin-subtitle"><?php echo $invoice_no ?></h5>
                    </div>
                    <div class="admin-body">
                        <div class="admin-content orders">
                            <h3 class="admin-desc"><?php echo $user_name ?></h3>
                        </div>
                    </div>
                    <div class="admin-footer">
                        <div class="admin-content">
                            <a href="includes/order.php?order_no=<?php echo $invoice_no ?>">Lihat Pesanan<i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <?php
}
                ?>
            </div>
        </div>
        <!-- Semua Pesanan End -->
    </div>
</div>