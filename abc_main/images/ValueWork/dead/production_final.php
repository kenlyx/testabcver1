<?php
@session_start();
header("Content-type: text/html; charset=utf-8"); 
require_once("../connMysql.php");
mysql_select_db("testabc_main");
$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;
//$_SESSION['productionplan_sumit']=1;


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


$production_plan = $_POST['production_plan']; // 讀取被選擇的值放入 $production_plan 陣列中
echo "您已成功進行以下項目生產規劃"."<BR>";

mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='螢幕原料檢驗'");
mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='kernel原料檢驗'");
mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='鍵盤原料檢驗'");
mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='在製品檢驗'");
mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month' AND `process`='成品檢驗'");
$monitor=0;
$kernel=0;
$keyboard=0;
$check_s=0;
$check=0;

for ($i=0; $i< count($production_plan); $i++){

if(!strcmp($production_plan[$i],"螢幕原料檢驗")){
$monitor=1;}
if(!strcmp($production_plan[$i],"kernel原料檢驗")){
$kernel=1;}
if(!strcmp($production_plan[$i],"鍵盤原料檢驗")){
$keyboard=1;}
if(!strcmp($production_plan[$i],"在製品檢驗")){
$check_s=1;}
if(!strcmp($production_plan[$i],"成品檢驗")){
$check=1;}

	
}

$action = "INSERT INTO production_plan (`cid`,`year`,`month`,`monitor`,`kernel`,`keyboard`,`check_s`,`check`) 
				VALUES ('$cid' , '$year' , '$month' ,'$monitor','$kernel','$keyboard','$check_s','$check')";
				
				
mysql_query("DELETE FROM production_plan WHERE `cid`='$cid' AND `year`='$year'");	

			
				if(mysql_query($action)){
		echo "success<br>";}
/*
	echo $production_plan[$i]."<BR>";
	$action = "INSERT INTO production_plan (`cid`,`year`,`month`,`production_plan`) 
				VALUES ('$cid' , '$year' , '$month' ,'".$production_plan[$i]."')";
	if(mysql_query($action)){
		echo "success<br>";
		
	    /*if($production_plan[$i]=="螢幕原料檢驗"){}
  	    if($production_plan[$i]=="kernel原料檢驗"){}
        if($production_plan[$i]=="鍵盤原料檢驗"){}
        if($production_plan[$i]=="成品檢驗"){
        if($production_plan[$i]=="在製品檢驗"){}*/		
	
	/*else{
		echo "fail<br>";
	}*/
	//機具
$cut_mA=$_POST['machine_type'];
$cut_mB=$_POST['machine_type'];
$cut_mC=$_POST['machine_type'];

$cp1_A=$_POST['cp1machine_type'];
$cp1_B=$_POST['cp1machine_type'];
$cp1_C=$_POST['cp1machine_type'];


$cp2_A=$_POST['cp2machine_type'];
$cp2_B=$_POST['cp2machine_type'];
$cp2_C=$_POST['cp2machine_type'];

$cut=0;
$cp1=0;
$cp2=0;


for ($j=0; $j<9; $j++){
if(!strcmp($cut_mA,"cut_mA")){
$cut=0;}
if(!strcmp($cut_mB,"cut_mB")){
$cut=1;}
if(!strcmp($cut_mC,"cut_mC")){
$cut=2;}

if(!strcmp($cp1_A,"cp1_A")){
$cp1=0;}
if(!strcmp($cp1_B,"cp1_B")){
$cp1=1;}
if(!strcmp($cp1_C,"cp1_C")){
$cp1=2;}

if(!strcmp($cp2_A,"cp2_A")){
$cp2=0;}
if(!strcmp($cp2_B,"cp2_B")){
$cp2=1;}
if(!strcmp($cp2_C,"cp2_C")){
$cp2=2;}

}
/*$action2 = "INSERT INTO production_plan (`cid`,`year`,`month`,`cut`,`combine1`,`combine2`) 
				VALUES ('$cid' , '$year' , '$month' ,'$cut','$cp1','$cp2')";
				if(mysql_query($action2)){
		echo "success<br>";}*/
		
		
$action2 ="UPDATE production_plan SET cut='$cut' , combine1='$cp1', combine2='$cp2'
WHERE cid='$cid' AND year='$year' AND month='$month' ";		
if(mysql_query($action2)){
		echo "success<br>";}
?>
<html>
    <head>
	
	</head>
    <body> 
	<meta http-equiv="refresh" content="1;url=http://localhost/ABC_games/testabc/abc_main/ValueWork/production.php" />

	    </body>
</html>
