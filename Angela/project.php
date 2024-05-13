<?php
require __DIR__ . '/config/pdo_connect.php';
$title = '登入';
$pageName = 'login';

// 检查用户是否已登录为管理员
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    include __DIR__ . '/project-admin.php';
    exit;
}

// 如果未登录为管理员，则显示登录表单
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 用户提交了登录表单，进行登录验证
    $username = $_POST['username']; // 从表单中获取用户名
    $password = $_POST['password']; // 从表单中获取密码

    if ($username === 'admin' && $password === 'password') {
        $_SESSION['admin'] = true; // 将用户标记为管理员
        header('Location: booking.php'); // 重定向到自身页面
        exit;
    } else {
        echo '用户名或密码错误，请重试。'; // 显示错误消息
    }
}
?>
    <?php include __DIR__ . '/parts/html_head.php' ?>
        <?php include __DIR__ . '/parts/navbar.php' ?>
    <div class="container">
        <div class="row">
            <div class="col-6">
            <div class="card">

                <div class="card-body">
                <h5 class="card-title">登入</h5>

                <form name="form1" onsubmit="sendData(event)">
                    <div class="mb-3">
                    <label for="email" class="form-label">電子郵箱</label>
                    <input type="text" class="form-control" id="email" name="email">
                    <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="form-text"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">登入</button>
                </form>

                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="failureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">登入失敗</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" role="alert" id="failureInfo">
            帳號或密碼錯誤
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        </div>
        </div>
    </div>
    </div>
    <?php include __DIR__ . '/parts/script.php' ?>

<script>
    const {
        email: emailEl,
        password: passwordEl,
    } = document.form1;

    const fields = [emailEl, passwordEl];

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function sendData(e) {
        // 回復欄位的外觀
        for (let el of fields) {
        el.style.border = '1px solid #CCC';
        el.nextElementSibling.innerHTML = '';
        }

        e.preventDefault(); // 不要讓表單以傳統的方式送出
        let isPass = true; // 整個表單有沒有通過檢查

        if (!validateEmail(emailEl.value)) {
        isPass = false;
        emailEl.style.border = '1px solid red';
        emailEl.nextElementSibling.innerHTML = '請填寫正確的 Email !';
        }

        // 有通過檢查才發送表單
        if (isPass) {
        const fd = new FormData(document.form1); // 沒有外觀的表單物件

        fetch(`login-api.php`, {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(data => {
            console.log(data);

            if (data.success) {
            location.href = 'index_.php';
            } else {
            failureModal.show();
            }

        })
        }
    }
    const failureModal = new bootstrap.Modal('#failureModal')
</script>
    <?php include __DIR__ . '/parts/html_foot.php' ?>