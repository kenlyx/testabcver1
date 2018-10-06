<?php
    session_start();
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $b_or_c=mysql_real_escape_string($_POST['type']);
    $temp=mysql_query("SELECT * FROM `order_detail`",$connect);
    $result=  mysql_fetch_array($temp);
    $str="";
    $company=$_SESSION['cid'];
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
	
	$temp=mysql_query("SELECT MIN(`rank`) FROM `product_quality`  WHERE `cid`='$company' AND `product`='A'",$connect);
	$result= mysql_fetch_array($temp);
	$ohya=$result[0];
	$temp=mysql_query("SELECT MIN(`rank`) FROM `product_quality`  WHERE `cid`='$company' AND `product`='B'",$connect);
	$result= mysql_fetch_array($temp);
    $ohya1=$result[0];
	
	$RD_result=mysql_query("SELECT SUM(`product_A_RD`) , SUM(`product_B_RD`) FROM `state` WHERE (`year`< $year OR ( `month`< $month AND `year`= $year )) AND `cid` = '$company' ",$connect);
    $Rd_result=mysql_fetch_array($RD_result);
    $RD_done_A=$Rd_result[0];
    $RD_done_B=$Rd_result[1];
    if(!empty($result)){
        $temp=mysql_query("SELECT * FROM `order_detail` WHERE `b_or_c`=$b_or_c",$connect);
        while($result=mysql_fetch_array($temp)){
            $no=$result['order_no'];
            $sub_temp=mysql_query("SELECT * FROM `order_accept` WHERE `cid`='$company' AND `order_no`='$no';",$connect);
            $sub_result=mysql_fetch_array($sub_temp);
            if($sub_result==NULL){
                if($result['quality']==1)
                    $quality="高";
                else if($result['quality']==2)
                    $quality="次高";
                else if($result['quality']==3)
                    $quality="中";
                else if($result['quality']==4)
                    $quality="次低";
                else if($result['quality']==5)
                    $quality="低";
                if($result['service']==1)
                    $service="高";
                else if($result['service']==2)
                    $service="次高";
                else if($result['service']==3)
                    $service="中";
                else if($result['service']==4)
                    $service="次低";
                else if($result['service']==5)
                    $service="低";
                if($b_or_c==0){
                    if($result['type']==mysql_real_escape_string($_POST['rank'])){
                        $product_result=explode('_',$result['order_no']);
                       	if((!strcmp($product_result[1],"A"))&&($RD_done_A==1)&&(
						$result['quality']>=$ohya))//判斷A產品
                            $str.="".$result['name'].","."訂單編號： ".$result['order_no'].","."下單時間： 第".$result['year']."年 ".$result['month']."月,"."品質需求： ".$quality.","."服務需求： ".$service.","."訂貨量： ".$result['quantity'].","."剩餘時間： ".$result['postpone']."個月".",".mysql_real_escape_string($_POST['rank']).";";
                        else if(!strcmp($product_result[1],"B")&&$RD_done_B==1&&($result['quality']>=$ohya1))//判斷為B產品
                            $str.="".$result['name'].","."訂單編號： ".$result['order_no'].","."下單時間： 第".$result['year']."年 ".$result['month']."月,"."品質需求： ".$quality.","."服務需求： ".$service.","."訂貨量： ".$result['quantity'].","."剩餘時間： ".$result['postpone']."個月".",".mysql_real_escape_string($_POST['rank']).";";
                    }
                }
                else{
                    $rank=$result['type'];
                    $product_result=explode('_',$result['order_no']);
                        if((!strcmp($product_result[1],"A"))&&($RD_done_A==1)&&($result['quality']>=$ohya))//判斷A產品
                            $str.="".$result['name'].","."訂單編號： ".$result['order_no'].","."下單時間： 第".$result['year']."年 ".$result['month']."月,"."品質需求： ".$quality.","."服務需求： ".$service.","."訂貨量： ".$result['quantity'].","."剩餘時間： ".$result['postpone']."個月".",".$rank.";";
                        else if(!strcmp($product_result[1],"B")&&$RD_done_B==1&&($result['quality']>=$ohya1))//判斷為B產品
                            $str.="".$result['name'].","."訂單編號： ".$result['order_no'].","."下單時間： 第".$result['year']."年 ".$result['month']."月,"."品質需求： ".$quality.","."服務需求： ".$service.","."訂貨量： ".$result['quantity'].","."剩餘時間： ".$result['postpone']."個月".",".$rank.";";
                }
            }
        }
        echo $str;
		$str="";
    }
?>
