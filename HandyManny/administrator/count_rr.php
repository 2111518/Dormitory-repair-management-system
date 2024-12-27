<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');

// 中西文圖書_依職位統計之SQL
$query1 = "SELECT user_style.style as style, COUNT(id) as count_ceb FROM hrec_ceb RIGHT OUTER JOIN user_style ON hrec_ceb.style = user_style.style";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1 = $query1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    } else {
        $query1 = $query1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    }
} else {
    $query1 = $query1 . " GROUP BY user_style.style ORDER BY user_style.style DESC";
}
$result1 = $con->query($query1);
$count_ceb = array();
$styleName1 = array();
while ($row1 = mysqli_fetch_assoc($result1)) {
    $count_ceb[] = $row1['count_ceb'];
    $styleName1[] = $row1['style'];
}
if (!$result1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(大學生)
$query1_1 = "SELECT unit, COUNT(id) as count_ceb_1 FROM hrec_ceb WHERE style = '大學生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1 = $query1_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_1 = $query1_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_1 = $query1_1 . " GROUP BY unit ORDER BY unit";
}
$result1_1 = $con->query($query1_1);
$count_ceb_1 = array();
$styleName1_1 = array();
while ($row1_1 = mysqli_fetch_assoc($result1_1)) {
    $count_ceb_1[] = $row1_1['count_ceb_1'];
    $styleName1_1[] = $row1_1['unit'];
}
if (!$result1_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(研究生)
$query1_2 = "SELECT unit, COUNT(id) as count_ceb_2 FROM hrec_ceb WHERE style = '研究生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_2 = $query1_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_2 = $query1_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_2 = $query1_2 . " GROUP BY unit ORDER BY unit";
}
$result1_2 = $con->query($query1_2);
$count_ceb_2 = array();
$styleName1_2 = array();
while ($row1_2 = mysqli_fetch_assoc($result1_2)) {
    $count_ceb_2[] = $row1_2['count_ceb_2'];
    $styleName1_2[] = $row1_2['unit'];
}
if (!$result1_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(教職員)
$query1_3 = "SELECT unit, COUNT(id) as count_ceb_3 FROM hrec_ceb WHERE style = '教職員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_3 = $query1_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_3 = $query1_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_3 = $query1_3 . " GROUP BY unit ORDER BY unit";
}
$result1_3 = $con->query($query1_3);
$count_ceb_3 = array();
$styleName1_3 = array();
while ($row1_3 = mysqli_fetch_assoc($result1_3)) {
    $count_ceb_3[] = $row1_3['count_ceb_3'];
    $styleName1_3[] = $row1_3['unit'];
}
if (!$result1_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(醫護人員)
$query1_4 = "SELECT unit, COUNT(id) as count_ceb_4 FROM hrec_ceb WHERE style = '醫護人員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_4 = $query1_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_4 = $query1_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_4 = $query1_4 . " GROUP BY unit ORDER BY unit";
}
$result1_4 = $con->query($query1_4);
$count_ceb_4 = array();
$styleName1_4 = array();
while ($row1_4 = mysqli_fetch_assoc($result1_4)) {
    $count_ceb_4[] = $row1_4['count_ceb_4'];
    $styleName1_4[] = $row1_4['unit'];
}
if (!$result1_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依職位統計之SQL
$query2 = "SELECT user_style.style as style, COUNT(id) as count_avm FROM hrec_avm RIGHT OUTER JOIN user_style ON hrec_avm.style = user_style.style";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2 = $query2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    } else {
        $query2 = $query2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    }
} else {
    $query2 = $query2 . " GROUP BY user_style.style ORDER BY user_style.style DESC";
}
$result2 = $con->query($query2);
$count_avm = array();
$styleName2 = array();
while ($row2 = mysqli_fetch_assoc($result2)) {
    $count_avm[] = $row2['count_avm'];
    $styleName2[] = $row2['style'];
}
if (!$result2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(大學生)
$query2_1 = "SELECT unit, COUNT(id) as count_avm_1 FROM hrec_avm WHERE style = '大學生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1 = $query2_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_1 = $query2_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_1 = $query2_1 . " GROUP BY unit ORDER BY unit";
}
$result2_1 = $con->query($query2_1);
$count_avm_1 = array();
$styleName2_1 = array();
while ($row2_1 = mysqli_fetch_assoc($result2_1)) {
    $count_avm_1[] = $row2_1['count_avm_1'];
    $styleName2_1[] = $row2_1['unit'];
}
if (!$result2_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(研究生)
$query2_2 = "SELECT unit, COUNT(id) as count_avm_2 FROM hrec_avm WHERE style = '研究生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_2 = $query2_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_2 = $query2_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_2 = $query2_2 . " GROUP BY unit ORDER BY unit";
}
$result2_2 = $con->query($query2_2);
$count_avm_2 = array();
$styleName2_2 = array();
while ($row2_2 = mysqli_fetch_assoc($result2_2)) {
    $count_avm_2[] = $row2_2['count_avm_2'];
    $styleName2_2[] = $row2_2['unit'];
}
if (!$result2_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(教職員)
$query2_3 = "SELECT unit, COUNT(id) as count_avm_3 FROM hrec_avm WHERE style = '教職員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_3 = $query2_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_3 = $query2_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_3 = $query2_3 . " GROUP BY unit ORDER BY unit";
}
$result2_3 = $con->query($query2_3);
$count_avm_3 = array();
$styleName2_3 = array();
while ($row2_3 = mysqli_fetch_assoc($result2_3)) {
    $count_avm_3[] = $row2_3['count_avm_3'];
    $styleName2_3[] = $row2_3['unit'];
}
if (!$result2_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(醫護人員)
$query2_4 = "SELECT unit, COUNT(id) as count_avm_4 FROM hrec_avm WHERE style = '醫護人員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_4 = $query2_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_4 = $query2_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_4 = $query2_4 . " GROUP BY unit ORDER BY unit";
}
$result2_4 = $con->query($query2_4);
$count_avm_4 = array();
$styleName2_4 = array();
while ($row2_4 = mysqli_fetch_assoc($result2_4)) {
    $count_avm_4[] = $row2_4['count_avm_4'];
    $styleName2_4[] = $row2_4['unit'];
}
if (!$result2_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依職位統計之SQL
$query3 = "SELECT user_style.style as style, COUNT(id) as count_cj FROM hrec_cj RIGHT OUTER JOIN user_style ON hrec_cj.style = user_style.style";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3 = $query3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    } else {
        $query3 = $query3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY user_style.style DESC";
    }
} else {
    $query3 = $query3 . " GROUP BY user_style.style ORDER BY user_style.style DESC";
}
$result3 = $con->query($query3);
$count_cj = array();
$styleName3 = array();
while ($row3 = mysqli_fetch_assoc($result3)) {
    $count_cj[] = $row3['count_cj'];
    $styleName3[] = $row3['style'];
}
if (!$result3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(大學生)
$query3_1 = "SELECT unit, COUNT(id) as count_cj_1 FROM hrec_cj WHERE style = '大學生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1 = $query3_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_1 = $query3_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_1 = $query3_1 . " GROUP BY unit ORDER BY unit";
}
$result3_1 = $con->query($query3_1);
$count_cj_1 = array();
$styleName3_1 = array();
while ($row3_1 = mysqli_fetch_assoc($result3_1)) {
    $count_cj_1[] = $row3_1['count_cj_1'];
    $styleName3_1[] = $row3_1['unit'];
}
if (!$result3_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(研究生)
$query3_2 = "SELECT unit, COUNT(id) as count_cj_2 FROM hrec_cj WHERE style = '研究生'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_2 = $query3_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_2 = $query3_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_2 = $query3_2 . " GROUP BY unit ORDER BY unit";
}
$result3_2 = $con->query($query3_2);
$count_cj_2 = array();
$styleName3_2 = array();
while ($row3_2 = mysqli_fetch_assoc($result3_2)) {
    $count_cj_2[] = $row3_2['count_cj_2'];
    $styleName3_2[] = $row3_2['unit'];
}
if (!$result3_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(教職員)
$query3_3 = "SELECT unit, COUNT(id) as count_cj_3 FROM hrec_cj WHERE style = '教職員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_3 = $query3_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_3 = $query3_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_3 = $query3_3 . " GROUP BY unit ORDER BY unit";
}
$result3_3 = $con->query($query3_3);
$count_cj_3 = array();
$styleName3_3 = array();
while ($row3_3 = mysqli_fetch_assoc($result3_3)) {
    $count_cj_3[] = $row3_3['count_cj_3'];
    $styleName3_3[] = $row3_3['unit'];
}
if (!$result3_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(醫護人員)
$query3_4 = "SELECT unit, COUNT(id) as count_cj_4 FROM hrec_cj WHERE style = '醫護人員'";
if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_4 = $query3_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_4 = $query3_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_4 = $query3_4 . " GROUP BY unit ORDER BY unit";
}
$result3_4 = $con->query($query3_4);
$count_cj_4 = array();
$styleName3_4 = array();
while ($row3_4 = mysqli_fetch_assoc($result3_4)) {
    $count_cj_4[] = $row3_4['count_cj_4'];
    $styleName3_4[] = $row3_4['unit'];
}
if (!$result3_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            } else if ($userkind == "administrator") {
                echo "管理員";
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

    <!-- 路徑欄 -->
    <nav style="--bs-breadcrumb-divider: '>'; margin-left:10px; margin-top:-10px;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php"
                    style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-decoration:none; user-select:none;">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                中西文圖書歷史推薦清單</li>
            <li class="breadcrumb-item active" aria-current="page"
                style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px; user-select:none;">
                統計推薦紀錄</li>
        </ol>
    </nav>

    <!-- 標題 -->
    <h2
        style="text-align:center; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:40px; user-select:none;">
        統計推薦紀錄</h2>

    <!-- 下拉式選單 + 回上層bottom -->
    <nav class="navbar navbar-light" style="width:95%;" user-select:none;>
        <div class="container-fluid" style="margin-left:5.5%;">
            <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="年-tab" data-bs-toggle="tab" data-bs-target="#年" type="button"
                        role="tab" aria-controls="年" aria-selected="true"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057;">年</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="月-tab" data-bs-toggle="tab" data-bs-target="#月" type="button"
                        role="tab" aria-controls="月" aria-selected="false"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057;">月</button>
                </li>
            </ul> -->

            <!-- 暫存 -->
            <?php
            if (isset($_GET['year'])) {
                $_SESSION['year'] = $_GET['year'];
                echo '<div id="yearNow" style="display:none">' . $_SESSION['year'] . '</div>';
            } else {
                echo '<div id="yearNow" style="display:none"></div>';
            }
            if (isset($_GET['month'])) {
                $_SESSION['month'] = $_GET['month'];
                echo '<div id="monthNow" style="display:none">' . $_SESSION['month'] . '</div>';
            } else {
                echo '<div id="monthNow" style="display:none"></div>';
            }
            ?>

            <form class="d-flex">
                <!--年度下拉式選單-->
                <div class="dropdown">
                    <select id="slt1" class="dropdown"
                        style="background-color:white; font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#808080;
                                                            height:37px; width:120px; border-radius:3px; text-align:center;" onchange="year();">
                        <option disabled hidden> 年 </option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000">選取年份</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="year">2023</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="year">2022</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="year">2021</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="year">2020</option>

                        <?php
                        if (isset($_GET['year'])) {
                            echo '<option style="font-size:18px; font-family:DFKai-sb; color:#000000" selected disabled hidden>' . $_GET['year'] . '</option>';
                        } else {
                            echo '<option disabled hidden selected> 年 </option>';
                        }
                        ?>
                    </select>

                    <br><br><br>
                </div>

                &emsp;

                <!--月份下拉式選單-->
                <div class="dropdown">
                    <select id="slt2" class="dropdown"
                        style="background-color:white; font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#808080;
                                                            height:37px; width:120px; border-radius:3px; text-align:center;" onchange="month();">
                        <option disabled hidden> 月 </option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000">選取月份</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">01</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">02</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">03</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">04</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">05</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">06</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">07</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">08</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">09</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">10</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">11</option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000" name="month">12</option>

                        <?php
                        if (isset($_GET['month'])) {
                            echo '<option style="font-size:18px; font-family:DFKai-sb; color:#000000" selected disabled hidden>' . $_GET['month'] . '</option>';
                        } else {
                            echo '<option disabled hidden selected> 月 </option>';
                        }
                        ?>

                    </select>

                    <br><br><br>
                </div>

                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;

                <input type="button" style="background-color:white; font-size:18px; font-family:DFKai-sb; color:#203057;
                                                height:37px; width:120px; border-radius:3px;" value="回上層"
                    onclick="resetChart()" />
            </form>

            <!--回上層bottom-->
            <!-- <bottom style="background-color:white; font-size:20px; font-family:'DFKai-sb'; color:#203057;
                            height:40px; width:150px; border-radius:3px; text-align:center;"
                        onclick="resetChart()">回上層</bottom> -->
        </div>

        <script>
            (function () {
                //全部選擇隱藏
                $('div[id^="tab_"]').hide();
                $('#slt1').change(function () {
                    let sltValue = $(this).val();
                    console.log(sltValue);

                    $('div[id^="tab_"]').hide();
                    //指定選擇顯示
                    $(sltValue).show();
                });
            });
        </script>
    </nav>

    <!-- 內容表格 -->
    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <canvas id="Chart" style="width: 95.5%; display: block; box-sizing: border-box; height: 435px;"></canvas>
        </div>
    </nav>

    <script language="javascript">
        // Setup Block_依職位統計
        const lables = <?php echo json_encode($styleName1); ?>;
        const count_ceb = <?php echo json_encode($count_ceb); ?>;
        const count_avm = <?php echo json_encode($count_avm); ?>;
        const count_cj = <?php echo json_encode($count_cj); ?>;
        const data = {
            labels: lables,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb,
                backgroundColor: '#4472C4'
            }, {
                label: '視聽資料',
                data: count_avm,
                backgroundColor: '#ED7D31'
            }, {
                label: '中文期刊',
                data: count_cj,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(大學生)
        const lables_1_1 = <?php echo json_encode($styleName1_1); ?>;
        const count_ceb_1 = <?php echo json_encode($count_ceb_1); ?>;
        const college_student_ceb = {
            labels: lables_1_1,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(研究生)
        const lables_1_2 = <?php echo json_encode($styleName1_2); ?>;
        const count_ceb_2 = <?php echo json_encode($count_ceb_2); ?>;
        const postgraduate_ceb = {
            labels: lables_1_2,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_2,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(教職員)
        const lables_1_3 = <?php echo json_encode($styleName1_3); ?>;
        const count_ceb_3 = <?php echo json_encode($count_ceb_3); ?>;
        const staff_ceb = {
            labels: lables_1_3,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_3,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(醫護人員)
        const lables_1_4 = <?php echo json_encode($styleName1_4); ?>;
        const count_ceb_4 = <?php echo json_encode($count_ceb_4); ?>;
        const medical_staff_ceb = {
            labels: lables_1_4,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_4,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_視聽資料_依單位統計(大學生)
        const lables_2_1 = <?php echo json_encode($styleName2_1); ?>;
        const count_avm_1 = <?php echo json_encode($count_avm_1); ?>;
        const college_student_avm = {
            labels: lables_2_1,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1,
                backgroundColor: '#ED7D31'
            }]
        };
        // Setup Block_視聽資料_依單位統計(研究生)
        const lables_2_2 = <?php echo json_encode($styleName2_2); ?>;
        const count_avm_2 = <?php echo json_encode($count_avm_2); ?>;
        const postgraduate_avm = {
            labels: lables_2_2,
            datasets: [{
                label: '視聽資料',
                data: count_avm_2,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依單位統計(教職員)
        const lables_2_3 = <?php echo json_encode($styleName2_3); ?>;
        const count_avm_3 = <?php echo json_encode($count_avm_3); ?>;
        const staff_avm = {
            labels: lables_2_3,
            datasets: [{
                label: '視聽資料',
                data: count_avm_3,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依單位統計(醫護人員)
        const lables_2_4 = <?php echo json_encode($styleName2_4); ?>;
        const count_avm_4 = <?php echo json_encode($count_avm_4); ?>;
        const medical_staff_avm = {
            labels: lables_2_4,
            datasets: [{
                label: '視聽資料',
                data: count_avm_4,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_中文期刊_依單位統計(大學生)
        const lables_3_1 = <?php echo json_encode($styleName3_1); ?>;
        const count_cj_1 = <?php echo json_encode($count_cj_1); ?>;
        const college_student_cj = {
            labels: lables_3_1,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位統計(研究生)
        const lables_3_2 = <?php echo json_encode($styleName3_2); ?>;
        const count_cj_2 = <?php echo json_encode($count_cj_2); ?>;
        const postgraduate_cj = {
            labels: lables_3_2,
            datasets: [{
                label: '中文期刊',
                data: count_cj_2,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位統計(教職員)
        const lables_3_3 = <?php echo json_encode($styleName3_3); ?>;
        const count_cj_3 = <?php echo json_encode($count_cj_3); ?>;
        const staff_cj = {
            labels: lables_3_3,
            datasets: [{
                label: '中文期刊',
                data: count_cj_3,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位統計(醫護人員)
        const lables_3_4 = <?php echo json_encode($styleName3_4); ?>;
        const count_cj_4 = <?php echo json_encode($count_cj_4); ?>;
        const medical_staff_cj = {
            labels: lables_3_4,
            datasets: [{
                label: '中文期刊',
                data: count_cj_4,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Config Block
        const options = {
            responsive: true,
            // plugins:{
            //     title: {
            //         display: true,
            //         text: '各職位',
            //         fontColor: '#595959',
            //         fontsize: 20,
            //         position: 'top' //top,left,bottom,right
            //     }
            // },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) { if (value % 1 === 0) { return value; } }
                    },
                    title: {
                        display: true,
                        text: '次數'
                    },
                }
            },
            legend: {
                position: 'top',
                display: true
            },
            animation: {
                duration: 2000,
                easing: 'linear' //easeOutQuart, easeInBounce, ...
            }
        };

        const config = {
            type: 'bar',
            data: data,
            options: options
        };

        // Render Block
        Chart.defaults.font.size = 18;
        Chart.defaults.font.Color = '#595959';
        Chart.defaults.font.family = "'Times New Roman','DFKai-sb'";
        const ctx = document.getElementById('Chart');
        const chart = new Chart(ctx, config);

        // 長條圖下鑽 Drill Down
        function clickHandler(click) {
            if (chart.config.data.datasets[0].label === '中西文圖書' && chart.config.data.datasets[1].label === '視聽資料' && chart.config.data.datasets[2].label === '中文期刊') {
                const points = chart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
                if (points.length) {
                    // console.log(points)

                    const firstPoint = points[0];
                    console.log(firstPoint)

                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 0) {
                        chart.config.data = medical_staff_ceb;
                    }
                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 1) {
                        chart.config.data = medical_staff_avm;
                    }
                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 2) {
                        chart.config.data = medical_staff_cj;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 0) {
                        chart.config.data = postgraduate_ceb;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 1) {
                        chart.config.data = postgraduate_avm;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 2) {
                        chart.config.data = postgraduate_cj;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 0) {
                        chart.config.data = staff_ceb;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 1) {
                        chart.config.data = staff_avm;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 2) {
                        chart.config.data = staff_cj;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 0) {
                        chart.config.data = college_student_ceb;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 1) {
                        chart.config.data = college_student_avm;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 2) {
                        chart.config.data = college_student_cj;
                    }

                    chart.update();
                }
            }
        }
        ctx.onclick = clickHandler;

        //回上層bottom
        function resetChart() {
            chart.config.data = data;
            chart.update();
        }

        //下拉式選單_year
        function year() {
            var year = [];
            var temp_year = document.getElementsByName("year");
            var yNow = document.getElementById("yearNow");
            var mNow = document.getElementById("monthNow").innerHTML;
            for (var i = 0; i < temp_year.length; i++) {
                if (temp_year[i].selected) {
                    year.push(temp_year[i].innerHTML);
                }
            }
            yNow.innerHTML = year;

            if (year != '') {
                if (mNow != '') {
                    location.href = "count_rr.php?year=" + year + "&month=" + mNow;
                }
                else {
                    location.href = "count_rr.php?year=" + year;
                }   
            }
            else {
                location.href = "count_rr.php";
            }
        }

        //下拉式選單_month
        function month() {
            var month = [];
            var temp_month = document.getElementsByName("month");
            var mNow = document.getElementById("monthNow");
            var yNow = document.getElementById("yearNow").innerHTML;
            for (var i = 0; i < temp_month.length; i++) {
                if (temp_month[i].selected) {
                    month.push(temp_month[i].innerHTML);
                }
            }
            mNow.innerHTML = month;

            if (month != '') {
                if (yNow != '') {
                        location.href = "count_rr.php?year=" + yNow + "&month=" + month;  
                }
                else {
                    location.href = "count_rr.php";
                }
            }
            else {
                location.href = "count_rr.php?year=" + yNow;
            }
        }
    </script>

    <br>

    <!--返回button-->
    <p style="text-align:center;">
        <input type="button" style="background-color:white; font-size:20px; font-family:DFKai-sb; color:#203057;
                                                            height:40px; width:150px; border-radius:3px;" name="send"
            value="返回" onclick="history.back()" />
    </p>

    <!-- 彈跳視窗靈魂 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

</body>

</html>