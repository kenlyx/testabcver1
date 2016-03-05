<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title> 企業價值分析</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/tableyellow.css" type="text/css" />
		<script type="text/javascript" src="../js/jquery.js"></script>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <link rel="stylesheet" href="../css/dupont.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
    </head>
    <body>
    <style>
#content{
	overflow:scroll;	
	}
</style> 
<div class="content-fluid">
    <h1> 企業價值分析</h1>
        
    <div class="col-sm-6 col-sm-offset-3 col-xs-12"> 
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab">單月</a>
                </li>
                <li role="presentation">
                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">累計</a>
                </li>
            </ul>
            <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">
           
<?php
	error_reporting(0);
	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
	mysql_select_db("testabc_main",$connect);

	$temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;",$connect);
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0];/*
        if($month==0){
            $month=12;
            $year-=1;
        }*/
	$month_for_report=$month+($year-1)*12-1;
	$sales_income=array();//總銷貨收入
	
	echo "<table class='table table-bordered table-striped'>";
	echo "<thead><tr align='center' class='warning'><th>公司名稱</th>";
	$i=1;
	while($company=mysql_fetch_array($C_name)){//每間公司名稱
		echo "<th>".$company['CompanyID']."</th>";
		$i++;
	}
	echo "<th>同業平均數據</th></tr></thead>";
	$length=$i-1;
	
	echo "<tbody><tr align='center' class='odd'><td>營業收入</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '41' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$sales_income[$i]=$temp['price'];//銷貨收入A
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '42' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$sales_income[$i]+=$temp['price'];//+銷貨收入B
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]== NULL)
				$sales_income[$i]=0;
			$print[$i]=$sales_income[$i];
			echo "<td>".number_format($print[$i])."</td>";
		}
		echo "<td>".number_format(array_sum($print)/$length)."</td>";
	
	echo "<tr align='center'><td>營收成長率</td>";//如果要加的只有兩欄就各用一個while
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '41' AND `month` = $month_for_report-1 ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$last_sales_income[$i]=$temp['price'];//上個月銷貨收入A
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '42' AND `month` = $month_for_report-1 ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$last_sales_income[$i]+=$temp['price'];//+上個月銷貨收入B
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($last_sales_income[$i]==0||$sales_income[$i]==0){//避免分母為零
				$print[$i]=0;
				echo "<td>-</td>";
			}
			else{
				$print[$i]=($sales_income[$i]-$last_sales_income[$i])/$last_sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
		
	echo "<tr align='center' class='odd'><td>營業利潤率</td>";//多於兩項就一間間來，這樣query次數應該會比較少
		$i=1;
		$result = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year AND `month`=$month ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){  //產品A直接原料+產品B直接原料+產品A直接人工+產品B直接人工+產品A製造費用+產品B製造費用
			$price[$i]=$temp['product_A_material_total']+$temp['product_B_material_total']+$temp['product_A_direct_labor']+$temp['product_B_direct_labor']+$temp['product_A_overhead']+$temp['product_A_overhead'];  
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i])/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>營業成本佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_costs` WHERE `name` = '5111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$costs[$i]=$temp['price']*(-1);//銷貨成本A
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_costs` WHERE `name` = '5112' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$costs[$i]+=$temp['price']*(-1);//+銷貨成本B
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$costs[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>直接原料佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `production_cost` WHERE `year` = $year AND `month` = $month ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$material_total[$i]=$temp['product_A_material_total']+$temp['product_B_material_total'];
			$direct_labor[$i]=$temp['product_A_direct_labor']+$temp['product_B_direct_labor'];
			$overhead[$i]=$temp['product_A_overhead']+$temp['product_B_overhead'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$material_total[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>直接人工佔營收百分比</td>";
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$direct_labor[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>間接費用佔營收百分比</td>";
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$overhead[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>折舊費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '142' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);//減：累計折舊
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>營業費用佔營收百分比</td>";
		$i=1;
		mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
		$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
		mysql_select_db("testabc_main",$connect);
		while($company=mysql_fetch_array($C_name)){//每間公司名稱
			$CN=$company['CompanyID'];
			$result = mysql_query("SELECT SUM(price) FROM `operating_expenses` WHERE `cid` = '$CN' AND `month` = $month_for_report", $connect);
			$temp=mysql_fetch_array($result);
			$OE[$i]=$temp[0]*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$OE[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>管理費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '525' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
		
	echo "<tr align='center' class='odd'><td>銷售費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '515' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>研發費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '524' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>資本周轉率</td>";
		$i=1;
		mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
		$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
		mysql_select_db("testabc_main",$connect);
		while($company=mysql_fetch_array($C_name)){//每間公司名稱
			$CN=$company['CompanyID'];
			$result = mysql_query("SELECT SUM(price) FROM `equity` WHERE `cid` = '$CN' AND `month` = $month_for_report", $connect);
			$temp=mysql_fetch_array($result);
			$price[$i]=$temp[0];//股東權益
			$i++;
		}
		
		for($i=1;$i<=$length;$i++){
			if($price[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$sales_income[$i]/$price[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>營運資金佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '114' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//存貨
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '113' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]+=$temp['price'];//+應收
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]+=$temp['price'];//+現金
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_liabilities` WHERE `name` = '213215' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]-=$temp['price'];//-應付
			$i++;
		}
		for($i=1;$i<=$length;$i++){

			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>現金佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//現金
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>存貨佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '114' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>應收帳款佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '113' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>應付帳款佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_liabilities` WHERE `name` = '213215' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>廠房設備佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '141' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//不動產、廠房及設備總額
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '142' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]-=$temp['price']*(-1);//-減：累計折舊
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($sales_income[$i]==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/$sales_income[$i]*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	echo "</tbody></table>";
?>
        </div> <!-- end tab-1 -->
        
        
        
        
        <div role="tabpanel" class="tab-pane fade" id="profile">
            <p>
<?php
	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
	mysql_select_db("testabc_main",$connect);

	$temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;",$connect);
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0];/*
        if($month==0){
            $month=12;
            $year-=1;
        }*/
	$month_for_report=$month+($year-1)*12-1;
	$sales_income=array();//總銷貨收入
	
	echo "<table cellspacing='3' class='table table-bordered table-striped'>";
	echo "<thead><tr align='center' class='warning'><th>公司名稱</th>";
	$i=1;
	while($company=mysql_fetch_array($C_name)){//每間公司名稱
		echo "<th>".$company['CompanyID']."</th>";
		$c[$i]=$company['CompanyID'];
		$i++;
	}
	echo "<th>同業平均數據</th></tr></thead>";
	$length=$i-1;
	
	echo "<tbody><tr align='center' class='odd'><td>營業收入</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '41' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$sales_income[$i]=$temp['price'];//銷貨收入A
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_revenue` WHERE `name` = '42' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$sales_income[$i]+=$temp['price'];//+銷貨收入B
			$i++;
		}
		for($i=1;$i<=$length;$i++){
		//echo $i.$c[1];
		if($month==1&&$year!=1)
			$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
		elseif($month!=1)	
			$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_array($sql_sale);
			if($sales_income[$i]+$sale['revenue']== 0){
			   $sales_income[$i]=0;}
			$print[$i]=$sales_income[$i]+$sale['revenue'];
			echo "<td>".number_format($print[$i])."</td>";	
				
			mysql_query("UPDATE `dupont` SET `revenue`=$print[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length)."</td>"; //同業平均
	
	echo "<tr align='center'><td>營收成長率</td>";//同期比 ex:今年8月比去年8月 //如果要加的只有兩欄就各用一個while
		$i=1;
		for($i=1;$i<=$length;$i++){
			$sql_now = "SELECT `revenue` FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`='$year' AND `month`='$month'"; //今年銷貨收入
			$sql_lastyear = "SELECT `revenue` FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=$month"; //去年銷貨收入
			$result = mysql_query($sql_now);
			$result1 = mysql_query($sql_lastyear);
			$now = mysql_fetch_row($result);
			$lastyear = mysql_fetch_row($result1);
			if($year==1){
				$print[$i]=0;
				echo "<td>-</td>";
			}
			else
			{
				if($lastyear[$i-1]==0||$now[$i-1]==0){//避免分母為零
				$print[$i]=0;
				echo "<td>-</td>";
				}
				else{
					$print[$i]=($now[$i-1]-$lastyear[$i-1])/$lastyear[$i-1]*100;
					echo "<td>".number_format($print[$i],2)."%</td>";
				}
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
		
	echo "<tr align='center' class='odd'><td>營業利潤率</td>";//多於兩項就一間間來，這樣query次數應該會比較少
		$i=1;
		$result = mysql_query("SELECT * FROM `production_cost` WHERE `year`=$year AND `month`=$month ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){  //產品A直接原料+產品B直接原料+產品A直接人工+產品B直接人工+產品A製造費用+產品B製造費用
			$price[$i]=$temp['product_A_material_total']+$temp['product_B_material_total']+$temp['product_A_direct_labor']+$temp['product_B_direct_labor']+$temp['product_A_overhead']+$temp['product_A_overhead'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
					$sql_profit=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
					$sql_profit=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$profit = mysql_fetch_array($sql_profit);
			if($sales_income[$i]==0){//避免分母為零
				echo "<td>-</td>";
				$print[$i]=$profit['profit'];
			}	
			else{
				$print[$i]=($price[$i])/$sales_income[$i]*100; //$sales_income[$i]*100;-->percent
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$OE_total[$i]=$OE[$i]+$profit['oe'];
			mysql_query("UPDATE `dupont` SET `oe`=$OE_total[$i],`profit`=$print[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
			
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>營業成本佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_costs` WHERE `name` = '5111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$costs[$i]=$temp['price']*(-1);//銷貨成本A
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_costs` WHERE `name` = '5112' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$costs[$i]+=$temp['price']*(-1);//+銷貨成本B
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($costs[$i]+$sale['cost'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$cost_total[$i]=$costs[$i]+$sale['cost'];
			mysql_query("UPDATE `dupont` SET cost=$cost_total[$i] WHERE `cid`='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>直接原料佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `production_cost` WHERE `year` = $year AND `month` = $month ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$material_total[$i]=$temp['product_A_material_total']+$temp['product_B_material_total'];
			$direct_labor[$i]=$temp['product_A_direct_labor']+$temp['product_B_direct_labor'];
			$overhead[$i]=$temp['product_A_overhead']+$temp['product_B_overhead'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($material_total[$i]+$sale['dm'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$material[$i]=$material_total[$i]+$sale['dm'];
			mysql_query("UPDATE `dupont` SET `dm`=$material[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>直接人工佔營收百分比</td>";
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($direct_labor[$i]+$sale['dl'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$dl_total[$i]=$direct_labor[$i]+$sale['dl'];
			mysql_query("UPDATE `dupont` SET dl=$dl_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>間接費用佔營收百分比</td>";
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($overhead[$i]+$sale['overhead'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$overhead_total[$i]=$overhead[$i]+$sale['overhead'];
			mysql_query("UPDATE `dupont` SET overhead=$overhead_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>折舊費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '142' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);//減：累計折舊  (存累積負數→變正數)
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			mysql_query("UPDATE `dupont` SET depreciation=$price[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>營業費用佔營收百分比</td>";
		$i=1;
		mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
		$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
		mysql_select_db("testabc_main",$connect);
		while($company=mysql_fetch_array($C_name)){//每間公司名稱
			$CN=$company['CompanyID'];
			$result = mysql_query("SELECT SUM(price) FROM `operating_expenses` WHERE `cid` = '$CN' AND `month` = $month_for_report", $connect);
			$temp=mysql_fetch_array($result);
			$OE[$i]=$temp[0]*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($OE[$i]+$sale['oe'])/($sales_income[$i]+$sale['revenue'])*100; //這裡怪怪的
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>管理費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '525' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i]+$sale['manage'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$manage_total[$i]=$price[$i]+$sale['manage'];
			mysql_query("UPDATE `dupont` SET manage=$manage_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
		
	echo "<tr align='center' class='odd'><td>銷售費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '515' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i]+$sale['sales'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$sale_total[$i]=$price[$i]+$sale['sales'];
			mysql_query("UPDATE `dupont` SET sales=$sale_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>研發費用佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `operating_expenses` WHERE `name` = '524' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price']*(-1);
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i]+$sale['rd'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			$rd_total[$i]=$price[$i]+$sale['rd'];
			mysql_query("UPDATE `dupont` SET rd=$rd_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>資本周轉率</td>";
		$i=1;
		mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
		$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC",$connect);
		mysql_select_db("testabc_main",$connect);
		
		while($company=mysql_fetch_array($C_name)){//每間公司名稱
			$CN=$company['CompanyID'];
			$result = mysql_query("SELECT SUM(price) FROM `equity` WHERE `cid` = '$CN' AND `month` = $month_for_report", $connect);
			$temp=mysql_fetch_array($result);
			$price[$i]=$temp[0];//權益
			$i++;
		}
		
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_array($sql_sale);
			if($price[$i]==0){//避免分母為零
				echo "<td>-</td>";
				$print[i]=$sale['turnover_rate'];
			}	
			else{
				$print[$i]=($sales_income[$i]+$sale['revenue'])/($price[$i])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			mysql_query("UPDATE `dupont` SET turnover_rate=$print[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>營運資金佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '114' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//存貨
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '113' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]+=$temp['price'];//應收
			$capital_total[$i]=$temp['price'];//for累積用
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]+=$temp['price'];//+現金
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `current_liabilities` WHERE `name` = '213215' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]-=$temp['price'];//-應付
			$capital_total[$i]-=$temp['price'];//for累積用
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i]+$sale['capital'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			mysql_query("UPDATE `dupont` SET capital=$capital_total[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>現金佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '111' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//現金
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>存貨佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '114' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>應收帳款佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_assets` WHERE `name` = '113' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=($price[$i]+$sale['debit_percentage'])/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center'><td>應付帳款佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `current_liabilities` WHERE `name` = '213215' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>";
	
	echo "<tr align='center' class='odd'><td>廠房設備佔營收百分比</td>";
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '141' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]=$temp['price'];//不動產、廠房及設備總額
			$i++;
		}
		$i=1;
		$result = mysql_query("SELECT * FROM `fixed_assets` WHERE `name` = '142' AND `month` = $month_for_report ORDER BY `cid` ASC", $connect);
		while($temp=mysql_fetch_array($result)){
			$price[$i]-=$temp['price']*(-1);//-減：累計折舊
			$i++;
		}
		for($i=1;$i<=$length;$i++){
			if($month==1&&$year!=1)
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=($year-1) AND `month`=12",$connect);
			elseif($month!=1)	
				$sql_sale=mysql_query("SELECT * FROM `dupont` WHERE `cid`='".$c[$i]."' AND `year`=$year AND `month`=($month-1)",$connect);
        	$sale = mysql_fetch_row($sql_sale);
			if($sales_income[$i]+$sale['revenue']==0)//避免分母為零
				echo "<td>-</td>";
			else{
				$print[$i]=$price[$i]/($sales_income[$i]+$sale['revenue'])*100;
				echo "<td>".number_format($print[$i],2)."%</td>";
			}
			//mysql_query("INSERT INTO `dupont` (cid,year,property) VALUES ('".$company['CompanyID']."','$year','$property[i]')",$connect) or die(mysql_error());
			mysql_query("UPDATE `dupont` SET property=$price[$i] WHERE cid='".$c[$i]."' AND year='$year' AND month='$month'",$connect) or die(mysql_error());
		}
		echo "<td>".number_format(array_sum($print)/$length,2)."%</td>"; 
	echo "</tbody></table>";
?>
         </div> <!-- end tab-2 -->
            </div><!-------end tab content-------->
        </div><!-- end tab -->
    </div>   
</div><!-- end content -->
    </body>
</html>