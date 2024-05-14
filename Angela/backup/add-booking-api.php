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
    if (!isset($_POST['booking_date'])) {
        echo json_encode($output);
        exit;
    }

    $bookingDate = DateTime::createFromFormat('Y-m-d', $_POST['booking_date']);
    
if (!$bookingDate) {
    // 日期格式不正确，返回错误消息或采取其他适当的错误处理措施
    $output['error'] = "Invalid date format";
    echo json_encode($output);
    exit;
}

    $booking_date_formatted = $bookingDate->format('Y-m-d');

    $sql = "INSERT INTO `booking` (
        `fk_b2c_id`, `fk_pet_id`, `fk_project_id`, `fk_reservation_id`, `booking_date`, `booking_note`) VALUES(
        ?, 
        ?, 
        ?, 
        ?, 
        ?,
        ?)";

    // 使用 $pdo->prepare() 準備來查詢SQL，並使用 $stmt->execute() 來執行查詢。傳遞了一個包含要插入到資料庫的值的陣列給 execute()
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['fk_b2c_id'],
        $_POST['fk_pet_id'],
        $_POST['fk_project_id'],
        $_POST['fk_reservation_id'],
        $booking_date_formatted, 
        $_POST['booking_note']
    ]);

    $output['success'] = !!$stmt->rowCount();
    # 新增了幾筆
    $output['newId'] = $pdo->lastInsertId();
    # 取得最近的新增資料的primary key

    echo json_encode($output, JSON_UNESCAPED_UNICODE);