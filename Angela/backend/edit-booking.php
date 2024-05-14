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

    // $sql = "SELECT *, fk_b2c_id, fk_pet_id, fk_project_id, fk_reservation_id 
    //     FROM booking AS book
    //     JOIN fk_b2c_id ON book.fk_b2c_id = b2c.fk_b2c_id
    //     JOIN fk_pet_id ON book.fk_pet_id = pet.fk_pet_id
    //     JOIN fk_project_id ON book.fk_project_id = project.fk_project_id
    //     JOIN fk_reservation_id ON book.fk_reservation_id = reservation.fk_reservation_id
    //     WHERE booking_id={$booking_id}";
        

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
            <form name="form1" onsubmit="sendData(event)">
            <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
            <input type="hidden" name="fk_b2c_id" value="<?= $row['fk_b2c_id'] ?>">
            <input type="hidden" name="fk_pet_id" value="<?= $row['fk_pet_id'] ?>">
            <input type="hidden" name="fk_project_id" value="<?= $row['fk_project_id'] ?>">
            <input type="hidden" name="fk_reservation_id" value="<?= $row['fk_reservation_id'] ?>">
            

                <div class="mb-3">
                <label for="booking_id" class="form-label">booking_id</label>
                <input type="text" id="booking_id" class="form-control" disabled value="<?= $row['booking_id'] ?>">
                </div>

                <input type="hidden" name="fk_b2c_id" value="<?= $row['fk_b2c_id'] ?>">
                <div class="mb-3">
                <label for="fk_b2c_id" class="form-label">fk_b2c_id</label>
                <input type="text" id="fk_b2c_id" class="form-control" disabled value="<?= $row['fk_b2c_id'] ?>">
                </div>

                <input type="hidden" name="fk_pet_id" value="<?= $row['fk_pet_id'] ?>">
                <div class="mb-3">
                <label for="fk_pet_id" class="form-label">fk_pet_id</label>
                <input type="text" id="fk_pet_id" class="form-control" disabled value="<?= $row['fk_pet_id'] ?>">
                </div>

                <input type="hidden" name="fk_project_id" value="<?= $row['fk_project_id'] ?>">
                <div class="mb-3">
                <label for="fk_project_id" class="form-label">fk_project_id</label>
                <input type="text" id="fk_project_id" class="form-control" disabled value="<?= $row['fk_project_id'] ?>">
                </div>

                <input type="hidden" name="fk_reservation_id" value="<?= $row['fk_reservation_id'] ?>">
                <div class="mb-3">
                <label for="fk_reservation_id" class="form-label">fk_reservation_id</label>
                <input type="text" id="fk_reservation_id" class="form-control" disabled value="<?= $row['fk_reservation_id'] ?>">
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
    e.preventDefault(); // 不要讓 form1 以傳統的方式送出

    let isPass = true;  // 表單有沒有通過檢查

    // 有通過檢查, 才要送表單
    if (isPass) {
        const fd = new FormData(document.form1); // 沒有外觀的表單物件

        fetch('edit-booking-api.php', {
            method: 'POST',
            body: fd, 
        }).then(r => r.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                myModal.show();
            } else {
                // 如果 API 返回了錯誤訊息，顯示給用戶
                if (data.error) {
                    showError(data.error);
                } else {
                    myModal2.show();
                }
            }
        })
        .catch(ex => {console.log(ex);
        });
    }
};

        const myModal = new bootstrap.Modal('#staticBackdrop')
        const myModal2 = new bootstrap.Modal('#staticBackdrop2')

    </script>
    <?php include __DIR__ . '/../parts/html_foot.php' ?>