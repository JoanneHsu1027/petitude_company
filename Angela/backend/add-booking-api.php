    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    // 將回傳的資料類型設置為 JSON 格式
    header('Content-Type: application/json');
    // 初始化$output 陣列，用於儲存後續的回傳資料，包括是否成功、提交的資料、錯誤訊息和程式碼
    $output = [
    'success' => false, # 有沒有新增成功
    'bodyData' => $_POST,
    'newId' => 0, # 追踨程式執行的編號
    ];

// TODO: 欄位資料檢查
    if (!isset($_POST['booking_id'])) {
        echo json_encode($output);
        exit;
    }

    $bookingDate = strtotime($_POST['booking_date']);
    if($bookingDate === false){
        $bookingDate = null;
    }else{
        $bookingDate = date('Y-m-d', $bookingDate);
    }




    // 將提交的資料準備好，準備插入到資料庫中。這包括將生日轉換為日期格式
    $sql = "INSERT INTO `booking` (
        `booking_id`, `fk_b2c_id`, `fk_pet_id`, `fk_project_id`, `fk_reservation_id`, `booking_date`, `booking_note`) VALUES(
        ?, 
        ?, 
        ?, 
        ?, 
        ?,
        ?,
        ?,)";

    // 使用 $pdo->prepare() 準備來查詢SQL，並使用 $stmt->execute() 來執行查詢。傳遞了一個包含要插入到資料庫的值的陣列給 execute()
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['booking_id'],
        $_POST['fk_b2c_id'],
        $_POST['fk_pet_id'],
        $_POST['fk_project_id'],
        $_POST['fk_reservation_id'],
        $booking_date,
        $_POST['booking_note']
    ]);

    $output['success'] = !!$stmt->rowCount();
    # 新增了幾筆
    $output['newId'] = $pdo->lastInsertId();
    # 取得最近的新增資料的primary key

    echo json_encode($output, JSON_UNESCAPED_UNICODE);