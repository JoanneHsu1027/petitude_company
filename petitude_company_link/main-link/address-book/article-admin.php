<?php
require __DIR__ . '/../config/pdo-connect.php';
$title = "文章列表";
$pageName = 'article';

$perPage = 20; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(article_id) FROM article";

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
    "SELECT * FROM `article` ORDER BY article_id DESC LIMIT %s, %s",
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
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<div class="container">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item ">
            <a class="page-link" href="?page=1">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item ">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
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
            <a class="page-link" href="?page=<?= $page + 1 ?>">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item ">
            <a class="page-link" href="?page=<?= $totalPages ?>">
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
            <!-- <th scope="col"><i class="fa-solid fa-trash"></i></th> -->
            <div style="display: flex;  justify-content:space-between"> <a class="btn btn-primary" href="article-add.php" role="button">新增文章 <i class="fa-solid fa-circle-plus"></i></a>
              <a href="class.php"><i class="fa-solid fa-angles-left"></i>主題管理</a>
            </div>

            <th scope="col">文章ID</th>
            <th scope="col">建立日期</th>
            <th scope="col">文章名稱</th>
            <th scope="col">文章內容</th>
            <th scope="col">文章圖片</th>
            <th scope="col">主題ID</th>
            <th scope="col">會員ID</th>
            <!-- <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <!-- <td><a href="javascript: deleteOne(<?= $r['article_id'] ?>)">
                  <i class="fa-solid fa-trash"></i>
                </a></td> -->
              <td><?= $r['article_id'] ?></td>
              <td><?= $r['article_date'] ?></td>
              <td><?= $r['article_name'] ?></td>
              <td><?= $r['article_content'] ?></td>
              <td><?= $r['article_img'] ?></td>
              <td><?= $r['fk_class_id'] ?></td>
              <td><?= $r['fk_b2c_id'] ?></td>
              <!-- <td>
                <a href="article-edit.php?article_id=<?= $r['article_id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td> -->
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
  const deleteOne = (article_id) => {
    if (confirm(`是否要刪除編號為 ${article_id} 的資料?`)) {
      location.href = `delete.php?article_id=${article_id}`;
    }
  }
</script>
<?php include __DIR__ . '/../parts/foot.php' ?>