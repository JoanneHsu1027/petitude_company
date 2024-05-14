<?php 
    session_start();

    if(isset($_SESSION['admin'])) {
        include __DIR__. '/product_imgs-admin.php';
    } else {
        include __DIR__. '/product_imgs-no-admin.php';
    }