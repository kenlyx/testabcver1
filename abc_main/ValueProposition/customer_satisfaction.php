<?php @session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顧客滿意度</title>
<link rel="stylesheet" href="../css/tableyellow.css" type="text/css" />
<link rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<?php
$cid =$_SESSION['cid'];
include("../connMysql.php");
if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
mysql_query("set names 'utf8'");

$b2b = array();
$b2c = array();
$s = mysql_query("SELECT * FROM customer_satisfaction WHERE `cid`='$cid'");
while ($row = mysql_fetch_array($s)) {
    $name = mysql_query("SELECT * FROM customer_state WHERE `name`='$row[0]'");
    $result = mysql_fetch_array($name);
    if ((int) $result['b_or_c'] == 1) {
        array_push($b2c, $row[0]);
    } elseif ((int) $result['b_or_c'] == 0) {
        array_push($b2b, $row[0]);
    }
}
$b_num = count($b2b);
$c_num = count($b2c);
$flag = 1;
?>
<style>
#content{
	margin-left:4%;
    margin:5px auto;
        }
</style>    
    <div id="content">
        <a class="back" href=""></a>
        <p class="head">
        ShelviDream Activity Based Costing Simulated System
        </p>
        <h1>顧客滿意度</h1>
        
<table align='center' cellspacing='0' class="ytable">
<thead><tr>
    <td colspan="2" width="30%">大訂單</td>
    <td colspan="2" width="30%">小訂單</td></tr>
<tr>
    <th>顧客名稱</th>
    <th>滿意度</th>
    <th>顧客名稱</th>
    <th>滿意度</th></tr>
</thead>
<?php
for ($i = 0; $i < max($b_num, $c_num); $i++) {
    if (($flag % 2) == 1) {
        echo "<tr class='odd'>";
    }
    $flag++;
    if ($i < $b_num) {
        $s = mysql_query("SELECT * FROM customer_satisfaction WHERE `cid`='$cid' AND `customer`='$b2b[$i]'");
        $row = mysql_fetch_array($s);
        echo "<td>".$row['customer']."</td><td>".$row['satisfaction']." %</td>";
    } else {
        echo "<td></td><td></td>";
    }
    if ($i < $c_num) {
        $s = mysql_query("SELECT * FROM customer_satisfaction WHERE `cid`='$cid' AND `customer`='$b2c[$i]'");
        $row = mysql_fetch_array($s);
        echo "<td>".$row['customer']."</td><td>".$row['satisfaction']." %</td>";
    } else {
        echo "<td></td><td></td>";
    }
	echo "</tr>";
	}
?>
</table>
</div>
</body>
</html>