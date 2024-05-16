<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = "保險產品表";
$pageName = 'product-list';

$perPage = 10; # 每一頁最多有幾筆

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}


$t_sql = "SELECT COUNT(insurance_product_id) FROM insurance_product";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];



// SELECT * FROM `address_book` ORDER BY sid DESC LIMIT 0, 20
// SELECT * FROM `address_book` ORDER BY sid DESC LIMIT 20, 20
// SELECT * FROM `address_book` ORDER BY sid DESC LIMIT 40, 20
// SELECT * FROM `address_book` ORDER BY sid DESC LIMIT 60, 20

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
  $sql = sprintf(
    "SELECT * FROM `insurance_product` ORDER BY insurance_product_id ASC LIMIT %s, %s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}
?>


<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<!-- 標題 start -->
<div class="">
  <div class="container">
    <div class="row">
      <h2 class="c-dark pagenation">保險產品表</h2>
    </div>
  </div>
  <!-- 標題 end -->



  <div class="container" style="max-width: 1800px">
    <div class="d-flex flex-row bd-highlight mb-3">
      <div class="p-2 bd-highlight">
        <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'add' ? 'active' : '' ?>" href="add.php" style="Text-decoration:none; color:white">新增商品 <i class="fa-solid fa-circle-plus"></i></a></button>
      </div>
      <div class="p-2 bd-highlight">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <<<<<<< HEAD <li class="page-item ">
              <a class="page-link" href="?page=1">
                <i class="fa-solid fa-angles-left"></i>
              </a>
              </li>
              <li class="page-item ">
                <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>">
                  <i class="fa-solid fa-angle-left"></i>
                </a>
                =======
                <!-- 前頁按鈕的功能 -->
              <li class="page-item">
                <a class="page-link" href="?page=1">
                  <i class="fa-solid fa-angles-left"></i></a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>"><i class="fa-solid fa-angle-left"></i></a>
                >>>>>>> origin/Joanne
              </li>
              <!-- 前頁按鈕的功能 -->
              <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                if ($i >= 1 and $i <= $totalPages) : ?>
                  <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                  </li>
              <?php endif;
              endfor; ?>
              <<<<<<< HEAD <li class="page-item ">
                <a class="page-link" href="?page=<?= $page <= $totalPages ? $page + 1 : '' ?>">
                  <i class="fa-solid fa-angle-right"></i>
                </a>
                </li>
                <li class="page-item ">
                  <a class="page-link" href="?page=<?= $totalPages ?>">
                    <i class="fa-solid fa-angles-right"></i>
                  </a>
                  =======
                  <!-- 後頁按鈕的功能 -->
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $page <= $totalPages ? $page + 1 : '' ?>"><i class="fa-solid fa-angle-right"></i></a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
                  >>>>>>> origin/Joanne
                </li>
                <!-- 後頁按鈕的功能 -->
          </ul>
        </nav>
      </div>
    </div>
    <!-- pagenation -->


    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-striped ">
          <thead>
            <tr style="vertical-align: middle; text-align: center">
              <th scope="col">方案編號</th>
              <th scope="col">保險名稱</th>
              <th scope="col">保險費用</th>
              <th scope="col">每年門診次數</th>
              <th scope="col">每年門診費用</th>
              <th scope="col">每年住院次數</th>
              <th scope="col">每次住院費用上限</th>
              <th scope="col">每年手術次數</th>
              <th scope="col">每次手術費用上限</th>
              <th scope="col">累積最高賠償限額 </th>
              <th scope="col">每一個人體傷責任</th>
              <th scope="col">每一意外事故體傷責任</th>
              <th scope="col">每一意外事故財物損失責任</th>
              <th scope="col">保險期間最高賠償金額</th>
              <th scope="col">寵物協尋廣告費</th>
              <th scope="col">被保人住院時寵物每日寄宿費</th>
              <th scope="col">寵物喪葬費保險</th>
              <th scope="col">寵物重取得費保險</th>
              <th scope="col">旅遊取消費用保險</th>
              <th scope="col">複製方案</th>
              <th scope="col">刪除方案</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r) : ?>
              <tr style="vertical-align: middle; text-align: center">
                <td><?= $r['insurance_product_id'] ?></td>
                <td><?= $r['insurance_name'] ?></td>
                <td><?= $r['insurance_fee'] ?></td>
                <td><?= $r['outpatient_clinic_time'] ?></td>
                <td><?= $r['outpatient_clinic_fee'] ?></td>
                <td><?= $r['Hospitalized_time'] ?></td>
                <td><?= $r['Hospitalized_fee'] ?></td>
                <td><?= $r['surgery_time'] ?></td>
                <td><?= $r['surgery_fee'] ?></td>
                <td><?= $r['max_compensation_of_medical_expense'] ?></td>
                <td><?= $r['personal_injury_liability'] ?></td>
                <td><?= $r['bodily_injury'] ?></td>
                <td><?= $r['property_damage'] ?></td>
                <td><?= $r['max_compensation_of_pet_tort'] ?></td>
                <td><?= $r['pet_search_advertising_expenses'] ?></td>
                <td><?= $r['pet_boarding_fee'] ?></td>
                <td><?= $r['pet_funeral_expenses'] ?></td>
                <td><?= $r['pet_reacquisition_cost'] ?></td>
                <td><?= $r['travel_cancellation_fee'] ?></td>
                <td class="text-center"><a href="add-copy.php?insurance_product_id=<?= $r['insurance_product_id'] ?>" class="btn btn-warning fa-solid fa-copy">
                  </a></td>

                <td class="text-center"><a href="javascript: deleteOne(<?= $r['insurance_product_id'] ?>)">
                    <!-- href="javascript: 假連結 -->
                    <button type="button" class="btn btn-danger fa-solid fa-trash-can"></button>
                  </a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>








  <?php include __DIR__ . '/../parts/scripts.php'; ?>
  <script>
    // 確認是否刪除
    const deleteOne = (insurance_product_id) => {
      if (confirm(`是否要刪除編號為 ${insurance_product_id} 的資料?`)) {
        location.href = `delete.php?insurance_product_id=${insurance_product_id}`;
      }
    }
  </script>
  <?php include __DIR__ . '/../parts/foot.php'; ?>