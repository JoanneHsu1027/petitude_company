<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$b2c_id = isset($_GET['b2c_id']) ? intval($_GET['b2c_id']) : 0;
var_dump($b2c_id);
if ($b2c_id < 1) {
  header('Location: b2c_list.php');
  exit;
}

$sql = "DELETE FROM `b2c_members` WHERE `b2c_members`.`b2c_id`=$b2c_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'b2c_list.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");