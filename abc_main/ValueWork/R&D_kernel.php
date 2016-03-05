<?php
    session_start();
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $company=$_SESSION['cid'];
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
    if(isset($_GET['decision'])){
        $arrs=split(":",$_GET['decision']);
        if (!strcmp($_GET['product'], "A")) {
            mysql_query("INSERT INTO `r_d` VALUES ('$company','A',1,$year,$month,-1,-1,-1);",$connect);
            mysql_query("INSERT INTO `r_d` VALUES ('$company','A',2,$year,$month,-1,-1,-1);",$connect);
            mysql_query("INSERT INTO `r_d` VALUES ('$company','A',3,$year,$month,-1,-1,-1);",$connect);
            mysql_query("UPDATE `contrast` SET `signA`=1 WHERE `cid` = '$company' AND `year`=$year AND `month`=$month",$connect);
			echo $_GET['product'];
            foreach($arrs as $arr){
                $value=split("=",$arr);
                if($value[0] === "A_A_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$company','A',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_B_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$company','A',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_C_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$company','A',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_A_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$company','A',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_B_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$company','A',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_C_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$company','A',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_A_3"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$company','A',3,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_B_3"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$company','A',3,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "A_C_3"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$company','A',3,$year,$month,$result[0],$result[1],0);",$connect);
                }
            }
            mysql_query("UPDATE `state` SET `product_A_RD`=1 WHERE `cid`='$company' AND `month`=$month AND `year` = $year;",$connect);
        }
        else if(!strcmp($_GET['product'], "B")){
            mysql_query("INSERT INTO `r_d` VALUES ('$company','B',1,$year,$month,-1,-1,-1);",$connect);
            mysql_query("INSERT INTO `r_d` VALUES ('$company','B',2,$year,$month,-1,-1,-1);",$connect);
            mysql_query("INSERT INTO `r_d` VALUES ('$company','B',3,$year,$month,-1,-1,-1);",$connect);
            mysql_query("UPDATE `contrast` SET `signB`=1 WHERE `cid` = '$company' AND `year`=$year AND `month`=$month",$connect);
            foreach($arrs as $arr){
                $value=split("=",$arr);
                if($value[0] === "B_A_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$company','B',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "B_B_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$company','B',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "B_C_1"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$company','B',1,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "B_A_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$company','B',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "B_B_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$company','B',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
                if($value[0] === "B_C_2"){
                    $result=split(",",$value[1]);
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$company','B',2,$year,$month,$result[0],$result[1],0);",$connect);
                }
            }
            mysql_query("UPDATE `state` SET `product_B_RD`=1 WHERE `cid`='$company' AND `month`=$month AND `year`= $year;",$connect);
        }
    }
    if(isset($_GET['result'])){
        if(!strcmp($_GET['result'], "all")){
            $arr=array(0,0);$arr1=array(0,0);
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            $result=mysql_query("SELECT SUM(`refresh`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' AND `refresh`=2",$connect);
            $temp=mysql_fetch_array($result);
            if($temp[0]!=NULL)
                $arr[1]-=$temp[0]/2;
            $result=mysql_query("SELECT SUM(`refresh`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' AND `refresh`=1",$connect);
            $temp=mysql_fetch_array($result);
            if($temp[0]!=NULL)
                $arr[0]-=$temp[0];
            $result=mysql_query("SELECT `product_A_RD` , `product_B_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$company' ",$connect);
            $arr1=mysql_fetch_array($result);
            if($arr1[0]==NULL)
                $arr1=array(0,0);
            echo $arr[0].",".$arr[1].",".$arr1[0].",".$arr1[1];
        }
        else if(!strcmp($_GET['result'], "refresh")){
            if(!strcmp($_GET['type'], "A")){
                $temp=mysql_query("SELECT `product_A_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$company' ",$connect);
                $result=mysql_fetch_array($temp);
                if($result[0]==0){
                    $result=mysql_query("SELECT SUM(`product_A_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
                    $arr=mysql_fetch_array($result);
                    if($arr[0]!=NULL){
                        $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid` = '$company' AND `type` = 'A' AND `source` =1",$connect);
                        $result=mysql_fetch_array($temp);
                        if($result[0]=='-1' && $result[1]=='-1' && $result[2]=='-1')
                            echo "1";
                        else
                            echo "0";
                    }
                }
                else
                    echo "0";
            }
            else if(!strcmp($_GET['type'], "B")){
                $temp=mysql_query("SELECT `product_B_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$company' ",$connect);
                $result=mysql_fetch_array($temp);
                if($result[0]==0){
                    $result=mysql_query("SELECT SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
                    $arr=mysql_fetch_array($result);
                    if($arr[0]!=NULL){
                        $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid` = '$company' AND `type` = 'B' AND `source` =1",$connect);
                        $result=mysql_fetch_array($temp);
                        if($result[0]=='-1' && $result[1]=='-1' && $result[2]=='-1')
                            echo "1";
                        else
                            echo "0";
                    }
                }
                else
                    echo "0";
            }
        }
        else if(!strcmp($_GET['result'], "detail")){
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`< $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
			//echo "SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`< $month AND `year`= $year )) AND `cid` = '$company' ";
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            echo $arr[0].",".$arr[1];
        }
        else if(!strcmp($_GET['result'], "A")){
            $result=mysql_query("SELECT `product_A_RD` FROM `state` WHERE `cid`='$company' AND `month`= $month AND `year`= $year AND `cid` = '$company' ",$connect);
            $arr=mysql_fetch_array($result);
            if($arr[0]==1){
                $arr=array("a","b","c");
                for($i=0;$i<3;$i++){
                    for($j=1;$j<=3;$j++){
                        $temp=mysql_query("SELECT `price`,`quantity` FROM `supplier_$arr[$i]` WHERE `cid` = '$company' AND `month`= $month AND `year`=$year AND `type` = 'A' AND `source` = '$j'",$connect);
                        $result=mysql_fetch_array($temp);
                        echo $result[0].":".$result[1].",";
                    }
                    echo "|";
                }
                echo $year."|".$month."|1";
            }
            else{
                $arr=array();
                for($i=1;$i<=3;$i++){
                    $temp=mysql_query("SELECT * FROM `r_d` WHERE `cid` = '$company' AND `type` = 'A' AND `source` = '$i'",$connect);
                    $result=mysql_fetch_array($temp);
                    array_push($arr, $result[5]);
                    array_push($arr, $result[6]);
                    array_push($arr, $result[7]);
                }
                $temp=0;
                $temp=$arr[1];
                $arr[1]=$arr[3];
                $arr[3]=$temp;
                $temp=$arr[2];
                $arr[2]=$arr[6];
                $arr[6]=$temp;
                $temp=$arr[5];
                $arr[5]=$arr[7];
                $arr[7]=$temp;
                for($i=0;$i<sizeof($arr);$i+=3){
                    echo $arr[$i].",".$arr[$i+1].",".$arr[$i+2]."|";
                }
                echo $result[3]."|".$result[4]."|0";
            }
        }
        else if(!strcmp($_GET['result'], "B")){
            $result=mysql_query("SELECT `product_B_RD` FROM `state` WHERE `cid`='$company' AND `month`= $month AND `year`= $year AND `cid` = '$company' ",$connect);
            $arr=mysql_fetch_array($result);
            if($arr[0]==1){
                $arr=array("a","b","c");
                for($i=0;$i<3;$i++){
                    for($j=1;$j<=2;$j++){
                        $temp=mysql_query("SELECT `price`,`quantity` FROM `supplier_$arr[$i]` WHERE `cid` = '$company' AND `month`= $month AND `type` = 'B' AND `source` = '$j'",$connect);
                        $result=mysql_fetch_array($temp);
                        echo $result[0].":".$result[1].",";
                    }
                    echo "|";
                }
                echo $year."|".$month."|1";
            }
            else{
                $arr=array();
                for($i=1;$i<=3;$i++){
                    $temp=mysql_query("SELECT * FROM `r_d` WHERE `cid` = '$company' && `type` = 'B' && `source` = '$i'",$connect);
                    $result=mysql_fetch_array($temp);
                    array_push($arr, $result[5]);
                    array_push($arr, $result[6]);
                    array_push($arr, $result[7]);
                }
                $temp=0;
                $temp=$arr[1];
                $arr[1]=$arr[3];
                $arr[3]=$temp;
                $temp=$arr[2];
                $arr[2]=$arr[6];
                $arr[6]=$temp;
                $temp=$arr[5];
                $arr[5]=$arr[7];
                $arr[7]=$temp;
                for($i=0;$i<sizeof($arr);$i+=3){
                    echo $arr[$i].",".$arr[$i+1].",".$arr[$i+2]."|";
                }
                echo $result[3]."|".$result[4]."|0";
            }
        }
    }
    if(isset($_GET['action'])){
        if(!strcmp($_GET['action'], "cencel")){
            mysql_query("DELETE FROM `supplier_a` WHERE `cid` = '$company' && `month`= $month;",$connect);
            mysql_query("DELETE FROM `supplier_b` WHERE `cid` = '$company' && `month`= $month;",$connect);
            mysql_query("DELETE FROM `supplier_c` WHERE `cid` = '$company' && `month`= $month;",$connect);
            mysql_query("DELETE FROM `r_d` WHERE `cid` = '$company' && `month`= $month;",$connect);
            mysql_query("UPDATE `state` SET `product_A_RD`=0 ,`product_B_RD`=0 WHERE `cid`='$company' AND `month`= $month AND `year`= $year;",$connect);
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            echo $arr[0].",".$arr[1].",0,0";
        }
        else if(!strcmp($_GET['action'], "refresh")){
            $type=$_GET['type'];
            $temp=mysql_query("SELECT `year` ,`month` FROM `r_d` WHERE `cid` = '$company' AND `type` = '$type'",$connect);
            $result=mysql_fetch_array($temp);
            $due=12-((($year-1)*12+$month)-(($result[0]-1)*12+$result[1]))+1;
            if($due>0){
                echo "你違約了啦~!! 要繳交 $".($due*1000)."的違約金......";
		mysql_query("UPDATE `contrast` SET `sign$type`='-1' ,`break$type`=1 ,`price`=$due*1000 WHERE `cid` = '$company' AND `year`=$year AND `month`=$month",$connect);
                $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid`='$company' AND `type`='$type';");
                while($result=  mysql_fetch_array($temp)){
                    if($result[0]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_a` FROM `supplier_satisfaction` WHERE `cid`='$company';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_a`=$value WHERE `cid`='$company';");
                    }
                    if($result[1]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_b` FROM `supplier_satisfaction` WHERE `cid`='$company';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_b`=$value WHERE `cid`='$company';");
                    }
                    if($result[2]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_c` FROM `supplier_satisfaction` WHERE `cid`='$company';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_c`=$value WHERE `cid`='$company';");
                    }
                }
            }
            if($type=="A")
                mysql_query("UPDATE `state` SET `refresh`=1,`product_A_RD`=0,`product_B_RD`=0 WHERE `cid`='$company' AND `month`= $month AND `year`= $year;",$connect);
            else
                mysql_query("UPDATE `state` SET `refresh`=2,`product_A_RD`=0,`product_B_RD`=0 WHERE `cid`='$company' AND `month`= $month AND `year`= $year;",$connect);
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$company' AND `type`='$type' AND `source`=1;",$connect) or die(mysql_error());
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$company' AND `type`='$type' AND `source`=2;",$connect) or die(mysql_error());
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$company' AND `type`='$type' AND `source`=3;",$connect) or die(mysql_error());
            mysql_query("DELETE FROM `supplier_a` WHERE `cid` = '$company' && `type`= '$type';",$connect);
            mysql_query("DELETE FROM `supplier_b` WHERE `cid` = '$company' && `type`= '$type';",$connect);
            mysql_query("DELETE FROM `supplier_c` WHERE `cid` = '$company' && `type`= '$type';",$connect);
        }
    }
?>