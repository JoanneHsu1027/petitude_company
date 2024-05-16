<?php 
  session_start();

if (isset($_SESSION['admin'])) {
  $fk_b2b_job_id = $_SESSION['admin']['fk_b2b_job_id'];
  if ($fk_b2b_job_id == 1) { 
    header("Location: b2c_list-admin.php");
    exit();
  } else {
    header("Location: b2c_list-no-admin.php");
    exit();
  }
} else {
  // 處理未登入的情況
  echo "You are not logged in.";
}
?>