<?php
if (!isset($pageName))
  $pageName = '';
?>
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
    </style>


    <div id="sidebar" class="show">
        <h1>Petitude</h1>
        <div class="menu-item">
            <a href="#">首頁</a>
        </div>
        <div class="menu-item">
            <a href="#">使用者管理</a>
        </div>
        <!-- <div class="menu-item">
            <a href="#">設置</a>
        </div> -->

        <?php if (isset($_SESSION['admin'])): ?>
        <div class="menu-item">
            <a class="nav-link"><?= $_SESSION['admin']['b2b_name'] ?></a>
        </div>
        <div class="menu-item">
            <a class="nav-link" href="b2b_list.php">員工列表</a>
        </div>
        <div class="menu-item">
            <a class="nav-link" href="b2c_list.php">會員列表</a>
        </div>
        <div class="menu-item">
            <a class="nav-link" href="logout.php">登出</a>
        </div>
        <?php else: ?>
        <div class="menu-item">
            <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="login.php">登入</a>
        </div>
        <div class="menu-item">
            <a class="nav-link <?= $pageName == 'register' ? 'active' : '' ?>" href="register.php">註冊</a>
        </div>
        <?php endif ?>
    </div>