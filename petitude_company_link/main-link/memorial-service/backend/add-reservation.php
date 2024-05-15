    <?php
    require __DIR__ . './../../b2bweb/admin-required.php';
    require __DIR__ . './../../config/pdo-connect.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $title = '新增預約紀錄';
    $pageName = 'add-reservation';
    ?>
    <?php include __DIR__ . '/../../parts/head.php' ?>
    <?php include __DIR__ . '/../../parts/navbar.php' ?>
    <style>
        form .mb-3 .form-text {
            color: red;
            font-weight: 800;
        }
    </style>
    <div id="content" style="color:#0c5a67">
        <h2>預約參觀-新增預約紀錄</h2>
    </div>
    <div class="container" style="color:#0c5a67">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form name="form1" onsubmit="sendData(event)">

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
                                <label for="note" class="form-label">note</label>
                                <textarea class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="background-color:#0c5a67; border-color:#0c5a67">新增</button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">新增成功</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        資料新增成功
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" onclick="location.href='./../reservation.php'">到列表頁</button>
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
                    <a href="./../reservation.php" class="btn btn-primary">跳到列表頁</a>
                </div>
            </div>
        </div>
    </div>


    <?php include __DIR__ . '/../../parts/scripts.php' ?>
    <script>
        const fd = new FormData(document.form1);

        const sendData = e => {
            e.preventDefault(); // 不要讓 form1 以傳統的方式送出

            // 有通過檢查, 才要送表單

            const fd = new FormData(document.form1);

            fetch('add-reservation-api.php', {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        myModal.show();
                    } else {
                        console.log('api error?')
                    }
                })
                .catch(ex => console.log(ex))

        };

        const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
    </script>
    <?php include __DIR__ .  '/../../parts/foot.php' ?>