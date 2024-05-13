<?php
    require __DIR__ . '/config/pdo_connect.php';
header('Content-Type: application/json');
$output = [
    'success' => false, # 有沒有登入成功
    'postData' => $_POST,
    'code' => 0, # 追踨程式執行的編號
];

if (empty($_POST['email']) or empty($_POST['password'])) {
    # 欄位資料不足
    $output['code'] = 400;
} else {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM petcompany WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (empty($row)) {
        # 帳號是錯的
        $output['code'] = 410;
    } else {
        // 驗證密碼
        $output['success'] = password_verify($password, $row["password"]);

        $output['code'] = $output['success'] ? 200 : 420;

        if ($output['success']) {
            // 設定 session
            $_SESSION['admin'] = [
                'id' => $row['id'],
                'email' => $email,
                'nickname' => $row['nickname'],
            ];
        }
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
