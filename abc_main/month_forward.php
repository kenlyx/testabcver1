<?php

include("./connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");//讀ABC所有的公司ID
mysql_query("set names 'utf8'");
$C_name = mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account`");
mysql_select_db("testabc_main");

$month = 0;
$year = 0;
$temp = mysql_query("SELECT MAX(`year`) FROM `state`");
$result = mysql_fetch_array($temp);
if (!$result[0])
    $year = 1;
else
    $year = $result[0];
$temp = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year");
$result = mysql_fetch_array($temp);
if (!$result[0])
    $month = 1;
else
    $month = $result[0] + 1;
if ($month / 12 > 1) {
    $year = $year + 1;
    $month-=12;
}
echo $year . "/" . $month;

//此處將新增資料表欄位
$datatable = array("0" => "ad_a", "1" => "ad_b", "2" => "donate", "3" => "materials_cost", "4" => "product_a",
    "5" => "product_b", "6" => "product_plan", "7" => "purchase_materials", "8" => "share", "9" => "state",
    "10" => "current_people", "11" => "training", "12" => "fund_raising", "13" => "contrast" , "14" => "purchase_materials_price",
    "15"=>"production_cost", "16" => "dupont", "17" => "score" , "18" => "budget");
//直接將資料表名稱放進datatable裡即可，除非欄位不同或其他特殊需求
$c_length = 0;
$happening = 0;
while ($company = mysql_fetch_array($C_name)) {//每間公司
    $cid[$c_length] = $company['CompanyID'];
    $c_length++;
}
$length = count($datatable);
for ($i = 0; $i < $length; $i++) {//*
    for ($j = 0; $j < $c_length; $j++) {
        if ($i <= 2 || $i == 8)
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0)");
        else if ($i == 3 || $i == 4 || $i == 7  || $i == 14 )
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0,0,0,0)");
        else if ($i == 5)
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0)");
        else if ($i == 6){//insert into `product_plan`
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,1,1,1,2,2,1,2,1)");
			if($year!=1 || $month!=1){//非第一回合-->抽上一回合的值進行update
				if($month == 1){
					$temp=mysql_query("Select * From `product_plan` where `cid`='$cid[$j]' and `year`=$year-1 and `month`=12");
				}
				else{
					$temp=mysql_query("Select * From `product_plan` where `cid`='$cid[$j]' and `year`=$year and `month`=$month-1");
				}
				$array = mysql_fetch_array($temp);
				$cut = (int)$array['cut'];
				$combine1 = (int)$array['combine1'];
				$combine2 = (int)$array['combine2'];
				mysql_query("UPDATE `product_plan` SET `cut`=$cut ,`combine1`=$combine1 ,`combine2`=$combine2 where `cid`='$cid[$j]' and `year`=$year and `month`=$month");
			}
		}
        else if ($i == 9)
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0,0,0,0,0,0,0,0)");
        else if ($i == 10) {
            if ($month == 1 && $year == 1) {
                mysql_query("INSERT INTO `current_people`  VALUES(1,1,'$cid[$j]','finance',0,0,0,0)");
                mysql_query("INSERT INTO `current_people`  VALUES(1,1,'$cid[$j]','equip',0,0,0,0)");
                mysql_query("INSERT INTO `current_people`  VALUES(1,1,'$cid[$j]','sale',0,0,0,0)");
                mysql_query("INSERT INTO `current_people`  VALUES(1,1,'$cid[$j]','human',0,0,0,0)");
				mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','research',5,0,50,50)");
                mysql_query("INSERT INTO `current_people`  VALUES(1,1,'$cid[$j]','research',0,0,50,50)");
                mysql_query("INSERT INTO `cash`  VALUES(1,1,'$cid[$j]',20000000,0,0)");
                mysql_query("INSERT INTO `stock`  VALUES(1,1,'$cid[$j]',10,2000000,0,0,0,1)");
            }else{
            mysql_query("INSERT INTO `current_people`  VALUES($year,$month,'$cid[$j]','finance',0,0,0,0)");
            mysql_query("INSERT INTO `current_people`  VALUES($year,$month,'$cid[$j]','equip',0,0,0,0)");
            mysql_query("INSERT INTO `current_people`  VALUES($year,$month,'$cid[$j]','sale',0,0,0,0)");
            mysql_query("INSERT INTO `current_people`  VALUES($year,$month,'$cid[$j]','human',0,0,0,0)");
            mysql_query("INSERT INTO `current_people`  VALUES($year,$month,'$cid[$j]','research',0,0,0,0)");
			}
        } else if ($i == 11 || $i==13) {
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0)");
        } elseif ($i == 12 ) {
            mysql_query("INSERT INTO `$datatable[$i]` VALUES($year,$month,'$cid[$j]',0,0,0,0,0,0,0,0,0,0,0,0,0,0)");
        } elseif ($i == 15 ){
            mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)");
            //echo "INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0,0,0,0,0,0)";
		} elseif ($i ==16 )	{
			mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0,0,0,0,0,0,0,0,0,0,0,0)");
        } elseif ($i ==17 )	{
			mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,$month,0,0,0)");
        } elseif ($i ==18 ) {
			if($month==1){
				mysql_query("INSERT INTO `$datatable[$i]` VALUES('$cid[$j]',$year,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)");
			}
		}
    }$round=$month+($year-1)*12;
}
//$function = array("0" => "cut", "1" => "combine1", "2" => "combine2");
for ($j = 0; $j < $c_length; $j++) {
    if ($month == 1 && $year == 1) {
        $result = mysql_query("SELECT MAX(`index`) FROM `machine`");
        $next_index_arr = mysql_fetch_array($result);
        if ($next_index_arr[0] == NULL)
            $next_index = 0;
        /*for ($i = 0; $i < 3; $i++) {
            for ($k = 0; $k < 5; $k++) {
                $next_index+=1;
                mysql_query("INSERT INTO `machine` VALUES($next_index,'$cid[$j]',0,999,'$function[$i]','C')");
            }
        }
        for ($k = 0; $k < 5; $k++) {
            $next_index+=1;
            mysql_query("INSERT INTO `machine` VALUES($next_index,'$cid[$j]',0,999,'detect','A')");
        }
        for ($k = 0; $k < 5; $k++) {
            $next_index+=1;
            mysql_query("INSERT INTO `machine` VALUES($next_index,'$cid[$j]',0,999,'detect','B')");
        }*/
        //到此為止，新增完所有最低等級的機具；
//            mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','finance',10,0,50,50)",$connect);
//            mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','equip',10,0,50,50)",$connect);
//            mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','sale',10,0,50,50)",$connect);
//            mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','human',10,0,50,50)",$connect);
//            mysql_query("INSERT INTO `current_people`  VALUES(1,0,'$cid[$j]','research',10,0,50,50)",$connect);
        mysql_query("INSERT INTO `supplier_satisfaction`  VALUES('{$cid[$j]}',50,50,50)");
        mysql_query("INSERT INTO `investor_satisfaction`  VALUES('{$cid[$j]}',0)");
        mysql_query("INSERT INTO `product_famous`  VALUES('A',30)");
        mysql_query("INSERT INTO `product_famous`  VALUES('B',30)");
        mysql_query("UPDATE `customer_state` SET `valid`=0,`initial`=0;") or die(mysql_error());
    }
}
if ($month == 1 && $year == 1)
    for ($i = 1; $i < 13; $i++)
        mysql_query("INSERT INTO `situation_overview` VALUES($i,0);");
if ($month == 1) {
    $arr = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0);
    $season_situat = array(12, 4, 1, 2, 3, 11);
    $month_situat = array(5, 6, 7, 10);
    $season_lock = 0;
    $half_year_lock = 0;
    for ($i = 1; $i <= 12; $i++) {
        mysql_query("UPDATE `situation_overview` SET `situation`=0;");
    }
    for ($i = 1; $i <= 12; $i++) {
        if ($i % 3 == 1)
            $season_lock = 0;
        if ($i % 6 == 1)
            $half_year_lock = 0;
        if ($i == 3)
            $arr[$i] = 9;
        else {
            $random_number = rand(1, 12);
            if (($random_number % 4) == 3 && $season_lock == 0) {
                $random_situat = rand(0, 5);
                $arr[$i] = $season_situat[$random_situat];
                $season_lock = 1;
            } else if (($random_number % 6) == 5 && $half_year_lock == 0) {
                $arr[$i] = 8;
                $half_year_lock = 1;
            } else {
                $random_situat = rand(0, 3);
				while(($i<2)&&($random_situat==7))
					$random_situat = rand(0, 3);
                $arr[$i] = $month_situat[$random_situat];
            }
        }
    }
    for ($i = 1; $i <= 12; $i++)
        mysql_query("UPDATE `situation_overview` SET `situation`={$arr[$i]} WHERE `month`=$i;");
}

$temp_result = mysql_query("SELECT * FROM `situation` WHERE `happening`>0;");
while ($result_temp = mysql_fetch_array($temp_result)) {
    if ($result_temp[0] == "")
        break;
    else {
        $happening = $result_temp['happening'] - 1;
        mysql_query("UPDATE `situation` SET `happening`=$happening WHERE `index`={$result_temp['index']}");
    }
}

//process_improvement 沒CompanyName?

/* 其它報表以外的資料表：
  correspondence
  current_people
  customer_state
  journal
  machine
  parameter_description

  finance 這些是預算用的，是換年時需要嗎?
  human_resources
  manager (只有年月兩欄?)
  marketing
  production_planning
  resource
  value_network */
?>
