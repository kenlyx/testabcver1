<?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);
	
	if($_GET['type']==A){
		
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['product_A_size_ratio']." where `name`='product_A_size_ratio'");
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['product_B_size_ratio']." where `name`='product_B_size_ratio' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplierA_flaw']." where `name`='supplierA_flaw' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplierB_flaw']." where `name`='supplierB_flaw' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplierC_flaw']." where `name`='supplierC_flaw' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplier_A_power']." where `name`='supplier_A_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplier_B_power']." where `name`='supplier_B_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['supplier_C_power']." where `name`='supplier_C_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['depreciation']." where `name`='depreciation' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['housing_cost']." where `name`='housing_cost' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['finance_salary']." where `name`='finance_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['sale_salary']." where `name`='sale_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['research_salary']." where `name`='research_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['human_salary']." where `name`='human_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['equip_salary']." where `name`='equip_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['detect_cost']." where `name`='detect_cost' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['Capacity_detect1']." where `name`='Capacity_detect1' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['Capacity_detect2']." where `name`='Capacity_detect2' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['company_image_ratio_A']." where `name`='company_image_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['company_image_ratio_B']." where `name`='company_image_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['customer_satisfaction_ratio_A']." where `name`='customer_satisfaction_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['customer_satisfaction_ratio_B']." where `name`='customer_satisfaction_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['price_ratio_A']." where `name`='price_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['price_ratio_B']." where `name`='price_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['quality_ratio_A']." where `name`='quality_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['quality_ratio_B']." where `name`='quality_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['monitor']." where `name`='monitor' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['kernel']." where `name`='kernel' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['keyboard']." where `name`='keyboard' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['cut']." where `name`='cut' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['combine1']." where `name`='combine1' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['combine2']." where `name`='combine2' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['check_s']." where `name`='check_s' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['check']." where `name`='check' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['pp_monitor']." where `name`='pp_monitor' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['pp_kernel']." where `name`='pp_kernel' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['pp_keyboard']." where `name`='pp_keyboard' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['pp_check_s']." where `name`='pp_check_s' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=".$_GET['pp_check']." where `name`='pp_check' ",$connect);
		
		
	}
	
	//-------------------------------我是分隔線~(￣▽￣)~(＿△＿)~(￣▽￣)~(＿△＿)~(￣▽￣)~------------------------------
	
	else if($_GET['type']==B){
		mysql_query("TRUNCATE TABLE `ad_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `ad_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `current_people` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `customer_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `donate` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `dupont` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `fixed_assets` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `fund_raising` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `income_taxes`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `investor_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `kpi_info` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `machine` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `materials_cost` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `operating_costs` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `order_accept` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `order_detail` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `process_improvement` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_famous` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_plan` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_quality` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_history` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `production_cost` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `purchase_materials_price` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `purchase_materials` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `r_d` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `relationship_decision` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `share` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `score` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `state` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_c` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `training` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `cash`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `stock`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `contract`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `market_trend`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `budget`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `budget_hire`;",$connect) or die(mysql_error());
		
		$table=array("operating_revenue","operating_costs","operating_expenses","other_revenue","other_expenses","fixed_assets","current_assets","equity","long-term_liabilities","current_liabilities","operating_netin","investing_netin","financing_netin","cash_balance_last");
		$length=count($table);
		for($i=0;$i<$length;$i++){
			mysql_query("TRUNCATE TABLE `$table[$i]`;",$connect) or die(mysql_error());
		}
		
		mysql_query("UPDATE `parameter_description` SET `value`=2 WHERE `name`='product_A_size_ratio';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=1 WHERE `name`='product_B_size_ratio';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0002 WHERE `name`='supplierA_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0003 WHERE `name`='supplierB_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0005 WHERE `name`='supplierC_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=1 WHERE `name`='housing_cost';",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=10000 where `name`='supplier_A_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=20000 where `name`='supplier_B_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=25000 where `name`='supplier_C_power' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=120 where `name`='depreciation' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=25000 where `name`='finance_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=28000 where `name`='sale_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=35000 where `name`='research_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=25000 where `name`='human_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=30000 where `name`='equip_salary' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=1.05 where `name`='detect_cost' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=360000 where `name`='Capacity_detect1' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=630000 where `name`='Capacity_detect2' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.25 where `name`='company_image_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.3 where `name`='company_image_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='customer_satisfaction_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.1 where `name`='customer_satisfaction_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.45 where `name`='price_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.3 where `name`='price_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.25 where `name`='quality_ratio_A' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.3 where `name`='quality_ratio_B' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.03 where `name`='monitor' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.03 where `name`='kernel' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.03 where `name`='keyboard' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='cut' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='combine1' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='combine2' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.03 where `name`='check_s' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.03 where `name`='check' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='pp_monitor' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='pp_kernel' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='pp_keyboard' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.05 where `name`='pp_check_s' ",$connect);
		mysql_query("UPDATE `parameter_description` Set `value`=0.1 where `name`='pp_check' ",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1200,`money2`=1100,`money3`=1000 WHERE `name`='purchase_materials_ma';",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1600,`money2`=1500,`money3`=1400 WHERE `name`='purchase_materials_mb';",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1100,`money2`=1000,`money3`=900 WHERE `name`='purchase_materials_mc';",$connect);
		mysql_query("UPDATE `situation_overview` SET `situation`=0");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=1;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=2;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=3;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=4;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=5;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=6;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=7;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=8;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=9;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=900 WHERE `index`=10;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=11;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=12;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=13;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=14;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=15;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3000 WHERE `index`=16;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=17;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=18;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=19;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2500 WHERE `index`=20;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=21;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1500 WHERE `index`=22;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3500 WHERE `index`=23;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2500 WHERE `index`=24;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1500 WHERE `index`=25;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=26;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3000 WHERE `index`=27;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=28;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=29;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=30;");
		
	}
	
	//-------------------------------我是分隔線~(￣▽￣)~(＿△＿)~(￣▽￣)~(＿△＿)~(￣▽￣)~------------------------------
	
	else if($_GET['type']==C){
		mysql_query("TRUNCATE TABLE `ad_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `ad_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `current_people` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `customer_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `donate` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `dupont` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `fixed_assets` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `fund_raising` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `income_taxes`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `investor_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `kpi_info` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `machine` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `materials_cost` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `operating_costs` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `order_accept` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `order_detail` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `process_improvement` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_famous` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_plan` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_quality` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `product_history` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `production_cost` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `purchase_materials_price` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `purchase_materials` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `r_d` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `relationship_decision` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `share` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `score` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `state` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_a` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_b` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_c` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `supplier_satisfaction` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `training` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `cash`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `stock`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `contract`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `market_trend`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `budget`;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `budget_hire`;",$connect) or die(mysql_error());
		
		$table=array("operating_revenue","operating_costs","operating_expenses","other_revenue","other_expenses","fixed_assets","current_assets","equity","long-term_liabilities","current_liabilities","operating_netin","investing_netin","financing_netin","cash_balance_last");
		$length=count($table);
		for($i=0;$i<$length;$i++){
			mysql_query("TRUNCATE TABLE `$table[$i]`;",$connect) or die(mysql_error());
		}
		
		mysql_query("UPDATE `parameter_description` SET `value`=2 WHERE `name`='product_A_size_ratio';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=1 WHERE `name`='product_B_size_ratio';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0002 WHERE `name`='supplierA_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0003 WHERE `name`='supplierB_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=0.0005 WHERE `name`='supplierC_flaw';",$connect);
		mysql_query("UPDATE `parameter_description` SET `value`=1 WHERE `name`='housing_cost';",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1200,`money2`=1100,`money3`=1000 WHERE `name`='purchase_materials_ma';",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1600,`money2`=1500,`money3`=1400 WHERE `name`='purchase_materials_mb';",$connect);
		mysql_query("UPDATE `correspondence` SET `money`=1100,`money2`=1000,`money3`=900 WHERE `name`='purchase_materials_mc';",$connect);
		mysql_query("UPDATE `situation_overview` SET `situation`=0");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=1;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=2;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=3;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=4;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=5;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=6;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=7;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=8;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=9;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=900 WHERE `index`=10;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=11;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=600 WHERE `index`=12;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=13;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=800 WHERE `index`=14;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=700 WHERE `index`=15;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3000 WHERE `index`=16;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=17;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=18;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=19;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2500 WHERE `index`=20;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=21;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1500 WHERE `index`=22;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3500 WHERE `index`=23;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2500 WHERE `index`=24;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1500 WHERE `index`=25;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=26;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=3000 WHERE `index`=27;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=28;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=1000 WHERE `index`=29;");
		mysql_query("UPDATE `customer_state` SET `initial`=0, `valid`=0, `quantity`=2000 WHERE `index`=30;");
		
		mysql_select_db("testabc_login", $connect);
		
		mysql_query("TRUNCATE TABLE `authority` ;",$connect) or die(mysql_error());
		mysql_query("TRUNCATE TABLE `account` ;",$connect) or die(mysql_error());
		
	}
	
?>