    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';

    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

    if(!empty($sid)) {
    $sql = "DELETE FROM `petcompany` WHERE sid=$sid";
    $pdo->query($sql);
    }
    $backTo = 'list.php';
    if(! empty($_SERVER['HTTP_REFERER'])){
    $backTo = $_SERVER['HTTP_REFERER'];
    }
    header('Location: '. $backTo);
