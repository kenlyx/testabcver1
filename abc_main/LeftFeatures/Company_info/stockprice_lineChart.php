<?php

session_start();
$year = $_SESSION['year'];
$year_now = $_SESSION['year'];
$month = $_SESSION['month'];
$month_now =$_SESSION['month'];
$company = $_SESSION['cid'];

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'UTF8'");

if (!strcmp($_GET['type'], "year")) {
    echo $year.":".$month;
    $_SESSION['year'] = $year_now;
	$_SESSION['month'] = $month_now;
} else {
    $year = (int) $_GET['type'];
	if(($month<2)&&($year==$year_now)){
		$year=$year-1;
	}
    $temp = mysql_query("SELECT * FROM `stock` WHERE `year`='$year' AND `cid`='$company' ORDER BY `month`;", $connect);
    while ($result = mysql_fetch_array($temp)) {
        if ($result[0] == "")
            break;
        echo $result['month'] . ":" . $result['stock_price'] . ":";
    }
    echo "@";
}
$_SESSION['year'] = $year_now;
$_SESSION['month'] = $month_now;
?>
