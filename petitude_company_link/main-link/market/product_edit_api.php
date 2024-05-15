<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['product_name'])) {
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

$currentDateTime = date('Y-m-d H:i:s');

$sql = "UPDATE `product` SET
`product_name` = ?,
`product_description` = ?,
`product_price` = ?,
`product_quantity` = ?,
`product_category` = ?,
`product_date` = ?,
`product_last_modified` = NOW()
WHERE product_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['product_name'],
  $_POST['product_description'],
  $_POST['product_price'],
  $_POST['product_quantity'],
  $_POST['product_category'],
  $_POST['product_date'],
  $_POST['product_id'],
]);


$output['success'] = !!$stmt->rowCount(); # 修改了幾筆

// if (!!$stmt->rowCount()) {
//   $output['success'] = true;
//   // 追蹤異動 update_at 繞過編輯成功彈跳視窗指標
//   $sql = "UPDATE `product` SET

// WHERE product_id = ?";
// `product_last_modified` = ?
//   $stmt = $pdo->prepare($sql);
//   $stmt->execute([
//     $_POST['product_id'],
//   ]);
// }


echo json_encode($output);
