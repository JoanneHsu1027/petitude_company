    <?php
    require __DIR__ . '/../parts/admin-required.php';
    require __DIR__ . '/../config/pdo_connect.php';
    
    header('Content-Type: application/json');
    $output = [
    'success' => false, # 有沒有新增成功
    'postData' => $_POST,
    'error' => '資料沒有修改',
    'code' => 0, # 追踨程式執行的編號
    ];


    if (!empty($_POST) && !empty($_POST['sid'])) {
    // TODO: 檢查各個欄位的資料, 有沒有符合規定

    if (strlen($_POST['name']) < 2) {
        $output['error'] = '請填寫正確的姓名';
        $output['code'] = 300;
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($email === false) {
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

    $sql = "UPDATE `petcompany` SET 
    `name`=?,
    `email`=?,
    `mobile`=?,
    `birthday`=?,
    `address`=?
    WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['name'],
        $email,
        $_POST['mobile'],
        $birthday,
        $_POST['address'],
        $_POST['sid']
    ]);
    $output['code'] = 200;
    $output['success'] = boolval($stmt->rowCount());
    }




    echo json_encode($output, JSON_UNESCAPED_UNICODE);