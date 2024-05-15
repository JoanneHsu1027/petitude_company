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

$b2bpasswd = password_hash($_POST['b2b_password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO `b2b_members`(
  `b2b_name`, `b2b_account`, `b2b_password`, `b2b_email`, `b2b_mobile`, `fk_b2b_job_id`) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ?)";

$stmt = $pdo->prepare($sql);

// 執行資料庫操作
try {
  $stmt->execute([
    $_POST['b2b_name'],
    $_POST['b2b_account'],
    $b2bpasswd,
    $_POST['b2b_email'],
    $_POST['b2b_mobile'],
    $_POST['fk_b2b_job_id']
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

// 移動以下兩行到 JSON 輸出之前
$output['success'] = !!$stmt->rowCount(); # 新增了幾筆
$output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key

echo json_encode($output);
