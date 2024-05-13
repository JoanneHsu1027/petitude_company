    <!-- 有權限 -->
    <?php
    require __DIR__ . '/config/pdo_connect.php';
    $title = '生前契約列表-有權限';
    $pageName = 'project-admin';

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($page < 1) {
    header('Location: ?page=1');
    exit;
    }

    $perPage = 25; # 每頁有幾筆
    # 算總筆數 $totalRows
    $t_sql = "SELECT COUNT(1) FROM project";
    $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
    $totalPages = ceil($totalRows / $perPage); # 總頁數

    $rows = []; # 預設值
    # 如果有資料的話
    if ($totalRows) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `project` ORDER BY project_id ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
    }

    ?>
    <?php include __DIR__ . '/parts/html_head.php' ?>
    <?php include __DIR__ . '/parts/navbar.php' ?>

    <div id="content">
        <h1>生前契約列表-有權限</h1>
    </div>
    <div class="container">
    <div class="row">
        <div class="col">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#">
                <i class="fa-solid fa-angles-left"></i>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#">
                <i class="fa-solid fa-angle-left"></i>
                </a>
            </li>

            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : ?>
                <?php if ($i >= 1 and $i <= $totalPages) : ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endif ?>
            <?php endfor ?>
            <li class="page-item">
                <a class="page-link" href="#">
                <i class="fa-solid fa-angle-right"></i>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">
                <i class="fa-solid fa-angles-right"></i>
                </a>
            </li>
            </ul>
        </nav>
        </div>
    </div>
            <!-- 新增/搜尋 -->
            <form class="d-flex">
                <a href="backend/add-project.php" class="btn btn-secondary fa-solid fa-circle-plus m-3"></a>
                <input class="form-control w-25 mt-2 me-2" style="height: 50px;" type="search" placeholder="Search" aria-label="Search">
                <a href=""><button class="btn btn-success mt-2" style="height: 50px;" type="submit">查詢</button></a>
            </form>
            <!-- 新增/搜尋 -->
    <div class="row">
        <div class="col">
        <form id="form1" name="form1" onsubmit="sendMultiDel(event)">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th><input type="checkbox" name="select-all" id="select-all" onclick="toggleAllCheckboxes()"></th>
                <th>project_id</th>
                <th>project_level</th>
                <th>project_name</th>
                <th>project_content</th>
                <th>project_fee</th>
                <th>編輯</th>
                <th>刪除</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                <td><input type="checkbox" name="project[]" value="<?= $r['project_id'] ?>"></td>
                <td><?= $r['project_id'] ?></td>
                <td><?= $r['project_level'] ?></td>
                <td><?= $r['project_name'] ?></td>
                <td><?= $r['project_content'] ?></td>
                <td><?= $r['project_fee'] ?></td>
                <!--
                <td><?= htmlentities($r['edit-project']) ?></td>
                -->
                <td>
                    <a href="/parts/edit-project.php?project_id=<?= $r['project_id'] ?>">
                    <i class="fa-solid fa-pen-to-square btn btn-warning"></i>
                    </a>
                </td>
                <td>
                    <a href="javascript: delete_one(<?= $r['project_id'] ?>)">
                    <i class="fa-solid fa-trash-can btn btn-danger"></i>
                    </a>
                </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        </form>
        </div>
    </div>
    </div>
    <?php include __DIR__ . '/parts/script.php' ?>
    <script>
    function delete_one(project_id){
        if(confirm(`是否要刪除編號為 ${project_id} 的資料?`)){
        location.href = `Angela\backend\delete-project.php?project_id=${project_id}`;
        }
    }

    function sendMultiDel(event) {
    event.preventDefault();
    const fd = new FormData(document.getElementById('form1'));
    fetch('/../multi-delete-project.php', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(result => {}).catch(ex => console.log(ex));
}

    function toggleAllCheckboxes() {
        const checkboxes = document.querySelectorAll('input[name="project[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
        });
    }
    </script>
    <?php include __DIR__ . '/parts/html_foot.php' ?>