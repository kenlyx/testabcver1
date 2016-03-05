<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<script type="text/javascript" src="abc_main/js/jquery.js"></script>
<body>

<input type="image" id="fukyou" src="abc_main/images/research.png"  onclick="fuk()"/>

<?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);
	$time = time();
	
	//操作用變數*********************************************
	//假設當前正確時間是1y3m  這邊設定1y4m  會刪除1y4m(含)以後的檔
	$year = 1;
	$month = 2;
	//*****************************************************
	$round = (($year-1)*12)+$month;
	/*
	mysql_query("DELETE From `ad_a` WHERE ((`year`>='$year' AND `month`>='$month') OR (`year`>'$year'))",$connect);
	mysql_query("DELETE From `ad_b` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `cash` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `current_assets` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `current_liabilities` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `current_people` WHERE (`year`>='$year' AND `month`>=$month-1) OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `donate` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `dupont` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `equity` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `financing_netin` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `fixed_assets` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `fund_raising` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `income_taxes` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `investing_netin` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `long-term_liabilities` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `machine` WHERE `buy_year`>='$year' AND `buy_month`>='$month'",$connect);
	mysql_query("DELETE From `market_trend` WHERE (`year`>='$year' AND `month`>=$month-1) OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `materials_cost` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `material_result` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `operating_costs` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `operating_expenses` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `operating_netin` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `operating_revenue` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `order_accept` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `order_detail` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `other_expenses` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `other_revenue` WHERE `month`>=$round-1",$connect);
	mysql_query("DELETE From `process_improvement` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `production_cost` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `product_a` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `product_b` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `product_history` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `product_plan` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `product_quality` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `purchase_materials` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `purchase_materials_price` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `r_d` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `score` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `share` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `state` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `stock` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `supplier_a` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `supplier_b` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `supplier_c` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	mysql_query("DELETE From `training` WHERE (`year`>='$year' AND `month`>='$month') OR (`year`>'$year')",$connect);
	*/
	

?>




<script type="text/javascript">
var a = new Date().getTime();
$(document).ready(function(e) {
    document.getElementById("abc").innerHTML = <?php echo $time; ?>;
	
});

function fuk(){
	a = new Date().getTime();
	var b = <?php echo $time; ?>;
	document.getElementById("abc").innerHTML = a;
	document.getElementById("ab").innerHTML = b;
	setTimeout("fuk()",1000);
}
</script>
<table width="750" border="1" cellpadding="5">
  <tr>
    <th scope="col" id="abc">AS</th>
    <th scope="col" id="ab">AS</th>
  </tr>
</table>

</body>
</html>