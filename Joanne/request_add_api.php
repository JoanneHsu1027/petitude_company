<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,


];

// TODO: 欄位資料檢查
if (!isset($_POST['name'])) {
  echo json_encode($output);
  exit; # 結束 php 程式
}

# preg_match(): regexp 比對用 

# mb_strlen(): 算字串的長度

# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL): 檢查 email 格式



/*
// 錯誤的作法, 會有 SQL injection 問題
$sql = sprintf("INSERT INTO `address_book`(
  `name`, `email`, `mobile`, `birthday`, `address`, `created_at`) VALUES (
    '%s',
    '%s',
    '%s',
    '%s',
    '%s', NOW() )",
  $_POST['name'],
  $_POST['email'],
  $_POST['mobile'],
  $_POST['birthday'],
  $_POST['address']
);

$stmt = $pdo->query($sql);
*/



$sql = "INSERT INTO `request`(
`request_date`, `request_statu`, `payment_status`, `fk_b2c_id`, `request_price`, `fk_county_id`, `fk_city_id`, `recipient_address`, `recipient_mobile`, `recipient_emai`) VALUES (
    NOW(),
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['request_date'],
  $_POST['request_statu'],
  $_POST['payment_status'],
  $_POST['fk_b2c_id'],
  $_POST['request_price'],
  $_POST['fk_county_id'],
  $_POST['fk_city_id'],
  $_POST['recipient_address'],
  $_POST['recipient_mobile'],
  $_POST['recipient_emai'],
]);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);
