   <!-- Scripts Start -->
   <script src="assets/js/jquery/jquery.min.js"></script>
   <script src="assets/fonts/font_awesome/js/all.js"></script>
   <script src="assets/js/main.js"></script>
   <!-- Scripts End -->
   <?php

        // Keluar{
        if(isset($_POST['logout'])){
            session_destroy();
            echo"<script>document.location='login.php';</script>";
        }
        ?>

   </body>

   </html>