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

	$play ="select * from environment where id ='1'"; 	
	$play1 = mysql_query($play);
	$play2 = mysql_fetch_array($play1,MYSQL_ASSOC);
	$round = $play2["month"];
	$term = $play2["year"];

   // $company = $_SESSION['company_name'];
    $account=$_SESSION['ID'];
	$acc ="select * from account where Account ='$account'"; 	
	$acc0 = mysql_query($acc);
	$acc00 = mysql_fetch_array($acc0,MYSQL_ASSOC);
	$position = $acc00["Position"];
    
	if($position=="stuManager")
	  {$position = "總經理";}
	  
	else if($position == "teacher")
	{$position = "老師";}
	
	else
	{$position=$position;}
	
	
	
	
	$getroundtime ="select * from timer where id ='1' and account='server'"; 	
	$getroundtime1 = mysql_query($getroundtime);
	$getroundtime2 = mysql_fetch_array($getroundtime1,MYSQL_ASSOC);
	
	$nowrunid = $getroundtime2["runid"];


	$flowtime = $getroundtime2["flowtime"];	//流程精靈
	
		$getruntime ="select * from time where id ='$nowrunid'"; 
		echo $getruntime;	
		$getruntime1 = mysql_query($getruntime);
		$getruntime2 = mysql_fetch_array($getruntime1,MYSQL_ASSOC);

		$status = $getruntime2["status"];  //取得狀態
		echo "eee",$status;

	
	 $sqladmincompany = "select * from company ";
	 $sqladmincompany2 = mysql_query($sqladmincompany);
	 $num=1;
     while($sqladmincompany3 = mysql_fetch_array($sqladmincompany2,MYSQL_ASSOC))
	 {
		 $admincompany[$num]=$sqladmincompany3["company_name"];
		 $num++;
	 }
	 
   if($admincompanychange)
   {
	   $sql1 = "SELECT * FROM company where company_name = '$admincompanychange'";
		$result1 = mysql_query($sql1);
		$getid = mysql_fetch_array($result1,MYSQL_ASSOC);
		$id=$getid["general_manager"];
		$_SESSION['username'] =$id;
		$_SESSION['company_name']=$admincompanychange;
		$company = $_SESSION['company_name'];
   }	
	 





   
							echo "<?php xml version =\"1.0\" ?> \n";
							echo "<response>\n";
							
								echo '<message>';
								echo "<company>".$account."</company>";
								
								echo "<account>".$id."</account>";
								echo "<position>".$position."</position>";
								echo "<cash>".number_format($cash)."</cash>";
								echo "<term>".$term."</term>";
								echo "<round>".$round."</round>";
								echo "<newstitle>".$newstitle."</newstitle>";
								echo "<newscontent>".$newscontent."</newscontent>";
								echo "<status>".$status."</status>";
								echo "<divstatus>".$status."</divstatus>";
								echo "<numm>".$num."</numm>";
								for($i=1;$i<=$num;$i++)
								{
									
									echo "<admincom".$i.">".$admincompany[$i]."</admincom".$i.">";
									
								}
													
								echo '</message>';
							echo "</response>";
	
?>


</body>
</html>