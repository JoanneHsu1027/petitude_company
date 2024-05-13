<?php
// require __DIR__ . '/admin-required.php';
// 驗證的先註解掉
require __DIR__ . '/../config/pdo-connect.php';

$sid = isset($_GET['insurance_order_id']) ? intval($_GET['insurance_order_id']) : 0;
if ($sid < 1) {
  header('Location: order-list-admin.php');
  // 等權限設定後再來改
  exit;
}

// 從表單抓資料原始
// $sql = "SELECT * FROM insurance_order WHERE insurance_order_id=$sid";
// $row = $pdo->query($sql)->fetchAll();
// if (empty($row)) {
//   header('Location: order-list-admin.php');
//   // 等權限設定後再來改
//   exit;
// }
// 從表單抓資料原始

// 從表單抓資料測試
$sql = "SELECT *, insurance_product.insurance_fee 
FROM insurance_order
JOIN insurance_product
ON insurance_order.fk_insurance_product_id = insurance_product.insurance_product_id
 WHERE insurance_order_id=$sid";
$row = $pdo->query($sql)->fetchAll();
if (empty($row)) {
  header('Location: order-list-admin.php');
  // 等權限設定後再來改
  exit;
}
// 從表單抓資料測試


// echo json_encode($row); 簡單檢查一下


// 把add的資料抓過來改
$title = "訂單編輯";

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
              <label for="fk_b2c_id" class="form-label">會員帳號</label>
              <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="fk_b2c_id" name="fk_b2c_id" value="<?= $r['fk_b2c_id'] ?>" placeholder="<?= $r['fk_b2c_id'] ?>" disabled>
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="fk_pet_id" class="form-label">寵物帳號</label>
              <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="fk_pet_id" name="fk_pet_id" value="<?= $r['fk_pet_id'] ?>" placeholder="<?= $r['fk_pet_id'] ?>" disabled>
              <?php endforeach; ?>
              <div class="form-text"></div>

              <label for="fk_insurance_product_id" class="form-label">保險商品代號</label>
              <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="fk_insurance_product_id" name="fk_insurance_product_id" disabled value="<?= $r['fk_insurance_product_id'] ?>" placeholder="<?= $r['fk_insurance_product_id'] ?>">
                <!-- placeholder 中還想放'fk_insurance_product_name', 一直出錯, 先跳過 -->
              <?php endforeach; ?>
              <div class="form-text"></div>


              <label for="insurance_fee" class="form-label">保險費用</label>
              <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="insurance_fee" name="insurance_fee" value="<?= $r['insurance_fee'] ?>" placeholder="<?= $r['insurance_fee'] ?>" disabled>
              <?php endforeach; ?>
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
          訂單修改成功
        </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button> -->
        <!-- 這邊用onclick設定位址, 也可用a -->
        <a href="list.php" type="button" class="btn btn-primary">到列表頁</a>
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
        <a href="order-list-admin.php" type="button" class="btn btn-primary">到列表頁</a>
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