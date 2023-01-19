<?php

    include "db.php";

    //Delete User
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];

    // untuk menghapus gambar profile
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    
    $user_image = $row['user_image'];

    if(!empty($user_image)){
        unlink('../../assets/images/customers/'.$user_image);

        $delete_user = "DELETE FROM users WHERE id='$user_id'";
        $result_delete = mysqli_query($conn, $delete_user);

        if($result_delete){
            echo "<script>alert('User Dihapus!')</script>";
            echo "<script>window.open('../index.php?users', '_self')</script>";
        }
    } else {
        $delete_user = "DELETE FROM users WHERE id='$user_id'";
        $result_delete = mysqli_query($conn, $delete_user);

        if($result_delete){
            echo "<script>alert('User Dihapus!')</script>";
            echo "<script>window.open('../index.php?users', '_self')</script>";
        }
    }
    }
?>