<?php
require_once('../db2.php');

$sortType = $_REQUEST['sortType'];
$kind = $_REQUEST['kind'];

// 根据排序方式参数和种类参数生成不同的排序SQL语句
if ($sortType === 'priceAsc') {
    if ($kind !== '' ) {
        // 如果种类参数不为空，则按种类和价格升序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY price ASC";
    } else {
        // 否则，只按价格升序排序
        $sql = 'SELECT * FROM cake ORDER BY price ASC';
    }
} else if ($sortType === 'priceDesc') {
    if ($kind !== '' ) {
        // 如果种类参数不为空，则按种类和价格降序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY price DESC";
    } else {
        // 否则，只按价格降序排序
        $sql = 'SELECT * FROM cake ORDER BY price DESC';
    }
} else if ($sortType === 'levelAsc') {
    if ($kind !== '' ) {
        // 如果种类参数不为空，则按种类和難度降序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY level ASC";
    } else {
        // 否则，只按難度降序排序
        $sql = 'SELECT * FROM cake ORDER BY level DESC';
    }
} else if ($sortType === 'levelDesc') {
    if ($kind !== '' ) {
        // 如果种类参数不为空，则按种类和難度降序排序
        $sql = "SELECT * FROM cake WHERE kind = ? ORDER BY level DESC";
    } else {
        // 否则，只按難度降序排序
        $sql = 'SELECT * FROM cake ORDER BY level ASC';
    }
} else {
    // 默认按价格升序排序
    $sql = 'SELECT * FROM cake ORDER BY price ASC';
}

// 參數綁定
if ($kind !== '') {
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $kind);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $mysqli->query($sql);
}

$cakes = array();

while ($row = $result->fetch_assoc()) {
    $cakes[] = $row;
}

// header返回格式設定，指定返回的是 JSON 格式
header('Content-Type: application/json');

// 将查询结果转换为 JSON 格式并返回给 AJAX 请求
echo json_encode($cakes);
?>