<?php

session_start();

if (isset($_SESSION['admin'])){
    include __DIR__. '/../parts/list-admin.php';
} else {
    include __DIR__. '/../parts/list-no-admin.php';
}