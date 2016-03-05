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
		$b_produce_A[$i] = $result['produce_A'];
		$b_produce_B[$i] = $result['produce_B'];
		//---------------------------------------------------------------------------------------------------
	
	
		//實際生產量-------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$cid' AND `year`='$i' AND `product`='A'");
		$result = mysql_fetch_array($temp);
		$produce_A[$i] = $result[0];
		if($produce_A[$i] == ""){
			$produce_A[$i] = 0;
		}
		$temp = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$cid' AND `year`='$i' AND `product`='B'");
		$result = mysql_fetch_array($temp);
		$produce_B[$i] = $result[0];
		if($produce_B[$i] == ""){
			$produce_B[$i] = 0;
		}
		//---------------------------------------------------------------------------------------------------
	
	
	
		//達成率-----------------------------------------------------------------------------------------------
		
		if($b_produce_A[$i] != 0){
			$produce_A_rate[$i] = ($produce_A[$i]*100) / $b_produce_A[$i];
		}
		else{
			$produce_A_rate[$i] = 0;
		}
		if($b_produce_B[$i] != 0){
			$produce_B_rate[$i] = ($produce_B[$i]*100) / $b_produce_B[$i];
		}
		else{
			$produce_B_rate[$i] = 0;
		}
		//---------------------------------------------------------------------------------------------------
		
		
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
            <td>產品A生產量</td>
            <td><?php echo $result['produce_A']; ?></td>
            <td><?php echo $produce_A[1]; ?></td>
            <td><?php echo number_format($produce_A_rate[1],2); ?>%</td>
        </tr>
        <tr>
            <td>產品B生產量</td>
            <td><?php echo $result['produce_B']; ?></td>
            <td><?php echo $produce_B[1]; ?></td>
            <td><?php echo number_format($produce_B_rate[1],2); ?>%</td>
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
            <td><?php echo $produce_A[2]; ?></td>
            <td><?php echo number_format($produce_A_rate[2],2); ?>%</td>
            <td><?php echo $produce_A[3]; ?></td>
            <td><?php echo number_format($produce_A_rate[3],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $produce_B[2]; ?></td>
            <td><?php echo number_format($produce_B_rate[2],2); ?>%</td>
            <td><?php echo $produce_B[3]; ?></td>
            <td><?php echo number_format($produce_B_rate[3],2); ?>%</td>
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
            <td><?php echo $produce_A[4]; ?></td>
            <td><?php echo number_format($produce_A_rate[4],2); ?>%</td>
            <td><?php echo $produce_A[5]; ?></td>
            <td><?php echo number_format($produce_A_rate[5],2); ?>%</td>
        </tr>
        <tr>
            <td><?php echo $produce_B[4]; ?></td>
            <td><?php echo number_format($produce_B_rate[4],2); ?>%</td>
            <td><?php echo $produce_B[5]; ?></td>
            <td><?php echo number_format($produce_B_rate[5],2); ?>%</td>
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