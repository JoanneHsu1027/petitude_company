<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = "員工列表";
$pageName = 'b2b_member-list';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'b2b_account';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$order = $order === 'desc' ? 'DESC' : 'ASC';

$searchConditions = [];
$params = [];

if (!empty($_GET['b2b_account'])) {
    $searchConditions[] = 'b2b_account = :b2b_account';
    $params[':b2b_account'] = $_GET['b2b_account'];
}

if (!empty($_GET['b2b_job_name'])) {
    $searchConditions[] = 'b2b_job_name LIKE :b2b_job_name';
    $params[':b2b_job_name'] = '%' . $_GET['b2b_job_name'] . '%';
}

$searchSql = '';
if (!empty($searchConditions)) {
    $searchSql = 'WHERE ' . implode(' AND ', $searchConditions);
}


// 計算總筆數
$t_sql = "SELECT COUNT(b2b_id) FROM b2b_members $searchSql";
$stmt = $pdo->prepare($t_sql);
$stmt->execute($params);
$totalRows = $stmt->fetch(PDO::FETCH_NUM)[0];

// 計算總頁數
$totalPages = $totalRows ? ceil($totalRows / $perPage) : 0;
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
        "SELECT b2b.*,b2b_job_name
    FROM b2b_members as b2b
    JOIN b2b_job ON fk_b2b_job_id = b2b_job_id
    $searchSql
    ORDER BY $sort $order
    LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
}

// 分頁邏輯保持不變
$currentPage = max($page, 1);
$range = 5;
$startPage = $currentPage - $range;
$endPage = $currentPage + $range;

if ($startPage < 1) {
    $endPage += 1 - $startPage;
    $startPage = 1;
}

if ($endPage > $totalPages) {
    $startPage -= $endPage - $totalPages;
    $endPage = $totalPages;

    if ($startPage < 1) {
        $startPage = 1;
    }
}
?>



<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<!-- 標題 start -->
<div id="content">
    <h2>員工列表</h2>
</div>
<!-- 標題 end -->

<div class="container">
    <!-- 分頁功能Start -->
    <div class="d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight">
<<<<<<< HEAD

            <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'b2b_add' ? 'active' : '' ?>" href="b2b-add.php" style="Text-decoration:none; color:white">新增員工 <i class="fa-solid fa-circle-plus"></i></a></button>
=======
            <button type="button" class="btn btn-primary">
                <a class=" <?= $pageName == 'b2b_add' ? 'active' : '' ?>"href="b2b-add.php" style="Text-decoration:none; color:white">
                    新增員工 <i class="fa-solid fa-circle-plus"></i>
                </a>
            </button>
>>>>>>> origin/s6538142
        </div>
        <div class="p-2 bd-highlight">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
<<<<<<< HEAD
                    <!-- 前頁按鈕的功能 -->
                    <li class="page-item">
                        <a class="page-link" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>"><i class="fa-solid fa-angle-left"></i></a>
=======
                    <li class="page-item ">
                        <a class="page-link" href="?page=<?= 1 ?>">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link" href="?page=<?= $currentPage - 1 ?>">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
>>>>>>> origin/s6538142
                    </li>
                    <!-- 前頁按鈕的功能 -->
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) : ?>
<<<<<<< HEAD
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
=======
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item ">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?>">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item ">
                        <a class="page-link"  href="?page=<?= $totalPages ?>">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
>>>>>>> origin/s6538142
                    </li>
                    <!-- 後頁按鈕的功能 -->
                </ul>
            </nav>
        </div>
    </div>
        <!-- 分頁功能End -->

        <!-- 搜尋功能Start -->
        <div class="p-2 bd-highlight">
            <form method="get" action="" class="form-horizontal">
                <div class="form-group row mb-0 align-items-center">
                    <label for="b2b_account" class="col-sm-3 col-form-label pe-0" style="color: #0c5a67;">員工編號</label>
                    <div class="col-sm-6 ps-0">
                        <input type="text" class="form-control ps-0" id="b2b_account" name="b2b_account" value="<?= htmlentities($_GET['b2b_account'] ?? '') ?>">
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary btn-block">搜尋</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 搜尋功能End -->
    <div class="row text-center">
        <div class="col">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="vertical-align: middle; text-align: center">
                        <th scope="col">員工編號
                            <a href="?sort=b2b_id&order=desc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-down"></i></a>
                            <a href="?sort=b2b_id&order=asc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-up"></i></a>
                        </th>

                        <th scope="col">員工姓名</th>
                        <th scope="col">員工手機</th>
                        <th scope="col">員工信箱</th>
                        <th scope="col">職位
                            <a href="?sort=fk_b2b_job_id&order=desc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-down"></i></a>
                            <a href="?sort=fk_b2b_job_id&order=asc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-up"></i></a>
                        </th>

                        <th scope="col">修改資料</th>
                        <th scope="col">刪除資料</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr style="vertical-align: middle;">

                            <td style="text-align: center"><?= $r['b2b_account'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_name'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_mobile'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_email'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_job_name'] ?></td>
                            <td style="text-align: center">
                                <a href="b2b-edit.php?b2b_id=<?= $r['b2b_id'] ?>">
                                    <button type="button" class="btn btn-warning fa-solid fa-pen-to-square"></button>
                                </a>
                            </td>
                            <td style="text-align: center">
                                <a href="javascript: deleteOne(<?= $r['b2b_id'] ?>)">
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
    const deleteOne = (b2b_id) => {
        if (confirm(`是否要刪除編號為 ${b2b_id} 的資料?`)) {
            location.href = `b2b-delete.php?b2b_id=${b2b_id}`;
        }
    }
</script>
<?php include __DIR__ . '/../parts/foot.php' ?>