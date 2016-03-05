<?php
	include ("mysql_connect.inc.php");
    mysql_query("set names 'utf8'");
	mysql_select_db("abc_main",$connect);  //因為mysql_connect.inc.php裡面連的是abc_login的資料庫，所以這邊要再指定資料庫為abc_main
	
	$temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;",$connect);
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0];
        if($month==0){
            $month=12;
            $year-=1;
        }
	
	echo $month;
?>