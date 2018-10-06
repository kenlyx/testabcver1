<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<?php
include("../connMysql.php");
$seldb = mysql_select_db("102abc_admin");
if (!$seldb) die("資料庫選擇失敗！");

if(isset($_GET["action"]) && $_GET["action"]=="set"){
	
	$courseN=mysql_real_escape_string($_POST["courseName"]);
	$courseT=mysql_real_escape_string($_POST["courseTeacher"]);
	$gameN=mysql_real_escape_string($_POST["gameName"]);
	$sql_query = "INSERT INTO `game` (`index`,`CourseName`,`CourseTeacher`,`GameName`) VALUES (";
		if($courseN!="" and $courseT!="" and $gameN!=""){
			 $sql_query .= "'',";
			 $sql_query .= "'".$courseN."',";
			 $sql_query .= "'".$courseT."',";
		   	 $sql_query .= "'".$gameN."')";
	     	 mysql_query($sql_query);	 	
		}else
			echo "建立失敗";
}
?>
<style>
.title{
	font-family:"華康秀風體W3";
	font-size:28px;
	color:#7fbfff;
	}
.steps{
	font-size:20px;
	font-family:"華康采風體W3";
	color:#FFF;
	}	
body{
	background:url(bg.png);
	color:#FFF;
	height:700px;
}			
</style>
<body>
<p style="height:2%">
<div class="title">
<b>建立競賽的步驟說明及操作</b></div>
<p>
<div class="steps">
1. 複製 phpmyadmin 裡的 clearabc_login 和 clearabc_main 資料庫並分別給予新的名稱。<br>&nbsp;&nbsp;&nbsp;
ex: "管會大學部" 可設為 MAU_login 和 _main / "管會研究所" 可設為 MAG_login 和 _main
<br><br>
2. 複製www裡的102abc資料夾，更新資料夾名稱，並更新連結資料庫的路徑
<br><br>
3. 完成以下的資料填寫裡的資料填寫
<br><br>
<?php
		echo '<form action="?action=set" method="post" name="form1" id="form1">';

		echo '&nbsp;&nbsp;&nbsp;課程名稱：<input type="text" size="10px" name="courseName" required/><br>';
		echo '&nbsp;&nbsp;&nbsp;授課導師：<input type="text" size="10px" name="courseTeacher" required/><br>';
		echo '&nbsp;&nbsp;&nbsp;競賽名稱：<input type="text" size="10px" name="gameName" required/><br><br>';
        
		echo '&nbsp;&nbsp;&nbsp;<input type="submit" name="button" style="height:20px" value="送出"/></form>';
?>
<br>
4. 至 "競賽管理" 裡選取剛設定的"競賽名稱"，點選"上傳學生名單"並依照指示完成設定 
</div>
<p>
</body>
</html>