<?php
function jtp(){
	//include ("../../../../Users/abc/Downloads/checkIP.php");
	//避免有重複影響的欄位被蓋掉，不論先前有沒被UPDATE過，都先讀值相加後再寫入
	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account`" );
	mysql_select_db("testabc_main",$connect);
	
	$temp=mysql_query("SELECT MAX(`year`) FROM `state`" );
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;" );
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0]-1;
    if($month==0){
    	$month=12;
    	$year-=1;
    }
	//上一回合的回合數(每回合一開始報表計算至上一回合)	
	$round_now=$month+($year-1)*12;
	$sum=0;
	$netin=0;
	$cash=0;
	$journal=mysql_query("SELECT * FROM journal ORDER BY `index`" );
	while($company=mysql_fetch_array($C_name)){//每間公司
		$cid=$company['CompanyID'];
		$table=array("operating_revenue","operating_costs","operating_expenses","other_revenue","other_expenses","fixed_assets","current_assets","equity","long-term_liabilities","current_liabilities","operating_netin","investing_netin","financing_netin","cash_balance_last");
		$table_rows=array("2","2","6","2","2",	"2","6","4","3","3",	"6","2","5","1");
		$name=array("41","42","5111","5112","516","512","515","525","524","518","522","523","7","521","141","142","115","117","112","113","114","111","31","32","35","33","232","216","212","211","213215","214","sales_income","purchase_product","operating_exp","other_exp","interest","income_tax","assets_purchase","assets_sale","short_pay","long_pay","cash_increase","treasury","dividend","cash_balance_last");
		$length=count($table);
		$j=0;
		for($i=0;$i<$length;$i++){
			for($index=1;$index<=$table_rows[$i];$j++,$index++){
				if($i<5||$i>9){
					mysql_query("INSERT INTO `$table[$i]` VALUES($index,'$cid',$round_now,'$name[$j]',0)" );
				}
				else{//財務狀況表先直接寫到下一期
					if($round_now>1){
						$result=mysql_query("SELECT price FROM `$table[$i]` WHERE `month`=$round_now-1 AND `cid`='$cid' AND `name`='$name[$j]'" );
						$temp=mysql_fetch_array($result);
						mysql_query("INSERT INTO `$table[$i]` VALUES($index,'$cid',$round_now,'$name[$j]',$temp[0])" );
					}
					else{ 
						mysql_query("INSERT INTO `$table[$i]` VALUES($index,'$cid',$round_now,'$name[$j]',0)" );
					}
				}
			}
		}
		//income_taxes cash欄位不同另外處理
		$sql_bankrupt=mysql_query("SELECT `bankrupt` FROM `cash` WHERE `year`=$year AND `month`=$month");
		$bankrupt=mysql_fetch_array($sql_bankrupt);
		$index=1;
	
		mysql_query("INSERT INTO `income_taxes` VALUES($index,'$cid',$round_now,0)" );
		if($month+1>12){
			mysql_query("INSERT INTO `cash` VALUES($year+1,1,'$cid',0,0,$bankrupt[0])" );
		}
		else{ 
			mysql_query("INSERT INTO `cash` VALUES($year,$month+1,'$cid',0,0,$bankrupt[0])" );
		}
		$journal=mysql_query("SELECT * FROM journal ORDER BY `index`" );
		while($decision_name=mysql_fetch_array($journal)){
			//mysql_select_db("report" );如果報表放另一個資料庫的話可能會用到這行?
			switch ($decision_name['name']){
				case 'current_people':
					$department=array("0"=>"finance","1"=>"equip","2"=>"sale","3"=>"human","4"=>"research");//資料庫的部門名稱改的話直接改這裡就好
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'" );
					$correspond=mysql_fetch_array($correspondence);//各決策所需金額對照表
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					$hire_count=0;
					$fire_count=0;
					for($i=0;$i<5;$i++){
						$result = mysql_query("SELECT * FROM current_people WHERE (`year`<$year OR (`year`=$year AND `month`<=$month)) AND `department`='$department[$i]' AND `cid`='$cid'", $connect);
						while($temp=mysql_fetch_array($result)){//先算整張表+-後有多少人
							$hire_count+=$temp['hire_count'];
							$fire_count+=$temp['fire_count'];
						}//再扣掉本回合決策的人數
						$result=mysql_query("SELECT * FROM current_people WHERE `year`=$year AND `month`=$month AND `department`='$department[$i]' AND `cid`='$cid'" );
						$temp=mysql_fetch_array($result);
						$sum=$sum+$temp['hire_count']*$correspond['money'];
						$hire_count-=$temp['hire_count'];
						$fire_count-=$temp['fire_count'];
						$people=$hire_count-$fire_count;//即為目前人數
						if ($department[$i] == "finance") {//各部門薪資＆資遣費判斷，correspondence的金額對應要對
							$sum = $sum + $people * $correspond['money2']; //薪資
							$sum = $sum + $temp['fire_count'] * $correspond['money2'] * 3;//資遣費
						} 
						elseif ($department[$i] == "equip") {
							$sum = $sum + $people * $correspond['money3'];
							$sum = $sum + $temp['fire_count'] * $correspond['money3'] * 3;
						} 
						elseif ($department[$i] == "sale") {
							$sum = $sum + $people * $correspond2['money'];
							$sum = $sum + $temp['fire_count'] * $correspond2['money'] * 3;
						} 
						elseif ($department[$i] == "human") {
							$sum = $sum + $people * $correspond2['money2'];
							$sum = $sum + $temp['fire_count'] * $correspond2['money2'] * 3;
						} 
						elseif ($department[$i] == "research") {
							$sum = $sum + $people * $correspond2['money3'];
							$sum = $sum + $temp['fire_count'] * $correspond2['money3'] * 3;
						}
						$hire_count=0;
						$fire_count=0;
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='512' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='512' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'share':   //平板差異化
					$for_cal=mysql_query("SELECT * FROM `share` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share1'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share3'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					$cal_array=mysql_fetch_array($for_cal);
					if ($cal_array['decision1'] == 1){
						$sum = $sum + $correspond['money'];
					}
					elseif ($cal_array['decision1'] == 2){
						$sum = $sum + $correspond['money2'];
					}
					elseif ($cal_array['decision1'] == 3){
						$sum = $sum + $correspond['money3'];
					}
					if ($cal_array['decision3'] == 1){
						$sum = $sum + $correspond['money'];
					}
					elseif ($cal_array['decision3'] == 2){
						$sum = $sum + $correspond['money2'];
					}
					elseif ($cal_array['decision3'] == 3){
						$sum = $sum + $correspond['money3'];
					}
					if($sum!=0){//0代表無異動，不理它
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);       //研究發展費用
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'share2':   //平板差異化
					$for_cal = mysql_query("SELECT * FROM `share` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share2'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					$cal_array = mysql_fetch_array($for_cal);
					if ($cal_array['decision2'] == 1){
						$sum = $sum + $correspond['money'];
					}
					elseif ($cal_array['decision2'] == 2){
						$sum = $sum + $correspond['money2'];
					}
					elseif ($cal_array['decision2'] == 3){
						$sum = $sum + $correspond['money3'];
					}
					if($sum!=0){//0代表無異動，不理它
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'donate':   //筆電差異化
					$for_cal=mysql_query("SELECT * FROM `donate` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'" );
					$correspond=mysql_fetch_array($correspondence);
					$cal_array=mysql_fetch_array($for_cal);
					for($i=1;$i<4;$i++){
						if($cal_array['decision'.$i]==1){
							$sum=$sum+$correspond['money'];
						}
						elseif($cal_array['decision'.$i]==2){
							$sum=$sum+$correspond['money2'];
						}
						elseif($cal_array['decision'.$i]==3){
							$sum=$sum+$correspond['money3'];
						}
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM other_expenses WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);           //研究發展費用
						mysql_query("UPDATE `other_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'ad_a':
					$for_cal = mysql_query("SELECT * FROM `ad_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_a1'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_a2'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_a3'", $connect);
					$correspond3 = mysql_fetch_array($correspondence);
					$cal_array = mysql_fetch_array($for_cal);
					for ($i = 1; $i < 4; $i++){
						if ($i == 1) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond['money3'];
						}
						elseif ($i == 2) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond2['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond2['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond2['money3'];
						}
						elseif ($i == 3) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond3['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond3['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond3['money3'];
						}
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='515' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='515' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'ad_b':
					$for_cal = mysql_query("SELECT * FROM `ad_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_b1'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_b2'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='ad_b3'", $connect);
					$correspond3 = mysql_fetch_array($correspondence);
					$cal_array = mysql_fetch_array($for_cal);
					for ($i = 1; $i < 4; $i++){
						if ($i == 1) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond['money3'];
						}
						elseif ($i == 2) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond2['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond2['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond2['money3'];
						}
						elseif ($i == 3) {
							if ($cal_array['decision' . $i] == 1)
								$sum = $sum + $correspond3['money'];
							elseif ($cal_array['decision' . $i] == 2)
								$sum = $sum + $correspond3['money2'];
							elseif ($cal_array['decision' . $i] == 3)
								$sum = $sum + $correspond3['money3'];
						}
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='515' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='515' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'purchase_materials':
					$for_cal = mysql_query("SELECT * FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$purchase_materials_price=mysql_query("SELECT * FROM `purchase_materials_price` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$materials_price = mysql_fetch_array($purchase_materials_price);
					$cal_array=mysql_fetch_array($for_cal);
					$sum = $sum + $cal_array['ma_supplier_a'] * $materials_price['ma_supplier_a'] + $cal_array['ma_supplier_b'] * $materials_price['ma_supplier_b'] + $cal_array['ma_supplier_c'] * $materials_price['ma_supplier_c'];
					$sum = $sum + $cal_array['mb_supplier_a'] * $materials_price['mb_supplier_a'] + $cal_array['mb_supplier_b'] * $materials_price['mb_supplier_b'] + $cal_array['mb_supplier_c'] * $materials_price['mb_supplier_c'];
					$sum = $sum + $cal_array['mc_supplier_a'] * $materials_price['mc_supplier_a'] + $cal_array['mc_supplier_b'] * $materials_price['mc_supplier_b'] + $cal_array['mc_supplier_c'] * $materials_price['mc_supplier_c'];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM `current_assets` WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
						$temp=mysql_query("SELECT price FROM current_liabilities WHERE `name`='213215' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_liabilities` SET `price`=$temp_result[0]+$sum WHERE `name`='213215' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'purchase_machine':
					$for_cal=mysql_query("SELECT * FROM `machine` WHERE `buy_year`='$year' AND `buy_month`='$month' AND `cid`='$cid' ORDER BY `buy_year`,`buy_month`" );
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='machine_cut'" );
					$correspond=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine1'" );
					$correspond2=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine2'" );
					$correspond3=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='machine_detect'" );
					$correspond4=mysql_fetch_array($correspondence);
					while($cal_array=mysql_fetch_array($for_cal)){
						if($cal_array['function']=="cut"){
							if($cal_array['type']=="A")
								$sum=$sum+$correspond['money'];
							else if($cal_array['type']=="B")
								$sum=$sum+$correspond['money2'];
							else if($cal_array['type']=="C")	
								$sum=$sum+$correspond['money3'];
						}
						else if($cal_array['function']=="combine1"){
							if($cal_array['type']=="A")$sum=$sum+$correspond2['money'];
							else if($cal_array['type']=="B")$sum=$sum+$correspond2['money2'];
							else if($cal_array['type']=="C")$sum=$sum+$correspond2['money3'];
						}
						else if($cal_array['function']=="combine2"){
							if($cal_array['type']=="A")$sum=$sum+$correspond3['money'];
							else if($cal_array['type']=="B")$sum=$sum+$correspond3['money2'];
							else if($cal_array['type']=="C")$sum=$sum+$correspond3['money3'];
						}
						else if($cal_array['function']=="detect"){
							if($cal_array['type']=="A")$sum=$sum+$correspond4['money'];
							else if($cal_array['type']=="B")$sum=$sum+$correspond4['money2'];
							else if($cal_array['type']=="C")$sum=$sum+$correspond4['money3'];
						}
					}
					if($sum!=0){
						//fixed_assets:若前一回合有購買機具，加入購買機具之價錢
						$temp=mysql_query("SELECT price FROM `fixed_assets` WHERE `name`='141' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `fixed_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='141' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM `current_assets` WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `investing_netin` SET `price`=0-$sum WHERE `name`='assets_purchase' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'sell_machine'://之後要再乘上折舊
					$depreciation=0;
					$sell_cash=0;
					$sell_lost=0;
					$machine=0;
					$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='depreciation'" );
					$result=mysql_fetch_array($temp);
					$for_cal=mysql_query("SELECT * FROM `machine` WHERE `sell_year`='$year' AND `sell_month`='$month' AND `cid`='$cid' ORDER BY `sell_year`,`sell_month`" );
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_cut'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine1'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine2'", $connect);
					$correspond3 = mysql_fetch_array($correspondence);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_detect'", $connect);
					$correspond4 = mysql_fetch_array($correspondence);
					while($cal_array=mysql_fetch_array($for_cal)){
						if($cal_array['function']=="cut"){
							if($cal_array['type']=="A")$machine=$machine+$correspond['money'];
							else if($cal_array['type']=="B")$machine=$machine+$correspond['money2'];
							else if($cal_array['type']=="C")$machine=$machine+$correspond['money3'];
						}
						else if($cal_array['function']=="combine1"){
							if($cal_array['type']=="A")$machine=$machine+$correspond2['money'];
							else if($cal_array['type']=="B")$machine=$machine+$correspond2['money2'];
							else if($cal_array['type']=="C")$machine=$machine+$correspond2['money3'];
						}
						else if($cal_array['function']=="combine2"){
							if($cal_array['type']=="A")$machine=$machine+$correspond3['money'];
							else if($cal_array['type']=="B")$machine=$machine+$correspond3['money2'];
							else if($cal_array['type']=="C")$machine=$machine+$correspond3['money3'];
						}
						else if($cal_array['function']=="detect"){
							if($cal_array['type']=="A")$machine=$machine+$correspond4['money'];
							else if($cal_array['type']=="B")$machine=$machine+$correspond4['money2'];
							else if($cal_array['type']=="C")$machine=$machine+$correspond4['money3'];
						}
						$buyround=($cal_array['buy_year']-1)*12+$cal_array['buy_month'];
						$sellround=($cal_array['sell_year']-1)*12+$cal_array['sell_month'];;
						if($sellround-$buyround>0){
							//累計折舊: 機具價格*(賣-買)/120
							$depreciation=$machine*($sellround-$buyround)/$result[0];
							$sell_cash=($machine-$depreciation)*0.7;
							$sell_lost=$machine-$depreciation-$sell_cash;
						}
						$sum=$machine;
					}
					if($sum!=0){
						//fixed_assets: 若有賣機具，扣掉賣出的價錢(固定打七折)
						$temp=mysql_query("SELECT price FROM `fixed_assets` WHERE `name`='141' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `fixed_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='141' AND `month`=$round_now AND `cid`='$cid'" );
						//正的累計折舊(是報表需要扣掉這個值???)
						$temp=mysql_query("SELECT price FROM `fixed_assets` WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `fixed_assets` SET `price`=$temp_result[0]+$depreciation WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM `operating_expenses` WHERE `name`='518' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sell_lost WHERE `name`='518' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);//+$sell_lost 從下面式子移除2012/3/4 13:13
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sell_cash WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `investing_netin` SET `price`=$sell_cash WHERE `name`='assets_sale' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sell_lost;
					break;
				case 'product_a':
					$for_cal=mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_ma'" );
					$correspond=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mb'" );
					$correspond2=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mc'" );
					$correspond3=mysql_fetch_array($correspondence);
					while($cal_array=mysql_fetch_array($for_cal)){
						$sum=$sum+$cal_array['ma_supplier_a']*$correspond['money']+$cal_array['ma_supplier_b']*$correspond['money2']+$cal_array['ma_supplier_c']*$correspond['money3'];
						$sum=$sum+$cal_array['mb_supplier_a']*$correspond2['money']+$cal_array['mb_supplier_b']*$correspond2['money2']+$cal_array['mb_supplier_c']*$correspond2['money3'];
						$sum=$sum+$cal_array['mc_supplier_a']*$correspond3['money']+$cal_array['mc_supplier_b']*$correspond3['money2']+$cal_array['mc_supplier_c']*$correspond3['money3'];
					}
					break;
				case 'product_b':
					$for_cal=mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_ma'" );
					$correspond=mysql_fetch_array($correspondence);
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mb'" );
					$correspond2=mysql_fetch_array($correspondence);
					while($cal_array=mysql_fetch_array($for_cal)){
						$sum=$sum+$cal_array['ma_supplier_a']*$correspond['money']+$cal_array['ma_supplier_b']*$correspond['money2']+$cal_array['ma_supplier_c']*$correspond['money3'];
						$sum=$sum+$cal_array['mb_supplier_a']*$correspond2['money']+$cal_array['mb_supplier_b']*$correspond2['money2']+$cal_array['mb_supplier_c']*$correspond2['money3'];
					}
					break;
				case 'process_improvement':
					$for_cal = mysql_query("SELECT * FROM `process_improvement` WHERE `month`=$round_now AND `cid`='$cid' ORDER BY `index`", $connect);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='process_improvement'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					while ($cal_array = mysql_fetch_array($for_cal)) {
						if ($cal_array['process'] == "monitor" || $cal_array['process'] == "kernel" || $cal_array['process'] == "keyboard")
							$sum = $sum + $correspond['money'];
						elseif ($cal_array['process'] == "check_s")
							$sum = $sum + $correspond['money2'];
						elseif ($cal_array['process'] == "check")
							$sum = $sum + $correspond['money3'];
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'product_plan':
					$direct_labor=0;
					$for_cal = mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$for_cal = mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array2 = mysql_fetch_array($for_cal);
					if($cal_array['ma_supplier_a']+$cal_array['ma_supplier_b']+$cal_array['ma_supplier_c']+$cal_array2['ma_supplier_a']+$cal_array2['ma_supplier_b']+$cal_array2['ma_supplier_c']>0){
						$for_cal = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						//$depreciation = $cal_array['product_A_depreciation']+$cal_array['product_B_depreciation'];//+$cal_array['notuse_cut_depreciation']+$cal_array['notuse_combine1_depreciation']+$cal_array['notuse_detect1_depreciation']+$cal_array['notuse_combine2_depreciation']+$cal_array['notuse_detect2_depreciation'];
						/*if($month-1==0)
							$for_cal = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year-1 AND `month`=1 AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						else $for_cal = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year AND `month`=$month-1 AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						$depreciation = $depreciation-($cal_array['notuse_cut_depreciation']+$cal_array['notuse_combine1_depreciation']+$cal_array['notuse_detect1_depreciation']+$cal_array['notuse_combine2_depreciation']+$cal_array['notuse_detect2_depreciation']);*/
						$for_cal = mysql_query("SELECT product_A_overhead, product_B_overhead FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						$overhead=$cal_array[0]+$cal_array[1];
						$for_cal = mysql_query("SELECT product_A_detect_labor, product_B_detect_labor FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						$detect_labor=$cal_array[0]+$cal_array[1];
						
						$sum=$overhead-$detect_labor; //-$depreciation;
						$for_cal = mysql_query("SELECT product_A_direct_labor, product_B_direct_labor FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						$direct_labor=$cal_array[0]+$cal_array[1];
						//分攤折舊
						$for_cal = mysql_query("SELECT product_A_depreciation, product_B_depreciation FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
						$cal_array = mysql_fetch_array($for_cal);
						$dep=$cal_array[0]+$cal_array[1];    //產品AB折舊和
							$temp=mysql_query("SELECT price FROM `current_assets` WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$detect_labor+$direct_labor+$sum WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
							
							$temp=mysql_query("SELECT price FROM `current_assets` WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);            //-(製造費用-折舊費用)=減料人工&機器使用成本
							mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$overhead+$dep WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
							//檢料人工入薪資費用
							$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='512' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$detect_labor WHERE `name`='512' AND `month`=$round_now AND `cid`='$cid'" );
							//機器使用成本入管理費
							$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);     //-(製造費用-檢料人工-折舊費用)
							mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-($overhead-$detect_labor-$dep) WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
							//取出本期的累計折舊(這段應該不要，不然會多存到折舊)
							$temp=mysql_query("SELECT price FROM `fixed_assets` WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);		
							mysql_query("UPDATE `fixed_assets` SET `price`=$temp_result[0]-$dep WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
							
							
							
					}
					$netin+=$direct_labor;
					break;
				case 'depreciation':
					
					//公司內現有且未出售的機具
					$sql_machine=mysql_query("SELECT * FROM `machine` WHERE `cid`='$cid' and `sell_month`='99' and ((`buy_year`-1)*12+`buy_month`)<=$round_now");
    				$rows_m = mysql_num_rows($sql_machine);
					
					//各類型機具之價錢
					$get_cutprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
   				 	$cutprice=mysql_fetch_array($get_cutprice);
					$get_com1price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
    				$com1price=mysql_fetch_array($get_com1price);
					$get_com2price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
    				$com2price=mysql_fetch_array($get_com2price);
					$get_detprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
    				$detprice=mysql_fetch_array($get_detprice);
	
					$type=array('A'=>1,'B'=>2,'C'=>3);
					
				if($rows_m!=0){
					$i=0;
					while($machine=mysql_fetch_array($sql_machine)){
						//get machine detail
						$machine_func[$i]=$machine['function'];
						$machine_type[$i]=$machine['type'];
						$machine_by[$i]=$machine['buy_year'];
						$machine_bm[$i]=$machine['buy_month'];
						$round_buy=($machine_by[$i]-1)*12+$machine_bm[$i];
						
						//購買價格、累計折舊
						if($machine_func[$i]=='cut'){
							$cutp=$cutprice[$type[$machine_type[$i]]];
							$depre+=$cutp/120;
						}else if($machine_func[$i]=='combine1'){
							$com1p=$com1price[$type[$machine_type[$i]]];
							$depre+=$com1p/120;
						}else if($machine_func[$i]=='combine2'){
							$com2p=$com2price[$type[$machine_type[$i]]];
							$depre+=$com2p/120;
						}else if($machine_func[$i]=='detect'){
							$detp=$detprice[$type[$machine_type[$i]]];
							$depre+=$detp/120;
						}//end if
					}//end while
				}//end if
						if($depre!=0){
							$temp=mysql_query("SELECT price FROM `fixed_assets` WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `fixed_assets` SET `price`=$temp_result[0]-$depre WHERE `name`='142' AND `month`=$round_now AND `cid`='$cid'" );
						//修改至帳目裡面
							
							$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$depre WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
							
								}
					$netin-=$depre;	
					break;
				case 'r_d':
					$for_cal=mysql_query("SELECT SUM(product_A_RD),SUM(product_B_RD) FROM `state` WHERE `year`<=$year AND `month`<='$month' AND `cid`='$cid' ORDER BY `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$for_cal=mysql_query("SELECT product_A_RD,product_B_RD FROM `state` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `month`" );
					$cal_array2 = mysql_fetch_array($for_cal);
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'", $connect);
					$correspond = mysql_fetch_array($correspondence);
					if(($cal_array[0]==1&&$cal_array2[0])||($cal_array[1]==1&&$cal_array2[1]))
						$sum=$correspond['money'];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='524' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'training':
					$for_cal=mysql_query("SELECT * FROM `training` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'" );
					$correspond=mysql_fetch_array($correspondence);
					$cal_array=mysql_fetch_array($for_cal);
					for($i=1;$i<6;$i++)
						if($cal_array['decision'.$i]==1)
							$sum=$sum+$correspond['money'];
						elseif($cal_array['decision'.$i]==2)
							$sum=$sum+$correspond['money2'];
						elseif($cal_array['decision'.$i]==3)
							$sum=$sum+$correspond['money3'];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'long':
					$for_cal=mysql_query("SELECT `long` FROM `fund_raising` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$sum=$cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`='212' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `long-term_liabilities` SET `price`=$temp_result[0]+$sum WHERE `name`='212' AND `month`=$round_now AND `cid`='$cid'" );
					
						mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='long_pay' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'short':
					$for_cal=mysql_query("SELECT `short` FROM `fund_raising` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$sum=$cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `current_liabilities` WHERE `name`='211' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_liabilities` SET `price`=$temp_result[0]+$sum WHERE `name`='211' AND `month`=$round_now AND `cid`='$cid'" );
					
						mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='short_pay' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'repay':
					$for_cal=mysql_query("SELECT `repay` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$sum=$cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`='212' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `long-term_liabilities` SET `price`=$temp_result[0]-$sum WHERE `name`='212' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM `financing_netin` WHERE `name`='long_pay' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `financing_netin` SET `price`=$temp_result[0]-$sum WHERE `name`='long_pay' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'repay2':
					$for_cal = mysql_query("SELECT `repay2` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$sum = $cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `current_liabilities` WHERE `name`='211' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_liabilities` SET `price`=$temp_result[0]-$sum WHERE `name`='211' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM `financing_netin` WHERE `name`='short_pay' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `financing_netin` SET `price`=$temp_result[0]-$sum WHERE `name`='short_pay' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'order'://銷貨收入AB要分開
					$result=mysql_query("SELECT * FROM `order_accept` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					$pA_income=0;
					$pB_income=0;
					while($temp=mysql_fetch_array($result)){
						$order_no=$temp['order_no'];
						$type=explode("_",$order_no);//拆字串判斷產品AB
						if($type[1]=='A')
							$pA_income+=$temp['price']*$temp['quantity'];
						elseif($type[1]=='B')
							$pB_income+=$temp['price']*$temp['quantity'];
						$sum=$pA_income+$pB_income;
					}
                    $sum2=0;
					$for_cal = mysql_query("SELECT product_A_COGS, product_B_COGS FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
                    $sum2=$cal_array[0] + $cal_array[1];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='113' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='113' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `operating_revenue` WHERE `name`='41' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_revenue` SET `price`=$temp_result[0]+$pA_income WHERE `name`='41' AND `month`=$round_now AND `cid`='$cid'" );
						$temp=mysql_query("SELECT price FROM `operating_revenue` WHERE `name`='42' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_revenue` SET `price`=$temp_result[0]+$pB_income WHERE `name`='42' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `operating_costs` WHERE `name`='5111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_costs` SET `price`=0-$cal_array[0] WHERE `name`='5111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp=mysql_query("SELECT price FROM `operating_costs` WHERE `name`='5112' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_costs` SET `price`=0-$cal_array[1] WHERE `name`='5112' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM `current_assets` WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$cal_array[0]-$cal_array[1] WHERE `name`='114' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin+=$sum;
                                        $netin-=$sum2;
					break;
				case 'storage':
					$for_cal=mysql_query("SELECT * FROM `state` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					for($i=3;$i<12;$i++)
						$sum=$sum+$cal_array[$i];
					$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='housing_cost'" );
					$result=mysql_fetch_array($temp);
					$sum=$sum*0.5*$result[0];//原料：$0.5/每單位/回合，因為用比較簡單的算式，原料要擺在前面先算
					$for_cal=mysql_query("SELECT `batch` FROM `product_history` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
					while ($cal_array = mysql_fetch_array($for_cal)) {
						$sum=$sum+$cal_array[0]*$result[0]; //製成品：$1/每單位/回合
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `operating_expenses` WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'start_cash':
					if($year==1&&$month==1)
						$sum=20000000;
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$sum WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'break_contract':
					$temp=mysql_query("SELECT `breakA` ,`breakB`,`price` FROM `contract` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid'" );
					$result=mysql_fetch_array($temp);
					if($result[0]==1||$result[1]==1)
						$sum=$result['price'];

					for($j=0;$j<2;$j++){
						if($j==0){
							$temp=mysql_query("SELECT SUM(`signA`) FROM `contract`" );
							$result2=mysql_fetch_array($temp);
							$temp2=$result2[0];
							$temp=mysql_query("SELECT SUM(`breakA`) FROM `contract`" );
							$result2=mysql_fetch_array($temp);
							$test=$temp2-$result2[0];
						}
						elseif($j==1){
							$temp=mysql_query("SELECT SUM(`signB`) FROM `contract`" );
							$result2=mysql_fetch_array($temp);
							$temp2=$result2[0];
							$temp=mysql_query("SELECT SUM(`breakB`) FROM `contract`" );
							$result2=mysql_fetch_array($temp);
							$test=$temp2-$result2[0];
						}
						if($j==0)
							$temp=mysql_query("SELECT `month` FROM `contract` WHERE `cid`='$cid' AND `year`<$year AND `month`<=$month AND `signA`=1 ORDER BY `year` DESC" );
						elseif($j==1)
							$temp=mysql_query("SELECT `month` FROM `contract` WHERE `cid`='$cid' AND `year`<$year AND `month`<=$month AND `signB`=1 ORDER BY `year` DESC" );
						$result=mysql_fetch_array($temp);
						if($month==$result[0]&&$test>0){//一年一次只需判斷月份
							$sAmA=0;
							$sAmB=0;
							$sAmC=0;
							$sBmA=0;
							$sBmB=0;
							$sBmC=0;
							$sCmA=0;
							$sCmB=0;
							$sCmC=0;
							$temp=mysql_query("SELECT * FROM `purchase_materials` WHERE `cid` = '$cid' AND (`year`=$year AND `month`<=$month) OR (`year`=$year-1 AND `month`>=$month)" );
							while($result=mysql_fetch_array($temp)){
								$sAmA+=$result['ma_supplier_a'];
								$sAmB+=$result['mb_supplier_a'];
								$sAmC+=$result['mc_supplier_a'];
								$sBmA+=$result['ma_supplier_b'];
								$sBmB+=$result['mb_supplier_b'];
								$sBmC+=$result['mc_supplier_b'];
								$sCmA+=$result['ma_supplier_c'];
								$sCmB+=$result['mb_supplier_c'];
								$sCmC+=$result['mc_supplier_c'];
							}//過去一年買了多少原料
							for($i=0;$i<=3;$i++){//供應商A原料i訂的契約量
								$temp=mysql_query("SELECT `quantity` FROM `supplier_a` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i" );
								while($result=mysql_fetch_array($temp)){
									if($i==1)
										$sAmA_require+=$result[0];
									elseif($i==2)
										$sAmB_require+=$result[0];
									elseif($i==3)
										$sAmC_require+=$result[0];
								}
								if($sAmA<$sAmA_require)
									$sum+=$sAmA_require-$sAmA;
								elseif($sAmB<$sAmB_require)
									$sum+=$sAmB_require-$sAmB;
								elseif($sAmC<$sAmC_require)
									$sum+=$sAmC_require-$sAmC;
							}
							for($i=0;$i<=3;$i++){//供應商B原料i訂的契約量
								$temp=mysql_query("SELECT `quantity` FROM `supplier_b` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i" );
								while($result=mysql_fetch_array($temp)){
									if($i==1)
										$sBmA_require+=$result[0];
									elseif($i==2)
										$sBmB_require+=$result[0];
									elseif($i==3)
										$sBmC_require+=$result[0];
								}
								if($sBmA<$sBmA_require)
									$sum+=$sBmA_require-$sBmA;
								elseif($sBmB<$sBmB_require)
									$sum+=$sBmB_require-$sBmB;
								elseif($sBmC<$sBmC_require)
									$sum+=$sBmC_require-$sBmC;
							}
							for($i=0;$i<=3;$i++){//供應商C原料i訂的契約量
								$temp=mysql_query("SELECT `quantity` FROM `supplier_c` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i" );
								while($result=mysql_fetch_array($temp)){
									if($i==1)
										$sCmA_require+=$result[0];
									elseif($i==2)
										$sCmB_require+=$result[0];
									elseif($i==3)
										$sCmC_require+=$result[0];
								}
								if($sCmA<$sCmA_require)
									$sum+=$sCmA_require-$sCmA;
								elseif($sCmB<$sCmB_require)
									$sum+=$sCmB_require-$sCmB;
								elseif($sCmC<$sCmC_require)
									$sum+=$sCmC_require-$sCmC;
							}
						}
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `other_expenses` WHERE `name`='521' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `other_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='521' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'interest':
					$for_cal=mysql_query("SELECT `short_interest`,`long_interest` FROM `fund_raising` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$sum=$sum+$cal_array[0]+$cal_array[1];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `other_expenses` WHERE `name`='7' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `other_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='7' AND `month`=$round_now AND `cid`='$cid'" );
					
						mysql_query("UPDATE `operating_netin` SET `price`=0-$sum WHERE `name`='interest' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'cash_increase':
					$for_cal=mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
					$cal_array=mysql_fetch_array($for_cal);
					$result=mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
					$stock_price=mysql_fetch_array($result);
					if($cal_array[0]!=0)
						if($stock_price[0]!=0){
							$stocks=0;
							$capital=0;
							$capital=($stock_price[0]-10)*$cal_array[0]/$stock_price[0];
							$sum=$sum+$cal_array[0];
							$stocks=$cal_array[0]-$capital;
						}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$stocks WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='cash_increase' AND `month`=$round_now AND `cid`='$cid'" );
						
						//$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
						//$temp_result=mysql_fetch_array($temp);
						//$temp_capital=$temp_result[0];
						//if($temp_capital<$capital){
							//mysql_query("UPDATE `equity` SET `price`=$capital WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
						
							//$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
							//$temp_result=mysql_fetch_array($temp);
							//mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$capital+$temp_capital WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
						
										$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
										$temp_result=mysql_fetch_array($temp);
										mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$capital WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
						}
					break;
				case 'relationship_i':
					$dividend_cost=0;
					$for_cal=mysql_query("SELECT * FROM `relationship_decision` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `target`='investor_0' ORDER BY `year`, `month`" );
					$correspondence=mysql_query("SELECT `money` FROM correspondence WHERE `name`='investor'" );
					$correspond=mysql_fetch_array($correspondence);
					$cal_array=mysql_fetch_array($for_cal);
					if($cal_array['level']>0)
						$sum=$correspond[0];
					for($i=1;$i<$cal_array['level'];$i++)
						$sum=$sum*2;
					$for_cal = mysql_query("SELECT `dividend_cost` FROM `fund_raising` WHERE `cid`='$cid' ORDER BY `year`, `month`", $connect);
					while($cal_array = mysql_fetch_array($for_cal)){
						if ($cal_array[0] != 0)
							$dividend_cost = $dividend_cost+$cal_array[0];
					}
					$sum=$sum-($sum*$dividend_cost*0.000000001);
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'relationship_s':
                    $for_cal=mysql_query("SELECT * FROM `relationship_decision` WHERE`year`=$year AND `month`=$month AND `cid`='$cid' ORDERBY `year`, `month`" );
                        if ($for_cal != NULL) {
                            while ($cal_array = mysql_fetch_array($for_cal)){
                                $r_s = explode("_", $cal_array['target']);
                                if ($r_s[0] == "supplier") {
                                    $result=mysql_query("SELECT * FROM `order_accept` WHERE`year`=$year AND `month`=$month AND`cid`='$cid'" );
                                    $total_income=0;
                                    while($temp=mysql_fetch_array($result)){
                                        $order_no=$temp['order_no'];
                                        $total_income+=$temp['price']*$temp['quantity'];
                                        }
                                    $sum+=$total_income*$cal_array['level']*0.01;
                                }
                            }
                        }
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						
						//mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='supplier_bonus' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'relationship_e':
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'", $connect);
					$correspond = mysql_fetch_array($correspondence); //各決策所需金額對照表
					$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'", $connect);
					$correspond2 = mysql_fetch_array($correspondence);
					
					$for_cal = mysql_query("SELECT * FROM `relationship_decision` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					if ($for_cal != NULL) {
						while ($cal_array = mysql_fetch_array($for_cal)) {
							$empolyee = explode("_", $cal_array['target']);
							if ($empolyee[0] == "empolyee") {
								$result = mysql_query("SELECT * FROM current_people WHERE (`year`<$year OR (`year`=$year AND `month`<=$month)) AND `department`='$empolyee[1]' AND `cid`='$cid'", $connect);
								while ($temp = mysql_fetch_array($result)) {//先算整張表+-後有多少人
									$hire_count+=$temp['hire_count'];
									$fire_count+=$temp['fire_count'];
								}//再扣掉本回合決策的人數
								$result = mysql_query("SELECT * FROM current_people WHERE `year`=$year AND `month`=$month AND `department`='$empolyee[1]' AND `cid`='$cid'", $connect);
								$temp = mysql_fetch_array($result);
								$hire_count-=$temp['hire_count'];
								$fire_count-=$temp['fire_count'];
								$people = $hire_count - $fire_count; //即為各部門目前人數
								$hire_count = 0;
								$fire_count = 0;
								if ($empolyee[1] == "finance")//各部門薪資＆資遣費判斷，correspondence的金額對應要對
									$sum = $sum + $cal_array['level'] * 0.01 * $correspond['money2']*$people; //薪資
								elseif ($empolyee[1] == "equip")
									$sum = $sum + $cal_array['level'] * 0.01 * $correspond['money3']*$people;
								elseif ($empolyee[1] == "sale")
									$sum = $sum + $cal_array['level'] * 0.01 * $correspond2['money']*$people;
								elseif ($empolyee[1] == "human")
									$sum = $sum + $cal_array['level'] * 0.01 * $correspond2['money2']*$people;
								elseif ($empolyee[1] == "research")
									$sum = $sum + $cal_array['level'] * 0.01 * $correspond2['money3']*$people;
							}
						}
					}
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM operating_expenses WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `operating_expenses` SET `price`=$temp_result[0]-$sum WHERE `name`='525' AND `month`=$round_now AND `cid`='$cid'" );
						
						//mysql_query("UPDATE `financing_netin` SET `price`=0-$sum WHERE `name`='empolyee_bonus' AND `month`=$round_now AND `cid`='$cid'" );
					}
					$netin-=$sum;
					break;
				case 'dividend':
					$for_cal = mysql_query("SELECT `dividend_cost` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					if ($cal_array[0] != 0)
						$sum = $cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM equity WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$sum WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='dividend' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'treasury':
					$for_cal = mysql_query("SELECT `treasury` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$result = mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$temp = mysql_fetch_array($result);
					if ($cal_array[0] != 0)
						$sum = $cal_array[0]*$temp[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
						$temp=mysql_query("SELECT price FROM equity WHERE `name`='33' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `equity` SET `price`=$temp_result[0]-$sum WHERE `name`='33' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `financing_netin` SET `price`=$sum*(-1) WHERE `name`='treasury' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'AR':
					if($month-1==0)
						$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year-1 AND `month`=12 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					else $for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year AND `month`=$month-1 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					while($cal_array = mysql_fetch_array($for_cal))
						if ($cal_array[0] != 0)
							$sum+=$cal_array[0]*$cal_array[1]*0.8;
					
					if($month-2==0)
						$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year-1 AND `month`=12 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					else $for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year AND `month`=$month-2 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					while($cal_array = mysql_fetch_array($for_cal))
						if ($cal_array[0] != 0)
							$sum+=$cal_array[0]*$cal_array[1]*0.15;
					
					if($month-3==0)
						$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year-1 AND `month`=12 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					else $for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$year AND `month`=$month-3 AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`" );
					while($cal_array = mysql_fetch_array($for_cal))
						if ($cal_array[0] != 0)
							$sum+=$cal_array[0]*$cal_array[1]*0.05;
						
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='113' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='113' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						
						mysql_query("UPDATE `operating_netin` SET `price`=$sum WHERE `name`='sales_income' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'AP':
					$for_cal = mysql_query("SELECT `price` FROM `current_liabilities` WHERE `name`=213215 AND `month`=$round_now-1 AND `cid`='$cid' ORDER BY `month`", $connect);
					if($for_cal!=NULL)
						$cal_array = mysql_fetch_array($for_cal);
					if ($cal_array[0] != 0)
						$sum = $cal_array[0];
					if($sum!=0){
						$temp=mysql_query("SELECT price FROM current_liabilities WHERE `name`='213215' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_liabilities` SET `price`=$temp_result[0]-$sum WHERE `name`='213215' AND `month`=$round_now AND `cid`='$cid'" );
						
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'tax':
					$tax=$netin*0.17;
					$sum=$tax;//上期資料之前已經寫入了
					$for_cal = mysql_query("SELECT `price` FROM `current_assets` WHERE `month`=$round_now-1 AND `cid`='$cid' AND `name`=115");
					$cal_array = mysql_fetch_array($for_cal);
					if($tax>$cal_array[0])
						$tax_asset=$cal_array[0];
					else $tax_asset=$tax;
					if($sum!=0){
						if($sum>0){
							$temp=mysql_query("SELECT price FROM income_taxes WHERE `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `income_taxes` SET `price`=$temp_result[0]-$sum WHERE `month`=$round_now AND `cid`='$cid'");
							$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'");
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$tax_asset WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'" );
							if($tax-$tax_asset>0){
								$temp=mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
								$temp_result=mysql_fetch_array($temp);
								mysql_query("UPDATE `long-term_liabilities` SET `price`=$temp_result[0]+$tax-$tax_asset WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
							}
						}
						else{
							$temp=mysql_query("SELECT price FROM income_taxes WHERE `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `income_taxes` SET `price`=$temp_result[0]-$sum WHERE `month`=$round_now AND `cid`='$cid'" );
							
							$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$sum WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'" );

						}
						/*if($temp_result[0]+$sum>=0){
							$temp2=$temp_result[0]+$sum;
							$temp=mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
							$temp_result=mysql_fetch_array($temp);
							mysql_query("UPDATE `long-term_liabilities` SET `price`=$temp_result[0]+$temp2 WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
						}*/
					}
					$for_cal = mysql_query("SELECT `price` FROM `long-term_liabilities` WHERE `month`=$round_now-1 AND `cid`='$cid' AND `name`=216", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$tax_pay=$cal_array[0];
					if($month%12==1&&$tax_pay>0&&$year>1){//每年一月繳稅
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]-$tax_pay WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );

						mysql_query("UPDATE `operating_netin` SET `price`=0-$tax_pay WHERE `name`='income_tax' AND `month`=$round_now AND `cid`='$cid'" );
						/*這邊遞延所得稅資產應該都會跟應付所得稅扣抵了，所以扣應付所得稅就好了
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `current_assets` SET `price`=0 WHERE `name`='115' AND `month`=$round_now AND `cid`='$cid'" );
						*/
						$temp=mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `long-term_liabilities` SET `price`=$temp_result[0]-$tax_pay WHERE `name`='216' AND `month`=$round_now AND `cid`='$cid'" );
					}
					break;
				case 'netin':
					$sum=$netin-$tax;
					$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					$temp_result=mysql_fetch_array($temp);
					mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0] WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
					
					$cash=$temp_result[0];
					
					$temp=mysql_query("SELECT price FROM equity WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
					$temp_result=mysql_fetch_array($temp);
					mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$sum WHERE `name`='35' AND `month`=$round_now AND `cid`='$cid'" );
					
					if($month+1>12){
						mysql_query("UPDATE `cash` SET `cash`=$cash WHERE `year`=$year+1 AND `month`=1 AND `cid`='$cid'" );
						mysql_query("UPDATE `cash` SET `netin`=$netin WHERE `year`=$year+1 AND `month`=1 AND `cid`='$cid'" );
					}
					else{
						mysql_query("UPDATE `cash` SET `cash`=$cash WHERE `year`=$year AND `month`=$month+1 AND `cid`='$cid'" );
						mysql_query("UPDATE `cash` SET `netin`=$netin WHERE `year`=$year AND `month`=$month+1 AND `cid`='$cid'" );
					}
					if($round_now==1)
						mysql_query("UPDATE `cash_balance_last` SET `price`=20000000 WHERE `month`=$round_now AND `cid`='$cid'" );
					else{
						$temp=mysql_query("SELECT price FROM current_assets WHERE `name`='111' AND `month`=$round_now-1 AND `cid`='$cid'" );
						$temp_result=mysql_fetch_array($temp);
						mysql_query("UPDATE `cash_balance_last` SET `price`=$temp_result[0] WHERE `month`=$round_now AND `cid`='$cid'" );
					}
					break;
			}//end of switch
			$sum=0;//千萬記得要歸零...
		}//end of while decision_name
		$netin=0;
		//日記帳以外的，現金流量表
		//進貨付現
		$temp2=0;

		$for_cal = mysql_query("SELECT price FROM `current_liabilities` WHERE `name`='213215' AND `month`=$round_now-1 AND `cid`='$cid'");
		$cal_array = mysql_fetch_array($for_cal);
		$temp2+=$cal_array[0];            //上月應付帳款與其他應付款
		mysql_query("UPDATE `operating_netin` SET `price`=0-$temp2 WHERE `name`='purchase_product' AND `month`=$round_now AND `cid`='$cid'" );
		
		//營業費用付現
						$for_cal = mysql_query("SELECT `price` FROM `operating_expenses` WHERE `name`='518' AND `cid` = '$cid' AND `month` = $round_now");
						$cal_array=mysql_fetch_array($for_cal);
						$temp2=$cal_array[0];//處分資產損失不算... 2012/2/4 13:21
		$for_cal = mysql_query("SELECT SUM(price) FROM `operating_expenses` WHERE `cid` = '$cid' AND `month` = $round_now", $connect);
		$cal_array=mysql_fetch_array($for_cal); //加回折舊
		mysql_query("UPDATE `operating_netin` SET `price`=$cal_array[0]-$temp2+$depre WHERE `name`='operating_exp' AND `month`=$round_now AND `cid`='$cid'" );
		
		//其他費用付現
		$for_cal = mysql_query("SELECT price FROM `other_expenses` WHERE `name`='521' AND `cid` = '$cid' AND `month` = $round_now", $connect);
		$cal_array=mysql_fetch_array($for_cal);
		mysql_query("UPDATE `operating_netin` SET `price`=$cal_array[0] WHERE `name`='other_exp' AND `month`=$round_now AND `cid`='$cid'" );
		
		//判斷是否現金增資
		if($month+1>12){
			$temp=mysql_query("SELECT cash FROM `cash` WHERE `year`=$year+1 AND `month`=1 AND `cid`='$cid'" );
		}
		else{ 
			$temp=mysql_query("SELECT cash FROM `cash` WHERE `year`=$year AND `month`=$month+1 AND `cid`='$cid'" );
		}
		$temp_result=mysql_fetch_array($temp);		
		$round = ($year-1)*12 + $month;
			//在外流通股數

		//$cash = mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `year`=$year AND `month`=$month-1 AND `cid`='$cid'" );
		//$outside_stock = mysql_fetch_array($cash);	
		//$stock_carter = $outside_stock[0]/10;
		//mysql_query("INSERT INTO `outside_stock` VALUES($year, $month, '$cid', '$stock_carter')" );
		//mysql_query("UPDATE `outside_stock` outside_stock`=  $outside_stock[0]  WHERE `cid`='$cid' AND `year`=$year AND `month`=$month" );		
		
		
		if($temp_result[0]<0){
			$outstock=(20000000-$temp_result[0])/10;
       		mysql_query("UPDATE `fund_raising` SET `cash_increase`=20000000-$temp_result[0] WHERE `year`=$year AND `month`=$month AND `cid`='$cid'" );
			if($month+1>12){
				$temp=mysql_query("UPDATE `cash` SET `cash`=20000000 WHERE `year`=$year+1 AND `month`=1 AND `cid`='$cid'" );
			}
			else{ 
				$temp=mysql_query("UPDATE `cash` SET `cash`=20000000 WHERE `year`=$year AND `month`=$month+1 AND `cid`='$cid'" );
			}
			//再跑一次現金增資對報表的影響
			$for_cal=mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
			$cal_array=mysql_fetch_array($for_cal);
			$result=mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`" );
			$stock_price=mysql_fetch_array($result);
			if($cal_array[0]!=0){
				if($stock_price[0]!=0){
					$capital=$cal_array[0]/$stock_price[0]*($stock_price[0]-10);
					$sum=$sum+$cal_array[0];
					$stocks=$cal_array[0]-$capital;
				}
			}
			if($sum!=0){
				$temp=mysql_query("SELECT `price` FROM `current_assets` WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
				$temp_result=mysql_fetch_array($temp);
				mysql_query("UPDATE `current_assets` SET `price`=$temp_result[0]+$sum WHERE `name`='111' AND `month`=$round_now AND `cid`='$cid'" );
			
				$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
				$temp_result=mysql_fetch_array($temp);
				mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$stocks WHERE `name`='31' AND `month`=$round_now AND `cid`='$cid'" );
				
				mysql_query("UPDATE `financing_netin` SET `price`=$sum WHERE `name`='cash_increase' AND `month`=$round_now AND `cid`='$cid'" );
			
				
				
				$temp=mysql_query("SELECT price FROM `equity` WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
				$temp_result = mysql_fetch_array($temp);
				mysql_query("UPDATE `equity` SET `price`=$temp_result[0]+$capital WHERE `name`='32' AND `month`=$round_now AND `cid`='$cid'" );
				
			}
			$sum=0;
		}
		
		
	}//end of while(每間公司)
	
}//end of function jtp()

jtp();
		
		
?>