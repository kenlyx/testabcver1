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
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    echo "</tr></thead><tr style=><td>期初原料</td>";
    $result = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`) FROM materials_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`<$first_month) OR `year`<$year)", $connect);
    $data = mysql_fetch_array($result);
    $i = 0;
    $material_array[$i]+=$data[0] + $data[1] + $data[2] + $data[3] + $data[4] + $data[5] + $data[6] + $data[7] + $data[8];
    $result = mysql_query("SELECT SUM(`product_A_material_total`),SUM(`product_B_material_total`) FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`<$first_month) OR `year`<$year)", $connect);
    $data = mysql_fetch_array($result);
    $material_array[$i]-=$data[0] + $data[1];
    $temp_name1 = "`product_" . $type . "_material_total`";
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }

    $temp_month = $month;
    while ($data1 = mysql_fetch_array($result)) {
        echo "<td>" . number_format($material_array[$i]) . "</td>";
        $year2 = (int) (($temp_month - 1) / 12) + 1;
        $month2 = ($temp_month - 1) % 12 + 1;
        $temp_month++;
        $result1 = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`) FROM materials_cost WHERE `cid`='$cid' AND `year`=$year2 AND `month`=$month2", $connect);
        $data = mysql_fetch_array($result1);
        $material_array[$i + 1]+=$material_array[$i] + $data[0] + $data[1] + $data[2] + $data[3] + $data[4] + $data[5] + $data[6] + $data[7] + $data[8];
        $result1 = mysql_query("SELECT SUM(`product_A_material_total`),SUM(`product_B_material_total`) FROM production_cost WHERE `cid`='$cid' AND `year`=$year2 AND `month`=$month2", $connect);
        $data = mysql_fetch_array($result1);
        $material_array[$i + 1]-=$data[0] + $data[1];
        $i++;
    }
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }

    echo "</tr><tr><td>本期購入</td><td>1000</td>";
//        $result=mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`) FROM materials_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`<=$first_month ) OR (`year`=$year+1 AND `month`<$first_month))",$connect);
//        while($data=mysql_fetch_array($result)){
//            $material=$data[0]+$data[1]+$data[2]+$data[3]+$data[4]+$data[5]+$data[6]+$data[7]+$data[8];
//            echo "<td>".$material."</td>";
//        }
    //if ($year == $end_year) {
    //    $result = mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c`,`mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c`,`mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c` FROM materials_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    //} else {
    //    $result = mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c`,`mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c`,`mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c` FROM materials_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    //}
    //while ($data = mysql_fetch_array($result)) {
    //    $material = $data[0] + $data[1] + $data[2] + $data[3] + $data[4] + $data[5] + $data[6] + $data[7] + $data[8];
   //     echo "<td>" . number_format($material) . "</td>";
    //}
    echo "</tr><tr style=><td>期末原料</td><td>1000</td>";
    //if ($year == $end_year) {
     //   $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    //} else {
    //    $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    //}
    $i = 1;
   // while ($data = mysql_fetch_array($result)) {
    //    echo "<td>" . number_format($material_array[$i]) . "</td>";
    //    $i++;
    //}
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name1 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    echo "</tr><tr><td>直接原料</td><td>0</td><td>$1,000,000</td>";
  //  while ($data = mysql_fetch_array($result)) {
   //     $sub_data = round($data[0]);
    //    echo "<td>" . number_format($sub_data) . "</td>";
    //}
    $temp_name2 = "`product_" . $type . "_direct_labor`";
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name2 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name2 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    echo "</tr><tr style=><td>直接人工</td>";
    while ($data = mysql_fetch_array($result)) {
        $sub_data = round($data[0]);
        echo "<td>" . number_format($sub_data) . "</td>";
    }
    $temp_name3 = "`product_" . $type . "_overhead`";
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name3 FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name3 FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    echo "</tr><tr><td>間接生產</td>";
    while ($data = mysql_fetch_array($result)) {
        $sub_data = round($data[0]);
        echo "<td>" . number_format($sub_data) . "</td>";
    }
    $temp_name = $temp_name1 . "," . $temp_name2 . "," . $temp_name3;
    if ($year == $end_year) {
        $result = mysql_query("SELECT $temp_name FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT $temp_name FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    echo "</tr><tr style=><td>製成品成本</td>";
    $i = 0;
    while ($data = mysql_fetch_array($result)) {
        $sub_data = round($data[0] + $data[1] + $data[2] + $data[3] + $data[4]);
        echo "<td>" . number_format($sub_data) . "</td>";
        $cost_array[$i]+=$sub_data;
        $i++;
    }
    echo "</tr><tr><td>期初製成品</td>";
    $inventory = "product_" . $type . "_inventory";
    if ($year == $end_year) {
        $result = mysql_query("SELECT `$inventory` FROM `production_cost` WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT `$inventory` FROM `production_cost` WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    $temp = 0;
    while ($data = mysql_fetch_array($result)) {
//        if ($month == 1) {
            echo "<td>" . number_format($temp) . "</td>";
            $temp = round($data[0]);
//        }
//        else
//            echo "<td>" . number_format(round($data[0])) . "</td>";
    }
    echo "</tr><tr style=><td>期末製成品</td>";
    if ($year == $end_year) {
        $result = mysql_query("SELECT `$inventory` FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT `$inventory` FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    while ($data = mysql_fetch_array($result)) {
        echo "<td>" . number_format(round($data[0])) . "</td>";
    }
    echo "</tr><tr><td>銷貨成本</td>";
    $product_COGS = "product_" . $type . "_COGS";
    if ($year == $end_year) {
        $result = mysql_query("SELECT `$product_COGS` FROM production_cost WHERE `cid`='$cid' AND (`year`=$year AND `month`>=$first_month AND `month`<$end_month)", $connect);
    } else {
        $result = mysql_query("SELECT `$product_COGS` FROM production_cost WHERE `cid`='$cid' AND ((`year`=$year AND `month`>=$first_month) OR (`year`=$end_year AND `month`<$end_month))", $connect);
    }
    while ($data = mysql_fetch_array($result)) {
        echo "<td>" . number_format(round($data[0])) . "</td>";
    }
    echo "</tr></table>";
}

cost_of_sales(mysql_real_escape_string($_POST['type']), mysql_real_escape_string($_POST['month']));
?>