<?php
@session_start();
header("Content-type: text/html; charset=utf-8"); 
require_once("../connMysql.php");
mysql_select_db("testabc_main");

$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;


//$process = $_POST['process'];
//$allprocess = implode (",",$process);
//echo $process;
//echo "<br>";
//echo $allprocess;
/*$sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='research' AND `cid`='$cid' AND `year`<=$year AND `month`<$month");//, $connect);
                		$exhf=mysql_fetch_array($sql_exhf);
                           $curp = $exhf[0]-$exhf[1];	//最終可用員工人數計算		
                               		
					         $times=$curp/5;//計算流程改良次數
					         $transform_times = floor($times);//無條件捨去小數點以下位數*/
					
					
//讀取各流程改良累計次數
$monitor_query = "SELECT * FROM process_improvement WHERE `process`='螢幕原料檢驗'";
$monitor_result = mysql_query($monitor_query);
$kernel_query = "SELECT * FROM process_improvement WHERE `process`='kernel原料檢驗'";
$kernel_result = mysql_query($kernel_query);
$keyboard_query = "SELECT * FROM process_improvement WHERE `process`='鍵盤原料檢驗'";
$keyboard_result = mysql_query($keyboard_query);
$check_s_query = "SELECT * FROM process_improvement WHERE `process`='在製品檢驗'";
$check_s_result = mysql_query($check_s_query);
$check_query = "SELECT * FROM process_improvement WHERE `process`='成品檢驗'";
$check_result = mysql_query($check_query);





$process = $_POST['process']; // 讀取被選擇要改良流程的值放入 $process 陣列中
echo "您已成功進行以下項目流程改良"."<BR>";

mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='螢幕原料檢驗'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='kernel原料檢驗'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='鍵盤原料檢驗'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='在製品檢驗'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='成品檢驗'");



for ($i=0; $i< count($process); $i++){

//for ($i=0; $i< $transform_times; $i++){
	echo $process[$i]."<BR>";

	$action = "INSERT INTO process_improvement (`cid`,`year`,`month`,`process`) 
				VALUES ('$cid','$year','$month','".$process[$i]."')";
	if(mysql_query($action)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
	
if($process[$i]=="螢幕原料檢驗"){

$valuequery_monitor = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'monitor'");//, $connect);
$valueresult_monitor=mysql_query($valuequery_monitor);
$resultquery_monitor = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_monitor'");//, $connect);
$frresult_monitor=mysql_query($resultquery_monitor);
$new_flawrate_monitor = $valueresult_monitor - mysql_num_rows($monitor_result)*$frresult_monitor;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_monitor' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		/cho "fail<br>";
	}*/
	
}else{

$resultquery_monitor = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_monitor'");//, $connect);
$frresult_monitor=mysql_query($resultquery_monitor);
$new_flawrate_monitor = $frresult_monitor;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_monitor' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}

if($process[$i]=="kernel原料檢驗"){
$valuequery_kernel = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'kernel'");//, $connect);
$valueresult_kernel=mysql_query($valuequery_kernel);
$resultquery_kernel = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_kernel'");//, $connect);
$frresult_kernel=mysql_query($resultquery_kernel);
$new_flawrate_kernel = $valueresult_kernel - mysql_num_rows($kernel_result)*$frresult_kernel;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_kernel' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
	
}else{

$resultquery_kernel = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_kernel'");//, $connect);
$frresult_kernel=mysql_query($resultquery_kernel);
$new_flawrate_kernel = $frresult_kernel;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_kernel' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}	
if($process[$i]=="鍵盤原料檢驗"){

$valuequery_keyboard = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'keyboard'");//, $connect);
$valueresult_keyboard=mysql_query($valuequery_keyboard);
$resultquery_keyboard = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_keyboard'");//, $connect);
$frresult_keyboard=mysql_query($resultquery_keyboard);
$new_flawrate_keyboard = $valueresult_keyboard - mysql_num_rows($keyboard_result)*$frresult_keyboard;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_keyboard' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}else{

$resultquery_keyboard = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_keyboard'");//, $connect);
$frresult_keyboard=mysql_query($resultquery_keyboard);
$new_flawrate_keyboard = $frresult_keyboard;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_keyboard' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}		
if($process[$i]=="在製品檢驗"){

$valuequery_check_s = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'check_s'");//, $connect);
$valueresult_check_s=mysql_query($valuequery_check_s);
$resultquery_check_s = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_check_s'");//, $connect);
$frresult_check_s=mysql_query($resultquery_check_s);
$new_flawrate_check_s = $valueresult_check_s - mysql_num_rows($check_s_result)*$frresult_check_s;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_check_s' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}else{

$resultquery_check_s = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_check_s'");//, $connect);
$frresult_check_s=mysql_query($resultquery_check_s);
$new_flawrate_check_s = $frresult_check_s;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_check_s' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}	

if($process[$i]=="成品檢驗"){

$valuequery_check = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'check'");//, $connect);
$valueresult_check=mysql_query($valuequery_check);
$resultquery_check = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pi_check'");//, $connect);
$frresult_check=mysql_query($resultquery_check);
$new_flawrate_check = $valueresult_check - mysql_num_rows($check_result)*$frresult_check;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_check' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}else{

$resultquery_check = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name` = 'pp_check'");//, $connect);
$frresult_check=mysql_query($resultquery_check);
$new_flawrate_check =$frresult_check;
$flawaction = "UPDATE process_improvement SET flaw_rate = '$new_flawrate_check' WHERE `cid` = $cid";
if(mysql_query($flawaction)){//成功回傳
		echo "success<br>";
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
}		
	
	
} // end of for 將使用者選擇依序 insert into DB
echo "系統將於三秒鐘後自動導向回主畫面"."<BR>";
//echo '<script language="JavaScript">
//location.href= ('http://localhost/102abc/abc_main/main.php');
//</script>';
// header("refresh:4;URL=http://localhost/102abc/abc_main/main.php#");


//統計各流程改良累計次數
//$flaw_rate=1;












/*
$number=count($process);
echo count($allprocess);
for($i=0;$i<=$number;$i++){
$sql_query="INSERT INTO `process_improvement`
(`process`)
VALUES(";
$sql_query .="'".$process."')";
$result = mysql_quer*/
?>

<html>
    <head>
	
	</head>
    <body> 
	<meta http-equiv="refresh" content="2;url=http://localhost/ABC_games/testabc/abc_main/ValueWork/process.php" />

	    </body>
</html>