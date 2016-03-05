<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主控台DB</title>
</head>

<body>
<?php

include("../connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

foreach($_POST as $key => $value);

date_default_timezone_set('Asia/Taipei');//設定時間區域

if($modifyroundtime){//修改回合時間
	mysql_query("update timer set roundtime='$modifyroundtime' where id='1'");
}

/*if($modifyresttime){//修改討論時間
	mysql_query("update timer set resttime='$modifyresttime' where id='1'");
}*/

if($modifygameyear){//修改競賽年限
	mysql_query("update timer set gameyear='$modifygameyear' where id='1'");	
}

if($cleargame){
	mysql_query("TRUNCATE TABLE time");
	mysql_query("update timer set status='競賽未啟動',isstart='0',starttime='0',runid='0' where id='1'");
	//include("C_truncateDB.php");	
}
	$nowt = 0;
	$nowr = 0;
	$status ='競賽未啟動';
	$getroundinfo ="select * from timer where id ='1' and account='server'"; 
	$getroundinfo1 = mysql_query($getroundinfo);
    $getroundinfo2 = mysql_fetch_array($getroundinfo1,MYSQL_ASSOC);
	
	$roundtime = $getroundinfo2["roundtime"];  //取得回合時間
	//$resttime = $getroundinfo2["resttime"];  //取得討論時間
	$gameyear = $getroundinfo2["gameyear"];  //取得競賽年限
	$nowrunid = $getroundinfo2["runid"];	
	$isstart = $getroundinfo2["isstart"];	//競賽是否已經開始
	$nowtime = time(); //取得server時間
	$lefttime=0;
	
	if($isgamestart==1){//競賽開始初始化
		$county = $gameyear;
		$countm = 12;
		$nowt = 1;
		$nowr = 1;
		$status = '競賽進行中';
		mysql_query("update timer set status='$status', isstart='1',starttime='$nowtime',runid='1' where id='1'");
		
		
		//將所有預定要跳躍的時間存入DB
		for($i=1;$i<=$county;$i++){
			$t = 1;
			
			for($j=0;$j<$countm;$j++){
				$runid = $j +1+($i-1)*12;
					
				$counttime = $roundtime*60*$t+$roundtime*12*60*($i-1);
				
					$insert = $nowtime + $counttime;
					mysql_query("insert into time(id,term,round,endtime,status)values('$runid','$i','$t','$insert','競賽進行中')");
					if($i==1&&$j==0)
					$lefttime=$insert-time();
					$t++;
					
			}
		}
		
		
		
	}//end

	
	if($isgamestart==3){
		$runidplus = $nowrunid+1;
		mysql_query("update timer set runid='$runidplus' where id='1' and account='server'");
		$getruntime ="select * from time where id ='$runidplus'";
		$getruntime1 = mysql_query($getruntime);
		$getruntime2 = mysql_fetch_array($getruntime1,MYSQL_ASSOC);
		$endtime = $getruntime2["endtime"];  //取得終止時間
		$nowt = $getruntime2["term"];  //取得終止時間
		$nowr = $getruntime2["round"];  //取得終止時間
		$status = $getruntime2["status"];  //取得狀態
		$lefttime = $endtime-time();
		echo "第".$nowt."年".$nowr."月  剩餘時間：".$lefttime."秒";
		echo "<br/>";
	
		
	}
	if($isgamestart==2){
		$getruntime ="select * from time where id ='$nowrunid'";
		$getruntime1 = mysql_query($getruntime);
		$getruntime2 = mysql_fetch_array($getruntime1,MYSQL_ASSOC);
		$endtime = $getruntime2["endtime"];  //取得終止時間
		$nowt = $getruntime2["term"];  //取得終止時間
		$nowr = $getruntime2["round"];  //取得終止時間
		$status = $getruntime2["status"];  //取得狀態
		$lefttime = $endtime-time();
		echo "第".$nowt."年".$nowr."月  剩餘時間：".$lefttime."秒";
		echo "<br/>";
	}
	
	if($isgamecontinue==1){//競賽繼續玩//還沒改完
		mysql_query("TRUNCATE TABLE time");
		$county = $gameyear;
		$countm = 12;
		//$ini = strtotime("$resttime mins");	
		$nowt = 0;
		$nowr = 0;
		mysql_query("update timer set isstart='1',starttime='$nowtime' where id='1'");
		
		
		for($i=1;$i<=$county;$i++){
			$t = 1;
			
			for($j=0;$j<$countm;$j++){
				$runid = $j +1+($i-1)*12;
					
				$counttime = $roundtime*60*$t+$roundtime*12*60*($i-1);
				
				
					$insert = $nowtime + $counttime;
					mysql_query("insert into time(id,term,round,endtime,status)values('$runid','$i','$t','$insert','競賽進行中')");
					if($i==1&&$j==0)
					$lefttime=$insert-time();
					$t++;
					
			}
		}
	
	$deletetime =0;
	//$countrest = $resttime*60;
	//$countflow = $flowtime*60;
	$countround = $roundtime*60;
	$sqlcom = "select * from time";
	$sqlcom2 = mysql_query($sqlcom);
	while($sqlcom3 = mysql_fetch_array($sqlcom2,MYSQL_ASSOC))
	{
		$thisid = $sqlcom3["id"];
		if($thisid<$nowrunid){
			//if($sqlcom3["status"]=='競賽時間'){
			$deletetime = $deletetime + $countround;	
			//}
			//else if($sqlcom3["status"]=='討論時間'){
				//$deletetime = $deletetime + $countrest;	
			//}
			//else{
				//$deletetime = $deletetime + $countflow;	
			//}
		}
		else{
			$setnewtime = $sqlcom3["endtime"] - $deletetime;
			mysql_query("update time set endtime = '$setnewtime' where id='$thisid'");
			if($thisid==$nowrunid){
				$lefttime = $setnewtime -$nowtime;
				$nowt = $sqlcom3["term"];
				$nowr = $sqlcom3["round"];
				$status = $sqlcom3["status"];
			}
		}
				
	}
	
}

echo "<?php xml version =\"1.0\" ?> \n";
echo "<response>\n";
echo '<message>';
echo "<isstart>".$isstart."</isstart>";
echo "<lefttime>".$lefttime."</lefttime>";
echo "<roundtime>".$roundtime."</roundtime>";
echo "<gameyear>".$gameyear."</gameyear>";
echo "<status>".$status."</status>";
echo "<nowt>".$nowt."</nowt>";
echo "<nowr>".$nowr."</nowr>";
echo '</message>';
echo "</response>";

?>
</body>
</html>
