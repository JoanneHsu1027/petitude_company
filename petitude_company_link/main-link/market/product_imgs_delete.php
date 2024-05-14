<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$picture_id = isset($_GET['picture_id']) ? intval($_GET['picture_id']) : 0;
if ($picture_id < 1) {
  header('Location: product_imgs.php');
  exit;
}

$sql = "DELETE FROM product_imgs WHERE picture_id=$picture_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'product_imgs.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
