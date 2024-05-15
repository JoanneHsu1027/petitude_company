    <?php
    require __DIR__ . './../config/pdo-connect.php';
    $title = '生前契約列表-有權限';
    $pageName = 'booking';

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

        $sql = sprintf("SELECT * FROM `booking` ORDER BY booking_id ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        $rows = $pdo->query($sql)->fetchAll();
    }

    ?>
    <?php include __DIR__ . '/../parts/head.php' ?>
    <?php include __DIR__ . '/../parts/navbar.php' ?>

    <!-- page頁籤 -->
    <div id="content">
        <h2>生前契約訂單-有權限</h2>
    </div>
    <div class="container">
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-primary"><a class=" <?= $pageName == 'add-booking' ? 'active' : '' ?>" href="add-booking.php" style="Text-decoration:none; color:white">新增預定 <i class="fa-solid fa-circle-plus"></i></a></button>
            </div>
            <div class="p-2 bd-highlight">
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
                <form id="form1" name="form1" onsubmit="sendMultiDel(event)">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center; vertical-align: middle;">
                                <th>booking_id</th>
                                <th>fk_b2c_id</th>
                                <th>fk_pet_id</th>
                                <th>fk_project_id</th>
                                <th>fk_reservation_id</th>
                                <th>booking_date</th>
                                <th>booking_note</th>
                                <th>編輯</th>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <!-- table欄位 -->
                        <!-- 欄位值 -->
                        <tbody>
                            <?php foreach ($rows as $r) : ?>
                                <tr style="vertical-align: middle;">
                                    <td style="text-align: center"><?= $r['booking_id'] ?></td>
                                    <td style="text-align: center"><?= $r['fk_b2c_id'] ?></td>
                                    <td style="text-align: center"><?= $r['fk_pet_id'] ?></td>
                                    <td style="text-align: center"><?= $r['fk_project_id'] ?></td>
                                    <td style="text-align: center"><?= $r['fk_reservation_id'] ?></td>
                                    <td style="text-align: center"><?= $r['booking_date'] ?></td>
                                    <td><?= $r['booking_note'] ?></td>
                                    <td style="text-align: center">
                                        <a href="edit-booking.php?booking_id=<?= $r['booking_id'] ?>">
                                            <i class="fa-solid fa-pen-to-square btn btn-warning"></i>
                                        </a>
                                    </td>
                                    <td style="text-align: center">
                                        <a href="javascript: deleteOne(<?= $r['booking_id'] ?>)">
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
        const deleteOne = (booking_id) => {
            if (confirm(`是否要刪除編號為 ${booking_id} 的資料?`)) {
                location.href = `delete-booking.php?booking_id=${booking_id}`;
            }
        }
    </script>
    <?php include __DIR__ . '/../parts/foot.php' ?>