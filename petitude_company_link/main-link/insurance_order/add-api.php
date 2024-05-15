<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,
];

// TODO: 欄位資料檢查
// if (!isset($_POST['insurance_name'])) {
//   echo json_encode($output);
//   exit; # 結束 php 程式
// }


$sql =
  "INSERT INTO `insurance_order`(
  `fk_b2c_id`, `fk_pet_id`, `fk_insurance_product_id`, `payment_status`, `insurance_start_date`, `fk_county_id`, `fk_city_id`, `policyholder_address`, `policyholder_mobile`, `policyholder_email`, `policyholder_IDcard` ) 
  VALUES (
    ?,
    ?,
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
  $_POST['fk_b2c_id'],
  $_POST['fk_pet_id'],
  $_POST['fk_insurance_product_id'],
  $_POST['payment_status'],
  $_POST['insurance_start_date'],
  $_POST['fk_county_id'],
  $_POST['fk_city_id'],
  $_POST['policyholder_address'],
  $_POST['policyholder_mobile'],
  $_POST['policyholder_email'],
  $_POST['policyholder_IDcard'],
]);

$output['success'] = !!$stmt->rowCount(); # 新增了幾筆, !! (not not表正) 轉為布林值
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key


echo json_encode($output);
