<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | 商城管理</title>
    <!-- bootstrap cdn css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- bootstrap cdn icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- font-awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- css外掛 -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #fff;
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
            /* position: relative; */
        }

        #sidebar.show {
            left: 0;
        }

        #content {
            margin-left: 250px;
            padding: 20px;
        }

        h2 {
            color: #0c5a67;
        }

        .menu-item {
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            position: relative;
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

        .dropdown {
            position: relative;
            top: 100%;
            left: 0;
            display: none;
        }

        .menu-item:hover .dropdown {
            display: block;
        }

        .menu-item:nth-child(2) .dropdown {
            left: 0;
        }

        .menu-item:nth-child(3) .dropdown {
            right: 0;
        }

        .container {
            margin-left: 300px;
            padding: 20px;
            position: relative;
        }
    </style>


</head>

<body>