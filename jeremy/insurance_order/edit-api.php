<?php
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, // 有沒有修改成功
];

if (empty($_POST['insurance_order_id'])) {
  $output['error'] = 'Missing insurance_order_id';
  echo json_encode($output);
  exit;
}

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
  `payment_status`=?, 
  `insurance_start_date`=?, 
  `fk_county_id`=?, 
  `fk_city_id`=?, 
  `policyholder_address`=?, 
  `policyholder_mobile`=?, 
  `policyholder_email`=?, 
  `policyholder_IDcard`=?
  WHERE insurance_order_id=?";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
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
  $_POST['insurance_order_id']
]);

if ($result) {
  $output['success'] = true;
} else {
  $output['error'] = 'Failed to update';
}

echo json_encode($output);
