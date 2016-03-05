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
		
		//預算------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_purchase_p[$i] = $result['purchase_p'];
		$b_purchase_k[$i] = $result['purchase_k'];
		$b_purchase_kb[$i] = $result['purchase_kb'];
		
		//---------------------------------------------------------------------------------------------------
	
	
		//實際購買量-------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma1 = $result[0];
		if($ma1 == ""){
			$ma1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma2 = $result[0];
		if($ma2 == ""){
			$ma2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma3 = $result[0];
		if($ma3 == ""){
			$ma3 = 0;
		}
		$purchase_p[$i] = $ma1 + $ma2 + $ma3;
		if($purchase_p[$i] == ""){
			$purchase_p[$i] = 0;
		}
		
		
		$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb1 = $result[0];
		if($mb1 == ""){
			$mb1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb2 = $result[0];
		if($mb2 == ""){
			$mb2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb3 = $result[0];
		if($mb3 == ""){
			$mb3 = 0;
		}
		$purchase_k[$i] = $mb1 + $mb2 + $mb3;
		
		$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc1 = $result[0];
		if($mc1 == ""){
			$mc1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc2 = $result[0];
		if($mc2 == ""){
			$mc2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc3 = $result[0];
		if($mc3 == ""){
			$mc3 = 0;
		}
		$purchase_kb[$i] = $mc1 + $mc2 + $mc3;
		
		//----------------------------------------------------------------------------------------------------
	
	
	
	
		//達成率-----------------------------------------------------------------------------------------------
		if($b_purchase_p[$i] != 0){
		$purchase_p_rate[$i] = ($purchase_p[$i]*100) / $b_purchase_p[$i];
		}
		else{
			$purchase_p_rate[$i] = 0;
		}
		if($b_purchase_k[$i] != 0){
			$purchase_k_rate[$i] = ($purchase_k[$i]*100) / $b_purchase_k[$i];
		}
		else{
			$purchase_k_rate[$i] = 0;
		}
		if($b_purchase_kb[$i] != 0){
			$purchase_kb_rate[$i] = ($purchase_kb[$i]*100) / $b_purchase_kb[$i];
		}
		else{
			$purchase_kb_rate[$i] = 0;
		}
		
		
		//----------------------------------------------------------------------------------------------------
		
		
	}
	
	
	
	
	//當年------------------------------------------------------------------------------------------------
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
        <tr class="info">
            <th></th>
            <th class="text-center">當年</th>
            <th class="text-center">第一年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td>面板購買量</td>
            <td><?php echo $result['purchase_p']; ?></td>
            <td><?php echo $purchase_p[1]; ?></td>
            <td><?php echo number_format($purchase_p_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>核心購買量</td>
            <td><?php echo $result['purchase_k']; ?></td>
            <td><?php echo $purchase_k[1]; ?></td>
            <td><?php echo number_format($purchase_k_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>鍵盤購買量</td>
            <td><?php echo $result['purchase_kb']; ?></td>
            <td><?php echo $purchase_kb[1]; ?></td>
            <td><?php echo number_format($purchase_kb_rate[1],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="info">
            <th class="text-center">第二年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第三年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo $purchase_p[2]; ?></td>
            <td><?php echo number_format($purchase_p_rate[2],2); ?>%</td>
            <td><?php echo $purchase_p[3]; ?></td>
            <td><?php echo number_format($purchase_p_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $purchase_k[2]; ?></td>
            <td><?php echo number_format($purchase_k_rate[2],2); ?>%</td>
            <td><?php echo $purchase_k[3]; ?></td>
            <td><?php echo number_format($purchase_k_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $purchase_kb[2]; ?></td>
            <td><?php echo number_format($purchase_kb_rate[2],2); ?>%</td>
            <td><?php echo $purchase_kb[3]; ?></td>
            <td><?php echo number_format($purchase_kb_rate[3],2); ?>%</td>
        </tr>
        </tbody>    
    </table>
    </div>
    
      
      <div class="item ">
    <table class="table table-bordered table-striped text-center">
        <tr class="info">
            <th class="text-center">第四年</th>
            <th class="text-center">達成率</th>
            <th class="text-center">第五年</th>
            <th class="text-center">達成率</th>
        </tr>
        <tbody>
        <tr>
            <td><?php echo $purchase_p[4]; ?></td>
            <td><?php echo number_format($purchase_p_rate[4],2); ?>%</td>
           <td><?php echo $purchase_p[5]; ?></td>
            <td><?php echo number_format($purchase_p_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $purchase_k[4]; ?></td>
            <td><?php echo number_format($purchase_k_rate[4],2); ?>%</td>
            <td><?php echo $purchase_k[5]; ?></td>
            <td><?php echo number_format($purchase_k_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $purchase_kb[4]; ?></td>
            <td><?php echo number_format($purchase_kb_rate[4],2); ?>%</td>
            <td><?php echo $purchase_kb[5]; ?></td>
            <td><?php echo number_format($purchase_kb_rate[5],2); ?>%</td>
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