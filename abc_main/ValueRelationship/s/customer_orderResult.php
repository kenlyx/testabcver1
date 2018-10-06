<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顧客訂單</title>
<link rel="stylesheet" href="../css/style.css"/>
<link rel="stylesheet" href="../css/tableyellow.css" type="text/css" />
</head>
<body>
<?php
@session_start();

function report($month) {
    $num = array("1" => "高", "2" => "次高", "3" => "中",
        "4" => "次低", "5" => "低");
	$borc = array("1" => "小訂單", "0" => "大訂單");
    $sum = 0;
    $flag = 1;
    $cid = $_SESSION['cid'];

    include("./connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
    
	if($month<=12)
        $year=1;
    else{
        if($month%12==0){
            $year=(int)($month/12);
            $month=12;
        }else{
            $year=(int)($month/12)+1;
            $month=$month%12;
        }
    }
?>
    <style>
	#content{
		margin-top:10px;
		margin-left:32px;
		}
	</style>
    <body>
    <div id="content" style="height:530px">
        <a class="back" href=""></a>
        <p class="head">
        ShelviDream Activity Based Costing Simulated System
        </p>
        <h1>顧客訂單量</h1>
        <p style="height:2%;">
        
<table align='center' cellspacing='0'>
<?php echo "<caption> 第".$year."年</capiton>";?>
<thead>
<tr>
    <th width = 80 bgcolor="#4F5F16" scope="co1">月份</th>
    <th scope="co1" width = 120>訂單種類</th>
    <th width = 120>顧客名稱</th>
    <th width = 120>訂單編號</th>
    <th width = 120>品質需求</th>
    <th width = 120>服務需求</th>
    <th width = 120>定價</th>
    <th width = 120>訂貨量</th>
    <th width = 120>預期收入</th>
    <th width = 120>詢價結果</th>
	<th width = 120>滿意度</th>
	<th width = 120>提升等級</th>
     
     
	</tr>
</thead>
<?php
$order = mysql_query("SELECT * FROM order_accept ORDER BY `index`");
    while ($row = mysql_fetch_array($order)) {
        if ($row['cid'] == $cid && $row['year']==$year) {
            if ($flag % 2 == 1)
                echo "<tr class='odd'>";
            echo "<td>".$row['month']."</td><td>".$borc[$row['b_or_c']]."</td><td>".$row['customer']."</td><td>".$row['order_no']."</td><td>".$num[$row['quality']]."</td><td>".$num[$row['service']]."</td><td>".$row['price']."</td><td>".$row['quantity']."</td>";
            if ($row['accept'] == 1) {
                $sum = $row['price'] * $row['quantity'];
                echo "<td>".$sum."</td><td>詢價成功</td>";
            }
            else
                echo "<td>0</td><td>詢價失敗</td>";
            echo "</tr>";
            $flag++;
        }
    }
?>
</table>
<?php
}
if (!strcmp(mysql_real_escape_string($_POST['month']), "now")) {
    $month = $_SESSION['month'];  //之後在這裡從資料庫中讀出確切月份
    $year=$_SESSION['year'];
    echo ($year-1)*12+(int)$month;
} else {
    report(mysql_real_escape_string($_POST['month']));
}
?>
</div>
</body>
</html>