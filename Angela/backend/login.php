
    <?php
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isset($_SESSION['admin'])) {
    header('Location: index_.php');
    exit;
    }
    $title = "登入";
    $pageName = 'login';

    ?>

    <?php include __DIR__ . '/../parts/html_head.php' ?>
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

        <div class="card-body">
            <h5 class="card-title">登入</h5>
            <form name="form1" onsubmit="sendData(event)">
                <div class="mb-3">
                    <label for="username" class="form-label">帳號</label>
                    <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">登入</button>
            </form>
        </div>
        </div>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">登入發生錯誤</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" role="alert">
            帳號或密碼錯誤
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續登入</button>
        </div>
        </div>
    </div>
    </div>



    <?php include __DIR__ . '/../parts/script.php' ?>

    <script>

    const usernameField = document.form1.username; // 修改获取用户名字段

const sendData = e => {
    e.preventDefault();

    const fd = new FormData(document.form1);
    // 将email字段改为username字段
    fetch('login-api.php', {
        method: 'POST',
        body: fd,
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
    
    <?php include __DIR__ . '/../parts/html_foot.php' ?>