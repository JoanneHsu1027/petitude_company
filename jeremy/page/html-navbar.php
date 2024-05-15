<?php
if (!isset($pageName)) $pageName = '';

?>




<div id="sidebar" class="show">
  <h1>Petitude</h1>
  <?php if (isset($_SESSION['admin'])) : ?>
    <div class="menu-item">
      <?= $_SESSION['admin']['b2b_name'] ?>
    </div>

    <div class="menu-item">
      <a href="index_.php">首頁</a>
    </div>
    <div class="menu-item">
      <a href="../insurance_product/product-list.php">保險產品表</a>

    </div>
    <div class="menu-item">
      <a href="../insurance_order/order-list.php">保險訂單表</a>
    </div>
    <div class="menu-item">
      <a href="logout.php">登出</a>
    </div>

  <?php else : ?>
    <div class="menu-item">
      <a href="login.php">登入</a>
    </div>
    <div class="menu-item">
      <a href="./quick-login-1.php">快速登入</a>
    </div>
  <?php endif ?>


</div>