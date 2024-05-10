<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,
];

// TODO: 欄位資料檢查
if (!isset($_POST['sid'])) {
  echo json_encode($output);
  exit; # 結束 php 程式
}



// 驗證生日是否沒填. 沒填的話 帶入null ; 有的話轉為Y-m-d格式
$birthday = strtotime($_POST['birthday']);
if ($birthday === false) {
  $birthday = null;
} else {
  $birthday = date('Y-m-d', $birthday);
}


$sql =
  "UPDATE `address_book` SET 
  `name`=?,
  `email`=?,
  `mobile`=?,
  `birthday`=?,
  `address`=? 
  WHERE sid=?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['name'],
  $_POST['email'],
  $_POST['mobile'],
  $birthday,
  $_POST['address'],
  $_POST['sid']
]);

$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);
