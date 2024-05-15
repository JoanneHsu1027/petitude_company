<?php
require __DIR__ . '/../b2bweb/admin-required.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "建立主題";
$pageName = 'add';

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

          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="class_name" class="form-label">主題名稱</label>
              <input type="text" class="form-control" id="class_name" name="class_name">
              <div class="form-text"></div>
            </div>
            <button type="submit" class="btn btn-primary">新增</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <a href="class.php"><i class="fa-solid fa-angles-left"></i>主題管理</a>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

        <button type="button" class="btn btn-primary" onclick="location.href='class.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>

  const nameField = document.form1.class_name;

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';

    let isPass = true;  // 表單有沒有通過檢查
    if (nameField.value.length < 2) {
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerText = '請填寫主題名稱';

    }

    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('class-add-api.php', {
        method: 'POST',
        body: fd, // Content-Type: multipart/form-data
      }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
          }
        })
        .catch(ex => console.log(ex))
    }

  };

  const myModal = new bootstrap.Modal('#staticBackdrop')

</script>
<?php include __DIR__ . '/../parts/foot.php' ?>