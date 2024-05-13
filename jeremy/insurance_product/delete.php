<?php
// require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$sid = isset($_GET['insurance_product_id']) ? intval($_GET['insurance_product_id']) : 0;
if ($sid < 1) {
  header('Location: product-list-admin.php');
  // 測試先用, 權限設定後改list.php
  exit;
}

$sql = "DELETE FROM insurance_product WHERE insurance_product_id=$sid";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'product-list-admin.php';
// 測試先用, 權限設定後改list.php
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
