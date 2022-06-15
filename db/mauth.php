<?php
        session_start();
        if ($_SESSION['login'] != 1) {
                $_SESSION['approved'] = false;
        } else{
                $_SESSION['approved'] = true;
        }
?>