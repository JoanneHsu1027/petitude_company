<?php
require __DIR__ . '/../parts/admin-required.php';
require __DIR__ . '/../config/pdo_connect.php';

    $reservation_id = isset($_GET['reservation_id']) ? intval($_GET['reservation_id']) : 0;

    if(empty($reservation_id)) {
        header('Location: ../reservation-admin.php');
        exit;
    }
    $sql = "DELETE FROM `reservation` WHERE reservation_id={$reservation_id}";
    $pdo->query($sql);
    if(isset($_SERVER['HTTP_REFERER'])){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        // ../是這一層資料夾的上一層
        header('Location: ../reservation-admin.php');
    }
    



