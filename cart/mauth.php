<?php
    session_start();
        if ($_SESSION['login']!=1){
                echo "<script>alert('請先登入')</script>";
                echo "<script>window.location.href='./cart_login.html';</script>";
                die('');
        }
?>