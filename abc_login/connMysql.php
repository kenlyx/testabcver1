<?php 
	//資料庫主機設定
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "53g4ek7abc";
	//連線伺服器
	$db_link = @mysql_connect($db_host, $db_username, $db_password);
	if (!$db_link) die("資料連結失敗！");
	//設定字元集與連線校對
	mysql_query("SET NAMES 'utf8'");
?>