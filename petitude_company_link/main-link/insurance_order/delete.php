<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$sid = isset($_GET['insurance_order_id']) ? intval($_GET['insurance_order_id']) : 0;
if ($sid < 1) {
  header('Location: order-list.php');
  exit;
}

$sql = "DELETE FROM insurance_order WHERE insurance_order_id=$sid";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'order-list.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
