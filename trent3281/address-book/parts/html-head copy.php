<!DOCTYPE html>
<html lang="zh">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($title) ? "$title | Petitude" : 'Petitude' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

        h1 {
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
        }
    </style>

</head>

<body>