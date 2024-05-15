<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'newId' => 0,
];

// 檢查必要的 POST 參數是否存在
if (
  isset($_POST['class_id'], $_POST['article_content'], $_POST['article_name'])
) {
  // 處理圖片上傳
  $uploadedImages = null; // 將預設值設置為 NULL
  if (!empty($_FILES['article_img']['name'][0])) {
    $uploadedImages = []; // 如果有上傳圖片，初始化一個空數組
    $uploadDir = __DIR__ . '/../img/';
    foreach ($_FILES['article_img']['tmp_name'] as $key => $tmp_name) {
      $uploadedFile = $uploadDir . basename($_FILES['article_img']['name'][$key]);
      if (move_uploaded_file($tmp_name, $uploadedFile)) {
        $uploadedImages[] = $_FILES['article_img']['name'][$key]; // 將圖片文件名添加到上傳圖片數組中
      }
    }
  }

  // 如果沒有上傳圖片，將 $uploadedImages 設置為 NULL
  if (empty($uploadedImages)) {
    $uploadedImages = null;
  }

  // 執行數據庫操作
  $sql = "INSERT INTO `article`(`article_date`, `article_name`, `article_content`, `article_img`, `fk_class_id`) 
          VALUES (
            NOW(), 
            ?, 
            ?, 
            ?, 
            ?
          )";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $_POST['article_name'],
    $_POST['article_content'],
    json_encode($uploadedImages), // 將圖片數組 JSON 字符串作為文章圖片
    $_POST['class_id'],
  ]);

  $output['success'] = !!$stmt->rowCount(); # 新增了幾筆
  $output['newId'] = $pdo->lastInsertId(); # 取得最近的新增資料的 primary key
} else {
  $output['error'] = '必要的 POST 參數不存在';
}

echo json_encode($output);
?>