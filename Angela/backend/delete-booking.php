<?php
require __DIR__ . '/../parts/admin-required.php';
require __DIR__ . '/../config/pdo_connect.php';

    $booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

    if(empty($booking_id)) {
        header('Location: ../booking-admin.php');
        exit;
    }
    $sql = "DELETE FROM `booking` WHERE booking_id={$booking_id}";
    $pdo->query($sql);
    if(isset($_SERVER['HTTP_REFERER'])){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        // ../是這一層資料夾的上一層
        header('Location: ../booking-admin.php');
    }
    



