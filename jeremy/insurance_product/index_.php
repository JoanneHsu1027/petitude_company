<?php

if (!isset($_SESSION)) {
  session_start();
}

?>
<?php include __DIR__ . '/../page/html-header.php'; ?>
<?php include __DIR__ . '/../page/html-navbar.php';  ?>



<div class="">
  <div class="container">
    <div class="row">
      <h1 class="c-dark pagenation">後臺管理系統</h1>
    </div>
  </div>

  <?php include __DIR__ . '/../page/html-scripts.php'; ?>
  <?php include __DIR__ . '/../page/html-footer.php'; ?>