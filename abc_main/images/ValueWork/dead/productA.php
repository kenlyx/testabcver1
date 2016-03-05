<?php
session_start();
require_once("../connMysql.php");
mysql_select_db("testabc_main");
$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;
//$_SESSION['productA_sumit']=1;
$newmonth=$month-1;

//$sql="INSERT INTO `product_a` (`cid`,`year`,`month`,`ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c`,`mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c`,`mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c`)
//VALUES ('$cid' , '$year' , '$month' ,'$_POST[SupA_ProductA]','$_POST[SupB_ProductA]','$_POST[SupC_ProductA]','$_POST[SupA_ProductA]','$_POST[SupB_ProductA]','$_POST[SupC_ProductA]','$_POST[SupA_ProductA]','$_POST[SupB_ProductA]','$_POST[SupC_ProductA]')";
$SAPA = $_POST["SA_PA"];
$SBPA = $_POST["SB_PA"];
$SCPA = $_POST["SC_PA"];
mysql_query("DELETE FROM product_a WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");

  	if(mysql_query("INSERT INTO `product_a` (`cid`,`year`,`month`,`ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c`,`mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c`,`mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c`)
VALUES ('$cid' , '$year' , '$month' ,'$SAPA','$SBPA','$SCPA','$SAPA','$SBPA','$SCPA','$SAPA','$SBPA','$SCPA')")){//成功回傳

  echo "您已成功投入筆記型電腦原料<br>供應商A:".$_POST["SA_PA"]."<br>供應商B:".$_POST["SB_PA"]."<br>供應商C:".$_POST["SC_PA"]."<br>系統將於三秒鐘後自動導向回主畫面";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
/*<script type="text/JavaScript">
     alert("<?phpecho
	 
	 
	 ?>");
</script>*/





?>
<html>
    <head>
	
	</head>
    <body> 
	<meta http-equiv="refresh" content="10;url=http://localhost/ABC_games/testabc/abc_main/ValueWork/production.php" />

	    </body>
</html>