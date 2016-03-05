<?php
session_start();
include("./connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
mysql_query("set names 'utf8'");

$C_name = mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account` ORDER BY `CompanyID`");
$cid=array();
$c_length=0;
while ($company = mysql_fetch_array($C_name)) {//每間公司
	//echo $c_length."|".$company['CompanyID']."，";
	array_push($cid,$company['CompanyID']);
	$c_length++;
}
//echo $cid[0]."。".$cid[0]."。".$cid[0]."。";
mysql_select_db("testabc_main");
$cost_array = array("cut_cost" => 0, "cut_num" => 0, "combine1_cost" => 0, "combine1_num" => 0,
    "detect1_cost" => 0, "detect1_num" => 0, "combine2_cost" => 0, "combine2_num" => 0,
    "detect2_cost" => 0, "detect2_num" => 0);
foreach ($cost_array as $name => $value) {
    $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = '$name'");
    $temp = mysql_fetch_array($result);
    $cost_array[$name] = $temp[0];
}

$temp = mysql_query("SELECT MAX(`year`) FROM `state`");
$result_temp = mysql_fetch_array($temp);
$year = $result_temp[0];
$temp = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
$result_temp = mysql_fetch_array($temp);
$month = $result_temp[0] - 1;
if ($month == 0) {
    $month = 12;
    $year-=1;
}
$lastround = $month + ($year - 1) * 12 - 1; //目前進行到第幾個月-1，ex第2年3月，$lastround=15-1=14
//echo $month."|";

//抓參數-----------------------------------------------------------------------------------------------------------------------------------
$machine_type = array("A", "B", "C");
$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'depreciation'");
$depreciation = mysql_fetch_array($result); //機器折舊120月，平均一年折舊10%

$result = mysql_query("SELECT `money3` FROM `correspondence` WHERE `name` = 'current_people'");
$equip_salary = mysql_fetch_array($result); //運籌生產薪水

$total_material = 0;
$materials_arr = array('ma_supplier_a', 'ma_supplier_b', 'ma_supplier_c', 'mb_supplier_a', 'mb_supplier_b', 'mb_supplier_c', 'mc_supplier_a', 'mc_supplier_b', 'mc_supplier_c');
$money_arr = array('money', 'money2', 'money3');
//echo $c_length;
for ($j = 0; $j < $c_length; $j++) {
	//echo $cid[0]."|".$j."|";
	//生產規劃，xx公司x年x月，各原料(monitor、kernal、keyboard)等級x，有使用哪些流程(0沒有、1有，預設為1)，使用機器等級(0、1、2，分別為等級A~C，預設為2)
    $result = mysql_query("SELECT * FROM `product_plan` WHERE `year`=$year AND `month`=$month AND `cid` = '$cid[$j]'");
    $product_plan = mysql_fetch_array($result); 
	
	//產品A=筆電，xx公司x年x月，原料A~C(=monitor、kernal、keyboard)，供應商A~C分別訂購數量
    $result = mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid[$j]'");
    $PA = mysql_fetch_array($result);

	//產品B=平板，xx公司x年x月，原料A、B(=monitor、kernal)，供應商A~C分別訂購數量
    $result = mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid[$j]'");
    $PB = mysql_fetch_array($result);
    $total_material = $PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c'] + $PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c'] + $PA['mb_supplier_a'] + $PA['mb_supplier_b'] + $PA['mb_supplier_c'] + $PB['mb_supplier_a'] + $PB['mb_supplier_b'] + $PB['mb_supplier_c'] + $PA['mc_supplier_a'] + $PA['mc_supplier_b'] + $PA['mc_supplier_c']; //原料總數
    
	$PA_material_total = 0;
    $PB_material_total = 0;
    $PA_direct_labor = 0;
    $PB_direct_labor = 0;
    $PA_detect_labor = 0;
    $PB_detect_labor = 0;
    $PA_machine = 0;
    $PB_machine = 0;
    $PA_depreciation = 0;
    $PB_depreciation = 0;
	
	//上一回合年月   
	$temp_month=$month-1;
    if($temp_month==0){
        $temp_year=$year-1;
        $temp_month=12;
    }
    else
        $temp_year=$year;
		
    if($temp_year==0){
        $notuse_direct_salary = 0;
        $notuse_cut_depreciation = 0;
        $notuse_combine1_depreciation = 0;
        $notuse_detect1_depreciation = 0;
        $notuse_combine2_depreciation = 0;
        $notuse_detect2_depreciation = 0;
    }
    else{
		//取得x年x月，各個公司的生產費用
        $result = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$temp_year AND `month`=$temp_month AND `cid` = '$cid[$j]'");
        $temp = mysql_fetch_array($result);

        //$notuse_direct_salary = $temp['notuse_direct_salary'];
        $notuse_direct_salary = 0;
        $notuse_cut_depreciation = $temp['notuse_cut_depreciation'];
        $notuse_combine1_depreciation = $temp['notuse_combine1_depreciation'];
        $notuse_detect1_depreciation = $temp['notuse_detect1_depreciation'];
        $notuse_combine2_depreciation = $temp['notuse_combine2_depreciation'];
        $notuse_detect2_depreciation = $temp['notuse_detect2_depreciation'];
    }
    //計算直接人工
    $result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `department` = 'equip' AND `cid`='$cid[$j]' AND (`year`-1)*12+`month`<=$lastround;");
    $row = mysql_fetch_array($result);
    $total_direct_labor = $row[0] - $row[1];
    $total_direct_salary = $notuse_direct_salary + $total_direct_labor * $equip_salary[0];
    //切割折舊
    $temp_cut_depreciation=0;
    for($x=0;$x<3;$x++){
		//找出cut的各個type各有幾個
        $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='cut' AND `type`='$machine_type[$x]' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`buy_year`-1)*12+`buy_month` > ($lastround-$depreciation[0]+1) AND (`sell_year`-1)*12+`sell_month` > $lastround");
        $cut_depreciation_temp = mysql_fetch_array($result);
        $result = mysql_query("SELECT `$money_arr[$x]` FROM `correspondence` WHERE `name`='machine_cut'");
        $cut_depreciation_temp2 = mysql_fetch_array($result);
        $temp_cut_depreciation += $cut_depreciation_temp[0] * $cut_depreciation_temp2[0] / $depreciation[0];
    }
    $cut_depreciation = $temp_cut_depreciation + $notuse_cut_depreciation;
    //組裝一折舊
    $temp_combine1_depreciation=0;
    for($x=0;$x<3;$x++){
        $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='combine1' AND `type`='$machine_type[$x]' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`buy_year`-1)*12+`buy_month` > ($lastround-$depreciation[0]+1) AND (`sell_year`-1)*12+`sell_month` > $lastround");
        $combine1_depreciation_temp = mysql_fetch_array($result);
        $result = mysql_query("SELECT `$money_arr[$x]` FROM `correspondence` WHERE `name`='machine_combine1'");
        $combine1_depreciation_temp2 = mysql_fetch_array($result);
        $temp_combine1_depreciation += $combine1_depreciation_temp[0] * $combine1_depreciation_temp2[0] / $depreciation[0];
    }
    $combine1_depreciation = $temp_combine1_depreciation + $notuse_combine1_depreciation;
    //合成檢測折舊
    $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='detect' AND `type`='A' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`buy_year`-1)*12+`buy_month` > ($lastround-$depreciation[0]+1) AND (`sell_year`-1)*12+`sell_month` > $lastround");
    $detect1_depreciation_temp = mysql_fetch_array($result);
    $result = mysql_query("SELECT `money` FROM `correspondence` WHERE `name`='machine_detect'");
    $detect1_depreciation_temp2 = mysql_fetch_array($result);
    $detect1_depreciation = $notuse_detect1_depreciation + $detect1_depreciation_temp[0] * $detect1_depreciation_temp2[0] / $depreciation[0];
    //組裝二折舊
    $temp_combine2_depreciation=0;
    for($x=0;$x<3;$x++){
    $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='combine2' AND `type`='$machine_type[$x]' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`buy_year`-1)*12+`buy_month` > ($lastround-$depreciation[0]+1) AND (`sell_year`-1)*12+`sell_month` > $lastround");
    $combine2_depreciation_temp = mysql_fetch_array($result);
    $result = mysql_query("SELECT `$money_arr[$x]` FROM `correspondence` WHERE `name`='machine_combine2'");
    $combine2_depreciation_temp2 = mysql_fetch_array($result);
    $temp_combine2_depreciation += $combine2_depreciation_temp[0] * $combine2_depreciation_temp2[0] / $depreciation[0];
    }
    $combine2_depreciation = $temp_combine2_depreciation + $notuse_combine2_depreciation;
    //精密檢測折舊
    $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='detect' AND `type`='B' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`buy_year`-1)*12+`buy_month` > ($lastround-$depreciation[0]+1) AND (`sell_year`-1)*12+`sell_month` > $lastround");
    $detect2_depreciation_temp = mysql_fetch_array($result);
    $result = mysql_query("SELECT `money2` FROM `correspondence` WHERE `name`='machine_detect'");
    $detect2_depreciation_temp2 = mysql_fetch_array($result);
    $detect2_depreciation = $notuse_detect2_depreciation + $detect2_depreciation_temp[0] * $detect2_depreciation_temp2[0] / $depreciation[0];

    if ($total_material != 0) {
        //計算原料的成本
        for ($i = 0; $i < 9; $i++) {
            $materials_name = $materials_arr[$i];
            //讀取歷史使用量$x(不包含本次)
            $result = mysql_query("SELECT SUM(`$materials_name`) FROM `product_a` WHERE (`year`<$year OR (`year`=$year AND `month`<$month)) AND `cid`='$cid[$j]'");
            $PA_old = mysql_fetch_array($result);
            if ($i < 6) {//本次使用量$z(PA_XXXX與PB_XXXX的部分
                $result = mysql_query("SELECT SUM(`$materials_name`) FROM `product_b` WHERE (`year`<$year OR (`year`=$year AND `month`<$month)) AND `cid`='$cid[$j]'");
                $PB_old = mysql_fetch_array($result);
                $x = $PB_old[0] + $PA_old[0];
                $z = $PA[$materials_name] + $PB[$materials_name];
            } else {
                $x = $PA_old[0];
                $z = $PA[$materials_name];
            }
            $purchase_month = 1;
            $material_total = 0;
            while ($x + $z > 0) {//如果使用量沒有扣完則繼續計算
                $purchase_year = (integer) ($purchase_month / 12) + 1;
                $purchase_month1 = $purchase_month % 12;
				if($purchase_month1==0){
					$purchase_month1=12;
					$purchase_year-=1;
				}
                //讀取第$purchase_month月的購買數量$y
                $result = mysql_query("SELECT `$materials_name` FROM `purchase_materials` WHERE `year`=$purchase_year AND `month`=$purchase_month1 AND `cid`='$cid[$j]'");
                $purchase_materials = mysql_fetch_array($result); //上面有bug
                $y = $purchase_materials[0];
			//echo "$cid[$j];$i;$x,$y,$z ;$purchase_month<br/>";
                $x-=$y; //原料使用量扣掉購買量
                if ($x <= 0) {//如果使用量成為負值，進入本月的計算
                    $result = mysql_query("SELECT `$materials_name` FROM `purchase_materials_price` WHERE `year`=$purchase_year AND `month`=$purchase_month1 AND `cid`='$cid[$j]'");
					$purchase_price1 = mysql_fetch_array($result);
                    $purchase_price = $purchase_price1[0]; //讀取purchase_month的購買價格
                    if ($x + $z > 0) {//本次使用不只一期的原料
                        $temp = -$x;
                        $z+=$x;
                        $x = 0;
                    } else {//這期的原料足夠使用
                        $temp = $z;
                    }
                    $material_total+=$purchase_price * $temp; //計算購買的總價
                }
                $purchase_month+=1;
            }
            //計算產品A B 原料分配的比例
            if ($i < 6 && ($PA[$materials_name] + $PB[$materials_name]) > 0) {
                $PA_material_total+=$material_total * $PA[$materials_name] / ($PA[$materials_name] + $PB[$materials_name]);
                $PB_material_total+=$material_total * $PB[$materials_name] / ($PA[$materials_name] + $PB[$materials_name]);
            }
            else
                $PA_material_total+=$material_total;
        }


        $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'detect_cost' ");
        $detect_cost = mysql_fetch_array($result); //檢料的單位人力成本
        //計算檢料的成本
        if ($product_plan['monitor'] == 1) {
            $PA_detect_labor+=$detect_cost[0] * ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']);
            $PB_detect_labor+=$detect_cost[0] * ($PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']);
        }
        if ($product_plan['kernel'] == 1) {
            $PA_detect_labor+=$detect_cost[0] * ($PA['mb_supplier_a'] + $PA['mb_supplier_b'] + $PA['mb_supplier_c']);
            $PB_detect_labor+=$detect_cost[0] * ($PB['mb_supplier_a'] + $PB['mb_supplier_b'] + $PB['mb_supplier_c']);
        }
        if ($product_plan['keyboard'] == 1) {
            $PA_detect_labor+=$detect_cost[0] * ($PA['mc_supplier_a'] + $PA['mc_supplier_b'] + $PA['mc_supplier_c']);
        }

        //計算切割固定成本。
        $cut_type = $product_plan['cut'];
        $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='cut' AND `type`='$machine_type[$cut_type]' AND `buy_year`<=$year AND `buy_month`<=$month AND (`sell_year`-1)*12+`sell_month`=99");
        $cut_machine = mysql_fetch_array($result);
        $cut_cost = $cost_array['cut_cost']; //每個月的成本
        $total_A_cut = 2 * ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']) + 4 * ($PA['mb_supplier_a'] + $PA['mb_supplier_b'] + $PA['mb_supplier_c']) + ($PA['mc_supplier_a'] + $PA['mc_supplier_b'] + $PA['mc_supplier_c']);
        $total_B_cut = 2 * ($PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']) + 4 * ($PB['mb_supplier_a'] + $PB['mb_supplier_b'] + $PB['mb_supplier_c']);
        //計算產品A的切割固定分攤成本。
        $PA_cut = $cut_machine[0] * $cut_cost * $total_A_cut / ($total_A_cut + $total_B_cut);
        //計算產品B的切割固定分攤成本。
        $PB_cut = $cut_machine[0] * $cut_cost * $total_B_cut / ($total_A_cut + $total_B_cut);
        //計算產品A與B的切割分攤折舊
        $PA_cut_depreciation = $cut_depreciation * $total_A_cut / ($total_A_cut + $total_B_cut);
        $PB_cut_depreciation = $cut_depreciation * $total_B_cut / ($total_A_cut + $total_B_cut);
        
        //計算組裝1成本
        $combine1_type = $product_plan['combine1'];
        $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='combine1' AND `type`='$machine_type[$combine1_type]' AND `buy_year`<=$year AND `buy_month`<=$month AND (`sell_year`-1)*12+`sell_month`=99");
        $combine1_machine = mysql_fetch_array($result);
        $combine1_cost = $cost_array['combine1_cost']; //合成1機器每個月的成本
        $total_A_combine1 = 0.1 * ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']) + 0.15 * ($PA['mb_supplier_a'] + $PA['mb_supplier_b'] + $PA['mb_supplier_c']);
        $total_B_combine1 = 0.1 * ($PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']) + 0.15 * ($PB['mb_supplier_a'] + $PB['mb_supplier_b'] + $PB['mb_supplier_c']);
        //計算產品A的組裝1分攤成本
        $PA_combine1 = $combine1_machine[0] * $combine1_cost * $total_A_combine1 / ($total_A_combine1 + $total_B_combine1);
        //計算產品B的組裝1分攤成本
        $PB_combine1 = $combine1_machine[0] * $combine1_cost * $total_B_combine1 / ($total_A_combine1 + $total_B_combine1);
        //計算產品A與B的組裝1分攤折舊
        $PA_combine1_depreciation = $combine1_depreciation * $total_A_combine1 / ($total_A_combine1 + $total_B_combine1);
        $PB_combine1_depreciation = $combine1_depreciation * $total_B_combine1 / ($total_A_combine1 + $total_B_combine1);
        
        if (($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']) > 0) {
            if ($product_plan['check_s'] == 1) {
                //計算產品A的合成檢測成本
                $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='detect' AND `type`='A' AND `buy_year`<=$year AND `buy_month`<=$month AND (`sell_year`-1)*12+`sell_month`=99");
                $detect1_machine = mysql_fetch_array($result);
                $detect1_cost = $cost_array['detect1_cost']; //每個月單位合成檢測機器的成本
                $PA_detect1 = $detect1_machine[0] * $detect1_cost;
            }
            //計算產品A的合成檢測折舊
            $PA_detect1_depreciation = $detect1_depreciation;
            
            //計算產品A的組裝二成本
            $combine2_type = $product_plan['combine2'];
            $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='combine2' AND `type`='$machine_type[$combine2_type]' AND `buy_year`<=$year AND `buy_month`<=$month AND (`sell_year`-1)*12+`sell_month`=99");
            $combine2_machine = mysql_fetch_array($result);
            $combine2_cost = $cost_array['combine2_cost']; //組裝2每個月的成本
            $PA_combine2 = $combine2_machine[0] * $combine2_cost;
            //計算產品A的組裝二折舊
            $PA_combine2_depreciation = $combine2_depreciation;
            $notuse_combine2_depreciation = 0;
            $notuse_detect1_depreciation = 0;
        }
        else{//若未生產A產品，將折舊累計
            $notuse_combine2_depreciation = $combine2_depreciation;
            $notuse_detect1_depreciation = $detect1_depreciation;

        }

        $PA_detect2_time = 2 * ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']) + 2 * ($PA['mb_supplier_a'] + $PA['mb_supplier_b'] + $PA['mb_supplier_c']) + 1 * ($PA['mc_supplier_a'] + $PA['mc_supplier_b'] + $PA['mc_supplier_c']);
        $PB_detect2_time = 2 * ($PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']) + 2 * ($PB['mb_supplier_a'] + $PB['mb_supplier_b'] + $PB['mb_supplier_c']);
        //計算精密檢測折舊分攤
        $PA_detect2_depreciation = $detect2_depreciation * $PA_detect2_time / ($PA_detect2_time + $PB_detect2_time);
        $PB_detect2_depreciation = $detect2_depreciation * $PB_detect2_time / ($PA_detect2_time + $PB_detect2_time);
        if ($product_plan['check_s'] == 1) {
            //計算精密檢測分攤成本
            $result = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid[$j]' AND `function`='detect' AND `type`='B' AND (`buy_year`-1)*12+`buy_month` <= $lastround AND (`sell_year`-1)*12+`sell_month` > $lastround");
            $detect2_machine = mysql_fetch_array($result);
            $detect2_cost = $cost_array['detect2_cost']; ///每個月單位精密檢測機器的成本
            //計算精密檢測產品A的分攤成本
            $PA_detect2 = $detect2_machine[0] * $detect2_cost * $PA_detect2_time / ($PA_detect2_time + $PB_detect2_time);
            //計算精密檢測產品B的分攤成本
            $PB_detect2 = $detect2_machine[0] * $detect2_cost * $PB_detect2_time / ($PA_detect2_time + $PB_detect2_time);
        }
        //$PA_total=$PA_material_total+$PA_detect_labor+$PA_cut+$PA_combine1+$PA_detect1+$PA_combine2+$PA_detect2;
        //$PB_total=$PB_material_total+$PB_detect_labor+$PB_cut+$PB_combine1+$PB_detect2;
        //產品A分攤的折舊
        $PA_depreciation = $PA_cut_depreciation + $PA_combine1_depreciation + $PA_detect1_depreciation + $PA_combine2_depreciation + $PA_detect2_depreciation;
        //產品B分攤的折舊
        $PB_depreciation = $PB_cut_depreciation + $PB_combine1_depreciation + $PB_detect2_depreciation;
        //產品A分攤的成本
        $PA_machine = $PA_cut + $PA_combine1 + $PA_detect1 + $PA_combine2 + $PA_detect2;
        //產品B分攤的成本
        $PB_machine = $PB_cut + $PB_combine1 + $PB_detect2;
        //產品A分攤的直接人工
        $PA_direct_labor = $total_direct_salary * ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c']) / ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c'] + $PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']);
        //產品B分攤的直接人工
        $PB_direct_labor = $total_direct_salary * ($PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']) / ($PA['ma_supplier_a'] + $PA['ma_supplier_b'] + $PA['ma_supplier_c'] + $PB['ma_supplier_a'] + $PB['ma_supplier_b'] + $PB['ma_supplier_c']);

        $notuse_direct_salary = 0;
        $notuse_cut_depreciation = 0;
        $notuse_combine1_depreciation = 0;
        $notuse_detect2_depreciation = 0;
    }
    else{//若未生產任何產品，將折舊與直接人工累積
         //$notuse_direct_salary = $total_direct_salary;
        $notuse_direct_salary = 0;
        $notuse_cut_depreciation = $cut_depreciation;
        $notuse_combine1_depreciation = $combine1_depreciation;
        $notuse_detect1_depreciation = $detect1_depreciation;
        $notuse_combine2_depreciation = $combine2_depreciation;
        $notuse_detect2_depreciation = $detect2_depreciation;
    }
    //計算銷貨成本
    $PA_overhead = $PA_detect_labor + $PA_machine + $PA_depreciation;
    $PB_overhead = $PB_detect_labor + $PB_machine + $PB_depreciation;
    $PA_total = $PA_material_total + $PA_direct_labor + $PA_overhead;
    $PB_total = $PB_material_total + $PB_direct_labor + $PB_overhead;
    if ($month == 1) {
        $month1 = 12;
        $year1 = $year - 1;
    } else {
        $month1 = $month - 1;
        $year1 = $year;
    }
    $A_COGS = 0;
    $B_COGS = 0;
    $A_inventory_before = 0;
    $B_inventory_before = 0;
    if ($year1 > 0) {
        $result = mysql_query("SELECT `product_A_COGS`,`product_B_COGS` FROM `production_cost` WHERE `cid`='$cid[$j]'AND`year`= $year AND `month`=$month");
        $temp = mysql_fetch_array($result);
        $A_COGS = $temp[0];
        $B_COGS = $temp[1];
        $result = mysql_query("SELECT `product_A_inventory` , `product_B_inventory` FROM `production_cost` WHERE `cid`='$cid[$j]'AND`year`= $year1 AND `month`=$month1");
        $temp = mysql_fetch_array($result);
        $A_inventory_before = $temp[0];
        $B_inventory_before = $temp[1];
    }
    $PA_inventory = $A_inventory_before + $PA_total - $A_COGS;
    $PB_inventory = $B_inventory_before + $PB_total - $B_COGS;
    echo $cid[$j]."|".$year."|".$month. "|" . $PA_inventory . "," .$A_inventory_before . "," . $PA_total . "," . $A_COGS . ",".$PA_material_total.",".$PB_material_total.",".$PA_direct_labor.",".$PB_direct_labor.",".$PA_overhead.",".$PB_overhead.",".$PA_depreciation.",".$PB_depreciation."<br>";
    mysql_query("UPDATE `production_cost` SET `product_A_material_total`=$PA_material_total,`product_B_material_total`=$PB_material_total,
                `product_A_direct_labor`=$PA_direct_labor,`product_B_direct_labor`=$PB_direct_labor,`product_A_overhead`=$PA_overhead,
                `product_B_overhead`=$PB_overhead,`product_A_inventory`=$PA_inventory,`product_B_inventory`=$PB_inventory ,
				`product_A_detect_labor`=$PA_detect_labor,`product_B_detect_labor`=$PB_detect_labor,
				`product_A_depreciation`=$PA_depreciation,`product_B_depreciation`=$PB_depreciation,
				`notuse_direct_salary`=$notuse_direct_salary,
				`notuse_cut_depreciation`=$notuse_cut_depreciation,`notuse_combine1_depreciation`=$notuse_combine1_depreciation ,
                `notuse_detect1_depreciation`=$notuse_detect1_depreciation,`notuse_combine2_depreciation`=$notuse_combine2_depreciation ,
                `notuse_detect2_depreciation`=$notuse_detect2_depreciation WHERE `cid`='$cid[$j]' AND `year`=$year AND `month`=$month");

        /*echo "UPDATE  `production_cost` SET `product_A_material_total`=$PA_material_total,`product_B_material_total`=$PB_material_total,
                `product_A_direct_labor`=$PA_direct_labor,`product_B_direct_labor`=$PB_direct_labor,`product_A_overhead`=$PA_overhead,
                `product_B_overhead`=$PB_overhead,`product_A_inventory`=$PA_inventory,`product_B_inventory`=$PB_inventory ,`product_A_detect_labor`=$PA_detect_labor,
                `product_B_detect_labor`=$PB_detect_labor,`product_A_depreciation`=$PA_depreciation,`product_B_depreciation`=$PB_depreciation,
                `notuse_direct_salary`=$notuse_direct_salary,`notuse_cut_depreciation`=$notuse_cut_depreciation,`notuse_combine1_depreciation`=$notuse_combine1_depreciation ,
                `notuse_detect1_depreciation`=$notuse_detect1_depreciation,`notuse_combine2_depreciation`=$notuse_combine2_depreciation ,
                `notuse_detect2_depreciation`=$notuse_detect2_depreciation WHERE `cid`='$cid[$j]' AND `year`=$year AND `month`=$month";*/
}//end for
?>
