<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= isset($title) ? "$title | Petitude" : 'Petitude' ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        #sidebar {
            width: 250px;
            background-color: #c8dbdf;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            transition: left 0.3s ease;
        }
        #sidebar.show {
            left: 0;
        }
        #content {
            margin-left: 270px;
            padding-top: 20px;
        }
        h1 {
            color: #0c5a67;            
        }
        h1 a {
            text-decoration: none;
            color: #0c5a67;
        }
        .menu-item {
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }
        .menu-item a {
            color: #0c5a67;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .menu-item a:hover {
            background-color: #81b6be;
            color: #fff;
        }
        .menu-item:hover {
            transform: translateX(5px);
            color: #fff;
        }
        .container {
            margin-left: 250px;
        }
        .hidden-column {
            display: none;
        }
        .pagination {
            position:absolute;
            top: 20px; /* 距離頂部的距離，可以根據需要進行調整 */
            left: 90%; /* 設置為頁面水平中心 */
            transform: translateX(-50%); /* 將 pagination 容器水平居中對齊 */
            z-index: 999; /* 確保 pagination 在其他內容上方顯示 */
        }
        form .mb-3 .form-text {
        color: red;
        }

    </style>

    </head>
    <body>
        
    </body>