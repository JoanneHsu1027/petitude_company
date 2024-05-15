<?php
require __DIR__. '/admin-required.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "新增內部員工資料";
$pageName = 'b2b-add';

?>
<?php
$jobs = ["--請選擇職位--",
"老闆", "經理", "業務主管", "會計", "業務"];

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

        <div class="card-body text-dark">
          <h5 class="card-title">新增員工資料</h5>
          <form name="form1" onsubmit="sendData(event)">

            <div class="mb-3">
              <label for="b2b_name" class="form-label">姓名</label>
              <input type="text" class="form-control" id="b2b_name" name="b2b_name">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2b_account" class="form-label">員工帳號</label>
              <input type="text" class="form-control" id="b2b_account" name="b2b_account">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2b_password" class="form-label">員工密碼</label>
              <input type="text" class="form-control" id="b2b_password" name="b2b_password">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2b_email" class="form-label">Email</label>
              <input type="text" class="form-control" id="b2b_email" name="b2b_email">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2b_mobile" class="form-label">手機</label>
              <input type="text" class="form-control" id="b2b_mobile" name="b2b_mobile">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_b2b_job_id" class="form-label">職位</label>
              <select id="fk_b2b_job_id" name="fk_b2b_job_id" class="form-select mb-2">
                <?php
                for ($i = 0; $i <= 5; $i++) {
                ?>
                  <option value="<?php echo $i; ?>"><?php echo $jobs[$i]; ?></option>
                <?php
                }
                ?>
              </select>
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

        <button type="button" class="btn btn-primary" onclick="location.href='b2b_list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
  const nameField = document.form1.b2b_name;
  const emailField = document.form1.b2b_email;

  function validateEmail(b2b_email) {
    const re_email =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re_email.test(b2b_email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true; // 表單有沒有通過檢查
    if (nameField.value.length < 2) {
      console.log('請填寫正確的名稱')
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerText = '請填寫正確的姓名';
    }
    // }
    if (!validateEmail(emailField.value)) {
      isPass = false;
      console.log('請填寫正確的email')
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch('b2b-add-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          }
        })
        .catch(ex => console.log(ex))
    }
  };

  const myModal = new bootstrap.Modal('#staticBackdrop')
</script>




<?php include __DIR__ . '/../parts/foot.php' ?>