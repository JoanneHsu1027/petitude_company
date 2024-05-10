<?php

session_start();

if (isset($_SESSION['admin'])){
    include __DIR__. '/reservation-admin.php';
} else {
    include __DIR__. '/reservation-no-admin.php';
}