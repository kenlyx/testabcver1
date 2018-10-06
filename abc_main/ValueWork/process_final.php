<?php
@session_start();
header("Content-type: text/html; charset=utf-8"); 
require_once("../connMysql.php");
mysql_select_db("testabc_main");

$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;


//$process = mysql_real_escape_string($_POST['process']);
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
$monitor_query = "SELECT * FROM process_improvement WHERE `process`='monitor'";
$monitor_result = mysql_query($monitor_query);
$kernel_query = "SELECT * FROM process_improvement WHERE `process`='kernel'";
$kernel_result = mysql_query($kernel_query);
$keyboard_query = "SELECT * FROM process_improvement WHERE `process`='keyboard'";
$keyboard_result = mysql_query($keyboard_query);
$check_s_query = "SELECT * FROM process_improvement WHERE `process`='check_s'";
$check_s_result = mysql_query($check_s_query);
$check_query = "SELECT * FROM process_improvement WHERE `process`='check'";
$check_result = mysql_query($check_query);





$process = mysql_real_escape_string($_POST['process']); // 讀取被選擇要改良流程的值放入 $process 陣列中
echo "您已成功進行以下項目流程改良"."<BR>";

mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='monitor'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='kernel'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='keyboard'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='check_s'");
mysql_query("DELETE FROM process_improvement WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='check'");



for ($i=0; $i< count($process); $i++){

//for ($i=0; $i< $transform_times; $i++){
	echo $process[$i]."<BR>";

	$action = "INSERT INTO process_improvement (`cid`,`year`,`month`,`process`) 
				VALUES ('$cid','$year','$month','".$process[$i]."')";
	if(mysql_query($action)){//成功回傳
		echo "success<br>";
	}
	}
	/*else{//失敗回傳
		echo "fail<br>";
	}*/
	
		
	
	
 // end of for 將使用者選擇依序 insert into DB
echo "系統將於三秒鐘後自動導向回主畫面"."<BR>";
echo "<script language='JavaScript'>
		location.href= ('process.php');
		</script>";
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
	<meta http-equiv="refresh" content="1;url=http://localhost/ABC_games/testabc/abc_main/ValueWork/process.php" />

	    </body>
</html>