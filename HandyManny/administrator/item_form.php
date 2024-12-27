<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../style.css" />

    <!--網站名稱-->
    <title>
        <?php showtitle(); ?>
    </title>

    <!--body樣式-->
    <style>
        body {
            background-image: linear-gradient(to left, white 65%, #FBE5D6 35%);
            background-attachment: fixed;
            background-position: center;
            background-size: 100%;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php showheader() ?>
        <div
            style="float:right; width:14%; margin-top:-58px; margin-right:10px; font-size:20px; font-family:DFKai-sb; color:#203057;">
            <?php
            $userkind = $_SESSION['userkind'];
            if ($userkind == "student") {
                echo "學生";
            } else if ($userkind == "administrator") {
                echo "管理者";
            } else {
                echo "您好";
            }
            ?>&nbsp;-
            <?php
            echo $_SESSION['name'];
            ?>&nbsp;
        </div>
    </div>
    

    <!--線-->
    <hr style="height:3px; margin-top:0px;">
    
    <!-- 路徑欄 -->
    <nav style="--bs-breadcrumb-divider: '>'; margin-left:10px; margin-top:-10px;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="reader_index.php"
                    style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-decoration:none; user-select:none;">首頁</a>
            </li>
            <li class="breadcrumb-item"><a href="item_management.php" 
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-decoration:none; user-select:none;">物品清單管理</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                新增物品</li>
        </ol>
    </nav>

    <!--左邊區塊-->
    <div style="float:left; height:150%; width:35%;">

        <img src="../imgs/fix.png" style="float:left; width:90%; margin-left:3%; margin-top:30%;">

    </div>

    <!--右邊區塊-->
    <div style="float:left; height:100%; width:65%;">

        <script>
            function logout() {
                answer = confirm("你確定要登出嗎？");
                if (answer)
                    location.href = "../login.php";
            }
        </script>

        </br></br>

        <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size: 40px; margin-left:41%">新  增  物  品&emsp;&emsp;
            <span style="color:red; font-family:Times New Roman,'DFKai-sb'; font-size:18.5px;"><b>＊為必填</b></span>
        </h2>
        
        <br>

        <div style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:24px; float:left; margin-left:28%">
            <form method="post" action="item_judge.php" id="subform">
                <!-- 物品編號 -->
                <label for="ItemID"><span style="color:red;">＊</span>物品編號：</label>
                <input type="text" style="width:320px;" id="ItemID" name="ItemID" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- 物品名稱 -->
                <label for="ItemName"><span style="color:red;">＊</span>物品名稱：</label>
                <input type="text" style="width:320px;" id="ItemName" name="ItemName" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- 物品狀態 -->
                <label for="ItemState"><span style="color:red;">＊</span>物品狀態：</label>
                <input type="radio" name="ItemState" value="使用中" CHECKED>使用中
                <input type="radio" name="ItemState" value="備用中">備用中<br><br>
                <!-- 物品存放地點 -->
                <label for="LID"><span style="color:red;">＊</span>存放地點：</label>
                <input type="text" style="width:320px;" id="LID" name="LID" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- 送出按鈕 -->
                <p style="text-align:center;">
                    <button
                        style="background-color:#203057;font-size:20px; font-family:DFKai-sb; color:white; height:40px; width:150px; border-radius:3px;"
                        name="send" onclick="sub(); chk_if_exist();">送出</button>
                    <input class="btn" type="button" id="back" value="返回" onclick="location.href = 'item_management.php'" />
                </p>
            </form>
            <script>
                function sub() {
                    var mas = "是否新增此物品？";
                    var agree_yn = document.getElementById('denyYN');
                    if (agree_yn.checked) {
                        if (confirm(mas) == true) {
                            if ($ItemID == "" && $Reason == ""){
                                event.preventDefault();
                            }
                            else {
                                document.getElementById('subform').submit();
                            }
                        }
                        else {
                            event.preventDefault();
                        }
                    }
                }
            </script>

            <br>
        </div>
</body>

</html>