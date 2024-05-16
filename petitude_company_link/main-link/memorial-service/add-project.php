<?php
require __DIR__ . '/../b2bweb/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';
if (!isset($_SESSION)) {
    session_start();
}
$title = '新增列表';
$pageName = 'add-project';
?>
<?php include __DIR__ . '/../parts/head.php' ?>
<?php include __DIR__ . '/../parts/navbar.php' ?>
<style>
    form .mb-3 .form-text {
        color: red;
        font-weight: 800;
    }
</style>
<div id="content" style="color:#0c5a67">
    <h2>生前契約列表-新增列表</h2>
</div>
<div class="container" style="color:#0c5a67">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form name="form1" onsubmit="sendData(event)">

                        <div class="mb-3">
                            <label for="project_level" class="form-label">方案等級</label>
                            <input type="text" class="form-control" id="project_level" name="project_level">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="project_name" class="form-label">方案名稱</label>
                            <input type="text" class="form-control" id="project_name" name="project_name">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="project_content" class="form-label">方案內容</label>
                            <input type="text" class="form-control" id="project_content" name="project_content">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="project_fee" class="form-label">方案費用</label>
                            <input type="text" class="form-control" id="project_fee" name="project_fee">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary"
                            style="background-color:#0c5a67; border-color:#0c5a67">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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

<?php include __DIR__ . '/../parts/scripts.php' ?>
<script>
    const fd = new FormData(document.form1);

    const sendData = e => {
        e.preventDefault(); // 不要讓 form1 以傳統的方式送出

        // 有通過檢查, 才要送表單

        const fd = new FormData(document.form1); // 沒有外觀的表單物件

        fetch('add-project-api.php', {
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
<?php include __DIR__ . '/../parts/foot.php' ?>