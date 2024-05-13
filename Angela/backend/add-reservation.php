    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    $title = '新增預約參觀';
    $pageName = 'add-reservation';
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
            <h5 class="card-title">新增 - 線上預約參觀</h5>

            <form name="form1" onsubmit="sendData(event)">
                <div class="mb-3">
                <label for="reservation_id" class="form-label"> reservation_id</label>
                <input type="text" class="form-control" id="reservation_id" name="reservation_id">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="fk_b2c_id" class="form-label">fk_b2c_id</label>
                <input type="text" class="form-control" id="fk_b2c_id" name="fk_b2c_id">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="fk_pet_id" class="form-label">fk_pet_id</label>
                <input type="text" class="form-control" id="fk_pet_id" name="fk_pet_id">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="reservation_date" class="form-label">reservation_date</label>
                <input type="date" class="form-control" id="reservation_date" name="reservation_date">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="reservation_note" class="form-label">reservation_note</label>
                <textarea class="form-control" name="reservation_note" id="reservation_note" cols="30" rows="3"></textarea>
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
    const fd = new FormData(); // 假設這裡定義了 fd 變數，並且包含了要發送的資料

    fetch('add-reservation-api.php', {
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