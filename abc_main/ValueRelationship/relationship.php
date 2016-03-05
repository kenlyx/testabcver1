<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    session_start();
    $cid=$_SESSION['cid'];
    $year=$_SESSION['year'];
    $month=$_SESSION['month'];
	
	//$cid = "C1";
	//$year = 2;
	//$month = 8;
	error_reporting(0);
    $year1=0;
    $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main",$connect);
    mysql_query("set names 'utf8'");
    if(!strcmp($_GET['type'],"customer")){
        $b_customer=array();$c_customer=array();$all_customer=array();
        $result=mysql_query("SELECT `customer` FROM `customer_satisfaction` WHERE `cid`= '$cid' ORDER BY `satisfaction`  ",$connect);
        $temp=mysql_fetch_array($result);
        if($temp==NULL)
            echo "NULL";
        else{
            $result=mysql_query("SELECT `customer` FROM `customer_satisfaction` WHERE `cid`= '$cid' ORDER BY `satisfaction`  ",$connect);
            while($temp=mysql_fetch_array($result)){
                array_push($all_customer,$temp[0]);
            }
            for($i=0;$i<sizeof($all_customer);$i++){
                $result=mysql_query("SELECT `b_or_c`,`index` FROM `customer_state` WHERE `name`= '$all_customer[$i]'",$connect);
                $temp_result=mysql_fetch_array($result);
                if($temp_result[0]==1)
                    array_push($c_customer,$temp_result[1]);
                if($temp_result[0]==0)
                    array_push($b_customer,$temp_result[1]);
            }
            if(!strcmp($_GET['type2'],"b2bG")){
                for($i=0;($i<count($b_customer)&&$i<3);$i++){
                    echo $b_customer[$i].";";
                }
            }
            else if(!strcmp($_GET['type2'],"b2bB")){
                for($i=0;($i<count($b_customer)&&$i<3);$i++){
					$ind = count($b_customer);
					
                    echo $b_customer[$ind - 1 - $i].";";
                }
            }
            else if(!strcmp($_GET['type2'],"b2cG")){
                for($i=0;($i<count($c_customer)&&$i<3);$i++){
                    echo $c_customer[$i].";";
                }
            }
            else if(!strcmp($_GET['type2'],"b2cB")){
                for($i=0;($i<count($c_customer)&&$i<3);$i++){
                    echo $c_customer[(count($c_customer)-1-$i)].";";
                }
            }

//            echo count($c_customer)."|";
//            if(count($c_customer)<=6){
//                for($i=0;$i<count($c_customer);$i++)
//                    echo $c_customer[$i].",";
//            }
//            else if(count($c_customer)>6){
//                for($i=0;$i<3;$i++)
//                    echo $c_customer[$i].",";
//                for($i=3;$i>0;$i++)
//                    echo $c_customer[count($c_customer)-$i].",";
//            }
//            echo ";".count($b_customer)."|";
//            if(count($b_customer)<=6){
//                for($i=0;$i<count($b_customer);$i++)
//                    echo $b_customer[$i].",";
//            }
//            else if(count($b_customer)>6){
//                for($i=0;$i<3;$i++)
//                    echo $b_customer[$i].",";
//                for($i=3;$i>0;$i++)
//                    echo $b_customer[count($c_customer)-$i].",";
//            }
        }
    }
    if(!strcmp($_GET['type'],"customer_data")){
        $customer_index=$_GET['name'];
        $result=mysql_query("SELECT `name` FROM `customer_state` WHERE `index`='$customer_index'",$connect);
        $customer=mysql_fetch_array($result);
        $result=mysql_query("SELECT `satisfaction` FROM `customer_satisfaction` WHERE `cid`= '$cid' AND `customer`='$customer[0]'",$connect);
        $temp_result=mysql_fetch_array($result);
        $result=mysql_query("SELECT `level` FROM `relationship_decision` WHERE `target`='customer_$customer_index' AND `cid` = '$cid' AND `year` = $year AND `month` = $month",$connect);
        $have_done=mysql_fetch_array($result);
        echo $customer[0].",".$temp_result[0].";".$have_done[0];//.",";
        //$result=mysql_query("SELECT * FROM `customer_state` WHERE `customer`='$customer'",$connect);
        //$temp_result=  mysql_fetch_array($result);
    }
    if(!strcmp($_GET['type'],"employee")){
        $arr=Array("finance","equip","sale","human","research");
        $result=mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `department` = '{$arr[$_GET['type2']-1]}' AND `cid` = '$cid' AND (`year` < $year OR ( `year` = $year AND `month` < $month ))",$connect);
        $temp=mysql_fetch_array($result);
        echo $temp[0]-$temp[1];
    }
    if(!strcmp($_GET['type'],"investor_data")){
        if($year!=1||$month!=1){
            if($month==1){
                $month1=12;
                $year1=$year-1;
            }
            else{
                $year1=$year;
                $month1=$month-1;
            }
            $result=mysql_query("SELECT `d_ic` FROM `fund_raising` WHERE `cid` = '$cid' AND `year` = $year1 AND `month` = $month1",$connect);//這裡用來讀取re的值，現在不知道在哪裡。
            $temp_result=mysql_fetch_array($result);
        }
        else
            $temp_result[0]=0;
        $result=mysql_query("SELECT MAX(`level`) FROM `relationship_decision` WHERE `target`='investor_0' AND `cid` = '$cid' AND (`year` < $year OR ( `year` = $year AND `month` < $month ))",$connect);
        $temp_result2=mysql_fetch_array($result);
        if($temp_result2[0]=="")
            $temp_result2[0]=0;
        $result=mysql_query("SELECT `level` FROM `relationship_decision` WHERE `target`='investor_0' AND `cid` = '$cid' AND `year` = $year AND `month` = $month",$connect);
        $have_done=mysql_fetch_array($result);
        echo $temp_result[0].",".$temp_result2[0].";".$have_done[0];//.",";
    }
    if(!strcmp($_GET['type'],"update")){
        $all_decision=$_GET['result'];
        $each_decision=split(";",$all_decision);
        for($i=0;$i<sizeof($each_decision);$i++){
            $r_decision=split(",",$each_decision[$i]);
            $target=$r_decision[0];
            mysql_query("DELETE FROM `relationship_decision` WHERE `cid` = '$cid' AND `target` = '$target' AND `year` = $year AND `month` = $month;",$connect);
            for($j=1;$j<sizeof($r_decision);$j++){
                $detail=split("=",$r_decision[$j]);
                mysql_query("INSERT INTO `relationship_decision` (`cid`, `year`, `month`, `target`, `decision`, `level`) VALUES ('$cid', $year, $month, '$target', '$detail[0]', $detail[1]);",$connect);
                //echo "DELETE FROM `relationship_decision` WHERE `cid` = '$cid' AND `target` = '$target' AND `year` = $year AND `month` = $month";
                //echo "INSERT INTO `relationship_decision` (`cid`, `year`, `month`, `target`, `decision`, `level`) VALUES ('$cid', $year, $month, '$target', '$detail[0]', $detail[1])";
            }
        }
    }
    if(!strcmp($_GET['type'],"get_netin")){
        //$result=mysql_query("",$connect);//取得上期的淨利
        //$temp=mysql_fetch_array($result);
        $month1=($year-1)*12+$month;
        $result=mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$cid' AND `month` = $month1",$connect);
        $temp=mysql_fetch_array($result);
        $revenue=$temp[0];
        $result=mysql_query("SELECT SUM(`price`) FROM `operating_costs` WHERE `cid`='$cid' AND `month` = $month1",$connect);
        $temp=mysql_fetch_array($result);
        $cost=$temp[0];
        $gross_profit=$revenue-$cost;//尚未詢問此值於報表何處，暫時寫死，得出結果後更改上述SQL語法即可。
        $result=mysql_query("SELECT `level` FROM `relationship_decision` WHERE `target`='{$_GET['supplier']}' AND `cid` = '$cid' AND `year` = $year AND `month` = $month",$connect);
        $have_done=mysql_fetch_array($result);
        echo $gross_profit.";".$have_done[0];
    }
    if(!strcmp($_GET['type'],"get_salary")){
        $department=$_GET['dep']."_salary";
        $result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='$department' ",$connect);
        $salary=mysql_fetch_array($result);
        $result=mysql_query("SELECT `level` FROM `relationship_decision` WHERE `target`='empolyee_{$_GET['dep']}' AND `cid` = '$cid' AND `year` = $year AND `month` = $month",$connect);
        $have_done=mysql_fetch_array($result);
        echo $salary[0].";".$have_done[0];
    }
	if($_GET['option']=="update"){
		$decision=$_GET['decision'];
		$split=split("_",$decision);
		$cus="customer_".$split[0];
		$star=$split[1];
		mysql_query("INSERT INTO `relationship_decision` (`cid`, `year`, `month`, `target`, `decision`, `level`) VALUES ('$cid', $year, $month, '$cus', 'd_2', $star)",$connect);
		}
?>
