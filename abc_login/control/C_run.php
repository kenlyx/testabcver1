<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>


<body>
<?php
include("./mysql_connect.inc.php");//testabc_login


	$sql_getenvir ="select * from environment where id ='1'"; 	
	$envir_get = mysql_query($sql_getenvir);
	$envir = mysql_fetch_array($envir_get,MYSQL_ASSOC);
	$term = $envir["year"];  
	$round =$envir["month"];
	
	
	if($round<12){
		
		$setmonth = $round+1;
		$sql = "update environment set month = '$setmonth'";
		mysql_query($sql);
		echo "<br/>";
		echo "進入下一回合 第".$term."年".$setmonth."月";
		echo "<br/>";

	}
	else{
		$setmonth = 1;
		$setyear = $term+1;
		$sql = "update environment set year = '$setyear',month = '$setmonth'";
		mysql_query($sql);
		echo "<br/>";
		echo "進入下一回合 第".$setyear."年".$setmonth."月";
		echo "<br/>";
	
	}
	
?>
</body>
</html>