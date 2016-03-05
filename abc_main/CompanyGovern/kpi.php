<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<style type="text/css">
@charset "utf-8";
body{
	background-size:cover;
	text-align:center;
}
table{
	border-style:double;
	border-width:10px;
	border-color:000000;
	-webkit-border-radius: 10px;
	color:#000;
	font-family:微軟正黑體,Ariel;
}

</style>
</head>

<body>
<?php
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
$session=$_SESSION['month']-1+($_SESSION['year']-1)*12;
mysql_select_db("testabc_login", $connect);
$cid=$_SESSION['cid'];
/*$temp=mysql_query("SELECT `Position` FROM `authority` WHERE `Account` = '{$_SESSION['user']}'",$connect);
$result_temp=mysql_fetch_array($temp);
$position=$result_temp[0];*/
?>
<!--<div class="title">KPI 管理</div>
<p>-->
<p>
<table width="76%" align="center">
  <tr style="font-size:20px;">
    <th width="32%" scope="col"><p>KPI名稱</th>
    <th width="29%" scope="col">年度預測值</th>
    <th width="25%" scope="col">實際營運值</th>
    <th width="14%" scope="col">狀態燈</th>
  </tr>
<?php 
include './ConnectDB.php';//連主控台DB改帳密!!!!!

$sql_kpiName = mysql_query("select * from kpi_abc");//這裡要改自己的table,kpi_inception或kpi_abc

$num = mysql_num_rows($sql_kpiName);
$kpinum = 0; 

include('./ConnectMysql.php');//連自己DB
$sql_kpi = mysql_query("select * from kpi_info where account='".$cid."' and session='".$session."'");
//echo"select * from kpi_info where account='".$cid."' and session='".$session."'";
$kpi = mysql_fetch_array($sql_kpi);

while($kpiName = mysql_fetch_array($sql_kpiName)){
	$kpinum+=1;
        if($kpi[$kpinum*2+1]!=0)
            $proportion=round($kpi[$kpinum*2]/$kpi[$kpinum*2+1],2);
	else
            $proportion=0;
        $pro=$proportion*100;
	
	if($proportion<=0.5)
		$light="red";
	else if($proportion<=0.8)
		$light="yellow";
	else
		$light="green";
	echo'
  <tr>
    <th scope="row"><input style="text-align:center;width:300px" disabled="disabled" name="kpi'.$kpinum.'" type="text" id="kpi'.$kpinum.'" value="'.$kpiName[0].'"/></th>
    <td>
      <input style="text-align:right" disabled="disabled" name="predict'.$kpinum.'" type="text" id="predict'.$kpinum.'" size="12" value="'.number_format($kpi[$kpinum*2+1]).'"/>
    </td>
    <td>
      <input style="text-align:right" disabled="disabled" name="average'.$kpinum.'" type="text" id="average'.$kpinum.'" size="12" value="'.number_format($kpi[$kpinum*2]).'"/>
   </td>
   <td style="text-align:center;">
      <input name="light" type="image" src="./images/'.$light.'_light.png" id="light width="40" height="40" title="目前已達成'.$pro.'%"/>
    </td>
  </tr>
	';

}
?>
</table>
<p>
<p>
<p>
<p>
<p>
</body>
</html>