<?php

session_start();
$cid = $_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$compare = ($year - 1) * 12 + $month;
$hire_count = 0;
$fire_count = 0;
$thismonth_hire = 0;
$thismonth_fire = 0;
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    
    
if(!strcmp($_GET['type'],"people")) {
	$result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='research'",$connect);
	$row = mysql_fetch_array($result);
	$rdcount = $row[0]-$row[1];
	$result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='finance'",$connect);
	$row = mysql_fetch_array($result);
	$financount = $row[0]-$row[1];
	$result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='sale'",$connect);
	$row = mysql_fetch_array($result);
	$salecount = $row[0]-$row[1];
	$result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='human'",$connect);
	$row = mysql_fetch_array($result);
	$humancount = $row[0]-$row[1];
	
	echo $financount . "|" . $salecount . "|" . $rdcount . "|" .$humancount;
}    
    
?>