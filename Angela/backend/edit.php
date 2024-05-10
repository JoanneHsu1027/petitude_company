    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';

    $title = '修改通訊錄';
    $pageName = 'edit';

    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
    if (empty($sid)) {
    header('Location: list.php');
    exit;
    }
    // 原先是 select * from address_book ?是哪個
    $sql = "SELECT * FROM petcompany WHERE sid=$sid";
    $r = $pdo->query($sql)->fetch();
    if (empty($r)) {
    header('Location: list.php');
    exit;
    }

    ?>
    <?php include __DIR__ . '/../parts/html_head.php' ?>
    <?php include __DIR__ . '/../parts/navbar.php' ?>
    <style>
    form .mb-3 .form-text {
        color: red;
    }
    </style>
    <div class="container">
    <div class="row">
        <div class="col-6">
        <div class="card">

            <div class="card-body">
            <h5 class="card-title">編輯通訊錄</h5>

            <form name="form1" onsubmit="sendData(event)">
                <!-- 隱藏欄位 用來傳送 primary key -->
                <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                <div class="mb-3">
                <label for="name" class="form-label">** 姓名</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($r['name']) ?>">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="email" class="form-label">電子郵箱</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $r['email'] ?>">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="mobile" class="form-label">手機</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $r['mobile'] ?>">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="birthday" class="form-label">生日</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $r['birthday'] ?>">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="address" class="form-label">地址</label>
                <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= $r['address'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">修改</button>
            </form>

            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">修改結果</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" role="alert">
            資料修改成功
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <button class="btn btn-primary" onclick="backToList()">回到列表頁</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">資料沒有修改</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" role="alert" id="failureInfo">
            資料沒有修改
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <button class="btn btn-primary" onclick="backToList()">回到列表頁</button>
        </div>
        </div>
    </div>
    </div>

    <?php include __DIR__ . '/../parts/script.php' ?>
    <script>
    function backToList() {
        if (document.referrer) {
        location.href = document.referrer;
        } else {
        location.href = 'list.php';
        }
    }

    const {
        name: nameEl,
        email: emailEl,
        mobile: mobileEl,
    } = document.form1;

    const fields = [nameEl, emailEl, mobileEl];

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function validateMobile(mobile) {
        const re = /^09\d{2}-?\d{3}-?\d{3}$/;
        return re.test(mobile);
    }

    function sendData(e) {
        // 回復欄位的外觀
        for (let el of fields) {
        el.style.border = '1px solid #CCC';
        el.nextElementSibling.innerHTML = '';
        }

        e.preventDefault(); // 不要讓表單以傳統的方式送出
        let isPass = true; // 整個表單有沒有通過檢查

        // TODO: 檢查各個欄位的資料, 有沒有符合規定
        if (nameEl.value.length < 2) {
        isPass = false; // 沒有通過檢查
        nameEl.style.border = '1px solid red';
        nameEl.nextElementSibling.innerHTML = '請填寫正確的姓名!';
        }

        if (emailEl.value && !validateEmail(emailEl.value)) {
        isPass = false;
        emailEl.style.border = '1px solid red';
        emailEl.nextElementSibling.innerHTML = '請填寫正確的 Email !';
        }

        if (mobileEl.value && !validateMobile(mobileEl.value)) {
        isPass = false;
        mobileEl.style.border = '1px solid red';
        mobileEl.nextElementSibling.innerHTML = '請填寫正確的手機號碼!';
        }

        // 有通過檢查才發送表單
        if (isPass) {
        const fd = new FormData(document.form1); // 沒有外觀的表單物件

        fetch(`edit-api.php`, {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(data => {
            console.log(data);
            if (data.success) {
            successModal.show();
            } else {
            document.querySelector('#failureInfo').innerHTML = data.error;
            failureModal.show();
            }

        })
        }

        // 地址: 兩層選單的參考
        // https://dennykuo.github.io/tw-city-selector/#/
    }

    const successModal = new bootstrap.Modal('#successModal')
    const failureModal = new bootstrap.Modal('#failureModal')
    </script>
    <?php include __DIR__ . '/../parts/html_foot.php' ?>