<?php
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year",$connect);
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0]-1;
        if($month==0){
            $month=12;
            $year-=1;
        }

    $temp=mysql_query("SELECT * FROM `order_detail`",$connect);
    $result=mysql_fetch_array($temp);
    if(!empty($result)){
        $temp=mysql_query("SELECT * FROM `order_detail`",$connect);
        while($result=mysql_fetch_array($temp)){
            $index=$result['index'];
            echo "NAME => ".$result['name'];
            $postpone=$result['postpone']-1;
            if($postpone>0)
                mysql_query("UPDATE `order_detail` SET `postpone` = $postpone WHERE `index` = $index",$connect) or die(mysql_error());
            else
                mysql_query("DELETE FROM `order_detail` WHERE `index`=$index",$connect) or die(mysql_error());
        }
    }
    $temp_01=mysql_query("SELECT MAX(`index`) as maxnum from `order_detail`") or die(mysql_error());
    $result=mysql_fetch_array($temp_01);
    if(!$result[0])
        $index=1;
    else
        $index=$result['maxnum']+1;
    $temp_result=mysql_query("SELECT `value` from `parameter_description` WHERE `name`='product_A_size_ratio'") or die(mysql_error());
    $result_temp=mysql_fetch_array($temp_result);
    $A_ratio=$result_temp[0];
    $temp_result=mysql_query("SELECT `value` from `parameter_description` WHERE `name`='product_B_size_ratio'") or die(mysql_error());
    $result_temp=mysql_fetch_array($temp_result);
    $B_ratio=$A_ratio+$result_temp[0];
    $temp_b2c=mysql_query("SELECT * FROM `customer_state` WHERE `initial`>'14' AND `b_or_c`='1'",$connect) or die(mysql_error());
    $temp_b2b=mysql_query("SELECT * FROM `customer_state` WHERE `initial`>'24' AND `b_or_c`='0'",$connect) or die(mysql_error());
    while($arr=mysql_fetch_array($temp_b2c)){
	    
        $random_number=rand();
        $order_no=($random_number%$index+$random_number/$index)*($index+1);
        $product_type=($random_number%$B_ratio)+1;
        if($product_type<=$A_ratio)
            $product_type='A';
        else
            $product_type='B';

        $order_no=intval($order_no)."_".$product_type;
        echo $order_no;
        $name=$arr['name'];
        $type=$arr['type'];
        $quality=$arr['quality'];
        $service=$arr['service'];
		if($arr['quantity'] <= 300){
			$arr['quantity'] = 301;
		}
        $quantity=rand(($arr['quantity']-200)/10,($arr['quantity']+250)/10)*6;
		if($quantity <= 300){
		  $quantity=310;
		}
        mysql_query("INSERT INTO `order_detail` VALUES ($index,$year,$month,'$order_no','$type','$name',$quality,$service,$quantity,1,3)",$connect);
        $index++;
    }
    while($arr=mysql_fetch_array($temp_b2b)){
        $random_number=rand();
        $order_no=$random_number%$index+$random_number/$index;
        $product_type=($random_number%$B_ratio)+1;
        if($product_type<=$A_ratio)
            $product_type='A';
        else
            $product_type='B';

        $order_no=intval($order_no)."_".$product_type;
        $name=$arr['name'];
        $type=$arr['type'];
        $quality=$arr['quality'];
        $service=$arr['service'];
		if($arr['quantity'] <= 300){
			$arr['quantity'] = 301;
		}
        $quantity=rand(($arr['quantity']-200)/10,($arr['quantity']+250)/10)*6;
        if($quantity <= 300){
		  $quantity=310;
		}
		mysql_query("INSERT INTO `order_detail` VALUES ($index,$year,$month,'$order_no','$type','$name',$quality,$service,$quantity,0,5)",$connect);
        $index++;
    }
?>
