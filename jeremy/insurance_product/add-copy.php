<?php
// require __DIR__ . '/admin-required.php';
// 驗證的先註解掉
require __DIR__ . '/../config/pdo-connect.php';

$title = "新增保險商品";
$pageName = 'add';


if (!isset($_SESSION)) {
  session_start();
};

$sid = isset($_GET['insurance_product_id']) ? intval($_GET['insurance_product_id']) : 0;
if ($sid < 1) {
  header('Location: product-list-admin.php');
  // 等權限設定後再來改
  exit;
}

// 從表單抓資料
$sql = "SELECT * FROM insurance_product
WHERE insurance_product_id=$sid";
$row = $pdo->query($sql)->fetchAll();
if (empty($row)) {
  header('Location: order-list-admin.php');
  // 等權限設定後再來改
  exit;
}
// 從表單抓資料
?>
<?php include __DIR__ . '/../page/html-header.php'; ?>
<?php include __DIR__ . '/../page/html-navbar.php'; ?>

<style>
  form .mb-3 .form-text {
    color: red;
    font-weight: 800;
  }
</style>

<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card" style="width: 18rem;">

        <div class="card-body">
          <h5 class="card-title">新增保單</h5>
          <form name="form1" onsubmit="sendData(event)">
            <!-- 設定name和設定onsubmit -->
            <div class="mb-3">
              <label for="insurance_name" class="form-label">保險名稱</label>
              <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="insurance_name" name="insurance_name" value="<?= $r['insurance_name'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="insurance_fee" class="form-label">保險費用</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="insurance_fee" name="insurance_fee" value="<?= $r['insurance_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="outpatient_clinic_time" class="form-label">每年門診次數</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="outpatient_clinic_time" name="outpatient_clinic_time" value="<?= $r['outpatient_clinic_time'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="outpatient_clinic_fee" class="form-label">每年門診費用</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="outpatient_clinic_fee" name="outpatient_clinic_fee" value="<?= $r['outpatient_clinic_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="hospitalized_time" class="form-label">每年住院次數</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="hospitalized_time" name="hospitalized_time" value="<?= $r['hospitalized_time'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="hospitalized_fee" class="form-label">每次住院費用上限</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="hospitalized_fee" name="hospitalized_fee" value="<?= $r['hospitalized_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="surgery_time" class="form-label">每年手術次數</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="surgery_time" name="surgery_time" value="<?= $r['surgery_time'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="surgery_fee" class="form-label">每次手術費用上限</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="surgery_fee" name="surgery_fee" value="<?= $r['surgery_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="max_compensation_of_medical_expense" class="form-label">累積最高賠償限額</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="max_compensation_of_medical_expense" name="max_compensation_of_medical_expense" value="<?= $r['max_compensation_of_medical_expense'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="personal_injury_liability" class="form-label">每一個人體傷責任</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="personal_injury_liability" name="personal_injury_liability" value="<?= $r['personal_injury_liability'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="bodily_injury" class="form-label">每一意外事故體傷責任</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="bodily_injury" name="bodily_injury" value="<?= $r['bodily_injury'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="property_damage" class="form-label">每一意外事故財物損失責任</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="property_damage" name="property_damage" value="<?= $r['property_damage'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="max_compensation_of_pet_tort" class="form-label">保險期間最高賠償金額</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="max_compensation_of_pet_tort" name="max_compensation_of_pet_tort" value="<?= $r['max_compensation_of_pet_tort'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="pet_search_advertising_expenses" class="form-label">寵物協尋廣告費</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="pet_search_advertising_expenses" name="pet_search_advertising_expenses" value="<?= $r['pet_search_advertising_expenses'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="pet_boarding_fee" class="form-label">被保人住院期間寵物寄宿費每日</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="pet_boarding_fee" name="pet_boarding_fee" value="<?= $r['pet_boarding_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="pet_funeral_expenses" class="form-label">寵物喪葬費保險</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="pet_funeral_expenses" name="pet_funeral_expenses" value="<?= $r['pet_funeral_expenses'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="pet_reacquisition_cost" class="form-label">寵物重取得費保險</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="pet_reacquisition_cost" name="pet_reacquisition_cost" value="<?= $r['pet_reacquisition_cost'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="travel_cancellation_fee" class="form-label">旅遊取消費用保險</label>
              <?php foreach ($row as $r) : ?>
                <input type="number" class="form-control mb-3" id="travel_cancellation_fee" name="travel_cancellation_fee" value="<?= $r['travel_cancellation_fee'] ?>">
              <?php endforeach; ?>
              <div class="form-text"></div>

              <button type="submit" class="btn btn-primary">新增</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">新增成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button> -->
        <!-- 這邊用onclick設定位址, 也可用a -->
        <a href="product-list-admin.php" type="button" class="btn btn-primary">到列表頁</a>
        <!-- 確認權限設定後來改 -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include __DIR__ . '/../page/html-scripts.php'; ?>
<!-- 新的js需要寫在原本掛的js下方 -->
<script>
  const nameField = document.form1.insurance_name;


  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';


    // TODO: 欄位資料檢查

    const fd = new FormData(document.form1); // 沒有外觀的表單物件
    let isPass = true; // 表單有沒有通過檢查
    // 檢驗姓名欄位
    if (nameField.value.length < 2) {
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    }
    // 因為只有一個欄位所以用innerHTML或innerText都可以

    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件
      fetch('add-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {}
        })
        .catch(ex => console.log(ex))
    }

  };
  const myModal = new bootstrap.Modal('#staticBackdrop')
</script>

<?php include __DIR__ . '/../page/html-footer.php'; ?>