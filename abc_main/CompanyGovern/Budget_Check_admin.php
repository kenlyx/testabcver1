<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABC Decision</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/budget.css" rel="stylesheet">
  </head>
  <body>
  <?php  
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	for($i=1;$i<6;$i++){
		
		//預算值--------------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_rd_A[$i] = $result['rd_A'];
		$b_rd_B[$i] = $result['rd_B'];
		$b_p_mc_A[$i] = $result['p_mc_A'];
		$b_p_mc_B[$i] = $result['p_mc_B'];
		$b_p_mc_C[$i] = $result['p_mc_C'];
		$b_p_m1_A[$i] = $result['p_m1_A'];
		$b_p_m1_B[$i] = $result['p_m1_B'];
		$b_p_m1_C[$i] = $result['p_m1_C'];
		$b_p_m2_A[$i] = $result['p_m2_A'];
		$b_p_m2_B[$i] = $result['p_m2_B'];
		$b_p_m2_C[$i] = $result['p_m2_C'];
		$b_p_mcheck[$i] = $result['p_mcheck']; 
		$b_p_mchecks[$i] = $result['p_mchecks']; 
		$b_fund_raising[$i] = $result['fund_raising'];
		$b_cash_divide[$i] = $result['cash_divide'];
		$b_S_borrow[$i] = $result['S_borrow'];
		$b_L_borrow[$i] = $result['L_borrow'];
		//--------------------------------------------------------------------------------------------------------------
	
	
		//實際研發狀況----------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`product_A_RD`) FROM `state` WHERE `cid`='$cid' AND `year`<='$i'");
		$result = mysql_fetch_array($temp);
		$rd_A[$i] = $result[0];
		
		$temp = mysql_query("SELECT SUM(`product_B_RD`) FROM `state` WHERE `cid`='$cid' AND `year`<='$i'");
		$result = mysql_fetch_array($temp);
		$rd_B[$i] = $result[0];
	
		//--------------------------------------------------------------------------------------------------------------
		
		
		//實際招聘人員數---------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='equip'");
		$result = mysql_fetch_array($temp);
		$equip[$i] = $result[0];
		if($equip[$i] == ""){
			$equip[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='human'");
		$result = mysql_fetch_array($temp);
		$human[$i] = $result[0];
		if($human[$i] == ""){
			$human[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='research'");
		$result = mysql_fetch_array($temp);
		$research[$i] = $result[0]/5;
		if($research[$i] == ""){
			$research[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='sale'");
		$result = mysql_fetch_array($temp);
		$sale[$i] = $result[0];
		if($sale[$i] == ""){
			$sale[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='finance'");
		$result = mysql_fetch_array($temp);
		$finance[$i] = $result[0];
		if($finance[$i] == ""){
			$finance[$i] = 0;
		}
	
	
		//--------------------------------------------------------------------------------------------------------------


		//實際購買機具----------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='cut' AND `type`='A'");
		$result = mysql_fetch_array($temp);
		$p_mc_A[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='cut' AND `type`='B'");
		$result = mysql_fetch_array($temp);
		$p_mc_B[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='cut' AND `type`='C'");
		$result = mysql_fetch_array($temp);
		$p_mc_C[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine1' AND `type`='A'");
		$result = mysql_fetch_array($temp);
		$p_m1_A[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine1' AND `type`='B'");
		$result = mysql_fetch_array($temp);
		$p_m1_B[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine1' AND `type`='C'");
		$result = mysql_fetch_array($temp);
		$p_m1_C[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine2' AND `type`='A'");
		$result = mysql_fetch_array($temp);
		$p_m2_A[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine2' AND `type`='B'");
		$result = mysql_fetch_array($temp);
		$p_m2_B[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='combine2' AND `type`='C'");
		$result = mysql_fetch_array($temp);
		$p_m2_C[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='detect' AND `type`='A'");
		$result = mysql_fetch_array($temp);
		$p_mcheck[$i] = $result[0];
		
		$temp = mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`='$i' AND `function`='detect' AND `type`='B'");
		$result = mysql_fetch_array($temp);
		$p_mchecks[$i] = $result[0];
		
		//--------------------------------------------------------------------------------------------------------------


		//現金增資  現金股利  短期借款  長期借款------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`cash_increase`) FROM `fund_raising` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$fund_raising[$i] = $result[0];
		if($fund_raising[$i] == ""){
			$fund_raising[$i] = 0;
		}
		$temp = mysql_query("SELECT SUM(`dividend_cost`) FROM `fund_raising` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$cash_divide[$i] = -($result[0]);
		if($cash_divide[$i] == ""){
			$cash_divide[$i] = 0;
		}
		$temp = mysql_query("SELECT SUM(`short`) FROM `fund_raising` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$S_borrow[$i] = $result[0];
		if($S_borrow[$i] == ""){
			$S_borrow[$i] = 0;
		}
		$temp = mysql_query("SELECT SUM(`long`) FROM `fund_raising` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$L_borrow[$i] = $result[0];
		if($L_borrow[$i] == ""){
			$L_borrow[$i] = 0;
		}
		
		//--------------------------------------------------------------------------------------------------------------




		//達成率---------------------------------------------------------------------------------------------------------
		if($rd_A[$i] == $b_rd_A[$i]){
			$rd_A_rate[$i] = 100;
		}
		else{
			$rd_A_rate[$i] = 0;
		}
		
		if($rd_B[$i] == $b_rd_B[$i]){
			$rd_B_rate[$i] = 100;
		}
		else{
			$rd_B_rate[$i] = 0;
		}
		
		
		//機具--------------------------------------------------------------------
		if($b_p_mc_A[$i] != 0){
			$p_mc_A_rate[$i] = ($p_mc_A[$i]*100) / $b_p_mc_A[$i];
		}
		else{
			$p_mc_A_rate[$i] = 0;
		}
		if($b_p_mc_B[$i] != 0){
			$p_mc_B_rate[$i] = ($p_mc_B[$i]*100) / $b_p_mc_B[$i];
		}
		else{
			$p_mc_B_rate[$i] = 0;
		}
		if($b_p_mc_C[$i] != 0){
			$p_mc_C_rate[$i] = ($p_mc_C[$i]*100) / $b_p_mc_C[$i];
		}
		else{
			$p_mc_C_rate[$i] = 0;
		}
		
		
		if($b_p_m1_A[$i] != 0){
			$p_m1_A_rate[$i] = ($p_m1_A[$i]*100) / $b_p_m1_A[$i];
		}
		else{
			$p_m1_A_rate[$i] = 0;
		}
		if($b_p_m1_B[$i] != 0){
			$p_m1_B_rate[$i] = ($p_m1_B[$i]*100) / $b_p_m1_B[$i];
		}
		else{
			$p_m1_B_rate[$i] = 0;
		}
		if($b_p_m1_C[$i] != 0){
			$p_m1_C_rate[$i] = ($p_m1_C[$i]*100) / $b_p_m1_C[$i];
		}
		else{
			$p_m1_C_rate[$i] = 0;
		}
		
		
		if($b_p_m2_A[$i] != 0){
			$p_m2_A_rate[$i] = ($p_m2_A[$i]*100) / $b_p_m2_A[$i];
		}
		else{
			$p_m2_A_rate[$i] = 0;
		}
		if($b_p_m2_B[$i] != 0){
			$p_m2_B_rate[$i] = ($p_m2_B[$i]*100) / $b_p_m2_B[$i];
		}
		else{
			$p_m2_B_rate[$i] = 0;
		}
		if($b_p_m2_C[$i] != 0){
			$p_m2_C_rate[$i] = ($p_m2_C[$i]*100) / $b_p_m2_C[$i];
		}
		else{
			$p_m2_C_rate[$i] = 0;
		}
		
		
		
		if($b_p_mcheck[$i] != 0){
			$p_mcheck_rate[$i] = ($p_mcheck[$i]*100) / $b_p_mcheck[$i];
		}
		else{
			$p_mcheck_rate[$i] = 0;
		}
		if($b_p_mchecks[$i] != 0){
			$p_mchecks_rate[$i] = ($p_mchecks[$i]*100) / $b_p_mchecks[$i];
		}
		else{
			$p_mchecks_rate[$i] = 0;
		}
		
		//資金募集-------------------------------------------------------------------------------------------------------
		
		if($b_fund_raising[$i] != 0){
			$fund_raising_rate[$i] = ($fund_raising[$i]*100) / $b_fund_raising[$i];
		}
		else{
			$fund_raising_rate[$i] = 0;
		}
		if($b_cash_divide[$i] != 0){
			$cash_divide_rate[$i] = ($cash_divide[$i]*100) / $b_cash_divide[$i];
		}
		else{
			$cash_divide_rate[$i] = 0;
		}
		if($b_S_borrow[$i] != 0){
			$S_borrow_rate[$i] = ($S_borrow[$i]*100) / $b_S_borrow[$i];
		}
		else{
			$S_borrow_rate[$i] = 0;
		}
		if($b_L_borrow[$i] != 0){
			$L_borrow_rate[$i] = ($L_borrow[$i]*100) / $b_L_borrow[$i];
		}
		else{
			$L_borrow_rate[$i] = 0;
		}
		
		//--------------------------------------------------------------------------------------------------------------
		
	}
	
	
	
	
	
	//當年-----------------------------------------------------------------------------------------------------------
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
?>
<div class="container-fluid">
<h1>預算成效檢視<small style="color:#ff0000;">* 檢視每年預算達成率 *</small></h1>
<!--------------按鈕區------------------------------------->   
    <div class="text-center">
        <a class="btn btn1 btn-danger" id="finance" href="Budget_Check_finance.php" role="button">銷</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-primary" id="produce" href="Budget_Check_produce.php" role="button">產</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-info" id="purchase" href="Budget_Check_purchase.php" role="button">購</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-success" id="human"  href="Budget_Check_human.php" role="button">人</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-warning" id="admin"  href="Budget_Check_admin.php" role="button">行</a>
    </div>    
<!-----------------------------------內容區域---------------------------->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" style="margin:20px 0;">

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
     <table class="table table-bordered table-striped text-center">
        <tr class="warning">
            <th></th>
            <th class="text-center">當年</th>
            <th class="text-center">第一年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td>研發筆電</td>
            <td>0<?php
	if($result['rd_A']==1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php
    if($rd_A[1] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_A_rate[1]; ?>%</td>
        </tr>
        <tr>
            <td>研發平板</td>
            <td><?php 
	if($result['rd_B']==1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php
    if($rd_B[1] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_B_rate[1]; ?>%</td>
        </tr>
        <tr>
            <td>切割機具A</td>
            <td><?php echo $result['p_mc_A']; ?></td>
            <td><?php echo $p_mc_A[1]; ?></td>
            <td><?php echo number_format($p_mc_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>切割機具B</td>
            <td><?php echo $result['p_mc_B']; ?></td>
            <td><?php echo $p_mc_B[1]; ?></td>
            <td><?php echo number_format($p_mc_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>切割機具C</td>
            <td><?php echo $result['p_mc_C']; ?></td>
            <td><?php echo $p_mc_C[1]; ?></td>
            <td><?php echo number_format($p_mc_C_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第一層組裝機具A</td>
            <td><?php echo $result['p_m1_A']; ?></td>
            <td><?php echo $p_m1_A[1]; ?></td>
            <td><?php echo number_format($p_m1_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第一層組裝機具B</td>
            <td><?php echo $result['p_m1_B']; ?></td>
            <td><?php echo $p_m1_B[1]; ?></td>
            <td><?php echo number_format($p_m1_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第一層組裝機具C</td>
            <td><?php echo $result['p_m1_C']; ?></td>
            <td><?php echo $p_m1_C[1]; ?></td>
            <td><?php echo number_format($p_m1_C_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第二層組裝機具A</td>
            <td><?php echo $result['p_m2_A']; ?></td>
            <td><?php echo $p_m2_A[1]; ?></td>
            <td><?php echo number_format($p_m2_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第二層組裝機具B</td>
            <td><?php echo $result['p_m2_B']; ?></td>
            <td><?php echo $p_m2_B[1]; ?></td>
            <td><?php echo number_format($p_m2_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>第二層組裝機具C</td>
            <td><?php echo $result['p_m2_C']; ?></td>
            <td><?php echo $p_m2_C[1]; ?></td>
            <td><?php echo number_format($p_m2_C_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>合格檢測機具</td>
            <td><?php echo $result['p_mcheck']; ?></td>
            <td><?php echo $p_mcheck[1]; ?></td>
            <td><?php echo number_format($p_mcheck_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>精密檢測機具</td>
            <td><?php echo $result['p_mchecks']; ?></td>
            <td><?php echo $p_mchecks[1]; ?></td>
            <td><?php echo number_format($p_mchecks_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>資金募集</td>
            <td><?php echo $result['fund_raising']; ?></td>
            <td><?php echo number_format($fund_raising[1]); ?></td>
            <td><?php echo number_format($fund_raising_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>發放現金股利</td>
            <td><?php echo $result['cash_divide']; ?></td>
            <td><?php echo number_format($cash_divide[1]); ?></td>
            <td><?php echo number_format($cash_divide_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>短期借款</td>
            <td><?php echo $result['S_borrow']; ?></td>
            <td><?php echo number_format($S_borrow[1]); ?></td>
            <td><?php echo number_format($S_borrow_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>長期借款</td>
            <td><?php echo $result['L_borrow']; ?></td>
            <td><?php echo number_format($L_borrow[1]); ?></td>
            <td><?php echo number_format($L_borrow_rate[1],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="warning">
            <th class="text-center">第二年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第三年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php
    if($rd_A[2] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_A_rate[2]; ?>%</td>
            <td><?php
    if($rd_A[3] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_A_rate[3]; ?>%</td>
        </tr>
        <tr>
            <td><?php
    if($rd_B[2] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_B_rate[2]; ?>%</td>
            <td><?php
    if($rd_B[3] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_B_rate[3]; ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_A[2]; ?></td>
            <td><?php echo number_format($p_mc_A_rate[2],2); ?>%</td>
            <td><?php echo $p_mc_A[3]; ?></td>
            <td><?php echo number_format($p_mc_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_B[2]; ?></td>
            <td><?php echo number_format($p_mc_B_rate[2],2); ?>%</td>
            <td><?php echo $p_mc_B[3]; ?></td>
            <td><?php echo number_format($p_mc_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_C[2]; ?></td>
            <td><?php echo number_format($p_mc_C_rate[2],2); ?>%</td>
            <td><?php echo $p_mc_C[3]; ?></td>
            <td><?php echo number_format($p_mc_C_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_A[2]; ?></td>
            <td><?php echo number_format($p_m1_A_rate[2],2); ?>%</td>
            <td><?php echo $p_m1_A[3]; ?></td>
            <td><?php echo number_format($p_m1_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_B[2]; ?></td>
            <td><?php echo number_format($p_m1_B_rate[2],2); ?>%</td>
            <td><?php echo $p_m1_B[3]; ?></td>
            <td><?php echo number_format($p_m1_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_C[2]; ?></td>
            <td><?php echo number_format($p_m1_C_rate[2],2); ?>%</td>
            <td><?php echo $p_m1_C[3]; ?></td>
            <td><?php echo number_format($p_m1_C_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_A[2]; ?></td>
            <td><?php echo number_format($p_m2_A_rate[2],2); ?>%</td>
            <td><?php echo $p_m2_A[3]; ?></td>
            <td><?php echo number_format($p_m2_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_B[2]; ?></td>
            <td><?php echo number_format($p_m2_B_rate[2],2); ?>%</td>
            <td><?php echo $p_m2_B[3]; ?></td>
            <td><?php echo number_format($p_m2_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_C[2]; ?></td>
            <td><?php echo number_format($p_m2_C_rate[2],2); ?>%</td>
            <td><?php echo $p_m2_C[3]; ?></td>
            <td><?php echo number_format($p_m2_C_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mcheck[2]; ?></td>
            <td><?php echo number_format($p_mcheck_rate[2],2); ?>%</td>
            <td><?php echo $p_mcheck[3]; ?></td>
            <td><?php echo number_format($p_mcheck_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mchecks[2]; ?></td>
            <td><?php echo number_format($p_mchecks_rate[2],2); ?>%</td>
            <td><?php echo $p_mchecks[3]; ?></td>
            <td><?php echo number_format($p_mchecks_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($fund_raising[2]); ?></td>
            <td><?php echo number_format($fund_raising_rate[2],2); ?>%</td>
            <td><?php echo number_format($fund_raising[3]); ?></td>
            <td><?php echo number_format($fund_raising_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($cash_divide[2]); ?></td>
            <td><?php echo number_format($cash_divide_rate[2],2); ?>%</td>
            <td><?php echo number_format($cash_divide[3]); ?></td>
            <td><?php echo number_format($cash_divide_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($S_borrow[2]); ?></td>
            <td><?php echo number_format($S_borrow_rate[2],2); ?>%</td>
            <td><?php echo number_format($S_borrow[3]); ?></td>
            <td><?php echo number_format($S_borrow_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($L_borrow[2]); ?></td>
            <td><?php echo number_format($L_borrow_rate[2],2); ?>%</td>
            <td><?php echo number_format($L_borrow[3]); ?></td>
            <td><?php echo number_format($L_borrow_rate[3],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
    
      
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="warning">
            <th class="text-center">第四年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第五年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php
    if($rd_A[4] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_A_rate[4]; ?>%</td>
            <td><?php
    if($rd_A[5] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_A_rate[5]; ?>%</td>
        </tr>
        <tr>
            <td><?php
    if($rd_B[4] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_B_rate[4]; ?>%</td>
            <td><?php
    if($rd_B[5] == 1){
		echo "已研發";
	}
	else{
		echo "未研發";
	}
	?></td>
            <td><?php echo $rd_B_rate[5]; ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_A[4]; ?></td>
            <td><?php echo number_format($p_mc_A_rate[4],2); ?>%</td>
            <td><?php echo $p_mc_A[5]; ?></td>
            <td><?php echo number_format($p_mc_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_B[4]; ?></td>
            <td><?php echo number_format($p_mc_B_rate[4],2); ?>%</td>
            <td><?php echo $p_mc_B[5]; ?></td>
            <td><?php echo number_format($p_mc_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mc_C[4]; ?></td>
            <td><?php echo number_format($p_mc_C_rate[4],2); ?>%</td>
            <td><?php echo $p_mc_C[5]; ?></td>
            <td><?php echo number_format($p_mc_C_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_A[4]; ?></td>
            <td><?php echo number_format($p_m1_A_rate[4],2); ?>%</td>
            <td><?php echo $p_m1_A[5]; ?></td>
            <td><?php echo number_format($p_m1_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_B[4]; ?></td>
            <td><?php echo number_format($p_m1_B_rate[4],2); ?>%</td>
            <td><?php echo $p_m1_B[5]; ?></td>
            <td><?php echo number_format($p_m1_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m1_C[4]; ?></td>
            <td><?php echo number_format($p_m1_C_rate[4],2); ?>%</td>
            <td><?php echo $p_m1_C[5]; ?></td>
            <td><?php echo number_format($p_m1_C_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_A[4]; ?></td>
            <td><?php echo number_format($p_m2_A_rate[4],2); ?>%</td>
            <td><?php echo $p_m2_A[5]; ?></td>
            <td><?php echo number_format($p_m2_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_B[4]; ?></td>
            <td><?php echo number_format($p_m2_B_rate[4],2); ?>%</td>
            <td><?php echo $p_m2_B[5]; ?></td>
            <td><?php echo number_format($p_m2_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_m2_C[4]; ?></td>
            <td><?php echo number_format($p_m2_C_rate[4],2); ?>%</td>
            <td><?php echo $p_m2_C[5]; ?></td>
            <td><?php echo number_format($p_m2_C_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mcheck[4]; ?></td>
            <td><?php echo number_format($p_mcheck_rate[4],2); ?>%</td>
            <td><?php echo $p_mcheck[5]; ?></td>
            <td><?php echo number_format($p_mcheck_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $p_mchecks[4]; ?></td>
            <td><?php echo number_format($p_mchecks_rate[4],2); ?>%</td>
            <td><?php echo $p_mchecks[5]; ?></td>
            <td><?php echo number_format($p_mchecks_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($fund_raising[4]); ?></td>
            <td><?php echo number_format($fund_raising_rate[4],2); ?>%</td>
            <td><?php echo number_format($fund_raising[5]); ?></td>
            <td><?php echo number_format($fund_raising_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($cash_divide[4]); ?></td>
            <td><?php echo number_format($cash_divide_rate[4],2); ?>%</td>
            <td><?php echo number_format($cash_divide[5]); ?></td>
            <td><?php echo number_format($cash_divide_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($S_borrow[4]); ?></td>
            <td><?php echo number_format($S_borrow_rate[4],2); ?>%</td>
            <td><?php echo number_format($S_borrow[5]); ?></td>
            <td><?php echo number_format($S_borrow_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($L_borrow[4]); ?></td>
            <td><?php echo number_format($L_borrow_rate[4],2); ?>%</td>
            <td><?php echo number_format($L_borrow[5]); ?></td>
            <td><?php echo number_format($L_borrow_rate[5],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
      
      
      
      
      
      
      
      
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    
    
    
    

    
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.js"></script>
  </body>
</html>