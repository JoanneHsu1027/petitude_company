<?php
require __DIR__ . './config/pdo-connect.php';
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
<?php include __DIR__ . './parts/head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>

<!-- 標題 start -->
<div id="content">
    <h2>產品列表</h2>
</div>
<!-- 標題 end -->


<div class="container" style="max-width: 1600px">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'product_add' ? 'active' : '' ?>" href="product_add.php" style="Text-decoration:none; color:white">新增商品</a></button>
        </div>
        <div class="col-2">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item ">
                        <a class="page-link" href="#">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link" href="#">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) : ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item ">
                        <a class="page-link" href="#">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link" href="#">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">商品號</th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">商品敘述</th>
                        <th scope="col">商品單價</th>
                        <th scope="col">商品庫存</th>
                        <th scope="col">商品分類</th>
                        <th scope="col">進貨日期</th>
                        <th scope="col">最後修改日期</th>
                        <th scope="col">修改商品</th>
                        <th scope="col">刪除商品</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['product_id'] ?></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['product_description'] ?></td>
                            <td><?= $r['product_price'] ?></td>
                            <td><?= $r['product_quantity'] ?></td>
                            <td><?= $r['product_category'] ?></td>
                            <td><?= $r['product_date'] ?></td>
                            <td><?= $r['product_last_modified'] ?></td>
                            <td>
                                <a href="./product_edit.php?product_id=<?= $r['product_id'] ?>" class="btn btn-warning fa-solid fa-pen-to-square"></a>
                            </td>
                            <td>
                                <a href="javascript: deleteOne(<?= $r['product_id'] ?>)">
                                    <button type="button" class="btn btn-danger fa-solid fa-trash-can"></button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const deleteOne = (product_id) => {
        if (confirm(`是否要刪除編號為 ${product_id} 的資料?`)) {
            location.href = `product_delete.php?product_id=${product_id}`;
        }
    }
</script>
<?php include __DIR__ . './parts/foot.php' ?>