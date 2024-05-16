    <?php
    require __DIR__ . '/../config/pdo-connect.php';
    $title = '生前契約列表-有權限';
    $pageName = 'project';

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }

    $perPage = 20; # 每頁有幾筆
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
    <?php include __DIR__ . '/../parts/head.php' ?>
    <?php include __DIR__ . '/../parts/navbar.php' ?>

    <!-- page頁籤 -->
    <div id="content">
        <h1>生前契約列表-有權限</h1>
    </div>
    <div class="container">
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'add-project' ? 'active' : '' ?>" href="add-project.php" style="Text-decoration:none; color:white">新增方案 <i class="fa-solid fa-circle-plus"></i></a></button>
            </div>
            <div class="p-2 bd-highlight">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- 前頁按鈕的功能 -->
                        <li class="page-item">
                            <a class="page-link" href="?page=1">
                                <i class="fa-solid fa-angles-left"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page >= 1 ? $page - 1 : '' ?>"><i class="fa-solid fa-angle-left"></i></a>
                        </li>
                        <!-- 前頁按鈕的功能 -->
                        <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                            if ($i >= 1 and $i <= $totalPages) : ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                        <?php endif;
                        endfor; ?>
                        <!-- 後頁按鈕的功能 -->
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page <= $totalPages ? $page + 1 : '' ?>"><i class="fa-solid fa-angle-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
                        </li>
                        <!-- 後頁按鈕的功能 -->
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <form id="form1" name="form1" onsubmit="sendMultiDel(event)">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center; vertical-align: middle;">
                                <th>project_id</th>
                                <th>project_level</th>
                                <th>project_name</th>
                                <th>project_content</th>
                                <th>project_fee</th>
                                <th>編輯</th>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <!-- table欄位 -->
                        <!-- 欄位值 -->
                        <tbody>
                            <?php foreach ($rows as $r) : ?>
                                <tr style="vertical-align: middle;">
                                    <td style="text-align: center"><?= $r['project_id'] ?></td>
                                    <td style="text-align: center"><?= $r['project_level'] ?></td>
                                    <td style="text-align: center"><?= $r['project_name'] ?></td>
                                    <td style="text-align: center"><?= $r['project_content'] ?></td>
                                    <td style="text-align: center"><?= $r['project_fee'] ?></td>
                                    <td style="text-align: center">
                                        <a href="edit-project.php?project_id=<?= $r['project_id'] ?>">
                                            <i class="fa-solid fa-pen-to-square btn btn-warning"></i>
                                        </a>
                                    </td>
                                    <td style="text-align: center">
                                        <a href="javascript: deleteOne(<?= $r['project_id'] ?>)">
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
    <?php include __DIR__ . '/../parts/scripts.php' ?>
    <script>
        const deleteOne = (project_id) => {
            if (confirm(`是否要刪除編號為 ${project_id} 的資料?`)) {
                location.href = `delete-project.php?project_id=${project_id}`;
            }
        }
    </script>
    <?php include __DIR__ . '/../parts/foot.php' ?>