<?php 
    session_start();

    if(isset($_SESSION['admin'])) {
        include __DIR__. '/request-admin.php';
    } else {
        include __DIR__. '/request-no-admin.php';
    }