<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首頁</title>
<style type="text/css">
/*body{
}
.whtable{
	font:"MV Boli";
	color:#FFF;
	font-size:18px;
	text-align:center;
	}
#mframe {
	background-image:url(../images/bg.png);
	height:80%;
	width:52%;
	margin-top:4%;
	margin-left:24%;
}*/
.show{
	color:#F60;
	}
input.groovybutton
{
   font-size:18px;
   color:#FFF;
   height:32px;
   background-color:#0077BB;
   border-style:none;
   font-family:Arial Unicode MS,微軟正黑體;
}

<!--
#div {
	background-color:#FFF;
	position:absolute;
	width:54%;
	top:10%;
	left:23%;
	right:23%;
	font-weight:800;
	font-size:1.2cm;
	text-align: center;
	border: 4px dotted #f5f500;
	overflow: auto;
	height:74%;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	.a{
	text-align:left;
	font-size:0.5cm;
	margin-left:6%; 
	margin-right:6%; 
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	
    .b{
	margin-left:6%; 
	margin-right:6%; 
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	background-color:#ccddff;
	}
.body{
	}    
</style>
</head>
<?php
include("../connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
mysql_query("set names 'utf8'");

$year=$_SESSION['year'];
$month=$_SESSION['month'];
$account=$_SESSION['user'];
$cid=$_SESSION['cid'];
//echo $cid."<br>";
//echo $account;

$sql_decision=mysql_query("SELECT * FROM `authority` WHERE `Account`='".$account."' and `Year`='".$year."'");
$rows_d=mysql_num_rows($sql_decision);
if($rows_d==0)
	$stated="<font color='#FF3300'>未完成</font>";
else
	$stated="<font color='#0077BB'>已完成</font>";	
//echo $rows_d;
//$result[0]=今年此公司的資料

mysql_select_db("testabc_main");
$sql_kpi=mysql_query("SELECT Max(`session`) FROM `kpi_info` WHERE `account`='".$cid."'");
$result_k=mysql_fetch_array($sql_kpi);
$rows_k=mysql_num_rows($sql_kpi);
$noerror=$result_k[0]%12;
if($result_k[0]==NULL)
	$rows_k=0;
if($rows_k==0)
	$statek="<font color='#FF3300'>未完成</font>";
else
	$statek="<font color='#0077BB'>已完成</font>";		
//echo "<br>".$rows_k;
//echo "<br>".$result_k[0];
?>
<script>
function check(){
	var s=new Array('決策分配','kpi預測');
	
	if(<?php echo $rows_d ?> == 1){
		removeItem(s,'決策分配');
	}
	//alert(s[0]+s[1]);
	if(<?php echo $rows_k ?> !=0 && <?php echo $noerror ?> == 0){
		removeItem(s, 'kpi預測');
	}
	//alert(s[0]+s[1]);
	if(s.length>0){
		//alert(s.length);
		if(s.length==2){
			alert("未完成："+s[0]+"、"+s[1]+"\n請務必完成設定再繼續競賽");
		}else{		
			alert("未完成："+s[0]+"\n請務必完成設定再繼續競賽");
		}
	}else{
		//alert(s[0]+s[1]);
		top.location= ('../../abc_main/main.php');
		alert("登入成功!");
		
	}

}
function removeItem(array, item){
    for(var i in array){
        if(array[i]==item){
            array.splice(i,1);
            break;
            }
    }
}

 function logout(){
	top.location= ('../logout.php');
}	

</script>
<body>
<div id="div" align="center">
<div class="b">
<p>
<table class="whtable" align="center">
<tr>
<td colspan="2" align="center"><b>ABC模擬經營競賽系統</b></td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td width="12%" style="vertical-align:top">決策分配：</td><td width="88%">屬於公司治理決策之一，總經理於年初與其他經理開會討論年度決策權，並進行決策分配。
總經理用有全部的決策權，請勿分配決策給總經理。無決策權者無法執行該項決策，一旦設定完成制下年度前將無法修改，請謹慎決定決策權的分配。</td>
</tr>
<tr>
<td colspan="2"><hr></td>
</tr>
<tr>
<td width="12%" style="vertical-align:top">KPI設定：</td><td  width="88%">屬於公司資訊內容之一，總經理於年初與其他經理開會討論，預測出年度KPI指標，並設定之。可
依照推薦值填寫，其值將影響公司目標達成率之績效分數。</td>
</tr>
</table>
</div>
<div class="a">
<table class="whtable" align="center">
<p>
<tr>
<td colspan="2"><b>競賽設定狀態</b></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>決策分配：</td><td><?php echo $stated?></td>
</tr>
<tr>
<td>KPI 預測：</td><td><?php echo $statek?></td>
</tr>
<tr>
<td colspan="2"><br><input type="button" name="button" id="continue" class="groovybutton" value="繼續競賽" onClick="check()" />
&nbsp;&nbsp;<input type="button" name="button" id="logout" class="groovybutton" value="登出" onClick="logout()"/></td>
</tr>
</table>
</div>
</div>
</body>
</html>