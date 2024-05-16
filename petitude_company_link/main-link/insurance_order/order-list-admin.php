<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = "保險訂單表";
$pageName = 'order-list';

$perPage = 15; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}


$t_sql = "SELECT COUNT(insurance_order_id) FROM insurance_order";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];


#預設值
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
  #用JOIN同時取得四個TABLE
  $sql = sprintf(
    "SELECT io.*, ip.insurance_fee, city_name, county_name
  FROM insurance_order io
  JOIN insurance_product ip ON io.fk_insurance_product_id = ip.insurance_product_id
  Join county on fk_county_id = county_id
  Join city on fk_city_id = city_id
  ORDER BY io.insurance_order_id ASC
  LIMIT %s, %s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}
?>


<?php include __DIR__ . '/name-transfer.php'; ?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<!-- 標題 start -->
<div id="content">
  <h2>保險訂單列表</h2>
</div>
<!-- 標題 end -->

<div class="container" style="max-width: 1550px;">
  <div class="d-flex flex-row bd-highlight mb-3">
    <!-- <div class="p-2 bd-highlight">
      <a href="add.php">
        <button type="submit" class="btn btn-primary">新增保單</button>
      </a>
    </div> -->

    <div class="p-2 bd-highlight">
      <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'add' ? 'active' : '' ?>" href="add.php" style="Text-decoration:none; color:white">新增保單 <i class="fa-solid fa-circle-plus"></i></a></button>
    </div>

    <!-- pagenation -->
    <div class="p-2 bd-highlight">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <!-- 前頁按鈕的功能 -->
          <li class="page-item">
            <a class="page-link" href="?page=1"><i class="fa-solid fa-angles-left"></i></a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>"><i class="fa-solid fa-angle-left"></i></a>
          </li>
          <!-- 前頁按鈕的功能 -->
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) : ?>
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
          </li>
          <!-- 後頁按鈕的功能 -->
        </ul>
      </nav>
    </div>
  </div>
  <!-- pagenation -->


  <div class="row">
    <div class="col-12">
      <table class="table table-bordered table-striped">
        <thead>
          <tr style="text-align: center; vertical-align: middle;">
            <th scope="col">訂單編號</th>
            <th scope="col">會員帳號</th>
            <th scope="col">寵物帳號</th>
            <th scope="col">保險商品代號</th>
            <th scope="col">保險費用</th>
            <th scope="col">付款狀態</th>
            <th scope="col">保險起始日期</th>
            <th scope="col">地址</th>
            <th scope="col">手機號碼</th>
            <th scope="col">聯絡信箱</th>
            <th scope="col">身分證字號</th>
            <th scope="col">修改訂單</th>
            <th scope="col">刪除訂單</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr style="vertical-align: middle;">


              <td style="text-align: center"><?= $r['insurance_order_id'] ?></td>
              <td style="text-align: center"><?= $r['fk_b2c_id'] ?></td>
              <td style="text-align: center"><?= $r['fk_pet_id'] ?></td>
              <td style="text-align: center"><?= $r['fk_insurance_product_id'] ?></td>
              <td style="text-align: center"><?= $r['insurance_fee'] ?></td>
              <!-- db沒有這個欄位, 要在抓insurance_product時去特別抓 -->
              <td style="text-align: center"><?= $transfer[$r['payment_status']] ?></td>
              <!-- db是布林值, 另外寫一個name-transfer.php來改. 上面要再require檔案 -->
              <td style="text-align: center"><?= $r['insurance_start_date'] ?></td>
              <td><?= htmlentities($r['county_name'] . $r['city_name'] . $r['policyholder_address']) ?></td>
              <td style="text-align: center"><?= htmlentities($r['policyholder_mobile']) ?></td>
              <td style="text-align: center"><?= htmlentities($r['policyholder_email']) ?></td>
              <td style="text-align: center"><?= htmlentities($r['policyholder_IDcard']) ?></td>
              <!-- 可以用兩種, strip_tags會擋掉tags,看不到對方用了甚麼tag. htmlentities只跳脫,可以看到對方用了甚麼,較建議用 -->
              <td style="text-align: center">
                <a href="edit.php?insurance_order_id=<?= $r['insurance_order_id'] ?>" class="btn btn-warning fa-solid fa-pen-to-square"></a>
              </td>
              <td style="text-align: center">
                <a href="javascript: deleteOne(<?= $r['insurance_order_id'] ?>)">
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
  // 確認是否刪除
  const deleteOne = (insurance_order_id) => {
    if (confirm(`是否要刪除編號為 ${insurance_order_id} 的資料?`)) {
      location.href = `delete.php?insurance_order_id=${insurance_order_id}`;
    }
  }
</script>
<?php include __DIR__ . '/../parts/foot.php' ?>