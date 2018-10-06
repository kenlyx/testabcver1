<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KPI預測</title>
<script src="./jquery-1.5.1.min.js"></script>
<style type="text/css">
@charset "utf-8";
body{/*
	background:url(bg4.jpg);*/
	font-family:"Comic Sans MS", cursive;
	background-repeat:repeat;
	text-align:center;
}
table{
	border-style:double;
	border-width:10px;
	border-color:#666;
	background:#000;
	-webkit-border-radius: 10px;
	color:#CCC;
	font-family:微軟正黑體,Ariel;

}
.title {
	text-align:center;
	background-color:#FA6A3A;
	font-size:30px;
	font-weight:bolder;
	color:#FFF;
	padding:2px;
}
.title span{
	font-size:16px;
	color:#000;
}
.title_d {
	font-size:16px;
	font-weight:bolder;
	color:#000;
	text-align:left;
}
</style>

</head>

<body>
<?php
include ("../connMysql.php");
mysql_select_db("testabc_main");
mysql_query("set names 'utf8'");

$temp=mysql_query("SELECT MAX(`year`) FROM `state`");
$result_temp=mysql_fetch_array($temp);
$year=$result_temp[0];
$temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
$result_temp=mysql_fetch_array($temp);
$month=$result_temp[0];
$session=$month+($year-1)*12;
mysql_select_db("testabc_login");
$temp=mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account` WHERE `Account` = '".$_SESSION['user']."'");
//$temp=mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account` WHERE `Account` = '984003008'");
$result_temp=mysql_fetch_array($temp);
$cid=$result_temp[0];
$temp=mysql_query("SELECT `GameName` FROM `game`");
$result_temp=mysql_fetch_array($temp);
$gamename=$result_temp[0];
?>
<div class="title">KPI 預測 <span><?php echo "第".$year."年 &nbsp;".$month."月"; ?></span></div>
<?php
//echo "回合:".$session."  公司名稱: ".$cid."   競賽名稱: ".$gamename;
echo ' 公司名稱：'.$cid.'&nbsp;&nbsp;競賽名稱：'.$gamename.'
<p>
<table border="0" align="center"><tr><th scope="col">KPI</th><th scope="col">推薦KPI</th>
    <th scope="col">輸入預測值</th>
    </tr>
    ';

$php = "select * from kpi_abc";//這裡要改自己的table,kpi_abc
$php2 = mysql_query($php);
$num = mysql_num_rows($php2);
$kpinum = 0; 
mysql_select_db("testabc_main");
$t=mysql_query("select * from kpi_info where `session`=".$session);
$php4 = mysql_fetch_array($t);
while($php3 = mysql_fetch_array($php2)){
$kpinum+=1;
 	echo'
  <tr>
    <th scope="row"><input style="text-align:center; width:400px"  disabled="disabled" name="kpi'.$kpinum.'" type="text" id="kpi'.$kpinum.'" size="10" value="'.$php3[0].'"/></th><td>';
	   
	   echo '<input style="text-align:right; width:200px"  disabled="disabled"  name="average'.$kpinum.'" type="text" id="average'.$kpinum.'" size="10" value="'.number_format($php3[1]).'"/>';
       //第一年一月，讀取預設值(=推薦值)，可寫
       if($year==1 && $month==1){
          echo '</td><td><input style="text-align:right; width:200px" name="predict'.$kpinum.'" type="text" id="predict'.$kpinum.'" value="'.number_format($php3[1]).'" size="15"/>';
       //其他年一月，讀取user第一年設定的預測值，可寫
	   }else if($year!=1 && $month==1){
          echo '</td><td><input style="text-align:right; width:200px" name="predict'.$kpinum.'" type="text" id="predict'.$kpinum.'" value="'.number_format($php4[(2*$kpinum+1)]).'" size="15"/>';
       //其他月，讀取user第一年設定的預測值，不可寫
	   }else{
          echo '</td><td><input style="text-align:right;width:200px" disabled="disabled" name="predict'.$kpinum.'" type="text" id="predict'.$kpinum.'" value="'.number_format($php4[(2*$kpinum+1)]).'" size="15"/>';
	   }
       echo '</td></tr>';
	   $kpi[$kpinum]=$php3[0];//KPI名字
}
  echo '</table>';
