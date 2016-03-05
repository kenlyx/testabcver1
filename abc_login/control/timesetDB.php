<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主控台DB</title>
</head>

<body>
<?php

//共同區----------------------------------------------------------------------------------------------
include("../connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

date_default_timezone_set('Asia/Taipei');//設定時間區域


$temp = mysql_query("SELECT * FROM `timer` WHERE `id`='1' AND `account`='server'");
$getroundinfo = mysql_fetch_array($temp,MYSQL_ASSOC);

$roundtime = $getroundinfo["roundtime"];  //取得回合時間
$gameyear = $getroundinfo["gameyear"];  //取得競賽年限
$nowrunid = $getroundinfo["runid"];	
$isstart = $getroundinfo["isstart"];	//競賽是否已經開始
$starttime = $getroundinfo["starttime"];
$status = $getroundinfo["status"];
$nowtime = time(); //取得server時間
$lefttime = 0;
$nowt = 0;
$nowr = 0;
$status = '競賽未啟動';
$temp = mysql_fetch_array(mysql_query("SELECT * FROM `game`"),MYSQL_ASSOC);
$gname = $temp['GameName'];
$temp = mysql_fetch_array(mysql_query("SELECT * FROM `time` ORDER BY  `time`.`id` DESC LIMIT 1"),MYSQL_ASSOC);
$endtime = $temp["endtime"];


//共同區-----------------------------------------------------------------------------------------------

if($_GET['type'] == 'ready'){//讀取頁面
	if($isstart == 1){
		$temp = mysql_query("SELECT * FROM `timer` WHERE `id`='1'");
		$result = mysql_fetch_array($temp);
		$nowrunid = $result['runid'];
		$getruntime = mysql_fetch_array(mysql_query("SELECT * FROM `time` WHERE `id`='$nowrunid'"),MYSQL_ASSOC);
		$endtime = $getruntime["endtime"];  //取得終止時間
		$nowt = $getruntime["term"];  
		$nowr = $getruntime["round"];  
		$status = $getruntime["status"];  //取得狀態
		$lefttime = $endtime - time();
	}
	//最前方放|讓[0]=" "  這空白消不掉(崩潰)
	echo "|".$starttime ."|". $gname ."|". $endtime ."|". $isstart ."|". $lefttime ."|". $roundtime ."|". $gameyear ."|". $status ."|". $nowt ."|". $nowr ."|";
	
}


if($_GET['type'] == "change_gameyear"){//修改競賽年限
	mysql_query("UPDATE `timer` SET `gameyear`={$_GET['gameyear']} WHERE `id`='1'");	
}

if($_GET['type'] == "change_roundtime"){//修改回合時間

	mysql_query("UPDATE `timer` SET `roundtime`={$_GET['roundtime']} WHERE `id`='1'");
	
}

if($_GET['type'] == "cleargame"){//清除競賽時間
	mysql_query("TRUNCATE TABLE time");
	mysql_query("UPDATE `timer` SET `status`='競賽未啟動',`isstart`='0',`starttime`='0',`runid`='0' WHERE `id`='1'");
}

if($_GET['type'] == "gamestart"){//競賽開始初始化

	$county = $gameyear;
	$countm = 12;
	$nowt = 1;
	$nowr = 1;
	$status = '競賽進行中';
	mysql_query("UPDATE `timer` SET `status`='$status', `isstart`='1',`starttime`='$nowtime',`runid`='1' WHERE `id`='1'");
	
	//將所有預定要跳躍的時間存入DB
	for($i=1;$i<=$county;$i++){
		$t = 1;
		for($j=0;$j<$countm;$j++){
			$runid = $j +1+($i-1)*12;
			$counttime = $roundtime*60*$t+$roundtime*12*60*($i-1);
			$insert = $nowtime + $counttime;
			mysql_query("INSERT INTO `time`(id,term,round,endtime,status)values('$runid','$i','$t','$insert','競賽進行中')");
			if($i==1&&$j==0){
				$lefttime=$insert-time();
			}
			$t++;
		}
	}
	
	$temp = mysql_query("SELECT * FROM `timer` WHERE `id`='1' AND `account`='server'");
	$getroundinfo = mysql_fetch_array($temp,MYSQL_ASSOC);
	
	$roundtime = $getroundinfo["roundtime"];  //取得回合時間
	$gameyear = $getroundinfo["gameyear"];  //取得競賽年限
	$nowrunid = $getroundinfo["runid"];	
	$isstart = $getroundinfo["isstart"];	//競賽是否已經開始
	$starttime = $getroundinfo["starttime"];
	$status = $getroundinfo["status"];
	
	echo "|".$starttime ."|". $gname ."|". $endtime ."|". $isstart ."|". $lefttime ."|". $roundtime ."|". $gameyear ."|". $status ."|". $nowt ."|". $nowr;
	
}//end


if($_GET['type'] == "run"){//跨月
	
	$temp = mysql_query("SELECT * FROM `timer` WHERE `id`='1'");
	$result = mysql_fetch_array($temp);
	$nowrunid = $result['runid'];
	
	$runidplus = $nowrunid + 1;
	if($runidplus <= $gameyear*12){
		mysql_query("UPDATE `timer` SET `runid`='$runidplus' WHERE `id`='1' AND `account`='server'");
		
		$getruntime = mysql_fetch_array(mysql_query("SELECT * FROM `time` WHERE `id`='$runidplus'"),MYSQL_ASSOC);
		$endtime = $getruntime["endtime"];  //取得終止時間
		$nowt = $getruntime["term"];  
		$nowr = $getruntime["round"];  
		$status = $getruntime["status"];  //取得狀態
		$lefttime = $endtime - time();
		
		echo "|".$starttime ."|". $gname ."|". $endtime ."|". $isstart ."|". $lefttime ."|". $roundtime ."|". $gameyear ."|". $status ."|". $nowt ."|". $nowr;

	}
	else{
		mysql_query("UPDATE `timer` SET `status`='競賽結束' WHERE `id`='1'");
	
		$temp = mysql_query("SELECT * FROM `timer` WHERE `id`='1' AND `account`='server'");
		$getroundinfo = mysql_fetch_array($temp,MYSQL_ASSOC);
		
		$roundtime = $getroundinfo["roundtime"];  //取得回合時間
		$gameyear = $getroundinfo["gameyear"];  //取得競賽年限
		$nowrunid = $getroundinfo["runid"];	
		$isstart = $getroundinfo["isstart"];	//競賽是否已經開始
		$starttime = $getroundinfo["starttime"];
		$status = $getroundinfo["status"];
		
		echo "|".$starttime ."|". $gname ."|". $endtime ."|". $isstart ."|". $lefttime ."|". $roundtime ."|". $gameyear ."|". $status ."|". $nowt ."|". $nowr;
	}
}

if($_GET['type'] == "pausegame"){//暫停

	mysql_query("UPDATE `timer` SET `status`='競賽暫停中' WHERE `id`='1'");
	mysql_query("UPDATE `time` SET `status`='競賽暫停中' WHERE `id`='$nowrunid'");

}

if($_GET['type'] == "continue"){//再續
	
	$getruntime = mysql_fetch_array(mysql_query("SELECT * FROM `time` WHERE `id`='$nowrunid'"),MYSQL_ASSOC);
	$nowt = $getruntime["term"];  
	$nowr = $getruntime["round"];  
	$roundtime = $roundtime * 60;//將一回合時間從分轉為秒
	$Total_round = $gameyear * 12;
	
	for($i=$nowrunid;$i<=$Total_round;$i++){
		
		$nowtime = $nowtime + $roundtime;//將nowtime轉為該回合的endtime
		
		mysql_query("UPDATE `time` SET `endtime`='$nowtime' WHERE `id`='$i'");
	}
	
	mysql_query("UPDATE `timer` SET `status`='競賽進行中' WHERE `id`='1'");
	mysql_query("UPDATE `time` SET `status`='競賽進行中' WHERE `id`='$nowrunid'");
}




?>
</body>
</html>
