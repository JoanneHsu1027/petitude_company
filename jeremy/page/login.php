<?php
$title = "登入";
$pageName = 'login';

if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['admin'])) {
  header('Location: index_.php');
  exit;
};


?>
<?php include __DIR__ . '/../page/html-header.php'; ?>
<?php include __DIR__ . '/../page/html-navbar.php';  ?>

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
          <h5 class="card-title">登入</h5>
          <form name="form1" onsubmit="sendData(event)">
            <!-- 設定name和設定onsubmit -->
            <label for="b2b_email" class="form-label">信箱</label>
            <input type="text" class="form-control mb-3" id="b2b_email" name="b2b_email">

            <label for="b2b_password" class="form-label">密碼</label>
            <input type="password" class="form-control mb-3" id="b2b_password" name="b2b_password">

            <button type="submit" class="btn btn-primary">登入</button>
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">登入失敗</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          帳號或密碼不正確,請重新確認
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續登入</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include __DIR__ . '/parts/html-scripts.php'; ?>
<!-- 新的js需要寫在原本掛的js下方 -->
<script>
  const emailField = document.form1.email;

  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出
    const fd = new FormData(document.form1); // 沒有外觀的表單物件
    fetch('login-api.php', {
        method: 'POST',
        body: fd, // Content-Type: multipart/form-data
      }).then(r => r.json())
      .then(data => {
        console.log(data);
        if (data.success) {
          location.href = 'index_.php';
        } else {
          myModal.show();
        }
      })
      .catch(ex => console.log(ex))
  }
  const myModal = new bootstrap.Modal('#staticBackdrop')
</script>

<?php include __DIR__ . '/../page/html-footer.php'; ?>