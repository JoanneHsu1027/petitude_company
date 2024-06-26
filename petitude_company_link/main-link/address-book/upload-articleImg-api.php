<?php
$output = [
  'success' => false,
  'code' => 0,
];

# 做檔案的篩選, 決定副檔名
$exts = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
  'image/gif' => '.gif',
  'image/svg' => '.svg',
  'image/webp' => '.webp',
];

$f = sha1(uniqid() . rand()); # 隨機的主檔名 

# 先確定有上傳的欄位
if (!empty($_FILES) and !empty($_FILES['article_img[]'])) {
  $output['code'] = 100;
  # 再確定上傳過程沒有出錯
  if ($_FILES['article_img[]']['error'] === 0) {
    $output['code'] = 200;
    # 判斷類型是不是符合我們的條件<?php
    $output = [
      'success' => false,
      'code' => 0,
    ];
    # 做檔案的篩選, 決定副檔名
    $exts = [
      'image/jpeg' => '.jpg',
      'image/png' => '.png',
      'image/gif' => '.gif',
      'image/svg' => '.svg',
      'image/webp' => '.webp',
    ];

    $f = sha1(uniqid() . rand()); # 隨機的主檔名 

    # 先確定有上傳的欄位
    if (!empty($_FILES) and !empty($_FILES['article_img[]'])) {
      $output['code'] = 100;
      # 再確定上傳過程沒有出錯
      if ($_FILES['article_img[]']['error'] === 0) {
        $output['code'] = 200;
        # 判斷類型是不是符合我們的條件
        if (!empty($exts[$_FILES['article_img[]']['type']])) {
          $output['code'] = 300;
          # 依照 mime-type 決定副檔名
          $ext = $exts[$_FILES['article_img[]']['type']]; # 副檔名

          $filename = __DIR__ . '/../petitude_company_link/main-link/address-book/img/' . $f . $ext;
          $filename = __DIR__ . '/../main-link/img/' . $f . $ext;

          $result = move_uploaded_file($_FILES['article_img[]']['tmp_name'], $filename);
          $output['success'] = $result;
          $output['filename'] = $f . $ext;
        }
      }
    }
    header('Content-Type: application/json');
    echo json_encode($output);
    if (!empty($exts[$_FILES['article_img[]']['type']])) {
      $output['code'] = 300;
      # 依照 mime-type 決定副檔名
      $ext = $exts[$_FILES['article_img[]']['type']]; # 副檔名

      $filename = __DIR__ . '../petitude_company_link/main-link/img' . $ext;

      $result = move_uploaded_file($_FILES['article_img[]']['tmp_name'], $filename);
      $output['success'] = $result;
      $output['filename'] = $ext;
    }
  }
}



header('Content-Type: application/json');

echo json_encode($output);
