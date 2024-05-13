<!-- 沒有權限 -->
<?php
require __DIR__ . '/config/pdo_connect.php';
$title = '生前契約訂單-無權限';
$pageName = 'booking-no-admin';
$perPage = 25; # 每頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(booking_id) FROM booking";

# 算總筆數 
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 預設值
$totalPages = 0; 
$rows = []; 

if ($totalRows) {
#總頁數
if ($page > $totalPages) {
    header('Location: ?page={$totalPages}');
    exit; # 結束這支程式
}

# 取得分頁資料
$sql = sprintf("SELECT booking.*b2c_id, 
FROM `booking` 
JOIN b2b_id ON fk_b2c_id = b2c_id
ORDER BY booking_id ASC 
LIMIT %s, %s", 
($page - 1) * $perPage,
$perPage);
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

<?php include __DIR__ . '/parts/html_head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div id="content">
    <h1>生前契約訂單-無權限</h1>
</div>
<div class="container">
<div class="row">
    <div class="col">
        <nav aria-label="Page navigation example" >
            <ul class="pagination">
                <!-- 跳轉到第一頁，如果已經是則隱藏 -->
                <li class="page-item " style="display: <?= $currentPage == 1 ? 'none' : '' ?>";>
                    <a class="page-link" href="?page=<?= 1 ?>">first</a>
                </li>
                <!-- Previous 上一頁 -->
                <li class="page-item<?= $currentPage == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                </li>

                <!-- 起始頁前的省略符號 -->
                <?php if ($startPage > 1): ?> <!-- 如果起始的頁面超過1 -->
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>

                <!-- 每頁按鈕 -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item<?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" style="width: 44.55px;text-align: center;" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- 結束頁後的省略符號 -->
                <?php if ($endPage < $totalPages): ?> <!-- 如果結束的頁面小於總頁數 -->
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>

                <!-- Next 下一頁 -->
                <li class="page-item <?= $currentPage == $totalPages ? ' disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                </li>
                <!-- 跳轉到最後一頁，如果已經是則隱藏 -->
                <li class="page-item " style="display: <?= $currentPage == $totalPages ? 'none' : '' ?>";>
                    <a class="page-link" href="?page=<?= $totalPages ?>">End</a>
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
            <th>booking_id</th>
            <th>fk_b2c_id</th>
            <th>fk_pet_id</th>
            <th>fk_project_id</th>
            <th>fk_reservation_id</th>
            <th>booking_date</th>
            <th>booking_note</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
            <td><?= $r['booking_id'] ?></td>
            <td><?= $r['fk_b2c_id'] ?></td>
            <td><?= $r['fk_pet_id'] ?></td>
            <td><?= $r['fk_project_id'] ?></td>
            <td><?= $r['fk_reservation_id'] ?></td>
            <td><?= $r['booking_date'] ?></td>
            <td><?= $r['booking_note'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>
</div>

<?php include __DIR__ . '/parts/script.php' ?>
<?php include __DIR__ . '/parts/html_foot.php' ?>
