<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST,
  'newId' => 0,
];

// 檢查必要的 POST 參數是否存在
if (isset($_POST['fk_class_id'], $_POST['article_content'], $_POST['article_name'], $_POST['article_img'])) {
  $sql = "INSERT INTO `article`(`article_id`, `article_date`, `article_name`, `article_content`, `article_img`, `fk_class_id`, `fk_b2c_id`) 
  VALUES (
    ?, 
    NOW(), 
    ?, 
    ?, 
    ?, 
    ?,
    ?)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $_POST['article_id'],
    $_POST['article_date'],
    $_POST['article_name'],
    $_POST['article_content'],
    $_POST['article_img'],
    $_POST['fk_class_id'],
    $_POST['fk_b2c_id']
  ]);

  $output['success'] = !!$stmt->rowCount(); # 新增了幾筆
  $output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的primary key
} else {
  $output['error'] = '必要的 POST 參數不存在';
}

echo json_encode($output);
