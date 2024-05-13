//測試假資料 

<?php

require __DIR__. '/../config/pdo_connect.php';

// 選擇要測試的table
$sql = "SELECT * FROM project LIMIT 3";

# $stmt = $pdo->query($sql);
# $rows = $stmt->fetchAll();

$rows = $pdo->query($sql)->fetchAll();

echo json_encode($rows, JSON_UNESCAPED_UNICODE);