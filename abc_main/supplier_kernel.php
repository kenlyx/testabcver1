<?php
/*這部份不確定主要功能為何  不過跟db相關部份基本上都被//掉了   那把整段/*掉應該也沒差......吧
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $supplier_arr=array("A","B","C");
    $supplier_arr2=array("a","b","c");
    $supplier_max=array();
    $supplier_power=array();
    for($i=0;$i<3;$i++){
        $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier_arr[$i]_power';",$connect);
        $para=mysql_fetch_array($temp);
        $temp=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier_arr2[$i]` WHERE `accept`=1");
        $result=mysql_fetch_array($temp);
        array_push($supplier_max,$para[0]-$result[0]);
        array_push($supplier_power,$para[0]);
    }
	
    for($j=0;$j<3;$j++){
        echo "j==> $j";
        for($i=1;$i<=3;$i++){
            echo "i==> $i";
            while($supplier_max[$j]>0){
                $choose_company="";
                $choose_type="";
                $choose_source="";
                $choose_price="";
                $choose_quantity="";
                $max=0;
                $num_minus=0;
                $temp=mysql_query("SELECT * FROM `supplier_$supplier_arr2[$j]` WHERE `source`='$i' AND `accept`=0",$connect) or die(mysql_error());
                $result=mysql_fetch_array($temp);
                if(empty($result))
                    break;
                $temp=mysql_query("SELECT * FROM `supplier_$supplier_arr2[$j]` WHERE `source`='$i' AND `accept`=0",$connect) or die(mysql_error());
                while($arr=mysql_fetch_array($temp)){
                    if($arr['quantity']>$supplier_max[$j]){
                        echo $arr['quantity']." > ".$supplier_max[$j]."<br/>";
                        $temp_max=$arr['price']*$supplier_max[$j];
                        if($temp_max>$max){
                            $max=$temp_max;
                            $choose_company=$arr['cid'];
                            $choose_type=$arr['type'];
                            $choose_source=$arr['source'];
                            $choose_price=$arr['price'];
                            $choose_quantity=$supplier_max[$j];
                            $num_minus=$supplier_max[$j];
                        }
                        else if($temp_max==$max){
                            if($arr['price']>$choose_price){
                                $max=$temp_max;
                                $choose_company=$arr['cid'];
                                $choose_type=$arr['type'];
                                $choose_source=$arr['source'];
                                $choose_price=$arr['price'];
                                $choose_quantity=$supplier_max[$j];
                                $num_minus=$supplier_max[$j];
                            }
                        }
                    }
                    else{
                        echo $arr['quantity']."<=".$supplier_max[$j]."<br/>";
                        $temp_max=$arr['price']*$arr['quantity'];
                        if($temp_max>$max){
                            $max=$temp_max;
                            $choose_company=$arr['cid'];
                            $choose_type=$arr['type'];
                            $choose_source=$arr['source'];
                            $choose_price=$arr['price'];
                            $choose_quantity=$arr['quantity'];
                            $num_minus=$arr['quantity'];
                        }
                        else if($temp_max==$max){
                            if($arr['quantity']<$num_minus){
                                $max=$temp_max;
                                $choose_company=$arr['cid'];
                                $choose_type=$arr['type'];
                                $choose_source=$arr['source'];
                                $choose_price=$arr['price'];
                                $choose_quantity=$arr['quantity'];
                                $num_minus=$arr['quantity'];
                            }
                        }
                    }
                    echo "$choose_company;$choose_quantity;<br/>";
                }
                $supplier_max[$j]-=$num_minus;
                $result=$choose_price.":".$choose_quantity;
                mysql_query("UPDATE `r_d` SET `supplier_$supplier_arr[$j]` = '$result' WHERE `cid` = '$choose_company' AND `type`= '$choose_type' AND `source`='$choose_source';",$connect) or die(mysql_error());
                mysql_query("UPDATE `supplier_$supplier_arr2[$j]` SET `accept` = 1 WHERE `cid` = '$choose_company' AND `type`= '$choose_type' AND `source`='$choose_source';",$connect) or die(mysql_error());
                //if($check_mod == 1){
                    mysql_query("UPDATE `supplier_$supplier_arr2[$j]` SET `quantity` = '$choose_quantity' WHERE `cid` = '$choose_company' AND `type`= '$choose_type' AND `source`='$choose_source';",$connect) or die(mysql_error());
					//echo "UPDATE `supplier_$supplier_arr2[$j]` SET `quantity` = '$choose_quantity' WHERE `cid` = '$choose_company' AND `type`= '$choose_type' AND `source`='$choose_source';<br/>";
				//}
				print_r($supplier_max);
                $temp=mysql_query("SELECT `satisfaction_$supplier_arr2[$j]` FROM `supplier_satisfaction` WHERE `cid`='$choose_company';");
                $result=mysql_fetch_array($temp);
                $value=$result[0]+$choose_quantity*0.001;
                mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_$supplier_arr2[$j]`=$value WHERE `cid`='$choose_company';",$connect);
				echo "UPDATE `supplier_satisfaction` SET `satisfaction_$supplier_arr2[$j]`=$value WHERE `cid`='$choose_company';<br/>";
				echo "SHIT~~!!<br/>";
            }
        }
    }
	mysql_query("DELETE FROM `supplier_a` WHERE `accept`=0;",$connect) or die(mysql_error());
	mysql_query("DELETE FROM `supplier_b` WHERE `accept`=0;",$connect) or die(mysql_error());
	mysql_query("DELETE FROM `supplier_c` WHERE `accept`=0;",$connect) or die(mysql_error());
*/	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
    //以下是月份推進後，分配原料的部分。其中供應商關係的參數尚未寫入資料表，故暫時將資料寫死，並將(應該)正確的程式碼進行註解。(分別在123行與160行。)
	//啊以下看不懂(懶的看)  搶料部份直接重寫(此處為103以前版本)
	
	/*
    $temp=mysql_query("SELECT MAX(`month`) FROM `state`",$connect);
    $result=mysql_fetch_array($temp);
    $month=$result[0]-1;
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
    $result=mysql_fetch_array($temp);
    $year=$result[0];
    $i_j=array("1_1"=>0,"1_2"=>0,"1_3"=>0,"2_1"=>0,"2_2"=>0,"2_3"=>0,"3_1"=>0,"3_2"=>0,"3_3"=>0,);
    for($j=0;$j<3;$j++){
        $c=0;//計算分配用的分母
        $d=0;//計算是否有剩餘。
        $e=0;//計算契約分掉了多少原料。
        for($i=1;$i<=3;$i++){
            $ii=$i-1;
            $temp1=mysql_query("SELECT `cid` FROM `state` WHERE `year`=$year AND `month`=$month",$connect);
            while($cid=mysql_fetch_array($temp1)){
                $temp=mysql_query("SELECT `supplier_$supplier_arr[$j]` FROM `r_d` WHERE `source`=$i AND `cid`='$cid[0]'",$connect);
                $result=mysql_fetch_array($temp);
                if(!empty($result)){
                    $temp=mysql_query("SELECT `supplier_$supplier_arr[$j]` FROM `r_d` WHERE `source`=$i AND `cid`='$cid[0]'",$connect);
                    while($rd_materials=mysql_fetch_array($temp)){
                        if($rd_materials['supplier_'.$supplier_arr[$j]]!=-1){
                            $rd_num=split(":",$rd_materials['supplier_'.$supplier_arr[$j]]);
						}
                        else{
                            $rd_num[1]=0;
//                        	echo $rd_materials['supplier_'.$supplier_arr[$j]].";";
						}
                    }
                }
                $temp=mysql_query("SELECT `m$supplier_arr2[$ii]_supplier_$supplier_arr2[$j]` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid[0]'",$connect);
                $pur_num=mysql_fetch_array($temp);
                $d+=$pur_num[0];
                if($rd_num[1]<$pur_num[0]){
                    $temp=mysql_query("SELECT `satisfaction_$supplier_arr[$j]` FROM `supplier_satisfaction` WHERE `cid`='$cid[0]'",$connect);
                    $satis=mysql_fetch_array($temp);
                    $c+=($pur_num[0]-$rd_num[1])*$satis[0];
//                    echo"<br/>($pur_num[0]-$rd_num[1])*$satis[0]<br/>";
                    $e+=$rd_num[1];
                }
                else{
                    $e+=$pur_num[0];
                }
//                echo $pur_num[0].";".$rd_num[1].";".$rd_materials['supplier_'.$supplier_arr[$j]].";".$ii.";".$j.";".$supplier_power[$j]."<br/>";
            }
            //計算和寫入分隔區
        }
//        echo $c.";".$d.";".$e."<br/>";
        for($i=1;$i<=3;$i++){
            $ii=$i-1;
            $temp1=mysql_query("SELECT `cid` FROM `state` WHERE `year`=$year AND `month`=$month",$connect);
            while($cid=mysql_fetch_array($temp1)){
                $ii=$i-1;
                $temp=mysql_query("SELECT `m$supplier_arr2[$ii]_supplier_$supplier_arr2[$j]` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='{$cid[0]}'",$connect);
                $pur_num=mysql_fetch_array($temp);
                if($d<=$supplier_power[$j]){
                    $ture_materials = $pur_num[0];
                }
                else {
                    $temp=mysql_query("SELECT `supplier_$supplier_arr[$j]` FROM `r_d` WHERE `source`=$i AND `cid`='$cid[0]'",$connect);
                    $result=mysql_fetch_array($temp);
                    if(!empty($result)){
                        $temp=mysql_query("SELECT `supplier_$supplier_arr[$j]` FROM `r_d` WHERE `source`=$i AND `cid`='$cid[0]'",$connect);
                        while($rd_materials=mysql_fetch_array($temp)){
                            if($rd_materials['supplier_'.$supplier_arr[$j]]!=-1){
                                $rd_num=split(":",$rd_materials['supplier_'.$supplier_arr[$j]]);
							}
                        }
                    }
                    if($e>=$supplier_power[$j]){
                        if($rd_num[1]<$pur_num[0]){
                            $ture_materials = $rd_num[1];
						}
                        else{
                            $ture_materials = $pur_num[0];
						}
                    }
                    else if($d>$supplier_power[$j]){
                        if($rd_num[1]<$pur_num[0]){
                            $temp=mysql_query("SELECT `satisfaction_$supplier_arr2[$j]` FROM `supplier_satisfaction` WHERE `cid`='$cid[0]'",$connect);
//                            echo "SELECT `satisfaction_$supplier_arr2[$j]` FROM `supplier_satisfaction` WHERE `company`='$cid[0]";
                            $satis=mysql_fetch_array($temp);
                            $ture_materials=$rd_num[1]+($pur_num[0]-$rd_num[1])*$satis[0]/$c*($pur_num[0]-$rd_num[1]);
//                            echo "$rd_num[1]+($pur_num[0]-$rd_num[1])*$satis[0]/$c*($pur_num[0]-$rd_num[1])";
//                            echo"<br/>SHIIIIIIIIIIT<br/>";
                        }
                        else{
                            $ture_materials = $pur_num[0];
						}
                    }
                }
                $x='supplier_'.$supplier_arr[$j];
                $ture_materials=(int)$ture_materials;
                echo $pur_num[0].";".$rd_num[1].";".$ture_materials.";".$ii.";".$j.";".$supplier_power[$j]."<br/>";
                //mysql_query("UPDATE `purchase_materials` SET `m$supplier_arr2[$ii]_supplier_$supplier_arr2[$j]` = '$ture_materials' WHERE `cid` = '$cid[0]' AND `month`= '$month' AND `year`='$year';",$connect) or die(mysql_error());
                $price_result=mysql_query("SELECT `m$supplier_arr2[$ii]_supplier_$supplier_arr2[$j]` FROM `purchase_materials_price` WHERE `cid` = '$cid[0]' AND `month`= '$month' AND `year`='$year'",$connect);
                $price=mysql_fetch_array($price_result);
                $ture_cost=$ture_materials*$price[0];
                //mysql_query("UPDATE `materials_cost` SET `m$supplier_arr2[$ii]_supplier_$supplier_arr2[$j]` = '$ture_cost' WHERE `cid` = '$cid[0]' AND `month`= '$month' AND `year`='$year';",$connect) or die(mysql_error());
            }
//            echo"<br/>";
        }
    }
	
	
	
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/*  搶料概念103(只含契約)  ps:因為供商關係好像未實作(?)

//值不變，放for內會抽過多次同樣質
sup_power_a = 供商(a)的最大供應量
sup_power_b = 供商(b)的最大供應量
sup_power_c = 供商(c)的最大供應量
overflow用來辨斷總量是否超出供應量

共九輪(i,j)  (i=0,i<3,i++)	(j=0,j<3,j++)
每一輪先計算m[i]_supplier_[j]當回合的總量
if(總量>供應量)則開始進入k與L迴圈

	每一輪內計算到的變數<--
	
	for(k=0,k<cid.length,k++){
		
		material_k = 該公司當月購買量
		quantity_k = 該公司在該供商(j)該商品(i)的簽約量(含type ab)
		
		
		if(material_k > quantity_k){
			True_material_k = material_k - quantity_k
			True_quantity_k = quantity_k
		}
		else{
			True_material_k = 0
			True_quantity_k = material_k
		}
		
		Total_True_material += True_material_k   	(k = 所有組)
		Total_True_quantity += True_quantity_k		(k = 所有組)
		
	}Total值需要k完全跑完才能算出來，故切出L迴圈
	
	True_sup_power_j = sup_power_j - Total_True_quantity
	
	for(L=0,L<cid.length,L++){
		
		Ratio_L = True_material_L / Total_True_material
		
		Last_material_L = Ratio_L * True_sup_power_j + True_quantity_L
		
		UPDATE Last_material_L
	}

	-->


*/


	include("./connMysql.php");
	if(!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

	$temp = mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account` ORDER BY `CompanyID`");
	$cid = array();
	$c_length = 0;
	while($company = mysql_fetch_array($temp)){//$company此array只有第一個位子[0]會取到值，故用while將所有值push進$cid(新array)
		array_push($cid,$company['CompanyID']);//將$company['CompanyID']的值push進$cid
		$c_length++;//總公司數
	}
	
	mysql_select_db("testabc_main");
	
	
	$overflow = false;
	
	$temp=mysql_query("SELECT MAX(`year`) FROM `state`");
    $result=mysql_fetch_array($temp);
    $year = $result[0];
	
	$temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`='$year'");
    $result=mysql_fetch_array($temp);
    $month = $result[0]-1;
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_A_power' ");
	$result = mysql_fetch_array($temp);
	$sup_power_A = $result[0];
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_B_power' ");
	$result = mysql_fetch_array($temp);
	$sup_power_B = $result[0];
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_C_power' ");
	$result = mysql_fetch_array($temp);
	$sup_power_C = $result[0];
	
	
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
				//php沒辦法讀取 $array_$letter[$i]  (就是一個變數裡有兩個變數)  故用if來做 (i,j)可能狀況的判斷
				if($i==0 && $j==0){
					$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_A){
						$overflow = true;
					}
				}
				else if($i==0 && $j==1){
					$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_B){
						$overflow = true;
					}
				}
				else if($i==0 && $j==2){
					$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_C){
						$overflow = true;
					}
				}
				else if($i==1 && $j==0){
					$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_A){
						$overflow = true;
					}
				}
				else if($i==1 && $j==1){
					$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_B){
						$overflow = true;
					}
				}
				else if($i==1 && $j==2){
					$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_C){
						$overflow = true;
					}
				}
				else if($i==2 && $j==0){
					$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_A){
						$overflow = true;
					}
				}
				else if($i==2 && $j==1){
					$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_B){
						$overflow = true;
					}
				}
				else if($i==2 && $j==2){
					$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE `year`='$year' AND `month`='$month'");
					$result = mysql_fetch_array($temp);
					$Total_material = $result[0];
					if($Total_material > $sup_power_C){
						$overflow = true;
					}
				}
				
			
			if($overflow == true){
				for($k=0;$k<$c_length;$k++){
				
					if($i==0 && $j==0){
						$temp = mysql_query("SELECT `ma_supplier_a` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_a WHERE `cid`='$cid[$k]' AND `source`='1'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==0 && $j==1){
						$temp = mysql_query("SELECT `ma_supplier_b` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_b WHERE `cid`='$cid[$k]' AND `source`='1'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==0 && $j==2){
						$temp = mysql_query("SELECT `ma_supplier_c` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_c WHERE `cid`='$cid[$k]' AND `source`='1'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==1 && $j==0){
						$temp = mysql_query("SELECT `mb_supplier_a` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_a WHERE `cid`='$cid[$k]' AND `source`='2'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==1 && $j==1){
						$temp = mysql_query("SELECT `mb_supplier_b` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_b WHERE `cid`='$cid[$k]' AND `source`='2'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==1 && $j==2){
						$temp = mysql_query("SELECT `mb_supplier_c` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_c WHERE `cid`='$cid[$k]' AND `source`='2'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==2 && $j==0){
						$temp = mysql_query("SELECT `mc_supplier_a` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_a WHERE `cid`='$cid[$k]' AND `source`='3'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==2 && $j==1){
						$temp = mysql_query("SELECT `mc_supplier_b` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_b WHERE `cid`='$cid[$k]' AND `source`='3'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					else if($i==2 && $j==2){
						$temp = mysql_query("SELECT `mc_supplier_c` FROM `purchase_materials` WHERE `cid`='$cid[$k]' AND `year`='$year' AND `month`='$month'");
						$result = mysql_fetch_array($temp);
						$material[$k] = $result[0];
						
						$temp = mysql_query("SELECT SUM(`quantity`) FROM supplier_c WHERE `cid`='$cid[$k]' AND `source`='3'");
						$result = mysql_fetch_array($temp);
						$quantity[$k] = $result[0];
					}
					
					
					if($material[$k] > $quantity[$k]){
						$True_material[$k] = $material[$k] - $quantity[$k];
						$True_quantity[$k] = $quantity[$k];
					}
					else{
						$True_material[$k] = 0;
						$True_quantity[$k] = $material[$k];
					}
					
					$Total_True_material += $True_material[$k];
					$Total_True_quantity += $True_quantity[$k];
					
				}//end of for_k
				
				if($j == 0){
					$True_sup_power_[$j] = $sup_power_A - $Total_True_quantity; 
				}
				else if($j == 1){
					$True_sup_power_[$j] = $sup_power_B - $Total_True_quantity; 
				}
				else{
					$True_sup_power_[$j] = $sup_power_C - $Total_True_quantity; 
				}
				
				for($L=0;$L<$c_length;$L++){
					
					if($Total_True_material != 0 ){
						$Ratio[$L] = $True_material[$L] / $Total_True_material;
					}
					else{
						$Ratio[$L] = 0;
					}
					$Last_material[$L] = $Ratio[$L] * $True_sup_power_[$j] + $True_quantity[$L];
					
					if($i==0 && $j==0){
						mysql_query("UPDATE `purchase_materials` SET `ma_supplier_a` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
						//echo $Last_material[$L]." || ".$year." || ".$month." || ".$material[$L]." || ".$c_length."\n";
					}
					else if($i==0 && $j==1){
						mysql_query("UPDATE `purchase_materials` SET `mb_supplier_a` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==0 && $j==2){
						mysql_query("UPDATE `purchase_materials` SET `mc_supplier_a` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==1 && $j==0){
						mysql_query("UPDATE `purchase_materials` SET `ma_supplier_b` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==1 && $j==1){
						mysql_query("UPDATE `purchase_materials` SET `mb_supplier_b` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==1 && $j==2){
						mysql_query("UPDATE `purchase_materials` SET `mc_supplier_b` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==2 && $j==0){
						mysql_query("UPDATE `purchase_materials` SET `ma_supplier_c` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==2 && $j==1){
						mysql_query("UPDATE `purchase_materials` SET `mb_supplier_c` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
					else if($i==2 && $j==2){
						mysql_query("UPDATE `purchase_materials` SET `mc_supplier_c` = '$Last_material[$L]' WHERE `cid`='$cid[$L]' AND `year`='$year' AND `month`='$month' ");
					}
						
					
				}//end of for_L
				
			}//end of if(overflow == true)
			$overflow = false;
			$Total_True_material = 0;//避免下一輪k時起始值不為0
			$Total_True_quantity = 0;
		}
	}
	//echo '';
?>
