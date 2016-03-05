<?php
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;",$connect);
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0]-1;
    if($month==0){
        $month=12;
        $year-=1;
    }
    $product_A=0;
    $product_B=0;

    $temp=mysql_query("SELECT `order_no`,`quantity` FROM `order_detail` ");
    while($result=  mysql_fetch_array($temp)){
        if($result[0]=="")
            break;
        $type=explode("_",$result['order_no']);
        if($type[1]=="A")
            $product_A+=$result['quantity'];
        else
            $product_B+=$result['quantity'];
    }
    mysql_query("INSERT INTO `market_trend` VALUES($year,$month,$product_A,$product_B);",$connect);
?>