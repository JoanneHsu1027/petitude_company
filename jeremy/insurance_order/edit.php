<?php
require __DIR__ . '/admin-required.php';

require __DIR__ . '/../config/pdo-connect.php';


$sid = isset($_GET['insurance_order_id']) ? intval($_GET['insurance_order_id']) : 0;
if ($sid < 1) {
  header('Location: order-list.php');
  exit;
}


// 從表單抓資料
$sql = "SELECT *, insurance_product.insurance_fee, city.city_name, county.county_name 
FROM insurance_order
JOIN insurance_product 
ON insurance_order.fk_insurance_product_id = insurance_product.insurance_product_id
JOIN county 
ON fk_county_id = county_id
JOIN city 
ON fk_city_id = city_id
WHERE insurance_order_id=$sid";
$row = $pdo->query($sql)->fetchAll();
if (empty($row)) {
  header('Location: order-list.php');
  exit;
}
// 從表單抓資料


// echo json_encode($row); 簡單檢查一下


// 把add的資料抓過來改
$title = "訂單編輯";

?>
<?php include __DIR__ . '/name-transfer.php'; ?>
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
    <div class="col-9">
      <div class="card ">
        <div class="card-body">
          <div class="text-center mb-3">
            <h4 class="card-title text-decoration-underline c-dark">修改表單資料</h4>
          </div>

          <form name="form1" onsubmit="sendData1(event)">
            <?php foreach ($row as $r) : ?>
              <div class="row">
                <div class="col-6">
                  <h4>基本資料</h4>
                  <label for="insurance_order_id" class="form-label">訂單編號</label>
                  <input type="text" class="form-control mb-3" id="insurance_order_id" name="insurance_order_id" value="<?= $r['insurance_order_id'] ?>" readonly>

                  <label for="fk_b2c_id" class="form-label">會員帳號</label>
                  <input type="text" class="form-control mb-3" id="fk_b2c_id" name="fk_b2c_id" value="<?= $r['fk_b2c_id'] ?>" readonly>

                  <label for="fk_pet_id" class="form-label">寵物帳號</label>
                  <input type="text" class="form-control mb-3" id="fk_pet_id" name="fk_pet_id" value="<?= $r['fk_pet_id'] ?>" readonly>

                  <label for="fk_insurance_product_id" class="form-label">保險商品代號</label>
                  <select class="form-select mb-3" id="fk_insurance_product_id" name="fk_insurance_product_id" readonly>
                    <option value="<?= $r['insurance_product_id'] ?>">
                      <?= $r['insurance_product_id'] ?> <?= $r['insurance_name'] ?>
                    </option>
                  </select>

                  <label for="insurance_fee" class="form-label">保險費用</label>
                  <input type="text" class="form-control mb-3" id="insurance_fee" name="insurance_fee" value="<?= $r['insurance_fee'] ?>" readonly>

                  <label for="payment_status" class="form-label">付款狀態</label>
                  <select class="form-select mb-3" id="payment_status" name="payment_status">
                    <option value="<?= $r['payment_status'] ?>"><?= $transfer[$r['payment_status']] ?></option>
                    <option value="<?= $r['payment_status'] ? 0 : 1 ?>"><?= $transfer[!$r['payment_status']] ?></option>
                  </select>

                  <label for="insurance_start_date" class="form-label">保險起始日期(YYYY-MM-DD)</label>
                  <input type="date" class="form-control mb-3" id="insurance_start_date" name="insurance_start_date" value="<?= $r['insurance_start_date'] ?>" readonly>
                </div>
                <div class="col-6">
                  <h4>聯絡資料</h4>
                  <label for="fk_county_id" class="form-label">居住縣市</label>
                  <select class="form-select mb-3" id="fk_county_id" name="fk_county_id" readonly>
                    <option value="<?= $r['fk_county_id'] ?>">
                      <?= $r['county_name'] ?>
                    </option>
                  </select>

                  <label for="fk_city_id" class="form-label">地址(鄉鎮區)</label>
                  <select class="form-select mb-3" id="fk_city_id" name="fk_city_id" readonly>
                    <option value="<?= $r['fk_city_id'] ?>">
                      <?= $r['city_name'] ?>
                    </option>
                  </select>

                  <label for="policyholder_address" class="form-label">地址</label>
                  <textarea type="text" class="form-control mb-3" id="policyholder_address" name="policyholder_address" cols="30" rows="5" readonly><?= $r['policyholder_address'] ?></textarea>

                  <label for="policyholder_mobile" class="form-label">手機號碼</label>
                  <input type="text" class="form-control mb-3" id="policyholder_mobile" name="policyholder_mobile" value="<?= $r['policyholder_mobile'] ?>" readonly>

                  <label for="policyholder_email" class="form-label">聯絡信箱</label>
                  <input type="text" class="form-control mb-3" id="policyholder_email" name="policyholder_email" value="<?= $r['policyholder_email'] ?>" readonly>

                  <label for="policyholder_IDcard" class="form-label">身分證字號</label>
                  <input type="text" class="form-control mb-3" id="policyholder_IDcard" name="policyholder_IDcard" value="<?= $r['policyholder_IDcard'] ?>" readonly>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="text-end">
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
        <a href="order-list.php" type="button" class="btn btn-primary">到列表頁</a>
        <!-- 權限設定後改去list.php -->
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
        <a href="order-list.php" type="button" class="btn btn-primary">到列表頁</a>
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
  const sendData1 = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出


    // TODO: 欄位資料檢查

    const fd = new FormData(document.form1); // 沒有外觀的表單物件
    let isPass = true; // 表單有沒有通過檢查
    // 檢驗姓名欄位
    // if (nameField.value.length < 2) {
    //   isPass = false;
    //   nameField.style.border = '1px solid red';
    //   nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    // }
    // 因為只有一個欄位所以用innerHTML或innerText都可以

    // 有通過檢查, 才要送表單

    if (isPass) {
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