<?php
// session_start();
            // Includes DB File
            include 'includes/db.php';

            // menambahkan Header
            include 'includes/header.php';
            
        ?>

<!-- Admin Panel Start -->
<div class="wrapper hover_collapse">
    <!-- Top Navbar Start -->
    <div class="top-navbar">
        <!-- Logo Start -->
        <div class="logo">
            <h2>Haikal Frozen Food</h2>
        </div>
        <!-- Logo End -->
        <!-- Menu Start -->
        <div class="menu">
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="logout">
                <?php
                echo 
                "<form method='post'>
                    <button name='logout' class='admin-logout'><i class='fa-solid fa-arrow-right-to-bracket'></i> Keluar</button>
                </form>
                ";            
                ?>
            </div>
        </div>
        <!-- Menu End -->
    </div>
    <!-- Top Navbar End -->
    <!-- Main Container Start -->
    <div class="main-container">
        <!-- Sidebar Start -->
        <div class="sidebar">
            <div class="sidebar_inner">
                <ul>
                    <li>
                        <a href="index.php?dashboard">
                            <span class="icon"><i class="fa-solid fa-qrcode"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?products">
                            <span class="icon"><i class="fa-brands fa-product-hunt"></i></span>
                            <span class="text">Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?category">
                            <span class="icon"><i class="fa-solid fa-list-check"></i></span>
                            <span class="text">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?orders">
                            <span class="icon"><i class="fa-solid fa-repeat"></i></span>
                            <span class="text">Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?users">
                            <span class="icon"><i class="fa-solid fa-users"></i></span>
                            <span class="text">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?settings">
                            <span class="icon"><i class="fa-solid fa-gear"></i></span>
                            <span class="text">Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Sidebar End -->

        <!-- Main Part Start -->
        <div class="main-part">
            <?php
                // Insert Dashboard
                if(isset($_GET['dashboard'])){
                    include("includes/dashboard.php");
                }

                 if(isset($_GET['products'])){
                    include("includes/products.php");
                }

                if(isset($_GET['category'])){
                    include("includes/category.php");
                }
                
                if(isset($_GET['settings'])){
                    include("includes/settings.php");
                }

                if(isset($_GET['users'])){
                    include("includes/users.php");
                }

                if(isset($_GET['orders'])){
                    include("includes/orders.php");
                }
                
            ?>




        </div>
        <!-- Main Part End -->
    </div>
    <!-- Main Container End -->
</div>
<!-- Admin Panel End -->
<?php
    // menambah Footer
    include "includes/footer.php";
?>