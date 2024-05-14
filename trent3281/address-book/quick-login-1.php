<?php

session_start();

$_SESSION['admin'] = [
  'b2b_id' => 1,
  'b2b_email' => 'user1@example.com',
  'b2b_name' => '王大明',
];

header('Location: index_.php');