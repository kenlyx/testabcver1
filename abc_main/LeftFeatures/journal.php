<?php
session_start();
error_reporting(0);

function flag($count){
	if ($count % 2 == 0)
	    echo "<tr class='odd'>";
	else
		echo "<tr>";	
}

function report($month) {
	//決策位置
    $args = array("current_people" => "招解聘", "share" => "平板差異化", "share2" => "平板差異化", "donate" => "筆電差異化",
        "ad_a" => "廣告行銷A", "ad_b" => "廣告行銷B", "purchase_materials" => "購買原料", "purchase_machine" => "購買資產","sell_machine" => "處分資產",
        "product_a" => "生產筆記型電腦", "product_b" => "生產平板電腦", "process_improvement" => "流程改良", "product_plan" => "生產規劃",
        "r_d" => "產品研發", "training" => "在職訓練", "long" => "長期借款", "short" => "短期借款", "repay" => "還款", "repay2" => "還款", "storage" => "倉儲費用", 
        "start_cash" => "初始資金", "break_contract" => "違約", "interest" => "借款利息", "cash_increase" => "現金增資", "relationship_s" => "供應商關係管理", 
        "relationship_e" => "員工關係管理", "relationship_i" => "投資人關係管理", "dividend" => "現金股利", "depreciation" => "機具折舊", "depreciation_cut" => " 機具折舊", "AR" => "應收帳款", "AP" => "應付帳款", "treasury" => "買回庫藏股"); //決策項目對照
	
    $subject = array("current_people" => "薪資費用", "share" => "研究發展費用", "share2" => "研究發展費用", "donate" => "研究發展費用",
        "ad_a" => "廣告費用A", "ad_b" => "廣告費用B", "purchase_materials" => "原料存貨", "purchase_machine" => "機具", "sell_machine" => "現金", 
        "product_a" => "製成品存貨", "product_b" => "製成品存貨", "process_improvement" => "流程改良費用", "product_plan" => "機器製造費用",
        "r_d" => "研發費用", "training" => "訓練費用", "long" => "現金", "short" => "現金", "repay" => "長期借款", "repay2" => "短期借款", "storage" => "倉儲費用", 
        "start_cash" => "現金", "break_contract" => "什項費用", "interest" => "利息費用", "cash_increase" => "現金", "relationship_s" => "管理及總務費用", 
        "relationship_e" => "員工福利費用", "relationship_i" => "管理及總務費用", "dividend" => "保留盈餘", "depreciation" => "製造費用-折舊", "AR" => "現金", "AP" => "應付帳款", "treasury" => "庫藏股", "depreciation_cut" => " 機具折舊"); //會計科目對照(借)

    $subject2 = array("current_people" => "現金", "share" => "現金", "share2" => "現金", "donate" => "現金",
        "ad_a" => "現金", "ad_b" => "現金", "purchase_materials" => "應付帳款", "purchase_machine" => "現金", "sell_machine" => "機具", 
        "product_a" => "原料存貨", "product_b" => "原料存貨", "process_improvement" => "現金", "product_plan" => "現金",
        "r_d" => "現金", "training" => "現金", "long" => "應付票據", "short" => "短期借款", "repay" => "現金", "repay2" => "現金", "storage" => "現金", 
        "start_cash" => "普通股", "break_contract" => "現金", "interest" => "現金", "cash_increase" => "普通股", "relationship_s" => "現金", 
        "relationship_e" => "現金", "relationship_i" => "現金", "dividend" => "現金", "depreciation" => "累計折舊", "AR" => "應收帳款", "AP" => "現金", "treasury" => "現金", "depreciation_cut" => " 機具折舊"); //會計科目對照(貸)

    $catalog = array("current_people" => "團隊學習", "share" => "市場聚焦", "share2" => "市場聚焦", "donate" => "市場聚焦",
        "ad_a" => "市場聚焦", "ad_b" => "市場聚焦", "purchase_materials" => "價值作業", "purchase_machine" => "投入與合一", "sell_machine" => "投入與合一", 
        "product_a" => "價值作業", "product_b" => "價值作業", "process_improvement" => "價值作業", "product_plan" => "價值作業",
        "r_d" => "投入與合一", "training" => "團隊學習", "long" => "投入與合一", "short" => "投入與合一", "repay" => "投入與合一", "repay2" => "投入與合一", "storage" => "非決策", 
        "start_cash" => "非決策", "break_contract" => "投入與合一", "interest" => "非決策", "cash_increase" => "投入與合一", "relationship_s" => "謀略與關係", 
        "relationship_e" => "謀略與關係", "relationship_i" => "謀略與關係", "dividend" => "投入與合一", "depreciation" => "銷貨成本", "AR" => "非決策", "AP" => "非決策", "treasury" => "投入與合一", "depreciation_cut" => " 機具折舊"); //決策類別對照
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $cid = $_SESSION['cid'];
    $year = (integer) ($month / 12) + 1;
    $month = $month % 12;
    if ($month == 0) {
        $month = 12;
        $year--;
    }
    $sum = 0;
    $catalog_temp = "";
	$netin=0;
	//前一回合
	$month_report=($year-1)*12+$month;

//以下為固定欄位
    echo "<table align='center' cellspacing='0' class='yTable'>"; //cellspacing去掉表格間的隔線
    echo "<thead><tr align='center'><td colspan=13><b>日記帳</b></td>";
    echo "<tr style='background-color: white'><th width = 80>第" . $year . "年</th>";
    echo "<th width =120 colspan='2'>會計科目</th><th width = 80>借方</th><th width = 80>貸方</th><th colspan='2' style='text-align:center'>決策</th></tr></thead>";
    echo "<tr style='color:#ff3030'>
			<th>" . $month . "月份</th>
			<td colspan='2'></td><td></td><td></td>
			<th width = 100>決策類別</th>
			<th width = 100>決策項目</th>
		  </tr>";

    $journal = mysql_query("SELECT * FROM journal ORDER BY `index`", $connect);
   	
    while ($decision_name = mysql_fetch_array($journal)) {
        switch ($decision_name['name']) {
            case 'current_people'://招聘的300元＆薪資＆資遣費
                $department = array("0" => "finance", "1" => "equip", "2" => "sale", "3" => "human", "4" => "research"); //資料庫的部門名稱改的話直接改這裡就好
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'", $connect);
                $correspond = mysql_fetch_array($correspondence); //各決策所需金額對照表
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
				$hire_count = 0;
				$fire_count = 0;
                for ($i = 0; $i < 5; $i++) {
                    $result = mysql_query("SELECT * FROM current_people WHERE (`year`<$year OR (`year`=$year AND `month`<=$month)) AND `department`='$department[$i]' AND `cid`='$cid'", $connect);
                    while ($temp = mysql_fetch_array($result)) {//先算整張表+-後有多少人
                        $hire_count+=$temp['hire_count'];
                        $fire_count+=$temp['fire_count'];
                    }//再扣掉本回合決策的人數
                    $result = mysql_query("SELECT * FROM current_people WHERE `year`=$year AND `month`=$month AND `department`='$department[$i]' AND `cid`='$cid'", $connect);
                    $temp = mysql_fetch_array($result);
					$sum = $sum + $temp['hire_count']*$correspond['money'];
                    $hire_count-=$temp['hire_count'];
                    $fire_count-=$temp['fire_count'];
                    $people = $hire_count - $fire_count; //即為各部門目前人數
                    if ($department[$i] == "finance") {//各部門薪資＆資遣費判斷，correspondence的金額對應要對
                        $sum = $sum + $people * $correspond['money2']; //薪資
                        $sum = $sum + $temp['fire_count'] * $correspond['money2'] * 3;//資遣費
                    } elseif ($department[$i] == "equip") {
                        $sum = $sum + $people * $correspond['money3'];
                        $sum = $sum + $temp['fire_count'] * $correspond['money3'] * 3;
                    } elseif ($department[$i] == "sale") {
                        $sum = $sum + $people * $correspond2['money'];
                        $sum = $sum + $temp['fire_count'] * $correspond2['money'] * 3;
                    } elseif ($department[$i] == "human") {
                        $sum = $sum + $people * $correspond2['money2'];
                        $sum = $sum + $temp['fire_count'] * $correspond2['money2'] * 3;
                    } elseif ($department[$i] == "research") {
                        $sum = $sum + $people * $correspond2['money3'];
                        $sum = $sum + $temp['fire_count'] * $correspond2['money3'] * 3;
                    }
                    $hire_count = 0;
                    $fire_count = 0;
                }
				$netin-=$sum;
                break;
            case 'share':
                $for_cal = mysql_query("SELECT * FROM `share` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share1'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share3'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
                $cal_array = mysql_fetch_array($for_cal);
                if ($cal_array['decision1'] == 1)
                    $sum = $sum + $correspond['money'];
                elseif ($cal_array['decision1'] == 2)
                    $sum = $sum + $correspond['money2'];
                elseif ($cal_array['decision1'] == 3)
                    $sum = $sum + $correspond['money3'];
                if ($cal_array['decision3'] == 1)
                    $sum = $sum + $correspond2['money'];
                elseif ($cal_array['decision3'] == 2)
                    $sum = $sum + $correspond2['money2'];
                elseif ($cal_array['decision3'] == 3)
                    $sum = $sum + $correspond2['money3'];
				$netin-=$sum;
                break;
            case 'share2':
                $for_cal = mysql_query("SELECT * FROM `share` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='share2'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $cal_array = mysql_fetch_array($for_cal);
                if ($cal_array['decision2'] == 1)
                    $sum = $sum + $correspond['money'];
                elseif ($cal_array['decision2'] == 2)
                    $sum = $sum + $correspond['money2'];
                elseif ($cal_array['decision2'] == 3)
                    $sum = $sum + $correspond['money3'];
				$netin-=$sum;
                break;	
            case 'donate':
                $for_cal = mysql_query("SELECT * FROM `donate` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    for ($i = 1; $i < 4; $i++)
                        if ($cal_array['decision' . $i] == 1)
                            $sum = $sum + $correspond['money'];
                        elseif ($cal_array['decision' . $i] == 2)
                            $sum = $sum + $correspond['money2'];
                        elseif ($cal_array['decision' . $i] == 3)
                            $sum = $sum + $correspond['money3'];
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
                for ($i = 1; $i < 4; $i++)
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
                for ($i = 1; $i < 4; $i++)
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
				$netin-=$sum;
                break;
            case 'purchase_materials':
                $for_cal = mysql_query("SELECT * FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $purchase_materials_price=mysql_query("SELECT * FROM `purchase_materials_price` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $materials_price = mysql_fetch_array($purchase_materials_price);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    $sum = $sum + $cal_array['ma_supplier_a'] * $materials_price['ma_supplier_a'] + $cal_array['ma_supplier_b'] * $materials_price['ma_supplier_b'] + $cal_array['ma_supplier_c'] * $materials_price['ma_supplier_c'];
                    $sum = $sum + $cal_array['mb_supplier_a'] * $materials_price['mb_supplier_a'] + $cal_array['mb_supplier_b'] * $materials_price['mb_supplier_b'] + $cal_array['mb_supplier_c'] * $materials_price['mb_supplier_c'];
                    $sum = $sum + $cal_array['mc_supplier_a'] * $materials_price['mc_supplier_a'] + $cal_array['mc_supplier_b'] * $materials_price['mc_supplier_b'] + $cal_array['mc_supplier_c'] * $materials_price['mc_supplier_c'];
                }
                break;
            case 'purchase_machine':
                $for_cal = mysql_query("SELECT * FROM `machine` WHERE `buy_year`=$year AND `buy_month`=$month AND `cid`='$cid' ORDER BY `index`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_cut'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine1'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine2'", $connect);
                $correspond3 = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_detect'", $connect);
                $correspond4 = mysql_fetch_array($correspondence);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    if ($cal_array['function'] == "cut") {
                        if ($cal_array['type'] == "A")$sum = $sum + $correspond['money'];
                        else if ($cal_array['type'] == "B")$sum = $sum + $correspond['money2'];
                        else if ($cal_array['type'] == "C")$sum = $sum + $correspond['money3'];
                    }
                    else if ($cal_array['function'] == "combine1") {
                        if ($cal_array['type'] == "A")$sum = $sum + $correspond2['money'];
                        else if ($cal_array['type'] == "B")$sum = $sum + $correspond2['money2'];
                        else if ($cal_array['type'] == "C")$sum = $sum + $correspond2['money3'];
                    }
                    else if ($cal_array['function'] == "combine2") {
                        if ($cal_array['type'] == "A")$sum = $sum + $correspond3['money'];
                        else if ($cal_array['type'] == "B")$sum = $sum + $correspond3['money2'];
                        else if ($cal_array['type'] == "C")$sum = $sum + $correspond3['money3'];
                    }
                    else if ($cal_array['function'] == "detect") {
                        if ($cal_array['type'] == "A")$sum = $sum + $correspond4['money'];
                        else if ($cal_array['type'] == "B")$sum = $sum + $correspond4['money2'];
                        else if ($cal_array['type'] == "C")$sum = $sum + $correspond4['money3'];
                    }
                }
                break;
            case 'sell_machine':
				$depreciation=0;
				$sell_cash=0;
				$sell_lost=0;
				$machine=0;
				$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='depreciation'",$connect);
				$result=mysql_fetch_array($temp);
				//機器折舊120月
				$for_cal=mysql_query("SELECT * FROM `machine` WHERE `sell_year`=$year AND `sell_month`=$month AND `cid`='$cid' ORDER BY `sell_year`,`sell_month`",$connect);
				
				$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_cut'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine1'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_combine2'", $connect);
                $correspond3 = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='machine_detect'", $connect);
                $correspond4 = mysql_fetch_array($correspondence);
				while($cal_array=mysql_fetch_array($for_cal)){
					//第幾回合買&賣機具
					$buyround=($cal_array['buy_year']-1)*12+$cal_array['buy_month'];
					$sellround=($cal_array['sell_year']-1)*12+$cal_array['sell_month'];
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
					$sum=$sum+$machine;
					if($sellround-$buyround>0){
						$depreciation=$machine*($sellround-$buyround)/$result[0];
						$sell_cash=($machine-$depreciation)*0.7;
						$sell_lost=$machine-$depreciation-$sell_cash;
					}
                }
					$netin-=$sell_lost;
                break;
            case 'product_a':
                $for_cal = mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_ma'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mb'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mc'", $connect);
                $correspond3 = mysql_fetch_array($correspondence);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    $sum = $sum + $cal_array['ma_supplier_a'] * $correspond['money'] + $cal_array['ma_supplier_b'] * $correspond['money2'] + $cal_array['ma_supplier_c'] * $correspond['money3'];
                    $sum = $sum + $cal_array['mb_supplier_a'] * $correspond2['money'] + $cal_array['mb_supplier_b'] * $correspond2['money2'] + $cal_array['mb_supplier_c'] * $correspond2['money3'];
                    $sum = $sum + $cal_array['mc_supplier_a'] * $correspond3['money'] + $cal_array['mc_supplier_b'] * $correspond3['money2'] + $cal_array['mc_supplier_c'] * $correspond3['money3'];
                }
                break;
            case 'product_b':
                $for_cal = mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_ma'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='purchase_materials_mb'", $connect);
                $correspond2 = mysql_fetch_array($correspondence);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    $sum = $sum + $cal_array['ma_supplier_a'] * $correspond['money'] + $cal_array['ma_supplier_b'] * $correspond['money2'] + $cal_array['ma_supplier_c'] * $correspond['money3'];
                    $sum = $sum + $cal_array['mb_supplier_a'] * $correspond2['money'] + $cal_array['mb_supplier_b'] * $correspond2['money2'] + $cal_array['mb_supplier_c'] * $correspond2['money3'];
                }
                break;
            case 'process_improvement':
                $for_cal = mysql_query("SELECT * FROM `process_improvement` WHERE `month`=$month_report AND `cid`='$cid' ORDER BY `index`", $connect);
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
				$netin-=$sum;
                break;
            case 'product_plan':
				$for_cal = mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
				$for_cal = mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array2 = mysql_fetch_array($for_cal);
				if($cal_array['ma_supplier_a']+$cal_array['ma_supplier_b']+$cal_array['ma_supplier_c']+$cal_array2['ma_supplier_a']+$cal_array2['ma_supplier_b']+$cal_array2['ma_supplier_c']>0){
					$for_cal = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$depreciation = $cal_array['product_A_depreciation']+$cal_array['product_B_depreciation'];//+$cal_array['notuse_cut_depreciation']+$cal_array['notuse_combine1_depreciation']+$cal_array['notuse_detect1_depreciation']+$cal_array['notuse_combine2_depreciation']+$cal_array['notuse_detect2_depreciation'];
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
					$sum=$overhead-$detect_labor-$depreciation;
					$for_cal = mysql_query("SELECT product_A_direct_labor, product_B_direct_labor FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
					$cal_array = mysql_fetch_array($for_cal);
					$direct_labor=$cal_array[0]+$cal_array[1];
				}
				$netin+=$direct_labor;
				break;
				 
				case 'depreciation':
					$get_cutprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
    				$cutprice=mysql_fetch_array($get_cutprice);
					$get_com1price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
  					$com1price=mysql_fetch_array($get_com1price);
					$get_com2price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
    				$com2price=mysql_fetch_array($get_com2price);
					$get_detprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
   					$detprice=mysql_fetch_array($get_detprice);
	
					$type=array('A'=>1,'B'=>2,'C'=>3);
					
					//公司目前有的機具，不計算本回合機具
					$sql_machine=mysql_query("SELECT * FROM `machine` WHERE `cid`='$cid' and `sell_month`='99' and ((`buy_year`-1)*12+`buy_month`)<=$month_report ORDER BY `machine`.`index` ASC");
    				$rows_m = mysql_num_rows($sql_machine);
					if($rows_m!=0){
						$i=0;
						while($machine=mysql_fetch_array($sql_machine)){
							//get machine detail
							//$machine_num[$i]=$machine['index'];
							$machine_func[$i]=$machine['function'];
							$machine_type[$i]=$machine['type'];
							$machine_by[$i]=$machine['buy_year'];
							$machine_bm[$i]=$machine['buy_month'];
							$round_buy=($machine_by[$i]-1)*12+$machine_bm[$i];
							
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
							}
							
							/*//購買價格、累計折舊
							if($machine_func[$i]=='cut'){
								$cutp=$cutprice[$type[$machine_type[$i]]];
								$depre+=$cutp*($month_report-$round_buy)/120;
							}else if($machine_func[$i]=='combine1'){
								$com1p=$com1price[$type[$machine_type[$i]]];
								$depre+=$com1p*($month_report-$round_buy)/120;
							}else if($machine_func[$i]=='combine2'){
								$com2p=$com2price[$type[$machine_type[$i]]];
								$depre+=$com2p*($month_report-$round_buy)/120;
							}else if($machine_func[$i]=='detect'){
								$detp=$detprice[$type[$machine_type[$i]]];
								$depre+=$detp*($month_report-$round_buy)/120;
							}*/
						}//end while	
					}//end if
				$sum=$depre; //當月總折舊	
				break;
			
			
			case 'depreciation_cut':
	//原料
	

	$A = "A";
	$B = "B";
	$C = "C";
	$sql=mysql_query("SELECT type FROM `machine` WHERE `cid`='$cid' and `function`='cut' and `sell_month`='99'");
						$result = mysql_fetch_row($sql);
							if($result[0]==$A){
								$cutaaa=0.25;
							}
							elseif($result[0]==$B){
								
								$cutaaa=0.26;
							}
							elseif($result[0]==$C){
								$cutaaa=0.27;
							}
	$com1_level=mysql_query("SELECT type FROM `machine` WHERE `cid`='$cid' and `function`='combine1' and `sell_month`='99'");
						$com1_test = mysql_fetch_row($com1_level);
						if($com1_test[0]==$A){
							$com1aaa=8.33;
						}
						else if($com1_test[0]==$B){
							$com1aaa=8.33;
						}
						else if($com1_test[0]==$C){
							$com1aaa=8.33;
						}
	$com2_level=mysql_query("SELECT type FROM `machine` WHERE `cid`='$cid' and `function`='combine2' and `sell_month`='99'");
						$com2_test = mysql_fetch_row($com2_level);
						if($com2_test[0]==$A){
							$com2aaa=11.9;
						}
						else if($com2_test[0]==$B){
							$com2aaa=12.5;
						}
						elseif ($com2_test[0]==$C){
							$com2aaa=13.33;
						}
							
                $for_cal = mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    $sum1 = ($sum + $cal_array['ma_supplier_a']+$cal_array['ma_supplier_b']+$cal_array['ma_supplier_c'])*$cutaaa*4;
                    $sum2 = ($sum + $cal_array['mb_supplier_a']+$cal_array['mb_supplier_b']+$cal_array['mb_supplier_c'])*$com1aaa/4;
                    $sum3 = ($sum + $cal_array['mc_supplier_a']+$cal_array['mc_supplier_b']+$cal_array['mc_supplier_c'])*$com2aaa/4;
                }

					//機具
					$get_cutprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
    				$cutprice=mysql_fetch_array($get_cutprice);
					$get_com1price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
  					$com1price=mysql_fetch_array($get_com1price);
					$get_com2price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
    				$com2price=mysql_fetch_array($get_com2price);
					$get_detprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
   					$detprice=mysql_fetch_array($get_detprice);
	
					$type=array('A'=>1,'B'=>2,'C'=>3);
					
					
					//公司目前有的機具，不計算本回合機具
					$sql_machine=mysql_query("SELECT * FROM `machine` WHERE `cid`='$cid' and `sell_month`='99' and ((`buy_year`-1)*12+`buy_month`)<=$month_report ORDER BY `machine`.`index` ASC");
    				$rows_m = mysql_num_rows($sql_machine);
					if($rows_m!=0){
						$i=0;
						while($machine=mysql_fetch_array($sql_machine)){
							//get machine detail
							//$machine_num[$i]=$machine['index'];
							$machine_func[$i]=$machine['function'];
							$machine_type[$i]=$machine['type'];
							$machine_by[$i]=$machine['buy_year'];
							$machine_bm[$i]=$machine['buy_month'];
							$round_buy=($machine_by[$i]-1)*12+$machine_bm[$i];
							
							if($machine_func[$i]=='cut'){
								$cutp=$cutprice[$type[$machine_type[$i]]];
								$depre_cut+=$cutp/120;
							}else if($machine_func[$i]=='combine1'){
								$com1p=$com1price[$type[$machine_type[$i]]];
								$depre_combine1+=$com1p/120;
							}else if($machine_func[$i]=='combine2'){
								$com2p=$com2price[$type[$machine_type[$i]]];
								$depre_combine2+=$com2p/120;
							}else if($machine_func[$i]=='detect'){
								$detp=$detprice[$type[$machine_type[$i]]];
								$depre_detect+=$detp/120;
							}
						}
					}
					$sum=$depre; //當月總折舊	
					break;
            case 'r_d':
                $for_cal=mysql_query("SELECT SUM(product_A_RD),SUM(product_B_RD) FROM `state` WHERE `year`<=$year AND `month`<='$month' AND `cid`='$cid' ORDER BY `month`",$connect);
                $cal_array = mysql_fetch_array($for_cal);
				$for_cal=mysql_query("SELECT product_A_RD,product_B_RD FROM `state` WHERE `year`=$year AND `month`='$month' AND `cid`='$cid' ORDER BY `month`",$connect);
                $cal_array2 = mysql_fetch_array($for_cal);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'", $connect);
                $correspond = mysql_fetch_array($correspondence);
				if(($cal_array[0]==1&&$cal_array2[0])||($cal_array[1]==1&&$cal_array2[1]))
					$sum = $correspond['money'];
				$netin-=$sum;
                break;
            case 'training':
                $for_cal = mysql_query("SELECT * FROM `training` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='$decision_name[name]'", $connect);
                $correspond = mysql_fetch_array($correspondence);
                while ($cal_array = mysql_fetch_array($for_cal)) {
                    for ($i = 1; $i < 6; $i++)
                        if ($cal_array['decision' . $i] == 1)
                            $sum = $sum + $correspond['money'];
                        elseif ($cal_array['decision' . $i] == 2)
                            $sum = $sum + $correspond['money2'];
                        elseif ($cal_array['decision' . $i] == 3)
                            $sum = $sum + $correspond['money3'];
                }
				$netin-=$sum;
                break;
            case 'long':
                $for_cal = mysql_query("SELECT `long` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                $sum = $cal_array['long'];
                break;
            case 'short':
                $for_cal = mysql_query("SELECT `short` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                $sum = $cal_array[0];
                break;
            case 'repay':
                $for_cal = mysql_query("SELECT `repay` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                $sum = $cal_array[0];
                break;
            case 'repay2':
                $for_cal = mysql_query("SELECT `repay2` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                $sum = $cal_array[0];
                break;
            case 'order':
					$result=mysql_query("SELECT * FROM `order_accept` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`",$connect);
					while($temp=mysql_fetch_array($result)){
						$order_no=$temp['order_no'];
						$type=explode("_",$order_no);//拆字串判斷產品AB
						if($type[1]=='A')
							$pA_income+=$temp['price']*$temp['quantity'];
						elseif($type[1]=='B')
							$pB_income+=$temp['price']*$temp['quantity'];
						$sum=$pA_income+$pB_income;
					}
                $for_cal = mysql_query("SELECT product_A_COGS, product_B_COGS FROM `production_cost` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                    $sum2+=$cal_array[0] + $cal_array[1];
				$netin+=$sum;
				$netin-=$sum2;
                break;
            case 'storage':
                $for_cal=mysql_query("SELECT * FROM `state` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array=mysql_fetch_array($for_cal);
                for ($i=3;$i<12;$i++)
                    $sum=$sum+$cal_array[$i];
				$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='housing_cost'",$connect);
				$result=mysql_fetch_array($temp);
                $sum=$sum*0.5*$result[0];//原料：$0.5/每單位/回合，因為用比較簡單的算式，原料要擺在前面先算
				$for_cal=mysql_query("SELECT `batch` FROM `product_history` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`",$connect);
				while ($cal_array = mysql_fetch_array($for_cal)) {
                    $sum=$sum+$cal_array[0]*$result[0]; //製成品：$1/每單位/回合
                }
				$netin-=$sum;
                break;
            case 'start_cash':
                if ($year == 1 && $month == 1)
                    $sum = 20000000;
                break;
            case 'break_contract':
                $temp = mysql_query("SELECT `breakA` ,`breakB`,`price` FROM `contract` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'", $connect);
                $result = mysql_fetch_array($temp);
                if ($result[0] == 1 || $result[1] == 1)
                    $sum = $result['price'];

                for ($j = 0; $j < 2; $j++) {
                    if ($j == 0) {
                        $temp = mysql_query("SELECT SUM(`signA`) FROM `contract`", $connect);
                        $result2 = mysql_fetch_array($temp);
                        $temp2 = $result2[0];
                        $temp = mysql_query("SELECT SUM(`breakA`) FROM `contract`", $connect);
                        $result2 = mysql_fetch_array($temp);
                        $test = $temp2 - $result2[0];
                    } elseif ($j == 1) {
                        $temp = mysql_query("SELECT SUM(`signB`) FROM `contract`", $connect);
                        $result2 = mysql_fetch_array($temp);
                        $temp2 = $result2[0];
                        $temp = mysql_query("SELECT SUM(`breakB`) FROM `contract`", $connect);
                        $result2 = mysql_fetch_array($temp);
                        $test = $temp2 - $result2[0];
                    }
                    if ($j == 0)
                        $temp = mysql_query("SELECT `month` FROM `contract` WHERE `cid`='$cid' AND `year`<$year AND `month`<=$month AND `signA`=1 ORDER BY `year` DESC", $connect);
                    elseif ($j == 1)
                        $temp = mysql_query("SELECT `month` FROM `contract` WHERE `cid`='$cid' AND `year`<$year AND `month`<=$month AND `signB`=1 ORDER BY `year` DESC", $connect);
                    $result = mysql_fetch_array($temp);
                    if ($month == $result[0] && $test > 0) {//一年一次只需判斷月份
                        $sAmA = 0;
                        $sAmB = 0;
                        $sAmC = 0;
                        $sBmA = 0;
                        $sBmB = 0;
                        $sBmC = 0;
                        $sCmA = 0;
                        $sCmB = 0;
                        $sCmC = 0;
                        $sAmA_require = 0;
                        $sAmB_require = 0;
                        $sAmC_require = 0;
                        $sBmA_require = 0;
                        $sBmB_require = 0;
                        $sBmC_require = 0;
                        $sCmA_require = 0;
                        $sCmB_require = 0;
                        $sCmC_require = 0;
                        $temp = mysql_query("SELECT * FROM `purchase_materials` WHERE `cid` = '$cid' AND (`year`=$year AND `month`<=$month) OR (`year`=$year-1 AND `month`>=$month)", $connect);
                        while ($result = mysql_fetch_array($temp)) {
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
                        for ($i = 0; $i <= 3; $i++) {//供應商A原料i訂的契約量
                            $temp = mysql_query("SELECT `quantity` FROM `supplier_a` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i", $connect);
                            while ($result = mysql_fetch_array($temp)) {
                                if ($i == 1)
                                    $sAmA_require+=$result[0];
                                elseif ($i == 2)
                                    $sAmB_require+=$result[0];
                                elseif ($i == 3)
                                    $sAmC_require+=$result[0];
                            }
                            if ($sAmA < $sAmA_require)
                                $sum+=$sAmA_require - $sAmA;
                            elseif ($sAmB < $sAmB_require)
                                $sum+=$sAmB_require - $sAmB;
                            elseif ($sAmC < $sAmC_require)
                                $sum+=$sAmC_require - $sAmC;
                        }
                        for ($i = 0; $i <= 3; $i++) {//供應商B原料i訂的契約量
                            $temp = mysql_query("SELECT `quantity` FROM `supplier_b` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i", $connect);
                            while ($result = mysql_fetch_array($temp)) {
                                if ($i == 1)
                                    $sBmA_require+=$result[0];
                                elseif ($i == 2)
                                    $sBmB_require+=$result[0];
                                elseif ($i == 3)
                                    $sBmC_require+=$result[0];
                            }
                            if ($sBmA < $sBmA_require)
                                $sum+=$sBmA_require - $sBmA;
                            elseif ($sBmB < $sBmB_require)
                                $sum+=$sBmB_require - $sBmB;
                            elseif ($sBmC < $sBmC_require)
                                $sum+=$sBmC_require - $sBmC;
                        }
                        for ($i = 0; $i <= 3; $i++) {//供應商C原料i訂的契約量
                            $temp = mysql_query("SELECT `quantity` FROM `supplier_c` WHERE `cid` = '$cid' AND `accept`=1 AND `source`=$i", $connect);
                            while ($result = mysql_fetch_array($temp)) {
                                if ($i == 1)
                                    $sCmA_require+=$result[0];
                                elseif ($i == 2)
                                    $sCmB_require+=$result[0];
                                elseif ($i == 3)
                                    $sCmC_require+=$result[0];
                            }
                            if ($sCmA < $sCmA_require)
                                $sum+=$sCmA_require - $sCmA;
                            elseif ($sCmB < $sCmB_require)
                                $sum+=$sCmB_require - $sCmB;
                            elseif ($sCmC < $sCmC_require)
                                $sum+=$sCmC_require - $sCmC;
                        }
                    }
                }
				$netin-=$sum;
                break;
            case 'interest':
                $for_cal = mysql_query("SELECT `short_interest`,`long_interest` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                $cal_array = mysql_fetch_array($for_cal);
                $sum = $sum + $cal_array[0] + $cal_array[1];
				$netin-=$sum;
                break;
            case 'cash_increase':
                $for_cal = mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                if ($for_cal != NULL) {
                    $cal_array = mysql_fetch_array($for_cal);
                    $result = mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                    $stock_price = mysql_fetch_array($result);
                    if ($cal_array[0] != 0)
                        if ($stock_price[0] != 0) {
                            $capital = ($stock_price[0]-10)*$cal_array[0]/$stock_price[0];
                            $sum = $sum + $cal_array[0];
                            $stocks = $cal_array[0] - $capital;
                        }
                }
                break;
            case 'relationship_i':
				$dividend_cost=0;
                $for_cal = mysql_query("SELECT * FROM `relationship_decision` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `target`='investor_0' ORDER BY `year`, `month`", $connect);
                $correspondence = mysql_query("SELECT `money` FROM correspondence WHERE `name`='investor'", $connect);
                $correspond = mysql_fetch_array($correspondence);
				$cal_array = mysql_fetch_array($for_cal);
				if($cal_array['level']>0)
                    $sum = $correspond[0];
				for ($i = 1; $i < $cal_array['level']; $i++)
					$sum = $sum * 2;
                $for_cal = mysql_query("SELECT `dividend_cost` FROM `fund_raising` WHERE `cid`='$cid' ORDER BY `year`, `month`", $connect);
				while($cal_array = mysql_fetch_array($for_cal)){
					if ($cal_array[0] != 0)
						$dividend_cost = $dividend_cost+$cal_array[0];
				}
				$sum=$sum-($sum*$dividend_cost*0.000000001);
				
				$netin-=$sum;
                break;
            case 'relationship_s':
                $for_cal = mysql_query("SELECT * FROM `relationship_decision` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
                if ($for_cal != NULL) {
                    while ($cal_array = mysql_fetch_array($for_cal)){
							$r_s = explode("_", $cal_array['target']);
                        if ($r_s[0] == "supplier") {
							if($month-1==0&&$year>1)
								$result = mysql_query("SELECT * FROM `order_accept` WHERE `year`=$year-1 AND `month`=12 AND `cid`='$cid'", $connect);
							else $result = mysql_query("SELECT * FROM `order_accept` WHERE `year`=$year AND `month`=$month-1 AND `cid`='$cid'", $connect);
							$total_income = 0;
							while ($temp = mysql_fetch_array($result)) {
								$order_no = $temp['order_no'];
								$total_income+=$temp['price'] * $temp['quantity'];
							}
							$sum += $total_income * $cal_array['level'] * 0.01;
						}
					}
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
							while ($temp = mysql_fetch_array($result)) {//先算整張表這個月前+-後有多少人
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
				$netin-=$sum;
                break;
            case 'dividend':
                $for_cal = mysql_query("SELECT `dividend_cost` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
				$cal_array = mysql_fetch_array($for_cal);
				if ($cal_array[0] != 0)
					$sum = -$cal_array[0];
                break;
            case 'treasury':
                $for_cal = mysql_query("SELECT `treasury` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
				$cal_array = mysql_fetch_array($for_cal);
                $result = mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
				$temp = mysql_fetch_array($result);
				if ($cal_array[0] != 0)
					$sum = $cal_array[0]*$temp[0];
                break;
            case 'AR':
				$order_month=($month_report-1)%12;
				$order_year=(int)(($month_report-1)/12+1);
         		    if($order_month==0){
                        $order_month=12;
                        $order_year--;
                    }
				$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$order_year AND `month`=$order_month AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`",$connect);
				while($cal_array = mysql_fetch_array($for_cal))
					if ($cal_array[0] != 0)
						$sum+=$cal_array[0]*$cal_array[1]*0.8;
				
				$order_month=($month_report-2)%12;
				$order_year=(int)(($month_report-2)/12+1);
				    if($order_month==0){
                        $order_month=12;
                        $order_year--;
                    }
				$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$order_year AND `month`=$order_month AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`",$connect);
				while($cal_array = mysql_fetch_array($for_cal))
					if ($cal_array[0] != 0)
						$sum+=$cal_array[0]*$cal_array[1]*0.15;
				
				$order_month=($month_report-3)%12;
				$order_year=(int)(($month_report-3)/12+1);
			    	if($order_month==0){
                        $order_month=12;
                        $order_year--;
                    }
				$for_cal=mysql_query("SELECT price,quantity FROM `order_accept` WHERE `year`=$order_year AND `month`=$order_month AND `cid`='$cid' AND `accept`=1 ORDER BY `year`, `month`",$connect);
				while($cal_array = mysql_fetch_array($for_cal))
					if ($cal_array[0] != 0)
						$sum+=$cal_array[0]*$cal_array[1]*0.05;
                break;
            case 'AP':
				$for_cal = mysql_query("SELECT `price` FROM `current_liabilities` WHERE `name`=213215 AND `month`=$month_report-1 AND `cid`='$cid' ORDER BY `month`", $connect);
				if($for_cal!=NULL)
					$cal_array = mysql_fetch_array($for_cal);
				if ($cal_array[0] != 0)
					$sum = $cal_array[0];
                break;
			case 'tax':
				$tax=$netin*0.17;
				$sum=$tax;
				//$tax_asset=$tax;
				$for_cal = mysql_query("SELECT `price` FROM `current_assets` WHERE `month`=$month_report-1 AND `cid`='$cid' AND `name`=115", $connect);
                $cal_array = mysql_fetch_array($for_cal);
				if($tax>$cal_array[0])
					$tax_asset=$cal_array[0];
				else $tax_asset=$tax;
				$for_cal = mysql_query("SELECT `price` FROM `long-term_liabilities` WHERE `month`=$month_report-1 AND `cid`='$cid' AND `name`=216", $connect);
                $cal_array = mysql_fetch_array($for_cal);
				if($month==1)
					$tax_pay=$cal_array[0];
                break;
			case 'netin':
				$sum=$netin-$tax;
                break;
        }//end case
		$flag=1;	
        if ($sum != 0) {//0代表無異動，不顯示 && $decision_name['name'] != "product_a"
            if ($decision_name['name'] == "order") {
                //同種決策類別只顯示一次
				if ($catalog_temp != $catalog[$decision_name['name']]){
                    $flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>應收帳款</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td>市場聚焦</td><td>訂單</td></tr>";
				}else{
					$flag++;
					flag($flag); 
					echo "<td></td><td style='text-align:left;border-right:0px;'>應收帳款</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td><td>訂單</td></tr>";
				}
				$flag++;
				flag($flag);
                echo $tr."<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>銷貨收入</td><td></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>銷貨成本</td><td style='text-align:right'>" . number_format($sum2) . "</td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>製成品存貨</td><td></td><td style='text-align:right'>" . number_format($sum2) . "</td><td></td><td></td></tr>";
                $catalog_temp = $catalog[$decision_name['name']];
            }
            elseif ($decision_name['name'] == "sell_machine") {
			    if ($catalog_temp != $catalog[$decision_name['name']]){//同種決策類別只顯示一次
                    $flag++;
					flag($flag);
                    echo "<td></td><td style='text-align:left;border-right:0px'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sell_cash) . "</td><td></td><td>" . $catalog[$decision_name['name']] . "</td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}else{ 
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sell_cash) . "</td><td></td><td></td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}
				$flag++;
				flag($flag);
              		echo "<td></td><td style='text-align:left;border-right:0px;'>累積折舊</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($depreciation) . "</td><td></td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='text-align:left;border-right:0px;'>處分損失</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($sell_lost) . "</td><td></td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($machine) . "</td><td></td><td></td></tr>";
                $catalog_temp = $catalog[$decision_name['name']];
            }
			//ok
            elseif ($decision_name['name'] == "product_plan") {
                if ($catalog_temp != $catalog[$decision_name['name']]){//同種決策類別只顯示一次
                    $flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>" . $subject[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td>" . $catalog[$decision_name['name']] . "</td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}else{
					$flag++;
					flag($flag);	 
					echo "<td></td><td style='text-align:left;border-right:0px;'>" . $subject[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}//end if
                $flag++;	
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='text-align:left;border-right:0px;'>製成品</td><td></td><td style='text-align:right'>" . number_format($direct_labor) . "</td><td></td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>薪資費用</td><td></td><td style='text-align:right'>" . number_format($direct_labor) . "</td><td></td><td></td></tr>";
			
				$flag++;
				flag($flag);
				echo "<td></td><td style='text-align:left;border-right:0px;'>製造費用-折舊</td><td></td><td style='text-align:right'>" . number_format($depreciation) . "</td><td></td><td></td><td></td></tr>";
				$flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>累計折舊</td><td></td><td style='text-align:right'>" . number_format($depreciation) . "</td><td></td><td></td></tr>";
				$flag++;
				flag($flag);
				echo "<td></td><td style='text-align:left;border-right:0px;'>製造費用-間接人工</td><td></td><td style='text-align:right'>" . number_format($detect_labor) . "</td><td></td><td></td><td></td></tr>";
                $flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>現金</td><td></td><td style='text-align:right'>" . number_format($detect_labor) . "</td><td></td><td></td></tr>";
				$catalog_temp = $catalog[$decision_name['name']];
            }
			//new machine
            elseif ($decision_name['name'] == "depreciation_cut") {
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>存貨______(面板)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($sum1) . "</td><td></td><td></td><td>" . $args[$decision_name['name']] . "</td></tr>";
					$flag++;
					flag($flag);
					
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>管理總務成本(cut)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_cut-$sum1) . "</td><td></td><td></td><td></td></tr>";
		 			$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;color: #a9a9a9'>累計折舊(cut)</td><td></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_cut) . "</td><td></td><td></td></tr>";
                   	$flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>存貨_____(主機板)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($sum2) . "</td><td></td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>管理總務成本(組一)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_combine1-$sum2) . "</td><td></td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;color: #a9a9a9'>累計折舊(組一)</td><td></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_combine1) . "</td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>存貨_______(鍵盤)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($sum3) . "</td><td></td><td></td><td></td></tr>";
					$flag++;
					flag($flag);

									echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>管理總務成本(組二)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_combine2-$sum3) . "</td><td></td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;color: #a9a9a9'>累計折舊(組二)</td><td></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_combine2) . "</td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;color: #a9a9a9'>管理總務成本(組裝)</td><td style='border-left:0px;'></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_detect) . "</td><td></td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;color: #a9a9a9'>累計折舊(組裝)</td><td></td><td style='text-align:right;color: #a9a9a9'>" . number_format($depre_detect) . "</td><td></td><td></td></tr>";
			
				
				$catalog_temp = $catalog[$decision_name['name']];
			}
			//現金增資
            elseif ($decision_name['name'] == "cash_increase") {
                if ($catalog_temp != $catalog[$decision_name['name']]){
                    $flag++;
					flag($flag);
					echo "<td></td><td style='text-algin:left; border-right:0px;'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td>" . $catalog[$decision_name['name']] . "</td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}else{ 
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}
                if ($capital == 0){
                    $flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($stocks) . "</td><td></td><td></td></tr>";
				}else if ($capital > 0) {
					$flag++;
					flag($flag);
                    echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($stocks) . "</td><td></td><td></td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>資本公積</td><td></td><td style='text-align:right'>" . number_format($captial) . "</td><td></td><td></td><td></td></tr>";
         
                } elseif ($capital < 0) {
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>資本公積</td><td></td><td style='text-align:right'>" . number_format($capital*(-1)) . "</td><td></td><td></td><td></td></tr>";
   
                    $flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($stocks) . "</td><td></td><td></td></tr>";
		
                }$catalog_temp = $catalog[$decision_name['name']];
            }
            else if ($decision_name['name'] == "tax") {
				if($tax>0){
					if ($catalog_temp != "非決策"){
						$flag++;
						flag($flag);
						echo "<td></td><td style='text-align:left;border-right:0px;'>所得稅費用</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($tax) . "</td><td></td><td>非決策</td><td>所得稅</td></tr>";
					}else{
						$flag++;
						flag($flag); 
						echo "<td></td><td style='text-align:left;border-right:0px;'>所得稅費用</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($tax) . "</td><td></td><td></td><td>所得稅</td></tr>";
					}
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>遞延所得稅負債</td><td></td><td style='text-align:right'>" . number_format($tax_asset) . "</td><td></td><td></td></tr>";
					if($tax-$tax_asset>0){ 
						$flag++;
						flag($flag);
						echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>應付所得稅</td><td></td><td style='text-align:right'>" . number_format($tax-$tax_asset) . "</td><td></td><td></td></tr>";
					}
			}else{
					if ($catalog_temp != "非決策"){
						$flag++;
						flag($flag);
						echo "<td></td><td style='text-align:left;border-right:0px;'>遞延所得稅資產</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($tax*(-1)) . "</td><td></td><td>非決策</td><td>所得稅</td></tr>";
					}else{
						$flag++;
						flag($flag); 
						echo "<td></td><td style='text-align:left;border-right:0px;'>遞延所得稅資產</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($tax*(-1)) . "</td><td></td><td></td><td>所得稅</td></tr>";
					}
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>所得稅利益</td><td></td><td style='text-align:right'>" . number_format($tax*(-1)) . "</td><td></td><td></td></tr>";
				}
				if($month==1&&$tax_pay>0){
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px;'>應付所得稅</td><td style='border-left:0px;'></td><td style='text-align:right'>" . number_format($tax_pay) . "</td><td></td><td></td><td>所得稅</td></tr>";
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><td style='text-align:left;border-left:0px;'>現金</td><td></td><td style='text-align:right'>" . number_format($tax_pay) . "</td><td></td><td></td></tr>";
				}
                $catalog_temp = "非決策";
            }
            else if ($decision_name['name'] == "netin") {
				if($sum>0){
					if ($catalog_temp != "非決策"){
						$flag++;
						flag($flag);
						echo "<td></td><th style='text-align:left;border-right:0px;'>淨利</th><td style='border-left:0px;'></td><th style='text-align:right'>" . number_format($sum) . "</th><th></th><th>非決策</th><th>本期淨利</th></tr>";
					}else{ 
						$flag++;
						flag($flag);
						echo "<td></td><th style='text-align:left;border-right:0px;'>淨利</th><td style='border-left:0px;'></td><th style='text-align:right'>" . number_format($sum) . "</th><th></th><th></th><th>本期淨利</th></tr>";
					}
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><th style='text-align:left;border-left:0px;'>保留盈餘</th><th></th><th style='text-align:right'>" . number_format($sum) . "</th><td></td><td></td></tr>";
				}
				else{
					if ($catalog_temp != "非決策"){
						$flag++;
						flag($flag);
						echo "<td></td><th style='text-align:left;border-right:0px'>保留盈餘</th><td style='border-left:0px'></td><th style='text-align:right'>" . number_format($sum*(-1)) . "</th><th></th><th>非決策</th><th>本期(淨利)</th></tr>";
					}else{ 
						$flag++;
						flag($flag);
						echo "<td></td><th style='text-align:left;border-right:0px'>保留盈餘</th><td style='border-left:0px'></td><th style='text-align:right'>" . number_format($sum*(-1)) . "</th><th></th><th></th><th>本期(淨利)</th></tr>";
					}
					$flag++;
					flag($flag);
					echo "<td></td><td style='border-right:0px;'></td><th style='text-align:left;border-left:0px;'>淨損</th><th style='border-left:0px'></th><th style='text-align:right'>" . number_format($sum*(-1)) . "</th><td></td><td></td></tr>";
				}
                $catalog_temp = "非決策";
            }
			
			else {
                if ($catalog_temp != $catalog[$decision_name['name']]){//同種決策類別只顯示一次
					$flag++;
					flag($flag);
                    echo "<td></td><td style='text-align:left;border-right:0px'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td>" . $catalog[$decision_name['name']] . "</td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}else{ 
					$flag++;
					flag($flag);
					echo "<td></td><td style='text-align:left;border-right:0px'>" . $subject[$decision_name['name']] . "</td><td style='border-left:0px'></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td><td>" . $args[$decision_name['name']] . "</td></tr>";
				}
				$flag++;
				flag($flag);
				echo "<td></td><td style='border-right:0px'></td><td style='text-align:left;border-left:0px'>" . $subject2[$decision_name['name']] . "</td><td></td><td style='text-align:right'>" . number_format($sum) . "</td><td></td><td></td></tr>";
                $catalog_temp = $catalog[$decision_name['name']];
				
            }
		}
        $sum = 0;
    }
}//end while 
if (!strcmp($_POST['month'], "now")) {
    $month = $_SESSION['month'];                               //之後在這裡從資料庫中讀出確切月份
    $year=$_SESSION['year'];
    echo ($year-1)*12+(int)$month;
} else {
    report($_POST['month']);
}
?>
