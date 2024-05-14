<?php
require __DIR__ . '/../parts/admin-required.php';
require __DIR__ . '/../config/pdo_connect.php';

    $project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;

    if(empty($project_id)) {
        header('Location: ../project-admin.php');
        exit;
    }
    $sql = "DELETE FROM `project` WHERE project_id={$project_id}";
    $pdo->query($sql);
    if(isset($_SERVER['HTTP_REFERER'])){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        // ../是這一層資料夾的上一層
        header('Location: ../project-admin.php');
    }
    



