    <?php
    // require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    header('Content-Type: application/json');

    $output = [
    'success' => false, # 有沒有新增成功
    'bodyData' => $_POST,
    'newId' => 0, # 追踨程式執行的編號
    ];

    $sql = "INSERT INTO `project` (
        `project_level`, `project_name`, `project_content`, `project_fee`) VALUES
        (
        ?, 
        ?,
        ?, 
        ?)";

    // 使用 $pdo->prepare() 準備來查詢SQL，並使用 $stmt->execute() 來執行查詢。傳遞了一個包含要插入到資料庫的值的陣列給 execute()
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['project_level'],
        $_POST['project_name'],
        $_POST['project_content'],
        $_POST['project_fee']
    ]);

    $output['success'] = !!$stmt->rowCount();
    # 新增了幾筆
    $output['newId'] = $pdo->lastInsertId();
    # 取得最近的新增資料的primary key

    echo json_encode($output, JSON_UNESCAPED_UNICODE);