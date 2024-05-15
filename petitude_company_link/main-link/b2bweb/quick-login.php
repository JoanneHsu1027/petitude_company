<?php

session_start();

$_SESSION['admin'] = [
    'id' => 7,
    'email' => 'shin@gg.com',
    'nickname' => '小新新',
  ];

header('Location: list.php');