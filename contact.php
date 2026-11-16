<?php
require_once 'includes/init.php';

// kirim pesan
if (isset($_POST['send'])) {
    $full_name = trim($_POST['name']);
    $bot_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $s_email = trim($_POST['s_email']);
    $pesan = trim($_POST['message']);

    if ($bot_email !== '') {
        // kolom tersembunyi terisi -> kemungkinan bot, pesan tidak dikirim
        $message = "Bot berusaha untuk mengirim email!";
    } elseif (!filter_var($s_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email anda tidak valid!";
    } else {
        $to = "lelyyusnita73@gmail.com";
        $mail_subject = "Pesan dari situs Haikal Frozen Food";

        $email_body = "<b>Pesan dari halaman kontak situs</b><br><br>";
        $email_body .= "<b>Nama:</b> " . e($full_name) . "<br>";
        $email_body .= "<b>Email:</b> " . e($s_email) . "<br>";
        $email_body .= "<b>Pesan:</b><br>" . nl2br(e($pesan));

        $headers = "Reply-To: {$s_email}\r\nContent-Type: text/html; charset=UTF-8";

        // mail() hanya berhasil di server yang sudah dikonfigurasi untuk mengirim email
        if (@mail($to, $mail_subject, $email_body, $headers)) {
            redirect('contact.php', 'pesan terkirim!');
        }
        redirect('contact.php', 'pesan tidak terkirim!');
    }
}

// menambahkan Header
include 'includes/header.php';
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

                          <form action="contact.php" method="post" class="contact-form">
                              <div class="contact-group">
                                  <label for="name">Nama Lengkap</label>
                                  <input name="name" type="text" id="name" required>
                              </div>
                              <!-- kolom ini hanya untuk bots atau hacker.. jika pesan isset tidak dapat dikirim -->
                              <div class="contact-group hidden">
                                  <label for="email">Email Bots</label>
                                  <input name="email" type="email" id="email" tabindex="-1" autocomplete="off">
                              </div>
                              <div class="contact-group">
                                  <label for="s_email">Email Anda</label>
                                  <input name="s_email" type="email" id="s_email" required>
                              </div>
                              <div class="contact-group">
                                  <label for="message">Pesan Anda</label>
                                  <textarea name="message" id="message" cols="30" rows="10" required></textarea>
                              </div>
                              <span class="text-error"><?php if (isset($message)) echo e($message); ?></span>
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
