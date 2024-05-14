<div id="sidebar" class="show">
  
  <div class="">
    <a style='text-decoration:none' href="./index_.php"><h1>Petitude</h1></a>
  </div>
  

  <ul class="navbar-nav mb-2 mb-lg-0">
    <?php if (isset($_SESSION['admin'])): ?>
      <div class="menu-item">
        <a class="nav-link"><?= $_SESSION['admin']['b2b_name'] ?></a>
      </div>

      <div class="menu-item">
        <a href="#">會員管理 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="#" class="align-middle">子菜單項目1</a>
            <a href="#" class="align-middle">子菜單項目2</a>
            <a href="#" class="align-middle">子菜單項目3</a>
        </div>
    </div>

  <div class="menu-item">
        <a href="#">生命禮儀 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="#" class="align-middle">子菜單項目1</a>
            <a href="#" class="align-middle">子菜單項目2</a>
            <a href="#" class="align-middle">子菜單項目3</a>
        </div>
    </div>
  
    <div class="menu-item">
        <a href="#">商品管理 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="#" class="align-middle">子菜單項目1</a>
            <a href="#" class="align-middle">子菜單項目2</a>
            <a href="#" class="align-middle">子菜單項目3</a>
        </div>
    </div>

   <div class="menu-item">
        <a href="#">合作店家 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="#" class="align-middle">子菜單項目1</a>
            <a href="#" class="align-middle">子菜單項目2</a>
            <a href="#" class="align-middle">子菜單項目3</a>
        </div>
    </div>

    <div class="menu-item">
        <a href="#">健康 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="#" class="align-middle">子菜單項目1</a>
            <a href="#" class="align-middle">子菜單項目2</a>
            <a href="#" class="align-middle">子菜單項目3</a>
        </div>
    </div>
  
    <div class="menu-item">
        <a href="#">論壇 <i class="fa-solid fa-angle-down"></i></a>
        <div class="dropdown">
            <a href="class.php" class="align-middle">主題管理</a>
            <a href="article.php" class="align-middle">文章管理</a>
        </div>
    </div>
  
   
      <div class="menu-item">
        <a href="logout.php">登出</a>
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