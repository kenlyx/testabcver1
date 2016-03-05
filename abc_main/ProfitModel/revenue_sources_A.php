<?php
session_start();
$year = $_SESSION['year'];
$year_now = $_SESSION['year'];
$company = $_SESSION['cid'];

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'UTF8'");
$reply = "";
$rely="";
$rev=0;
if (!strcmp($_GET['type'], "year")) {
    echo $year;
	$_SESSION['year'] = $year_now;
} else {
	$flag=0;
	$rev=0;
    $year = (int) $_GET['type'];
	for($i=1;$i<=12;$i++){
		$result=mysql_query("SELECT * FROM `order_accept` WHERE `year`=$year AND `month`= $i AND `cid`='$company' AND `accept`=1;", $connect);
		while($row = mysql_fetch_array($result)){
			$out = explode("_", $row['order_no']);
			if(!strcmp($out[1], "A")){
				$flag=1;
				$rev=$rev+(int) $row['price'] * (int) $row['quantity'];
			}
		}
		if(!$flag){
			$reply=$reply.$i.":"."0:";
		}else{
			$reply=$reply.$i.":".$rev.":";
			$flag=0;
		}
	}
	$reply=$reply."@";
    echo $reply;
}
$_SESSION['year'] = $year_now;
?>