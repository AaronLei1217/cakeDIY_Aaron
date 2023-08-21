<?php
require_once('php/db2.php');

$sql = 'select * from cake';
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../resources/css/menu2.css">
    <link rel="stylesheet" href="../resources/css/Navbar.css">
    <link rel="stylesheet" href="../resources/css/footer2.css">
    <link rel="stylesheet" href="../resources/css/topBtn.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <!-- Back-to-Top Button -->
    <button onclick="topFunction()" class="topBtn" id="topBtn"></button>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbarTitle">
            <a href="../public/mainpage.html"><img src="../image/icon-noBorder-whiteFont.png"></a>
        </div>
        <div class="hambuger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="navbarLink">
            <ul id="login_check" name="login_check"></ul>
        </div>
    </nav>

    <!-- Menu -->
    <main class="menu">

        <!-- Type Navbar -->
        <p style="margin:120px 0 0 0 "></p>
        <div class="kindNavbar" id="kindNavbar">
            <div class="kindBlock">
                <div><b>選擇種類：</b></div>
                <label class="container">全品項
                    <input type="radio" checked="checked" name="radio" id="cake" onclick="kindFilter('')">
                    <span class="checkmark"></span>
                </label>
                <label class="container">蛋糕
                    <input type="radio" name="radio" id="cake" onclick="kindFilter('蛋糕')">
                    <span class="checkmark"></span>
                </label>
                <label class="container">點心
                    <input type="radio" name="radio" id="cookie" onclick="kindFilter('點心')">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="dropdown">
                <button class="dropbtn">排序方式</button>
                <div class="dropdown-content">
                    <a herf="javascript:void(0);" onclick="cakeSort('priceAsc')">價格：由低到高</a>
                    <a herf="javascript:void(0);" onclick="cakeSort('priceDesc')">價格：由高到低</a>
                    <a herf="javascript:void(0);" onclick="cakeSort('levelAsc')">難度：由低到高</a>
                    <a herf="javascript:void(0);" onclick="cakeSort('levelDesc')">難度：由高到低</a>
                </div>
            </div>
        </div>

        <!-- Menu Info -->
        <div class="menuBlock2">

            <?php
            while ($row = $result->fetch_assoc()) {
                $level = '';
                if ($row['level'] == 1) {
                    $level = '★';
                } else if ($row['level'] == 2) {
                    $level = '★★';
                } else if ($row['level'] == 3) {
                    $level = '★★★';
                }
                if ($row['cid'] != 0) {
                    echo
                        "
                    <div class=\"backgroundDiv\">
                        <div class=\"menuInfoDiv\" id=\"menuInfo\" data-cakeid={$row['cid']}>
                            <a href=\"detail.php?cid={$row['cid']}\">
                                <img src=\"{$row['cImg1']}\">
                                <div class=\"menuInfoContent\" id=\"menuInfoContent\">
                                    <ul class=\"menuInfo\" id=\"menuInfo\">
                                        <li class=\"titleName\">{$row['cName']}</li>
                                        <li class=\"scdName\">難度 {$level}</li>
                                        <li class=\"scdName\">$ {$row['price']}</li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    ";
                }

            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 64px;">
        <div class="footerContainer">
            <div class="footerRow">
                <div class="footerCol">
                    <h4>DIY蛋糕</h4>
                    <ul>
                        <li><a href="">關於我們</a></li>
                        <li><a href="">常見問題</a></li>
                    </ul>
                </div>
                <div class="footerCol">
                    <h4>服務內容</h4>
                    <ul>
                        <li><a href="">立即預約</a></li>
                        <li><a href="">產品介紹</a></li>
                    </ul>
                </div>
                <div class="footerCol">
                    <h4>聯絡我們</h4>
                    <div class="socialLinks">
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-twitter"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                        <a href=""><i class="fab fa-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
<script src="../resources/js/login.js"></script>
<script src="../resources/js/navbar.js"></script>
<script src="../resources/js/topBtn.js"></script>

<script>
    // 在此添加全局变量来记录客人点击的种类
    let selectedKind = '';

    // 蛋糕種類篩選 3.0
    function kindFilter(kind) {
        fetch(`php/menu/kindfilter.php?kind=${kind}`)
            .then(response => response.json())
            .then(sortedCakes => {
                // 更新種類全域變數
                selectedKind = kind;
                renderCakes(sortedCakes);
            })
            .catch(error => console.error('請求失敗：', error));
    }

    // 接收排序方式参数，價格排序ajax 3.0 
    function cakeSort(sortType) {
        // 增加種類參數
        fetch(`php/menu/cakesort.php?sortType=${sortType}&kind=${selectedKind}`)
            .then(response => response.json())
            .then(sortedCakes => {
                renderCakes(sortedCakes);
            })
            .catch(error => console.error('請求失敗：', error));
    }

    // 畫面總攬render
    function renderCakes(cakes) {
        var menuBlock2 = document.querySelector('.menuBlock2');
        menuBlock2.innerHTML = '';

        cakes.forEach(cake => {
            // level = '';
            if (cake.level === 1) {
                cake.level = '★';
            } if (cake.level === 2) {
                cake.level = '★★';
            } if (cake.level === 3) {
                cake.level = '★★★';
            }

            if (cake.cid == 0) {
                return;
            }

            menuBlock2.innerHTML += `
            <div class="backgroundDiv">
                <div class="menuInfoDiv" id="menuInfo" data-cakeid="${cake.cid}" > <!-- 添加data-cakeid屬性 -->
                    <a href="javascript:void(0);" onclick="showProductDetail(${cake.cid})"><img src="${cake.cImg1}"></a> 
                    <div class="menuInfoContent" id="menuInfoContent">
                        <ul class="menuInfo" id="menuInfo">
                            <li class="titleName">${cake.cName}</li>
                            <li class="scdName">難度 ${cake.level}</li>
                            <li class="scdName">$ ${cake.price}</li>
                        </ul>
                    </div>
                </div>
             </div>
            `;
        });
    }

    // 點擊產品總攬其中一個div後
    function showProductDetail(cakeId) {
        window.location.href = `detail.php?cid=${cakeId}`;
    }

</script>

</html>