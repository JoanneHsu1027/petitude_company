    <?php
    // 需要在後端執行的一些驗證或其他程序
    require __DIR__ . '/../parts/admin-required.php';
    // 用來建立到資料庫的 PDO 連接
    require __DIR__ . '/../config/pdo_connect.php';
    // 將回傳的資料類型設置為 JSON 格式
    header('Content-Type: application/json');
    // 初始化$output 陣列，用於儲存後續的回傳資料，包括是否成功、提交的資料、錯誤訊息和程式碼
    $output = [
    'success' => false, # 有沒有新增成功
    'postData' => $_POST,
    'error' => '',
    'code' => 0, # 追踨程式執行的編號
    ];


    if (!empty($_POST)) {
    // TODO: 程式檢查了 $_POST 陣列是否為空，若不是空的，則進行下一步驗證

    // 對提交的表單資料進行基本的驗證，如姓名是否太短、Email 是否有效等。若發現任何錯誤，程式將設置相應的錯誤訊息和程式碼，並將其以 JSON 格式回傳
    if (strlen($_POST['name']) < 2) {
        $output['error'] = '請填寫正確的姓名';
        $output['code'] = 300;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        # $email = ''; # 如果不是必填的狀況
        $output['error'] = '請填寫正確的 Email';
        $output['code'] = 400;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }


    $birthday = null;
    if (!empty($_POST['birthday'])) {
        $birthday = strtotime($_POST['birthday']);
        if ($birthday === false) {
        # 不是合法的日期字串
        $birthday = null;
        } else {
        $birthday = date('Y-m-d', $birthday);
        }
    }


    // 將提交的資料準備好，準備插入到資料庫中。這包括將生日轉換為日期格式
    $sql = "INSERT INTO petcompany 
    (`name`, `email`, `mobile`, `birthday`, `address`, `created_at`) 
    VALUES 
    (?, ?, ?, ?, ?, NOW())";
    // 使用 $pdo->prepare() 準備來查詢SQL，並使用 $stmt->execute() 來執行查詢。傳遞了一個包含要插入到資料庫的值的陣列給 execute()
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['name'],
        $email,
        $_POST['mobile'],
        $birthday,
        $_POST['address']
    ]);

    $output['success'] = boolval($stmt->rowCount());
    }




    echo json_encode($output, JSON_UNESCAPED_UNICODE);