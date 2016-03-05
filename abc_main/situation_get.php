<?php
    session_start();
    $connect = mysql_connect("localhost", "root", "projectabc2012") or die(mysql_error());
    mysql_select_db("abc_main", $connect);
    mysql_query("set names 'utf8'");
    $month=$_SESSION['month'];
    $temp=mysql_query("SELECT `situation` FROM `situation_overview` WHERE `month`=$month");
    $result=  mysql_fetch_array($temp);
    $temp_01=mysql_query("SELECT `name`,`description` FROM `situation` WHERE `index`={$result['situation']};",$connect);
    $result=  mysql_fetch_array($temp_01);
    echo $result['name']."@".$result['description'];
?>