?>
<p>
<input type="image" src="../images/submit6.png" id="submit" name="submit" style="width:100px">
<!--<input type="submit" id="submit" name="submit" value="送出" />-->
<?php
	function reverse($number) {
    	return (int)str_replace(",","",$number);
	}
	$var="varchar(30) NOT NULL";
	$int="int(11) NOT NULL";
	$kpipre="";
	error_reporting(0);
	$predict = array(0,mysql_real_escape_string($_POST['predict1']),mysql_real_escape_string($_POST['predict2']),mysql_real_escape_string($_POST['predict3']),mysql_real_escape_string($_POST['predict4']),mysql_real_escape_string($_POST['predict5']),mysql_real_escape_string($_POST['predict6']),mysql_real_escape_string($_POST['predict7']),mysql_real_escape_string($_POST['predict8']),mysql_real_escape_string($_POST['predict9']),mysql_real_escape_string($_POST['predict10']),mysql_real_escape_string($_POST['predict11']),mysql_real_escape_string($_POST['predict12']),mysql_real_escape_string($_POST['predict13']),mysql_real_escape_string($_POST['predict14']),mysql_real_escape_string($_POST['predict15']),mysql_real_escape_string($_POST['predict16']),mysql_real_escape_string($_POST['predict17']),mysql_real_escape_string($_POST['predict18']),mysql_real_escape_string($_POST['predict19']),mysql_real_escape_string($_POST['predict20']),mysql_real_escape_string($_POST['predict21']),mysql_real_escape_string($_POST['predict22']),mysql_real_escape_string($_POST['predict23']),mysql_real_escape_string($_POST['predict24']),mysql_real_escape_string($_POST['predict25']),mysql_real_escape_string($_POST['predict26']),mysql_real_escape_string($_POST['predict27']),mysql_real_escape_string($_POST['predict28']),mysql_real_escape_string($_POST['predict29']),mysql_real_escape_string($_POST['predict30']));
	
	for($i=1;$i<=$num;$i++){//table欄位名稱
		if($i==$num){
			$kpipre.="`".$kpi[$i]."` ".$int.",`predict".$i."` ".$int;
		}
		else{
			$kpipre.="`".$kpi[$i]."` ".$int.",`predict".$i."` ".$int.",";
		}
	}
	
	
	$select_db=@mysql_select_db("testabc_main");
	
if($predict[1]!=null){
		
		for($i=1;$i<=$num;$i++){
			if($i==$num)
				$kpipre2.='"0","'.reverse($predict[$i]).'"';
		
			else
				$kpipre2.='"0","'.reverse($predict[$i]).'",';
		}
	
		for($j=0;$j<12;$j++){
			$session2=$session+$j;
		    mysql_query('insert into kpi_info values("'.$cid.'","'.$session2.'",'.$kpipre2.')')or die(mysql_error());
		}
	}
if($month==1){
?>
<script language="javascript">
$(function() {  
  
//環境指數 update 進 DB  
  $('#submit').click(function(){
    $.post("KPI_ceo.php",{
	  predict1:$("#predict1").val(),
	  predict2:$("#predict2").val(),
	  predict3:$("#predict3").val(),
	  predict4:$("#predict4").val(),
	  predict5:$("#predict5").val(),
	  predict6:$("#predict6").val(),
	  predict7:$("#predict7").val(),
	  predict8:$("#predict8").val(),
	  predict9:$("#predict9").val(),
	  predict10:$("#predict10").val(),
	  predict11:$("#predict11").val(),
	  predict12:$("#predict12").val(),
	  predict13:$("#predict13").val(),
	  predict14:$("#predict14").val(),
	  predict15:$("#predict15").val(),
	  predict16:$("#predict16").val(),
	  predict17:$("#predict17").val(),
	  predict18:$("#predict18").val(),
	  predict19:$("#predict19").val(),
	  predict20:$("#predict20").val(),
	  predict21:$("#predict21").val(),
	  predict22:$("#predict22").val(),
	  predict23:$("#predict23").val(),
	  predict24:$("#predict24").val(),
	  predict25:$("#predict25").val(),
	  predict26:$("#predict26").val(),
	  predict27:$("#predict27").val(),
	  predict28:$("#predict28").val(),
	  predict29:$("#predict29").val(),
	  predict30:$("#predict30").val()
      },function(xml){
		  	alert("設定完成!")
      });
	// alert("加入成功");
	});
});
</script>
<?php
}
?>
</body>
</html>