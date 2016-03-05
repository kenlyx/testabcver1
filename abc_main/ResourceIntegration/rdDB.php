<?php session_start();?>
<?php
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
	mysql_query("set names 'utf8'");
    $cid = $_SESSION['cid'];
    $sql_year=mysql_query("SELECT MAX(`year`) FROM `state` WHERE `cid`='$cid'");
	$year=mysql_fetch_array($sql_year);
	$sql_month=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `cid`='$cid' AND `year`=$year[0]");
	$month=mysql_fetch_array($sql_month);
	
	$_SESSION['year']=$year[0];
	$_SESSION['month']=$month[0];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	//echo $year[0]."|".$month[0]."|".$cid;
	/*
    if(isset($_GET['decision'])){
        $decision_arr=split(":",$_GET['decision']);*/
	//公司、產品、原料、年、月、供應商A、供應商B、供應商C
    if(isset($_GET['product'])){   
		if (!strcmp($_GET['product'], "A")) {
			
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','A',1,$year,$month,-1,-1,-1);");
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','A',2,$year,$month,-1,-1,-1);");
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','A',3,$year,$month,-1,-1,-1);");
            mysql_query("UPDATE `contract` SET `signA`=1 WHERE `cid` = '$cid' AND `year`=$year AND `month`=$month");
			
				//原料(1:panel/2:CPU/3:keyboard)_供應商(A/B/C)
                if($_GET['p_A']&&$_GET['price_pA']){
					$pnum=$_GET['p_A'];
					$per_price=$_GET['price_pA'];
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$cid','A',1,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['c_A']&&$_GET['price_cA']){
					$pnum=$_GET['c_A'];
					$per_price=$_GET['price_cA'];
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$cid','A',2,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['k_A']&&$_GET['price_kA']){
					$pnum=$_GET['k_A'];
					$per_price=$_GET['price_kA'];
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$cid','A',3,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['p_B']&&$_GET['price_pB']){
					$pnum=$_GET['p_B'];
					$per_price=$_GET['price_pB'];
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$cid','A',1,$year,$month,$per_price,$pnum,0);");
                }
                 if($_GET['c_B']&&$_GET['price_cB']){
					$pnum=$_GET['c_B'];
					$per_price=$_GET['price_cB'];
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$cid','A',2,$year,$month,$per_price,$pnum,0);");
                }
                 if($_GET['k_B']&&$_GET['price_kB']){
					$pnum=$_GET['k_B'];
					$per_price=$_GET['price_kB'];
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$cid','A',3,$year,$month,$per_price,$pnum,0);");
                }
                 if($_GET['p_C']&&$_GET['price_pC']){
					$pnum=$_GET['p_C'];
					$per_price=$_GET['price_pC'];
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$cid','A',1,$year,$month,$per_price,$pnum,0);");
                }
               if($_GET['c_C']&&$_GET['price_cC']){
					$pnum=$_GET['c_C'];
					$per_price=$_GET['price_cC'];
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$cid','A',2,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['k_C']&&$_GET['price_kC']){
					$pnum=$_GET['k_C'];
					$per_price=$_GET['price_kC'];
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$cid','A',3,$year,$month,$per_price,$pnum,0);");
                }
            
            mysql_query("UPDATE `state` SET `product_A_RD`='1' WHERE `cid`='$cid' AND `month`='$month' AND `year`='$year';");
        }
        else if(!strcmp($_GET['product'], "B")){
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','B',1,$year,$month,-1,-1,-1);");
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','B',2,$year,$month,-1,-1,-1);");
            mysql_query("INSERT INTO `r_d` VALUES ('$cid','B',3,$year,$month,-1,-1,-1);");
            mysql_query("UPDATE `contract` SET `signB`=1 WHERE `cid` = '$cid' AND `year`=$year AND `month`=$month");
            echo $_GET['p_A']."|".$_GET['c_A']."|".$_GET['price_pA'];
               //原料(1:panel/2:CPU/3:keyboard)_供應商(A/B/C)
                if($_GET['p_A']&&$_GET['price_pA']){
					$pnum=$_GET['p_A'];
					$per_price=$_GET['price_pA'];
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$cid','B',1,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['c_A']&&$_GET['price_cA']){
					$pnum=$_GET['c_A'];
					$per_price=$_GET['price_cA'];
                    mysql_query("INSERT INTO `supplier_a` VALUES ('$cid','B',2,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['p_B']&&$_GET['price_pB']){
					$pnum=$_GET['p_B'];
					$per_price=$_GET['price_pB'];
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$cid','B',1,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['c_B']&&$_GET['price_cB']){
					$pnum=$_GET['c_B'];
					$per_price=$_GET['price_cB'];
                    mysql_query("INSERT INTO `supplier_b` VALUES ('$cid','B',2,$year,$month,$per_price,$pnum,0);");
                }
                if($_GET['p_C']&&$_GET['price_pC']){
					$pnum=$_GET['p_C'];
					$per_price=$_GET['price_pC'];
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$cid','B',1,$year,$month,$per_price,$pnum,0);");
                }
                  if($_GET['c_C']&&$_GET['price_cC']){
					$pnum=$_GET['c_C'];
					$per_price=$_GET['price_cC'];
                    mysql_query("INSERT INTO `supplier_c` VALUES ('$cid','B',2,$year,$month,$per_price,$pnum,0);");
                }
            
            mysql_query("UPDATE `state` SET `product_B_RD`=1 WHERE `cid`='$cid' AND `month`=$month AND `year`= $year;");
			echo "update";
        }
  }
    if(isset($_GET['result'])){
        if(!strcmp($_GET['result'], "all")){
            $arr=array(0,0);
			$arr1=array(0,0);
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND cid` = '$cid' ");
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            $result=mysql_query("SELECT SUM(`refresh`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$cid' AND `refresh`=2");
            $temp=mysql_fetch_array($result);
            if($temp[0]!=NULL)
                $arr[1]-=$temp[0]/2;
            $result=mysql_query("SELECT SUM(`refresh`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$cid' AND `refresh`=1");
            $temp=mysql_fetch_array($result);
            if($temp[0]!=NULL)
                $arr[0]-=$temp[0];
            $result=mysql_query("SELECT `product_A_RD` , `product_B_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$cid' ");
            $arr1=mysql_fetch_array($result);
            if($arr1[0]==NULL)
                $arr1=array(0,0);
            echo $arr[0].",".$arr[1].",".$arr1[0].",".$arr1[1];
        }
        else if(!strcmp($_GET['result'], "refresh")){
            if(!strcmp($_GET['type'], "A")){
                $temp=mysql_query("SELECT `product_A_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$cid' ");
                $result=mysql_fetch_array($temp);
                if($result[0]==0){
                    $result=mysql_query("SELECT SUM(`product_A_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$cid' ");
                    $arr=mysql_fetch_array($result);
                    if($arr[0]!=NULL){
                        $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid` = '$cid' AND `type` = 'A' AND `source` =1");
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
                $temp=mysql_query("SELECT `product_B_RD` FROM `state` WHERE `month`= $month AND `year`= $year AND `cid` = '$cid' ");
                $result=mysql_fetch_array($temp);
                if($result[0]==0){
                    $result=mysql_query("SELECT SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$cid' ");
                    $arr=mysql_fetch_array($result);
                    if($arr[0]!=NULL){
                        $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid` = '$cid' AND `type` = 'B' AND `source` =1");
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
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`< $month AND `year`= $year )) AND `cid` = '$cid' ");
			//echo "SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`< $month AND `year`= $year )) AND `cid` = '$cid' ";
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            echo $arr[0].",".$arr[1];
        }
        else if(!strcmp($_GET['result'], "A")){
            $result=mysql_query("SELECT `product_A_RD` FROM `state` WHERE `cid`='$cid' AND `month`= $month AND `year`= $year AND `cid` = '$cid' ");
            $arr=mysql_fetch_array($result);
            if($arr[0]==1){
                $arr=array("a","b","c");
                for($i=0;$i<3;$i++){
                    for($j=1;$j<=3;$j++){
                        $temp=mysql_query("SELECT `price`,`quantity` FROM `supplier_$arr[$i]` WHERE `cid` = '$cid' AND `month`= $month AND `year`=$year AND `type` = 'A' AND `source` = '$j'");
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
                    $temp=mysql_query("SELECT * FROM `r_d` WHERE `cid` = '$cid' AND `type` = 'A' AND `source` = '$i'");
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
            $result=mysql_query("SELECT `product_B_RD` FROM `state` WHERE `cid`='$cid' AND `month`= $month AND `year`= $year AND `cid` = '$cid' ");
            $arr=mysql_fetch_array($result);
            if($arr[0]==1){
                $arr=array("a","b","c");
                for($i=0;$i<3;$i++){
                    for($j=1;$j<=2;$j++){
                        $temp=mysql_query("SELECT `price`,`quantity` FROM `supplier_$arr[$i]` WHERE `cid` = '$cid' AND `month`= $month AND `type` = 'B' AND `source` = '$j'");
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
                    $temp=mysql_query("SELECT * FROM `r_d` WHERE `cid` = '$cid' && `type` = 'B' && `source` = '$i'");
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
            mysql_query("DELETE FROM `supplier_a` WHERE `cid` = '$cid' && `month`= $month;");
            mysql_query("DELETE FROM `supplier_b` WHERE `cid` = '$cid' && `month`= $month;");
            mysql_query("DELETE FROM `supplier_c` WHERE `cid` = '$cid' && `month`= $month;");
            mysql_query("DELETE FROM `r_d` WHERE `cid` = '$cid' && `month`= $month;");
            mysql_query("UPDATE `state` SET `product_A_RD`=0 ,`product_B_RD`=0 WHERE `cid`='$cid' AND `month`= $month AND `year`= $year;");
            $result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`<= $month AND `year`= $year )) AND `cid` = '$cid' ");
            $arr=mysql_fetch_array($result);
            if($arr[0]==NULL)
                $arr=array(0,0);
            echo $arr[0].",".$arr[1].",0,0";
        }
        else if(!strcmp($_GET['action'], "refresh")){
            $type=$_GET['type'];
            $temp=mysql_query("SELECT `year` ,`month` FROM `r_d` WHERE `cid` = '$cid' AND `type` = '$type'");
            $result=mysql_fetch_array($temp);
            $due=12-((($year-1)*12+$month)-(($result[0]-1)*12+$result[1]))+1;
            if($due>0){
                echo "違約通知! 需繳交 $".($due*1000)."的違約金...";
		mysql_query("UPDATE `contract` SET `sign$type`='-1' ,`break$type`=1 ,`price`=$due*1000 WHERE `cid` = '$cid' AND `year`=$year AND `month`=$month");
                $temp=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `cid`='$cid' AND `type`='$type';");
                while($result=  mysql_fetch_array($temp)){
                    if($result[0]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_a` FROM `supplier_satisfaction` WHERE `cid`='$cid';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_a`=$value WHERE `cid`='$cid';");
                    }
                    if($result[1]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_b` FROM `supplier_satisfaction` WHERE `cid`='$cid';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_b`=$value WHERE `cid`='$cid';");
                    }
                    if($result[2]!=-1){
                        $sub_temp=mysql_query("SELECT `satisfaction_c` FROM `supplier_satisfaction` WHERE `cid`='$cid';");
                        $sub_result=mysql_fetch_array($sub_temp);
                        $value=$sub_result[0]-$due*0.1;
                        mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_c`=$value WHERE `cid`='$cid';");
                    }
                }
            }
            if($type=="A")
                mysql_query("UPDATE `state` SET `refresh`=1,`product_A_RD`=0,`product_B_RD`=0 WHERE `cid`='$cid' AND `month`= $month AND `year`= $year;");
            else
                mysql_query("UPDATE `state` SET `refresh`=2,`product_A_RD`=0,`product_B_RD`=0 WHERE `cid`='$cid' AND `month`= $month AND `year`= $year;");
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$cid' AND `type`='$type' AND `source`=1;") or die(mysql_error());
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$cid' AND `type`='$type' AND `source`=2;") or die(mysql_error());
            mysql_query("UPDATE `r_d` SET `year`=$year,`month`=$month,`supplier_A`=-1,`supplier_B`=-1,`supplier_C`=-1 WHERE `cid`='$cid' AND `type`='$type' AND `source`=3;") or die(mysql_error());
            mysql_query("DELETE FROM `supplier_a` WHERE `cid` = '$cid' && `type`= '$type';");
            mysql_query("DELETE FROM `supplier_b` WHERE `cid` = '$cid' && `type`= '$type';");
            mysql_query("DELETE FROM `supplier_c` WHERE `cid` = '$cid' && `type`= '$type';");
        }
    }
?>