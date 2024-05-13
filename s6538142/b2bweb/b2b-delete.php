<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$b2b_id = isset($_GET['b2b_id']) ? intval($_GET['b2b_id']) : 0;
var_dump($b2b_id);
if ($b2b_id < 1) {
  header('Location: b2b_list.php');
  exit;
}

$sql = "DELETE FROM `b2b_members` WHERE `b2b_members`.`b2b_id`=$b2b_id";
$pdo->query($sql);

# $_SERVER['HTTP_REFERER']: 從哪個頁面連過來的
$comeFrom = 'b2b_list.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  $comeFrom = $_SERVER['HTTP_REFERER'];
}

header("Location: $comeFrom");