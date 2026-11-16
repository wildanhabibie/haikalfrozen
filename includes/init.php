<?php
// Dipanggil paling awal di setiap halaman, SEBELUM ada output HTML,
// supaya session, redirect dan proses form bisa berjalan dengan benar.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions/functions.php';

ensure_schema();

// Keluar (logout) - tombolnya ada di header
if (isset($_POST['logout'])) {
    unset($_SESSION['customerName']);
    redirect('index.php');
}

$currentUser = isset($_SESSION['customerName']) ? $_SESSION['customerName'] : null;
