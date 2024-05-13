<?php
if (!isset($pageName)) $pageName = '';

?>

<style>
  .navbar-nav .nav-link.active {
    background-color: blue;
    color: white;
    font-weight: 700;
    border-radius: 6px;
  }

  /* 因為在.navbar-nav這個階層有設定文字顏色, 所以為了覆蓋它, 需將class的階層設到這層才行 不能只設.nav-link.active */
</style>

<div class="container">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="list-admin.php">logo</a> 
      <!-- 確認首頁位置後修改 -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'list-admin' ? 'active' : '' ?>" aria-current="page" href="list-admin.php">列表</a>
            <!-- 確認權限設定後修改 -->
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'add' ? 'active' : '' ?>" href="add.php">新增</a>
          </li>
        </ul>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- 如果已經登入了 -->
          <?php /*if (isset($_SESSION['admin'])) :*/ ?> 
            <!-- 測試先不確認權限, 註掉 -->
            <li class="nav-item">
              <a class="nav-link"><?= /* $_SESSION['admin']['nickname']*/ ?></a>
              <!-- 測試先不確認權限, 註掉 -->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">登出</a>
            </li>
          <?php /* else : */?>
            <li class="nav-item">
              <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="login.php">登入</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $pageName == 'register' ? 'active' : '' ?>" href="register.php">註冊</a>
            </li>
          <?php /* endif */ ?>


        </ul>


      </div>
    </div>
  </nav>
</div>