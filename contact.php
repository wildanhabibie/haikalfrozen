          <?php
            // menambahkan Header
            include 'includes/header.php';


           // kirim pesan
            if(isset($_POST['send'])){

                $full_name = $_POST['name'];
                $email = $_POST['email'];
                $s_email = $_POST['s_email'];
                $message = $_POST['message'];

                // kalau email isset dan email tidak kosong, maka pesan tidak terkirim
                if(isset($email) && trim($email !="") ){

                    $message = "Bot berusaha untuk mengirim email!";
                    
                } else {

                $to = "lelyyusnita73@gmail.com";
                $mail_subject = "pesan dari situs";
                
                $email_body = "Pesan dari halaman kontak situs";
                $email_body .= "<b>Pesan:</b><br>". nl2br(strip_tags($message));
                $email_body .= "<br><b></b>{$full_name}<br>";

                $header = "Email: {$s_email}\r\nContent-Type: text/html;";
                   
                $send_mail_result = mail($to, $mail_subject, $email_body, $header );

                // hanya berlaku di live server
                
                if($send_mail_result) {
                    echo "<script>alert('pesan terkirim!')</script>";
                    echo "<script>window.open('contact.php', '_self')</script>";
                } else {
                    echo "<script>alert('pesan tidak terkirim!')</script>";
                    echo "<script>window.open('contact.php', '_self')</script>";
                }

                }

            }

            ?>

          <!-- Main Start -->
          <main id="main">
              <!-- Halaman Kontak Start -->
              <div class="contact-container">
                  <div class="contact-row">
                      <h2 class="contact-title">Kontak Kami</h2>
                      <p class="sub-title">Apakah anda memiliki kritik dan saran agar toko ini menjadi lebih
                          baik,ataupun ingin mengetahui lebih lanjut informasi produk,pelayanan ataupun ingin bermitra
                          dengan kami? kirimkan pesan untuk menjalin kedekatan dengan kami.</p>
                  </div>
                  <div class="contact-row">
                      <div class="contact-col">
                          <!-- Form Start -->

                          <form action="" method="post" class="contact-form">
                              <div class="contact-group">
                                  <label for="name">Nama Lengkap</label>
                                  <input name="name" type="text" id="name" required>
                              </div>
                              <!-- kolom ini hanya untuk bots atau hacker.. jika pesan isset tidak dapat dikirim -->
                              <div class="contact-group hidden">
                                  <label for="email">Email Bots</label>
                                  <input name="email" type="email" id="email">
                              </div>
                              <div class="contact-group">
                                  <label for="s_email">Email Anda</label>
                                  <input name="s_email" type="s_email" id="email" required>
                              </div>
                              <div class="contact-group">
                                  <label for="name">Pesan Anda</label>
                                  <textarea name="message" id="" cols="30" rows="10" required></textarea>
                              </div>
                              <span class="text-error"><?php if (isset($message)) echo $message; ?></span>
                              <button name="send" class="contact-btn">Kirim</button>
                          </form>
                          <!-- Form End -->
                      </div>
                      <div class="contact-col">
                          <!-- Social Icons Start -->
                          <p class="socials">
                              Cara menghubungi kami lainya
                          </p>
                          <div class="socials-group">
                              <a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a>
                              <a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a>
                              <a href="#"><i class="fa-brands fa-whatsapp"></i> Whatsapp</a>
                          </div>
                          <!-- Social Icons End -->
                      </div>
                  </div>
                  <div class="contact-row">
                      <div class="contact-col">
                          <!-- Contact Info Start -->
                          <div class="contact-info">
                              <h3>Alamat Kami</h3>
                              <p>Jl. KH. Wahid Hasyim No.19, Sanggrahan Kidul, Bendungan, Kec. Wates, Kabupaten Kulon
                                  Progo</p>
                              <p>Kec. Wates, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta 55651</p>
                              <p>haikalfrozenfood@gmail.com</p>
                          </div>
                          <!-- Contact Info End -->
                      </div>
                      <div class="contact-col">
                          <!-- Maps Start -->
                          <div class="contact-map">
                              <iframe
                                  src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15808.067503448454!2d110.1416335!3d-7.8933027!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e0c41d0fd56cc55!2sHaikal%20Frozen%20Food!5e0!3m2!1sid!2sid!4v1663236209937!5m2!1sid!2sid"
                                  width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                  referrerpolicy="no-referrer-when-downgrade"></iframe>
                          </div>
                          <!-- Maps End -->
                      </div>
                  </div>
              </div>
              <!-- Halaman Kontak End -->
          </main>
          <!-- Main End -->


          <?php
            // menambahkan Footer
            include 'includes/footer.php';

            
        ?>