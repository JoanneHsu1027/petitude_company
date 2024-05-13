<?php
require __DIR__ . '/../parts/admin-required.php';
require __DIR__ . '/../config/pdo_connect.php';

    $project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;

    if(!empty($project_id)) {
    $sql = "DELETE FROM `project` WHERE project_id={$project_id}";
    $pdo->query($sql);
    }
    $backTo = 'project.php';
    if(! empty($_SERVER['HTTP_REFERER'])){
    $backTo = $_SERVER['HTTP_REFERER'];
    }
    header('Location: /project.php');



