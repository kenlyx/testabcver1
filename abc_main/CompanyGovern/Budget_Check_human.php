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
  <?php  
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	
	for($i=1;$i<6;$i++){
		
		//預算招聘人員數---------------------------------------------------------------------------------------------------
		
		$temp = mysql_query("SELECT SUM(`equip`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_equip[$i] = $result[0];
		if($b_equip[$i] == ""){
			$b_equip[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`human`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_human[$i] = $result[0];
		if($b_human[$i] == ""){
			$b_human[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`research`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_research[$i] = $result[0];
		if($b_research[$i] == ""){
			$b_research[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`sale`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_sale[$i] = $result[0];
		if($b_sale[$i] == ""){
			$b_sale[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`finance`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_finance[$i] = $result[0];
		if($b_finance[$i] == ""){
			$b_finance[$i] = 0;
		}
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
	
	
		//達成率---------------------------------------------------------------------------------------------------------
		if($b_equip[$i] != 0){
			$equip_rate[$i] = ($equip[$i] * 100) / $b_equip[$i];
		}
		else{
			$equip_rate[$i] = 0;
		}
		
		if($b_human[$i] != 0){
			$human_rate[$i] = ($human[$i] * 100) / $b_human[$i];
		}
		else{
			$human_rate[$i] = 0;
		}
		
		if($b_research[$i] != 0){
			$research_rate[$i] = ($research[$i] * 100) / $b_research[$i];
		}
		else{
			$research_rate[$i] = 0;
		}
		
		if($b_sale[$i] != 0){
			$sale_rate[$i] = ($sale[$i] * 100) / $b_sale[$i];
		}
		else{
			$sale_rate[$i] = 0;
		}
		
		if($b_finance[$i] != 0){
			$finance_rate[$i] = ($finance[$i] * 100) / $b_finance[$i];
		}
		else{
			$finance_rate[$i] = 0;
		}
		//--------------------------------------------------------------------------------------------------------------
		
		
		
	}//end of for
	
	//當年-----------------------------------------------------------------------------------------------------------
	$temp = mysql_query("SELECT SUM(`equip`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$equip_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`human`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$human_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`research`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$research_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`sale`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$sale_now = $result[0];

	$temp = mysql_query("SELECT SUM(`finance`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$finance_now = $result[0];
	
	
?>
  <body>
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
        <tr class="success">
            <th></th>
            <th class="text-center">當年</th>
            <th class="text-center">第一年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td>生產人員</td>
            <td><?php echo number_format($equip_now); ?></td>
            <td><?php echo number_format($equip[1]); ?></td>
            <td><?php echo number_format($equip_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>行政人員</td>
            <td><?php echo number_format($human_now); ?></td>
            <td><?php echo number_format($human[1]); ?></td>
            <td><?php echo number_format($human_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>研發團隊</td>
            <td><?php echo number_format($research_now); ?></td>
            <td><?php echo number_format($research[1]); ?></td>
            <td><?php echo number_format($research_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>業務人員</td>
            <td><?php echo number_format($sale_now); ?></td>
            <td><?php echo number_format($sale[1]); ?></td>
            <td><?php echo number_format($sale_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>財務人員</td>
            <td><?php echo number_format($finance_now); ?></td>
            <td><?php echo number_format($finance[1]); ?></td>
            <td><?php echo number_format($finance_rate[1],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="success">
            <th class="text-center">第二年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第三年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo number_format($equip[2]); ?></td>
            <td><?php echo number_format($equip_rate[2],2); ?>%</td>
            <td><?php echo number_format($equip[3]); ?></td>
            <td><?php echo number_format($equip_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($human[2]); ?></td>
            <td><?php echo number_format($human_rate[2],2); ?>%</td>
            <td><?php echo number_format($human[3]); ?></td>
            <td><?php echo number_format($human_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($research[2]); ?></td>
            <td><?php echo number_format($research_rate[2],2); ?>%</td>
            <td><?php echo number_format($research[3]); ?></td>
            <td><?php echo number_format($research_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($sale[2]); ?></td>
            <td><?php echo number_format($sale_rate[2],2); ?>%</td>
            <td><?php echo number_format($sale[3]); ?></td>
            <td><?php echo number_format($sale_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($finance[2]); ?></td>
            <td><?php echo number_format($finance_rate[2],2); ?>%</td>
            <td><?php echo number_format($finance[3]); ?></td>
            <td><?php echo number_format($finance_rate[3],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
    
      
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="success">
            <th class="text-center">第四年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第五年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo number_format($equip[4]); ?></td>
            <td><?php echo number_format($equip_rate[4],2); ?>%</td>
            <td><?php echo number_format($equip[5]); ?></td>
            <td><?php echo number_format($equip_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($human[4]); ?></td>
            <td><?php echo number_format($human_rate[4],2); ?>%</td>
            <td><?php echo number_format($human[5]); ?></td>
            <td><?php echo number_format($human_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($research[4]); ?></td>
            <td><?php echo number_format($research_rate[4],2); ?>%</td>
            <td><?php echo number_format($research[5]); ?></td>
            <td><?php echo number_format($research_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($sale[4]); ?></td>
            <td><?php echo number_format($sale_rate[4],2); ?>%</td>
            <td><?php echo number_format($sale[5]); ?></td>
            <td><?php echo number_format($sale_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo number_format($finance[4]); ?></td>
            <td><?php echo number_format($finance_rate[4],2); ?>%</td>
            <td><?php echo number_format($finance[5]); ?></td>
            <td><?php echo number_format($finance_rate[5],2); ?>%</td>
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