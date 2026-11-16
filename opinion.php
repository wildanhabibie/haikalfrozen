<?php
require_once 'includes/init.php';

$user_image = '';
if (!empty($currentUser)) {
    $safe_user = db_esc($currentUser);
    $result = q("SELECT * FROM users WHERE username = '$safe_user'");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $user_image = $row['user_image'];
    }
}

// Tambah testimoni (hanya untuk user yang login)
if (isset($_POST['add']) && !empty($currentUser)) {
    $userip = db_esc(getUserIP());
    $message = db_esc($_POST['message']);
    $safe_user = db_esc($currentUser);
    $safe_image = db_esc($user_image);

    if ($message === '') {
        $form_message = "Opini tidak boleh kosong!";
    } elseif (q("INSERT INTO opinion (user_ip, user_name, user_image, user_message, date)
                 VALUES ('$userip', '$safe_user', '$safe_image', '$message', NOW())")) {
        redirect('opinion.php', 'Komentar sudah ditambahkan!');
    } else {
        $form_message = "Komentar gagal ditambahkan!";
    }
}

// menambahkan Header
include 'includes/header.php';
?>

          <!-- Main Start -->
          <main id="main">

              <!-- Opinion Start -->
              <div class="opinion-container">
                  <h2 class="opinion-title">
                      bagi kami anda adalah raja!
                  </h2>
                  <?php if (!empty($currentUser)): ?>
                  <div class="opinion-row">
                      <form action="opinion.php" method="post">
                          <div class="form-opinion">
                              <label for="opinion">Opini Anda</label>
                              <textarea name="message" id="opinion" cols="30" rows="10" required></textarea>
                          </div>
                          <span class="text-success"><?php if (isset($form_message)) echo e($form_message); ?></span>
                          <button name="add" class="btn-opinion">Tambahkan</button>
                      </form>
                  </div>
                  <?php else: ?>
                  <div class="opinion-row">
                      <p><a href="login.php">Login</a> untuk menulis testimoni anda.</p>
                  </div>
                  <?php endif ?>

                  <div class="opinion-row">
                      <div class="opinion-col">
                          <?php
                          $per_page = 12; // setiap page ada 12 komentar
                          $page = current_page();
                          $start_from = ($page - 1) * $per_page;

                          $result = q("SELECT * FROM opinion ORDER BY id DESC LIMIT $start_from, $per_page");
                          if (q_count($result) == 0) {
                              echo "
                              <div class='no_found'>
                                  <h4 class='no_found_title'>Saat ini tidak ada Testimonial!</h4>
                              </div>
                              ";
                          } else {
                          ?>
                          <div class="opinion-cards">
                              <?php
                              while ($row = mysqli_fetch_assoc($result)) {
                                  $username = e($row['user_name']);
                                  $avatar = !empty($row['user_image']) ? e($row['user_image']) : 'user.png';
                              ?>
                              <div class="opinion-card">
                                  <div class="opinion-card-header">
                                      <p class="opinion-date"><?php echo e($row['date']) ?></p>
                                  </div>
                                  <div class="opinion-card-body">
                                      <p class="opinion-desc"><?php echo nl2br(e($row['user_message'])) ?></p>
                                  </div>
                                  <div class="opinion-card-footer">
                                      <img src="assets/images/customers/<?php echo $avatar ?>" alt="<?php echo $username ?>" class="opinion-img">
                                      <span class="opinion-name"><?php echo $username ?></span>
                                  </div>
                              </div>
                              <?php
                              }
                              ?>
                          </div>
                          <?php
                          }
                          ?>
                      </div>
                  </div>
                  <!-- pagination -->
                  <?php
                  $total_record = q_count(q("SELECT id FROM opinion"));
                  render_pagination('opinion.php?', $page, (int) ceil($total_record / $per_page));
                  ?>
              </div>
              <!-- Opinion End -->
          </main>
          <!-- Main End -->

<?php
// menambahkan Footer
include 'includes/footer.php';
