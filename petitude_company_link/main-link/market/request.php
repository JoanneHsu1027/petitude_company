<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = "訂單列表";
$pageName = 'request';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(request_id) FROM `request`";

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
        "SELECT request.*, county_name, city_name
        FROM `request`
        JOIN county ON fk_county_id = county_id
        JOIN city ON request.fk_city_id = city_id
        ORDER BY request_id
        LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php

$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

$currentPage = max($currentPage, 1); #  currentPage 不小於 1

$range = 5; // 前後按鈕長度

$startPage = $currentPage - $range;
$endPage = $currentPage + $range;


if ($startPage < 1) {
    $endPage += 1 - $startPage; #由於這時候$startPage是負數，$endPage會加上 1-$startPage 補足缺少的長度 
    $startPage = 1;
}

if ($endPage > $totalPages) {
    $startPage -= $endPage - $totalPages; #由於這時候$endPage超過了原本的總頁數，$startPage- ($endPage - $totalPages) 減去多餘的長度 
    $endPage = $totalPages;

    # 確保 `startPage` 不小於 1
    if ($startPage < 1) {
        $startPage = 1;
    }
}
?>

<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<!-- 標題 start -->
<div id="content">
    <h2>訂單列表</h2>
</div>
<!-- 標題 end -->


<div class="container" style="max-width: 1600px">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'request_add' ? 'active' : '' ?>" href="request_add.php" style="Text-decoration:none; color:white">新增訂單</a></button>
        </div>
        <div class="col-2 me-0">
            <nav aria-label="Page navigation example">
                <ul class="pagination mx-0">
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
                        <th scope="col">訂單號</th>
                        <th scope="col">訂單日期</th>
                        <th scope="col">訂單狀態</th>
                        <th scope="col">付款狀態</th>
                        <th scope="col">會員編號</th>
                        <th scope="col">訂單總價</th>
                        <th scope="col">寄送地址</th>
                        <th scope="col">連絡電話</th>
                        <th scope="col">電子信箱</th>
                        <th scope="col">修改訂單</th>
                        <th scope="col">刪除訂單</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['request_id'] ?></td>
                            <td><?= $r['request_date'] ?></td>
                            <td><?= $r['request_status'] ?></td>
                            <td><?= $r['payment_status'] ?></td>
                            <td><?= $r['fk_b2c_id'] ?></td>
                            <td><?= $r['request_price'] ?></td>
                            <td><?= htmlentities($r['county_name'] . $r['city_name'] . $r['recipient_address']) ?></td>
                            <td><?= $r['recipient_mobile'] ?></td>
                            <td><?= $r['recipient_email'] ?></td>
                            <td>

                                <a href="./request_edit.php?request_id=<?= $r['request_id'] ?>" class="btn btn-warning fa-solid fa-pen-to-square"></a>


                            </td>
                            <td>
                                <a href="javascript: deleteOne(<?= $r['request_id'] ?>)">
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

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
    const deleteOne = (request_id) => {
        if (confirm(`是否要刪除編號為 ${request_id} 的資料?`)) {
            location.href = `request_delete.php?request_id=${request_id}`;
        }
    }
</script>
<?php include __DIR__ . '/../parts/foot.php' ?>