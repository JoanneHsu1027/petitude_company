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

    $bookingDate = DateTime::createFromFormat('Y-m-d', $_POST['booking_date']);
if (!$bookingDate) {
    // 日期格式不正确，返回错误消息或采取其他适当的错误处理措施
    $output['error'] = "Invalid date format";
    echo json_encode($output);
    exit;
}

    $booking_date_formatted = $bookingDate->format('Y-m-d');

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
    $booking_date_formatted,
    $_POST['booking_note'],
    $_POST['booking_id'],
]);

$output['success'] = !!$stmt->rowCount(); 
# 修改了幾筆

echo json_encode($output);

