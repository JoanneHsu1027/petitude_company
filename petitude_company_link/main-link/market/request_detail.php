<?php 
    session_start();

    if(isset($_SESSION['admin'])) {
        include __DIR__. '/request_detail-admin.php';
    } else {
        include __DIR__. '/request_detail-no-admin.php';
    }