<?php 
  session_start();

  if(isset($_SESSION['admin'])) {
    include __DIR__. '/b2b_list-admin.php';
  } else {
    include __DIR__. '/b2b_list-no-admin.php';
  }