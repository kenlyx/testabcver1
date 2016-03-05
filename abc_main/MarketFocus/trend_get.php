<?php
    session_start();
$year_now =$_SESSION['year'];
$month =$_SESSION['month'];
$month_now =$_SESSION['month'];


$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");

if (!strcmp($_GET['type'], "year")) {
	$year=1;
    echo $year_now.":".$month;
} else {
    $year = (int) $_GET['type'];
    $temp = mysql_query("SELECT * FROM `market_trend` WHERE `year`=$year ORDER BY `month`;", $connect);
    while ($result = mysql_fetch_array($temp)) {
        if ($result[0] == "")
            break;
        echo $result['month'] . ":" . $result['A_trend'] . ":" . $result['B_trend'] . ":";
    }
    echo "@";
}
	
?>
