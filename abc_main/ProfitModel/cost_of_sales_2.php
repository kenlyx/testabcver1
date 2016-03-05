<?php

session_start();

function cost_of_sales($type, $month) {//印出報表的主程式
    $year = (int) (($month - 1) / 12) + 1;
    $first_month = ($month - 1) % 12 + 1;
    $end_year = (int) (($month + 5) / 12) + 1;
    $end_month = ($month + 5) % 12 + 1;
    $change = 0;                                                          //控制列為空值的變數，1代表不為空
    $flag = 1;                                                            //控制列的背景色彩，1代表有色彩
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());  //與資料庫進行連結
    $cid = $_SESSION["cid"];
    $cost_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    $material_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    $product_array = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    if ($type == "A")
        echo "<table class='yellowTable' width='100%' height='100%'><caption><font size=6><b>筆記型電腦的銷貨成本分析</b></font></caption>";
    if ($type == "B")
        echo "<table class='yellowTable' width='100%' height='100%'><caption><font size=6><b>平板電腦的銷貨成本分析</b></font></caption>";
    echo "<thead>";
    echo "<td width ='16%'>年份</td>";
    for ($i = $first_month; $i < $first_month + 6; $i++) {//印出年份
        $year1 = $year;
        if ($i % 12 == 1 || $i == $first_month) {
            echo "<td width='12%' colspan='12' align='left'>第" . $year1 . "年</td>";
            $year1+=1;
        }
    }
    echo "<tr><th width ='12%'>月份</th>";
    for ($i = $first_month; $i < $first_month + 6; $i++) {//印出月份
        if ($i % 12 == 0)
            echo "<th width ='12%'>第12月</th>";
        else
            echo "<th width ='12%'>第" . ($i % 12) . "月</th>";
    }
   echo "</tr></thead><tr style=><td>期初原料</td><td>0</td><td>$10,000,000</td><td>$10,000,000</td><td>$15,000,000</td><td>$8,000,000</td><td>$3,000,000</td>";
    echo "</tr><tr><td>本期購入</td><td>$10,000,000</td><td>0</td><td>$5,000,000</td><td>0</td><td>0</td><td>$500,000</td>";

    echo "</tr><tr style=><td>期末原料</td><td>$10,000,000</td><td>$10,000,000</td><td>$15,000,000</td><td>$8,000,000</td><td>$3,000,000</td><td>0</td>";
    
    echo "</tr><tr><td>直接原料</td><td>0</td><td>0</td><td>0</td><td>$7,000,000</td><td>$5,000,000</td><td>$3,500,000</td>";
    
    echo "</tr><tr style=><td>直接人工</td><td>0</td><td>0</td><td>0</td><td>$1,200,000</td><td>$860,000</td><td>$600,000</td>";
   
    echo "</tr><tr><td>間接生產</td><td>0</td><td>0</td><td>0</td><td>$600,000</td><td>$500,000</td><td>$350,000</td>";
    
    echo "</tr><tr style=><td>製成品成本</td><td>0</td><td>0</td><td>0</td><td>$8,800,000</td><td>$6,360,000</td><td>$4,450,000</td>";
    
    echo "</tr><tr><td>期初製成品</td><td>0</td><td>0</td><td>0</td><td>0</td><td>$1,200</td><td>$2,200</td>";
    
    echo "</tr><tr style=><td>期末製成品</td><td>0</td><td>0</td><td>0</td><td>$1,200</td><td>$1,000</td><td>$850</td>";
    
    echo "</tr><tr><td>銷貨成本</td><td>0</td><td>0</td><td>0</td><td>$8,801,200</td><td>6,359,800</td><td>$4,448,650</td>";
    
    echo "</tr></table>";
}

cost_of_sales($_POST['type'], $_POST['month']);
?>