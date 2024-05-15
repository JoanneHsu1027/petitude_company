<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';


$title = "新增保險商品";
$pageName = 'add';


if (!isset($_SESSION)) {
  session_start();
};

// 新增完成回到訂單表最後一頁時使用 start
$perPage = 15; # 每一頁最多有幾筆 注意要跟product-list-admin.php連動

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
<?php include __DIR__ . '/../page/html-header.php'; ?>
<?php include __DIR__ . '/../page/html-navbar.php'; ?>


<div class="container">
  <div class="row">
    <div class="col-9">
      <div class="card justify-">
        <div class="card-body">
          <div class="text-center mb-2">
            <h4 class="card-title text-decoration-underline c-dark">新增資料</h4>
          </div>

          <form name="form1" onsubmit="sendData(event)">
            <div class="">
              <div class="row justify-content-between">
                <div class="col-3">
                  <h4>寵物醫療</h4>
                  <label for="insurance_name" class="form-label">保險名稱</label>
                  <input type="text" class="form-control mb-2" id="insurance_name" name="insurance_name">
                  <div class="form-text"></div>

                  <label for="insurance_fee" class="form-label">保險費用</label>
                  <input type="number" class="form-control mb-2" id="insurance_fee" name="insurance_fee">
                  <div class="form-text"></div>

                  <label for="outpatient_clinic_time" class="form-label">每年門診次數</label>
                  <input type="number" class="form-control mb-2" id="outpatient_clinic_time" name="outpatient_clinic_time">
                  <div class="form-text"></div>

                  <label for="outpatient_clinic_fee" class="form-label">每年門診費用</label>
                  <input type="number" class="form-control mb-2" id="outpatient_clinic_fee" name="outpatient_clinic_fee">
                  <div class="form-text"></div>

                  <label for="hospitalized_time" class="form-label">每年住院次數</label>
                  <input type="number" class="form-control mb-2" id="hospitalized_time" name="hospitalized_time">
                  <div class="form-text"></div>

                  <label for="hospitalized_fee" class="form-label">每次住院費用上限</label>
                  <input type="number" class="form-control mb-2" id="hospitalized_fee" name="hospitalized_fee">
                  <div class="form-text"></div>

                  <label for="surgery_time" class="form-label">每年手術次數</label>
                  <input type="number" class="form-control mb-2" id="surgery_time" name="surgery_time">
                  <div class="form-text"></div>

                  <label for="surgery_fee" class="form-label">每次手術費用上限</label>
                  <input type="number" class="form-control mb-2" id="surgery_fee" name="surgery_fee">
                  <div class="form-text"></div>

                  <label for="max_compensation_of_medical_expense" class="form-label">累積最高賠償限額</label>
                  <input type="number" class="form-control mb-2" id="max_compensation_of_medical_expense" name="max_compensation_of_medical_expense">
                  <div class="form-text"></div>
                </div>

                <div class="col-3">
                  <h4>寵物侵權責任險</h4>
                  <label for="personal_injury_liability" class="form-label">每一個人體傷責任</label>
                  <input type="number" class="form-control mb-2" id="personal_injury_liability" name="personal_injury_liability">
                  <div class="form-text"></div>

                  <label for="bodily_injury" class="form-label">每一意外事故體傷責任</label>
                  <input type="number" class="form-control mb-2" id="bodily_injury" name="bodily_injury">
                  <div class="form-text"></div>

                  <label for="property_damage" class="form-label">每一意外事故財物損失責任</label>
                  <input type="number" class="form-control mb-2" id="property_damage" name="property_damage">
                  <div class="form-text"></div>

                  <label for="max_compensation_of_pet_tort" class="form-label">保險期間最高賠償金額</label>
                  <input type="number" class="form-control mb-2" id="max_compensation_of_pet_tort" name="max_compensation_of_pet_tort">
                  <div class="form-text"></div>



                </div>

                <div class="col-3">
                  <h4>其他保險</h4>
                  <label for="pet_search_advertising_expenses" class="form-label">寵物協尋廣告費</label>
                  <input type="number" class="form-control mb-2" id="pet_search_advertising_expenses" name="pet_search_advertising_expenses">
                  <div class="form-text"></div>

                  <label for="pet_boarding_fee" class="form-label">被保人住院期間寵物寄宿費每日</label>
                  <input type="number" class="form-control mb-2" id="pet_boarding_fee" name="pet_boarding_fee">
                  <div class="form-text"></div>

                  <label for="pet_funeral_expenses" class="form-label">寵物喪葬費保險</label>
                  <input type="number" class="form-control mb-2" id="pet_funeral_expenses" name="pet_funeral_expenses">
                  <div class="form-text"></div>

                  <label for="pet_reacquisition_cost" class="form-label">寵物重取得費保險</label>
                  <input type="number" class="form-control mb-2" id="pet_reacquisition_cost" name="pet_reacquisition_cost">
                  <div class="form-text"></div>

                  <label for="travel_cancellation_fee" class="form-label">旅遊取消費用保險</label>
                  <input type="number" class="form-control mb-2" id="travel_cancellation_fee" name="travel_cancellation_fee">
                  <div class="form-text"></div>



                </div>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-primary">新增</button>
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
        <a href="product-list.php?page=<?= $totalPages ?>" type="button" class="btn btn-primary">到列表頁</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../page/html-scripts.php'; ?>
<script>
  const nameField = document.form1.insurance_name;

  const sendData = e => {
    e.preventDefault();

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';

    let isPass = true;

    if (nameField.value.length < 2) {
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    }

    if (isPass) {
      const fd = new FormData(document.form1);
      fetch('add-api.php', {
          method: 'POST',
          body: fd,
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