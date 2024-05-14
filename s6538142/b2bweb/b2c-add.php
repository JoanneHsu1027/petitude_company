<?php
// require __DIR__. '/admin-required.php';
if (!isset($_SESSION)) {
  session_start();
}
$title = "新增通訊錄";
$pageName = 'add';

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-bar.php' ?>
<?php include __DIR__ . '/Alladdress.php' ?>
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
          <h5 class="card-title">新增資料</h5>
          <form name="form1" onsubmit="sendData(event)">

            <div class="mb-3">
              <label for="b2c_name" class="form-label">姓名</label>
              <input type="text" class="form-control" id="b2c_name" name="b2c_name">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_email" class="form-label">Email</label>
              <input type="text" class="form-control" id="b2c_email" name="b2c_email">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_mobile" class="form-label">手機</label>
              <input type="text" class="form-control" id="b2c_mobile" name="b2c_mobile">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="b2c_birth" class="form-label">生日</label>
              <input type="date" class="form-control" id="b2c_birth" name="b2c_birth">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
<<<<<<< HEAD
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
=======
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
>>>>>>> origin/s6538142
            </div>

            <div class="mb-3">
              <label for="fk_city_id" class="form-label">居住地區</label>
              <select id="fk_city_id" name="fk_city_id" class="form-select mb-2">
<<<<<<< HEAD

=======
                    <option value="0">--請先選擇縣市--</option>
>>>>>>> origin/s6538142
              </select>
            </div>

            <div class="mb-3">
              <label for="b2c_address" class="form-label">地址</label>

              <textarea class="form-control" id="b2c_address" name="b2c_address" cols="30" rows="3"></textarea>
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
<<<<<<< HEAD

        <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button>
=======
        
        <button type="button" class="btn btn-primary" onclick="location.href='b2c_list.php'">到列表頁</button>
>>>>>>> origin/s6538142
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const nameField = document.form1.b2c_name;
  const emailField = document.form1.b2c_email;

  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
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
      // isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerText = '請填寫正確的姓名';

    }
    if (!validateEmail(emailField.value)) {
      // isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerText = '請填寫正確的 Email';
    }


    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件

<<<<<<< HEAD
      fetch('b2c-edit-api.php', {
          method: 'POST',
          body: fd, // Content-Type: multipart/form-data
        }).then(r => r.json())
=======
      fetch('b2c-add-api.php', {
        method: 'POST',
        body: fd, // Content-Type: multipart/form-data
      }).then(r => r.json())
>>>>>>> origin/s6538142
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
<<<<<<< HEAD

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


=======
<script src="./js/city.js"></script>
>>>>>>> origin/s6538142
<?php include __DIR__ . '/parts/html-foot.php' ?>