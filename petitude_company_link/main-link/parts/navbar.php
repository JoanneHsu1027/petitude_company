<div id="sidebar" class="show">
    <h1>Petitude</h1>
    <div class="menu-item">
        <a href="./index_.php">回首頁</a>
    </div>

    <?php if (isset($_SESSION['admin'])) : ?>

        <div class="menu-item">
            <a class="nav-link"><?= $_SESSION['admin']['b2b_name'] ?></a>
        </div>



        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        使用者管理
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="m-2">
                        <a href="../b2bweb/b2b_list.php" class="align-middle" style="text-decoration:none; color:#0c5a67">員工列表 </a>
                    </div>
                    <div class="m-2">
                        <a href="../b2bweb/b2c_list.php" class="align-middle" style="text-decoration:none; color:#0c5a67">會員列表 </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                        商品管理
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="m-2">
                        <a href="../market/product.php" class="align-middle" style="text-decoration:none; color:#0c5a67">商品列表</a>
                    </div>
                    <div class="m-2">
                        <a href="../market/product_imgs.php" class="align-middle" style="text-decoration:none; color:#0c5a67">商品圖片列表</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                        訂單管理
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="m-2">
                        <a href="../market/request.php" class="align-middle" style="text-decoration:none; color:#0c5a67">訂單列表</a>
                    </div>
                    <div class="m-2">
                        <a href="../market/request_detail.php" class="align-middle" style="text-decoration:none; color:#0c5a67">訂單詳細列表</a>
                    </div>
                </div>
            </div>
        </div>




        <div class="menu-item">
            <a class="nav-link" href="logout.php">登出</a>
        </div>
    <?php else : ?>
        <div class="menu-item">
            <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="../b2bweb/login.php">登入</a>
        </div>
        <div class="menu-item">
            <a class="nav-link <?= $pageName == 'register' ? 'active' : '' ?>" href="../b2bweb/register.php">註冊</a>
        </div>
    <?php endif ?>

    <!-- <div class="menu-item">
        <a href="#"></a>
    </div> -->
</div>
</div>