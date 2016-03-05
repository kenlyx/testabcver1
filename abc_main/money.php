<?php
    session_start();
	include("./connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
	
	@mysql_select_db("testabc_main");
	$sql_year=mysql_query("SELECT MAX(`year`) FROM state");
	$year=mysql_fetch_array($sql_year);
	$year=$year[0];
	$sql_month=mysql_query("SELECT MAX(`month`) FROM state WHERE `year`=$year");
	$month=mysql_fetch_array($sql_month);
	$month=$month[0];
	$thisround=($year-1)*12+$month;
	$cid=$_SESSION['cid'];
 if(!strcmp($_GET['type'],"cash")){
		
			$com_temp=$_SESSION['cid'];
			$result_21 = @mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$com_temp' AND `year`='$year' AND `month`='$month'");
			$money = mysql_fetch_array($result_21);
			$cash = $money[0];
			echo $cash;
 }

?>