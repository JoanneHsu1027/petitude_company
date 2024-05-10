<?php

require __DIR__ . '/connect_config.php';
//這一行代碼使用 require 將名為 connect-config.php 的檔案引入到當前的 PHP 檔案中。
//__DIR__ 是 PHP 預定義的常數，表示當前檔案所在的目錄。
//connect-config.php 應該包含用於連接到資料庫所需的相關設定，例如資料庫主機、使用者名稱、密碼等。

    $dsn = "mysql:host={$db_host};dbname={$db_name};port={$db_port};charset=utf8mb4";

    $pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $db_user, $db_pass);

    if (!isset($_SESSION)) {
    session_start();
    }