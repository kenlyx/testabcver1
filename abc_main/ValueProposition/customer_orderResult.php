<?php @session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顧客訂單</title>
<link rel="stylesheet" href="../css/tableyellow1.css" type="text/css" />
</head>
<body>
<?php
function report($month) {
    $num = array("1" => "高", "2" => "次高", "3" => "中",
        "4" => "次低", "5" => "低");
	$borc = array("0" => "小訂單", "1" => "大訂單");
    $sum = 0;
    $flag = 1;
    //$cid = "C01"; 
	$cid = $_SESSION['cid'];
	$order_month=$_SESSION['month'];
    include("../connMysql.php");
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
<table align='center' cellspacing='0' class="yellowTable">
<?php echo "<caption> 第".$year."年</capiton>";?>
<thead>
<tr>
    <th bgcolor="#4F5F16" scope="co1">月份</th>
    <th scope="co1">訂單種類</th>
    <th>顧客名稱</th>
    <th>訂單編號</th>
    <th>品質需求</th>
    <th>服務需求</th>
    <th>定價</th>
    <th>訂貨量</th>
    <th>預期收入</th>
    <th>詢價結果</th></tr>
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
            else if($row['month']==$order_month){
				echo "<td>0</td><td>詢價中...</td>";
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
    report(mysql_real_escape_string($_POST['year']));

?>

</body>
</html>