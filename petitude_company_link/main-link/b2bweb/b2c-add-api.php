<?php
require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, // 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,
];

// 處理資料庫連線錯誤
if (!$pdo) {
  $output['error'] = '資料庫連線錯誤';
  echo json_encode($output);
  exit; // 結束 php 程式
}

// 檢查是否有 POST 資料
if (empty($_POST)) {
  $output['error'] = '沒有收到 POST 資料';
  echo json_encode($output);
  exit; // 結束 php 程式
}

$birthday = strtotime($_POST['b2c_birth']);
if($birthday === false) {
  $birthday = null;
} else {
  $birthday = date('Y-m-d', $birthday);
}

$sql = "INSERT INTO `b2c_members`(
  `b2c_name`, `b2c_email`, `b2c_mobile`, `b2c_birth`, `fk_county_id`, `fk_city_id`,`b2c_address`) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ? )";

$stmt = $pdo->prepare($sql);

// 執行資料庫操作
try {
  $stmt->execute([
    $_POST['b2c_name'],
    $_POST['b2c_email'],
    $_POST['b2c_mobile'],
    $birthday,
    $_POST['fk_county_id'],
    $_POST['fk_city_id'],
    $_POST['b2c_address']
  ]);
  
  // 檢查是否成功新增資料
  if ($stmt->rowCount() > 0) {
    $output['success'] = true;
    $output['newId'] = $pdo->lastInsertId();
  } else {
    $output['error'] = '新增資料失敗';
  }
} catch (PDOException $e) {
  $output['error'] = '資料庫操作失敗: ' . $e->getMessage();
}

echo json_encode($output);


$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key


