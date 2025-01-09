<!DOCTYPE html>
<?php session_start();
require_once("./globefunction.php");
require_once("./mysql_connect.php");

//抓user身分

if(isset($_GET['login_error'])){
    echo ' <div id="login_yn" style="display:none">'.$_GET['login_error'].'</div>';
}
else{
    echo ' <div id="login_yn" style="display:none">0</div>';
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />

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

    <script>
        window.onload=function(){
            var login_yn = document.getElementById('login_yn').innerHTML;
            if(login_yn=="1"){
                alert('帳號或密碼錯誤，請重新輸入!')
            }
        }

        function myFunction() {


        }
        $(document).ready(function () {
            $('#autoclickme a').get(0).click();
        });

        function check() {
            if (logintable.account.value == "") {
                alert("尚未填寫帳號！");
                return false;
            }
            else if (logintable.password.value == "") {
                alert("尚未填寫密碼");
                return false;
            }
            else {
                logintable.submit();
            }
        }

        //enter login
        function login_enter() {

            if (event.keyCode == 13) {
                alert('enter');
            }
        }

        function submitenter(myfield, e) {
            var keycode;
            if (window.event) keycode = window.event.keyCode;
            else if (e) keycode = e.which;
            else return true;
            if (keycode == 13) {
                myfield.form.submit();
                return false;
            }
            else
                return true;
        }
        
    </script>

</head>

<!-- 彈跳視窗樣式 -->
<style>
    #window-container {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #window-pop {
        background: white;
        width: 30%;
        margin: 3.5% auto;
        overflow: auto;
        border-radius: 3px;
    }

    .window-content {
        width: auto;
        height: 616px;
        line-height: 200px overflow: auto;
        text-align: center;
    }

    span {
        display: inline-block;
        vertical-align: middle;
        line-height: normal;
    }
</style>

<body>
    <!--左邊區塊-->
    <div style="float:left; height:100%; width:35%;">

        <!--系統logo-->
        </br></br>
        <img src="./imgs/logo.png" style="float:left; width:80%; margin-left:9%; margin-top:6%;">

        </br></br>

        <!--登入頁圖片-->
        <img src="./imgs/dog.png" style="float:left; width:90%; margin-left:3%;">
    </div>

    <!--右邊登入區塊-->
    <div style="float:left; height:100%; width:65%;">

        </br></br></br></br></br>

        <!--標題 -->
        <h2 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size: 40px; text-align:center;">登 入</h2>

        <br><br><br>

        <!--登入表格-->
        <div id="layout">
            <form id="logintable" name="logintable" method="post" enctype="multipart/form-data"
                action="login_judge.php">
                <p
                    style="text-align:right; margin-right:35%; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px;">
                    帳號：
                    <input type="text" placeholder="Account" name="account" id="account"
                        style="padding:3px; width:40%; border-radius:3px; font-size:18px; font-family:Times New Roman, DFKai-sb;"
                        onKeyUp="value=value.replace(/[\W]/g,'') " />
                </p>

                <p
                    style="text-align:right; margin-right:35%; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px;">
                    密碼：
                    <input type="password" placeholder="Password" name="password" id="password"
                        style="padding:3px; width:40%; border-radius:3px; font-size:18px; font-family:Times New Roman, DFKai-sb;"
                        onKeyUp="value=value.replace(/[\W]/g,'') " />
                    <img src="./imgs/eyeclose.jpg" style="width:4%; margin-right:-30px;" id="eyes">
                </p>

                <!-- 眼睛閉合靈魂 -->
                <script>
                    var input = document.querySelector('input[name="password"]')
                    var imgs = document.getElementById('eyes');
                    var flag = 0;
                    imgs.onclick = function () {
                        if (flag == 0) {
                            input.type = 'text';
                            eyes.src = './imgs/eyeopen.jpg'; //睜眼
                            flag = 1;
                        } else {
                            input.type = 'password';
                            eyes.src = './imgs/eyeclose.jpg'; //閉眼
                            flag = 0;
                        }
                    }
                </script>


                <!--帳號密碼說明按鈕-->
                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="margin-left:54%; color:red; font-family:Times New Roman,'DFKai-sb'; font-size:18px;"><u>帳號密碼說明</u></a>

                <!-- 帳號密碼說明跳視窗 -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <img src="./imgs/notice.png" style="width:120%; height:120%;">
                        </div>
                    </div>
                </div>

                <br><br><br><br><br>

                <!--登入btn-->
                <div style="text-align:center;">
                    <input type="button" class="btn" name="send" value="登入" onclick="check();" />
                </div>

            </form>
            <div id="autoclickme">

                <a onclick="myFunction()" data-am-modal="{target: '#newequipment'}"></a>
            </div>
            

        </div>
    </div>

    <!-- 彈跳視窗靈魂 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>