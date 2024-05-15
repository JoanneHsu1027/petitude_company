<?php
require __DIR__ . './../../b2bweb/admin-required.php';
require __DIR__ . './../../config/pdo-connect.php';

// 設定響應標頭為 JSON
header('Content-Type: application/json');

// 初始化回傳數據
$output = [
    'success' => false,
];

// 檢查必要的 POST 資料是否存在
if (!isset($_POST['booking_id'])) {
    echo json_encode($output);
    exit;
}

// 準備 SQL 語句
$sql = "UPDATE booking SET booking_date = :booking_date, booking_note = :booking_note WHERE booking_id = :booking_id";

// 準備 SQL 數據
$data = [
    'booking_date' => $_POST['booking_date'],
    'booking_note' => $_POST['booking_note'],
    'booking_id' => $_POST['booking_id'],
];

// 準備 PDO 語句
$stmt = $pdo->prepare($sql);

// 執行 PDO 語句
$stmt->execute($data);

// 更新成功時將成功標誌設置為 true
$output['success'] = $stmt->rowCount() > 0;

// 返回 JSON 數據
echo json_encode($output);
