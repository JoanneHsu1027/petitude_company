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
// if (!isset($_POST['insurance_product_id'])) {
//   echo json_encode($output);
//   exit; # 結束 php 程式
// }



$sql =
  "UPDATE `insurance_product` SET 
  `insurance_name`=?,
  `insurance_fee`=?,
  `outpatient_clinic_time`=?,
  `outpatient_clinic_fee`=?,
  `Hospitalized_time`=? 
  `Hospitalized_fee`=? 
  `surgery_time`=? 
  `surgery_fee`=? 
  `max_compensation_of_medical_expense`=? 
  `personal_injury_liability`=? 
  `bodily_injury`=? 
  `property_damage`=? 
  `max_compensation_of_pet_tort`=? 
  `pet_search_advertising_expenses`=? 
  `pet_boarding_fee`=? 
  `pet_funeral_expenses`=? 
  `pet_reacquisition_cost`=? 
  `travel_cancellation_fee`=? 
  WHERE insurance_product_id=?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['insurance_name'],
  $_POST['insurance_fee'],
  $_POST['outpatient_clinic_time'],
  $_POST['outpatient_clinic_fee'],
  $_POST['Hospitalized_time'],
  $_POST['Hospitalized_fee'],
  $_POST['surgery_time'],
  $_POST['surgery_fee'],
  $_POST['max_compensation_of_medical_expense'],
  $_POST['personal_injury_liability'],
  $_POST['bodily_injury'],
  $_POST['property_damage'],
  $_POST['max_compensation_of_pet_tort'],
  $_POST['pet_search_advertising_expenses'],
  $_POST['pet_boarding_fee'],
  $_POST['pet_funeral_expenses'],
  $_POST['pet_reacquisition_cost'],
  $_POST['travel_cancellation_fee'],

  $_POST['insurance_product_id']
]);

$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);
