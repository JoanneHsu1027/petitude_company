    <!-- 有權限 -->
    <?php
    require __DIR__ . '/config/pdo_connect.php';
    $title = '預約參觀列表-有權限';
    $pageName = 'reservation-admin';

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($page < 1) {
    header('Location: ?page=1');
    exit;
    }

    $perPage = 25; # 每頁有幾筆
    # 算總筆數 $totalRows
    $t_sql = "SELECT COUNT(1) FROM reservation";
    $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
    $totalPages = ceil($totalRows / $perPage); # 總頁數

    $rows = []; # 預設值
    # 如果有資料的話
    if ($totalRows) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `reservation` ORDER BY reservation_id DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
    }

    ?>
    <?php include __DIR__ . '/parts/html_head.php' ?>
    <?php include __DIR__ . '/parts/navbar.php' ?>

    <div id="content">
        <h1>預約參觀列表-有權限</h1>
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
    <div class="row">
        <div class="col">
        <form name="form1" onsubmit="sendMultiDel(event)">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th><button type="submit">勾選</button></th>
                <th>刪除</th>
                <th>reservation_id</th>
                <th>fk_b2c_id</th>
                <th>fk_pet_id</th>
                <th>reservation_date</th>
                <th>note</th>
                <th>編輯</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                <td><input type="checkbox" name="reservation" value="<?= $r['reservation_id'] ?>"></td>
                <td>
                    <a href="javascript: delete_one(<?= $r['reservation_id'] ?>)">
                    <i class="fa-solid fa-trash btn btn-danger"></i>
                    </a>
                </td>
                <td><?= $r['reservation_id'] ?></td>
                <td><?= $r['fk_b2c_id'] ?></td>
                <td><?= $r['fk_pet_id'] ?></td>
                <td><?= $r['reservation_date'] ?></td>
                <td><?= $r['note'] ?></td>
                <!--
                <td><?= htmlentities($r['edit']) ?></td>
                -->
                <td>
                    <a href="edit.php?reservation_id=<?= $r['reservation_id'] ?>">
                    <i class="fa-solid fa-pen-to-square btn btn-warning"></i>
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
    function delete_one(booking_id){
        if(confirm(`是否要刪除編號為 ${reservation_id} 的資料?`)){
        location.href = `delete.php?reservation_id=${reservation_id}`;
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
    <?php include __DIR__ . '/parts/html_foot.php' ?>