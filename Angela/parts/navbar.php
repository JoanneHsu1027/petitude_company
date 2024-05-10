    <?php
    if (!isset($pageName)) {
    $pageName = '';
    }
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
            margin-left: 300px;
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
            margin-left: 300px;
        }
    </style>

    <div class="container">
    <div id="sidebar" class="show">
        <h1><a href="index_.php">Petitude</a></h1>
        
        <div class="menu-item">
            <a href="./parts/project.php" class="<?= $pageName == 'project' ? 'active' : '' ?>">生前契約方案</a>
        </div>
        <div class="menu-item">
            <a href="./parts/reservation.php" class="<?= $pageName == 'reservation' ? 'active' : '' ?>">預約參觀</a>
        </div>
        <div class="menu-item">
            <a href="./parts/booking.php" class="<?= $pageName == 'booking' ? 'active' : '' ?>">生前契約 - 線上下單</a>
        </div>

        <div class="menu-item">
            <?php if (isset($_SESSION['admin'])) : ?>
                <a href="#" class=""><?= $_SESSION['admin']['nickname'] ?></a>
            <?php else : ?>
                <a href="./backend/login.php" class="<?= $pageName == 'login' ? 'active' : '' ?>">登入</a>
            <?php endif; ?>
        </div>
        <div class="menu-item">
            <?php if (isset($_SESSION['admin'])) : ?>
                <a href="./backend/logout.php">登出</a>
            <?php else : ?>
                <a href="./backend/register.php" class="<?= $pageName == 'register' ? 'active' : '' ?>">註冊</a>
            <?php endif; ?>
        </div>
    </div>
</div>
