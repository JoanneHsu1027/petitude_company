<?php
// require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,
];

// TODO: 欄位資料檢查
// if (!isset($_POST['insurance_product_id'])) {
//   echo json_encode($output);
//   exit; # 結束 php 程式
// }



// 驗證生日是否沒填. 沒填的話 帶入null ; 有的話轉為Y-m-d格式
// $birthday = strtotime($_POST['birthday']);
// if ($birthday === false) {
//   $birthday = null;
// } else {
//   $birthday = date('Y-m-d', $birthday);
// }


$sql =
  "UPDATE `insurance_order` SET 
  `fk_b2c_id`=?,
  `fk_pet_id`=?,
  `fk_insurance_product_id`=?,
  `insurance_fee`=?,
  `payment_status`=? 
  `insurance_start_date`=? 
  `county_name`=? 
  `city_name`=? 
  `policyholder_address`=? 
  `policyholder_mobile`=? 
  `policyholder_email`=? 
  `policyholder_IDcard`=? 
    WHERE insurance_order_id=?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['fk_b2c_id'],
  $_POST['fk_pet_id'],
  $_POST['fk_insurance_product_id'],
  $_POST['insurance_fee'],
  $_POST['payment_status'],
  $_POST['insurance_start_date'],
  $_POST['county_name'],
  $_POST['city_name'],
  $_POST['policyholder_address'],
  $_POST['policyholder_mobile'],
  $_POST['policyholder_email'],
  $_POST['policyholder_IDcard'],

  $_POST['insurance_order_id']
]);

$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);
