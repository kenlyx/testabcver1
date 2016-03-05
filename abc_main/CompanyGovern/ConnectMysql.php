<?php
//資料庫主機設定
$db_host="localhost";
$db_username="root";
$db_password="53g4ek7abc";

//連線伺服器
$db_link=@mysql_connect($db_host,$db_username,$db_password); //mysql前面加上一個@,可以抑制錯誤訊息的產生
if(!$db_link) die("資料連結失敗");

//設定字元集語連線校對
mysql_query("SET NAMES utf8");

$select_db=@mysql_select_db("testabc_main");
if(!$select_db) die("資料出錯");

?>
