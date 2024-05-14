    <?php
    // require __DIR__. '/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    $title = "修改訂單資料";
    $pageName = 'edit-booking';

    $booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
    if ($booking_id < 1) {
    header('Location: ./../booking-admin.php');
    exit;
    }

    $sql = "SELECT * FROM booking WHERE booking_id={$booking_id}";

    $row = $pdo->query($sql)->fetch();
    if (empty($row)) {
    header('Location: ./../booking-admin.php');
    exit;
    }

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
            <h5 class="card-title">編輯訂單資料</h5>
            <form name="form1" onsubmit="sendData(event)"><input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                <div class="mb-3">
                <label for="booking_id" class="form-label">booking_id</label>
                <input type="text" class="form-control" disabled value="<?= $row['booking_id'] ?>">
                </div>
                <div class="mb-3">
                <label for="booking_date" class="form-label">booking_date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date">
                <div class="form-text"></div>
                </div>
                <div class="mb-3">
                <label for="booking_note" class="form-label">booking_note</label>
                <textarea class="form-control" name="booking_note" id="booking_note" cols="30" rows="3"></textarea>
                </div>


                <button type="submit" class="btn btn-primary">修改</button>
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
            <h1 class="modal-title fs-5" id="staticBackdropLabel">修改成功</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" role="alert">
            資料修改成功
            </div>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-primary" onclick="location.href='./request.php'">到列表頁</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        </div>
        </div>
    </div>
    </div>
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

            <button type="button" class="btn btn-primary" onclick="location.href='./request.php'">到列表頁</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        </div>
        </div>
    </div>
    </div>


    <?php include __DIR__ . '/../parts/script.php' ?>
    <script>

    const sendData = e => {
        e.preventDefault();
    
        let isPass = true;  // 表單有沒有通過檢查
        
        // 有通過檢查, 才要送表單
        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單物件

            fetch('edit-booking-api.php', {
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
    <?php include __DIR__ . '/../parts/html_foot.php' ?>