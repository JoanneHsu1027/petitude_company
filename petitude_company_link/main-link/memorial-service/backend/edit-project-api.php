<?php
require __DIR__ . './../../b2bweb/admin-required.php';
require __DIR__ . './../../config/pdo-connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
];

// 檢查是否存在 POST 請求數據
if (!isset($_POST['project_id'], $_POST['project_level'], $_POST['project_name'], $_POST['project_content'], $_POST['project_fee'])) {
    echo json_encode($output);
    exit;
}

$sql = "UPDATE project SET project_level = :project_level, project_name = :project_name, project_content = :project_content, project_fee = :project_fee WHERE project_id = :project_id";

$data = [
    'project_level' => $_POST['project_level'],
    'project_name' => $_POST['project_name'],
    'project_content' => $_POST['project_content'],
    'project_fee' => $_POST['project_fee'],
    'project_id' => $_POST['project_id'],
];

$stmt = $pdo->prepare($sql);

if ($stmt->execute($data)) {
    $output['success'] = true;
}

echo json_encode($output);
