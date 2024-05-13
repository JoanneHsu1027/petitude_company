<?php 
  session_start();

  if(isset($_SESSION['admin'])) {
    include __DIR__. '/b2c_list-admin.php';
  } else {
    include __DIR__. '/b2c_list-no-admin.php';
  }