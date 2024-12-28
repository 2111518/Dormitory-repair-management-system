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
        <?php showtitle() ?>
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
    <!-- Header + User辨認語法 -->
    <div id="header">
        <?php showheader() ?>
        <div
            style="float:right; width:14%; margin-top:-58px; margin-right:10px; font-size:20px; font-family:DFKai-sb; color:#203057;">
            <?php
            $userkind = $_SESSION['userkind'];
            if ($userkind == "reader") {
                echo "學生";
            } else if ($userkind == "admin") {
                echo "管理者";
            } else {
                echo "您好";
            }
            ?>&nbsp;-
            <?php echo $_SESSION['name']; ?>&nbsp;
        </div>
    </div>

    <!-- 登出語法 -->
    <script>
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../login.php";
        }
    </script>

    <!--線-->
    <hr style="height:3px; margin-top:0px;">

    <!--左邊區塊-->
    <div style="float:left; height:100%; width:35%;">

        <br>

        <!--通知欄-->
        <div style="text-align:center;">
            <p style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:32px; margin-top:10px;">通 知 欄</p>
            <div align="center"
                style=" width:505px; height:450px; overflow-y:scroll; /*縱向滾動條始終顯示*/ overflow-x:none; margin-left:15px;">
                <table
                    style="color:black; background-color:white; font-family:Times New Roman,'DFKai-sb'; font-size:18px; width:480px; height:450px;">
                    <?php
                    $sql = "SELECT `applicant`.`UName` AS `ApplicantName`,
                                    `item`.`ItemName` AS item_name, 
                                    `Time`
                            FROM `application` 
                            JOIN `user` AS applicant ON `application`.`UID1` = `applicant`.`UID`
                            JOIN `item` ON `application`.`ItemID` = `item`.`ItemID`
                            where `AState`='未審核' ORDER BY Time desc;";
                    $result = mysqli_query($con, $sql);
                    $num = $con->query($sql);
                    if ($num) {
                        $total = mysqli_num_rows($num);
                    }
                    if ($total >= 1) {
                        echo "<tr> <th style='color:#FF5151'>最新申請</th> </tr>";
                    }
                    else{
                        echo "<tr> <td style='height:450px;text-align: center;'>目前已無待處理申請</td> </tr>";
                    }

                    while ($application = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<th style='width:20%;'>申請時間：</th>";
                        echo "<td>" . $application['Time'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th style='width:20%;'>申請人：</th>";
                        echo "<td>" . $application['ApplicantName'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>報修物品：</th>";
                        echo "<td>" . $application['item_name'] . "</td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    ?>
                </table>
            </div>
        </div>

        <br>
        </div>
    </div>

    <!--右邊登入區塊-->
    <div style="float:left; height:100%; width:65%;">

        <br><br>

        <!-- 標題 -->
        <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size: 40px; text-align:center;">管   理  者  中  心</h2>

        <br><br><br>

        <!-- 選擇頁面 -->
        <div>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="application" value="申請表管理" onclick="location.href='status1.php'" />
            </p>
            <br><br>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="item" value="物品清單" onclick="location.href='item_management.php'" />
            </p>
            <br><br>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="count" value="統計圖" onclick="location.href='count.php'" />
            </p>
        </div>
    </div>

    <!-- 彈跳視窗靈魂 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>

</html>