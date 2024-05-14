<?php
require __DIR__ . './admin-required.php';
require __DIR__ . './config/pdo-connect.php';
require __DIR__ . './Alladdress.php';
$title = "修改訂單資料";
$pageName = 'request_edit';


$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
if ($request_id < 1) {
  header('Location: request.php');
  exit;
}

$sql = "SELECT request.*, county_name, city_name
FROM request
JOIN county ON request.fk_county_id = county.county_id
JOIN city ON request.fk_city_id = city.city_id
WHERE request_id={$request_id}";

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
<div class="container" style="color:#0c5a67">
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
              <label for="fk_county_id" class="form-label">居住縣市</label>
              <select id="fk_county_id" name="fk_county_id" class="form-select mb-2" onchange="updatecitys()">
                <option value="<?= $row['fk_county_id'] ?>"><?= $row['county_name'] ?></option>
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
                <option value="<?= $row['fk_city_id'] ?>"><?= $row['city_name'] ?></option>
              </select>
            </div>

            <div class="mb-3">
              <label for="recipient_address" class="form-label">寄送地址(詳細)</label>

              <textarea class="form-control" id="recipient_address" name="recipient_address" cols="30" rows="3"><?= $row['recipient_address'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="recipient_mobile" class="form-label">連絡電話</label>
              <input type="text" class="form-control" id="recipient_mobile" name="recipient_mobile" value="<?= $row['recipient_mobile'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="recipient_email" class="form-label">電子信箱</label>
              <input type="text" class="form-control" id="recipient_email" name="recipient_email" value="<?= $row['recipient_email'] ?>">
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

        <button type="button" class="btn btn-primary" onclick="location.href='request.php'">到列表頁</button>
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

        <button type="button" class="btn btn-primary" onclick="location.href='request.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
  // const nameField = document.form1.name;
  const emailField = document.form1.recipient_email;

  function validateEmail(recipient_email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(recipient_email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    // nameField.style.border = '1px solid #CCCCCC';
    // nameField.nextElementSibling.innerText = '';
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

<script>
  function updatecitys() {
    var countySelect = document.getElementById("fk_county_id");
    var citySelect = document.getElementById("fk_city_id");
    var county = countySelect.value;
    citySelect.innerHTML = ""; // 清除鄉鎮區選項

    // 根據選擇的縣市，添加相應的鄉鎮區選項
    switch (county) {
      case "1":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 1; j <= 12; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "2":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 13; j <= 19; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "3":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 20; j <= 48; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "4":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 49; j <= 61; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "5":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 62; j <= 64; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "6":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 65; j <= 77; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "7":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 78; j <= 90; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "8":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 91; j <= 108; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "9":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 109; j <= 137; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "10":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 138; j <= 163; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "11":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 164; j <= 176; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "12":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 177; j <= 178; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "13":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 179; j <= 196; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "14":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 197; j <= 216; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "15":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 217; j <= 253; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "16":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 254; j <= 291; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "17":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 292; j <= 293; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "18":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 294; j <= 299; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "19":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 300; j <= 332; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "20":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 333; j <= 348; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "21":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 349; j <= 361; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "22":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 362; j <= 367; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "23":
        addOption(citySelect, "請選擇鄉鎮地區", 0);
        for (var j = 368; j <= 371; j++) {
          addOption(citySelect, cities[j], j);
        }
        break;
      case "0":
        addOption(citySelect, "請先選擇縣市", 0);
        break;
    }
  }

  function addOption(selectElement, optionText, optionValue) {
    var option = document.createElement("option");
    option.text = optionText;
    option.value = optionValue;
    selectElement.add(option);
  }
</script>

<?php include __DIR__ . './parts/foot.php' ?>