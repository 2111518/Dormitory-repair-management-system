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

    <!--左邊區塊-->
    <div style="float:left; height:150%; width:35%;">

        <br>

        <!--通知欄-->
        <div style="text-align:center;">
            <p style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:32px; margin-top:10px;">通 知 欄</p>
            <div align="center"
                style=" width:505px; height:450px; overflow-y:scroll; /*縱向滾動條始終顯示*/ overflow-x:none; margin-left:15px;">
                <table
                    style="color:black; background-color:white; font-family:Times New Roman,'DFKai-sb'; font-size:18px; width:480px; height:450px;">
                    <?php
                    $sql = "SELECT `ItemName`, `AState` 
                        FROM `application`
                        JOIN `item` ON `application`.`ItemID` = `item`.`ItemID`
                        WHERE `UID1` = '" . $_SESSION['uid'] . "' 
                        AND `AState` IN ('未審核', '採購中', '維修中')
                        ORDER BY `Time` DESC;";
                    $result = mysqli_query($con, $sql);
                    $num = $con->query($sql);
                    if ($num) {
                        $total = mysqli_num_rows($num);
                    }
                    while ($application = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<th style='width:20%;'>申請物品：</th>";
                        echo "<td>" . $application['ItemName'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th style='width:20%;'>申請狀況：</th>";
                        echo "<td >" . $application['AState'] ."</td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }
                    if ($total == 0) {
                        echo "<tr> <td style='height:450px;text-align: center;'>尚未推薦書刊</td> </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <br>

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

        <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size: 40px; margin-left:41%">報  修  申  請&emsp;&emsp;
            <span style="color:red; font-family:Times New Roman,'DFKai-sb'; font-size:18.5px;"><b>＊為必填</b></span>
        </h2>
        
        <br>

        <div style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:24px; float:left; margin-left:28%">
            <form method="post" action="application_judge.php" id="subform">
                <!-- 書名欄位 -->
                <label for="ItemID"><span style="color:red;">＊</span>物品編號：</label>
                <input type="text" style="width:320px;" id="ItemID" name="ItemID" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- 理由欄位 -->
                <label for="Reason">報修原因：</label><br>
                <textarea id="Reason" style="width:483px; height:200px; resize:none;" name="Reason" autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"></textarea><br>
                <br><br>
                <input type="hidden" id="isbnText" name="isbnTest" value="0" >
                <!-- 送出按鈕 -->
                <p style="text-align:center;">
                    <!-- <input type="submit"
                        style="background-color:#203057;font-size:20px; font-family:DFKai-sb; color:white; height:40px; width:150px; border-radius:3px;"
                        name="send" value="送出" /> -->

                    <button
                        style="background-color:#203057;font-size:20px; font-family:DFKai-sb; color:white; height:40px; width:150px; border-radius:3px;"
                        name="send" onclick="sub(); chk_if_exist();">送出</button>
                </p>
            </form>
            <script>
                function sub() {
                    var mas = "是否確認推薦此圖書？";
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