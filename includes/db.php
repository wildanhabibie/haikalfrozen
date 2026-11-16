<?php

// Parameter koneksi database (ubah sesuai server anda)
$servername = "localhost";
$username = "root"; // root adalah default untuk localhost
$password = "";     // kosongkan untuk default localhost (XAMPP)
$database = "online_shop";

// Sejak PHP 8.1 mysqli melempar exception untuk setiap error SQL sehingga
// halaman langsung "Fatal error". Kita matikan dan cek hasil query manual.
mysqli_report(MYSQLI_REPORT_OFF);

// Membuat Koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// jika tidak sukses
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
