    <!-- 有權限 -->
    <?php
    require __DIR__ . '/../config/pdo_connect.php';
    $title = '通訊錄列表';
    $pageName = 'list';

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($page < 1) {
    header('Location: ?page=1');
    exit;
    }

    $perPage = 25; # 每頁有幾筆
    # 算總筆數 $totalRows
    $t_sql = "SELECT COUNT(1) FROM booking";
    $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
    $totalPages = ceil($totalRows / $perPage); # 總頁數

    $rows = []; # 預設值
    # 如果有資料的話
    if ($totalRows) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `booking` ORDER BY booking_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
    }

    ?>
    <?php include __DIR__ . '/../parts/html_head.php' ?>
    <?php include __DIR__ . '/../parts/navbar.php' ?>
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
    <div class="row">
        <div class="col">
        <form name="form1" onsubmit="sendMultiDel(event)">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th><button type="submit" class="btn btn-danger">刪除所選</button></th>
                <th><i class="fa-solid fa-trash"></i></th>
                <th>booking_id</th>
                <th>fk_b2c_id</th>
                <th>fk_pet_id</th>
                <th>fk_project_id</th>
                <th>fk_reservation_id</th>
                <th>booking_date</th>
                <th>booking_note</th>
                <th><i class="fa-solid fa-file-pen"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                <td><input type="checkbox" name="booking" value="<?= $r['booking_id'] ?>"></td>
                <td>
                    <a href="javascript: delete_one(<?= $r['booking_id'] ?>)">
                    <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
                <td><?= $r['booking_id'] ?></td>
                <td><?= $r['fk_b2c_id'] ?></td>
                <td><?= $r['fk_pet_id'] ?></td>
                <td><?= $r['fk_project_id'] ?></td>
                <td><?= $r['fk_reservation_id'] ?></td>
                <td><?= $r['booking_date'] ?></td>
                <td><?= $r['booking_note'] ?></td>
                <!--
                <td><?= htmlentities($r['edit']) ?></td>
                -->
                <td>
                    <a href="edit.php?booking_id=<?= $r['booking_id'] ?>">
                    <i class="fa-solid fa-file-pen"></i>
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
    <?php include __DIR__ . '/../parts/script.php' ?>
    <script>
    function delete_one(booking_id){
        if(confirm(`是否要刪除編號為 ${booking_id} 的資料?`)){
        location.href = `delete.php?booking_id=${booking_id}`;
        }
    }

    function sendMultiDel(event){
        event.preventDefault();

        const fd = new FormData(document.form1);

        fetch('handle-multi-delete.php', {
        method: 'POST',
        body: fd
        }).then(r=>r.json()).then(result=>{

        }).catch(ex=>console.log(ex));
    }
    </script>
    <?php include __DIR__ . '/../parts/html_foot.php' ?>