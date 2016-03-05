<?php
    include("./connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`");
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0];
    $temp=mysql_query("SELECT * FROM `product_famous`") or die(mysql_error());
    $a_partial=0;
    $b_partial=0;
    $transfer=0;
    $value=18;
    $index=0;
    while($result=  mysql_fetch_array($temp)){
        if($result[0]=='A')
            $a_partial=$result[1];
        else if($result[0]=='B')
            $b_partial=$result[1];
    }
    if($a_partial>$b_partial){
        $transfer=(integer)($a_partial/$b_partial)-1;
        if($transfer!=0){
            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='product_A_size_ratio';");
            $result=mysql_fetch_array($temp);
            $transfer+=$result[0];
            mysql_query("UPDATE `parameter_description` SET `value`=$transfer WHERE `name`='product_A_size_ratio';");
            $temp=mysql_query("SELECT `value` FROM `product_famous` WHERE `product`='B';");
            $result=mysql_fetch_array($temp);
            $value+=$result[0];
            mysql_query("UPDATE `product_famous` SET `value`=$value WHERE `product`='B';");
        }
    }
    else if($a_partial<$b_partial){
        $transfer=(integer)($b_partial/$a_partial)-1;
        if($transfer!=0){
            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='product_B_size_ratio';");
            $result=mysql_fetch_array($temp);
            $transfer+=$result[0];
            mysql_query("UPDATE `parameter_description` SET `value`=$transfer WHERE `name`='product_B_size_ratio';");
            $temp=mysql_query("SELECT `value` FROM `product_famous` WHERE `product`='A';");
            $result=mysql_fetch_array($temp);
            $value+=$result[0];
            mysql_query("UPDATE `product_famous` SET `value`=$value WHERE `product`='A';");
        }
    }
    mysql_query("UPDATE `customer_state` SET `initial`=0 WHERE `valid`='0';");
    $temp=mysql_query("SELECT SUM(`product_A_RD`),SUM(`product_B_RD`) FROM `state`;") or die(mysql_error());
    $result=  mysql_fetch_array($temp);
    if($result[0]+$result[1]>0){
        for($i=0;$i<6;$i++){
            mysql_query("UPDATE `customer_state` SET `valid`=1 WHERE `index`=($i*5+1) OR `index`= ($i*5+2);") or die(mysql_error());
        }
    }
    if($month>3){
        $temp=mysql_query("SELECT * FROM `order_detail`");
        $order_row = mysql_num_rows($temp);
        if($order_row==0){
            $temp=mysql_query("SELECT * FROM `product_quality`");
            $pro_row = mysql_num_rows($temp);
            if($pro_row!=0){
                $temp=mysql_query("SELECT * FROM `customer_state` WHERE `valid`=1;");
                $index=mysql_num_rows($temp);
                $index=$index/6+1;
                for($i=0;$i<6;$i++){
                    mysql_query("UPDATE `customer_state` SET `valid`=1 WHERE `index`=($i*5+$index);") or die(mysql_error());
					//mysql_query("UPDATE `customer_state` SET `valid`=1 WHERE `valid`='0';") or die(mysql_error());    
				}
            }
        }
    }
?>
