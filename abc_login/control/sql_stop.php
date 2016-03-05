<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
include("mysql_connect.inc.php");
foreach($_POST as $key => $value);

	
	$nowt = 0;
	$norr = 0;
	$status ='';
	$getroundtime ="select * from timer where id ='1' and account='server'"; 
	$getroundtime1 = mysql_query($getroundtime);
	$getroundtime2 = mysql_fetch_array($getroundtime1,MYSQL_ASSOC);
	$nowrunid = $getroundtime2["runid"];	


	mysql_query("delete from time where id>$nowrunid");
		mysql_query("update timer set isstart='0',status='競賽暫停' where id='1'");






?>
</body>
</html>