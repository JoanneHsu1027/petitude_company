<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';

$request_detail_id = isset($_GET['request_detail_id']) ? intval($_GET['request_detail_id']) : 0;
if ($request_detail_id < 1) {
  header('Location: request_detail.php');
  exit;
}

$sql = "DELETE FROM request_detail WHERE request_detail_id=$request_detail_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'request_detail.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
