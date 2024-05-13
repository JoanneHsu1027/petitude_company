<?php
require __DIR__ . './config/pdo-connect.php';
$title = "產品圖片列表";
$pageName = 'product_imgs';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(picture_id) FROM `product_imgs`";

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
        "SELECT * FROM `product_imgs` ORDER BY picture_id LIMIT %s, %s",
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
    <h2>訂單列表</h2>
</div>
<!-- 標題 end -->


<div class="container" style="max-width: 1600px">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'product_imgs_add' ? 'active' : '' ?>" href="product_imgs_add.php" style="Text-decoration:none; color:white">新增圖片</a></button>
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
        <div class="col-6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">圖片編號</th>
                        <th scope="col">對應商品編號</th>
                        <th scope="col">圖片名稱</th>
                        <th scope="col">圖片url</th>
                        <th scope="col">修改內容</th>
                        <th scope="col">刪除圖片</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['picture_id'] ?></td>
                            <td><?= $r['fk_product_id'] ?></td>
                            <td><?= $r['picture_name'] ?></td>
                            <td><?= $r['picture_url'] ?></td>
                            <td>
                                <a href="edit.php?picture_id=<?= $r['picture_id'] ?>">
                                    <button type="button" class="btn btn-warning fa-solid fa-pen-to-square"></button>
                                </a>
                            </td>
                            <td>
                                <a href="javascript: deleteOne(<?= $r['picture_id'] ?>)">
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
    const deleteOne = (picture_id) => {
        if (confirm(`是否要刪除編號為 ${picture_id} 的資料?`)) {
            location.href = `product_imgs_delete.php?picture_id=${picture_id}`;
        }
    }
</script>
<?php include __DIR__ . './parts/foot.php' ?>