<?php

session_start();
$cid = $_SESSION['cid'];
$year_now=$_SESSION['year'];
$month_now=$_SESSION['month'];

$reply = "";
$flage = 0;
$month = 0;
$year = 0;
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'utf8'");
if (($_GET['option']) == "buy_material") {
    $purchase = mysql_query("SELECT * FROM purchase_materials WHERE `cid`='$cid'", $connect);
    while ($row = mysql_fetch_array($purchase)) {
        $year = $row['year'];
        $month = $row['month'];

        if ($row['ma_supplier_a'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'螢幕與面板','供應商A'," . $row['ma_supplier_a'] . "],";
        }
        if ($row['ma_supplier_b'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'螢幕與面板','供應商B'," . $row['ma_supplier_b'] . "],";
        }
        if ($row['ma_supplier_c'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'螢幕與面板','供應商C'," . $row['ma_supplier_c'] . "],";
        }
        if ($row['mb_supplier_a'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'主機板與核心電路','供應商A'," . $row['mb_supplier_a'] . "],";
        }
        if ($row['mb_supplier_b'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'主機板與核心電路','供應商B'," . $row['mb_supplier_b'] . "],";
        }
        if ($row['mb_supplier_c'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'主機板與核心電路','供應商C'," . $row['mb_supplier_c'] . "],";
        }
        if ($row['mc_supplier_a'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'鍵盤基座','供應商A'," . $row['mc_supplier_a'] . "],";
        }
        if ($row['mc_supplier_b'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'鍵盤基座','供應商B'," . $row['mc_supplier_b'] . "],";
        }
        if ($row['mc_supplier_c'] != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'鍵盤基座','供應商C'," . $row['mc_supplier_c'] . "],";
        }
    }
	//$_SESSION['year']=$year_now;
	//$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "process_improve") {
    $process = mysql_query("SELECT * FROM process_improvement WHERE `cid`='$cid'", $connect);
    while ($row = mysql_fetch_array($process)) {
		//echo "-".$row['year'].$row['month'];
        //$year = (integer) ($row['month'] / 12) + 1;
        //$month = $row['month'] % 12;
        /*if ($month == 0) {
            $month = 12;
            $year = $year - 1;
        }*/
		$year = $row['year'];
		$month = $row['month'];
        if ($row['process'] == "monitor") {
            $reply = $reply . "[" . $year . "," . $month . ",'螢幕原料檢驗上升1級'],";
        } elseif ($row['process'] == "kernel") {
            $reply = $reply . "[" . $year . "," . $month . ",'kernel原料檢驗上升1級'],";
        } elseif ($row['process'] == "keyboard") {
            $reply = $reply . "[" . $year . "," . $month . ",'鍵盤原料檢驗上升1級'],";
        } elseif ($row['process'] == "check_s") {
            $reply = $reply . "[" . $year . "," . $month . ",'在製品檢驗上升1級'],";
        } elseif ($row['process'] == "check") {
            $reply = $reply . "[" . $year . "," . $month . ",'成品檢驗上升1級'],";
        } elseif ($row['process'] == "cut") {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割上升1級'],";
        }
    }
	//$_SESSION['year']=$year_now;
	//$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "produce_plan") {
    $plan = mysql_query("SELECT * FROM `production_plan` WHERE `cid`='$cid'", $connect);
    while ($row = mysql_fetch_array($plan)) {
        $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",";
        if ((int) $row['monitor']) {
            $reply = $reply . "'執行',";
        } else {
            $reply = $reply . "'不執行',";
        }
        if ((int) $row['kernel']) {
            $reply = $reply . "'執行',";
        } else {
            $reply = $reply . "'不執行',";
        }
        if ((int) $row['keyboard']) {
            $reply = $reply . "'執行',";
        } else {
            $reply = $reply . "'不執行',";
        }
        if ((int) $row['cut'] == 0) {
            $reply = $reply . "'機器等級A',";
        } elseif ((int) $row['cut'] == 1) {
            $reply = $reply . "'機器等級B',";
        } elseif ((int) $row['cut'] == 2) {
            $reply = $reply . "'機器等級C',";
        }
        if ((int) $row['combine1'] == 0) {
            $reply = $reply . "'機器等級A',";
        } elseif ((int) $row['combine1'] == 1) {
            $reply = $reply . "'機器等級B',";
        } elseif ((int) $row['combine1'] == 2) {
            $reply = $reply . "'機器等級C',";
        }
        if ((int) $row['check_s']) {
            $reply = $reply . "'執行',";
        } else {
            $reply = $reply . "'不執行',";
        }
        if ((int) $row['combine2'] == 0) {
            $reply = $reply . "'機器等級A',";
        } elseif ((int) $row['combine2'] == 1) {
            $reply = $reply . "'機器等級B',";
        } elseif ((int) $row['combine2'] == 2) {
            $reply = $reply . "'機器等級C',";
        }
        if ((int) $row['check']) {
            $reply = $reply . "'執行'],";
        } else {
            $reply = $reply . "'不執行'],";
        }
    }
	//$_SESSION['year']=$year_now;
	//$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "product_produce") {
$plan_a = mysql_query("SELECT * FROM `product_a` WHERE `cid`='$cid'", $connect);
while ($row = mysql_fetch_array($plan_a)) {
    $num = (int) $row['ma_supplier_a'] + (int) $row['ma_supplier_b'] + (int) $row['ma_supplier_c'];
    if ($num) {
        $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦'," . $num . "],";
    }
}
$plan_b = mysql_query("SELECT * FROM `product_b` WHERE `cid`='$cid'", $connect);
while ($row = mysql_fetch_array($plan_b)) {
    $num = (int) $row['ma_supplier_a'] + (int) $row['ma_supplier_b'] + (int) $row['ma_supplier_c'];
    if ($num) {
        $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平版電腦'," . $num . "],";
    }

}
//$_SESSION['year']=$year_now;
//$_SESSION['month']=$month_now;
}
echo "[" . $reply . "]";
?>
