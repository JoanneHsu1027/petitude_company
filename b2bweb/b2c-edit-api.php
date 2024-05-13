<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['b2c_id'])) {
  echo json_encode($output);
  exit; # 結束 php 程式
}

# preg_match(): regexp 比對用 

# mb_strlen(): 算字串的長度

# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL): 檢查 email 格式




$birthday = strtotime($_POST['b2c_birth']);
if ($birthday === false) {
  $birthday = null;
} else {
  $birthday = date('Y-m-d', $birthday);
}



$sql = "UPDATE `b2c_members` SET 
    `b2c_name`=?,
    `b2c_email`=?,
    `b2c_mobile`=?,
    `b2c_birth`=?,
    `fk_county_id`=?,
    `fk_city_id`=?,
    `b2c_address`=?
WHERE b2c_id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['b2c_name'],
  $_POST['b2c_email'],
  $_POST['b2c_mobile'],
  $birthday,
  $_POST['fk_county_id'],
  $_POST['fk_city_id'],
  $_POST['b2c_address'],
  $_POST['b2c_id'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);

