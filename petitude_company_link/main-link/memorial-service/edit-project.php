<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
$title = "修改列表資料";
$pageName = 'edit-project';

$project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;
if ($project_id < 1) {
    header('Location: project.php');
    exit;
}

$sql = "SELECT * FROM project WHERE project_id = {$project_id}";

$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: project.php');
    exit;
}

?>
<?php include __DIR__ . '/../parts/head.php' ?>
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

                <div class="card-body" style="color:#0c5a67">
                    <h5 class="card-title">編輯列表資料</h5>
                    <form name="form1" onsubmit="sendData(event)">

                        <input type="hidden" name="project_id" value="<?= $row['project_id'] ?>">

                        <div class="mb-3">
                            <label for="project_id" class="form-label">project_id</label>
                            <input type="text" id="project_id" class="form-control" readonly value="<?= $row['project_id'] ?>">
                        </div>

                        <div class="mb-3">
                            <label for="project_level" class="form-label">project_level</label>
                            <input type="text" class="form-control" id="project_level" name="project_level" value="<?= $row['project_level'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="project_name" class="form-label">project_name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" value="<?= $row['project_name'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="project_content" class="form-label">project_content</label>
                            <input type="text" class="form-control" id="project_content" name="project_content" value="<?= $row['project_content'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="project_fee" class="form-label">project_fee</label>
                            <input type="text" class="form-control" id="project_fee" name="project_fee" value="<?= $row['project_fee'] ?>">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="background-color:#0c5a67; border-color:#0c5a67">修改</button>
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

                <button type="button" class="btn btn-primary" onclick="location.href='project.php'">到列表頁</button>
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

                <button type="button" class="btn btn-primary" onclick="location.href='project.php'">到列表頁</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
    const sendData = e => {
        e.preventDefault(); // 不要讓 form1 以傳統的方式送出

        let isPass = true; // 表單有沒有通過檢查

        // 有通過檢查, 才要送表單
        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單物件

            fetch('edit-project-api.php', {
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
                .catch(ex => {
                    console.log(ex);
                });
        }
    };

    const myModal = new bootstrap.Modal('#staticBackdrop')
    const myModal2 = new bootstrap.Modal('#staticBackdrop2')
</script>
<?php include __DIR__ . '/../parts/foot.php' ?>