<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

// 地址的縣市鄉鎮選擇使用
require __DIR__ . '/Alladdress.php';

$title = "新增保險訂單";
$pageName = 'add';


if (!isset($_SESSION)) {
  session_start();
};

// 新增完成回到訂單表最後一頁時使用 start
$perPage = 15; # 每一頁最多有幾筆 注意要跟order-list-admin.php連動

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit; # 結束這支程式
}

$t_sql = "SELECT COUNT(insurance_order_id) FROM insurance_order";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];


#預設值
$totalPages = 0;
$rows = [];
if ($totalRows) {
  # 總頁數
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    header("Location: ?page={$totalPages}");
    exit; # 結束這支程式
  }
}

// 新增完成回到訂單表最後一頁時使用 end

$sql = "SELECT *, insurance_product.insurance_fee
FROM insurance_order
JOIN insurance_product 
ON insurance_order.fk_insurance_product_id = insurance_product.insurance_product_id
";
$row = $pdo->query($sql)->fetchAll();
if (empty($row)) {
  header('Location: order-list.php');
  exit;
}

// 保險商品代號選擇使用 start
require __DIR__ . '/../config/pdo-connect.php';
$product_sql = "SELECT * FROM insurance_product";
$product_row = $pdo->query($product_sql)->fetchAll();
// 保險商品代號選擇使用 end

// // 地址(縣市)代號選擇使用 start
// require __DIR__ . '/../config/pdo-connect.php';
// $county_sql = "SELECT * FROM county";
// $county_row = $pdo->query($county_sql)->fetchAll();
// // 地址(縣市)代號選擇使用 end

// // 地址(鄉鎮區)代號選擇使用 start
// require __DIR__ . '/../config/pdo-connect.php';
// $city_sql = "SELECT * FROM city";
// $city_row = $pdo->query($city_sql)->fetchAll();
// // 地址(鄉鎮區)代號選擇使用 end

?>
<?php include __DIR__ . '/../page/html-header.php'; ?>
<?php include __DIR__ . '/../page/html-navbar.php'; ?>

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
          <h5 class="card-title">新增保單</h5>
          <form name="form1" onsubmit="sendData1(event)">
            <!-- 設定name和設定onsubmit -->
            <div class="mb-3">
              <label for="fk_b2c_id" class="form-label">會員帳號</label>
              <input type="text" class="form-control mb-3" id="fk_b2c_id" name="fk_b2c_id">
              <div class="form-text"></div>

              <label for="fk_pet_id" class="form-label">寵物帳號</label>
              <input type="text" class="form-control mb-3" id="fk_pet_id" name="fk_pet_id">
              <div class="form-text"></div>

              <label for="fk_insurance_product_id" class="form-label">保險商品代號</label>
              <select class="form-select mb-3" id="fk_insurance_product_id" name="fk_insurance_product_id">
                <option value="" selected disabled>請選擇商品代號</option>
                <?php foreach ($product_row as $r) : ?>
                  <option value="<?= $r['insurance_product_id'] ?>">
                    <?= $r['insurance_product_id'] ?> <?= $r['insurance_name'] ?>
                  </option>
                <?php endforeach; ?>
                <div class="form-text"></div>
              </select>



              <!-- <?php foreach ($row as $r) : ?>
                <input type="text" class="form-control mb-3" id="insurance_fee" name="insurance_fee" value="<?= $r['insurance_fee'] ?>" disabled>
              <?php endforeach; ?>
              <div class="form-text"></div> -->
              <!-- 費用希望他能依據商品代號自動帶出, 未完成 -->


              <label for="payment_status" class="form-label">付款狀態</label>
              <div class="dropdown mb-3">
                <select class="form-select" id="payment_status" name="payment_status">
                  <option value="0" selected>未付款</option>
                  <option value="1">已付款</option>
                </select>
              </div>
              <div class="form-text"></div>

              <label for="insurance_start_date" class="form-label">保險起始日期(YYYY-MM-DD)</label>
              <input type="date" class="form-control mb-3" id="insurance_start_date" name="insurance_start_date">
              <div class="form-text"></div>
              <!-- 虛設限制, 不能早於今天 -->

              <label for="fk_county_id" class="form-label">居住縣市</label>
              <select class="form-select mb-3 " id="fk_county_id" name="fk_county_id" onchange="updatecitys()">
                <?php
                for ($i = 0; $i <= 23; $i++) {
                ?>
                  <option value="<?php echo $i; ?>"><?php echo $counties[$i]; ?></option>
                <?php
                }
                ?>
              </select>
              <div class="form-text"></div>


              <label for="fk_city_id" class="form-label">居住地區</label>
              <select class="form-select mb-3 " id="fk_city_id" name="fk_city_id">

              </select>
              <div class="form-text"></div>


              <label for="policyholder_address" class="form-label">地址</label>
              <textarea class="form-control mb-3" name="policyholder_address" id="policyholder_address" cols="30" rows="5"></textarea>
              <div class="form-text"></div>

              <label for="policyholder_mobile" class="form-label">手機號碼</label>
              <input type="text" class="form-control mb-3" id="policyholder_mobile" name="policyholder_mobile">
              <div class="form-text"></div>

              <label for="policyholder_email" class="form-label">聯絡信箱</label>
              <input type="text" class="form-control mb-3" id="policyholder_email" name="policyholder_email">
              <div class="form-text"></div>

              <label for="policyholder_IDcard" class="form-label">身分證字號</label>
              <input type="text" class="form-control mb-3" id="policyholder_IDcard" name="policyholder_IDcard">
              <div class="form-text"></div>



              <button type="submit" class="btn btn-primary">送出新增</button>
            </div>
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
          訂單新增成功
        </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-primary" onclick="location.href='list.php'">到列表頁</button> -->
        <!-- 這邊用onclick設定位址, 也可用a -->
        <a href="order-list.php?page=<?= $totalPages ?>" type="button" class="btn btn-primary">到列表頁</a>
        <!-- 確認權限設定後來改 -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include __DIR__ . '/../page/html-scripts.php'; ?>
<script>
  const sendData1 = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';


    // TODO: 欄位資料檢查

    const fd = new FormData(document.form1); // 沒有外觀的表單物件




    fetch('add-api.php', {
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

  ;
  const myModal1 = new bootstrap.Modal('#staticBackdrop')
</script>

<!-- 新的js需要寫在原本掛的js下方 -->
<script>
  // 地址選擇 start
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
  // 地址選擇 end




  // 驗證表單 start
  const nameField = document.form1.fk_b2c_id;


  const sendData = e => {
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerText = '';


    // TODO: 欄位資料檢查

    const fd = new FormData(document.form1); // 沒有外觀的表單物件
    let isPass = true; // 表單有沒有通過檢查
    // 檢驗姓名欄位
    if (nameField.value.length < 2) {
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的商品名稱';
    }
    // 因為只有一個欄位所以用innerHTML或innerText都可以

    // 有通過檢查, 才要送表單
    if (isPass) {
      const fd = new FormData(document.form1); // 沒有外觀的表單物件
      fetch('add-api.php', {
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
  // 驗證表單 end
</script>

<?php include __DIR__ . '/../page/html-footer.php'; ?>