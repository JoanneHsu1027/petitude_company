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
            <a class="page-link" href="?page=1">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item ">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
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
        <a class="btn btn-primary" href="class-add.php" role="button">新增類別 <i class="fa-solid fa-circle-plus"></i></a>
        <thead>
          <tr>
            <th></th>
            <th scope="col">類別ID</th>
            <th scope="col">類別名稱</th>
            <th scope="col">員工ID</th>
            <th colspan="2"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>

            <tr>
              <td></td>
              <td><?= $r['class_id'] ?></td>
              <td><?= $r['class_name'] ?></td>
              <td><?= $r['fk_b2b_id'] ?></td>
              <td><a href="javascript: deleteOne(<?= $r['class_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a>
              </td>
              <td>
                <a href="class-edit.php?class_id=<?= $r['class_id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td>

            </tr>

            <tr>

              <td colspan="6">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseExample<?= $r['class_id'] ?>" aria-expanded="false"
                  aria-controls="collapseExample<?= $r['class_id'] ?>">
                  <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="collapse" id="collapseExample<?= $r['class_id'] ?>">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <?php
                      $class_id = $r['class_id']; // 從迴圈中獲取類別ID
                    
                      // 查詢與特定 class_id 相關聯的文章資訊
                      $stmt = $pdo->prepare("SELECT article_id, article_date, article_name, article_content, article_img, fk_class_id, fk_b2c_id
                            FROM article
                            WHERE fk_class_id = ?");
                      $stmt->execute([$class_id]);
                      $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // 檢查是否有文章
                      $hasArticles = !empty($articles);
                      ?>
                      <?php if ($hasArticles): ?>
                        <thead>
                          <tr>
                            <th>文章ID</th>
                            <th>日期</th>
                            <th>標題</th>
                            <th>內容</th>
                            <th>圖片</th>
                            <th>類別ID</th>
                            <th>B2C會員ID</th>
                          </tr>
                        </thead>
                      <?php endif; ?>
                      <tbody>
                        <?php
                        // 如果有文章，顯示文章相關資訊，否則顯示提示訊息
                        if ($hasArticles) {
                          foreach ($articles as $article) {
                            echo "<tr>";
                            echo "<td>{$article['article_id']}</td>";
                            echo "<td>{$article['article_date']}</td>";
                            echo "<td>{$article['article_name']}</td>";
                            echo "<td>{$article['article_content']}</td>";
                            echo "<td>{$article['article_img']}</td>";
                            echo "<td>{$article['fk_class_id']}</td>";
                            echo "<td>{$article['fk_b2c_id']}</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='7'>類別中無新增文章</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </td>
            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>
      <a href="article.php">所有文章<i class="fa-solid fa-angles-right"></i></a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>

<script>
  const deleteOne = (class_id) => {
    if (confirm(`是否要刪除編號 ${class_id} 的類別?`)) {
      location.href = `delete.php?class_id=${class_id}`;
    }
  }


</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>