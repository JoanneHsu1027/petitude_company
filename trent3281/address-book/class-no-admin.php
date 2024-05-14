<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = "通訊錄列表";
$pageName = 'class';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(class_id) FROM class";

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
    "SELECT * FROM `class` ORDER BY class_id DESC LIMIT %s, %s",
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
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

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
          <?php for ($i = $page - 5; $i <= $page + 5; $i++):
            if ($i >= 1 and $i <= $totalPages): ?>
              <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endif; endfor; ?>
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

            <th scope="col">類別ID</th>
            <th scope="col">類別名稱</th>
            <th scope="col">員工ID</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>

              <td><?= $r['class_id'] ?></td>
              <td><?= $r['class_name'] ?></td>
              <td><?= $r['fk_b2b_id'] ?></td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const deleteOne = (class_id) => {
    if (confirm(`是否要刪除編號為 ${class_id} 的資料?`)) {
      location.href = `delete.php?class_id=${class_id}`;
    }
  }


</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>