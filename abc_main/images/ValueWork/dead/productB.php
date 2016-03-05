<?php
session_start();
require_once("../connMysql.php");
mysql_select_db("testabc_main");
$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;
//$_SESSION['productB_sumit']=1;

$newmonth=$month-1;
$SAPB = $_POST["SA_PB"];
$SBPB = $_POST["SB_PB"];
$SCPB = $_POST["SC_PB"];
$sql="INSERT INTO product_b (`cid`,`year`,`month`,`ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c`,`mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c`)
VALUES ('$cid' , '$year' , '$month' ,'$_POST[SA_PB]','$_POST[SB_PB]','$_POST[SC_PB]','$_POST[SA_PB]','$_POST[SB_PB]','$_POST[SC_PB]')";

  	if(mysql_query($sql)){//成功回傳
  echo "您已完成生產規劃相關決策<br>您已成功投入平板電腦原料<br>供應商A:".$_POST[SA_PB]."<br>供應商B:".$_POST[SB_PB]."<br>供應商C:".$_POST[SC_PB]."<br>系統將於三秒鐘後自動導向回主畫面";
   //header("refresh:3;URL=http://localhost/projectTest/ABCMain/index.php");
  }
else{
  echo "Error creating database: " . mysql_error();
  }
/*<script type="text/JavaScript">
     alert("
	 
	 
	");
</script>*///localhost/projectTest/ABCMain/test

?>
<html>
    <head>
	
	</head>
    <body> 
	<meta http-equiv="refresh" content="10;url=http://localhost/ABC_games/testabc/abc_main/ValueWork/production.php" />

	    </body>
</html>