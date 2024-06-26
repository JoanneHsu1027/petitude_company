<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = "產品列表";
$pageName = 'product';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(product_id) FROM `product`";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 預設值
$totalPages = 0;
$rows = [];

if ($totalRows) {
    # 總頁數
    $totalPages = ceil($totalRows / $perPage);
    if ($page > $totalPages) {
        header("Location: ?page={$totalPages}");
        exit; # 結束這支程式
    }

    # 取得分頁資料
    $sql = sprintf(
        "SELECT * FROM `product` ORDER BY product_id LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<!-- 標題 start -->
<div id="content">
    <h2>產品列表</h2>
</div>
<!-- 標題 end -->


<div class="container" style="max-width: 1600px">
    <div class="d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- 前頁按鈕的功能 -->
                    <li class="page-item">
                        <a class="page-link" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>"><i class="fa-solid fa-angle-left"></i></a>
                    </li>
                    <!-- 前頁按鈕的功能 -->
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) : ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>
                    <!-- 後頁按鈕的功能 -->
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page <= $totalPages ? $page + 1 : '' ?>"><i class="fa-solid fa-angle-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
                    </li>
                    <!-- 後頁按鈕的功能 -->
                </ul>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="vertical-align: middle; text-align: center">
                        <th scope="col">商品號</th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">商品敘述</th>
                        <th scope="col">商品單價</th>
                        <th scope="col">商品庫存</th>
                        <th scope="col">商品分類</th>
                        <th scope="col">進貨日期</th>
                        <th scope="col">最後修改日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr style="vertical-align: middle;">
                            <td style="text-align: center"><?= $r['product_id'] ?></td>
                            <td style="text-align: center"><?= $r['product_name'] ?></td>
                            <td><?= $r['product_description'] ?></td>
                            <td style="text-align: center"><?= $r['product_price'] ?></td>
                            <td style="text-align: center"><?= $r['product_quantity'] ?></td>
                            <td style="text-align: center"><?= $r['product_category'] ?></td>
                            <td><?= $r['product_date'] ?></td>
                            <td><?= $r['product_last_modified'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<?php include __DIR__ . '/../parts/foot.php' ?>