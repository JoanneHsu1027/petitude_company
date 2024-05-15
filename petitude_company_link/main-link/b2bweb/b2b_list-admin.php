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
                    <label for="b2b_account">員工編號</label>
                    <input type="text" class="form-control" id="b2b_account" name="b2b_account" value="<?= htmlentities($_GET['b2b_account'] ?? '') ?>">
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