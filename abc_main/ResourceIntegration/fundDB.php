<?php session_start();?>
<?php
$cid =$_SESSION['cid'];
$month =$_SESSION['month'];
$year =$_SESSION['year'];

$lia_now = 0;
$stock_now = 0;
$debt_now = 0;
$stock_price = 0;
$dividend_cost = 0;
$estimate_debt=0;
$test_debt=0;
include("../connMysql.php");
if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
mysql_query("set names 'utf8'");

if (!strcmp($_GET['type'], "set")) {
    $month_now = ($year - 1) * 12 + $month;
    /*$result = mysql_query("SELECT * FROM `fund_raising` WHERE `cid`='$cid' ORDER BY `year`, `month`");
    while ($row = mysql_fetch_array($result)) {
        $compare = ((integer) $row['year'] - 1) * 12 + (integer) $row['month'];
        if ($compare < $month_now) {
            $lia_now = $lia_now + $row['long'] + $row['long_interest'] - $row['repay'] - $row['long_repay'];
			$debt_now=$debt_now+$row['long']+$row['short']+$row['short_interest']-$row['repay']-$row['short_repay'];
        }
    }*/
	if($month_now==1){
		$debt_now=0;
		$lia_now=0;
	}
	else{
		$result = mysql_query("SELECT `price` FROM `long-term_liabilities` WHERE `name`=212 AND `cid`='$cid' AND `month`=$month_now-1");
		$temp=mysql_fetch_array($result);
		$debt_now=$temp[0];
		$lia_now=$temp[0];
		$result = mysql_query("SELECT `price` FROM `current_liabilities` WHERE `name`=211 AND `cid`='$cid' AND `month` =$month_now-1");
		$temp=mysql_fetch_array($result);
		$debt_now+=$temp[0];//長期上回+短期借款上回=上回總借款
	}
	
    $result = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
    $row = mysql_fetch_row($result);
    $cash = (int) $row[0];  //現金
	
	// NEW 2013/5/26
	//mysql_select_db("testabc_main");	
	//$sql_year = "SELECT MAX(`year`) FROM `outside_stock`";
	//$endyear = mysql_query($sql_year);	
		//$rowy=mysql_fetch_array($endyear);
		//$carter1=$rowy[0];
	//$sql_month = "SELECT MAX(`month`) FROM `outside_stock` ";
	//$endmonth = mysql_query($sql_month);	
		//$rowm=mysql_fetch_array($endmonth);
		//$carter2=$rowm[0];
	// NEW 2013/5/26 end

	$outstock = mysql_query("SELECT `outside_stock` FROM `stock` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
	$row0 =  mysql_fetch_array($outstock);

	
    $result = mysql_query("SELECT * FROM `fund_raising` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");
	
    $row = mysql_fetch_array($result);
    $short = $row['short'];
    $long = $row['long'];
    $repay = $row['repay'];
	$dividend = $row['dividend'];
	$dc=$row['dividend_cost'];
    $cash_increase = $row['cash_increase'];
    
	$cash+=($cash_increase+$short+$long-$repay+$dc);
    $treasury = $row0[0];
    
	$estimate_debt = $debt_now + $long + $short - $repay;
    $equity = 0;
	if($month_now == 1){
		$equity = 20000000;
		
	}
	else{
		$result = mysql_query("SELECT * FROM `equity` WHERE `cid`='$cid' AND `month`=$month_now-1");
		while ($row = mysql_fetch_array($result)) {
			$equity = $equity + $row['price'];
		}
	}
	
    if (($equity+$debt_now)==0) { //資產(正數)+負債(正數)
        $debt_now = 0;
    } 
	else {//?
		$test_debt=$equity-$debt_now;
		
        $debt_now = (float) (($debt_now) / ($debt_now + $equity));
		$debt_now=$debt_now*100;
		
		
    }
	if (($equity+$estimate_debt)==0) {
		$estimate_debt=0;
    } 
	else {
		$estimate_debt = (float) (($estimate_debt) / ($estimate_debt + $equity));
		$estimate_debt=$estimate_debt*100;
    }
    $result = mysql_query("SELECT `stock_price`,`stock` FROM `stock` WHERE `cid`='$cid' AND `year`='$year'AND `month`='$month'");
    $row = mysql_fetch_row($result);
    $stock_price = $row[0];	
    $stock_now = $row[1];	
	
	$result = mysql_query("SELECT SUM(`treasury`) FROM `fund_raising` WHERE `cid`='$cid'");
	$row = mysql_fetch_array($result);
	$treasurystock = $row[0];
	
	
    echo $lia_now . "|" . number_format($debt_now, 2) . "|" . number_format($stock_price, 2) . "|" . $cash_increase . "|" . $dividend . "|" . $short . "|" . $long . "|" . $repay . "|" . number_format($estimate_debt, 2) . "%|" . $stock_now . "|" . $treasury."|".$cash. "|".$test_debt. "|".$treasurystock;	
	
} 
elseif (!strcmp($_GET['type'], "update")) {
	//echo $_GET['decision1'];
    $result = mysql_query("SELECT `stock` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`");
    $temp = mysql_fetch_array($result);
	$my_stock = $temp[0];
	$result = mysql_query("SELECT `outside_stock` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`");
	$temp = mysql_fetch_array($result);
	$outside_stock = $temp[0];
	$dividend_cost -= $_GET['decision5'] * ($my_stock + $outside_stock);
	//echo $_GET['decision1']."|".$_GET['decision2']."|".$_GET['decision3']."|".$_GET['decision4']."|".$_GET['decision5']."|".$_GET['decision6'].$dividend_cost;
	$treasury = $_GET['decision6']-$_GET['decision7'];
	$outside_stock1 = $outside_stock-$treasury;
	//mysql_query("UPDATE `stock` SET  `outside_stock`=".$outside_stock1." WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	mysql_query("UPDATE `fund_raising` SET `short`=".$_GET['decision1'].",`long`=".$_GET['decision2'].",`repay`=".$_GET['decision3'].",`cash_increase`=".$_GET['decision4'].",`dividend`=".$_GET['decision5'].",`dividend_cost`=".$dividend_cost.",`treasury`=".$treasury." WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	
} 
elseif (!strcmp($_GET['type'], "month")) {
	echo $month;
}
?>
