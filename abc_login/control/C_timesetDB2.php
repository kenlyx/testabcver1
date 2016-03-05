<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
include("mysql_connect.inc.php");
foreach($_POST as $key => $value);
	//$company = $_SESSION['company_name'];
	  $company = "s1";
	 	 $year = "SELECT year FROM environment WHERE id = '1' ";
 $year1 = mysql_query($year);
 $year2 = mysql_fetch_row($year1);
 $year3 = $year2[0];
 $year4 = $year3;
 $year5 = $year3;
 $beforeyear = $year3 - 1;
 
 	
 $month = "SELECT month FROM environment WHERE id = '1' ";
 $month1 = mysql_query($month);
 $month2 = mysql_fetch_row($month1);
 $month3 = $month2[0];
 $month4 = $month3 -1;
 $month5 = $month3 +1;
  if($month5 =='13')
 {
     $month5 = 1;
     $year4 = $year3 +1;
     }

 if($month4 == '0' && $beforeyear != '0' )
 {
     $month4 = 12;
     $year5 = $year3 -1;
     }

	 $engmonth44 = "select engmonth from month where month = '$month3'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $nowengmonth = $engmonth43[0];
	 $engmonth44 = "select engmonth from month where month = '$month4'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $beforeengmonth = $engmonth43[0];
	 $engmonth44 = "select engmonth from month where month = '$month5'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $laterengmonth = $engmonth43[0];
	
	
	$envir_get ="select * from environment where id ='1'"; 	
	$envir_get1 = mysql_query($envir_get);
	$envir_get2 = mysql_fetch_array($envir_get1,MYSQL_ASSOC);
	$evterm = $envir_get2["year"];  
	$evround =$envir_get2["month"];

date_default_timezone_set('Asia/Taipei');

if($modifyroundtime){//修改回合時間
	mysql_query("update timer set roundtime='$modifyroundtime' where id='1'");
	
	
}
if($modifylogin==1){//修改登入

	$timefix ="select * from timer where id ='1' and account='server'"; 	
	$timefix1 = mysql_query($timefix);
	$timefix2 = mysql_fetch_array($timefix1,MYSQL_ASSOC);
	$time = $timefix2["runid"]; 
	mysql_query("update timer set runid='$time' where id='1' and account='$company'");
	
	
}
if($modifyresttime){//修改討論時間
	mysql_query("update timer set resttime='$modifyresttime' where id='1'");
	
	
}
if($modifygameyear){//修改遊戲年限
	mysql_query("update timer set gameyear='$modifygameyear' where id='1'");
	
	
}

if($cleargame){
	mysql_query("TRUNCATE TABLE time");
	mysql_query("update timer set isstart='0',starttime='0',runid='0' where id='1'");
	
}
	$nowt = 0;
	$norr = 0;
	$status ='';
	$getroundtime ="select * from timer where id ='1' and account='$company'"; 	
	$getroundtime1 = mysql_query($getroundtime);
	$getroundtime2 = mysql_fetch_array($getroundtime1,MYSQL_ASSOC);
	$roundtime = $getroundtime2["roundtime"];  //取得回合時間
	$resttime = $getroundtime2["resttime"];  //取得討論時間
	$gameyear = $getroundtime2["gameyear"];  //取得遊戲年限
	$nowrunid = $getroundtime2["runid"];	
	$isstart = $getroundtime2["isstart"];	//遊戲是否已經開始
	$flowtime = $getroundtime2["flowtime"];	//流程精靈
	$nowtime = time();
	$lefttime=0;
	
	

	if($isgamestart==2){
			/*$loanpercent3 = "SELECT $beforeengmonth FROM company_rent WHERE company_name = '$company' and event='負債比率' and year='$year5' ";
	 		$loanpercent2 = mysql_query($loanpercent3);
 			$loanpercent1 = mysql_fetch_row($loanpercent2);
 			$loanpercent =$loanpercent1[0];
		//if($loanpercent > 100 || $loanpercent < 0)
		//{$status="公司已倒閉";}
		//else
		//{*/
		
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
		
		
		
		$runidplus = $nowrunid+1;
		//}
		
	}
/*	echo "zzzzzzzz";

	echo "zzzzzzzz".$loanpercent."zzzzzzzzzzzz";
	*/
	if($isgamestart==3){
		
	/*	$loanpercent3 = "SELECT $beforeengmonth FROM company_rent WHERE company_name = '$company' and event='負債比率' and year='$year5' ";
		$loanpercent2 = mysql_query($loanpercent3);
 		$loanpercent1 = mysql_fetch_row($loanpercent2);
 		$loanpercent =$loanpercent1[0];
		
	$runidplus = $nowrunid+1;
		//if($loanpercent > 100 || $loanpercent < 0){
			//$runidplus =99;
		//}*/
				$runidplus = $nowrunid+1;
		mysql_query("update timer set runid='$runidplus' where id='1'  and account='$company'");
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
	
	
		

	/* $sqlcash = "select cash from company_data where company_name = '$company'";
	 $sqlcash2 = mysql_query($sqlcash);
     $sqlcash3 = mysql_fetch_row($sqlcash2);
	 $cash = $sqlcash3[0];
	 $sqlnews = "select event from environment ";
	 $sqlnews2 = mysql_query($sqlnews);
     $sqlnews3 = mysql_fetch_row($sqlnews2);
	 $newsevent = $sqlnews3[0];
	
	 $sql_news1 ="select * from news_content where event ='$newsevent'"; 	
	 $sql_news2 = mysql_query($sql_news1);
	 $sql_news3 = mysql_fetch_array($sql_news2,MYSQL_ASSOC);
	 $newstitle=$sql_news3["title"];
	 $newscontent=$sql_news3["content"];*/
	
	
echo "<?php xml version =\"1.0\" ?> \n";
echo "<response>\n";

	echo '<message>';
	echo "<isstart>".$isstart."</isstart>";
	echo "<lefttime>".$lefttime."</lefttime>";
	echo "<roundtime>".$roundtime."</roundtime>";
	echo "<resttime>".$resttime."</resttime>";
	echo "<gameyear>".$gameyear."</gameyear>";
	echo "<status>".$status."</status>";
	echo "<nowt>".$nowt."</nowt>";
	echo "<nowr>".$nowr."</nowr>";
	echo "<evterm>".$evterm."</evterm>";
	echo "<evround>".$evround."</evround>";
	echo "<newstitle>".$newstitle."</newstitle>";
	echo "<newscontent>".$newscontent."</newscontent>";
	echo '</message>';
	


echo "</response>";





?>
</body>
</html>