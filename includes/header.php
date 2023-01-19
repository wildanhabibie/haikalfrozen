<?php

session_start();


// Includes DB File
include 'includes/db.php';


// Include Functions File
include "includes/functions/functions.php";


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="assets/fonts/font_awesome/css/all.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Link End -->

    <title>Haikal Frozen Food</title>
</head>

<body>

    <!-- Main Container Start -->
    <div id="container">
        <!-- Header Start -->
        <header id="header">
            <div class="container">
                <div class="top-navbar">
                    <div class="top-row">
                        <div class="top-col">
                            <?php
                            if(isset($_SESSION['customerName'])){
                                $currentUser = $_SESSION['customerName'];
                            }
                            
                            // mengecek jika user eksis
                            if(!isset($currentUser)){
                                echo "<span class='user'><i class='fa fa-user'></i><a>Guest</a></span>";
                            }
                            //if exist user
                            else{
                                echo"<span class='user'><i class='fa fa-user'></i><a href='account.php'>$currentUser</a><span>";
                            }
                            ?>
                        </div>
                        <div class="top-col">
                            <?php
                             if(isset($_SESSION['customerName'])){
                                $currentUser = $_SESSION['customerName'];
                            }
                            // mengecek ada tidaknya user
                            if(!isset($currentUser)){
                                echo "<a href='login.php'>Login <i class='fa-solid fa-arrow-right-to-bracket'></i></a>";
                            }
                            //jika user ada
                            else{
                                echo"
                                 <form method='post'>
                                    <button name='logout'>Keluar<i
                                    class='fa-solid fa-arrow-right-to-bracket'></i></button>
                            </form>";
                            }
                            ?>
                            <a href="cart.php"><i class='fa fa-shopping-cart'></i><span class="badge"><?php item(); ?></span> </a>
                            <a href="wish.php"><i class='fa fa-heart'></i><span class="badge"><?php itemWish(); ?></span> </a>
                        </div>
                    </div>
                </div>
                <nav class="navbar">
                    <a href="index.php" class="brand">Haikal Frozen Food</a>
                    <button type="button" class="burger" id="burger">
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                    </button>
                    <span class="overlay" id="overlay"></span><!-- background ketika menu dibuka -->
                    <div class="menu" id="menu">
                        <ul class="menu-block">
                            <li class="menu-item"><a class="menu-link" href="index.php">Home</a></li>
                            <li class="menu-item"><a class="menu-link" href="shop.php">Toko</a></li>
                            <li class="menu-item"><a class="menu-link" href="opinion.php">Testimonial</a></li>
                            <li class="menu-item"><a class="menu-link" href="about.php">Tentang</a></li>
                            <li class="menu-item"><a class="menu-link" href="contact.php">Kontak</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Header End -->