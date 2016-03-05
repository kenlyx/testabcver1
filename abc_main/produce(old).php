<?php
include ("checkIP.php");
	include("./connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
	//讀ABC所有的公司名稱
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account");
	mysql_select_db("testabc_main");

	$temp=mysql_query("SELECT MAX(`year`) FROM `state`");
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0]-1;
        if($month==0){
            $month=12;
            $year-=1;
    	}
		$month_report=$month+($year-1)*12;
        $percent=0;
	while($company=mysql_fetch_array($C_name)){//每間公司
		$cid=$company['CompanyID'];
		$flaw_arr=array("supplierA_flaw"=>0,"supplierB_flaw"=>0,"supplierC_flaw"=>0,"monitor"=>0,"kernel"=>0,"keyboard"=>0,"cut"=>0,"combine1"=>0,"check_s"=>0,"combine2"=>0,"check"=>0);
		$flaw_rate=1;
		$quality=0;
		$batch=1;
		$rank=0;
		foreach($flaw_arr as $name => $value){//讀取所有瑕疵率存入陣列
			$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = '$name'");
			$temp=mysql_fetch_array($result);
			$flaw_arr[$name]=$temp[0];
			if($name=="monitor"||$name=="kernel"||$name=="keyboard"||$name=="check_s"||$name=="check"){//流程改良和生產規劃的步驟一樣
				$result = mysql_query("SELECT * FROM `product_plan` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month");
				$temp=mysql_fetch_array($result);
				if($temp[$name]==0){//不做時改變瑕疵率
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_{$name}'");
					$temp=mysql_fetch_array($result);
					$flaw_arr[$name]=$temp[0];//直接改變瑕疵率
				}
				else{//要做的話再計算流程改良過的瑕疵率
					$result = mysql_query("SELECT COUNT(`process`) FROM `process_improvement` WHERE `cid` = '$cid' AND  `process` = '$name' AND `month` < $month_report;");
					$temp=mysql_fetch_array($result);
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_{$name}'");
					$temp2=mysql_fetch_array($result);
					$flaw_arr[$name]=$flaw_arr[$name]-$temp[0]*$temp2[0];//減少瑕疵率
				}
			}
			/*if($name=="cut"||$name=="check_s"||$name=="check"){//生產規劃
				$result = mysql_query("SELECT * FROM `product_plan` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month");
				$temp=mysql_fetch_array($result);
				if($temp[$name]==0){
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_.$name'");
					$temp=mysql_fetch_array($result);
					$flaw_arr[$name]=$temp[0];
				}
			}*/
			if($name=="cut"||$name=="combine1"||$name=="combine2"){//機具選擇
				$result = mysql_query("SELECT * FROM `product_plan` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month");
				$temp=mysql_fetch_array($result);
				if($temp[$name]==0){
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = '{$name}A'");
					$temp=mysql_fetch_array($result);
					$flaw_arr[$name]=$flaw_arr[$name]-$temp[0];
				}
				elseif($temp[$name]==1){
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = '{$name}B'");
					$temp=mysql_fetch_array($result);
					$flaw_arr[$name]=$flaw_arr[$name]-$temp[0];
				}
				elseif($temp[$name]==2){
					$result = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = '{$name}C'");
					$temp=mysql_fetch_array($result);
					$flaw_arr[$name]=$flaw_arr[$name]-$temp[0];
				}
			}
		}//既然產品只有兩個我下面就不做迴圈了...不然又要多好幾個變數
		$result = mysql_query("SELECT * FROM `product_a` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month");
		$productA=mysql_fetch_array($result);
		$batch=$productA[3]+$productA[4]+$productA[5];
				if($batch!=0){
                    foreach($flaw_arr as $name => $value){//計算A成品數量及瑕疵率
                            if($name=="supplierA_flaw"||$name=="supplieB_flaw"||$name=="supplierC_flaw"){//原料瑕疵
                                if($name=="supplierA_flaw")
                                    $i=0;
				            elseif($name=="supplierB_flaw")
                                    $i=1;
				            elseif($name=="supplierC_flaw")
                                    $i=2;
				            if($batch>0)
                                    $percent=($productA[3+$i]+$productA[6+$i]+$productA[9+$i])/$batch;
				                    $batch=$batch*(1-$percent*$value);
				                    $flaw_rate=$flaw_rate*(1+$percent*$value);
                            }else{
                            	$batch=$batch*(1-$value);
				                $flaw_rate=$flaw_rate*(1+$value);
                            }
                    }
                    $quality=2-$flaw_rate;//計算品質
                    if($quality>0.92)
			$rank=1;
                    elseif($quality>0.87)
			$rank=2;
                    elseif($quality>0.79)
			$rank=3;
                    elseif($quality>0.66)
			$rank=4;
                    else
			$rank=5;
                    $temp=mysql_query("SELECT MAX(`index`) as maxnum from `product_quality`") or die(mysql_error());
                    $result=mysql_fetch_array($temp);
                    if(!$result[0])
                        $index=1;
                    else
                        $index=$result['maxnum']+1;
                    mysql_query("INSERT INTO `product_quality` VALUES ($index,$year,$month,'$cid','A',$batch,$quality,$rank)");
                    echo "INSERT INTO `product_quality` VALUES ($index,$year,$month,'$cid','A',$batch,$quality,$rank);";
                    mysql_query("INSERT INTO `product_history` VALUES ($index,$year,$month,'$cid','A',$batch)");
                }
		//產品B
		$quality=0;
		$batch=1;
		$rank=0;
		$result = mysql_query("SELECT * FROM `product_b` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month");
		$productB=mysql_fetch_array($result);
		$batch=$productB[3]+$productB[4]+$productB[5];
                if($batch!=0){
                    foreach($flaw_arr as $name => $value){//計算B成品數量及瑕疵率
			if($name=="supplierA_flaw"||$name=="supplieB_flaw"||$name=="supplierC_flaw"){//原料瑕疵
				if($name=="supplierA_flaw")
					$i=0;
				elseif($name=="supplierB_flaw")
					$i=1;
				elseif($name=="supplierC_flaw")
					$i=2;
				if($batch>0)
					$percent=($productB[3+$i]+$productB[6+$i])/$batch;
				$batch=$batch*(1-$percent*$value);
				$flaw_rate=$flaw_rate*(1+$percent*$value);
			}
			elseif($name=="keyboard"||$name=="check_s"||$name=="combine2")
				continue;//B無此三步驟故跳過
			else{
				$batch=$batch*(1-$value);
				$flaw_rate=$flaw_rate*(1+$value);
			}
                    }
                    $quality=2-$flaw_rate;//計算品質
                    if($quality>0.92)
			$rank=1;
                    elseif($quality>0.87)
			$rank=2;
                    elseif($quality>0.79)
			$rank=3;
                    elseif($quality>0.66)
			$rank=4;
                    else
			$rank=5;
                    $temp=mysql_query("SELECT MAX(`index`) as maxnum from `product_quality`") or die(mysql_error());
                    $result=mysql_fetch_array($temp);
                    if(!$result[0])
                        $index=1;
                    else
                        $index=$result['maxnum']+1;
                    mysql_query("INSERT INTO `product_quality` VALUES ($index,$year,$month,'$cid','B',$batch,$quality,$rank)");
                    mysql_query("INSERT INTO `product_history` VALUES ($index,$year,$month,'$cid','B',$batch)");
            }
        }
?>
