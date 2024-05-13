<!-- 沒有權限 -->
<?php
require __DIR__ . '/config/pdo_connect.php';
$title = '線上預約參觀-無權限';
$pageName = 'reservation-no-admin';

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

$sql = sprintf("SELECT * FROM `reservation` ORDER BY reservation_id ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include __DIR__ . '/parts/html_head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div id="content">
    <h1>線上預約參觀-無權限</h1>
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
            <th class="hidden-column"><input type="checkbox" name="select-all" id="select-all" onclick="toggleAllCheckboxes()"></th>
                <th>reservation_id</th>
                <th>fk_b2c_id</th>
                <th>fk_pet_id</th>
                <th>reservation_date</th>
                <th>note</th>
            <th class="hidden-column">編輯</th>
            <th class="hidden-column">刪除</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
            <td class="hidden-column"><input type="checkbox" name="reservation[]" value="<?= $r['reservation_id'] ?>"></td>
                <td><?= $r['reservation_id'] ?></td>
                <td><?= $r['fk_b2c_id'] ?></td>
                <td><?= $r['fk_pet_id'] ?></td>
                <td><?= $r['reservation_date'] ?></td>
                <td><?= $r['note'] ?></td>
            <td class="hidden-column">
                <?php if (isset($_SESSION['admin'])) : ?>
                <a href="/parts/edit-reservation.php?reservation_id=<?= $r['reservation_id'] ?>">
                <i class="fa-solid fa-pen-to-square btn btn-warning"></i>
                </a>
            <?php endif; ?>
            </td>
            <td class="hidden-column">
                <?php if (isset($_SESSION['admin'])) : ?>
                <a href="javascript: delete_one(<?= $r['reservation_id'] ?>)">
                <i class="fa-solid fa-trash-can btn btn-danger"></i>
                </a>
            <?php endif; ?>
            </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    </div>
</div>
</div>
<?php include __DIR__ . '/parts/script.php' ?>
<script>
function delete_one(reservation_id) {
    if (confirm(`是否要刪除編號為 ${reservation_id} 的資料?`)) {
        location.href = `delete-reservation.php?reservation_id=${reservation_id}`;
    }
};

function sendMultiDel(event) {
event.preventDefault();
const fd = new FormData(document.getElementById('form1'));
fetch('/../multi-delete-reservation.php', {
    method: 'POST',
    body: fd
}).then(r => r.json()).then(result => {}).catch(ex => console.log(ex));
}

function toggleAllCheckboxes() {
    const checkboxes = document.querySelectorAll('input[name="reservation[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = !checkbox.checked;
    });
}

</script>

<?php include __DIR__ . '/parts/html_foot.php' ?>
