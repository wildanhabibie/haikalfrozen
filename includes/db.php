<?php

// Parameters
$servername = "localhost";
$username = "root"; //root adalah default untuk localhost
$password = ""; // kosongkan untuk default localhost
$database = "online_shop";

// Membuat Koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Untuk Mengecek koneksi

// jika tidak sukses
if(!$conn){
    die("Koneksi Gagal" . mysqli_connect_error());
}

// jika sukses
// echo "Koneksi Sukses!";

?> 