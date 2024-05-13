<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($product_id < 1) {
  header('Location: product.php');
  exit;
}

$sql = "DELETE FROM product WHERE product_id=$product_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'product.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
