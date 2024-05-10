<?php

require __DIR__ . '/connect-config.php';


$dsn = "mysql: host={$db_host}; dbname={$db_name}; port={$db_port}; charset=utf8mb4";

$pdo_options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  # 錯誤訊息使⽤例外⽅式
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  # fetch 時取得關聯式陣列
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

// 驗證用, 先註掉
// if (!isset($_SESSION)) {
//   session_start();
// };
