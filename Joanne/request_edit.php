<?php
// require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';
$title = "修改訂單資料";
$pageName = 'request_edit';


$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
if ($request_id < 1) {
  header('Location: request.php');
  exit;
}

$sql = "SELECT * FROM request WHERE request_id={$request_id}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: request.php');
  exit;
}



?>
<?php include __DIR__ . './parts/head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>
<style>
  form .mb-3 .form-text {
    color: red;
    font-weight: 800;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">編輯訂單資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
            <div class="mb-3">
              <label for="request_id" class="form-label">訂單編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['request_id'] ?>">
            </div>
            <div class="mb-3">
              <label for="request_date" class="form-label">訂單日期</label>
              <input type="text" class="form-control" id="request_date" name="request_date" value="<?= $row['request_date'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="request_status" class="form-label">訂單狀態</label>
              <input type="text" class="form-control" id="request_status" name="request_status" value="<?= $row['request_status'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="payment_status" class="form-label">付款狀態</label>
              <input type="text" class="form-control" id="payment_status" name="payment_status" value="<?= $row['payment_status'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_b2c_id" class="form-label">會員編號</label>
              <input type="text" class="form-control" id="fk_b2c_id" name="fk_b2c_id" value="<?= $row['fk_b2c_id'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="request_price" class="form-label">訂單總價</label>
              <input type="text" class="form-control" id="request_price" name="request_price" value="<?= $row['request_price'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_county_id" class="form-label">寄送地址(縣市)</label>
              <input type="text" class="form-control" id="fk_county_id" name="fk_county_id" value="<?= $row['fk_county_id'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_city_id" class="form-label">寄送地址(鄉鎮市區)</label>
              <input type="text" class="form-control" id="fk_city_id" name="fk_city_id" value="<?= $row['fk_city_id'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">寄送地址(詳細)</label>

              <textarea class="form-control" id="address" name="address" cols="30" rows="3"><?= $row['recipient_address'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="mobile" class="form-label">連絡電話</label>
              <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $row['recipient_mobile'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">電子信箱</label>
              <input type="text" class="form-control" id="email" name="email" value="<?= $row['recipient_email'] ?>">
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">修改</button>
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">修改成功</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='./request.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel2">資料沒有修改</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="location.href='./request.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
  const nameField = document.form1.name;
  const emailField = document.form1.email;

  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true; // 表單有沒有通過檢查
    // if (nameField.value.length < 2) {
    //   isPass = false;
    //   nameField.style.border = '1px solid red';
    //   nameField.nextElementSibling.innerText = '請填寫正確的姓名';

    // }
    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch('request_edit_api.php', {
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
<?php include __DIR__ . './parts/foot.php' ?>