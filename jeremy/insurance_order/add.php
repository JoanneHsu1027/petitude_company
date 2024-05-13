<?php
// require __DIR__ . '/admin-required.php';
// 權限確認用先註掉

$title = "新增保險訂單";
$pageName = 'add';


if (!isset($_SESSION)) {
  session_start();
};

// 保險商品代號選擇使用 start
require __DIR__ . '/../config/pdo-connect.php';
$product_sql = "SELECT * FROM insurance_product";
$product_row = $pdo->query($product_sql)->fetchAll();
// 保險商品代號選擇使用 end

// 地址(縣市)代號選擇使用 start
require __DIR__ . '/../config/pdo-connect.php';
$county_sql = "SELECT * FROM county";
$county_row = $pdo->query($county_sql)->fetchAll();
// 地址(縣市)代號選擇使用 end

// 地址(鄉鎮區)代號選擇使用 start
require __DIR__ . '/../config/pdo-connect.php';
$city_sql = "SELECT * FROM city";
$city_row = $pdo->query($city_sql)->fetchAll();
// 地址(鄉鎮區)代號選擇使用 end

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
              <label for="fk_b2c_id" class="form-label">會員帳號</label>
              <input type="text" class="form-control mb-3" id="fk_b2c_id" name="fk_b2c_id">
              <div class="form-text"></div>

              <label for="fk_pet_id" class="form-label">寵物帳號</label>
              <input type="text" class="form-control mb-3" id="fk_pet_id" name="fk_pet_id">
              <div class="form-text"></div>

              <label for="fk_insurance_product_id" class="form-label">保險商品代號</label>
              <select class="form-select mb-3" id="fk_insurance_product_id" name="fk_insurance_product_id">
                <option value="" selected disabled>請選擇商品代號</option>
                <?php foreach ($product_row as $r) : ?>
                  <option value="<?= $r['insurance_product_id'] ?>"><?= $r['insurance_product_id'] ?> <?= $r['insurance_name'] ?></option>
                <?php endforeach; ?>
                <div class="form-text"></div>
              </select>

              <label for="insurance_fee" class="form-label">保險費用</label>
              <input type="text" class="form-control mb-3" id="insurance_fee" name="insurance_fee">
              <div class="form-text"></div>


              <label for="payment_status" class="form-label">付款狀態</label>
              <div class="dropdown mb-3">
                <select class="form-select" id="payment_status" name="payment_status">
                  <option value="0" selected>未付款</option>
                  <option value="1">已付款</option>
                </select>
              </div>
              <div class="form-text"></div>

              <label for="insurance_start_date" class="form-label">保險起始日期(YYYY-MM-DD)</label>
              <input type="date" class="form-control mb-3" id="insurance_start_date" name="insurance_start_date">
              <div class="form-text"></div>

              <label for="county_name" class="form-label">地址(縣市)</label>
              <select class="form-select mb-3 " id="county_name" name="county_name">
                <option value="" selected disabled>請選擇縣市</option>
                <?php foreach ($county_row as $c) : ?>
                  <option value="<?= $c['county_id'] ?>"><?= $c['county_name'] ?></option>
                <?php endforeach; ?>
                <div class="form-text"></div>
              </select>

              <label for="city_name" class="form-label">地址(鄉鎮區)</label>
              <select class="form-select mb-3 " id="city_name" name="city_name">
                <option value="" selected disabled>請選擇鄉鎮區</option>
                <?php foreach ($city_row as $ci) : ?>
                  <option value="<?= $ci['city_id'] ?>"><?= $ci['city_name'] ?></option>
                <?php endforeach; ?>
                <div class="form-text"></div>
              </select>


              <label for="policyholder_address" class="form-label">地址</label>
              <textarea class="form-control mb-3" name="policyholder_address" id="policyholder_address" cols="30" rows="5"></textarea>
              <div class="form-text"></div>

              <label for="policyholder_mobile" class="form-label">手機號碼</label>
              <input type="text" class="form-control mb-3" id="policyholder_mobile" name="policyholder_mobile">
              <div class="form-text"></div>

              <label for="policyholder_email" class="form-label">聯絡信箱</label>
              <input type="text" class="form-control mb-3" id="policyholder_email" name="policyholder_email">
              <div class="form-text"></div>

              <label for="policyholder_IDcard" class="form-label">身分證字號</label>
              <input type="text" class="form-control mb-3" id="policyholder_IDcard" name="policyholder_IDcard">
              <div class="form-text"></div>



              <button type="submit" class="btn btn-primary">送出新增</button>
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
          訂單新增成功
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
  const nameField = document.form1.fk_b2c_id;


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