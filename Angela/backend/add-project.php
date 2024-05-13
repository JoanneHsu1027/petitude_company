    <?php
    // require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    $title = '新增訂單';
    $pageName = 'add';
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
            <h5 class="card-title">新增 - 生前契約列表</h5>

            <form name="form1" onsubmit="sendData(event)">
                <div class="mb-3">
                <label for="project_id" class="form-label"> project_id</label>
                <input type="text" class="form-control" id="project_id" name="project_id">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="fk_b2c_id" class="form-label">project_level</label>
                <input type="text" class="form-control" id="project_level" name="project_level">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="project_name" class="form-label">project_name</label>
                <input type="text" class="form-control" id="project_name" name="project_name">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="project_content" class="form-label">project_content</label>
                <input type="text" class="form-control" id="project_content" name="project_content">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="project_fee" class="form-label">project_fee</label>
                <input type="text" class="form-control" id="project_fee" name="project_fee">
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
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">新增結果</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" role="alert">
            資料新增成功
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <a href="list.php" class="btn btn-primary">跳到列表頁</a>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">新增失敗</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" role="alert" id="failureInfo">
            資料新增失敗
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <a href="list.php" class="btn btn-primary">跳到列表頁</a>
        </div>
        </div>
    </div>
    </div>

    <?php include __DIR__ . '/../parts/script.php' ?>
    <script>
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

        fetch(`add-api.php`, {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(data => {
            console.log(data);
            /*
            if (data.success) {
            alert('資料新增成功');
            location.href = 'list.php';
            } else {
            alert('資料新增沒有成功\n' + data.error);
            }
            */
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
    <?php include __DIR__ .  '/../parts/html_foot.php' ?>