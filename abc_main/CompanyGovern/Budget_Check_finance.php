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
	
	for($i=1;$i<=5;$i++){
		
	//預算--------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_sell_A[$i] = $result['sell_A'];
		$b_sell_B[$i] = $result['sell_B'];
		$b_internet_A[$i] = $result['internet_A'];
		$b_internet_B[$i] = $result['internet_B'];
		$b_TV_A[$i] = $result['TV_A'];
		$b_TV_B[$i] = $result['TV_B'];
		$b_magazine_A[$i] = $result['magazine_A'];
		$b_magazine_B[$i] = $result['magazine_B'];
		$b_func1_A[$i] = $result['func1_A'];
		$b_func2_A[$i] = $result['func2_A'];
		$b_func3_A[$i] = $result['func3_A'];
		$b_func1_B[$i] = $result['func1_B'];
		$b_func2_B[$i] = $result['func2_B'];
		$b_func3_B[$i] = $result['func3_B'];
	//-----------------------------------------------------------------------------------------------------
	
	
	//實際--------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`quantity`) FROM `order_accept` WHERE SUBSTRING_INDEX(`order_no`,'_',-1)='A' AND `cid`='$cid' AND `year`='$i' AND `accept`='1'");
		$result = mysql_fetch_array($temp);
		$sell_A[$i] = $result[0];
		if($sell_A[$i] == ""){
			$sell_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`quantity`) FROM `order_accept` WHERE SUBSTRING_INDEX(`order_no`,'_',-1)='B' AND `cid`='$cid' AND `year`='$i' AND `accept`='1'");
		$result = mysql_fetch_array($temp);
		$sell_B[$i] = $result[0];
		if($sell_B[$i] == ""){
			$sell_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision1`) FROM `ad_a` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$internet_A[$i] = $result[0];
		if($internet_A[$i] == ""){
			$internet_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision2`) FROM `ad_a` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$TV_A[$i] = $result[0];
		if($TV_A[$i] == ""){
			$TV_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision3`) FROM `ad_a` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$magazine_A[$i] = $result[0];
		if($magazine_A[$i] == ""){
			$magazine_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision1`) FROM `ad_b` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$internet_B[$i] = $result[0];
		if($internet_B[$i] == ""){
			$internet_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision2`) FROM `ad_b` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$TV_B[$i] = $result[0];
		if($TV_B[$i] == ""){
			$TV_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision3`) FROM `ad_b` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$magazine_B[$i] = $result[0];
		if($magazine_B[$i] == ""){
			$magazine_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision1`) FROM `donate` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func1_A[$i] = $result[0];
		if($func1_A[$i] == ""){
			$func1_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision2`) FROM `donate` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func2_A[$i] = $result[0];
		if($func2_A[$i] == ""){
			$func2_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision3`) FROM `donate` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func3_A[$i] = $result[0];
		if($func3_A[$i] == ""){
			$func3_A[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision1`) FROM `share` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func1_B[$i] = $result[0];
		if($func1_B[$i] == ""){
			$func1_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision2`) FROM `share` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func2_B[$i] = $result[0];
		if($func2_B[$i] == ""){
			$func2_B[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`decision3`) FROM `share` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$func3_B[$i] = $result[0];
		if($func3_B[$i] == ""){
			$func3_B[$i] = 0;
		}
		
		
		
	//-----------------------------------------------------------------------------------------------------
	
	//達成率------------------------------------------------------------------------------------------------
		if($b_sell_A[$i] != 0){
			$sell_A_rate[$i] = ($sell_A[$i]*100) / $b_sell_A[$i];
		}
		else{
			$sell_A_rate[$i] = 0;
		}
		
		if($b_sell_B[$i] != 0){
			$sell_B_rate[$i] = ($sell_B[$i]*100) / $b_sell_B[$i];
		}
		else{
			$sell_B_rate[$i] = 0;
		}
		
		if($b_internet_A[$i] != 0){
			$internet_A_rate[$i] = ($internet_A[$i]*100) / $b_internet_A[$i];
		}
		else{
			$internet_A_rate[$i] = 0;
		}
		
		if($b_TV_A[$i] != 0){
			$TV_A_rate[$i] = ($TV_A[$i]*100) / $b_TV_A[$i];
		}
		else{
			$TV_A_rate[$i] = 0;
		}
		
		if($b_magazine_A[$i] != 0){
			$magazine_A_rate[$i] = ($magazine_A[$i]*100) / $b_magazine_A[$i];
		}
		else{
			$magazine_A_rate[$i] = 0;
		}
		
		if($b_internet_B[$i] != 0){
			$internet_B_rate[$i] = ($internet_B[$i]*100) / $b_internet_B[$i];
		}
		else{
			$internet_B_rate[$i] = 0;
		}
		
		if($b_TV_B[$i] != 0){
			$TV_B_rate[$i] = ($TV_B[$i]*100) / $b_TV_B[$i];
		}
		else{
			$TV_B_rate[$i] = 0;
		}
		
		if($b_magazine_B[$i] != 0){
			$magazine_B_rate[$i] = ($magazine_B[$i]*100) / $b_magazine_B[$i];
		}
		else{
			$magazine_B_rate[$i] = 0;
		}

		if($b_func1_A[$i] != 0){
			$func1_A_rate[$i] = ($func1_A[$i]*100) / $b_func1_A[$i];
		}
		else{
			$func1_A_rate[$i] = 0;
		}
		
		if($b_func2_A[$i] != 0){
			$func2_A_rate[$i] = ($func2_A[$i]*100) / $b_func2_A[$i];
		}
		else{
			$func2_A_rate[$i] = 0;
		}
		
		if($b_func3_A[$i] != 0){
			$func3_A_rate[$i] = ($func3_A[$i]*100) / $b_func3_A[$i];
		}
		else{
			$func3_A_rate[$i] = 0;
		}
		
		if($b_func1_B[$i] != 0){
			$func1_B_rate[$i] = ($func1_B[$i]*100) / $b_func1_B[$i];
		}
		else{
			$func1_B_rate[$i] = 0;
		}
		
		if($b_func2_B[$i] != 0){
			$func2_B_rate[$i] = ($func2_B[$i]*100) / $b_func2_B[$i];
		}
		else{
			$func2_B_rate[$i] = 0;
		}
		
		if($b_func3_B[$i] != 0){
			$func3_B_rate[$i] = ($func3_B[$i]*100) / $b_func3_B[$i];
		}
		else{
			$func3_B_rate[$i] = 0;
		}
		
	//-----------------------------------------------------------------------------------------------------
	
	}
	//當年--------------------------------------------------------------------------------------------------
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
        <tr class="danger">
            <th></th>
            <th class="text-center">當年</th>
            <th class="text-center">第一年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td>產品A銷售量</td>
            <td><?php echo $result['sell_A']; ?></td>
            <td><?php echo $sell_A[1]; ?></td>
            <td><?php echo number_format($sell_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>產品B銷售量</td>
            <td><?php echo $result['sell_B']; ?></td>
            <td><?php echo $sell_B[1]; ?></td>
            <td><?php echo number_format($sell_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>網路A</td>
            <td><?php echo $result['internet_A']; ?></td>
            <td><?php echo $internet_A[1]; ?></td>
            <td><?php echo number_format($internet_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>網路B</td>
            <td><?php echo $result['internet_B']; ?></td>
            <td><?php echo $internet_B[1]; ?></td>
            <td><?php echo number_format($internet_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>電視A</td>
            <td><?php echo $result['TV_A']; ?></td>
            <td><?php echo $TV_A[1]; ?></td>
            <td><?php echo number_format($TV_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>電視B</td>
            <td><?php echo $result['TV_B']; ?></td>
            <td><?php echo $TV_B[1]; ?></td>
            <td><?php echo number_format($TV_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>雜誌A</td>
            <td><?php echo $result['magazine_A']; ?></td>
            <td><?php echo $magazine_A[1]; ?></td>
            <td><?php echo number_format($magazine_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>雜誌B</td>
            <td><?php echo $result['magazine_B']; ?></td>
            <td><?php echo $magazine_B[1]; ?></td>
            <td><?php echo number_format($magazine_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>半導體晶圓A</td>
            <td><?php echo $result['func1_A']; ?></td>
            <td><?php echo $func1_A[1]; ?></td>
            <td><?php echo number_format($func1_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>多核心處理器A</td>
            <td><?php echo $result['func2_A']; ?></td>
            <td><?php echo $func2_A[1]; ?></td>
            <td><?php echo number_format($func2_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>顯示器A</td>
            <td><?php echo $result['func3_A']; ?></td>
            <td><?php echo $func3_A[1]; ?></td>
            <td><?php echo number_format($func3_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>觸控螢幕B</td>
            <td><?php echo $result['func1_B']; ?></td>
            <td><?php echo $func1_B[1]; ?></td>
            <td><?php echo number_format($func1_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>記憶體B</td>
            <td><?php echo $result['func2_B']; ?></td>
            <td><?php echo $func2_B[1]; ?></td>
            <td><?php echo number_format($func2_B_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>多核心處理器B</td>
            <td><?php echo $result['func3_B']; ?></td>
            <td><?php echo $func3_B[1]; ?></td>
            <td><?php echo number_format($func3_B_rate[1],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="danger">
            <th class="text-center">第二年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第三年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo $sell_A[2]; ?></td>
            <td><?php echo number_format($sell_A_rate[2],2); ?>%</td>
            <td><?php echo $sell_A[3]; ?></td>
            <td><?php echo number_format($sell_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $sell_B[2]; ?></td>
            <td><?php echo number_format($sell_B_rate[2],2); ?>%</td>
            <td><?php echo $sell_B[3]; ?></td>
            <td><?php echo number_format($sell_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $internet_A[2]; ?></td>
            <td><?php echo number_format($internet_A_rate[2],2); ?>%</td>
            <td><?php echo $internet_A[3]; ?></td>
            <td><?php echo number_format($internet_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $internet_B[2]; ?></td>
            <td><?php echo number_format($internet_B_rate[2],2); ?>%</td>
            <td><?php echo $internet_B[3]; ?></td>
            <td><?php echo number_format($internet_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $TV_A[2]; ?></td>
            <td><?php echo number_format($TV_A_rate[2],2); ?>%</td>
            <td><?php echo $TV_A[3]; ?></td>
            <td><?php echo number_format($TV_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $TV_B[2]; ?></td>
            <td><?php echo number_format($TV_B_rate[2],2); ?>%</td>
            <td><?php echo $TV_B[3]; ?></td>
            <td><?php echo number_format($TV_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $magazine_A[2]; ?></td>
            <td><?php echo number_format($magazine_A_rate[2],2); ?>%</td>
            <td><?php echo $magazine_A[3]; ?></td>
            <td><?php echo number_format($magazine_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $magazine_B[2]; ?></td>
            <td><?php echo number_format($magazine_B_rate[2],2); ?>%</td>
            <td><?php echo $magazine_B[3]; ?></td>
            <td><?php echo number_format($magazine_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func1_A[2]; ?></td>
            <td><?php echo number_format($func1_A_rate[2],2); ?>%</td>
            <td><?php echo $func1_A[3]; ?></td>
            <td><?php echo number_format($func1_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func2_A[2]; ?></td>
            <td><?php echo number_format($func2_A_rate[2],2); ?>%</td>
            <td><?php echo $func2_A[3]; ?></td>
            <td><?php echo number_format($func2_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func3_A[2]; ?></td>
            <td><?php echo number_format($func3_A_rate[2],2); ?>%</td>
            <td><?php echo $func3_A[3]; ?></td>
            <td><?php echo number_format($func3_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func1_B[2]; ?></td>
            <td><?php echo number_format($func1_B_rate[2],2); ?>%</td>
            <td><?php echo $func1_B[3]; ?></td>
            <td><?php echo number_format($func1_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func2_B[2]; ?></td>
            <td><?php echo number_format($func2_B_rate[2],2); ?>%</td>
            <td><?php echo $func2_B[3]; ?></td>
            <td><?php echo number_format($func2_B_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func3_B[2]; ?></td>
            <td><?php echo number_format($func3_B_rate[2],2); ?>%</td>
            <td><?php echo $func3_B[3]; ?></td>
            <td><?php echo number_format($func3_B_rate[3],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
    
      
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="danger">
            <th class="text-center">第四年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第五年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo $sell_A[4]; ?></td>
            <td><?php echo number_format($sell_A_rate[4],2); ?>%</td>
            <td><?php echo $sell_A[5]; ?></td>
            <td><?php echo number_format($sell_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $sell_B[4]; ?></td>
            <td><?php echo number_format($sell_B_rate[4],2); ?>%</td>
            <td><?php echo $sell_B[5]; ?></td>
            <td><?php echo number_format($sell_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $internet_A[4]; ?></td>
            <td><?php echo number_format($internet_A_rate[4],2); ?>%</td>
            <td><?php echo $internet_A[5]; ?></td>
            <td><?php echo number_format($internet_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $internet_B[4]; ?></td>
            <td><?php echo number_format($internet_B_rate[4],2); ?>%</td>
            <td><?php echo $internet_B[5]; ?></td>
            <td><?php echo number_format($internet_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $TV_A[4]; ?></td>
            <td><?php echo number_format($TV_A_rate[4],2); ?>%</td>
            <td><?php echo $TV_A[5]; ?></td>
            <td><?php echo number_format($TV_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $TV_B[4]; ?></td>
            <td><?php echo number_format($TV_B_rate[4],2); ?>%</td>
            <td><?php echo $TV_B[5]; ?></td>
            <td><?php echo number_format($TV_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $magazine_A[4]; ?></td>
            <td><?php echo number_format($magazine_A_rate[4],2); ?>%</td>
            <td><?php echo $magazine_A[5]; ?></td>
            <td><?php echo number_format($magazine_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $magazine_B[4]; ?></td>
            <td><?php echo number_format($magazine_B_rate[4],2); ?>%</td>
            <td><?php echo $magazine_B[5]; ?></td>
            <td><?php echo number_format($magazine_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func1_A[4]; ?></td>
            <td><?php echo number_format($func1_A_rate[4],2); ?>%</td>
            <td><?php echo $func1_A[5]; ?></td>
            <td><?php echo number_format($func1_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func2_A[4]; ?></td>
            <td><?php echo number_format($func2_A_rate[4],2); ?>%</td>
            <td><?php echo $func2_A[5]; ?></td>
            <td><?php echo number_format($func2_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func3_A[4]; ?></td>
            <td><?php echo number_format($func3_A_rate[4],2); ?>%</td>
            <td><?php echo $func3_A[5]; ?></td>
            <td><?php echo number_format($func3_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func1_B[4]; ?></td>
            <td><?php echo number_format($func1_B_rate[4],2); ?>%</td>
            <td><?php echo $func1_B[5]; ?></td>
            <td><?php echo number_format($func1_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func2_B[4]; ?></td>
            <td><?php echo number_format($func2_B_rate[4],2); ?>%</td>
            <td><?php echo $func2_B[5]; ?></td>
            <td><?php echo number_format($func2_B_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $func3_B[4]; ?></td>
            <td><?php echo number_format($func3_B_rate[4],2); ?>%</td>
            <td><?php echo $func3_B[5]; ?></td>
            <td><?php echo number_format($func3_B_rate[5],2); ?>%</td>
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