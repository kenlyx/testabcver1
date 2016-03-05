<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><style type="text/css">
<!--
#div {
	position:absolute;
	width:800px;
	margin:-100px 0px 0px -200px;
	top:97px;
	left:198px;
	text-align: center;
	font-weight:800;
	font-size:0.6cm;
	border: 1px dotted #999;
	overflow: auto;
	height:450px;
	font-family:Arial Unicode MS,微軟正黑體;
	background-attachment: fixed; 
	background-image:url(js/css/wall2.jpg); 
    background-repeat: repeat; 
	}
	.a{
	
	font-size:0.7cm;
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	position:relative;top:45px;left:50px;
	}
	-->
	</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>userInfo</title>
</head>
<body>
<?php
//connect to DB
include_once("C_mysql_connect.php");

//取得遊戲編號
$thisgame=$_SESSION["GameNo"];

//取得公司數目
$query2="SELECT CompanyNum FROM game";   //先不加 where $thisgame=GameNo  測試   
$companyNum=mysql_query($query2);
	$k=0;
	while($row=mysql_fetch_array($companyNum)){	  
	$companyNumArr[$k]=$row['CompanyNum'];       // companyNumArr[]
	$k++;
	}
//取公司編號
$selectCom_query="select CompanyNo from company";  //還沒加gameno
$CompanyNo=mysql_query($selectCom_query) or die("沒抓到companyNo");
	$ii=0;
	while($row=mysql_fetch_array($CompanyNo)){	
	$companyNoArr[$ii]=$row['CompanyNo'];           // companyNoArr[]
	$ii++;
	}
//取出公司名稱
$ki=0;
for($i=0;$i<$companyNumArr[0];$i++){
$selComName_query="select CompanyName from company where companyNo = '$companyNoArr[$i]'";
$CompanyName=mysql_query($selComName_query) or die("沒抓到CompanyName");
	while($row=mysql_fetch_array($CompanyName)){	
	$CompanyName[$ki]=$row['CompanyName'];          // cid[]
	$ki++;
	}}
//取出總經理ID
$iii=0;
for($i=0;$i<$companyNumArr[0];$i++){
$selectsID_query="select CompanyManager from company where companyNo = '$companyNoArr[$i]'";
$StudentNo=mysql_query($selectsID_query) or die("沒抓到StudentNo");
	while($row=mysql_fetch_array($StudentNo)){	
	$companyManagerID[$iii]=$row['CompanyManager'];       
	$iii++;
	}}
//取出初有資金	這邊想再研究一下
$kk=0;
for($i=0;$i<$companyNumArr[0];$i++){                       //暫定為game1
$selectmoney_query="select InitialCapital from c_bsc where GameNo ='1'"; // '$thisgame'  資金都一樣了還要做在表格裡嗎??
$money=mysql_query($selectmoney_query) or die("沒抓到money");  
	while($row=mysql_fetch_array($money)){	
	$moneyArr[$kk]=$row['InitialCapital'];
	$kk++;
	}}		       
?><div id="div">
<div class="a">玩家資訊
<!--上方欄-->
<table border="1">
  <tr>
    <th scope="col">公司編號</th>
    <th scope="col">公司名稱</th>
    <th scope="col">初始資金</th>         
    <th scope="col">公司人數</th>
    <th scope="col">公司成員</th>
    <th scope="col">成員決策</th>
  </tr>
  
<?php
 for($i=0;$i<$companyNumArr[0];$i++){

//取出所有公司成員ID
$j=0;
	
$studentNum=0;	
$selectAllID_query="select Account from account where cid = '$cid[$i]'"; 
$StudentNoAll=mysql_query($selectAllID_query) or die("沒抓到StudentNo");
	while($row=mysql_fetch_array($StudentNoAll)){	
	$studentID[$j]=$row['Account'];
	$studentNum++;
	$j++;
	}

/* 顯示學生分配到的權限 */
	   $find21 = "select Decision from account where cid = '$cid[$i]'";
     $findposition21 =  mysql_query($find21);/* 查詢DB裡的位置 */
	   $findvalue21 = mysql_fetch_row($findposition21);/* 查詢DB位置的值 */    	   
	   $finddata21 = $findvalue21[0];/* 第一筆資料 */  
	   
	   $decno = explode(",",$finddata21);
	   $decname = array();
     
                    
/* 存入決策到陣列 */	   
	   for($k=0;$k<sizeof($decno);$k++)
		  {
			  $find31 = "select DecisionName from info_decision where DecisionNo = '$decno[$k]'";
	          $findposition31 =  mysql_query($find31);/* 查詢DB裡的位置 */
	          $findvalue31 = mysql_fetch_array($findposition31);
	          $finddata31[$k] = $findvalue31['DecisionName'];/* 第一筆資料 */  
           
		  }
      
	
//取得成員數目	
//$studentNum=mysql_num_rows($StudentNoAll); //因為前面就有了所以不需要
?>
<!--欄位內容-->
  <tr><th><?php echo "C ".$companyNoArr[$i]; ?></th> 
      <th><?php echo $cid[$i]; ?></th>
      <th><?php echo $moneyArr[$i]; ?></th>     
      <th><?php echo $studentNum; ?></th>
      <th>
        <table><?php
        for($k=0;$k<$studentNum;$k++){ ?>
        <tr><th> <?php echo $studentID[$k]  ?> </th></tr>
        <?php } ?></table>
      </th>
      
      <th> 
      <table><?php
	  	for($k=0;$k<sizeof($decno);$k++){ ?>
        <tr><th><?php echo $finddata31[$k]  ?></th></tr>
      <?php } ?></table></th>	
      </tr>
	
<?php }?>

</table>
</div>
</div>
</body>
</html>