<?php
	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	$connect2=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM `account`",$connect);
	mysql_select_db("testabc_main",$connect);

	$temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;",$connect);
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0]-1;
    if($month==0){
		if($year==1){
			$month=0;
			$year=1;
		}
		elseif($year!=1){
			$month=12;
			$year-=1;
		}
    }
	$month_for_report=$month+($year-1)*12;
	while($company=mysql_fetch_array($C_name)){//每間公司
		$stock_increase=0;
		$cid=$company['CompanyID'];
		$result = mysql_query("SELECT * FROM `stock` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month", $connect);
		$temp=mysql_fetch_array($result);
		$my_stock = $temp['stock'];
		$outside_stock = $temp['outside_stock'];
		$stock = $outside_stock + $my_stock;//股數
		$stock_increase += $outside_stock;
		
		//現金增資增加的股數
		$for_cal=mysql_query("SELECT `cash_increase` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`",$connect);
		$cal_array=mysql_fetch_array($for_cal);//cal_array = cash_increase
		$result = mysql_query("SELECT `stock_price` FROM `stock` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`", $connect);
		$stock_arr = mysql_fetch_array($result);//stock_arr = stock_price
		$stock_increase+=$cal_array[0]/$stock_arr[0];
				
				
		//庫藏股買回的股數
		$for_cal=mysql_query("SELECT `treasury` FROM `fund_raising` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' ORDER BY `year`, `month`",$connect);
		$cal_array=mysql_fetch_array($for_cal);//cal_array = treasury   庫藏股數	
		$stock_increase-=$cal_array[0];
		
		
		
		$result = mysql_query("SELECT SUM(price) FROM `equity` WHERE `cid` = '$cid' AND `month` = $month_for_report", $connect);
		$temp=mysql_fetch_array($result);
		$equity=$temp[0];
		
		$B=$equity/($stock_increase+$my_stock);//每股帳面價值=權益總額/本月期末股數
		
		
		$result = mysql_query("SELECT * FROM `order_accept` WHERE `cid` = '$cid' AND `year`=$year AND `month` =$month", $connect);
		$income=0;
		while($temp=mysql_fetch_array($result)){//本月銷貨收入計算
			$income+=$temp['price']*$temp['quantity'];
		}
		$S=$income/($stock_increase+$my_stock);//每股銷貨收入= 銷貨收入/本月期末股數
		
		$result = mysql_query("SELECT netin FROM `cash` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month", $connect);
		$temp=mysql_fetch_array($result);//本期
		$net_profit=$temp[0];
		$EPS=$net_profit/($stock_increase+$my_stock);//本期淨利/本月期末股數
		
		$result = mysql_query("SELECT price FROM `long-term_liabilities` WHERE `name`=212 AND `cid` = '$cid' AND `month` = $month_for_report", $connect);
		$temp=mysql_fetch_array($result);
		$D=$temp[0];
		$result = mysql_query("SELECT price FROM `current_liabilities` WHERE `name`=211 AND `cid` = '$cid' AND `month` = $month_for_report", $connect);
		$temp=mysql_fetch_array($result);
		$D+=$temp[0];//付息負債=>長短期借款總額不算利息
		$result = mysql_query("SELECT * FROM `fund_raising` WHERE `cid` = '$cid' AND `year`=$year AND `month` = $month", $connect);
		$temp=mysql_fetch_array($result);
		$Rd=$temp['interest']*12;//負債資金成本
		$E=2000000*10;
		
		$P1=0.2;//設定股價因子
		$P2=0.4;
		$P3=0.2;
		$P4=0.2;
		if($EPS<=0&&$income==0){
			$P1=0;
			$P2=2/3;
			$P3=0;
			$P4=1/3;
		}
		elseif($EPS<=0&&$income>0){
			$P1=0;
			$P2=0.5;
			$P3=0.25;
			$P4=0.25;
		}
		
		$BL=1*(1+((1-0.17)*$D)/$equity);//一堆公式
		$REL=0.02+$BL*(0.12-0.02);
		
		$result=mysql_query("SELECT MAX(`level`) FROM `relationship_decision` WHERE `target`='investor_0' AND `cid` = '$company' AND (`year` < $year OR ( `year` = $year AND `month` < $month ))",$connect);
        $temp=mysql_fetch_array($result);//投資人關係管理影響
		if($temp[0]>0)
			$REL-=$temp[0]*0.005;
        
		$IC=$D+$equity;
		$W=$Rd*(1-0.17)*$D/$IC+$REL*$equity/$IC;
		$stock_price=10*$EPS*$P1+1*$B*$P2+1*$S*$P3+(1/$W)*1.2*$P4;
		
		
		
		$report_month=($year-1)*12+$month+1;
		
		
		 
		//在外股>手持股  進行互換
		if($my_stock < $stock_increase){
			$temp = $my_stock;
			$my_stock = $stock_increase;
			$stock_increase = $temp;
			
			//互換同時set 倒閉=1
			mysql_query("UPDATE `cash` SET `bankrupt` = 1  WHERE `cid`='$cid'  AND `year`='$year' AND `month`='$month'",$connect);
			
		}
		
		if($month+1>12)
			mysql_query("INSERT INTO `stock`  VALUES($year+1,1,'$cid',$stock_price,$my_stock,$stock_increase,$W,$REL,$report_month)",$connect);
		else 
			mysql_query("INSERT INTO `stock`  VALUES($year,$month+1,'$cid',$stock_price,$my_stock,$stock_increase,$W,$REL,$report_month)",$connect);
		
		
				/*echo "<br>".$Rd."*(1-0.17)*".$D."/".$IC."+".$REL."*".$equity."/".$IC;
				echo "<br>10*".$EPS."*".$P1."+2*".$B."*".$P2."+1*".$S."*".$P3."+(1/".$W.")*2.4*".$P4."<br>";
				echo $BL;*/
	}
?>