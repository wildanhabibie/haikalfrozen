<?php
    session_start();
    if(isset($_SESSION['customerName'])){
     $currentUser = $_SESSION['customerName'];
    } else {
        echo"<script>document.location='login.php';</script>";
    }

    include "db.php";

    //count for dashboard
    $get_users = "SELECT * FROM users";
    $run_users = mysqli_query($conn, $get_users);
    $count_users = mysqli_num_rows($run_users);

    $get_products = "SELECT * FROM products";
    $run_products = mysqli_query($conn, $get_products);
    $count_products = mysqli_num_rows($run_products);

    $get_orders = "SELECT * FROM orders GROUP BY invoice_no";
    $run_orders = mysqli_query($conn, $get_orders);
    $count_orders = mysqli_num_rows($run_orders);

    $get_totalPrice = "SELECT SUM(total_price) AS totalPrice FROM orders";
    $run_totalPrice = mysqli_query($conn, $get_totalPrice);
    $row = mysqli_fetch_assoc($run_totalPrice);

    $sub_total = $row['totalPrice'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toko Online Frozen Food">
    <meta name="keywords" content="HTML,CSS,JavaScript">
    <meta name="author" content="Muhammad Wildan Habibie">

    <!-- Link Start -->
    <link rel="stylesheet" href="assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Link End -->

    <title>Admin Panel</title>
</head>

<body>