<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . './config/pdo-connect.php';
$title = "修改商品資料";
$pageName = 'product_imgs_edit';


$picture_id = isset($_GET['picture_id']) ? intval($_GET['picture_id']) : 0;
if ($picture_id < 1) {
  header('Location: product_imgs.php');
  exit;
}

$sql = "SELECT * FROM product_imgs WHERE picture_id={$picture_id}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
  header('Location: product_imgs.php');
  exit;
}



?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>
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
            <input type="hidden" name="picture_id" value="<?= $row['picture_id'] ?>">
            <div class="mb-3">
              <label for="picture_id" class="form-label">圖片編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['picture_id'] ?>">
            </div>

            <div class="mb-3">
              <label for="fk_product_id" class="form-label">對應商品編號</label>
              <input type="text" class="form-control" id="fk_product_id" name="fk_product_id" value="<?= $row['fk_product_id'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="picture_name" class="form-label">圖片名稱</label>
              <textarea class="form-control" id="picture_name" name="picture_name" cols="30" rows="3"><?= $row['picture_name'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="picture_url" class="form-label">圖片url</label>
              <input type="text" class="form-control" id="picture_url" name="picture_url" value="<?= $row['picture_url'] ?>">
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

        <button type="button" class="btn btn-primary" onclick="location.href='product_imgs.php'">到列表頁</button>
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

        <button type="button" class="btn btn-primary" onclick="location.href='product_imgs.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
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

      fetch('product_imgs_edit_api.php', {
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


<?php include __DIR__ . '/../parts/foot.php' ?>