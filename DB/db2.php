<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = "127.0.0.1:3306"; //"127.0.0.1:33306"; 
$user = "root";
$pwd  = "";
$db   = "cake";
$mysqli = new mysqli($host, $user, $pwd, $db);



//測試是否連上資料庫
//
// $link = @mysqli_connect(
//     '127.0.0.1:33306',  // MySQL主機名稱 
//     'root',       // 使用者名稱 
//     '',  // 密碼 
//     'cake' // 預設使用的資料庫名稱
// );   
// if (!$link) {
//     echo "MySQL資料庫連接錯誤!<br/>";
//     exit();
// } else {
//     echo "MySQL資料庫test連接成功!<br/>";
// }
