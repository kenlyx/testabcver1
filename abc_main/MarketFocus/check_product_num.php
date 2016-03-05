<?php
    session_start();
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
	mysql_query("SET NAMES 'utf8'");
    $cid=$_SESSION['cid'];
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
    $str=$_POST['str'];
    if(!strcmp($_POST['type'], "1")){
        $sum_a=0;
        $sum_b=0;
        $result_temp=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='A'",$connect);
        $temp=mysql_fetch_array($result_temp);
        $total_a=$temp['sum'];
        $result_temp=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='B'",$connect);
        $temp=mysql_fetch_array($result_temp);
        $total_b=$temp['sum'];
        $args=explode('@',$str);
        $string="";

        foreach($args as $arr){
            $temp=explode('|',$arr);
            $order_no=explode(" ",$temp['1']);
            $type=explode("_",$temp['1']);
            $num=explode(" ",$temp['5']);
            if($type['1']=='A'){
				
				//以下呼叫定義所需變數
				//生產人員計算
				$hire=mysql_query("SELECT SUM(hire_count) as sum FROM `current_people` WHERE  `cid`='$cid' AND `department` = 'equip'",$connect);
				$hire_count=mysql_fetch_array($hire);
       			$hire_count=$hire_count['sum'];
				$fire=mysql_query("SELECT SUM(fire_count) as sum FROM `current_people` WHERE  `cid`='$cid' AND `department` = 'equip'",$connect);
				$count = $hire - $fire;//生產人員總數
				$fire_count=mysql_fetch_array($fire);
       			$fire_count=$fire_count['sum'];
				$people=$hire_count-$fire_count;
				
				$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='product_per_employee';",$connect);
				$result=  mysql_fetch_array($temp);
				$basis=$result[0];
				$temp=mysql_query("SELECT `efficiency` FROM `current_people` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month AND `department`='equip';",$connect);
				$result=  mysql_fetch_array($temp);//計算生產人員效率
				if($result[0]>60)
					$basis=5+$basis;
				elseif($result[0]>70)
					$basis=10+$basis;
				elseif($result[0]>80)
					$basis=15+$basis;
				elseif($result[0]>90)
					$basis=20+$basis;
				$result=  mysql_query("SELECT * FROM `product_A` WHERE `cid`='$cid' AND `year`= $year AND `month`= $month",$connect);
				$temp=mysql_fetch_array($result);
				$a_use=$temp['ma_supplier_a']+$temp['ma_supplier_b']+$temp['ma_supplier_c'];
				$limit=intval($basis*$people-$a_use);//生產人員 最多產量
                if($num['1']<$total_a+$limit){
					$sum_a+=$num['1'];
                 	if($total_a < $num['1']){
						$sum_a=$num['1'];
						echo"目前庫存不夠，須再生產，若無達程需罰違約金";
					  //echo "(\"目前庫存不夠，須再生產，若無達程需罰違約金\")";
					}
					
				}
				else{	
					$string.="您現在的無法負荷NO.".$order_no[1]."的訂單~!!^";
				}
					
            }
            else{
                if($num['1']<$total_b + $limit){
                	$sum_b+=$num['1'];
                	if($total_b < $num['1']){
                		echo"目前庫存不夠，須再生產，若無達程需罰違約金";
					}
                }
                else{
                  $string.="您現在的無法負荷NO.".$order_no[1]."的訂單~!!^";
				}
			}
        }
        if($string!="")
                echo substr($string,0,-1);
        else{
            if($sum_a>$total_a + $limit||$sum_b>$total_b)
                $string.="您的庫存無法應付所有訂單總和~!!";
            if($string!="")
                echo $string;
        }

    }
   else if(!strcmp($_POST['type'], "2")){
        $correspond=array("高"=>'1',"次高"=>'2',"中"=>'3',"次低"=>'4',"低"=>'5');
        $result_global_A=array('1'=>"0","2"=>"0",'3'=>"0",'4'=>"0",'5'=>"0");
        $result_global_B=array('1'=>"0","2"=>"0",'3'=>"0",'4'=>"0",'5'=>"0");
        $args=explode('|',$str);
        $string="";
        foreach($args as $arr){
            $result=explode('@',$arr);
            $order_no=$result['1'];
            $type=explode("_",$order_no);
            $num=$result['7'];
            $quality=$correspond[$result['2']];
			
            if($type['1']=='A')
                $result_global_A[$quality]=$result_global_A[$quality]+$num;
            else if($type['1']=='B')
                $result_global_B[$quality]=$result_global_B[$quality]+$num;		
        }
		/*
           $row= mysql_query("SELECT `quality`, `service` FROM `order_detail` WHERE `order_no`='$order_no'");
			$check = mysql_fetch_array($row)
            $checkqqqq= parseInt($quality);
            $checkqu=$check[0];
            $checkse=$check[1];
			
            if($checkqu<$checkqqqq)
            {
            	$string.="請確認產品品質是否有達標";
            }
		*/
		if($string!="")
		{
			echo $string;
		}       
		else
		{
        for($i=5;$i>0;$i--){
            $result_sum=0;
			if($i=5)
			{
			$temp_result= mysql_query("SELECT `quality`, `service` FROM `order_detail` WHERE `order_no`='$order_no'");
			
			$total=mysql_fetch_array($temp_result);
            //$checkqqqq= parseInt($quality);
			
			
			
            $checkqu=$total[0];
            $checkse=$total[1];
			$minrank = mysql_query ("SELECT MIN(rank) FROM `product_quality` WHERE `cid`='$cid'");
			$minrk = mysql_fetch_array($minrank);
			$rkmin = $minrk[0];
			
			if($checkqu<$quality)
            {
            	$string.="請確定是否訂單是否有符合品質需求";
            }	
			elseif($quality<$rkmin)
			{
				$string.="請確定公司產品是否是否有符合品質需求";
			}
			break;
			}
			else
			{
            $temp_result=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='A' AND `rank`>=$i",$connect);
            $total=mysql_fetch_array($temp_result);
            if(!empty($total)){
                $temp_result=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='A' AND `rank`>=$i",$connect);
                $total=mysql_fetch_array($temp_result);
                $total=$total['sum'];
                for($j=5;$j>=$i;$j--)
                    $result_sum+=$result_global_A[$j];
                if($result_sum>$total){
                    $string.="您現有庫存無法應付所有訂單配置的品質需求~!!";
                    break;
                }
            }
			}
        }

		for($i=5;$i>0;$i--){
            $result_sum=0;
			if($i=5)
			{
			$temp_result= mysql_query("SELECT `quality`, `service` FROM `order_detail` WHERE `order_no`='$order_no'");
			
			$total=mysql_fetch_array($temp_result);
            //$checkqqqq= parseInt($quality);
			
            $checkqu=$total[0];
            $checkse=$total[1];
			
			$minrank = mysql_query ("SELECT MIN(rank) FROM `product_quality` WHERE `cid`='$cid'");
			$minrk = mysql_fetch_array($minrank);
			$rkmin = $minrk[0];
			
			if($checkqu<$quality)
            {
			if($string!="請確定是否訂單是否有符合品質需求")
            	$string.="請確定是否訂單是否有符合品質需求";
            }	
			elseif($quality<$rkmin)
			{
				$string.="請確定公司產品是否是否有符合品質需求";
			}
			break;
			}
			else
			{
            $temp_result=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='A' AND `rank`>=$i",$connect);
            $total=mysql_fetch_array($temp_result);
            if(!empty($total)){
                $temp_result=mysql_query("SELECT SUM(batch) as sum FROM `product_quality` WHERE  `cid`='$cid' AND `product`='A' AND `rank`>=$i",$connect);
                $total=mysql_fetch_array($temp_result);
                $total=$total['sum'];
                for($j=5;$j>=$i;$j--)
                    $result_sum+=$result_global_A[$j];
                if($result_sum>$total){
                    $string.="您現有庫存無法應付所有訂單配置的品質需求~!!";
                    break;
                }
            }
			}
        }

        if($string!=""){
            echo $string;
        }}
    }


    else if(!strcmp($_POST['type'], "3")){
        $correspond=array("finan_load"=>'finan_count',"sale_load"=>'sale_count',"human_load"=>'human_count',"research_load"=>'research_count');
        $correspond_2=array("finan"=>"財務人員",'sale'=>"行銷與業務人員",'human'=>"行政人員",'research'=>"研發團隊");
        $temp_result=mysql_query("SELECT `name`,`value` FROM `parameter_description` WHERE  `name`='finan_load' OR `name`='research_load' OR `name`='human_load' OR `name`='sale_load';",$connect);
        $result_temp=mysql_fetch_array($temp_result);
        $min=$result_temp['value']*$_POST[$correspond[$result_temp['name']]];
        $dep="";
        $avg_load=0;
        while($result_temp=mysql_fetch_array($temp_result)){
            if($result_temp['value']*$_POST[$correspond[$result_temp['name']]]<$min){
                $min=$result_temp['value']*$_POST[$correspond[$result_temp['name']]];
                $dep_temp=explode('_',$result_temp['name']);
                $dep=$correspond_2[$dep_temp['0']];
            }
        }
        $result=mysql_query("SELECT `price`, `quantity` FROM `order_accept` WHERE `cid` = '$cid' AND `month` = $month AND `year` = $year ",$connect);
        $temp=mysql_fetch_array($result);
        if($temp[0]!=0){
            $result=mysql_query("SELECT `price`, `quantity` FROM `order_accept` WHERE `cid` = '$cid' AND `month` = $month AND `year` = $year ",$connect);
            while($temp=mysql_fetch_array($result)){
                $min-=$temp[0]*$temp[1];
            }
        }
        $avg_load=$min;
        $args=explode('|',$str);
        $string="";
        $sum_A=0;
        $sum_B=0;
        foreach($args as $arr){
            $result=explode('@',$arr);
            $order_no=$result['1'];
            $type=explode("_",$order_no);
            $num=$result['7'];
            $price=$result['4'];
            if($type['1']=='A')
                $sum_A+=$num*$price;
            else if($type['1']=='B')
                $sum_B+=$num*$price;
        }
        if($sum_A>$avg_load)
            echo "您公司的".$dep."之基本工作負荷量已達上限值~不堪於A產品的銷貨數量~!!";
        else if($sum_B>$avg_load)
            echo "您公司的".$dep."之基本工作負荷量已達上限值~不堪於B產品的銷貨數量~!!";
    }
?>
