<!DOCTYPE html>
<?php session_start();
require_once("./globefunction.php");
require_once("../mysql_connect.php");
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
            background-image: linear-gradient(to bottom, #FBE5D6 15%, white 85%);
            background-attachment: fixed;
            background-position: center;
            background-size: 100%;
        }

        input:disabled {
            text-align: center;
            background-color: #D3D3D3;
            color: #203057;
            border-color: #203057;
            font-size: 20px;
            font-family: 'DFKai-sb';
            height: 40px;
            width: 150px;
            border-radius: 3px;
        }
    </style>

    <script language="javascript">
        //全選
        function check_all(obj, cName) {
            var checkboxs = document.getElementsByName(cName);
            for (var i = 0; i < checkboxs.length; i++) {
                checkboxs[i].checked = obj.checked;
            }
        }

        //按鈕隱藏
        function disableElement(cName) {
            var checkboxs = document.getElementsByName(cName);
            var count = 0;
            var updateNO = [];
            var u = document.getElementById("update");
            for (var i = 0; i < checkboxs.length; i++) {
                if (checkboxs[i].checked) {
                    count += 1;
                    updateNO.push(checkboxs[i].value);  //儲存打勾的no
                }
            }
            u.innerHTML = updateNO;
            if (count >= 1) {
                document.getElementById("edit").disabled = false;
                document.getElementById("PS").disabled = false;
                document.getElementById("delete").disabled = false;
            }
            else {
                document.getElementById("edit").disabled = true;
                document.getElementById("PS").disabled = true;
                document.getElementById("delete").disabled = true;
            }

            //檢查全選框
            if (count != checkboxs.length) {
                document.getElementsByName("all")[0].checked = false;
            }
            else {
                document.getElementsByName("all")[0].checked = true;
            }
        }

        //全選改值
        function allPush() {
            var updateNO = [];
            var u = document.getElementById("update");
            var ck = document.getElementsByName("all");
            var checkboxs = document.getElementsByName("check");
            if (ck.checked = true) {
                for (var i = 0; i < checkboxs.length; i++) {
                    updateNO.push(checkboxs[i].value);
                }
                u.innerHTML = updateNO;
            }
        }

         //取得radio值
        function changeState() {
            var state_list = document.getElementsByName("state");
            var Sno = document.getElementById("update");
            var selected = [];
            for (var i = 0; i < state_list.length; i++) {
                if (state_list[i].checked) {
                    selected.push(state_list[i].value);
                }
            }
            if (Sno != '' && selected != '') {
                
                location.href = "status1.php?Sno=" + Sno.innerHTML + "&newState=" + selected;
            }
            else {
                location.href = "status1.php";
            }
        }

        //取消勾選
        function cancelChecked(obj, cName) {
            var checkboxs = document.getElementsByName(cName);
            for (var i = 0; i < checkboxs.length; i++) { checkboxs[i].checked = false; }
            document.getElementById("edit").disabled = true;
            document.getElementById("PS").disabled = true;
            document.getElementById("delete").disabled = true;
        }


        //搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;
            if (temp_search != '') {

                location.href = "status1.php?search=" + temp_search;
            }
            else {
                location.href = "status1.php";
            };
        }

        //刪除
        function empty() {
            var no = document.getElementById("update");
            if (no != '') {
                location.href = "status1.php?no=" + no.innerHTML;
            }
            else {
                location.href = "status1.php";
            }
        }

        //撰寫備註
        function PSChange() {
            var text_list = document.getElementsByName("message-text");
            var Eno = document.getElementById("update");
            if (Eno != '' && text_list != '') {
                location.href = "status1.php?Eno=" + Eno.innerHTML + "&PS=" + text_list[0].value;
            }
            else {
                location.href = "status1.php";
            }
        }
    </script>
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
            } else if ($userkind == "administrator") {
                echo "管理者";
            } else {
                echo "您好";
            }
            ?>&nbsp;-
            <?php echo $_SESSION['name'];?>&nbsp;
        </div>
    </div>

    <!--線-->
    <hr style="height:3px; margin-top:0px;">

    <!-- 路徑欄 -->
    <nav style="--bs-breadcrumb-divider: '>'; margin-left:10px; margin-top:-10px;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php"
                    style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-decoration:none; user-select:none;">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                申請表管理</li>
        </ol>
    </nav>

    <!-- 登出語法 -->
    <script>
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../login.php";
        }
    </script>

    <!-- 標題 -->
    <h2
        style="text-align:center; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:40px; user-select:none;">
        申請表管理</h2>

    <!-- 頁籤 -->
    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="#" href="status1.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">未審核</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="status2.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">採購中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="status3.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">維修中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="status4.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">已完成</a>
                </li>
            </ul>

            <form class="d-flex">
                <!--搜尋-->
                <input class="light-table-filter" type="text" placeholder="Search" id="txt-search"
                    style="height:37px; width:250px" onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"
                    <?php
                    if (isset($_GET['search'])) {
                        echo 'value="' . $_GET['search'] . '"';
                    }
                    ?>>
                <input type="button" style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                        height:37px; width:98px; border-radius:3px; margin-left:1.5%;" title="Search"
                    onClick="Search()" id="search" value="搜尋">
            </form>

        </div>
    </nav>
    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <!-- 未審核 -->
            <div id="application_table" style="width:100%;">
                <table class="table table-striped table-hover" style="background-color:white; 
                                font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-align:center;"
                    align="center">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" name="all"
                                    onclick="check_all(this,'check'); disableElement('all'); allPush();">
                                編號
                            </th>
                            <th scope="col">申請日期</th>
                            <th scope="col">申請人</th>
                            <th scope="col">物品名稱</th>
                            <th scope="col">申請原因</th>
                            <th scope="col">負責人</th>
                            <th scope="col">備註</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $supervisorID = $_SESSION['uid'];
                        //撰寫備註
                        if (isset($_GET['Eno']) && isset($_GET['PS'])) {
                            $Eno_update = $_GET['Eno'];
                            $PS = $_GET['PS'];
                            $Eno_array = explode(",", $Eno_update);
                            $count_num = 0;
                            foreach ($Eno_array as $i => $value) {
                                $con->query("UPDATE `application` 
                                            SET `PS` = '" . $PS . "', 
                                                `UID2` = '" . $supervisorID . "'
                                            WHERE `AID` = " . $value . ";");
                                $count_num += 1;
                            }
                        }

                         //改變狀態
                         if (isset($_GET['Sno']) && isset($_GET['newState'])) {
                            $Sno_update = $_GET['Sno'];
                            $newState = $_GET['newState'];
                            $Sno_array = explode(",", $Sno_update);
                            $count_num = 0;
                            if($newState == '採購中' || $newState == '維修中'){
                                $ItemState = '維修中';
                            }
                            else{
                                $ItemState = '使用中';
                            }
                            foreach ($Sno_array as $i => $value) {
                                $value = (int)$value;  
                                $newState = $con->real_escape_string($newState);
                                $supervisorID = $con->real_escape_string($supervisorID);
                                $ItemState = $con->real_escape_string($ItemState);
                                
                                $query = "
                                    UPDATE application a
                                    JOIN item i ON a.ItemID = i.ItemID
                                    SET a.AState = '$newState',
                                        a.UID2 = '$supervisorID',
                                        i.ItemState = '$ItemState'
                                    WHERE a.AID = $value";
                                
                                $con->query($query);
                                $count_num += 1;
                            }
                        }
                        // 刪除
                        if (isset($_GET['no'] )) {
                            $no_update = $_GET['no'];
                            $no_array = explode(",", $no_update);
                            foreach ($no_array as $i => $value) {
                                $con->query("DELETE FROM `application` 
                                    where `AID` =" . $value . ";");
                            }
                        }

                        //算筆數
                        
                        $sql_view = "SELECT * FROM `application`
                                    JOIN `user`AS applicant ON `application`.`UID1` = `applicant`.`UID`
                                    JOIN `user`AS supervisor ON `application`.`UID2` = `supervisor`.`UID` 
                                    JOIN `item` ON `application`.`ItemID` = `item`.`ItemID`
                                    where `AState` like '未審核'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql_view = $sql_view . " and (
                                    Time like '%" . $search . "%' or 
                                    applicant.UName like'%" . $search . "%' or 
                                    ItemName like '%" . $search . "%' or 
                                    supervisor.UName like '%" . $search . "%' or 
                                    Reason like '%" . $search . "%'or 
                                    PS like '%" . $search . "%' )";
                        }

                        $result = $con->query($sql_view);
                        if ($result) {
                            $total = mysqli_num_rows($result); //總筆數
                            $number = intval($total / 10); //資料有幾頁
                            $spare = $total % 10; //不滿一頁加一頁 
                            if ($spare != 0) {
                                $number += 1;
                            }
                            if ($number < 1) {
                                $number += 1;
                            }
                        }
                        //資料表輸出內容
                        $sql = "SELECT 
                                    `application`.`AID`,
                                    `application`.`Time`,
                                    `applicant`.`UName` AS `ApplicantName`,
                                    `item`.`ItemName`,
                                    `application`.`Reason`,
                                    `supervisor`.`UName` AS `SupervisorName`,
                                    `application`.`PS`
                                FROM 
                                    `application`
                                JOIN 
                                    `user` AS `applicant` ON `application`.`UID1` = `applicant`.`UID`
                                JOIN 
                                    `user` AS `supervisor` ON `application`.`UID2` = `supervisor`.`UID`
                                JOIN 
                                    `item` ON `application`.`ItemID` = `item`.`ItemID`
                                WHERE 
                                    `application`.`AState` = '未審核'";
                                    
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = $sql . "and (
                                    Time like '%" . $search . "%' or 
                                    applicant.UName like'%" . $search . "%' or 
                                    ItemName like '%" . $search . "%' or 
                                    supervisor.UName like '%" . $search . "%' or 
                                    Reason like '%" . $search . "%'or  
                                    PS like '%" . $search . "%')";
                        }
                        //資料表輸出格式
                        $sql = $sql . " ORDER BY Time desc ";
                        if (isset($_GET['page'])) {
                            $temp = 0;
                            while ($temp < $number) {
                                $temp = $temp + 1;
                                if (intval($_GET['page']) == $temp) {
                                    $temp1 = ($temp - 1) * 10;
                                    $sql = $sql . ' LIMIT ' . $temp1 . ',10;';
                                    break;
                                }
                            }
                        } else {
                            $sql = $sql . " LIMIT 0,10;";
                        }

                        //資料表輸出
                        $result = $con->query($sql);
                        $num = 1;
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            $num = $num + 10 * ($p - 1);
                        } else {
                            $p = 1;
                            $num = $num + 10 * ($p - 1);
                        }

                        while ($application = $result->fetch_array()) {
                            echo '<tr>';
                            echo '<th><input type="checkbox" name="check" onclick="disableElement(' . "'check'" . ')" value="' . $application["AID"] . '">&nbsp;' . $num . '</th>';
                            echo '<td>' . $application["Time"] . '</td>';
                            echo '<td>' . $application["ApplicantName"] . '</td>';
                            echo '<td>' . $application["ItemName"] . '</td>';
                            echo '<td>' . $application["Reason"] . '</td>';
                            echo '<td>' . $application["SupervisorName"] . '</td>';
                            echo '<td>' . $application["PS"] . '</td>';
                            echo '</tr>';
                            $num += 1;
                        }
                        if ($spare < 10 && $spare > 0) {
                            $need = 10 - $spare;
                            if (isset($_GET['page'])) {
                                $_SESSION['page'] = $_GET['page'];
                                if ($_SESSION['page'] == $number && $_SESSION['page'] != 1) {
                                    for ($i = 1; $i <= $need; $i++) {
                                        echo '<tr>
                                            <th>-</th>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            </tr>';
                                    }
                                }
                            }
                            if ($number == 1) {
                                for ($i = 1; $i <= $need; $i++) {
                                    echo '<tr>
                                            <th>-</th>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            </tr>';
                                }
                            }
                        }
                        if ($spare == 0 && $total == 0) {
                            for ($i = 1; $i <= 10; $i++) {
                                echo '<tr>
                                    <th>-</th>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!--暫存-->
            <?php
            if (isset($_GET['no'])) {
                $_SESSION['no'] = $_GET['no'];
                echo '<div id="update" style="display:none">' . $_SESSION['no'] . '</div>';
            } else {
                echo '<div id="update" style="display:none"></div>';
            }
            if (isset($_GET['search'])) {
                $_SESSION['search'] = $_GET['search'];
                echo '<div id="searchNow" style="display:none">' . $_SESSION['search'] . '</div>';
            } else {
                echo '<div id="searchNow" style="display:none"></div>';
            }
            if (isset($_GET['state'])) {
                $_SESSION['state'] = $_GET['state'];
                echo '<div id="stateNow" style="display:none">' . $_SESSION['state'] . '</div>';
            } else {
                echo '<div id="stateNow" style="display:none"></div>';
            }
            ?>

            <!-- 按鈕群組 -->
            <p style="text-align:center; margin-left:420px">
                <input disabled="true" class="btn" type="button" id="edit" value="編輯申請狀況"
                    data-bs-target="#exampleModalToggle1" data-bs-toggle="modal" onclick="#">&emsp;
                <input disabled="true" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn"
                    id="PS" value="撰寫備註" onclick="#" />&emsp;
                <input disabled="true" type="button" data-bs-toggle="modal" href="#exampleModalToggle5" class="btn"
                    id="delete" value="刪除" onclick="#" />
            </p>
        </div>

    </nav>

    <!-- 分頁功能 -->
    <div style="text-align:center;">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"> <!--回第一頁-->
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="status1.php?page=1&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="status1.php?page=1" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    }
                    ?>
                </li>

                <li class="page-item"> <!--往前一頁-->
                    <?php
                    if (isset($_GET['search'])) {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1) {
                                $p = $p - 1;
                            } else {
                                $p = 1;
                            }
                            echo '<a class="page-link" href="status1.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="status1.php?page=1&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1) {
                                $p = $p - 1;
                            } else {
                                $p = 1;
                            }
                            echo '<a class="page-link" href="status1.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="status1.php?page=1" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        }
                    }
                    ?>
                </li> <!--頁數-->
                <?php
                if (isset($_GET['search'])) {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                } else {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="status1.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="status1.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=1" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=2" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="status1.php?page=3" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                }
                ?>
                <li class="page-item"> <!--往後一頁-->
                    <?php
                    if (isset($_GET['search'])) {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p >= 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="status1.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number = 1) {
                                echo '<a class="page-link" href="status1.php?page=1&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="status1.php?page=2&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p >= 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="status1.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number = 1) {
                                echo '<a class="page-link" href="status1.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="status1.php?page=2" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </li>

                <li class="page-item"> <!--到最後一頁-->
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="status1.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="status1.php?page=' . $number . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>

    <br><br>
    </div>

    <!--返回button-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

    <!-- 編輯採購狀況的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle1" aria-hidden="true" tabindex="-1"
        aria-labelledby="exampleModalToggle1" data-bs-toggle="modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit" style="color:#203057;"><b>編輯採購狀況</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="radio" name="state" value="未審核" CHECKED>未審核
                    <input type="radio" name="state" value="採購中">採購中
                    <input type="radio" name="state" value="維修中">維修中
                    <input type="radio" name="state" value="已完成">已完成
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                        height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">確定</button>
                    <button style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                        height:37px; width:98px; border-radius:3px;" aria-label="Close"
                        data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2" style="color:#203057;"><b>編輯採購狀況</b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    已更改採購狀況！
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                        height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');changeState();">確定</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 撰寫備註的彈跳視窗 -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057;"><b>備註
                        </b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="message-text" style="width:100%; resize:none; font-size:18px; font-family:DFKai-sb;"
                        rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                height:37px; width:98px; border-radius:3px;"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');PSChange()">儲存</button>
                    <button type="button" data-bs-dismiss="modal" style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                height:37px; width:98px; border-radius:3px;">取消</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 刪除的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle5" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    是否確定刪除紀錄？
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle6" data-bs-toggle="modal" data-bs-dismiss="modal">確定</button>
                    <button style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                height:37px; width:98px; border-radius:3px;" aria-label="Close"
                        data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle6" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel6" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    紀錄已刪除！
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle6" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');empty()">確定</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>