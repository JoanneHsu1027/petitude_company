<?php
if (!isset($pageName))
    $pageName = '';
?>

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
