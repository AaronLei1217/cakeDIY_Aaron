<?php
require_once('php/db2.php');

if (isset($_GET['cid'])) {
    $cakeId = $_GET['cid'];

    // 使用預處理語句獲取指定ID的產品詳細資訊
    $sql = 'SELECT * FROM cake WHERE cid = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $cakeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $cakeDetail = $result->fetch_assoc();

        // 將詳細資訊轉換為JSON格式並返回給AJAX
        echo json_encode($cakeDetail);
    } else {
        // 若未找到對應產品，回傳空JSON物件
        echo '{}';
    }
} else {
    // 若未提供產品ID，回傳空JSON物件
    echo '{}';
}
?>