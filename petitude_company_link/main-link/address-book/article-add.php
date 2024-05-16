<?php
require __DIR__ . '/../config/pdo-connect.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "建立文章";
$pageName = 'add';
$class_sql = "SELECT * FROM class";
$stmt = $pdo->query($class_sql);
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
          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="class_id" class="form-label">文章分類</label>
              <select class="form-select" id="class_id" name="class_id">
                <option value="">--請選擇文章分類--</option>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                  <option value="<?= $row['class_id'] ?>"><?= $row['class_name'] ?></option>
                <?php endwhile; ?>
              </select>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="article_name" class="form-label">文章名稱</label>
              <input type="text" class="form-control" id="article_name" name="article_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="article_content" class="form-label">文章內容</label>
              <input type="text" class="form-control" id="article_content" name="article_content">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="article_img[]" class="form-label">文章圖片</label><br>
              <form method="post" action="upload-articleImg-api.php" enctype="multipart/form-data">
                <input type="file" name="article_img[]" class="form-control" accept="image/*" multiple />
            </div>
            <button type="submit" class="btn btn-primary">新增</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <a href="article.php"><i class="fa-solid fa-angles-left"></i>文章列表</a>
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
        <button type="button" class="btn btn-primary" onclick="location.href='article.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
  const sendData = e => {
    e.preventDefault(); // 防止表單自動提交
    const form = document.form1;
    const nameField = form.article_name;
    const contentField = form.article_content;
    const classField = form.class_id;
    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';
    contentField.style.border = '1px solid #CCCCCC';
    contentField.nextElementSibling.innerText = '';
    classField.style.border = '1px solid #CCCCCC';
    classField.nextElementSibling.innerText = '';
    let nameIsPass = true;
    if (nameField.value.length < 2) {
      nameIsPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerText = '請填寫文章名稱';
    }
    let contentIsPass = true;
    if (contentField.value.length < 2) {
      contentIsPass = false;
      contentField.style.border = '1px solid red';
      contentField.nextElementSibling.innerText = '請填寫文章內容';
    }
    let classIsPass = true;
    if (classField.value === '') { // 修改此處的檢查條件
      classIsPass = false;
      classField.style.border = '1px solid red';
      classField.nextElementSibling.innerText = '請選擇文章分類';
    }
    if (nameIsPass && contentIsPass && classIsPass) {
      const fd = new FormData(form);
      fetch('article-add-api.php', {
        method: 'POST',
        body: fd,
      }).then(response => {
        if (response.ok) {
          return response.json();
        }
        throw new Error('Network response was not ok.');
      }).then(data => {
        console.log(data);
        if (data.success) {
          myModal.show();
        }
      }).catch(error => {
        console.error('Error:', error);
      });
    }
  };
  const myModal = new bootstrap.Modal('#staticBackdrop');
</script>
<?php include __DIR__ . '/../parts/foot.php'; ?>