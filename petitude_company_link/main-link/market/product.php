<?php 
    session_start();

    if(isset($_SESSION['admin'])) {
        include __DIR__. '/product-admin.php';
    } else {
        include __DIR__. '/product-no-admin.php';
    }