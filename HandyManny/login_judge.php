<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />

<?php
include("./mysql_connect.php");

// 接收 POST 請求中的帳號與密碼
$ac = $_POST['account'];
$pw = $_POST['password'];

// SQL 查詢，結合 user 表與 type 表
$sql = "
    SELECT user.*, type.TypeName AS type 
    FROM user 
    INNER JOIN type ON user.TID = type.TID 
    WHERE Account = '$ac' AND Password = '$pw'
";

$result = mysqli_query($con, $sql);

// 檢查查詢結果的筆數
$num = mysqli_num_rows($result);

if ($num > 1) {
    echo "<br>>1";
    while ($list = mysqli_fetch_array($result)) {
        echo "<br>>1";
        echo "<br>list['type']=" . $list['type'];
    }
} else if ($num == 1) {
    echo "<br>=1";
    $list = mysqli_fetch_array($result);
    echo " list['type']=" . $list['type'];

    // 根據使用者類型進行導向
    if ($list['type'] == "student") {
        $_SESSION['userkind'] = $list['type'];
        $_SESSION['uid'] = $list['UID'];
        $_SESSION['tid'] = $list['TID'];
        $_SESSION['name'] = $list['UName'];
        $_SESSION['account'] = $list['Account'];
        header("Location:./student/student_index.php");
    } else if ($list['type'] == "admin") {
        $_SESSION['userkind'] = $list['type'];
        $_SESSION['uid'] = $list['UID'];
        $_SESSION['tid'] = $list['TID'];
        $_SESSION['name'] = $list['UName'];
        $_SESSION['account'] = $list['Account'];
        echo "<br>" . $_SESSION['userkind'] . "<br>";
        echo $_SESSION['tid'] . "<br>";
        echo $_SESSION['name'] . "<br>";
        header("Location:./administrator/admin_index.php");
    }
} else {
    // 登入失敗處理
    setcookie("logintext", "false", time() + 3600);
    $_SESSION['login_yn'] = 1;
    header("Location:./login.php?login_error=1");
}
?>
