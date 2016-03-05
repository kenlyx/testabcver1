<?php

//每月計算KPI
session_start();
include("./connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!"); //讀ABC所有的公司名稱
mysql_query("set names 'utf8'");
$C_name = mysql_query("SELECT DISTINCT(`CompanyID`) FROM account;");
mysql_select_db("testabc_main");
$c_length = 0;
while ($company = mysql_fetch_array($C_name)) {//每間公司
    $CompanyID[$c_length] = $company['CompanyID'];
    $c_length++;
}
$temp = mysql_query("SELECT MAX(`year`) FROM `state`");
$result_temp = mysql_fetch_array($temp);
$year = $result_temp[0];
$temp = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
$result_temp = mysql_fetch_array($temp);
$month = $result_temp[0] - 1;
//echo $month;
if ($month == 0) {
    $month = 12;
    $year-=1;
}
//$month = 1;
//$year = 1;
for ($j = 0; $j < $c_length; $j++) {
    $company = $CompanyID[$j];
    //企業評價
    //營收成長率
    $p_revenue = 0;
    $n_revenue = 0;
    $revenue = 0;
    if ($year == 1) {//讀營收的預期值(第一年銷貨收入參考值)
        $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'target_revenue'");
        $temp = mysql_fetch_array($result);
        $p_revenue = $temp[0]*1;
    } else {
        $p_f_month = ($year - 2) * 12 + 1;
        $p_l_month = ($year - 1) * 12;
        $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` >= $p_f_month AND `month` <= $p_l_month");
        $temp = mysql_fetch_array($result);
        $p_revenue = $temp[0];
    }
    $f_month = ($year - 1) * 12 + 1;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $n_revenue = $temp[0];
//    echo "$n_revenue / $p_revenue";
    if ($p_revenue != 0)
        $revenue = ($n_revenue / $p_revenue - 1) * 100;
    else
        $revenue=0;
    mysql_query("UPDATE `kpi_info` SET `企業評價：營收成長率`=$revenue WHERE `session`=$n_month AND `account`='$company'"); //寫入 $revenue;
    //營業淨利率
    $f_month = ($year - 1) * 12 + 1;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_costs` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $cost = $temp[0];
    $gross_profit = $revenue + $cost;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $expenses = $temp[0];
    $net_income = $gross_profit + $expenses;
    if ($gross_profit != 0)
        $net_profit_margin = ($net_income / $gross_profit) * 100;
    else
        $net_profit_margin=0;
    mysql_query("UPDATE `kpi_info` SET `企業評價：營業淨利率`=$net_profit_margin WHERE `session`=$n_month AND `account`='$company'"); //寫入 $net_profit_margin;
    //營業比率
    $f_month = ($year - 1) * 12 + 1;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_costs` WHERE `cid`='$company' AND `month`>= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $cost = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $expenses = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    if ($revenue != 0)
        $sales_ratio = -($cost + $expenses) / $revenue *100;
    else
        $sales_ratio=0;
    mysql_query("UPDATE `kpi_info` SET `企業評價：營業比率`=$sales_ratio WHERE `session`=$n_month AND `account`='$company'"); //寫入 $sales_ratio;
    //負債佔資產比率
    $f_month = ($year - 1) * 12 + 1;
    $result = mysql_query("SELECT SUM(`price`) FROM `long-term_liabilities` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $long_term = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `current_liabilities` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $current = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `fixed_assets` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $fixed_assets = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `current_assets` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $current_assets = $temp[0];
    if ($fixed_assets + $current_assets != 0)
        $debt_ratio = ($long_term + $current) / ($fixed_assets + $current_assets) * 100;
    else
        $debt_ratio=0;
    mysql_query("UPDATE `kpi_info` SET `企業評價：負債佔資產比率`=$debt_ratio WHERE `session`=$n_month AND `account`='$company'"); //寫入$debt_ratio
    //價值作業
    //存貨週轉率
    $f_month = ($year - 1) * 12;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_costs` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $cost = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `current_assets` WHERE `cid`='$company' AND (`month` = $f_month OR `month` = $n_month) AND `name` = 114");
    $temp = mysql_fetch_array($result);
    $avg_invetory = $temp[0] / 2;
    if ($avg_invetory == 0)
        $inventory_turnover_rate = 0;
    else
        $inventory_turnover_rate=$cost / $avg_invetory;
    mysql_query("UPDATE `kpi_info` SET `價值作業：存貨週轉率`=$inventory_turnover_rate WHERE `session`=$n_month AND `account`='$company'"); //寫入 $inventory_turnover_rate;
    //總資產週轉率
    $f_month = ($year - 1) * 12;
    $n_month = ($year - 1) * 12 + $month;
  $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `fixed_assets` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $fixed_assets = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `current_assets` WHERE `cid`='$company' AND `month` = $n_month");
    $temp = mysql_fetch_array($result);
    $current_assets = $temp[0];
    $avg_invetory = $temp[0];
    if ($fixed_assets + $current_assets == 0)
        $total_turnover = 0;
    else
        $total_turnover=$revenue / ($fixed_assets + $current_assets);
    mysql_query("UPDATE `kpi_info` SET `價值作業：總資產週轉率`=$total_turnover WHERE `session`=$n_month AND `account`='$company'"); //寫入 $total_turnover;
    //年產量A
    //$expected_annual_A=$target[4];//讀預期生產量
    $result = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$company' AND `product`='A' AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $current_production_A = $temp[0];
//    if($expected_annual_A==0)
//        $annual_production_A=0;
//    else
    $annual_production_A = $current_production_A;
    mysql_query("UPDATE `kpi_info` SET `價值作業：年產量A`=$annual_production_A WHERE `session`=$n_month AND `account`='$company'"); //寫入$annual_production_A
    //年產量B
//    $expected_annual_B=$target[5];//讀預期生產量
    $result = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$company' AND `product`='B' AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $current_production_B = $temp[0];
//    if($expected_annual_B==0)
//        $annual_production_B=0;
//    else
    $annual_production_B = $current_production_B; ///$expected_annual_B*100;
    mysql_query("UPDATE `kpi_info` SET `價值作業：年產量B`=$annual_production_B WHERE `session`=$n_month AND `account`='$company'"); //寫入$annual_production_B
    //市場聚焦
    //市占率A;
    $quantity = 0;
    $c_quantity = 0;
    $market_share_A = 0;
    $result = mysql_query("SELECT `order_no`,`quantity`,`cid` FROM `order_accept` WHERE ((`year`=$year AND `month` <= $month) OR `year`<$year) AND `accept` = 1 ");
    while ($temp = mysql_fetch_array($result)) {
        $order = explode("_", $temp[0]);
        $type = $order[1];
        if ($type === "A") {
            $quantity+=$temp[1];
            if ($temp[2] === $company) {
                $c_quantity+=$temp[1];
            }
        }
    }
    if ($quantity != 0) {
        $market_share_A = $c_quantity / $quantity * 100;
    }
    mysql_query("UPDATE `kpi_info` SET `市場聚焦：市占率A`=$market_share_A WHERE `session`=$n_month AND `account`='$company'"); //寫入 $market_share_A;
    //市占率B;
    $quantity = 0;
    $c_quantity = 0;
    $market_share_B = 0;
    $result = mysql_query("SELECT `order_no`,`quantity`,`cid` FROM `order_accept` WHERE ((`year`=$year AND `month` <= $month) OR `year`<$year) AND `accept` = 1 ");
    while ($temp = mysql_fetch_array($result)) {
        $order = explode("_", $temp[0]);
        $type = $order[1];
        if ($type === "B") {
            $quantity+=$temp[1];
            if ($temp[2] === $company) {
                $c_quantity+=$temp[1];
            }
        }
    }
    if ($quantity != 0) {
        $market_share_B = $c_quantity / $quantity * 100;
    }
    mysql_query("UPDATE `kpi_info` SET `市場聚焦：市占率B`=$market_share_B WHERE `session`=$n_month AND `account`='$company'"); //寫入 $market_share_B;
    //價格競爭力A
    $quantity = 0;
    $c_quantity = 0;
    $price = 0;
    $c_price = 0;
    $price_A = 0;
    $result = mysql_query("SELECT `order_no`,`quantity`,`cid`,`price` FROM `order_accept` WHERE ((`year`=$year AND `month` <= $month) OR `year`<$year) AND `accept` = 1 ");
    while ($temp = mysql_fetch_array($result)) {
        $order = explode("_", $temp[0]);
        $type = $order[1];
        if ($type === "A") {
            $quantity+=$temp[1];
            $price+=$temp[1] * $temp[3];
            if ($temp[2] === $company) {
                $c_quantity+=$temp[1];
                $c_price+=$temp[1] * $temp[3];
            }
        }
    }
    if ($quantity != 0 && $c_quantity != 0) {
        $price_A = -(($c_price / $c_quantity) - ($price / $quantity)) / ($price / $quantity) * 100;
    }
    mysql_query("UPDATE `kpi_info` SET `市場聚焦：價格競爭力A`=$price_A WHERE `session`=$n_month AND `account`='$company'"); //寫入 $price_A;
    //價格競爭力B
    $quantity = 0;
    $c_quantity = 0;
    $price = 0;
    $c_price = 0;
    $price_B = 0;
    $result = mysql_query("SELECT `order_no`,`quantity`,`cid`,`price` FROM `order_accept` WHERE ((`year`=$year AND `month` <= $month) OR `year`<$year) AND `accept` = 1 ");
    while ($temp = mysql_fetch_array($result)) {
        $order = explode("_", $temp[0]);
        $type = $order[1];
        if ($type === "B") {
            $quantity+=$temp[1];
            $price+=$temp[1] * $temp[3];
            if ($temp[2] === $company) {
                $c_quantity+=$temp[1];
                $c_price+=$temp[1] * $temp[3];
            }
        }
    }
    if ($quantity != 0 && $c_quantity != 0) {
        $price_B = -(($c_price / $c_quantity) - ($price / $quantity)) / ($price / $quantity) * 100;
    }
    mysql_query("UPDATE `kpi_info` SET `市場聚焦：價格競爭力B`=$price_B WHERE `session`=$n_month AND `account`='$company'"); //寫入 $price_B;
    //價值主張
    //顧客平均滿意度
    //$expected_customer_satisfaction=$target[3];//這裡之後讀預期值
    $result = mysql_query("SELECT SUM(`satisfaction`),COUNT(`satisfaction`) FROM `customer_satisfaction` WHERE `cid`='$company' ");
    $temp = mysql_fetch_array($result);
    if ($temp[1] != 0)
        $customer_satisfaction = $temp[0] / $temp[1];
    else
        $customer_satisfaction=0;
//    if($expected_customer_satisfaction==0)
//        $customer_satisfaction_growth_rate=0;
//    else
    $customer_satisfaction_growth_rate = $customer_satisfaction; //$expected_customer_satisfaction-1;
    mysql_query("UPDATE `kpi_info` SET `價值主張：顧客平均滿意度`=$customer_satisfaction_growth_rate WHERE `session`=$n_month AND `account`='$company'"); //寫入 $customer_satisfaction_growth_rate
    //行銷費用佔營收比率
    $f_month = ($year - 1) * 12;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month  AND `name` = 515");
    $temp = mysql_fetch_array($result);
    $marketing = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    if ($revenue == 0)
        $marketing_revenue_ratio = 0;
    else
        $marketing_revenue_ratio=$marketing / $revenue * 100;
    mysql_query("UPDATE `kpi_info` SET `價值主張：行銷費用佔營收比率`=$marketing_revenue_ratio WHERE `session`=$n_month AND `account`='$company'"); //寫入$marketing_revenue_ratio;
    //費用收入比
    $f_month = ($year - 1) * 12;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` >= $f_month AND `month` <= $n_month ");
    $temp = mysql_fetch_array($result);
    $expenses = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    if ($revenue == 0)
        $cost_income_ratio = 0;
    else
        $cost_income_ratio=$expenses / $revenue * 100;
    mysql_query("UPDATE `kpi_info` SET `價值主張：費用收入比`=$cost_income_ratio WHERE `session`=$n_month AND `account`='$company'"); //寫入$cost_income_ratio;
    //資源整合
    //固定資產週轉率
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $revenue = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `fixed_assets` WHERE `cid`='$company' AND (`month` = $f_month OR `month` = $n_month)");
    $temp = mysql_fetch_array($result);
    $avg_fixed_assets = $temp[0] / 2;
    if ($avg_fixed_assets == 0)
        $fixed_asset_turnover = 0;
    else
        $fixed_asset_turnover=$revenue / $avg_fixed_assets;
    mysql_query("UPDATE `kpi_info` SET `資源整合：固定資產週轉率`=$fixed_asset_turnover WHERE `session`=$n_month AND `account`='$company'"); //寫入$fixed_asset_turnover
    //產品研發能力
    //$expected_RD=$target[6];//讀取年度預計開發計劃數量
    $f_month = ($year - 1) * 12;
    $n_month = ($year - 1) * 12 + $month;
    $result = mysql_query("SELECT COUNT(`index`) FROM `process_improvement` WHERE `cid` = '$company' AND `month`>$f_month AND `month`<$n_month");
    $temp = mysql_fetch_array($result);
    $current_RD = $temp[0];
//    if($expected_RD==0)
//        $RD_capability=0;
//    else
    $RD_capability = $current_RD; //$expected_RD*100;
    mysql_query("UPDATE `kpi_info` SET `資源整合：產品研發能力`=$RD_capability WHERE `session`=$n_month AND `account`='$company'"); //寫入$RD_capability
    //產品A成本率??????
    $expected_cost=0;
    $now_cost=0;
    $cost_rate_A=0;
    $cost=0;
    $batch=0;
    $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'target_cost_A'");
    $temp = mysql_fetch_array($result);
    $expected_cost = $temp[0];  //讀取年度預計成本
    //$expected_cost=$target[9];
	
    if ($year != 1) {
        $result = mysql_query("SELECT * FROM `product_history` WHERE `cid`='$company' AND `product`='A' AND `year`=$year-1", $connec);
        while ($temp = mysql_fetch_array($result)) {
            $temp_year = $temp[1];
            $temp_month = $temp[2];
            $batch = $temp[5];
            $result1 = mysql_query("SELECT `product_A_material_total`,`product_A_direct_labor`,`product_A_overhead` FROM `production_cost` WHERE `cid`='$company' AND `year`=$temp_year AND `month`=$temp_month");
            $temp1 = mysql_fetch_array($result1);
            $cost = $temp1[0] + $temp1[1] + $temp1[2];
        }
        if ($batch != 0)
            $expected_cost = $cost / $batch;
    }
    $result = mysql_query("SELECT * FROM `product_history` WHERE `cid`='$company' AND `product`='A' AND `year`=$year AND `month`<=$month");
    while ($temp = mysql_fetch_array($result)) {
        $temp_year = $temp[1];
        $temp_month = $temp[2];
        $batch = $temp[5];
        $result1 = mysql_query("SELECT `product_A_material_total`,`product_A_direct_labor`,`product_A_overhead` FROM `production_cost` WHERE `cid`='$company' AND `year`=$temp_year AND `month`=$temp_month");
        $temp1 = mysql_fetch_array($result1);
        $cost = $temp1[0] + $temp1[1] + $temp1[2];
    }
    if ($batch == 0)
        $cost_rate_A = 0;
    else{
        $now_cost=$cost / $batch;
        if ($expected_cost == 0)
            $cost_rate_A = 0;
        else
            $cost_rate_A = (1 - $now_cost / $expected_cost) * 100;
    }
    mysql_query("UPDATE `kpi_info` SET `資源整合：產品A成本率`=$cost_rate_A WHERE `session`=$n_month AND `account`='$company'"); //寫入$cost_rate_A
    //產品B成本率??????
    $expected_cost=0;
    $now_cost=0;
    $cost=0;
    $batch=0;
    $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'target_cost_B'");
    $temp = mysql_fetch_array($result);
    $expected_cost = $temp[0];
    //$expected_cost=$target[10];//讀取年度預計成本
    if ($year != 1) {
        $result = mysql_query("SELECT * FROM `product_history` WHERE `cid`='$company' AND `product`='B' AND `year`=$year-1");
        while ($temp = mysql_fetch_array($result)) {
            $temp_year = $temp[1];
            $temp_month = $temp[2];
            $batch = $temp[5];
            $result1 = mysql_query("SELECT `product_B_material_total`,`product_B_direct_labor`,`product_B_overhead` FROM `production_cost` WHERE `cid`='$company' AND `year`=$temp_year AND `month`=$temp_month");
            $temp1 = mysql_fetch_array($result1);
            $cost = $temp1[0] + $temp1[1] + $temp1[2];
        }
        if ($batch != 0)
            $expected_cost=$cost / $batch;
    }
    $result = mysql_query("SELECT * FROM `product_history` WHERE `cid`='$company' AND `product`='B' AND `year`=$year AND `month`<=$month");
    while ($temp = mysql_fetch_array($result)) {
        $temp_year = $temp[1];
        $temp_month = $temp[2];
        $batch = $temp[5];
        $result1 = mysql_query("SELECT `product_B_material_total`,`product_B_direct_labor`,`product_B_overhead` FROM `production_cost` WHERE `cid`='$company' AND `year`=$temp_year AND `month`=$temp_month");
        $temp1 = mysql_fetch_array($result1);
        $cost = $temp1[0] + $temp1[1] + $temp1[2];
    }
    if ($batch == 0)
        $cost_rate_B=0;
    else{
        $now_cost=$cost / $batch;
        if ($expected_cost == 0)
            $cost_rate_B = 0;
        else
            $cost_rate_B = (1 - $now_cost / $expected_cost) *100;
    }
    echo "$cost_rate_B = (1 - $now_cost / $expected_cost) *100<br/>";
    mysql_query("UPDATE `kpi_info` SET `資源整合：產品B成本率`=$cost_rate_B WHERE `session`=$n_month AND `account`='$company'"); //寫入$cost_rate_B
    //價值關係
    //產品A良品率
    $result = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$company' AND `product`='A' AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $batch = $temp[0];
    $result = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`) FROM `product_a` WHERE `cid`='$company'AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $product = $temp[0] + $temp[1] + $temp[2];
    if ($product != 0)
        $yield_A = $batch / $product *100;
    else
        $yield_A=0;
    mysql_query("UPDATE `kpi_info` SET `價值關係：產品A良品率`=$yield_A WHERE `session`=$n_month AND `account`='$company'"); //寫入$yield_A
    //產品B良品率
    $result = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$company' AND `product`='B' AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $batch = $temp[0];
    $result = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`) FROM `product_b` WHERE `cid`='$company' AND `year`=$year AND `month`<=$month");
    $temp = mysql_fetch_array($result);
    $product = $temp[0] + $temp[1] + $temp[2];
    if ($product != 0)
        $yield_B = $batch / $product *100;
    else
        $yield_B=0;
    mysql_query("UPDATE `kpi_info` SET `價值關係：產品B良品率`=$yield_B WHERE `session`=$n_month AND `account`='$company'"); //寫入$yield_B
    //薪資成本比率
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month AND `name`=512");
    $temp = mysql_fetch_array($result);
    $salary = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $operating_expenses = $temp[0];
    if ($operating_expenses == 0)
        $salary_cost_ratio = 0;
    else
        $salary_cost_ratio=$salary / $operating_expenses *100;
    mysql_query("UPDATE `kpi_info` SET `價值關係：薪資成本比率`=$salary_cost_ratio WHERE `session`=$n_month AND `account`='$company'"); //寫入$salary_cost_ratio
    //團隊學習
    //員工滿意度與績效成長
    $arr = Array("finance", "equip", "sale", "human", "research");
    $n_efficiency = 0;
    $n_satisfaction = 0;
    $n_total_people = 0;
    $p_efficiency = 0;
    $p_satisfaction = 0;
    $p_total_people = 0;
    $now_satisfaction = 0;
    $now_efficiency = 0;
    $past_satisfaction = 0;
    $past_efficiency = 0;
    $satisfaction = 0;
    $efficiency = 0;
    for ($i = 0; $i < 5; $i++) {
        $result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `cid`='$company' AND `department`='$arr[$i]' AND ((`year`=$year AND `month`<=$month) OR `year`<$year)");
        $temp = mysql_fetch_array($result);
        $people = $temp[0] - $temp[1];
        $result = mysql_query("SELECT `efficiency`,`satisfaction` FROM `current_people` WHERE `cid`='$company' AND `department`='$arr[$i]' AND `year`=$year AND `month`=$month");
        $temp = mysql_fetch_array($result);
        $n_efficiency+=$temp[0] * $people;
        $n_satisfaction+=$temp[1] * $people;
        $n_total_people+=$people;
        $result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `cid`='$company' AND `department`='$arr[$i]' AND (`year`<$year OR `month`=0)");
        $temp = mysql_fetch_array($result);
        $people = $temp[0] - $temp[1];
        if ($year == 1)
            $result = mysql_query("SELECT `efficiency`,`satisfaction` FROM `current_people` WHERE `cid`='$company' AND `department`='$arr[$i]' AND `month`=0");
        else
            $result=mysql_query("SELECT `efficiency`,`satisfaction` FROM `current_people` WHERE `cid`='$company' AND `department`='$arr[$i]' AND `year`=$year-1 AND `month`=12");
        $temp = mysql_fetch_array($result);
        $p_efficiency+=$temp[0] * $people;
        $p_satisfaction+=$temp[1] * $people;
        $p_total_people+=$people;
    }

    if ($n_total_people != 0) {
        $now_satisfaction = $n_satisfaction / $n_total_people;
        $now_efficiency = $n_efficiency / $n_total_people;
    }
    if ($p_total_people != 0) {
        $past_satisfaction = $p_satisfaction / $p_total_people;
        $past_efficiency = $p_efficiency / $p_total_people;
    }
    if ($past_satisfaction != 0)
        $satisfaction = ($now_satisfaction / $past_satisfaction - 1) * 100;
    if ($past_efficiency != 0)
        $efficiency = ($now_efficiency / $past_efficiency - 1) * 100;
    mysql_query("UPDATE `kpi_info` SET `團隊學習：員工滿意度`=$satisfaction,`團隊學習：員工效率成長率`=$efficiency WHERE `session`=$n_month AND `account`='$company'"); //寫入$satisfaction,$efficiency
    //員工能力度
    //$expected_train=$target[7];//讀出期初預期投入在職訓練費用金額
    $total_train = 0;
    $result = mysql_query("SELECT `decision1`,`decision2`,`decision3`,`decision4`,`decision5` FROM `training` WHERE `cid`='$company'  AND `year`=$year");
    while ($temp = mysql_fetch_array($result)) {
        for ($i = 0; $i < 5; $i++) {
            if ($temp[$i] == 1)
                $total_train+=5000;
            else if ($temp[$i] == 2)
                $total_train+=10000;
            else if ($temp[$i] == 3)
                $total_train+=20000;
        }
    }
//    if($expected_train==0)
//        $train=0;
//    else
    $train = $total_train; //$expected_train;
    mysql_query("UPDATE `kpi_info` SET `團隊學習：員工能力度`=$train WHERE `session`=$n_month AND `account`='$company'"); //寫入$train
    //員工平均獲利能力
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $operating_revenue = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_costs` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $operating_cost = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `operating_expenses` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $operating_expenses = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `other_revenue` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $other_revenue = $temp[0];
    $result = mysql_query("SELECT SUM(`price`) FROM `other_expenses` WHERE `cid`='$company' AND `month` > $f_month AND `month` <= $n_month");
    $temp = mysql_fetch_array($result);
    $other_expenses = $temp[0];
    $profit_before_tax = $operating_revenue + $operating_cost + $operating_expenses + $other_revenue + $other_expenses;
    $result = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `cid`='$company' AND ((`year`=$year AND `month`<=$month) OR `year`<$year)");
    $temp = mysql_fetch_array($result);
    $people = $temp[0] - $temp[1];
    if ($people != 0)
        $profitability_per_employee = $profit_before_tax / $people;
    else
        $profitability_per_employee=0;
    mysql_query("UPDATE `kpi_info` SET `團隊學習：員工平均獲利能力`=$profitability_per_employee WHERE `session`=$n_month AND `account`='$company'"); //寫入$profitability_per_employee
    //公司治理
    //投資人關係管理投入等級
    //$expected_level=$target[8];//讀預期提升等級
    $actual_level = mysql_query("SELECT MAX(`level`) FROM `relationship_decision` WHERE `cid`='$company' AND ((`year`=$year AND `month`<=$month) OR `year`<$year) AND `target`='investor_0'");
//    if($expected_level==0)
//        $investor_relations=0;
//    else
//echo "SELECT MAX(`level`) FROM `relationship_decision` WHERE `cid`='$company' AND ((`year`=$year AND `month`<=$month) OR `year`<$year) AND `target`='investor_0'";
    $investor_relations = mysql_fetch_array($actual_level); //$expected_level*100;
    if ($investor_relations[0] == "")
        $investor_relations[0] = 0;
    //echo "UPDATE `kpi_info` SET `公司治理：投資人關係管理投入等級`=$investor_relations[0] WHERE `session`=$n_month AND `account`='$company'";
    mysql_query("UPDATE `kpi_info` SET `公司治理：投資人關係管理投入等級`=$investor_relations[0] WHERE `session`=$n_month AND `account`='$company'"); //寫入$investor_relations
    //員工管理費用
    $result = mysql_query("SELECT `netin` FROM `cash` WHERE `cid`='$company' AND `year`=$year AND `month`=$month");
    //echo "SELECT `netin` FROM `cash` WHERE `cid`='$company' AND `year`=$year AND `month`=$month";
    $netin = mysql_fetch_array($result);
    $total_bonus = 0;
    $arr2 = Array("finance", "equip", "sale", "human", "research");
    for ($i = 0; $i < 5; $i++) {
        $result = mysql_query("SELECT SUM(`level`) FROM `relationship_decision` WHERE `cid`='$company'  AND `year`=$year AND `decision`='employee_$arr2[$i]'");
        $temp = mysql_fetch_array($result);
        $result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='$arr2[$i]_salary'");
        $temp1 = mysql_fetch_array($result);
        $total_bonus+=$temp[0] * $temp1[0];
    }
    //echo $netin[0];
    if ($netin[0] == 0)
        $bonus = 0;
    else
        $bonus=$total_bonus / $netin[0] * 100;
    //echo "UPDATE `kpi_info` SET `公司治理：員工管理費用`=$bonus WHERE `session`=$n_month AND `account`='$company'";
    mysql_query("UPDATE `kpi_info` SET `公司治理：員工管理費用`=$bonus WHERE `session`=$n_month AND `account`='$company'"); //寫入$bonus
    //現金股利發放金額
    //$expected_cash_dividend=$target[11];//讀取預期現金股利發放金額
    $result = mysql_query("SELECT `dividend_cost` FROM `fund_raising` WHERE `cid`='$company' AND `year`=$year AND `month`=1");
    $temp = mysql_fetch_array($result);
    $cash_dividend = $temp[0];
//    if($expected_cash_dividend==0)
//        $cash_dividend_rate=0;
//    else
    $cash_dividend_rate = $cash_dividend; //$expected_cash_dividend*100;
    mysql_query("UPDATE `kpi_info` SET `公司治理：現金股利發放金額`=$cash_dividend_rate WHERE `session`=$n_month AND `account`='$company'"); //寫入$cash_dividend_rate
    //現金增資程度
    $result = mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `cid`='$company'  AND `year`=$year");
    $temp = mysql_fetch_array($result);
    $cash_increase = $temp[0];
//    $result = mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `cid`='$company'  AND `year` = $year AND `month` = 1");
//    $temp = mysql_fetch_array($result);
//    $cash_increase_before = $temp[0];
//    if ($cash_increase_before == 0)
//        $cash_capital_increase = 0;
//    else
//        $cash_capital_increase=$cash_increase / $cash_increase_before * 100;
    mysql_query("UPDATE `kpi_info` SET `公司治理：現金增資金額`=$cash_increase WHERE `session`=$n_month AND `account`='$company'"); //寫入$cash_capital_increase
}
?>
