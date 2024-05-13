<?php
require __DIR__ . './admin-required.php';
require __DIR__ . '/Alladdress.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "新增資料";
$pageName = 'request_add';

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

        <div class="card-body" style="color:#0c5a67">
          <h5 class="card-title">新增訂單資料</h5>
          <form name="form1" onsubmit="sendData(event)">

            <div class="mb-3">
              <label for="request_date" class="form-label">訂單日期</label>
              <input type="text" class="form-control" id="request_date" name="request_date">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="request_status" class="form-label">訂單狀態</label>
              <input type="text" class="form-control" id="request_status" name="request_status">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="payment_status" class="form-label">付款狀態</label>
              <input type="text" class="form-control" id="payment_status" name="payment_status">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_b2c_id" class="form-label">會員編號</label>
              <input type="text" class="form-control" id="fk_b2c_id" name="fk_b2c_id">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="request_price" class="form-label">訂單總價</label>
              <input type="text" class="form-control" id="request_price" name="request_price">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="fk_county_id" class="form-label">居住縣市</label>
              <select id="fk_county_id" name="fk_county_id" class="form-select mb-2" onchange="updatecitys()">
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

              </select>
            </div>

            <div class="mb-3">
              <label for="recipient_address" class="form-label">寄送地址(詳細)</label>
              <textarea class="form-control" id="recipient_address" name="recipient_address" cols="30" rows="2"></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="recipient_mobile" class="form-label">連絡電話</label>
              <input type="text" class="form-control" id="recipient_mobile" name="recipient_mobile">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="recipient_email" class="form-label">電子信箱</label>
              <input type="text" class="form-control" id="recipient_email" name="recipient_email">
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

        <button type="button" class="btn btn-primary" onclick="location.href='request.php'">到列表頁</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
  const emailField = document.form1.recipient_email;

  function validateEmail(recipient_email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(recipient_email);
  }

  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerText = '';
    // TODO: 欄位資料檢查

    let isPass = true; // 表單有沒有通過檢查
    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

      fetch('request_add_api.php', {
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