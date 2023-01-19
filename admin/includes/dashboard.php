<div class="admin">
    <div class="admin-row">
        <h4 class="admin-title">Admin / <i class="fa-solid fa-qrcode"></i> Dashboard</h4>
    </div>
    <div class="admin-row">
        <!-- Dashboard Start -->
        <div class="admin-cards">
            <div class="admin-card">
                <div class="admin-header">
                    <h5 class="admin-subtitle">Harga Total</h5>
                </div>
                <div class="admin-body">
                    <div class="admin-content">
                        <i class="fa-solid fa-money-bill"></i>
                        <?php

                        if(!$sub_total){
                            echo "<span class='admin-price'>Rp. 0.000</span>";
                        } else {
                            echo "<span class='admin-price'>Rp. $sub_total</span>";
                        }
                        
                        ?>
                        
                    </div>
                </div>
            </div>
            <div class="admin-card">
                <div class="admin-header">
                    <h5 class="admin-subtitle">Produk</h5>
                </div>
                <div class="admin-body">
                    <div class="admin-content">
                        <span class="admin-badge"><?php echo $count_products ?></span>
                    </div>
                    <div class="admin-content">
                        <i class="fa-solid fa-eye"></i>
                        <a href="index.php?products">Lihat Semua</a>
                    </div>
                </div>
            </div>
            <div class="admin-card">
                <div class="admin-header">
                    <h5 class="admin-subtitle">Pesanan</h5>
                </div>
                <div class="admin-body">
                    <div class="admin-content">
                        <div class="admin-info">
                            <span class="admin-badge"><?php echo $count_orders ?></span>
                        </div>
                    </div>
                    <div class="admin-content">
                        <i class="fa-solid fa-eye"></i>
                        <a href="index.php?orders">Lihat Semua</a>
                    </div>
                </div>
            </div>
            <div class="admin-card">
                <div class="admin-header">
                    <h5 class="admin-subtitle">Users</h5>
                </div>
                <div class="admin-body">
                    <div class="admin-content">
                        <div class="admin-info">
                            <span class="admin-badge"><?php echo $count_users ?></span>
                        </div>
                    </div>
                    <div class="admin-content">
                        <i class="fa-solid fa-eye"></i>
                        <a href="index.php?users">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard End -->
    </div>
</div>