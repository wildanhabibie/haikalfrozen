<?php
require_once __DIR__ . '/init.php';
require_admin('login.php');

// angka untuk dashboard
$count_users = q_count(q("SELECT id FROM users"));
$count_products = q_count(q("SELECT id FROM products"));
$count_orders = q_count(q("SELECT DISTINCT invoice_no FROM orders"));

$run_totalPrice = q("SELECT COALESCE(SUM(total_price), 0) AS totalPrice FROM orders");
$row = $run_totalPrice ? mysqli_fetch_assoc($run_totalPrice) : ['totalPrice' => 0];
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