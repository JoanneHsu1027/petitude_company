<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['request_date'])) {
  echo json_encode($output);
  exit; # 結束 php 程式
}

# preg_match(): regexp 比對用 

# mb_strlen(): 算字串的長度

# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL): 檢查 email 格式




// $birthday = strtotime($_POST['birthday']);
// if ($birthday === false) {
//   $birthday = null;
// } else {
//   $birthday = date('Y-m-d', $birthday);
// }



$sql = "UPDATE `request` SET 
    `request_date`=?,
    `request_status`=?,
    `payment_status`=?,
    `fk_b2c_id`=?,
    `request_price`=?,
    `fk_county_id`=?,
    `fk_city_id`=?,
    `recipient_address`=?,
    `recipient_mobile`=?,
    `recipient_email`=?
WHERE request_id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['request_date'],
  $_POST['request_status'],
  $_POST['payment_status'],
  $_POST['fk_b2c_id'],
  $_POST['request_price'],
  $_POST['fk_county_id'],
  $_POST['fk_city_id'],
  $_POST['recipient_address'],
  $_POST['recipient_mobile'],
  $_POST['recipient_email'],
  $_POST['request_id'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);
