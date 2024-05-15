<?php
// 删除数据的 API 端点
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
// 检查请求方法是否为 POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit;
}

// 检查是否设置了要删除的记录 ID
if (!isset($_POST['booking_id'])) {
    http_response_code(400); // Bad Request
    exit;
}

// 从 POST 请求中获取要删除的记录 ID
$record_id = $_POST['booking_id'];

// 连接到数据库
// 假设你已经创建了一个 PDO 连接 $pdo

// 准备 SQL 语句，删除对应的记录
$sql = "DELETE FROM booking WHERE booking_id = ?";
$stmt = $pdo->prepare($sql);

// 执行 SQL 语句
if ($stmt->execute([$booking_id])) {
    // 删除成功
    http_response_code(200); // OK
    echo json_encode(['success' => true]);
} else {
    // 删除失败
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'error' => 'Failed to delete booking']);
}
