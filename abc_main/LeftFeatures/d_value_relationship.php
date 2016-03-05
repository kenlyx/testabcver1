<?php

session_start();
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'utf8'");
$company = $_SESSION['cid'];
$year_now=$_SESSION['year'];
$month_now=$_SESSION['month'];
$temp = 0;
$reply = "";
$price = 0;
$des = "";
$content = "";
$name = "";
$num=0;
if (($_GET['option']) == "donate") {
    $for_cal = mysql_query("SELECT * FROM `donate` WHERE `cid`='$company' ORDER BY `year`, `month`", $connect);
    while ($cal_array = mysql_fetch_array($for_cal)) {
		if(((int)$cal_array[3]+(int)$cal_array[4]+(int)$cal_array[5])>0){
			$reply = $reply . "[" . $cal_array[1] . "," . $cal_array[2] . ",";
			for ($i = 3; $i < 6; $i++) {
				$temp = $cal_array[$i];
				if ($temp == 0)
					$reply = $reply . "0";
				elseif ($temp == 1)
					$reply = $reply . "100000";
				elseif ($temp == 2)
					$reply = $reply . "200000";
				elseif ($temp == 3)
					$reply = $reply . "300000";
				if ($i < 5)
					$reply = $reply . ",";
			}
			$reply = $reply . "],";
		}else{
			
		}
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
}elseif (($_GET['option']) == "share") {
    $for_cal = mysql_query("SELECT * FROM `share` WHERE `cid`='$company' ORDER BY `year`, `month`", $connect);
    while ($cal_array = mysql_fetch_array($for_cal)) {
		if(((int)$cal_array[3]+(int)$cal_array[4]+(int)$cal_array[5])>0){
			$reply = $reply . "[" . $cal_array[1] . "," . $cal_array[2] . ",";
			for ($i = 3; $i < 6; $i++) {
				$temp = $cal_array[$i];
				if ($temp == 0){
					$reply = $reply . "0";
				}elseif ($temp == 1){			
					$reply = $reply . "100000";
				}elseif ($temp == 2){
					if($i==5){
						$reply = $reply . "200000";
					}else{
						$reply = $reply . "200000";
					}
				}elseif ($temp == 3){
					if($i==5){
						$reply = $reply . "300000";
					}else{
						$reply = $reply . "300000";
					}
				}
				if ($i < 5)
					$reply = $reply . ",";
			}
			$reply = $reply . "],";
		}else{
			
		}
			
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
}elseif (($_GET['option']) == "relationship") {
$connect2 = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect2);
$correspondence = mysql_query("SELECT * FROM `correspondence` WHERE `name`='current_people'", $connect2);
$correspond = mysql_fetch_array($correspondence);
$correspondence = mysql_query("SELECT * FROM `correspondence` WHERE `name`='current_people_2'", $connect2);
$correspond2 = mysql_fetch_array($correspondence);

$for_cal = mysql_query("SELECT * FROM `relationship_decision` WHERE `cid`='$company'", $connect);
while ($row = mysql_fetch_array($for_cal)) {
    $des = explode("_", $row['target']);
    if (!strcmp($des[0], "empolyee")) {
        if (!strcmp($des[1], "sale")) {
            $price = (int) ((int) $correspond2['money'] * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'員工關係管理','發放行銷業務人員獎金$" . $price . "元'],";
        } elseif (!strcmp($des[1], "equip")) {
            $price = (int) ((int) $correspond['money3'] * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'員工關係管理','發放資源運籌人員獎金$" . $price . "元'],";
        } elseif (!strcmp($des[1], "human")) {
            $price = (int) ((int) $correspond2['money2'] * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'員工關係管理','發放行政人員獎金$" . $price . "元'],";
        } elseif (!strcmp($des[1], "finance")) {
            $price = (int) ((int) $correspond['money2'] * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'員工關係管理','發放財務人員獎金$" . $price . "元'],";
        } elseif (!strcmp($des[1], "research")) {
            $price = (int) ((int) $correspond2['money3'] * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'員工關係管理','發放研發人員獎金$" . $price . "元'],";
        }
    } elseif (!strcmp($des[0], "customer")) {
        $num = (int) $des[1];
        $get = mysql_query("SELECT * FROM `customer_state` WHERE `index`=$num", $connect2);
        $names = mysql_fetch_array($get);
        $name = $names['name'];
        $content = explode("_", $row['decision']);
        if ((int) $content[1] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'顧客關係管理','給予" . $name . "" . $row['level'] . "%折扣'],";
        } elseif ((int) $content[1] == 2) {
            if ((int) $row['level'] == 1) {
                $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'顧客關係管理','提供" . $name . "普通的售後服務'],";
            } elseif ((int) $row['level'] == 2) {
                $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'顧客關係管理','提供" . $name . "較佳的售後服務'],";
            } elseif ((int) $row['level'] == 3) {
                $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'顧客關係管理','提供" . $name . "頂級的售後服務'],";
            }
        }
    } elseif (!strcmp($des[0], "investor")) {
        $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'投資人關係管理','上升一級'],";
    } elseif (!strcmp($des[0], "supplier")) {
        $get = mysql_query("SELECT * FROM `order_accept` WHERE `accept`=1 AND `cid`='$company' AND `year`={$row['year']} AND `month`={$row['month']}-1", $connect2);
        $mo = mysql_fetch_array($get);
        $price = (int) $mo['price'] * (int) $mo['quantity'];
        if ((int) $des[1] == 0) {
            $price = (int) ($price * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'供應商關係管理','提供供應商A $" . $price . "元的分紅'],";
        } elseif ((int) $des[1] == 1) {
            $price = (int) ($price * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'供應商關係管理','提供供應商B $" . $price . "元的分紅'],";
        } elseif ((int) $des[1] == 2) {
            $price = (int) ($price * ((float) $row['level'] / 100));
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'供應商關係管理','提供供應商C $" . $price . "元的分紅'],";
        }
    }
}
$_SESSION['year']=$year_now;
$_SESSION['month']=$month_now;
}



echo "[" . $reply . "]";
?>
