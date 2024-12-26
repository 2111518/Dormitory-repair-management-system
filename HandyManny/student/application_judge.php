<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');

// 接收表單提交的資料
$ItemID = $_POST["ItemID"];
$Reason = $_POST["Reason"];

//--
$UID = $_SESSION['uid'];




// 第一階段：檢查 `item` 資料表中是否存在該物品
$sql1 = "SELECT `ItemID` FROM `item` WHERE `ItemID` = '$ItemID'";
$result1 = mysqli_query($con, $sql1);

if (mysqli_num_rows($result1) == 0) {
    // 如果物品不存在，提示錯誤訊息
    echo "<script>
        alert('物品不存在，請檢查後再試！');
        location.href = './application_form.php';
    </script>";
} else {
    // 第二階段：檢查 `application` 資料表中是否已經有該物品的申請記錄
    $sql2 = "SELECT `ItemID` FROM `application` WHERE `ItemID` = '$ItemID'";
    $result2 = mysqli_query($con, $sql2);

    if (mysqli_num_rows($result2) == 0) {
        // 如果該物品未曾在 `application` 資料表中申請，直接新增申請
        $sql3 = "INSERT INTO `application` (`UID1`, `ItemID`, `Reason`, `AState`) 
                 VALUES ('$UID', '$ItemID', '$Reason', '未審核')";
        if (mysqli_query($con, $sql3)) {
            echo "<script>
                alert('申請成功！');
                location.href = './application_record.php';
            </script>";
        } else {
            echo "<script>
                alert('申請失敗，請稍後再試！');
                location.href = './application_form.php';
            </script>";
        }
    } else {
        // 如果該物品已經在 `application` 表中，檢查其狀態
        $sql3 = "SELECT `AState` FROM `application` WHERE `ItemID` = '$ItemID'";
        $result3 = mysqli_query($con, $sql3);
        $row = mysqli_fetch_assoc($result3);

        if (in_array($row['AState'], ['未審核', '採購中', '維修中'])) {
            // 如果物品狀態為 '未審核', '採購中', '維修中'，提示用戶重複申請
            echo "<script>
                var msg = '您輸入的物品已被申請！點選確認取消申請；取消則返回表單。';
                if (confirm(msg) == true) {
                    location.href = './application_record.php?ItemIDRe=1';
                } else {
                    location.href = './application_form.php';
                }
            </script>";
        } else {
            // 其他情況下，重新處理申請
            $sql4 = "INSERT INTO `application` (`UID1`, `ItemID`, `Reason`, `AState`) 
                     VALUES ('$UID', '$ItemID', '$Reason', '未審核')";
            if (mysqli_query($con, $sql4)) {
                echo "<script>
                    alert('申請成功！');
                    location.href = './application_record.php';
                </script>";
            } else {
                echo "<script>
                    alert('申請失敗，請稍後再試！');
                    location.href = './application_form.php';
                </script>";
            }
        }
    }
}



// 關閉資料庫連線
mysqli_close($con);
?>