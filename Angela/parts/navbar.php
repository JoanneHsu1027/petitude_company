    <?php
    if (!isset($pageName)) {
    $pageName = '';
    }
    ?>
    

    <div class="container">
    <div id="sidebar" class="show">
        <h1><a href="./backend/index_.php">Petitude</a></h1>
        
        <div class="menu-item">
            <a href="http://localhost:8080/petitude_company/Angela/project.php" class="<?= $pageName == 'project' ? 'active' : '' ?>">生前契約方案</a>
        </div>
        <div class="menu-item">
            <a href="http://localhost:8080/petitude_company/Angela/reservation.php" class="<?= $pageName == 'reservation' ? 'active' : '' ?>">預約參觀</a>
        </div>
        <div class="menu-item">
            <a href="http://localhost:8080/petitude_company/Angela/booking.php" class="<?= $pageName == 'booking' ? 'active' : '' ?>">生前契約 - 線上下單</a>
        </div>

        <div class="menu-item">
            <?php if (isset($_SESSION['admin'])) : ?>
                <a href="#" class=""><?= $_SESSION['admin']['nickname'] ?></a>
            <?php else : ?>
                <a href="http://localhost:8080/petitude_company/Angela/backend/login.php" class="<?= $pageName == 'login' ? 'active' : '' ?>">登入</a>
            <?php endif; ?>
        </div>
        <div class="menu-item">
            <?php if (isset($_SESSION['admin'])) : ?>
                <a href="http://localhost:8080/petitude_company/Angela/backend/index_.php">登出</a>
            <?php else : ?>
                <a href="http://localhost:8080/petitude_company/Angela/backend/register.php" class="<?= $pageName == 'register' ? 'active' : '' ?>">註冊</a>
            <?php endif; ?>
        </div>
    </div>
</div>
