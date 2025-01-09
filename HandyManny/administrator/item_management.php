<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
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
                document.getElementById("delete").disabled=false;
            }
            else {
                document.getElementById("edit").disabled = true;
                document.getElementById("delete").disabled=true;
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

        //取消勾選
        function cancelChecked(obj, cName) {
            var checkboxs = document.getElementsByName(cName);
            for (var i = 0; i < checkboxs.length; i++) { checkboxs[i].checked = false; }
            document.getElementById("edit").disabled = true;
            document.getElementById("delete").disabled=true;  
        }

        //搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;
            var stNow = document.getElementById("statueNow").innerHTML;
            if (stNow != '') {
                if (temp_search != '') {
                    location.href = "item_management.php?search=" + temp_search + "&statue=" + stNow;
                }
                else {
                    location.href = "item_management.php?statue=" + stNow;
                }
            }
            else {
                if (temp_search != '') {

                    location.href = "item_management.php?search=" + temp_search;
                }
                else {
                    location.href = "item_management.php";
                };
            }
        }

        //刪除
        function empty() {
            var no = document.getElementById("update");
            if (no != '') {
                location.href = "item_management.php?no=" + no.innerHTML;
            }
            else {
                location.href = "item_management.php";
            }
        }

        //取得radio值
        function changeState() {
            var state_list = document.getElementsByName("state");
            var lname = document.getElementsByName("lname");
            var Sno = document.getElementById("update");
            var selected = [];
            for (var i = 0; i < state_list.length; i++) {
                if (state_list[i].checked) {
                    selected.push(state_list[i].value);
                }
            }
            if (Sno != '' && selected != '') {
                
                location.href = "item_management.php?Sno=" + Sno.innerHTML + "&newState=" + selected+ "&lname=" + lname[0].value;
            }
            else {
                location.href = "item_management.php";
            }
        }

         //下拉選單
        function switchStatue() {
            var statue = [];
            var temp_switch = document.getElementsByName("switch");
            var srNow = document.getElementById("searchNow").innerHTML;
            for (var i = 1; i < temp_switch.length; i++) {
                if (temp_switch[i].selected) {
                    statue.push(temp_switch[i].innerHTML);
                }
            }
            if (search != '') {
                if (statue != '') {
                    location.href = "item_management.php?search=" + srNow + "&statue=" + statue;
                }
                else {
                    location.href = "item_management.php?search=" + srNow;
                }
            }
            else {
                if (statue != '') {
                    location.href = "item_management.php?statue=" + statue;
                }
                else {
                    location.href = "item_management.php";
                }
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
                echo "讀者";
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
            <li class="breadcrumb-item"><a href="admin_index.php"
                    style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-decoration:none; user-select:none;">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                物品清單管理</li>
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
    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:40px;">物   品  清  單  管  理</h2>

            <form class="d-flex">

            <select name="stateChoose" style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#808080; 
                                height:37px; width:120px; border-radius:3px; margin-right: 10px; text-align:center;"
                data-table="order-table" class="light-table-filter" onchange="switchStatue();">
                <option disabled hidden> 物品狀況 </option>
                <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="switch">全部</option>
                <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="switch">使用中</option>
                <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="switch">維修中</option>
                <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="switch">備用中</option>
                <?php
                if (isset($_GET['statue'])) {
                    echo '<option style="font-size:18px; font-family:DFKai-sb; color:#000000" selected disabled hidden>' . $_GET['statue'] . '</option>';
                } else {
                    echo '<option disabled hidden selected> 全部 </option>';
                }
                ?>
            </select>

                <!--搜尋-->
                <input class="light-table-filter" type="text" placeholder="Search" id="txt-search"
                    style="height:37px; width:250px; font-family:Times New Roman, 'DFKai-sb';"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')" <?php
                    if (isset($_GET['search'])) {
                        echo 'value="' . $_GET['search'] . '"';
                    }
                    ?>>
                <input type="button" style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                        height:37px; width:98px; border-radius:3px; margin-left:1.5%;" title="Search"
                    onClick="Search()" id="search" value="搜尋">
            </form>

            <div id="ceb_table" style="width:100%;">
                <!--物品紀錄表格-->
                <table class="table table-striped table-hover" style="background-color:white; 
                                font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-align:center;"
                    align="center">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" name="all"
                                    onclick="check_all(this,'check'); disableElement('all'); allPush();">
                                NO.
                            </th>
                            <th scope="col">物品編號</th>
                            <th scope="col">物品名稱</th>
                            <th scope="col">物品狀態</th>
                            <th scope="col">存放位置</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        //改變狀態
                        if (isset($_GET['Sno']) && isset($_GET['newState']) && isset($_GET['lname'])) {
                            $Sno_update = $_GET['Sno'];
                            $newState = $_GET['newState'];
                            $lname = $_GET['lname'];
                            $Sno_array = explode(",", $Sno_update);
                            $count_num = 0;
                        
                            // 如果 lname 為空，則不更新 LID
                            foreach ($Sno_array as $i => $value) {
                                if (!empty($lname)) {
                                    // 查詢 LID
                                    $result = $con->query("SELECT `LID` FROM `location` WHERE `LName` ='" . $lname . "';");
                                    if ($result) {
                                        $row = $result->fetch_assoc(); // 使用 fetch_assoc() 提取查詢結果
                                        $LID_value = $row['LID']; // 提取 LID
                                
                                        // 更新 `item` 表並設定 LID
                                        $update_query = "UPDATE `item` 
                                                         SET `ItemState` = '" . $newState . "', `LID` = '" . $LID_value . "' 
                                                         WHERE `ItemID` = '" . $value . "';";
                                        $con->query($update_query); // 執行更新
                                    }
                                } else {
                                    // 當 lname 為空時，只更新 ItemState
                                    $update_query = "UPDATE `item` 
                                                     SET `ItemState` = '" . $newState . "' 
                                                     WHERE `ItemID` = '" . $value . "';";
                                    $con->query($update_query); // 執行更新
                                }
                        
                                $count_num += 1; // 計數更新次數
                            }

                        }
                        
                        // 刪除
                        if (isset($_GET['no'])) {
                            $no_update = $_GET['no'];
                            $no_array = explode(",", $no_update);
                            foreach ($no_array as $i => $value) {
                                echo "<script>console.log('Value: " . $value . "');</script>";
                                $con->query("DELETE FROM item WHERE ItemID = '" . $value . "';");
                            }
                        }

                        //算筆數
                        if (isset($_GET['statue'])) {
                            $statue = $_GET['statue'];
                            $sql_view = "SELECT * FROM `item` 
                                        JOIN `location` ON item.LID = location.LID ";
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql_view = $sql_view . " and (
                                    ItemID like '%" . $search . "%' or  
                                    ItemName like '%" . $search . "%' or 
                                    location.LName like '%" . $search . "%')
                                    and ItemState like'%" . $statue . "%';";
                            } else {
                                $sql_view = $sql_view . "and (ItemState like '%" . $statue . "%');";
                            }
                        } else {
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql_view = "SELECT * FROM item 
                                            JOIN `location` ON item.LID = location.LID ";
                                $sql_view = $sql_view . " and (
                                    ItemID like '%" . $search . "%' or  
                                    ItemName like '%" . $search . "%' or 
                                    location.LName like '%" . $search . "%')";
                            } else {
                                $sql_view = "SELECT * FROM item ";
                            }
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

                        $sql = "SELECT `ItemID`,
                                        `ItemName`,
                                        `location`.`LName` AS LocationName,
                                        `ItemState`
                                FROM item
                                JOIN `location` ON item.LID = location.LID "; 
                        if (isset($_GET['statue'])) {
                            $statue = $_GET['statue'];
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql = $sql . "and (
                                        ItemID like '%" . $search . "%' or 
                                        ItemName like '%" . $search . "%' or  
                                        location.LName like '%" . $search . "%')
                                        and ItemState like'%" . $statue . "%'";
                            } else {
                                $sql = $sql . "and ( ItemState like '%" . $statue . "%')";
                                            
                            }

                        } else {
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql = $sql . "and (
                                        ItemID like '%" . $search . "%' or 
                                        ItemName like '%" . $search . "%' or  
                                        location.LName like '%" . $search . "%')";
                            }
                        }

                        //資料表輸出格式
                        $sql = $sql . " ORDER BY ItemID desc ";
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

                        while ($item = $result->fetch_array()) {
                            echo '<th><input type="checkbox" name="check" onclick="disableElement(' . "'check'" . ')" value="' . $item["ItemID"] . '">&nbsp;' . $num . '</th>';
                            echo '<td>' . $item["ItemID"] . '</td>';
                            echo '<td>' . $item["ItemName"] . '</td>';
                            echo '<td>' . $item["ItemState"] . '</td>';
                            echo '<td>' . $item["LocationName"] . '</td>';
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
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!--暫存-->
            <div id="update" style="display:none"></div>
            <?php
            if (isset($_GET['statue'])) {
                $_SESSION['statue'] = $_GET['statue'];
                echo '<div id="statueNow" style="display:none">' . $_SESSION['statue'] . '</div>';
            } else {
                echo '<div id="statueNow" style="display:none"></div>';
            }
            if (isset($_GET['search'])) {
                $_SESSION['search'] = $_GET['search'];
                echo '<div id="searchNow" style="display:none">' . $_SESSION['search'] . '</div>';
            } else {
                echo '<div id="searchNow" style="display:none"></div>';
            }
            ?>

            <!-- 按鈕群組 -->
            <p style="text-align:center; margin-left:420px">
                <input class="btn" type="button" id="send" value="新增物品" onclick="location.href = 'item_form.php'" />
                <input disabled="true" class="btn" type="button" id="edit" value="編輯物品狀況"
                    data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" onclick="#">  
                <input disabled="true" class="btn" type="button" id="delete" value="刪除"
                        data-bs-target="#exampleModalToggle5" data-bs-toggle="modal" onclick="#">&emsp;
            </p>
        </div>

    </nav>

    <!-- 分頁功能 -->
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"> <!--回第一頁-->
                    <?php
                    if (isset($_GET['statue'])) {
                        if (isset($_GET['search'])) {
                            echo '<a class="page-link" href="item_management.php?page=1&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&laquo;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="item_management.php?page=1&statue=' . $statue . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&laquo;</span>';
                            echo '</a>';
                        }
                    } else {
                        if (isset($_GET['search'])) {
                            echo '<a class="page-link" href="item_management.php?page=1&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&laquo;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="item_management.php?page=1" aria-label="Previous">';
                            echo '<span aria-hidden="true">&laquo;</span>';
                            echo '</a>';
                        }
                    }
                    ?>
                </li>

                <li class="page-item"> <!--往前一頁-->
                    <?php
                    if (isset($_GET['statue'])) {
                        if (isset($_GET['search'])) {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p > 1) {
                                    $p = $p - 1;
                                } else {
                                    $p = 1;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=1&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
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
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=1&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            }
                        }
                    } else {
                        if (isset($_GET['search'])) {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p > 1) {
                                    $p = $p - 1;
                                } else {
                                    $p = 1;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=1&search=' . $search . '" aria-label="Previous">';
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
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&lt;</span>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </li> <!--頁數-->
                <?php
                if (isset($_GET['statue'])) {
                    if (isset($_GET['search'])) {
                        if (isset($number)) {
                            if ($number <= 3) {
                                for ($i = 1; $i <= $number; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $i . '&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">' . $i . '</a></li>';
                                }
                            } else {
                                if (isset($_GET['page'])) {
                                    $p = intval($_GET['page']);
                                    if ($p >= 3) {
                                        if (($p + 1) > $number) {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 2) . '&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $number . '&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">' . $number . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                        }
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">1</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">2</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">3</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&search=' . $search . '&statue=' . $statue . '" style="color:#203057;">3</a></li>';
                                }
                            }
                        }
                    } else {
                        if (isset($number)) {
                            if ($number <= 3) {
                                for ($i = 1; $i <= $number; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $i . '&statue=' . $statue . '" style="color:#203057;">' . $i . '</a></li>';
                                }
                            } else {
                                if (isset($_GET['page'])) {
                                    $p = intval($_GET['page']);
                                    if ($p >= 3) {
                                        if (($p + 1) > $number) {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 2) . '&statue=' . $statue . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&statue=' . $statue . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $number . '&statue=' . $statue . '" style="color:#203057;">' . $number . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&statue=' . $statue . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $p . '&statue=' . $statue . '" style="color:#203057;">' . $p . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p + 1) . '&statue=' . $statue . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                        }
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&statue=' . $statue . '" style="color:#203057;">1</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&statue=' . $statue . '" style="color:#203057;">2</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&statue=' . $statue . '" style="color:#203057;">3</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&statue=' . $statue . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&statue=' . $statue . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&statue=' . $statue . '" style="color:#203057;">3</a></li>';
                                }
                            }
                        }
                    }
                } else {
                    if (isset($_GET['search'])) {
                        if (isset($number)) {
                            if ($number <= 3) {
                                for ($i = 1; $i <= $number; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                                }
                            } else {
                                if (isset($_GET['page'])) {
                                    $p = intval($_GET['page']);
                                    if ($p >= 3) {
                                        if (($p + 1) > $number) {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                        }
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            }
                        }
                    } else {
                        if (isset($number)) {
                            if ($number <= 3) {
                                for ($i = 1; $i <= $number; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                                }
                            } else {
                                if (isset($_GET['page'])) {
                                    $p = intval($_GET['page']);
                                    if ($p >= 3) {
                                        if (($p + 1) > $number) {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                            echo '<li class="page-item"><a class="page-link" href="item_management.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                        }
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1" style="color:#203057;">1</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2" style="color:#203057;">2</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3" style="color:#203057;">3</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="item_management.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            }
                        }
                    }
                }
                ?>

                <li class="page-item"> <!--往後一頁-->
                    <?php
                    if (isset($_GET['statue'])) {
                        if (isset($_GET['search'])) {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 1 && $p < $number) {
                                    $p += 1;
                                } else {
                                    $p = $number;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=2&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 1 && $p < $number) {
                                    $p += 1;
                                } else {
                                    $p = $number;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=2&statue=' . $statue . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }

                    } else {
                        if (isset($_GET['search'])) {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 1 && $p < $number) {
                                    $p += 1;
                                } else {
                                    $p = $number;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=2&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 1 && $p < $number) {
                                    $p += 1;
                                } else {
                                    $p = $number;
                                }
                                echo '<a class="page-link" href="item_management.php?page=' . $p . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="item_management.php?page=2" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </li>

                <li class="page-item"> <!--到最後一頁-->
                    <?php
                    if (isset($_GET['statue'])) {
                        if (isset($_GET['search'])) {
                            echo '<a class="page-link" href="item_management.php?page=' . $number . '&search=' . $search . '&statue=' . $statue . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&raquo;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="item_management.php?page=' . $number . '&statue=' . $statue . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&raquo;</span>';
                            echo '</a>';
                        }
                    } else {
                        if (isset($_GET['search'])) {
                            echo '<a class="page-link" href="item_management.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&raquo;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="item_management.php?page=' . $number . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&raquo;</span>';
                            echo '</a>';
                        }
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
    
    <br><br>

    <!--返回button-->
    <p style="text-align:center;">
        <input type="button" style="background-color:white; font-size:20px; font-family:DFKai-sb; color:#203057;
                                                            height:40px; width:150px; border-radius:3px;" name="send"
            value="返回" onclick="location.href = 'admin_index.php'" />
    </p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

    <!-- 編輯物品狀況的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" tabindex="-1"
        aria-labelledby="exampleModalToggle3" data-bs-toggle="modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit" style="color:#203057;"><b>物品使用狀況</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="radio" name="state" value="使用中" CHECKED>使用中
                    <input type="radio" name="state" value="備用中">備用中
                    <br><br>
                    <input type="text" name="lname" placeholder="請修改物品位置" >
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                        height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle4" data-bs-toggle="modal" data-bs-dismiss="modal">確定</button>
                    <button style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                        height:37px; width:98px; border-radius:3px;" aria-label="Close"
                        data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle4" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel4" style="color:#203057;"><b>編輯物品狀況</b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    已更改物品狀況！
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                        height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle4" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');changeState();">確定</button>
                </div>
            </div>
        </div>
    </div>  
    <!-- 刪除的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle5" aria-hidden="true" tabindex="-1"
        aria-labelledby="exampleModalToggle5" data-bs-toggle="modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    是否確定刪除紀錄？
                </div>
                <div class="modal-footer">
                    <button
                        style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white; height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle6" data-bs-toggle="modal" data-bs-dismiss="modal">確定</button>
                    <button style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                        height:37px; width:98px; border-radius:3px;" aria-label="Close"
                        data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle6" aria-hidden="true" aria-labelledby="exampleModalToggleLabel6"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel6" style="color:#203057;"><b>刪除</b>
                    </h5>
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