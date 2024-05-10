<?php

session_start();

if (isset($_SESSION['admin'])){
    include __DIR__. '/booking-admin.php';
} else {
    include __DIR__. '/booking-no-admin.php';
}