<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
include("./mysql_connect.inc.php");

mysql_query("update environment set year = '1' where id='1'");
mysql_query("update environment set month = '1' where id='1'");

   for ($y = 1 ; $y <=5 ; $y ++)
   {
				      for ($m = 1 ; $m <= 12 ; $m++)
					  {
						  
	 $engmonth44 = "select engmonth from month where month = '$m'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $choiseengmonth = $engmonth43[0];

					  }
}
   for ($y = 1 ; $y <=5 ; $y ++)
   {
	   
				      for ($m = 1 ; $m <= 12 ; $m++)
					  {
						  
	 $engmonth44 = "select engmonth from month where month = '$m'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $choiseengmonth = $engmonth43[0];
   //  mysql_query("update calculate_netincome set $choiseengmonth = '0' where year ='$y' and event = '當期總淨利正'");
     //mysql_query("update calculate_netincome set $choiseengmonth = '0' where year ='$y' and event = '當期總淨利負'");

					  }
    }
   for ($y = 1 ; $y <=5 ; $y ++)
   {
	   
				      for ($m = 1 ; $m <= 12 ; $m++)
					  {
						  
	 $engmonth44 = "select engmonth from month where month = '$m'";
	 $engmonth42 = mysql_query($engmonth44);
     $engmonth43 = mysql_fetch_row($engmonth42);
	 $choiseengmonth = $engmonth43[0];
/*mysql_query("update calculate_news set $choiseengmonth = '1' where year ='$y' and category = '存貨成本'");
mysql_query("update calculate_news set $choiseengmonth = '1' where year ='$y' and category = '物料成本'");
mysql_query("update calculate_news set $choiseengmonth = '1' where year ='$y' and category = '運輸成本'");
mysql_query("update calculate_news set $choiseengmonth = '1' where year ='$y' and category = '需求數'");
mysql_query("update calculate_news set $choiseengmonth = '1' where year ='$y' and category = '可生產量'");*/
					  }
}
$gerservertime ="select * from timer where id ='1' and account='server'"; 	
$gerservertime1 = mysql_query($gerservertime);
$gerservertime2 = mysql_fetch_array($gerservertime1,MYSQL_ASSOC);
$sid = $gerservertime2["id"];
$sstatus = $gerservertime2["status"];
$sisstart = $gerservertime2["isstart"];
$sroundtime = $gerservertime2["roundtime"];
$sresttime = $gerservertime2["resttime"];
$sgameyear = $gerservertime2["gameyear"];
$sstarttime = $gerservertime2["starttime"];
$srunid = $gerservertime2["runid"];

mysql_query("TRUNCATE TABLE timer");
mysql_query("insert into timer(id,account,status,isstart,roundtime,resttime,gameyear,starttime,runid)values('1','server','$sstatus','$sisstart','$sroundtime','$sresttime','$sgameyear','$sstarttime','$srunid')");
?>
</body>
</html>
