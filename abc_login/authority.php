<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?php
  include("./connMysql.php");
  if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
  mysql_query("set names 'utf8'");
  $sql_year = mysql_query("SELECT MAX(`year`) FROM `state`");
  $result = mysql_fetch_array($sql_year);
  //$_SESSION['year']=$result[0];
  $year =$result[0];//$_SESSION['year'];
  
  $sql_month = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`='$year'");
  $result = mysql_fetch_array($sql_month);
  $_SESSION['month'] = $result[0];
  $month=$_SESSION['month'];
  
  echo "第".$year."年 &nbsp;".$month."月";
  
  $login_ceo=$_SESSION["loginMember"];

/*if($year=1){	
    $sql_ceo = "SELECT * FROM `account` where `Account`='$login_ceo'";
}else{    
}*/ 
    mysql_select_db("testabc_login"); 
	//join table, 把cid加進authority
	$sql_join = "SELECT b.*,`CompanyID` FROM `account` a JOIN `authority` b ON a.Account=b.Account";
	$result = mysql_query($sql_join);
	$join = mysql_fetch_array($result); //0=year,1=account,2=position,3=isceo,4=decision,5=cid   
    
	//取得總經理資料
	if($year==1){
    	$sql_ceo = "SELECT * FROM `student_list` where `sid`='$login_ceo' and `isCaptain`='1'";
		$result = mysql_query($sql_ceo);
    	$ceo= mysql_fetch_array($result);
		
		//取得公司members
		$cid = $ceo['cid'];
	}
	else{
		$sql_ceo = "SELECT * FROM `$join` where `Account`='$login_ceo' and `isceo`='1'";
		$result = mysql_query($sql_ceo);
    	$ceo= mysql_fetch_array($result);
		
		//取得公司members
		$cid = $ceo['CompanyID'];
	}
	
 	$sql_all = mysql_query("SELECT `Account` FROM `account` WHERE `CompanyID`='$cid'");
	$num = mysql_num_rows($sql_all); //公司總人數
	$members = mysql_fetch_array($sql_all); //將此公司的所有帳號存進陣列
	

if($plan=="C1-1"){		
		if($place=="place1"){
	  		$sql_update_plan = "UPDATE `$join` SET oneone='1' WHERE CompanyID='$cid' AND Account='$member[0]'";
	  		mysql_query($sql_update_plan);
  		}else{
	  		$sql_update_plan = "UPDATE plan_decision SET oneone='0' WHERE company='$cid' AND username='$member[0]'";
	  		mysql_query($sql_update_plan);
	  	}
  		if($place=="place2"){
	  		$sql_update_plan = "UPDATE plan_decision SET oneone='1' WHERE company='$cid' AND username='$member[1]'";
	  		mysql_query($sql_update_plan);
  		}else{
	  $sql_update_plan = "UPDATE plan_decision SET oneone='0' WHERE company='$cid' AND username='$member[1]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET oneone='1' WHERE company='$cid' AND username='$member[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET oneone='0' WHERE company='$cid' AND username='$member[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET oneone='1' WHERE company='$cid' AND username='$member[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET oneone='0' WHERE company='$cid' AND username='$member[3]'";
	  mysql_query($sql_update_plan);
	  }
  }

if($plan=="C1-2"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET onetwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C1-3"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET twoone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET twoone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET twoone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET twoone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET twoone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET twoone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET twoone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET twoone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C1-4"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET threeone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threeone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET threeone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threeone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET threeone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threeone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET threeone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threeone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C1-5"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threetwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C2-1"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET threethree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threethree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET threethree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threethree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET threethree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threethree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET threethree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET threethree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C2-2"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fourone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fourone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fourone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fourone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C2-3"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourtwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C2-4"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fourthree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{

	  $sql_update_plan = "UPDATE plan_decision SET fourthree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C2-5"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fiveone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C3-1"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivetwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C3-2"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivethree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}


if($plan=="C3-3"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET fivefour='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C3-4"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sixone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sixone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sixone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sixone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C3-5"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixtwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C4-1"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sixthree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C4-2"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C4-3"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C4-4"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET seventhree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C4-5"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfour='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C5-1"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET sevenfive='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C5-2"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET eightone='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightone='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET eightone='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightone='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET eightone='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightone='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET eightone='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightone='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C5-3"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eighttwo='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C5-4"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET eightthree='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightfourthree='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}

if($plan=="C5-5"){
  if($place=="place1"){
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='1' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='0' WHERE company='$cid' AND username='$user[2]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place2"){
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='1' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='0' WHERE company='$cid' AND username='$user[3]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place3"){
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='1' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='0' WHERE company='$cid' AND username='$user[4]'";
	  mysql_query($sql_update_plan);
	  }
  if($place=="place4"){
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='1' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
  }else{
	  $sql_update_plan = "UPDATE plan_decision SET eightfour='0' WHERE company='$cid' AND username='$user[5]'";
	  mysql_query($sql_update_plan);
	  }
}
?>

<title>jQuery Poker Demo</title>
<script src="./js/jquery-1.3.2.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<link rel="stylesheet" href="./js/jquery-ui.js">
<script>
$(document).ready(function(){
	if(<?php echo $num; ?> ==4){
	  $('#person4').hide();
	}
	if(<?php echo $num; ?> ==3){
	  $('#person4').hide();
	  $('#person3').hide();
	}
	if(<?php echo $num; ?> ==2){
	  $('#person4').hide();
	  $('#person3').hide();
	  $('#person2').hide();
	}
	if(<?php echo $num; ?> ==1){
	  $('#person4').hide();
	  $('#person3').hide();
	  $('#person2').hide();
	  $('#person1').hide();
	}	
});
</script>

<style type="text/css">
/* 25決策 */
#decision_table{
	float:left;
}
.decision {
	width: 450px;
	height: 450px;
}
.decision a {
	position: absolute;
	top: 10px;
}	

/* 圖片裁切顯示 */
.picture {
	overflow:hidden; 
	width:80px;
	height:80px; 
}

/* 放置區 */
.place_area {
	border: dashed 1px #333;
	background-color: #eee;	
	height: 85px;
	width:820px;
	margin:10px;
}
.place_area a {
	float: left;
	margin: 2px 1px;
}
.place_area:hover{
	background-color: #ffe45c;	
}

/* 放置區的總區塊*/
#place_table {
	width: 550px;
	height: 400px;
	float:left;
}
.title {
	text-align:center;
	background-color:#f6a828;
	font-size:30px;
	font-weight:bolder;
	color:#FFF;
	padding:2px;
}
.title_d {
	font-size:16px;
	font-weight:bolder;
	color:#000;
	text-align:left;
}
.content {
	width:150px;
	font-family:"Comic Sans MS", cursive;
	font-size:14px;
	color:#CCC;
	overflow:scroll;
}
body{
	text-align:center;
	font-family:"Comic Sans MS", cursive;
}
</style>
<script type="text/javascript">
        $(function() {

            //產生25個決策，c是陣列的指標（0~24）
            var cards = [], c = 0;
            for (var i = 1; i <= 5; i++) {
                for (var j = 1; j <= 5; j++) {
                    cards[c++] = i + "-" + j;
                }
            }

            //把決策放到固定位置
            var cardPool = $("#decision_table");
            $.each(cards, function(i, v) {
                cardPool.append(getCard(v));
            });
            
            //利用圖片座標位移顯示特定圖案
            function getCard(cardId) {
                var pos = cardId.split("-");
                return $(
                "<a href='javascript:void(0);' id='C" + cardId + "'>" +
                "<div class=picture>" +
                "<img src='img/distribution.png' width='400' style='margin-left:" +
                (parseInt(pos[1]) - 1) * -80 + "px;margin-top:" +
                (parseInt(pos[0]) - 1) * -80 + "px;' /></div></a>");
            }

            //排列整齊成5*5
            $("#decision_table a").each(function(i) {
				$(this).css({
					"cursor":"move"
				});
				if(i<5){
					$(this).css({
                    	"left": (i * 85 +15) + "px"
               		});
				}else if(i<10 && i>=5){
					$(this).css({
                    	"left": ((i-5) * 85 +15) + "px",
                		"top":95+"px"
					});
				}else if(i<15 && i>=10){
					$(this).css({
                    	"left": ((i-10) * 85 +15) + "px",
                		"top":180+"px"
					});
				}else if(i<20 && i>=15){
					$(this).css({
                    	"left": ((i-15) * 85 +15) + "px",
                		"top":265+"px"
					});
				}else if(i<25 && i>=20){
					$(this).css({
                    	"left": ((i-20) * 85 +15) + "px",
                		"top":350+"px"
					});
				}
            });

            //允許拖拉
            $("#decision_table a").draggable({
                revert: true, //拖完返回原始位置
                opacity: 0.50, //拖拉過程半透明
            });

            //接受放牌
            $(".place_area").droppable({
                over: function(evt, ui) {
                    //將隱藏的牌去除，以免影響計數
                    $(this).find("a:hidden").remove();
                },
                drop: function(evt, ui) {					
                    var cardPack = $(this);
                    if (cardPack.find("a").length < parseInt(cardPack.attr("maxcards"))) {
                        //複製到放置區
                        ui.draggable.clone().appendTo(cardPack)
                        .css({ position: "", top: "", left: "", opacity: "" });
                        //原牌隱藏，直接刪除會影響draggable的結束事件
                        ui.draggable.hide();
						
						//被拖到放置區時
						var cid = ui.draggable.attr("id");
						var pid = $(this).attr("id");
						//alert(cid+pid);
		$.post("authority.php",{
			plan:cid,
			place:pid
		});	
                    }
                }
            });
			
            //接受將牌拖回決策區
            $(".decision").droppable({
                drop: function(evt, ui) {
                    //如果該牌是要放回決策區
                    var cId = ui.draggable.attr("id");
                    var hdnCard = $(this).find("#" + cId + ":hidden");
                    if (hdnCard.length > 0) {
                        ui.draggable.hide();
                        hdnCard.show();
                    }
                }
            });
			
            //開放放置區內可排序
            $(".place_area").sortable();
			
        });
</script>

<style type="text/css">
div#demo {
	text-align: left;
}
div#demo ul#bubbleup {
    list-style: none;
    display: inline-block;
}   
div#demo ul#bubbleup li {
    height: 3.5em;
	float: left;
    position: relative;
    margin: 0 35px;
}
div#demo ul#bubbleup li a {position: absolute;cursor:pointer;}
div#demo ul#bubbleup li img {
    position: absolute;
    width: 3.5em;
    border: none;
    overflow: hidden;
}

</style>
<script type="text/javascript">
	$(function(){
		// 把 #bubbleup 轉成 Bubbleup 效果
		// 同時當滑鼠移入到選單時出現文字提示
		$("div#demo ul#bubbleup li img").bubbleup({
			tooltip: true, 
			scale: 84,
			fontSize:18,
			fontFamily:'微軟正黑體',
			color: "#000000",
		});
	});
</script>

<script>

$(document).ready(function(){
   $("#decision").hide();
   $("#setkpi").hide();
   
   $("#info").click(function(){
	  $("#information").show();
	  $("#decision").hide();
	  $("#setkpi").hide();
	  });
   $("#distribution").click(function(){
	  $("#decision").show();  
	  $("#information").hide();
	  $("#setkpi").hide();	  
	  });
   $("#kpi").click(function(){
	  $("#setkpi").show();
      $("#decision").hide();
	  $("#information").hide();
	  });
});
</script>

</head>
<body>

<div style="position:absolute;">
	<div id="demo">
		<ul id="bubbleup"> 
            <li> <a id="distribution"> <img src="./images/game.png" alt="決策分配"/></a> </li>
            <li> <a id="kpi"> <img src="./images/game.png" alt="關鍵指標"/></a> </li>                        
		</ul>
	</div>    
</div>

<div id="information">
<div class="title">Inception商業決策模擬系統</div>
<div  aligh="center" style="margin:15px;">
<table width="500px" align="center" style="text-align:center;">	  
<tr><td><h2>您好，歡迎進入inception商業決策模擬系統</h2></td></tr>
<tr><td><h2>公司名稱：<?php echo $cid; ?></h2></td></tr>
<tr><td><h2>職位：	  

</h2></td></tr>
<tr><td><h2>擁有決策：
<?php
if($subceo[3]=="1"){echo "營收來源、";}
if($subceo[4]=="1"){echo "銷貨成本分析、";}
if($subceo[5]=="1"){echo "資本結構、";}
if($subceo[6]=="1"){echo "投資人關係管理、";}
if($subceo[7]=="1"){echo "員工關係管理、";}
if($subceo[8]=="1"){echo "供應商關係管理、";}
if($subceo[9]=="1"){echo "部門員工能力指數、";}
if($subceo[10]=="1"){echo "員工訓練、";}
if($subceo[11]=="1"){echo "招聘/解僱員工、";}
if($subceo[12]=="1"){echo "代工廠簽約、";}
if($subceo[13]=="1"){echo "營運資金管理、";}
if($subceo[14]=="1"){echo "資本預算、";}
if($subceo[15]=="1"){echo "原料採購、";}
if($subceo[16]=="1"){echo "企業社會責任、";}
if($subceo[17]=="1"){echo "生產規劃、";}
if($subceo[18]=="1"){echo "ERP投資系統決策、";}
if($subceo[19]=="1"){echo "顧客服務指數、";}
if($subceo[20]=="1"){echo "市場產品需求變化、";}
if($subceo[21]=="1"){echo "產品差異化、";}
if($subceo[22]=="1"){echo "服務品質、";}
if($subceo[23]=="1"){echo "維修效率、";}
if($subceo[24]=="1"){echo "市占率、";}
if($subceo[25]=="1"){echo "產品定價、";}
if($subceo[26]=="1"){echo "廣告及促銷活動、";}
if($subceo[27]=="1"){echo "通路商關係管理";}
?>
</h2></td></tr>
<tr><td><h2><a href="../abc_main/index.html">進入遊戲</a></h2></td></tr>
</table>
</div>
</div>
</div>

<div id="decision">
<div class="title">決策分配</div>

<!--決策區-->
<div id="decision_table" class="decision" style="position:absolute; top:10%;"></div>

<!--放置區-->
<div id="place_table" style="position:absolute; left:480px; top:10%;">

<div id="person1">
<div class="title_d">
帳號：<?php echo $member[0]; ?>
  職務名稱：<input name="job" id="job1" class="content" type="text" value="請填入職務名稱" autocomplete="off" onFocus="if(this.value=='請填入職務名稱'){this.value = ''; this.style.color='#000'}" onBlur="if (this.value==''){this.value='請填入職務名稱'; this.style.color='#CCC'}"/>
</div>
<div id="place1" class="place_area" maxcards="10"></div>
</div>

<div id="person2">
<div class="title_d">
帳號：<?php echo $member[1]; ?>
  職務名稱：<input name="job" id="job2" class="content" type="text" value="請填入職務名稱" autocomplete="off" onFocus="if(this.value=='請填入職務名稱'){this.value = ''; this.style.color='#000'}" onBlur="if (this.value==''){this.value='請填入職務名稱'; this.style.color='#CCC'}"/>
</div>
<div id="place2" class="place_area" maxcards="10"></div>
</div>

<div id="person3">
<div class="title_d">
帳號：<?php echo $member[2]; ?>
  職務名稱：<input name="job" id="job3" class="content" type="text" value="請填入職務名稱" autocomplete="off" onFocus="if(this.value=='請填入職務名稱'){this.value = ''; this.style.color='#000'}" onBlur="if (this.value==''){this.value='請填入職務名稱'; this.style.color='#CCC'}"/>
</div>
<div id="place3" class="place_area" maxcards="10"></div>
</div>

<div id="person4">
<div class="title_d">
帳號：<?php echo $member[3]; ?>
  職務名稱：<input name="job" id="job4" class="content" type="text" value="請填入職務名稱" autocomplete="off" onFocus="if(this.value=='請填入職務名稱'){this.value = ''; this.style.color='#000'}" onBlur="if (this.value==''){this.value='請填入職務名稱'; this.style.color='#CCC'}"/>
</div>
<div id="place4" class="place_area" maxcards="10"></div>
</div>

</div>
</div>

<div id="setkpi"></div>

</body>
</html>