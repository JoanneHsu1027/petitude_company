<?php
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, // 有沒有修改成功
  'bodyData' => $_POST,
];

// 檢查是否有必要的欄位
$requiredFields = ['insurance_order_id', 'fk_b2c_id', 'fk_pet_id', 'fk_insurance_product_id', 'payment_status', 'insurance_start_date', 'fk_county_id', 'fk_city_id', 'policyholder_address', 'policyholder_mobile', 'policyholder_email', 'policyholder_IDcard'];

foreach ($requiredFields as $field) {
  if (!isset($_POST[$field])) {
    $output['error'] = "Missing $field";
    echo json_encode($output);
    exit;
  }
}

// TODO: 欄位資料檢查
// 此處可添加必要的欄位資料檢查，如檢查日期格式、手機號碼格式等

$sql = "UPDATE `insurance_order` SET 
  `fk_b2c_id` = ?,
  `fk_pet_id` = ?,
  `fk_insurance_product_id` = ?,
  `payment_status` = ?,
  `insurance_start_date` = ?,
  `fk_county_id` = ?,
  `fk_city_id` = ?,
  `policyholder_address` = ?,
  `policyholder_mobile` = ?,
  `policyholder_email` = ?,
  `policyholder_IDcard` = ?
  WHERE insurance_order_id = ?";

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

$output['success'] = $result ? true : false;

echo json_encode($output);
