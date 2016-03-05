<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<?php

$db_server = "localhost";

$db_name = "testabc_login";

$db_user = "root";

$db_passwd = "1942jiqu,6sj/4";

$connect=@mysql_connect($db_server, $db_user, $db_passwd);
if(!$connect){
	die("無法對資料庫連線");
}

mysql_query("SET NAMES 'utf8'",$connect);
mysql_query("SET CHARACTER_SET_database= utf8",$connect);
mysql_query("SET CHARACTER_SET_CLIENT= utf8",$connect);
mysql_query("SET CHARACTER_SET_RESULTS= utf8",$connect); 

if(!@mysql_select_db($db_name)){
	die("無法使用資料庫");
}

?> 
<body>
</body>
</html>