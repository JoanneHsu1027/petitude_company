<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';
$title = "修改商品資料";
$pageName = 'product_edit';


$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($product_id < 1) {
  header('Location: product.php');
  exit;
}

$sql = "SELECT * FROM product WHERE product_id={$product_id}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: product.php');
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
<div class="container" style="color:#0c5a67">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">編輯商品資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
            <div class="mb-3">
              <label for="product_id" class="form-label">商品編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['product_id'] ?>">
            </div>
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱</label>
              <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $row['product_name'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_description" class="form-label">商品敘述</label>
              <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="3"><?= $row['product_description'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_price" class="form-label">商品單價</label>
              <input type="text" class="form-control" id="product_price" name="product_price" value="<?= $row['product_price'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_quantity" class="form-label">商品庫存</label>
              <input type="text" class="form-control" id="product_quantity" name="product_quantity" value="<?= $row['product_quantity'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_category" class="form-label">商品分類</label>
              <input type="text" class="form-control" id="product_category" name="product_category" value="<?= $row['product_category'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_date" class="form-label">進貨日期</label>
              <input type="text" class="form-control" id="product_date" name="product_date" value="<?= $row['product_date'] ?>">
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">修改</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal 1 -->
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

        <button type="button" class="btn btn-primary" onclick="location.href='product.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal 2-->
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

        <button type="button" class="btn btn-primary" onclick="location.href='product.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
  // const nameField = document.form1.name;
  // const emailField = document.form1.recipient_email;

  // function validateEmail(recipient_email) {
  //   const re =
  //     /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  //   return re.test(recipient_email);
  // }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    // nameField.style.border = '1px solid #CCCCCC';
    // nameField.nextElementSibling.innerText = '';
    // emailField.style.border = '1px solid #CCCCCC';
    // emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true; // 表單有沒有通過檢查
    // if (nameField.value.length < 2) {
    //   isPass = false;
    //   nameField.style.border = '1px solid red';
    //   nameField.nextElementSibling.innerText = '請填寫正確的姓名';

    // }
    // if (!validateEmail(emailField.value)) {
    //   isPass = false;
    //   emailField.style.border = '1px solid red';
    //   emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    // }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch('product_edit_api.php', {
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