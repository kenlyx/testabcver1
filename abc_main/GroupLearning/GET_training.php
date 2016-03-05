<?php
    session_start();
   include("../connMysql.php");
   if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$month=$_SESSION['month'];
    $year=$_SESSION['year'];
	$round=($year-1)*12+$month;
	//echo $cid."|".$year."|".$month;
	$reply="";
        $hire_count=0;
        $fire_count=0;
	$department=array("0"=>"finance","1"=>"equip","2"=>"sale","3"=>"human","4"=>"research");//資料庫的部門名稱改的話直接改這裡就好
	if(($_GET['option'])=="get"){
		for($i=0;$i<5;$i++){
			if($round!=1){
				$sql_curp = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `department`='$department[$i]' AND `cid`='$cid' AND (`year`-1)*12+`month`<$round");
				$curp=mysql_fetch_array($sql_curp);
				$people=$curp[0]-$curp[1]; //總hire-總fire
			
				$sql_es=mysql_query("SELECT * FROM `current_people` WHERE `department`='$department[$i]' AND `cid`='$cid' AND `year`=$year AND `month`=$month");
				$es=mysql_fetch_array($sql_es);
				$reply=$reply.$people.":".$es['efficiency'].":".$es['satisfaction'].":";//績效和滿意度只看這回合的
			}else{
				if($i==4){
					$sql_curp = mysql_query("SELECT * FROM `current_people` WHERE `department`='$department[$i]' AND `cid`='$cid' AND `year`=$year AND `month`=$month");
					$curp=mysql_fetch_array($sql_curp);
					$people=$curp['hire_count']-$curp['fire_count'];
					$reply=$reply.$people.":".$curp['efficiency'].":".$curp['satisfaction'].":";
				}else
					$reply=$reply."0:0:0:";
			}
		}//本回合決策紀錄不同表，放後面
		$result=mysql_query("SELECT * FROM training WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp=mysql_fetch_array($result);
		$reply=$reply.$temp['decision1'].":".$temp['decision2'].":".$temp['decision3'].":".$temp['decision4'].":".$temp['decision5'];
		echo $reply;
	}
	else if(($_GET['option'])=="update"){	 
       	$result=mysql_query("SELECT * FROM training order by `year` ,`month` DESC") or die(mysql_error());
		$sql_string="UPDATE training SET ";
		for($i=1;$i<=5;$i++)
			if($i<5)
				$sql_string=$sql_string."`decision$i`={$_GET['decision'.$i]},";
			else 
				$sql_string=$sql_string."`decision$i`={$_GET['decision'.$i]}";//query最後一行無逗號
		mysql_query($sql_string." WHERE `year`=$year AND `month`=$month AND `cid`='$cid'") or die(mysql_error());
		echo "update".$sql_string;
	}
?>
