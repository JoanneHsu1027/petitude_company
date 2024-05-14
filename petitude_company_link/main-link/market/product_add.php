<?php
require __DIR__ . '/../b2bweb/admin-required.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "新增商品資料";
$pageName = 'product_add';

?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>
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

        <div class="card-body" style="color:#0c5a67">
          <h5 class="card-title">新增商品資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱</label>
              <input type="text" class="form-control" id="product_name" name="product_name">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_description" class="form-label">商品敘述</label>
              <textarea class="form-control" id="product_description" name="product_description" cols="30" rows="2"></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_price" class="form-label">商品單價</label>
              <input type="text" class="form-control" id="product_price" name="product_price">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_quantity" class="form-label">商品庫存</label>
              <input type="text" class="form-control" id="product_quantity" name="product_quantity">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_category" class="form-label">商品分類</label>
              <input type="text" class="form-control" id="product_category" name="product_category">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="product_date" class="form-label">進貨日期</label>
              <input type="text" class="form-control" id="product_date" name="product_date">
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">新增</button>
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

        <button type="button" class="btn btn-primary" onclick="location.href='product.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
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

      fetch('product_add_api.php', {
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
<?php include __DIR__ . '/../parts/foot.php' ?>