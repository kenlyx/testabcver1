<?php
    session_start();
    $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main",$connect);
    mysql_query("set names 'utf8'");
	$company=$_SESSION['cid'];
	$month1=$_SESSION['month'];
	$year1=$_SESSION['year'];
	$department=array("0"=>"finance","1"=>"equip","2"=>"sale","3"=>"human","4"=>"research");
	for($i=0;$i<5;$i++){
		$result=mysql_query("SELECT `efficiency` FROM `current_people` WHERE `year`=$year1 AND `month`=$month1 AND `department`='$department[$i]' AND `cid`='$company'",$connect);
		$temp=mysql_fetch_array($result);
		$array[$i]=$temp[0];
	}
	$reply=$array[0].":".$array[1].":".$array[2].":".$array[3].":".$array[4];
	echo $reply;
?>
