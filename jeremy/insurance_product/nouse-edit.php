<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$sid = isset($_GET['insurance_product_id']) ? intval($_GET['insurance_product_id']) : 0;
if ($sid < 1) {
  header('Location: product-lis.php');
  exit;
}

$sql = "SELECT * FROM insurance_product WHERE insurance_product_id=$sid";
$pdo->query($sql);

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: product-lis.php');
  exit;
}

// echo json_encode($row); 簡單檢查一下


// 把add的資料抓過來改
$title = "修改商品表資料";

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
          <h5 class="card-title">修改資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <!-- 設定name和設定onsubmit -->

            <div class="mb-3">
              <label for="insurance_product_id" class="form-label">商品編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['insurance_product_id'] ?>">
            </div>
            <!-- 需要id才能知道要修改哪筆, 想讓用戶看到又不想讓他修改這個資料 -->
            <label for="insurance_name" class="form-label">保險名稱</label>
            <input type="text" class="form-control mb-3" id="insurance_name" name="insurance_name" value="">
            <div class="form-text"></div>

            <label for="insurance_fee" class="form-label">保險費用</label>
            <input type="text" class="form-control mb-3" id="insurance_fee" name="insurance_fee">
            <div class="form-text"></div>

            <label for="outpatient_clinic_time" class="form-label">每年門診次數</label>
            <input type="text" class="form-control mb-3" id="outpatient_clinic_time" name="outpatient_clinic_time">
            <div class="form-text"></div>

            <label for="outpatient_clinic_fee" class="form-label">每年門診費用</label>
            <input type="text" class="form-control mb-3" id="outpatient_clinic_fee" name="outpatient_clinic_fee">
            <div class="form-text"></div>

            <label for="hospitalized_time" class="form-label">每年住院次數</label>
            <input type="text" class="form-control mb-3" id="hospitalized_time" name="hospitalized_time">
            <div class="form-text"></div>

            <label for="hospitalized_fee" class="form-label">每次住院費用上限</label>
            <input type="text" class="form-control mb-3" id="hospitalized_fee" name="hospitalized_fee">
            <div class="form-text"></div>

            <label for="surgery_time" class="form-label">每年手術次數</label>
            <input type="text" class="form-control mb-3" id="surgery_time" name="surgery_time">
            <div class="form-text"></div>

            <label for="surgery_fee" class="form-label">每次手術費用上限</label>
            <input type="text" class="form-control mb-3" id="surgery_fee" name="surgery_fee">
            <div class="form-text"></div>

            <label for="max_compensation_of_medical_expense" class="form-label">累積最高賠償限額</label>
            <input type="text" class="form-control mb-3" id="max_compensation_of_medical_expense" name="max_compensation_of_medical_expense">
            <div class="form-text"></div>

            <label for="personal_injury_liability" class="form-label">每一個人體傷責任</label>
            <input type="text" class="form-control mb-3" id="personal_injury_liability" name="personal_injury_liability">
            <div class="form-text"></div>

            <label for="bodily_injury" class="form-label">每一意外事故體傷責任</label>
            <input type="text" class="form-control mb-3" id="bodily_injury" name="bodily_injury">
            <div class="form-text"></div>

            <label for="property_damage" class="form-label">每一意外事故財物損失責任</label>
            <input type="text" class="form-control mb-3" id="property_damage" name="property_damage">
            <div class="form-text"></div>

            <label for="max_compensation_of_pet_tort" class="form-label">保險期間最高賠償金額</label>
            <input type="text" class="form-control mb-3" id="max_compensation_of_pet_tort" name="max_compensation_of_pet_tort">
            <div class="form-text"></div>

            <label for="pet_search_advertising_expenses" class="form-label">寵物協尋廣告費</label>
            <input type="text" class="form-control mb-3" id="pet_search_advertising_expenses" name="pet_search_advertising_expenses">
            <div class="form-text"></div>

            <label for="pet_boarding_fee" class="form-label">被保人住院期間寵物寄宿費每日</label>
            <input type="text" class="form-control mb-3" id="pet_boarding_fee" name="pet_boarding_fee">
            <div class="form-text"></div>

            <label for="pet_funeral_expenses" class="form-label">寵物喪葬費保險</label>
            <input type="text" class="form-control mb-3" id="pet_funeral_expenses" name="pet_funeral_expenses">
            <div class="form-text"></div>

            <label for="pet_reacquisition_cost" class="form-label">寵物重取得費保險</label>
            <input type="text" class="form-control mb-3" id="pet_reacquisition_cost" name="pet_reacquisition_cost">
            <div class="form-text"></div>

            <label for="travel_cancellation_fee" class="form-label">旅遊取消費用保險</label>
            <input type="text" class="form-control mb-3" id="travel_cancellation_fee" name="travel_cancellation_fee">
            <div class="form-text"></div>

            <button type="submit" class="btn btn-primary">修改</button>
        </div>
        </form>

      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal 提示修改成功-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">修改成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button> -->
        <!-- 這邊用onclick設定位址, 也可用a -->
        <a href="product-list-admin.php" type="button" class="btn btn-primary">到列表頁</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- Modal 2 提示修改失敗-->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel2">沒有修改資料</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          沒有修改資料
        </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button> -->
        <!-- 這邊用onclick設定位址, 也可用a -->
        <a href="product-list-admin.php" type="button" class="btn btn-primary">到列表頁</a>
        <!-- 確認權限設定後來改 -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal 2 -->

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
      fetch('edit-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            myModal2.show();
          }
        })
        .catch(ex => console.log(ex))
    }

  };
  const myModal = new bootstrap.Modal('#staticBackdrop')
  const myModal2 = new bootstrap.Modal('#staticBackdrop2')
</script>

<?php include __DIR__ . '/../page/html-footer.php'; ?>