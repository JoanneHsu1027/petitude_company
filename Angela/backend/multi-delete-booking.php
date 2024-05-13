<?php
// 檢查是否有 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否有選中的項目
    if(isset($_POST['booking']) && !empty($_POST['booking'])) {
        // 獲取選中的項目
        $booking_id = $_POST['booking'];
        
        // 在這裡添加刪除多個項目的程式碼，例如使用迴圈逐個刪除
        
        // 刪除完成後返回成功消息
        echo json_encode(array("status" => "success", "message" => "刪除成功"));
    } else {
        // 如果沒有選中的項目，返回錯誤消息
        echo json_encode(array("status" => "error", "message" => "未選中任何項目"));
    }
} else {
    // 如果不是 POST 請求，返回錯誤消息
    echo json_encode(array("status" => "error", "message" => "僅接受 POST 請求"));
}
?>
