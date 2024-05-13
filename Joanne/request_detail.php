<?php
require __DIR__ . './config/pdo-connect.php';
$title = "訂單詳細列表";
$pageName = 'request_detail';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(request_detail_id) FROM `request_detail`";

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
        "SELECT * FROM `request_detail` ORDER BY request_detail_id LIMIT %s, %s",
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
    <h2>訂單詳細頁</h2>
</div>
<!-- 標題 end -->


<div class="container">
    <div class="row">
        <div class="col">
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
        <div class="col">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">訂單號</th>
                        <th scope="col">商品號</th>
                        <th scope="col">購買數量</th>
                        <th scope="col">評論星數</th>
                        <th scope="col">評論內容</th>
                        <th scope="col">評論圖片</th>
                        <th scope="col">刪除資料</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['request_detail_id'] ?></td>
                            <td><?= $r['fk_request_id'] ?></td>
                            <td><?= $r['fk_product_id'] ?></td>
                            <td><?= $r['purchase_quantity'] ?></td>
                            <td><?= $r['comment_score'] ?></td>
                            <td><?= $r['comment_comments'] ?></td>
                            <td><a href="<?= $r['comment_image'] ?>"><?= $r['comment_image'] ?></a></td>
                            <td>
                                <a href="javascript: deleteOne(<?= $r['request_detail_id'] ?>)">
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
    const deleteOne = (request_detail_id) => {
        if (confirm(`是否要刪除編號為 ${request_detail_id} 的資料?`)) {
            location.href = `request_detail_delete.php?request_detail_id=${request_detail_id}`;
        }
    }
</script>
<?php include __DIR__ . './parts/foot.php' ?>