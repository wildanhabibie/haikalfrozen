        <!-- Footer {sticky} Start -->
        <footer id="footer">
            <section class="horizontal-footer-section" id="footer-top-section">
                <div id="footer-logo">
                    <a href="index.php">Haikal Frozen Food</a>
                </div>
                <div id="footer-top-menu-container" role="menubar">
                    <ul id="footer-top-menu" role="menu">
                        <?php
                            $query = "SELECT * FROM category";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_array($result)){
                                $category_id = $row['id'];
                                $category_name = $row['category_name'];
                        
                        ?>
                        <li class="footer-top-menu-item" role="menuitem">
                            <a href="shop.php?cat=<?php echo $category_id ?>" class="footer-top-menu-link">
                                <?php echo $category_name ?>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <div id="footer-buttons-container">
                    <a href="shop.php" class="footer-button" role="button">Cek Toko Kami</a>
                </div>
            </section>

            <section class="horizontal-footer-section" id="footer-middle-section">
                <div id="footer-about" class="footer-columns footer-columns-large">
                    <h1>Alamat Kami</h1>
                    <address>
                        <p><i class="fa fa-solid fa-location-dot"></i>
                            Jl. KH. Wahid Hasyim No.19, Sanggrahan Kidul, Bendungan, Kec. Wates, Kabupaten Kulon Progo,
                            Daerah Istimewa Yogyakarta 55651
                        </p>
                        <p> <i class="fa fa-solid fa-phone"></i> 0819-1064-7243</p>
                        <p> <i class="fa fa-solid fa-clock"></i>07.00–21.00
                            buka setiap hari
                        </p>
                    </address>
                    <h1>Info Update</h1>
                    <input type="email" class="subscribe-input" placeholder="Email anda"><a href="#"
                        class="footer-button" role="button">Berlangganan</a>
                </div>
                <div class="footer-columns">
                    <h1>Gambaran</h1>
                    <ul class="footer-column-menu" role="menu">
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="index.php" class="footer-column-menu-item-link">Home</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="shop.php" class="footer-column-menu-item-link">Toko</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="opinion.php" class="footer-column-menu-item-link">Testimonial</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="about.php" class="footer-column-menu-item-link">Tentang</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="contact.php" class="footer-column-menu-item-link">Kontak</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-columns">
                    <h1>Resources</h1>
                    <ul class="footer-column-menu" role="menu">
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="" class="footer-column-menu-item-link">Tanya Jawab</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="" class="footer-column-menu-item-link">Media Sosial</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="" class="footer-column-menu-item-link">Petunjuk</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="" class="footer-column-menu-item-link">Free Resources</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="" class="footer-column-menu-item-link">Testimonial</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-columns">
                    <h1>Informasi</h1>
                    <ul class="footer-column-menu" role="menu">
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="#" class="footer-column-menu-item-link">Tentang Kami</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="#" class="footer-column-menu-item-link">Persyaratan</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="#" class="footer-column-menu-item-link">Informasi Hukum</a>
                        </li>
                        <li class="footer-column-menu-item" role="menuitem">
                            <a href="#" class="footer-column-menu-item-link">Kirim Saran</a>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="horizontal-footer-section" id="footer-bottom-section">
                <div id="footer-copyright-info">
                    &copy; Muhammad Wildan Habibie - 2022.
                </div>
            </section>
        </footer>
        <!-- Footer {sticky} End -->

        </div>
        <!-- Main Container End -->




        <!-- Scripts Start -->
        <script src="assets/js/jquery/jquery.min.js"></script>
        <script src="assets/fonts/font_awesome/js/all.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <!-- Scripts End -->

        <?php

        // Keluar{
        if(isset($_POST['logout'])){
            session_destroy();
            echo"<script>document.location='index.php';</script>";
        }

        include "db.php";
        ?>


        </body>

        </html>