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
                    $query = "SELECT * FROM orders GROUP by invoice_no";
                    $result = mysqli_query($conn, $query);
                    $count = mysqli_num_rows($result);

                    if($count == 0){
                        echo "<h4>Tidak ada pesanan sekarang!</h4>";
                    }

                while ($row = mysqli_fetch_array($result)) {
                    $invoice_no = $row['invoice_no'];
                    $user_name = $row['user_name'];

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