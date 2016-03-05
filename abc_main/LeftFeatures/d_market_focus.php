<?php
    session_start();
    $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main",$connect);
	mysql_query("set names 'utf8'");
	$company=$_SESSION['cid'];
	$temp=0;
	$reply="";

	if(($_GET['option'])=="ad_a")
		$for_cal=mysql_query("SELECT * FROM `ad_a` WHERE `cid`='$company' ORDER BY `year`, `month`",$connect);
	if(($_GET['option'])=="ad_b")
		$for_cal=mysql_query("SELECT * FROM `ad_b` WHERE `cid`='$company' ORDER BY `year`, `month`",$connect);
	
	while($cal_array=mysql_fetch_array($for_cal)){
		if(($cal_array[3]+$cal_array[4]+$cal_array[5])>0){
			$reply=$reply."[".$cal_array[1].",".$cal_array[2].",";
			for($i=3;$i<6;$i++){
				$temp=$cal_array[$i];
				if($temp==0){
					$reply=$reply."0";
				}elseif($temp==1){
					if($i==3){
						$reply=$reply."2000";
					}elseif($i==4){
						$reply=$reply."4000";
					}elseif($i==5){
						$reply=$reply."10000";
					}
				}elseif($temp==2){
					if($i==3){
						$reply=$reply."4000";
					}elseif($i==4){
						$reply=$reply."6000";
					}elseif($i==5){
						$reply=$reply."12000";
					}
				}elseif($temp==3){
					if($i==3){
						$reply=$reply."6000";
					}elseif($i==4){
						$reply=$reply."8000";
					}elseif($i==5){
						$reply=$reply."15000";
					}
				}
				if($i<5)
					$reply=$reply.",";
			}
			$reply=$reply."],";
		}else{
			
		}
	}
	echo "[".$reply."]";
	
?>
