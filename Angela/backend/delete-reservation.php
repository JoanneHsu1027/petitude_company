<?php
require __DIR__ . '/../parts/admin-required.php';
require __DIR__ . '/../config/pdo_connect.php';

    $reservation_id = isset($_GET['reservation_id']) ? intval($_GET['reservation_id']) : 0;

    if(!empty($reservation_id)) {
    $sql = "DELETE FROM `reservation` WHERE reservation_id={$reservation_id}";
    $pdo->query($sql);
    }
    $backTo = 'reservation.php';
    if(! empty($_SERVER['HTTP_REFERER'])){
    $backTo = $_SERVER['HTTP_REFERER'];
    }
    header('Location: /reservation.php');



