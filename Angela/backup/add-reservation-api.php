    <?php
    // require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';

    header('Content-Type: application/json');

    $output = [
    'success' => false, # 有沒有新增成功
    'bodyData' => $_POST,
    'newId' => 0, # 追踨程式執行的編號
    ];

// TODO: 欄位資料檢查
    if (!isset($_POST['reservation_date'])) {
        echo json_encode($output);
        exit;
    }

    $reservationDate = DateTime::createFromFormat('Y-m-d', $_POST['reservation_date']);
    if (!$reservationDate) {
    // 日期格式不正确，返回错误消息或采取其他适当的错误处理措施
    $output['error'] = "Invalid date format";
    echo json_encode($output);
    exit;
    }

    $reservation_date_formatted = $reservationDate->format('Y-m-d');

    $sql = "INSERT INTO `reservation` (
        `fk_b2c_id`, `fk_pet_id`, `reservation_date`, `note`) VALUES(
        ?, 
        ?, 
        ?,  
        ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['fk_b2c_id'],
        $_POST['fk_pet_id'],
        $reservation_date_formatted, 
        $_POST['note']
    ]);

    $output['success'] = !!$stmt->rowCount();
    # 新增了幾筆
    $output['newId'] = $pdo->lastInsertId();
    # 取得最近的新增資料的primary key

    echo json_encode($output, JSON_UNESCAPED_UNICODE);