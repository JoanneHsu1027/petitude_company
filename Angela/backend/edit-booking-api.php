<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false, # 有沒有新增成功
    'bodyData' => $_POST,
];

// TODO: 欄位資料檢查
if (!isset($_POST['booking_id'])) {
    echo json_encode($output);
    exit; # 結束 php 程式
}

# preg_match(): regexp 比對用 

# mb_strlen(): 算字串的長度

# filter_var('bob@example.com', FILTER_VALIDATE_EMAIL): 檢查 email 格式

$bookingDate = strtotime($_POST['booking_date']);
if ($bookingDate === false) {
    $bookingDate = null;
} else {
    $bookingDate = date('Y-m-d', $bookingDate);
}

$sql = "UPDATE `booking` SET 
    `fk_b2c_id`=?,
    `fk_pet_id`=?,
    `fk_project_id`=?,
    `fk_reservation_id`=?,
    `booking_date`=?,
    `booking_note`=?
WHERE booking_id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['fk_b2c_id'],
    $_POST['fk_pet_id'],
    $_POST['fk_project_id'],
    $_POST['fk_reservation_id'],
    $bookingDate,
    $_POST['booking_note'],
    $_POST['booking_id'],
]);

$output['success'] = !!$stmt->rowCount(); 
# 修改了幾筆

echo json_encode($output);

