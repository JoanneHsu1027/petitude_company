<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';

$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
if ($request_id < 1) {
  header('Location: request.php');
  exit;
}

$sql = "DELETE FROM request WHERE request_id=$request_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'request.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");
