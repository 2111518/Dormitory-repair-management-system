<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');

// 接收表單提交的資料
$ItemID = $_POST["ItemID"];
$ItemName = $_POST["ItemName"];
$ItemState = $_POST["ItemState"];
$LID = $_POST["LID"];


// 檢查 `ItemID` 是否符合格式：以 "item" 開頭，後面跟數字
if (!preg_match("/^item\d+$/", $ItemID)) {
    echo "<script>
        alert('物品編號格式錯誤，請確認物品編號以item開頭並且後面為數字！');
        location.href = './item_form.php';
    </script>";
    exit();
}

// 檢查資料庫中是否已經存在該 `ItemID`
$sql1 = "SELECT `ItemID` FROM `item` WHERE `ItemID` = '$ItemID'";
$result1 = mysqli_query($con, $sql1);

if (mysqli_num_rows($result1) > 0) {
    // 如果資料庫中已有該物品，則不能新增
    echo "<script>
        alert('物品編號已存在，無法新增！');
        location.href = './item_form.php';
    </script>";
    exit();
}

// 檢查 `LID` 是否存在於 `location` 表中
$sql2 = "SELECT `LID` FROM `location` WHERE `LID` = '$LID'";
$result2 = mysqli_query($con, $sql2);

if (mysqli_num_rows($result2) == 0) {
    // 如果 `LID` 在 `location` 表中不存在，提示錯誤訊息
    echo "<script>
        alert('該存放位置不存在，無法新增物品！');
        location.href = './item_form.php';
    </script>";
    exit();
}

// 新增物品資料到資料庫
$sql3 = "INSERT INTO `item` (`ItemID`, `ItemName`, `ItemState`, `LID`) 
         VALUES ('$ItemID', '$ItemName', '$ItemState', '$LID')";
    
if (mysqli_query($con, $sql3)) {
    echo "<script>
        alert('新增物品成功！');
        location.href = './item_management.php';
    </script>";
} else {
    echo "<script>
        alert('新增物品失敗，請稍後再試！');
        location.href = './item_form.php';
    </script>";
}



// 關閉資料庫連線
mysqli_close($con);
?>