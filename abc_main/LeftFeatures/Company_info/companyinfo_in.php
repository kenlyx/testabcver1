<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title>使用 jQuery 實作內容切換顯示</title>
<link rel="stylesheet" type="text/css" href="css/import.css" media="all" />
<script type="text/javascript" charset="utf-8" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery_ticker.js"></script>

</head>
<?php
//include('connectDB.php');

$cid = $_SESSION['cid'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];
$name=$_SESSION['user']; 
$thisround=($year-1)*12+$month;

	 	include("../../connMysql.php");
   		if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
   	 	mysql_query("set names 'utf8'");  //連接資料表abc_login  
		
   		if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
		$temp=mysql_query("SELECT MAX(`year`) FROM `state`");  //抓取最新年份
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0];
		$thisround=($year-1)*12+$month;
        //資本資訊
	$lia_now = 0;
    $cash = 0;
    $stock = 0;
    $result = mysql_query("SELECT * FROM `fund_raising` WHERE `cid`='$cid' ORDER BY `year`, `month`");
    while ($row = mysql_fetch_array($result)) {
        $compare = ((integer) $row['year'] - 1) * 12 + (integer) $row['month'];
        if ($compare < $thisround) {
            $lia_now = $lia_now + (integer) $row['long'] - (integer) $row['repay'] + (int) $row['short'] - (int) $row['repay2'];
        }  //總負債
    }
    $result = mysql_query("SELECT `stock` FROM `stock` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
    $row = mysql_fetch_row($result);
	$my_stock = $row[0];
	$result = mysql_query("SELECT `outside_stock` FROM `stock` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
    $row = mysql_fetch_row($result);
	$outside_stock = $row[0];
    $stock = $my_stock + $outside_stock;  //股數
	    $result = mysql_query("SELECT `stock_price` FROM `stock` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
    $row = mysql_fetch_row($result);
    $stock_price = $row[0];
	
    $result = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`=$year And `month`=$month");
    $row = mysql_fetch_row($result);
    $cash = (int) $row[0];  //現金

     //員工數目
    $number_equip = 0;
    $number_finance = 0;
    $number_human = 0;
    $number_research = 0;
    $number_sale = 0;
    $rdpeople = mysql_fetch_array(mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='research' AND (`year`-1)*12+`month`< $thisround"));
    $number_research = $rdpeople[0]-$rdpeople[1];
    $fnpeople = mysql_fetch_array(mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='finance' AND (`year`-1)*12+`month`< $thisround"));
    $number_finance = $fnpeople[0]-$fnpeople[1];
    $salepeople = mysql_fetch_array(mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='sale' AND (`year`-1)*12+`month`< $thisround"));
    $number_sale = $salepeople[0]-$salepeople[1];
    $equippeople = mysql_fetch_array(mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='equip' AND (`year`-1)*12+`month`< $thisround"));
    $number_equip = $equippeople[0]-$equippeople[1];
    $humanpeople = mysql_fetch_array(mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM current_people WHERE cid = '".$cid."' AND department='human' AND (`year`-1)*12+`month`< $thisround"));
    $number_human = $humanpeople[0]-$humanpeople[1];
	
	
    $satisfaction_equip = 0;
    $satisfaction_finance = 0;
    $satisfaction_human = 0;
    $satisfaction_research = 0;
    $satisfaction_sale = 0;
    $people = mysql_query("SELECT * FROM current_people WHERE `cid`='$cid' AND (`year`-1)*12+`month`=$thisround");
    while ($row = mysql_fetch_array($people)) {
        if ($row['department'] == "equip") {
            $satisfaction_equip = $row['satisfaction'];
        } elseif ($row['department'] == "finance") {
            $satisfaction_finance = $row['satisfaction'];
        } elseif ($row['department'] == "human") {
            $satisfaction_human = $row['satisfaction'];
        } elseif ($row['department'] == "research") {
            $satisfaction_research = $row['satisfaction'];
        } elseif ($row['department'] == "sale") {
            $satisfaction_sale = $row['satisfaction'];
        }
    }
	
	$material = mysql_query("SELECT * FROM state WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");
    $row = mysql_fetch_array($material);
    $ma_suppliera=$row['ma_supplier_a'];
	$ma_supplierb=$row['ma_supplier_b'];
	$ma_supplierc=$row['ma_supplier_c'];
	$mb_suppliera=$row['mb_supplier_a'];
	$mb_supplierb=$row['mb_supplier_b'];
	$mb_supplierc=$row['mb_supplier_c'];
	$mc_suppliera=$row['mc_supplier_a'];
	$mc_supplierb=$row['mc_supplier_b'];
	$mc_supplierc=$row['mc_supplier_c'];
	//原料存貨
	$buymaterial = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM purchase_materials WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");
	//$usematerial = mysql_query("SELECT SUM(`SupA_Monitor`),SUM(`SupB_Monitor`),SUM(`SupC_Monitor`),SUM(`SupA_Kernel`),SUM(`SupB_Kernel`),SUM(`SupC_Kernel`),SUM(`SupA_KeyBoard`),SUM(`SupB_KeyBoard`),SUM(`SupC_KeyBoard`) FROM production WHERE `cid`='$cid' ");//AND `year`='$year' AND `month`='$newmonth'");
    
	$useA_material = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM `product_a` WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$useB_material = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`)
FROM `product_b` WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$row = mysql_fetch_array($buymaterial);
    $rowA = mysql_fetch_array($useA_material);
	$rowB = mysql_fetch_array($useB_material);

    $ma_suppliera=$row[0]-$rowA[0]-$rowB[0];
	$ma_supplierb=$row[1]-$rowA[1]-$rowB[1];
	$ma_supplierc=$row[2]-$rowA[2]-$rowB[2];
	$mb_suppliera=$row[3]-$rowA[3]-$rowB[3];
	$mb_supplierb=$row[4]-$rowA[4]-$rowB[4];
	$mb_supplierc=$row[5]-$rowA[5]-$rowB[5];
	$mc_suppliera=$row[6]-$rowA[6];
	$mc_supplierb=$row[7]-$rowA[7];
	$mc_supplierc=$row[8]-$rowA[8];
    $sum_ma = $ma_suppliera + $ma_supplierb + $ma_supplierc;
    $sum_mb = $mb_suppliera + $mb_supplierb + $mb_supplierc;
    $sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;
	//產品存貨
	$p_a_1 = 0;
    $p_a_2 = 0;
    $p_a_3 = 0;
    $p_a_4 = 0;
    $p_a_5 = 0;
    $p_b_1 = 0;
    $p_b_2 = 0;
    $p_b_3 = 0;
    $p_b_4 = 0;
    $p_b_5 = 0;
    $product = mysql_query("SELECT * FROM `product_quality` WHERE `cid`='$cid'");
    while ($row = mysql_fetch_array($product)) {
        if ($row['product'] == "A") {
            if($row['rank']=="1"){
                $p_a_1+=(int)$row['batch'];
            }elseif($row['rank']=="2"){
                $p_a_2+=(int)$row['batch'];
            }elseif($row['rank']=="3"){
                $p_a_3+=(int)$row['batch'];
            }elseif($row['rank']=="4"){
                $p_a_4+=(int)$row['batch'];
            }elseif($row['rank']=="5"){
                $p_a_5+=(int)$row['batch'];
            }
        } elseif ($row['product'] == "B") {
            if($row['rank']=="1"){
                $p_b_1+=(int)$row['batch'];
            }elseif($row['rank']=="2"){
                $p_b_2+=(int)$row['batch'];
            }elseif($row['rank']=="3"){
                $p_b_3+=(int)$row['batch'];
            }elseif($row['rank']=="4"){
                $p_b_4+=(int)$row['batch'];
            }elseif($row['rank']=="5"){
                $p_b_5+=(int)$row['batch'];
            }
        }
    }
	

	//機具資訊
	$cut_a = 0;
    $cut_b = 0;
    $cut_c = 0;
    $combine1_a = 0;
    $combine1_b = 0;
    $combine1_c = 0;
    $combine2_a = 0;
    $combine2_b = 0;
    $combine2_c = 0;
    $detect_a = 0;
    $detect_b = 0;
	$compare = ((integer) $year - 1) * 12 + (integer) $month;
    $machine = mysql_query("SELECT * FROM machine WHERE `cid`='$cid' AND `sell_month`=99 AND (`buy_year`-1)*12+`buy_month`<$compare");
    while ($row = mysql_fetch_array($machine)) {
        if ($row['function'] == "cut") {
            if ($row['type'] == "A") {
                $cut_a = $cut_a + 1;
            } elseif ($row['type'] == "B") {
                $cut_b = $cut_b + 1;
            } elseif ($row['type'] == "C") {
                $cut_c = $cut_c + 1;
            }
        } elseif ($row['function'] == "combine1") {
            if ($row['type'] == "A") {
                $combine1_a = $combine1_a + 1;
            } elseif ($row['type'] == "B") {
                $combine1_b = $combine1_b + 1;
            } elseif ($row['type'] == "C") {
                $combine1_c = $combine1_c + 1;
            }
        } elseif ($row['function'] == "combine2") {
            if ($row['type'] == "A") {
                $combine2_a = $combine2_a + 1;
            } elseif ($row['type'] == "B") {
                $combine2_b = $combine2_b + 1;
            } elseif ($row['type'] == "C") {
                $combine2_c = $combine2_c + 1;
            }
        } elseif ($row['function'] == "detect") {
            if ($row['type'] == "A") {
                $detect_a = $detect_a + 1;
            } elseif ($row['type'] == "B") {
                $detect_b = $detect_b + 1;
            }
        }
    }
		$sql_allbr=mysql_query("SELECT	SUM(`bankrupt`) FROM `cash` WHERE `cid`='$cid'");
		$bankrupt=mysql_fetch_array($sql_allbr); //總倒閉次數
		$result = mysql_query("SELECT MAX(`year`) FROM `cash` WHERE `cid`='$cid' AND `bankrupt`=1");
		$lastyear = mysql_fetch_array($result);//最後一次倒閉是第幾年
		$result = mysql_query("SELECT MAX(`month`) FROM `cash` WHERE `cid`='$cid' AND `bankrupt`=1 AND `year`='$lastyear[0]'");
		$lastmonth = mysql_fetch_array($result);//最後一次倒閉是第幾月
		if($bankrupt[0]>0){
			$bankrupt_date ="第".$lastyear[0]." 年".$lastmonth[0]." 月 (".$bankrupt[0].")";
		}else
			$br="尚未倒閉";

?>
<body style="background-color:#FFF;">
<div id="container" style="background-color:#FBF4DA;">

<div id="navi">
<ul>
<li class="onCounter">基本資訊</li>
<li class="offCounter">股票價格</li>
<li class="offCounter">員工數目</li>
<li class="offCounter">機具資訊</li>
<li class="offCounter">原料存貨</li>
<li class="offCounter">產品存貨</li>

</ul>
<!-- #navi --></div>

<div id="ticker">
<ul>
<li style="display: list-item;">
<div>
<noscript>本網頁使用 JavaScript 程式。由於 JavaScript 未啟用，因此無法正確顯示內容。</noscript>
<h2>基本資訊</h2>
<table width="86%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td>公司名稱</td>
      <td><?php echo $cid ?></td>
    </tr>
    <tr>
      <td>公司股數</td>
      <td><?php echo $stock ?></td>
    </tr>
    <tr>
      <td>現在時間</td>
      <td>第<?php echo $year ?>年<?php echo $month ?>月</td>
    </tr>
    <tr>
      <td>現金</td>
      <td><?php echo $cash ?></td>
    </tr>
    <tr>
      <td>總負債</td>
      <td><?php echo $lia_now ?></td>
    </tr>
	  <tr>
      <td>倒閉時間</td>
      <td><?php 
	  		if($bankrupt[0]==0) 
				echo $br; 
	  		else{
				echo $bankrupt_date;	
		  	}
		  ?>
      	     
      </td>
    </tr>
  </table>

</div>
</li>
<li style="display: none;">
<div>
<h2>股票價格</h2>
	<table width="86%" border="1" cellspacing="0" cellpadding="0">
	<tr align="center">
	 <tr>
      <td>公司名稱</td>
      <td><?php echo $cid ?></td>
    </tr>
    
    <tr>
      <td>公司股數</td>
      <td><?php echo $stock ?></td>
    </tr>
    
    <tr>
    	<td>公司股價</td>
    	<td><?php echo $stock_price ?></td>
    </tr>
    
    
    </tr>
	</table>
</div>
</li>


<li style="display: none;">
<div>
<h2>員工數目</h2>
<table width="86%" border="1" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td><strong>員工功能別</strong></td>
          <td><strong>人數</strong></td>
          <td><strong>滿意度</strong></td>
        </tr>
    <tr>
      <td>財務人員</td>
          <td align="right"><?php echo $number_finance ?></td>
          <td align="right"><?php echo $satisfaction_finance ?></td>
        </tr>
    <tr>
      <td>資源運籌人員</td>
          <td align="right"><?php echo $number_equip ?></td>
          <td align="right"><?php echo $satisfaction_equip ?></td>
        </tr>
    <tr>
      <td>行銷與業務人員</td>
          <td align="right"><?php echo $number_sale ?></td>
          <td align="right"><?php echo $satisfaction_sale ?></td>
        </tr>
    <tr>
      <td>行政人員</td>
      	  <td align="right"><?php echo $number_human ?></td>
          <td align="right"><?php echo $satisfaction_human ?></td>
        </tr>
    <tr>
      <td>研發人員</td>
     	  <td align="right"><?php echo $number_research ?></td>
          <td align="right"><?php echo $satisfaction_research ?></td>
        </tr>
  </table></div>
</li>
<li style="display: none;">
<div>
<h2>機具資訊</h2>
<table width="86%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr align="center">
        <td><strong>機器功能</strong></td>
        <td><strong>類型</strong></td>
        <td><strong>數量</strong></td>
      </tr>
      <tr align="center">
        <td rowspan="4">原料切割</td>
      </tr>
      <tr align="center">
        <td>機具A</td>
        <td align="right"><?php echo $cut_a ?></td>
      </tr>
      <tr align="center">
        <td>機具B</td>
        <td align="right"><?php echo $cut_b ?></td>
      </tr>
      <tr align="center">
        <td>機具C</td>
        <td align="right"><?php echo $cut_c ?></td>
      </tr>
      <tr align="center">
        <td rowspan="4">第一層組裝</td>
      </tr>
      <tr align="center">
        <td>機具A</td>
        <td align="right"><?php echo $combine1_a ?></td>
      </tr>
      <tr align="center">
        <td>機具B</td>
        <td align="right"><?php echo $combine1_b ?></td>
      </tr>
      <tr align="center">
        <td>機具C</td>
        <td align="right"><?php echo $combine1_c ?></td>
      </tr>
      <tr align="center">
        <td rowspan="4">第二層組裝</td>
      </tr>
      <tr align="center">
        <td>機具A</td>
        <td align="right"><?php echo $combine2_a ?></td>
      </tr>
      <tr align="center">
        <td>機具B</td>
        <td align="right"><?php echo $combine2_b ?></td>
      </tr>
      <tr align="center">
        <td>機具C</td>
        <td align="right"><?php echo $combine2_c ?></td>
      </tr>
      <tr align="center">
        <td rowspan="3">原料&amp;在製品檢驗</td>
      </tr>
      <tr align="center">
        <td>合成檢驗機器</td>
        <td align="right"><?php echo $detect_a ?></td>
      </tr>
      <tr align="center">
        <td>精密檢測機器</td>
		<td align="right"><?php echo $detect_b ?></td>
      </tr>
    </tbody>
  </table>
  </div>
</li>
<li style="display: none;">
<div>
<h2>原料存貨</h2>
 <table width="86%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
      <tr align="center" >
        <td><strong>原料類型</strong></td>
        <td><strong>供應商</strong></td>
        <td><strong>庫存數量</strong></td>
      </tr>
      <tr>
        <td rowspan="4" align="center">螢幕與面板</td>
      </tr>
      <tr>
        <td align="center">供應商A</td>
        <td align="right"><?php echo $ma_suppliera ?></td>
      </tr>
      <tr>
        <td align="center">供應商B</td>
        <td align="right"><?php echo $ma_supplierb ?></td>
      </tr>
      <tr>
        <td align="center">供應商C</td>
        <td align="right"><?php echo $ma_supplierc ?></td>
      </tr>
      <tr>
        <td rowspan="4" align="center">主機板與核心電路</td>
      </tr>
      <tr >
        <td align="center">供應商A</td>
        <td align="right"><?php echo $mb_suppliera ?></td>
      </tr>
      <tr>
        <td align="center">供應商B</td>
        <td align="right"><?php echo $mb_supplierb ?></td>
      </tr>
      <tr>
        <td align="center">供應商C</td>
        <td align="right"><?php echo $mb_supplierc ?></td>
      </tr>
      <tr>
        <td rowspan="4" align="center">鍵盤</td>
      </tr>
      <tr>
        <td align="center">供應商A</td>
        <td align="right"><?php echo $mc_suppliera ?></td>
      </tr>
      <tr>
        <td align="center">供應商B</td>
        <td align="right"><?php echo $mc_supplierb ?></td>
      </tr>
      <tr>
        <td align="center">供應商C</td>
        <td align="right"><?php echo $mc_supplierc ?></td>
      </tr>
    </tbody>
  </table></div>
</li>
<li style="display: none;">
<div>
<h2>產品存貨</h2>
<table  width="86%" border="1" cellpadding="0" cellspacing="0">
    <tbody>
      <tr align="center">
        <td><strong >產品類型</strong></td>
        <td><strong>數量</strong></td>
        <td><strong>品質等級</strong></td>
      </tr>
      <tr>
        <td align="center" rowspan="5">筆記型電腦</td>
        <td align="right"><?php echo $p_a_1 ?></td>
        <td align="center">1</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_a_2 ?></td>
        <td align="center">2</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_a_3 ?></td>
        <td align="center">3</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_a_4 ?></td>
        <td align="center">4</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_a_5 ?></td>
        <td align="center">5</td>
      </tr>
      <tr>
        <td align="center" rowspan="5">平板電腦</td>
        <td align="right"><?php echo $p_b_1 ?></td>
        <td align="center">1</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_b_2 ?></td>
        <td align="center">2</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_b_3 ?></td>
        <td align="center">3</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_b_4 ?></td>
        <td align="center">4</td>
      </tr>
      <tr>
        <td align="right"><?php echo $p_b_5 ?></td>
        <td align="center">5</td>
      </tr>
    </tbody>
  </table></div>
</li>

</ul>
<!-- #ticker --></div>

<!-- #container --></div>

</body>
</html>
