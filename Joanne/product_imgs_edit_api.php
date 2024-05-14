<?php
// require __DIR__ . '/admin-required.php';
require __DIR__ . './config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['picture_name'])) {
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

$sql = "UPDATE `product_imgs` SET
`fk_product_id` = ?,
`picture_name` = ?,
`picture_url` = ?
WHERE picture_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['fk_product_id'],
  $_POST['picture_name'],
  $_POST['picture_url'],
  $_POST['picture_id'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆


echo json_encode($output);
