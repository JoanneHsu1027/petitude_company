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

$t_sql = "SELECT COUNT(b2b_id) FROM b2b_members";

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
        "SELECT b2b.*,b2b_job_name
    FROM b2b_members as b2b
    JOIN b2b_job ON fk_b2b_job_id = b2b_job_id
    ORDER BY b2b_id ASC
    LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

/*
echo json_encode([
  'totalRows' => $totalRows,
  'totalPages' => $totalPages,
  'page' => $page,
  'rows' => $rows,
]);
*/
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
    <h2>員工列表</h2>
</div>
<!-- 標題 end -->

<div class="container">
    <div class="d-flex flex-row bd-highlight mb-3">
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



    

    <div class="row">
        <div class="col">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="vertical-align: middle; text-align: center">

                        <th scope="col">員工編號</th>
                        <th scope="col">姓名</th>
                        <th scope="col">職位</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr style="vertical-align: middle;">

                            <td style="text-align: center"><?= $r['b2b_account'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_name'] ?></td>
                            <td style="text-align: center"><?= $r['b2b_job_name'] ?></td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>

<?php include __DIR__ . '/../parts/foot.php' ?>