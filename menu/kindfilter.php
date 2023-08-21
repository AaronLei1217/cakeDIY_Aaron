<?php
require_once('../db2.php');

// 獲取前端參數
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

// 設定header 指定回傳的格式
header('Content-Type: application/json');

echo json_encode($cakes);
?>