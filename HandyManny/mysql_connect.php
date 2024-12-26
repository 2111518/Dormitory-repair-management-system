<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<?php
//資料庫位置
$db_server = "localhost:3307";
//資料庫名稱
$db_name = "final_project";
//資料庫管理者帳號
$db_user = "root";
//資料庫管理者密碼
$db_passwd = "";


$con = new mysqli($db_server, $db_user, $db_passwd, $db_name); //對資料庫連線
if ($con->connect_error) {
    die("Connected Failed: " . $con->connect_error);
}

mysqli_set_charset($con, "utf8");

?>