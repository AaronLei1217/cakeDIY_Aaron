<?php
require_once('../db2.php'); // 引入資料庫連接文件

$sortType = $_REQUEST['sortType']; // 獲取排序類型參數
$kind = $_REQUEST['kind']; // 獲取蛋糕種類參數

// 根據排序方式和種類參數，生成不同的 SQL 查詢語句
if ($sortType === 'priceAsc') {
    if ($kind !== '' ) {
        // 如果蛋糕種類不為空，則按種類和價格升序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY price ASC";
    } else {
        // 否則，只按價格升序排序
        $sql = 'SELECT * FROM cake ORDER BY price ASC';
    }
} else if ($sortType === 'priceDesc') {
    if ($kind !== '' ) {
        // 如果蛋糕種類不為空，則按種類和價格降序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY price DESC";
    } else {
        // 否則，只按價格降序排序
        $sql = 'SELECT * FROM cake ORDER BY price DESC';
    }
} else if ($sortType === 'levelAsc') {
    if ($kind !== '' ) {
        // 如果蛋糕種類不為空，則按種類和難度升序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY level ASC";
    } else {
        // 否則，只按難度降序排序
        $sql = 'SELECT * FROM cake ORDER BY level DESC';
    }
} else if ($sortType === 'levelDesc') {
    if ($kind !== '' ) {
        // 如果蛋糕種類不為空，則按種類和難度降序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY level DESC";
    } else {
        // 否則，只按難度升序排序
        $sql = 'SELECT * FROM cake ORDER BY level ASC';
    }
} else {
    // 默認按價格升序排序
    $sql = 'SELECT * FROM cake ORDER BY price ASC';
}

// 如果蛋糕種類不為空，則進行參數綁定
if ($kind !== '') {
    $stmt = $mysqli->prepare($sql); // 預備 SQL 語句
    $stmt->bind_param('s', $kind); // 綁定參數
    $stmt->execute(); // 執行查詢
    $result = $stmt->get_result(); // 獲取結果
} else {
    $result = $mysqli->query($sql); // 直接執行 SQL 查詢
}

$cakes = array(); // 初始化蛋糕數組

while ($row = $result->fetch_assoc()) {
    $cakes[] = $row; // 將查詢結果添加到蛋糕數組中
}

// 設定返回格式為 JSON
header('Content-Type: application/json');

// 將查詢結果轉換為 JSON 格式並返回給 AJAX 請求
echo json_encode($cakes);
?>
