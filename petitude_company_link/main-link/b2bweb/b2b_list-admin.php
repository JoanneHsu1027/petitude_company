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

<div class="container">
    <!-- 分頁功能Start -->
      <div class="row">
          <div class="col">
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'b2b_add' ? 'active' : '' ?>" href="b2b-add.php" style="Text-decoration:none; color:white">新增員工 <i class="fa-solid fa-circle-plus"></i></a></button>
            </div>
              <nav aria-label="Page navigation example">
                  <ul class="pagination">
                      <!-- First Page Link -->
                      <li class="page-item" style="display: <?= $currentPage == 1 ? 'none' : '' ?>;">
                          <a class="page-link" href="?page=1&order=<?= $order ?>&sort=<?= $sort ?>">First</a>
                      </li>
                      <!-- Previous Page Link -->
                      <li class="page-item<?= $currentPage == 1 ? ' disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $currentPage - 1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Previous</a>
                      </li>
                      <!-- Ellipsis before the start page -->
                      <?php if ($startPage > 1): ?>
                          <li class="page-item disabled"><span class="page-link">...</span></li>
                      <?php endif; ?>
                      <!-- Page Number Links -->
                      <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                          <li class="page-item<?= $i == $currentPage ? ' active' : '' ?>">
                              <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&sort=<?= $sort ?>"><?= $i ?></a>
                          </li>
                      <?php endfor; ?>
                      <!-- Ellipsis after the end page -->
                      <?php if ($endPage < $totalPages): ?>
                          <li class="page-item disabled"><span class="page-link">...</span></li>
                      <?php endif; ?>
                      <!-- Next Page Link -->
                      <li class="page-item<?= $currentPage == $totalPages ? ' disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $currentPage + 1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Next</a>
                      </li>
                      <!-- Last Page Link -->
                      <li class="page-item" style="display: <?= $currentPage == $totalPages ? 'none' : '' ?>;">
                          <a class="page-link" href="?page=<?= $totalPages ?>&order=<?= $order ?>&sort=<?= $sort ?>">End</a>
                      </li>
                  </ul>
              </nav>
          </div>
      </div>
    <!-- 分頁功能End -->

    <!-- 搜尋功能Start -->
    <div class="row">
      <form method="get" action="">
            <div class="form text-dark">
                <div class=" col-md-3">
                    <label for="b2b_id">員工編號</label>
                    <input type="text" class="form-control" id="b2b_id" name="b2b_id" value="<?= htmlentities($_GET['b2b_id'] ?? '') ?>">
                </div>
                <div class=" col-md-3">
                    <label for="b2b_name">員工姓名</label>
                    <input type="text" class="form-control" id="b2b_name" name="b2b_name" value="<?= htmlentities($_GET['b2b_name'] ?? '') ?>">
                </div>
                <div class=" col-md-3">
                    <label for="b2b_email">員工Email</label>
                    <input type="text" class="form-control" id="b2b_email" name="b2b_email" value="<?= htmlentities($_GET['b2b_email'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="b2b_mobile">員工手機</label>
                    <input type="text" class="form-control" id="b2b_mobile" name="b2b_mobile" value="<?= htmlentities($_GET['b2b_mobile'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" >搜尋</button>
      </form>
    </div>
    <!-- 搜尋功能End -->
  <div class="row text-center">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col">員工編號</th>
            <th scope="col">員工姓名</th>
            <th scope="col">員工手機</th>
            <th scope="col">員工信箱</th>
            <th scope="col">職位</th>
            <th scope="col">修改資料</th>
            <th scope="col">刪除資料</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>

              <td><?= $r['b2b_account'] ?></td>
              <td><?= $r['b2b_name'] ?></td>
              <td><?= $r['b2b_mobile'] ?></td>
              <td><?= $r['b2b_email'] ?></td>
              <td><?= $r['b2b_job_name'] ?></td>
              <td>
                <a href="b2b-edit.php?b2b_id=<?= $r['b2b_id'] ?>">
                 <button type="button" class="btn btn-warning fa-solid fa-pen-to-square"></button>
                </a>
              </td>
              <td>
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