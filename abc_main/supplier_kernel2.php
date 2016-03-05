<?php
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
    //以下是月份推進後，分配原料的部分。其中供應商關係的參數尚未寫入資料表，故暫時將資料寫死，並將(應該)正確的程式碼進行註解。(分別在123行與160行。)

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
                        if($rd_materials['supplier_'.$supplier_arr[$j]]!=-1)
                            $rd_num=split(":",$rd_materials['supplier_'.$supplier_arr[$j]]);
                        else
                            $rd_num[1]=0;
//                        echo $rd_materials['supplier_'.$supplier_arr[$j]].";";
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
                            if($rd_materials['supplier_'.$supplier_arr[$j]]!=-1)
                                $rd_num=split(":",$rd_materials['supplier_'.$supplier_arr[$j]]);
                        }
                    }
                    if($e>=$supplier_power[$j]){
                        if($rd_num[1]<$pur_num[0])
                            $ture_materials = $rd_num[1];
                        else
                            $ture_materials = $pur_num[0];
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
                        else
                            $ture_materials = $pur_num[0];
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
?>