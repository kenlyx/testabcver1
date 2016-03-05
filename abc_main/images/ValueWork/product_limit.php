<?php
    session_start();
    $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main",$connect);
    $month=$_SESSION['month'];
    $cid=$_SESSION['cid'];
    $year=$_SESSION['year'];
    mysql_query("set names 'UTF8'");
	
    $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='product_per_employee';",$connect);
    $result=  mysql_fetch_array($temp);
    $basis=$result[0];
    $temp=mysql_query("SELECT `efficiency` FROM `current_people` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month AND `department`='equip';",$connect);
    $result=  mysql_fetch_array($temp);
    if($result[0]>60)
        $basis=5+$basis;
    elseif($result[0]>70)
        $basis=10+$basis;
    elseif($result[0]>80)
        $basis=15+$basis;
    elseif($result[0]>90)
        $basis=20+$basis;
    if(!strcmp($_GET['type'],"A")){
        $result=  mysql_query("SELECT * FROM `product_B` WHERE `cid`='$cid' AND `year`= $year AND `month`= $month",$connect);
        $temp=mysql_fetch_array($result);
        $b_use=$temp['ma_supplier_a']+$temp['ma_supplier_b']+$temp['ma_supplier_c'];
        echo $basis."|".$b_use;
    }
    else if(!strcmp($_GET['type'],"B")){
        $result=  mysql_query("SELECT * FROM `product_A` WHERE `cid`='$cid' AND `year`= $year AND `month`= $month",$connect);
        $temp=mysql_fetch_array($result);
        $a_use=$temp['ma_supplier_a']+$temp['ma_supplier_b']+$temp['ma_supplier_c'];
        echo $basis."|".$a_use;
    }
?>
