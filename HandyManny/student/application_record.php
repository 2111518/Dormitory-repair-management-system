<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');

// $ac = $_POST['account'];
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF8" />
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
        //搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;

            if (temp_search != '') {

                location.href = "application_record.php?search=" + temp_search;
            }
            else {
                location.href = "application_record.php";
            };
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
            <?php echo $_SESSION['name']; ?>&nbsp;
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
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                歷史報修紀錄</li>
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
            <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:40px;">歷   史  報  修    紀    錄</h2>

            <form class="d-flex">
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


            <div id="application_table" style="width:100%;">
                <!--推薦紀錄表格-->
                <table class="table table-striped table-hover" style="background-color:white; 
                                font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-align:center;"
                    align="center">
                    <thead>
                        <tr>
                            <th scope="col">編號</th>
                            <th scope="col">物品編號</th>
                            <th scope="col">物品名稱</th>
                            <th scope="col">申請原因</th>
                            <th scope="col">申請日期</th>
                            <th scope="col">申請狀況</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        //算筆數
                        $total = 0;
                        $spare = 0;
                        $number = 1;

                        $sql_view = "SELECT `AID`, `ItemID`, `ItemName`, `Reason`, `Time`, `AState`
                                FROM `application`
                                JOIN `item` ON `application`.`ItemID` = `item`.`ItemID`
                                WHERE `application`.`UID` LIKE '" . $_SESSION['uid'] . "'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql_view = $sql_view . " and (
                                            Reason like '%" . $search . "%' or 
                                            ItemName like '%" . $search . "%' or 
                                            AID like '%" . $search . "%' or 
                                            Time like '%" . $search . "%'or 
                                            AState like '%" . $search . "%')";
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
                        $sql = "SELECT `AID`, `item`.`ItemID` AS item_id, 
                                        `ItemName`, `Reason`, `Time`, `AState`
                                FROM `application`
                                JOIN `item` ON `application`.`ItemID` = `item`.`ItemID`
                                WHERE `application`.`UID1` LIKE '" . $_SESSION['uid'] . "'";

                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = $sql . " and(
                                            item.ItemID like '%" . $search . "%' or
                                            Reason like '%" . $search . "%' or 
                                            AID like '%" . $search . "%' or 
                                            ItemName like '%" . $search . "%'or 
                                            Time like '%" . $search . "%'or 
                                            AState like '%" . $search . "%')";
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
                            echo '<th style="width:10%;">' . $num . '</th>';
                            echo '<td>' . $application["item_id"] . '</td>';
                            echo '<td width:30%;" >' . $application["ItemName"] . '</td>'; 
                            echo '<td>' . $application["Reason"] . '</td>';
                            echo '<td>' . $application["Time"] . '</td>';
                            echo '<td>' . $application["AState"] . '</td>';
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
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!--暫存-->
            <?php
            if (isset($_GET['search'])) {
                $_SESSION['search'] = $_GET['search'];
                echo '<div id="searchNow" style="display:none">' . $_SESSION['search'] . '</div>';
            } else {
                echo '<div id="searchNow" style="display:none"></div>';
            }
            ?>
        </div>
    </nav>

    <!-- 分頁功能 -->
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"> <!--回第一頁-->
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="application_record.php?page=1&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="application_record.php?page=1" aria-label="Previous">';
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
                            echo '<a class="page-link" href="application_record.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="application_record.php?page=1&search=' . $search . '" aria-label="Previous">';
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
                            echo '<a class="page-link" href="application_record.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="application_record.php?page=1" aria-label="Previous">';
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
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                } else {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="application_record.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="application_record.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=1" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=2" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="application_record.php?page=3" style="color:#203057;">3</a></li>';
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
                            if ($p > 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="application_record.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number = 1) {
                                echo '<a class="page-link" href="application_record.php?page=1&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="application_record.php?page=2&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }

                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="application_record.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number = 1) {
                                echo '<a class="page-link" href="application_record.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="application_record.php?page=2" aria-label="Previous">';
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
                        echo '<a class="page-link" href="application_record.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="application_record.php?page=' . $number . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
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
            value="繼續申請" onclick="location.href = 'application_form.php'" />
    </p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>
</body>

</html>