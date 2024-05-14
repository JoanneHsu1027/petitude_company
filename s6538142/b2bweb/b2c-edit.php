<?php
// require __DIR__. '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
require __DIR__ . '/Alladdress.php';

$title = "修改一般會員資料";



$b2c_id = isset($_GET['b2c_id']) ? intval($_GET['b2c_id']) : 0;
if ($b2c_id < 1) {
  header('Location: b2c_list.php');
  exit;
}

    
$sql = "SELECT b2c.*, county_name, city_name 
        FROM b2c_members AS b2c 
        JOIN county ON b2c.fk_county_id = county.county_id
        JOIN city ON b2c.fk_city_id = city.city_id
        WHERE b2c_id={$b2c_id}";

$row = $pdo->query($sql)->fetch();


if (empty($row)) {
  header('Location: b2c_list.php');
  exit;
}

// echo json_encode($row);


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-bar.php' ?>
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
          <h5 class="card-title">編輯資料</h5>
          <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="b2c_id" value="<?= $row['b2c_id'] ?>">

            <div class="mb-3">
              <label for="b2c_id" class="form-label">編號</label>
              <input type="text" class="form-control" disabled value="<?= $row['b2c_id'] ?>">
            </div>

            <div class="mb-3">
              <label for="b2c_name" class="form-label">姓名</label>
              <input type="text" class="form-control" id="b2c_name" name="b2c_name" value="<?= $row['b2c_name'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_email" class="form-label">Email</label>
              <input type="text" class="form-control" id="b2c_email" name="b2c_email" value="<?= $row['b2c_email'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_mobile" class="form-label">手機</label>
              <input type="text" class="form-control" id="b2c_mobile" name="b2c_mobile" value="<?= $row['b2c_mobile'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_birth" class="form-label">生日</label>
              <input type="date" class="form-control" id="b2c_birth" name="b2c_birth" value="<?= $row['b2c_birth'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
                <label for="fk_county_id" class="form-label">居住縣市</label>
                <select id="fk_county_id" name="fk_county_id" class="form-select mb-2" onchange="updatecitys()">
                    <option value="<?=$row['fk_county_id']?>"><?=$row['county_name']?></option>
                    <?php 
                        for ($i = 0; $i <= 23; $i++) {
                    ?>
                        <option value="<?php echo $i; ?>"><?php echo $counties[$i]; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="mb-3">
              <label for="fk_city_id" class="form-label">居住地區</label>
              <select id="fk_city_id" name="fk_city_id" class="form-select mb-2">
                    <option value="<?=$row['fk_city_id']?>"><?=$row['city_name']?></option>
              </select>
            </div>

            <div class="mb-3">
              <label for="b2c_address" class="form-label">詳細地址</label>
              <textarea class="form-control" id="b2c_address" name="b2c_address" cols="30"
                rows="3"><?= $row['b2c_address'] ?></textarea>
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
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

        <button type="button" class="btn btn-primary" onclick="location.href='b2c_list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal 2-->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

        <button type="button" class="btn btn-primary" onclick="location.href='b2c_list.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const nameField = document.form1.b2c_name;
  const emailField = document.form1.b2c_email;

  function validateEmail(b2c_email) {
    const re_email =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re_email.test(b2c_email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true;  // 表單有沒有通過檢查
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

      fetch('b2c-edit-api.php', {
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

<script src="js/city.js"></script>


<?php include __DIR__ . '/parts/html-foot.php' ?>