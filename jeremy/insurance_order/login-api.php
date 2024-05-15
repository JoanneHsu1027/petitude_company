<?php
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有登入成功
  'bodyData' => $_POST,
  'code' => 0, # 除錯追踨用的
];

# 1. 判斷是否帳號密碼欄是空的
if (empty($_POST['b2b_email']) or empty($_POST['b2b_password'])) {
  $output['code'] = 400;  #除錯追踨用的
  echo json_encode($output);
  exit; # 結束 php 程式
}


# 2. 判斷帳號是否正確
$sql = "SELECT * FROM b2b_members WHERE b2b_email=?";
$stmt = $pdo->prepare($sql);

$stmt->execute([$_POST['b2b_email']]);

$row = $stmt->fetch();
if (empty($row)) {
  # 帳號是錯的/不存在
  $output['code'] = 420;  #除錯追踨用的
  echo json_encode($output);
  exit; # 結束 php 程式
};



# 3. 判斷密碼是否正確
if (password_verify($_POST['b2b_password'], $row['b2b_password'])) {
  $output['success'] = true;
  # 把登入完成的狀態記錄在 session
  $_SESSION['admin'] = [
    'b2b_id' => $row['b2b_id'],
    'b2b_email' => $row['b2b_email'],
    'b2b_name' => $row['b2b_name'],
  ];
} else {
  # 密碼是錯的
  $output['code'] = 440;
};


echo json_encode($output);
