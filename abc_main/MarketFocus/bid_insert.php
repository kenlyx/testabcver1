<?php
    session_start();
    $args=array("高"=>'1',"次高"=>'2',"中"=>'3',"次低"=>'4',"低"=>'5');
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_query("SET NAMEs 'utf8'");
    mysql_select_db("testabc_main", $connect);
    $arrs=explode("|",$_GET['result']);
    print_r($arrs);
    $cid=$_SESSION['cid'];
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];

    $temp_01=mysql_query("SELECT MAX(`index`) as maxnum from `order_accept`") or die(mysql_error());
    $result=mysql_fetch_array($temp_01);
    if(!$result[0])
        $index=1;
    else
        $index=$result['maxnum']+1;

    foreach($arrs as $arr){
        $result=explode("@",$arr);
        $name=$result['0'];
        $order_no=$result['1'];
        $quality=$args[$result['2']];
        $service=$args[$result['3']];
        $price=$result['4'];
        $type=$result['5'];
        $b_or_c=$result['6'];
        $quantity=$result['7'];
        mysql_query("INSERT INTO `order_accept` VALUES ($index,$year,$month,'$cid','$type','$name','$order_no',$quality,$service,$price,$quantity,$b_or_c,0);",$connect) or die(mysql_error());
        $index++;
        echo "success";
    
    }
?>
