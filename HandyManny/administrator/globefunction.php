<?php
function userkind()
{
	echo $list[type];
}
?>

<?php
function showtitle()
{
	echo '宿舍 報修系統';
}
// <a href="javascript:logout()" style="font-size:20px; font-family:DFKai-sb; color:#203057; float:right;
//                              margin-top:50px; margin-right:10px;">登出</a> title="首頁" title="登出"
function showheader()
{
	echo '
		<div style="padding:5px 0px 0px 5px;" >
			<a href="./admin_index.php" title="報修系統 - 政治大學 宿舍">
				<img src="../imgs/logo.png" align="center" id="headerimg" alt="政治大學-宿舍 報修系統" style="width:23%;">
			</a>
			
			<a href="javascript:logout()">			 
            	<img src="../imgs/logout.png" style="float:right; margin-top:40px; margin-right:15px; width:3%;">
			</a>
							 
			<a href="./admin_index.php">			 
            	<img src="../imgs/home.jpg" style="float:right; margin-top:45px; margin-right:180px; width:2%;">
			</a>
		</div>';
}