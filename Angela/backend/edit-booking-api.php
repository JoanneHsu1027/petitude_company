<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '../../config/pdo_connect.php';

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
    `booking_date`=?,
    `booking_note`=?
WHERE booking_id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $booking_date_formatted,
    $_POST['booking_note'],
]);

$output['success'] = !!$stmt->rowCount(); 
# 修改了幾筆

echo json_encode($output, JSON_UNESCAPED_UNICODE);

