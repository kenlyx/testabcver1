<?php
session_start();

function report($month) {
    $num = array("1" => "高", "2" => "次高", "3" => "中",
        "4" => "次低", "5" => "低");
    $sum = 0;
    $flag = 1;
    $cid = $_SESSION['cid'];

    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
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

    echo "<table align='center' cellspacing='0' style='background-color:#99F'><caption>第".$year."年".$month."月</capiton>";
    echo "<tr><th></th><td width = 100>顧客名稱</td><td width = 80>訂單編號</td><td width = 80>品質需求</td><td width = 80>服務需求</td><td width = 80>定價</td><td width = 80>訂貨量</td><td width = 80>預期收入</td><td width = 80>詢價結果</td></tr>";

    $order = mysql_query("SELECT * FROM order_accept WHERE `b_or_c`=0 ORDER BY `index`", $connect);
    $row = mysql_fetch_array($order);
    echo "<tr><th>B2C</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
    $order = mysql_query("SELECT * FROM order_accept WHERE `b_or_c`=0 ORDER BY `index`", $connect);
    while ($row = mysql_fetch_array($order)) {
        if ($row['cid'] == $cid && $row['month'] == $month && $row['year']==$year) {
            if ($flag % 2 == 1)
                echo "<tr style='background-color: #bbf'>";
            else
                echo "<tr style='background-color: floralwhite'>";

            echo "<td></td><td>" . $row['customer'] . "</td><td>" . $row['order_no'] . "</td><td>" . $num[$row['quality']] . "</td><td>" . $num[$row['service']] . "</td><td>" . $row['price'] . "</td><td>" . $row['quantity'] . "</td>";
            if ($row['accept'] == 1) {
                $sum = $row['price'] * $row['quantity'];
                echo "<td>" . $sum . "</td><td>詢價成功</td>";
            }
            else
                echo "<td>0</td><td>詢價失敗</td>";
            echo "</tr>";
            $flag++;
        }
    }

    $order = mysql_query("SELECT * FROM order_accept WHERE `b_or_c`=1 ORDER BY `index`", $connect);
    $row = mysql_fetch_array($order);
    echo "<tr><th>B2B</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
    $order = mysql_query("SELECT * FROM order_accept WHERE `b_or_c`=1 ORDER BY `index`", $connect);
    while ($row = mysql_fetch_array($order)) {
        if ($row['cid'] == $cid && $row['month'] == $month && $row['year']==$year) {
            if ($flag % 2 == 1)
                echo "<tr style='background-color: #bbf'>";
            else
                echo "<tr style='background-color: floralwhite'>";

            echo "<td></td><td>" . $row['customer'] . "</td><td>" . $row['order_no'] . "</td><td>" . $num[$row['quality']] . "</td><td>" . $num[$row['service']] . "</td><td>" . $row['price'] . "</td><td>" . $row['quantity'] . "</td>";
            if ($row['accept'] == 1) {
                $sum = $row['price'] * $row['quantity'];
                echo "<td>" . $sum . "</td><td>詢價成功</td>";
            }
            else
                echo "<td>0</td><td>詢價失敗</td>";
            echo "</tr>";
            $flag++;
        }
    }
    echo "</table>";
}

if (!strcmp(mysql_real_escape_string($_POST['month']), "now")) {
    $month = $_SESSION['month'];                               //之後在這裡從資料庫中讀出確切月份
    $year=$_SESSION['year'];
    echo ($year-1)*12+(int)$month;
} else {
    report(mysql_real_escape_string($_POST['month']));
}
?>
