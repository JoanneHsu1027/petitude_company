<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = "新增保險商品";
$pageName = 'add';


if (!isset($_SESSION)) {
  session_start();
};

$sid = isset($_GET['insurance_product_id']) ? intval($_GET['insurance_product_id']) : 0;
if ($sid < 1) {
  header('Location: product-list.php');
  exit;
}

// 從表單抓資料
$sql = "SELECT * FROM insurance_product
WHERE insurance_product_id=$sid";
$row = $pdo->query($sql)->fetchAll();
if (empty($row)) {
  header('Location: order-list.php');
  exit;
}
// 從表單抓資料

// 新增完成回到訂單表最後一頁時使用 start
$perPage = 15; # 每一頁最多有幾筆 注意要跟order-list-admin.php連動

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(insurance_product_id) FROM insurance_product";

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
}

// 新增完成回到訂單表最後一頁時使用 end
?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>

<style>
  form .mb-3 .form-text {
    color: red;
    font-weight: 800;
  }
</style>


<div class="container" style="padding-top: 8px;">
  <div class="row">
    <div class="col-9">
      <div class="card" style="margin-top: 0;">
        <div class="card-body" style="color:#0c5a67">
          <div class="text-center mb-3">
            <h4 class="card-title text-decoration-underline c-dark">新增資料</h4>
          </div>

          <form name="form1" onsubmit="sendData(event)">
            <?php foreach ($row as $r) : ?>
              <div class="">
                <div class="row justify-content-between">
                  <div class="col-3">
                    <h4>寵物醫療</h4>
                    <label for="insurance_name" class="form-label">保險名稱</label>
                    <input type="text" class="form-control mb-2" id="insurance_name" name="insurance_name" value="<?= $r['insurance_name'] ?>">
                    <div class="form-text"></div>

                    <label for="insurance_fee" class="form-label">保險費用</label>
                    <input type="number" class="form-control mb-2" id="insurance_fee" name="insurance_fee" value="<?= $r['insurance_fee'] ?>">
                    <div class="form-text"></div>

                    <label for="outpatient_clinic_time" class="form-label">每年門診次數</label>
                    <input type="number" class="form-control mb-2" id="outpatient_clinic_time" name="outpatient_clinic_time" value="<?= $r['outpatient_clinic_time'] ?>">
                    <div class="form-text"></div>

                    <label for="outpatient_clinic_fee" class="form-label">每年門診費用</label>
                    <input type="number" class="form-control mb-2" id="outpatient_clinic_fee" name="outpatient_clinic_fee" value="<?= $r['outpatient_clinic_fee'] ?>">
                    <div class="form-text"></div>

                    <label for="hospitalized_time" class="form-label">每年住院次數</label>
                    <input type="number" class="form-control mb-2" id="hospitalized_time" name="hospitalized_time" value="<?= $r['Hospitalized_time'] ?>">
                    <div class="form-text"></div>

                    <label for="hospitalized_fee" class="form-label">每次住院費用上限</label>
                    <input type="number" class="form-control mb-2" id="hospitalized_fee" name="hospitalized_fee" value="<?= $r['Hospitalized_fee'] ?>">
                    <div class="form-text"></div>

                    <label for="surgery_time" class="form-label">每年手術次數</label>
                    <input type="number" class="form-control mb-2" id="surgery_time" name="surgery_time" value="<?= $r['surgery_time'] ?>">
                    <div class="form-text"></div>

                    <label for="surgery_fee" class="form-label">每次手術費用上限</label>
                    <input type="number" class="form-control mb-2" id="surgery_fee" name="surgery_fee" value="<?= $r['surgery_fee'] ?>">
                    <div class="form-text"></div>

                    <label for="max_compensation_of_medical_expense" class="form-label">累積最高賠償限額</label>
                    <input type="number" class="form-control mb-2" id="max_compensation_of_medical_expense" name="max_compensation_of_medical_expense" value="<?= $r['max_compensation_of_medical_expense'] ?>">
                    <div class="form-text"></div>
                  </div>

                  <div class="col-3">
                    <h4>寵物侵權責任險</h4>
                    <label for="personal_injury_liability" class="form-label">每一個人體傷責任</label>
                    <input type="number" class="form-control mb-2" id="personal_injury_liability" name="personal_injury_liability" value="<?= $r['personal_injury_liability'] ?>">
                    <div class="form-text"></div>

                    <label for="bodily_injury" class="form-label">每一意外事故體傷責任</label>
                    <input type="number" class="form-control mb-2" id="bodily_injury" name="bodily_injury" value="<?= $r['bodily_injury'] ?>">
                    <div class="form-text"></div>

                    <label for="property_damage" class="form-label">每一意外事故財物損失責任</label>
                    <input type="number" class="form-control mb-2" id="property_damage" name="property_damage" value="<?= $r['property_damage'] ?>">
                    <div class="form-text"></div>

                    <label for="max_compensation_of_pet_tort" class="form-label">保險期間最高賠償金額</label>
                    <input type="number" class="form-control mb-2" id="max_compensation_of_pet_tort" name="max_compensation_of_pet_tort" value="<?= $r['max_compensation_of_pet_tort'] ?>">
                    <div class="form-text"></div>



                  </div>

                  <div class="col-3">
                    <h4>其他保險</h4>
                    <label for="pet_search_advertising_expenses" class="form-label">寵物協尋廣告費</label>
                    <input type="number" class="form-control mb-2" id="pet_search_advertising_expenses" name="pet_search_advertising_expenses" value="<?= $r['pet_search_advertising_expenses'] ?>">
                    <div class="form-text"></div>

                    <label for="pet_boarding_fee" class="form-label">被保人住院時寵物每日寄宿費</label>
                    <input type="number" class="form-control mb-2" id="pet_boarding_fee" name="pet_boarding_fee" value="<?= $r['pet_boarding_fee'] ?>">
                    <div class="form-text"></div>

                    <label for="pet_funeral_expenses" class="form-label">寵物喪葬費保險</label>
                    <input type="number" class="form-control mb-2" id="pet_funeral_expenses" name="pet_funeral_expenses" value="<?= $r['pet_funeral_expenses'] ?>">
                    <div class="form-text"></div>

                    <label for="pet_reacquisition_cost" class="form-label">寵物重取得費保險</label>
                    <input type="number" class="form-control mb-2" id="pet_reacquisition_cost" name="pet_reacquisition_cost" value="<?= $r['pet_reacquisition_cost'] ?>">
                    <div class="form-text"></div>

                    <label for="travel_cancellation_fee" class="form-label">旅遊取消費用保險</label>
                    <input type="number" class="form-control mb-2" id="travel_cancellation_fee" name="travel_cancellation_fee" value="<?= $r['travel_cancellation_fee'] ?>">
                    <div class="form-text"></div>

                  <?php endforeach; ?>
                  <div class="text-end" style="margin-top: 270px;">
                    <button type="submit" class="btn btn-primary">新增</button>
                  </div>


                  </div>
                </div>


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
        <a href="product-list.php?page=<?= $totalPages ?>" type="button" class="btn btn-primary">到列表頁</a>
        <!-- 必須到list , 不能去admin -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include __DIR__ . '/../parts/scripts.php'; ?>
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

<?php include __DIR__ . '/../parts/foot.php'; ?>