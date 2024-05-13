    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';

    if (!isset($_SESSION)) {
    session_start();
    }
    $title = '新增列表';
    $pageName = 'add-project';
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
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">新增成功</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" role="alert">
            資料新增成功
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="location.href='project.php'">到列表頁</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
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
            <a href="project.php" class="btn btn-primary">跳到列表頁</a>
        </div>
        </div>
    </div>
    </div>

    <?php include __DIR__ . '/../parts/script.php' ?>
    <script>
    const fd = new FormData(); // 假設這裡定義了 fd 變數，並且包含了要發送的資料

    fetch('add-project-api.php', {
    method: 'POST',
    body: fd,
    })
    .then(r => r.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            // 如果 success 為 true，表示 API 呼叫成功
            myModal.show();
        } else {
            // 如果 success 為 false，表示 API 呼叫失敗
            // 在這裡可以執行相應的錯誤處理邏輯，例如顯示錯誤訊息給用戶
            console.error('API 呼叫失敗');
        }
    })
    .catch(ex => console.error(ex));

    const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
    </script>
        <?php include __DIR__ .  '/../parts/html_foot.php' ?>