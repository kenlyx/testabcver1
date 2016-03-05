<?php
	session_start();
        $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
        mysql_select_db("testabc_main",$connect);
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$month=$_SESSION['month'];
	$year=$_SESSION['year'];
	/*$cid="C01";
	$month=5;
	$year=1;*/
	
	$month_m=$month+12*($year-1);
	if(($_GET['option'])=="get"){
		if(($_GET['type'])=="pp"){
			$result=mysql_query("SELECT * FROM `product_plan` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			$temp=mysql_fetch_array($result);
			$reply=$temp[3].":".$temp[4].":".$temp[5].":".$temp[8].":".$temp[9].":".$temp[6].":".$temp[10].":".$temp[7];
			echo $reply;
		}
		if(($_GET['type'])=="B"){
			$arrA=array("0"=>"ma_supplier_a","1"=>"ma_supplier_b","2"=>"ma_supplier_c","3"=>"mb_supplier_a","4"=>"mb_supplier_b","5"=>"mb_supplier_c");
			$reply="";
			for($i=0;$i<6;$i++){
				$result=mysql_query("SELECT SUM(`$arrA[$i]`) FROM purchase_materials WHERE 12*(`year`-1)+`month`<=$month_m AND `cid`='$cid'",$connect);
				$temp1=mysql_fetch_array($result);
				$reply=$reply.$temp1[0].":";
			}	
			$result=mysql_query("SELECT * FROM product_a WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			$temp2=mysql_fetch_array($result);
			$result=mysql_query("SELECT * FROM product_b WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			$temp3=mysql_fetch_array($result);
		
			//for($i=0;$i<6;$i++)
				//$reply=$reply.$temp1[$i].":";//($temp1[$arrA[$i]]-$temp2[$arrA[$i]]-$temp3[$arrA[$i]]).":";
			for($i=0;$i<6;$i++)
				$reply=$reply.$temp3[$arrA[$i]].":";
			for($i=0;$i<6;$i++)
				$reply=$reply.$temp2[$arrA[$i]].":";
			echo $reply;
		}
		if(($_GET['type'])=="A"){
			$arrA=array("0"=>"ma_supplier_a","1"=>"ma_supplier_b","2"=>"ma_supplier_c","3"=>"mb_supplier_a","4"=>"mb_supplier_b","5"=>"mb_supplier_c","6"=>"mc_supplier_a","7"=>"mc_supplier_b","8"=>"mc_supplier_c");
			$reply="";
			for($i=0;$i<9;$i++){
				$result=mysql_query("SELECT SUM(`$arrA[$i]`) FROM `purchase_materials` WHERE 12*(`year`-1)+`month`<=$month_m AND `cid`='$cid'",$connect);
				$temp1=mysql_fetch_array($result);
				$reply=$reply.$temp1[0].":";
			}	
			$result=mysql_query("SELECT * FROM `product_a` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			$temp2=mysql_fetch_array($result);
			$result=mysql_query("SELECT * FROM `product_b` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			$temp3=mysql_fetch_array($result);
			/*for($i=0;$i<9;$i++)
				$reply=$reply.$temp1[$arrA[$i]].":";//($temp1[$arrA[$i]]-$temp2[$arrA[$i]]-$temp3[$arrA[$i]]).":";*/
			for($i=0;$i<9;$i++)
				$reply=$reply.$temp2[$arrA[$i]].":";
			for($i=0;$i<6;$i++)
				$reply=$reply.$temp3[$arrA[$i]].":";
			echo $reply;
		}
	}
	elseif(($_GET['option'])=="update"){
		if(($_GET['type'])=="pp"){
			mysql_query("UPDATE `product_plan` SET `monitor`={$_GET['monitor']}, `kernel`={$_GET['kernel']}, `keyboard`={$_GET['keyboard']}, `cut`={$_GET['cut']}, `combine1`={$_GET['combine1']},`check_s`={$_GET['check_s']}, `combine2`={$_GET['combine2']},`check`={$_GET['check']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			echo "updated!!";
		}
		if(($_GET['type'])=="B"){
			mysql_query("UPDATE product_b  SET `ma_supplier_a`={$_GET['a_supplyA']},`ma_supplier_b`={$_GET['a_supplyB']},`ma_supplier_c`={$_GET['a_supplyC']},`mb_supplier_a`={$_GET['b_supplyA']},`mb_supplier_b`={$_GET['b_supplyB']},`mb_supplier_c`={$_GET['b_supplyC']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			echo "updated!!";
		}
		if(($_GET['type'])=="A"){
			mysql_query("UPDATE product_a  SET `ma_supplier_a`={$_GET['a_supplyA']},`ma_supplier_b`={$_GET['a_supplyB']},`ma_supplier_c`={$_GET['a_supplyC']},`mb_supplier_a`={$_GET['b_supplyA']},`mb_supplier_b`={$_GET['b_supplyB']},`mb_supplier_c`={$_GET['b_supplyC']},`mc_supplier_a`={$_GET['c_supplyA']},`mc_supplier_b`={$_GET['c_supplyB']},`mc_supplier_c`={$_GET['c_supplyC']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
			echo "updated!!";
		}
	}
	elseif(($_GET['option'])=="get_machine"){
            $result=mysql_query("SELECT * FROM `product_plan` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'",$connect);
            $machine=mysql_fetch_array($result);
            $machine_array=array("A","B","C");
            $cut_type=$machine['cut'];
            $combine1_type=$machine['combine1'];
            $combine2_type=$machine['combine2'];
			$detect1_do=$machine['check_s'];
			$detect2_do=$machine['check'];
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='cut' AND `type`='$machine_array[$cut_type]' ",$connect);
            $cut_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='combine1' AND `type`='$machine_array[$combine1_type]' ",$connect);
            $combine1_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='combine2' AND `type`='$machine_array[$combine2_type]' ",$connect);
            $combine2_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='detect' AND `type`='A' ",$connect);
            $detect1_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='detect' AND `type`='B' ",$connect);
            $detect2_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='Capacity_cut_$machine_array[$cut_type]'",$connect);
            $Capacity_cut=mysql_fetch_array($result);
            $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='Capacity_combine1_$machine_array[$combine1_type]'",$connect);
            $Capacity_combine1=mysql_fetch_array($result);
            $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='Capacity_combine2_$machine_array[$combine2_type]'",$connect);
            $Capacity_combine2=mysql_fetch_array($result);
            $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='Capacity_detect1'",$connect);
            $Capacity_detect1=mysql_fetch_array($result);
            $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='Capacity_detect2'",$connect);
            $Capacity_detect2=mysql_fetch_array($result);
            if(($_GET['type'])=="B"){
                $result=mysql_query("SELECT * FROM `product_a` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month",$connect);
                $product_a_used=mysql_fetch_array($result);
                $cut_total=($cut_num[0]*$Capacity_cut[0]-2*($product_a_used['ma_supplier_a']+$product_a_used['ma_supplier_b']+$product_a_used['ma_supplier_c'])-4*($product_a_used['mb_supplier_a']+$product_a_used['mb_supplier_b']+$product_a_used['mb_supplier_c'])-($product_a_used['mc_supplier_a']+$product_a_used['mc_supplier_b']+$product_a_used['mc_supplier_c']))/6;
                $combine1_total=($combine1_num[0]*$Capacity_combine2[0]-0.1*($product_a_used['ma_supplier_a']+$product_a_used['ma_supplier_b']+$product_a_used['ma_supplier_c'])-0.15*($product_a_used['mb_supplier_a']+$product_a_used['mb_supplier_b']+$product_a_used['mb_supplier_c']))*4;// /0.25 == *4
                $min_total=min($cut_total,$combine1_total);
				if($detect2_do==1){
					$detect2_total=($detect2_num[0]*$Capacity_detect2[0]-2*($product_a_used['ma_supplier_a']+$product_a_used['ma_supplier_b']+$product_a_used['ma_supplier_c'])-2*($product_a_used['mb_supplier_a']+$product_a_used['mb_supplier_b']+$product_a_used['mb_supplier_c'])-1*($product_a_used['mc_supplier_a']+$product_a_used['mc_supplier_b']+$product_a_used['mc_supplier_c']))/4;
                	$min_total=min($min_total,$detect2_total);
				}
            }
            if(($_GET['type'])=="A"){
                $result=mysql_query("SELECT * FROM `product_b` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month",$connect);
                $product_b_used=mysql_fetch_array($result);
                $cut_total=($cut_num[0]*$Capacity_cut[0]-2*($product_b_used['ma_supplier_a']+$product_b_used['ma_supplier_b']+$product_b_used['ma_supplier_c'])-4*($product_b_used['mb_supplier_a']+$product_b_used['mb_supplier_b']+$product_b_used['mb_supplier_c']))/7;
                $combine2_total=($combine2_num[0]*$Capacity_combine2[0]-0.1*($product_b_used['ma_supplier_a']+$product_b_used['ma_supplier_b']+$product_b_used['ma_supplier_c'])-0.15*($product_b_used['mb_supplier_a']+$product_b_used['mb_supplier_b']+$product_b_used['mb_supplier_c']))*4;// /0.25 == *4
                $combine1_total=($combine1_num[0]*$Capacity_combine1[0])/0.27;
                $min_total=min($cut_total,$combine1_total,$combine2_total);
				if($detect2_do==1){
				    $detect2_total=($detect2_num[0]*$Capacity_detect2[0]-2*($product_b_used['ma_supplier_a']+$product_b_used['ma_supplier_b']+$product_b_used['ma_supplier_c'])-2*($product_b_used['mb_supplier_a']+$product_b_used['mb_supplier_b']+$product_b_used['mb_supplier_c']))/5;
                	$min_total=min($min_total,$detect2_total);
				}
				if($detect1_do==1){
                	$detect1_total=($detect1_num[0]*$Capacity_detect1[0])/4;
					$min_total=min($min_total,$detect1_total);
				}
            }
            echo (integer)$min_total;
	}
	elseif(($_GET['option'])=="fix_cost"){
            $machine_array=array("A","B","C");
            $cut_type=$_GET['cut'];
            $combine1_type=$_GET['combine1'];
            $combine2_type=$_GET['combine2'];
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='cut' AND `type`='$machine_array[$cut_type]' ",$connect);
            $cut_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='combine1' AND `type`='$machine_array[$combine1_type]' ",$connect);
            $combine1_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE 12*(`buy_year`-1)+`buy_month`<$month_m AND 12*(`sell_year`-1)+`sell_month`>$month_m AND `cid`='$cid' AND `function`='combine2' AND `type`='$machine_array[$combine2_type]' ",$connect);
            $combine2_num=mysql_fetch_array($result);
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`='cut_set_up' ",$connect);
            $cut_setup=mysql_fetch_array($result);
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`='combine1_set_up' ",$connect);
            $combine1_setup=mysql_fetch_array($result);
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`='combine2_set_up' ",$connect);
            $combine2_setup=mysql_fetch_array($result);
            $cut_fix_cost=$cut_num[0]*$cut_setup[$cut_type];
            $combine1_fix_cost=$combine1_num[0]*$combine1_setup[$cut_type];
            $combine2_fix_cost=$combine2_num[0]*$combine2_setup[$cut_type];
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`='detect0_set_up' ",$connect);
            $detect0_setup=mysql_fetch_array($result);//人工檢料
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`='detect_set_up' ",$connect);
            $detect_setup=mysql_fetch_array($result);
            $fixcostA=$_GET['monitor']*$detect0_setup[0]+$_GET['kernel']*$detect0_setup[1]+$_GET['check']*$detect_setup[1]+$cut_fix_cost+$combine2_fix_cost;
            $fixcostB=$fixcostA+$_GET['keyboard']*$detect0_setup[2]+$_GET['check_s']*$detect_setup[0]+$combine1_fix_cost;
            echo $fixcostA.";".$fixcostB;
	}
?>