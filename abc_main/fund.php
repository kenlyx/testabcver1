<?php

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
$connect2 = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_login", $connect); //讀ABC所有的公司名稱
mysql_query("set names 'utf8'");
$getcid = mysql_query("SELECT DISTINCT(`CompanyID`) FROM account", $connect);
mysql_select_db("testabc_main", $connect);
mysql_select_db("testabc_main", $connect2);

$month = 0;
$year = 0;
$temp = mysql_query("SELECT MAX(`year`) FROM `state`", $connect);
$result = mysql_fetch_array($temp);
$year = $result[0];
$temp = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year", $connect);
$result = mysql_fetch_array($temp);
$month = $result[0];

$right = 0;


while ($company = mysql_fetch_array($getcid)) {
    $CompanyID = $company['CompanyID'];
    //Settlement
	$d = 0.0;
	$ic = 0.0;
	$d_ic = 0.0;
	$d_long = 0;
	$d_short = 0;
	$interest = 0.0;
	$long_interest = 0;
	$short_interest = 0;
	$short_pay=0;
	$long_pay=0;
	$payment=0;
	$right = 0;
	
    $month_bf = $month - 1;
    if ($month_bf == 0) {
        $month_bf = 12;
        $year_bf = $year - 1;
    } else {
        $year_bf = $year;
    }
	$compare = ($year_bf - 1) * 12 + $month_bf;
	
	//計算$d_long, $d_short, $d
    $result = mysql_query("SELECT * FROM `fund_raising` WHERE `cid`='$CompanyID'", $connect);
    while ($row = mysql_fetch_array($result)) {
        if ((((int) $row['year'] - 1) * 12 + (int) $row['month']) <= $compare) {
            //還未結清的長期和短期借款
			$d_long = $d_long + (int) $row['long'] - (int) $row['repay'];
            $d_short = $d_short + (int) $row['short'] - (int) $row['repay2'];
        }
    }
	$d = $d_long + $d_short;
	//end計算$d_long, $d_short, $d
	//計算d/ic
	if($compare==1){
		$right=20000000;
	}else{
		$result = mysql_query("SELECT * FROM `equity` WHERE `cid`='$CompanyID' AND `month`=$compare-1", $connect);
		while ($row = mysql_fetch_array($result)) {
			$right = $right +  $row['price'];
		}
	}
	if($d+$right){
		$d_ic = (float) ($d / ($d + $right));
	}else{
		$d_ic=0;
	}

	//end計算d/ic
	//計算利率
    if (($d_ic) < 0.2) {
        $interest = 0.05/12;
    } elseif (( ($d_ic) > 0.2) && ( ($d_ic) < 0.4)) {
        $interest = 0.06/12;
    } elseif (( ($d_ic) > 0.4) && ( ($d_ic) < 0.6)) {
        $interest = 0.08/12;
    } elseif (( ($d_ic) > 0.6) && ( ($d_ic) < 0.8)) {
        $interest = 0.11/12;
    } elseif (($d_ic) > 0.8) {
        $interest = 0.15/12;
    }//end計算利率
	
	//計算借款利息
    if ($d_long > 0) {
        $long_interest = (int) ($d_long * $interest);
    } else {
        $long_interest = 0;
    }
    if ($d_short > 0) {
		$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='short_interest'", $connect);
		$row = mysql_fetch_row($temp);		
        //短期借款年利率=0.04
		$short_interest = (int) ($d_short * (float) ($row[0]/12));
    } else {
        $short_interest = 0;
    }
	$long_pay = $long_interest;
	$short_pay = $short_interest;
	//end計算借款利息
	echo "d_long=".$d_long.", d_short=".$d_short.", d=".$d.", right=".$right.", d/ic=".$d_ic."@";
    mysql_query("UPDATE `fund_raising` SET `d_ic`='$d_ic',`interest`='$interest',`long_interest`='$long_interest',`short_interest`='$short_interest',`long_repay`='$long_pay',`short_repay`='$short_pay' WHERE `year`=$year_bf AND `month`=$month_bf AND `cid`='$CompanyID'", $connect);
	
    //set the short_payment
	$compare = ($year - 1) * 12 + $month;
    $fund = mysql_query("SELECT * FROM `fund_raising` WHERE `cid`='$CompanyID'", $connect);
    while ($row = mysql_fetch_array($fund)) {
        if ((((int) $row['year'] - 1) * 12 + (int) $row['month']) < $compare) {
            
			if ($row['short'] != 0) {
                if (($compare - (((int) $row['year'] - 1) * 12 + (int) $row['month'])) == 6) {
                    $payment = (int) $row['short'];
					break;
                }
            }
			/*
			if ($row['long'] != 0) {
				if (($compare - (((int) $row['year'] -1 * 12 + (int) $row['month'])) == 24) {				
					$payment_long = (int) $row['long'];
					break;
				}
			}
			*/
		}
    }
	    
	//set the long_payment 
	
	echo $CompanyID;
	mysql_query("UPDATE `fund_raising` SET `repay2`='$payment' WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'", $connect);
    mysql_query("UPDATE `fund_raising` SET `repay`='$payment_long' WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'", $connect);
	
	
	
}
?>