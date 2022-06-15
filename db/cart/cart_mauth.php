<?php
session_start();
if ($_SESSION['identity'] != 2) {
        echo "<script>alert('權限不足!!')</script>";
        echo "<script>window.location.href='./cart_list.php';</script>";
        die('');
        
}
?>