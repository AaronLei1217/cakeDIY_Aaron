<?php
require_once('../db2.php');

// 获取从前端传递过来的查询种类参数
$kind = $_REQUEST['kind'];

$sql = '';
if($kind == '') {
    $sql = "SELECT * FROM cake";
} else {
    $sql = "SELECT * FROM cake WHERE kind = ?";
}

$stmt = $mysqli->prepare($sql);
if($kind != '') {
    $stmt->bind_param('s', $kind);
}

$stmt->execute();

$result = $stmt->get_result();

$cakes = array();

while ($row = $result->fetch_assoc()) {
    $cakes[] = $row;
}

// 设置响应头部，指定返回的是 JSON 格式的数据
header('Content-Type: application/json');

// 将查询结果转换为 JSON 格式并返回给 AJAX 请求
// var_dump($cakes);
echo json_encode($cakes);
?>