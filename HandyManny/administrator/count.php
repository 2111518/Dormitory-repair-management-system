<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("./globefunction.php");
include_once('../mysql_connect.php');

// Function to safely execute queries and handle errors
function executeQuery($con, $query) {
    $result = mysqli_query($con, $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($con));
        return false;
    }
    return $result;
}

// 獲取選擇的商品名稱和時間範圍
$selectedItemName = isset($_GET['ItemName']) ? $_GET['ItemName'] : null;
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '2024-01-01';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '2024-12-31';

$data1 = [];
$data2 = [];

// 只在總覽頁面查詢圖表1資料
if (!$selectedItemName) {
    $query1 = "
        SELECT
            MIN(i.ItemID) as ItemID,
            i.ItemName,
            COUNT(a.AID) AS RepairCount
        FROM
            application a
        JOIN
            item i ON a.ItemID = i.ItemID
        WHERE
            a.Time BETWEEN '$startDate' AND '$endDate'
        GROUP BY
            i.ItemName
        ORDER BY
            RepairCount DESC;
    ";

    $result1 = executeQuery($con, $query1);
    
    if ($result1) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $data1[] = $row;
        }
        mysqli_free_result($result1);
    }
}

// 查詢圖表2資料（當選擇了特定商品時）
if ($selectedItemName) {
    $query2 = "
        SELECT
            l.LName,
            i.ItemName,
            COUNT(a.AID) AS DamageCount
        FROM
            application a
        JOIN
            item i ON a.ItemID = i.ItemID
        JOIN
            location l ON i.LID = l.LID
        WHERE
            i.ItemName = ?
            AND a.Time BETWEEN '$startDate' AND '$endDate'
        GROUP BY
            l.LName, i.ItemName
        ORDER BY
            DamageCount DESC;
    ";
    
    $stmt = mysqli_prepare($con, $query2);
    mysqli_stmt_bind_param($stmt, "s", $selectedItemName);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);

    if ($result2) {
        while ($row = mysqli_fetch_assoc($result2)) {
            $data2[] = $row;
        }
        mysqli_free_result($result2);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($con);

$chartData1 = !empty($data1) ? json_encode($data1) : '[]';
$chartData2 = !empty($data2) ? json_encode($data2) : '[]';
?>
<!DOCTYPE html>
<html lang="zh-TW">
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

        .selected {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
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
                echo "讀者";
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
                統計申請紀錄</li>
        </ol>
    </nav>

    <!-- 標題 -->
    <h2
        style="text-align:center; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:40px; user-select:none;">
        統  計  申  請  紀  錄
    </h2>

    <!-- 時間範圍選擇 -->


    <?php if (!$selectedItemName): ?>
        <!-- 總覽頁面 -->
        <div class="selected">
            <form action="" method="GET">
                <label for="startDate">開始日期：</label>
                <input type="date" name="startDate" value="<?php echo $startDate; ?>" required>
                &emsp;
                <label for="endDate">結束日期：</label>
                <input type="date" name="endDate" value="<?php echo $endDate; ?>" required>
                &emsp;
                <button type="submit" class="btn">更新</button>
            </form>
        </div>

        <nav class="navbar navbar-light" style="width:95%;">
            <div class="container-fluid" style="margin-left:5.5%;">
                <canvas id="chart1" style="width: 95.5%; display: block; box-sizing: border-box; height: 435px;"></canvas>
            </div>
        </nav>

        <?php else: ?>
        <!-- 詳細頁面 -->
        <div class="selected">
            選擇的商品：<?php echo htmlspecialchars($selectedItemName); ?>
            &emsp;&emsp;
            <a href="?startDate=<?php echo $startDate; ?>&endDate=<?php echo $endDate; ?>" class="btn">返回總覽</a>
        </div>

        <nav class="navbar navbar-light" style="width:95%;">
            <div class="container-fluid" style="margin-left:5.5%;">
                <canvas id="chart2" style="width: 95.5%; display: block; box-sizing: border-box; height: 435px;"></canvas>
            </div>
        </nav>
    <?php endif; ?>

    <script>
        // 設定全局字體樣式
        Chart.defaults.font.size = 18;  // 設定字體大小為 18px
        Chart.defaults.font.color = '#595959';  // 設定字體顏色為灰色
        Chart.defaults.font.family = "'Times New Roman','DFKai-sb'";  // 設定字體為 'Times New Roman' 或 'DFKai-sb'

        var chartData1 = <?php echo $chartData1; ?>;
        var chartData2 = <?php echo $chartData2; ?>;
        var selectedItemName = <?php echo $selectedItemName ? json_encode($selectedItemName) : 'null'; ?>;
        var startDate = "<?php echo $startDate; ?>";
        var endDate = "<?php echo $endDate; ?>";

        window.onload = function() {
            if (!selectedItemName) {
                // 總覽頁面的圖表
                const itemNames = chartData1.map(item => item.ItemName);
                const repairCounts = chartData1.map(item => item.RepairCount);
                const itemNames_for_url = chartData1.map(item => encodeURIComponent(item.ItemName));

                const ctx1 = document.getElementById('chart1').getContext('2d');
                const chart1 = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: itemNames,
                        datasets: [{
                            label: '各類物品報修次數',
                            data: repairCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
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
                        onClick: function(e) {
                            const activePoints = chart1.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
                            if (activePoints.length > 0) {
                                const selectedItemName = itemNames_for_url[activePoints[0].index];
                                // 確保 URL 正確地加入 startDate 和 endDate 參數
                                window.location.href = `?ItemName=${selectedItemName}&startDate=${startDate}&endDate=${endDate}`;
                            }
                        }
                    }
                });
            } else if (chartData2.length > 0) {
                // 詳細頁面的圖表
                const locations = chartData2.map(item => item.LName);
                const damageCounts = chartData2.map(item => item.DamageCount);

                const ctx2 = document.getElementById('chart2').getContext('2d');
                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: locations,
                        datasets: [{
                            label: '損壞物品地點',
                            data: damageCounts,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
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
                        }
                    }
                });
            }
        };
    </script>


</body>
</html>
