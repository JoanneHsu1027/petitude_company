<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;
if ($class_id < 1) {
  header('Location: class.php');
  exit;
}

$sql = "DELETE FROM class WHERE class_id=$class_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'class.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");