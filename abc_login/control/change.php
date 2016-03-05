<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

include("../connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

foreach($_POST as $key => $value);


if($gameN)
{

	echo "fds".$gameN;

	$_SESSION['gameName']=$gameN; //老師登入主控台的轉換
	

/*	$selectN=mysql_query("select GameNo from game where GameName ='$gameName' ")or die ("false");
	$selectNo=mysql_fetch_array($selectN);
	$gameNo=$selectNo[0];

	$_SESSION["GameNo"]=$gameNo; //抓出遊戲編號*/

}


?>
</body>
</html>