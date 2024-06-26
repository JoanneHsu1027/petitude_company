<?php
require __DIR__ . '/../config/pdo-connect.php';

$title = "會員列表";
$pageName = 'b2c_member-list';

$perPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'b2c_id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$order = $order === 'desc' ? 'DESC' : 'ASC';

$validSortColumns = ['b2c_id', 'b2c_name', 'b2c_email', 'b2c_mobile', 'b2c_birth'];
if (!in_array($sort, $validSortColumns)) {
    $sort = 'b2c_id';
}

$searchConditions = [];
$params = [];

if (!empty($_GET['b2c_id'])) {
    $searchConditions[] = 'b2c_id = :b2c_id';
    $params[':b2c_id'] = $_GET['b2c_id'];
}

if (!empty($_GET['b2c_name'])) {
    $searchConditions[] = 'b2c_name LIKE :b2c_name';
    $params[':b2c_name'] = '%' . $_GET['b2c_name'] . '%';
}

if (!empty($_GET['b2c_email'])) {
    $searchConditions[] = 'b2c_email LIKE :b2c_email';
    $params[':b2c_email'] = '%' . $_GET['b2c_email'] . '%';
}

if (!empty($_GET['b2c_mobile'])) {
    $searchConditions[] = 'b2c_mobile LIKE :b2c_mobile';
    $params[':b2c_mobile'] = '%' . $_GET['b2c_mobile'] . '%';
}

$searchSql = '';
if (!empty($searchConditions)) {
    $searchSql = 'WHERE ' . implode(' AND ', $searchConditions);
}

// 計算總筆數
$t_sql = "SELECT COUNT(b2c_id) FROM b2c_members $searchSql";
$stmt = $pdo->prepare($t_sql);
$stmt->execute($params);
$totalRows = $stmt->fetch(PDO::FETCH_NUM)[0];

// 計算總頁數
$totalPages = $totalRows ? ceil($totalRows / $perPage) : 0;
$rows = [];

if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page={$totalPages}");
        exit;
    }

    $offset = ($page - 1) * $perPage;
    $sql = "SELECT b2c.*, county_name, city_name
            FROM b2c_members AS b2c
            JOIN county ON fk_county_id = county_id
            JOIN city ON b2c.fk_city_id = city_id
            $searchSql
            ORDER BY $sort $order
            LIMIT $offset, $perPage";
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
    <h2>會員列表</h2>
</div>
<!-- 標題 end -->

<div class="container">
    <!-- 分頁功能Start -->
    <div class="p-2 bd-highlight">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item ">
                    <a class="page-link" href="?page=<?= 1 ?>">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>
                <li class="page-item ">
                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
                <!-- 前頁按鈕的功能 -->
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPages) : ?>
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
                    <a class="page-link" href="?page=<?= $totalPages ?>">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
                <!-- 後頁按鈕的功能 -->
            </ul>
        </nav>
    </div>

    <!-- 分頁功能End -->

    <!-- 搜尋功能Start -->
    <div class="p-2 bd-highlight">
        <form method="get" action="" class="form-horizontal">
            <div class="form-group row mb-0 align-items-center">
                <label for="b2c_id" class="col-sm-1 col-form-label px-0 text-center" style="color: #0c5a67;">會員編號</label>
                <div class="col-sm-1 px-0">
                    <input type="text" class="form-control mr-2" id="b2c_id" name="b2c_id" value="<?= htmlentities($_GET['b2c_id'] ?? '') ?>">
                </div>
                <label for="b2c_name" class="col-sm-1 col-form-label px-0 text-center" style="color: #0c5a67;">姓名</label>
                <div class="col-sm-1 px-0">
                    <input type="text" class="form-control mr-2" id="b2c_name" name="b2c_name" value="<?= htmlentities($_GET['b2c_name'] ?? '') ?>">
                </div>
                <label for="b2c_email" class="col-sm-1 col-form-label px-0 text-center" style="color: #0c5a67;">Email</label>
                <div class="col-sm-1 px-0">
                    <input type="text" class="form-control mr-2" id="b2c_email" name="b2c_email" value="<?= htmlentities($_GET['b2c_email'] ?? '') ?>">
                </div>
                <label for="b2c_mobile" class="col-sm-1 col-form-label px-0 text-center" style="color: #0c5a67;">手機</label>
                <div class="col-sm-1 px-0">
                    <input type="text" class="form-control mr-2" id="b2c_mobile" name="b2c_mobile" value="<?= htmlentities($_GET['b2c_mobile'] ?? '') ?>">
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">搜尋</button>
                </div>
            </div>
        </form>
    </div>
    <!-- 搜尋功能End -->

    <div class="row ">
        <div class="col">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="vertical-align: middle; text-align: center">
                        <th scope="col">
                            會員編號
                            <a href="?sort=b2c_id&order=desc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-down"></i></a>
                            <a href="?sort=b2c_id&order=asc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-up"></i></a>
                        </th>
                        <th scope="col">
                            姓名
                        </th>
                        <th scope="col">
                            Email
                            <a href="?sort=b2c_email&order=desc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-down"></i></a>
                            <a href="?sort=b2c_email&order=asc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-up"></i></a>
                        </th>
                        <th scope="col">手機</th>
                        <th scope="col">
                            生日
                            <a href="?sort=b2c_birth&order=desc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-down"></i></a>
                            <a href="?sort=b2c_birth&order=asc&page=<?= $currentPage ?>"><i class="fa-solid fa-sort-up"></i></a>
                        </th>

                        <th scope="col">地址</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr style="vertical-align: middle;">

                            <td style="text-align: center"><?= $r['b2c_id'] ?></td>
                            <td style="text-align: center"><?= $r['b2c_name'] ?></td>
                            <td style="text-align: center"><?= $r['b2c_email'] ?></td>
                            <td style="text-align: center"><?= $r['b2c_mobile'] ?></td>
                            <td style="text-align: center"><?= $r['b2c_birth'] ?></td>
                            <td><?= htmlentities($r['county_name'] . $r['city_name'] . $r['b2c_address']) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>

<?php include __DIR__ . '/../parts/html-foot.php' ?>