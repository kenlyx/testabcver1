<!DOCTYPE html>
<?php session_start(); ?>
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
    <script type="text/javascript" src="../js/jquery.js"></script>
  </head>
<?php	
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	
	$temp = mysql_query("SELECT MAX(`product_A_RD`) FROM `state`  WHERE `cid`='$cid'");
	$result = mysql_fetch_array($temp);
	$rd_A = $result[0];
	
	$temp = mysql_query("SELECT MAX(`product_B_RD`) FROM `state`  WHERE `cid`='$cid'");
	$result = mysql_fetch_array($temp);
	$rd_B = $result[0];
	
	/*
	$temp = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$cid' AND `month`<=($year-1)*12 AND `month` > ($year-2)*12");
	$result = mysql_fetch_array($temp);
	$total_revenue = $result[0];
	if($total_revenue == ""){
		$total_revenue = 0;
	}*/
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$total_revenue = ($result['sell_A']*20000) + ($result['sell_B']*15000);
	if($result['produce_A'] > $result['produce_B']){
		$Recom_equip = $result['produce_A'] / 200;
	}
	else{
		$Recom_equip = $result['produce_B'] / 200;
	}
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='finan_load2'");
	$result = mysql_fetch_array($temp);
	$finan_load2 = $result[0];
	$Recom_finan = ($total_revenue / 12) / ($finan_load2 * 1000);
	
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='research_load2'");
	$result = mysql_fetch_array($temp);
	$research_load2 = $result[0];
	$Recom_research = ($total_revenue / 12) / ($research_load2 * 1000);
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='sale_load2'");
	$result = mysql_fetch_array($temp);
	$sale_load2 = $result[0];
	$Recom_sale = ($total_revenue / 12) / ($sale_load2 * 1000);
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='human_load2'");
	$result = mysql_fetch_array($temp);
	$human_load2 = $result[0];
	$Recom_human = ($total_revenue / 12) / ($human_load2 * 1000);
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
?>
  <body>
<div class="container-fluid">
<h1>編製預算<small style="color:#ff0000;">* 進行每年花費之規劃 *</small></h1>
<!--------------按鈕區------------------------------------->   
    <div class="text-center">
        <a class="btn btn1 btn-danger" href="./Budget_Set_finance.php" role="button">銷</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-primary" href="./Budget_Set_produce.php" role="button">產</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-info" href="./Budget_Set_purchase.php" role="button">購</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-success" href="./Budget_Set_human.php" role="button">人</a>
        <span class="hidden-xs"><i class="fa fa-angle-double-right"></i></span>
        <a class="btn btn1 btn-warning" href="./Budget_Set_admin.php" role="button">行</a>
    </div>    
    <!-------------有關$$的區域-------------------------->
    <div class="container-fluid ">
        <div class="col-sm-4 text-center admincash">
        <table class="table table-bordered " style="margin-top:25px;">
            <tr class="warning">
                <th></th>
                <th></th>
            </tr>
            <tbody>
            <tr>
                <td>資金募集</td>
                
                <td><input id="fund_raising" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['fund_raising']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>發放現金股利</td>
                <td><input id="cash_divide" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['cash_divide']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>短期借款</td> 
                <td><input id="S_borrow" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['S_borrow']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>長期借款</td>
                <td><input id="L_borrow" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['L_borrow']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            
            </tbody>
        </table>       
        </div>
    </div>
    <!-------------------------資產區域------------------------------------>
    <div class="col-sm-4 text-center panelpadding1">
        <table class="table table-bordered" style="margin-top:25px;s">
            <tr class="warning">
                <th></th>
                <th></th>
            </tr>
            <tbody>    
            <tr class="active">
                <td>筆記型電腦</td>
                <td><input id="RD_A" type="checkbox"></td>
            </tr>
            <tr class="active">
                <td>平板電腦</td>
                <td><input id="RD_B" type="checkbox"></td>
            </tr>
            <tr>
                <td></td>
                <td>切割原料機具</td>
            </tr>
            <tr>
                <td>A(600,000/每台)</td>
                <td><input id="p_mc_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_mc_A']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>B(500,000/每台)</td> 
                <td><input id="p_mc_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_mc_B']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>C(400,000/每台)</td>
                <td><input id="p_mc_C" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_mc_C']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            
            </tbody>
        </table>       
    </div>
        <div class="col-sm-4 text-center panelpadding1 panelpadding2">
        <table class="table table-bordered" style="margin-top:25px;s">
            <tr class="warning">
                <th></th>
                <th></th>
            </tr>
            <tbody>
            <tr class="active">
                <td></td>
                <td>合格檢測機具</td>
            </tr>
            <tr class="active">
                <td>1,000,000/每台</td>
                <td><input id="p_mcheck" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_mcheck']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td></td>
                
                <td>第一層組裝機具</td>
            </tr>
            <tr>
                <td>A(700,000/每台)</td>
                <td><input id="p_m1_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m1_A']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>B(600,000/每台)</td> 
                <td><input id="p_m1_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m1_B']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>C(500,000/每台)</td>
                <td><input id="p_m1_C" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m1_C']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>

            </tbody>
        </table>       
    </div>
        <div class="col-sm-4 text-center panelpadding2">
        <table class="table table-bordered" style="margin-top:25px;s">
            <tr class="warning">
                <th></th>
                <th></th>
            </tr>
            <tbody>
            <tr class="active">
                <td></td>
                <td>精密檢測機具</td>
            </tr>
            <tr class="active">
                <td>1,500,000/每台</td>
                <td><input id="p_mchecks" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_mchecks']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td></td>
                
                <td>第二層組裝機具</td>
            </tr>
            <tr>
                <td>A(1,000,000/每台)</td>
                <td><input id="p_m2_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m2_A']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>B(900,000/每台)</td> 
                <td><input id="p_m2_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m2_B']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>C(800,000/每台)</td>
                <td><input id="p_m2_C" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['p_m2_C']; ?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>

            </tbody>
        </table>       
    </div>
    <!---------------------------submitbutton-------------------->
    <div class="col-sm-12 text-center">
    <input id="sub" type="submit" class="btn btn-primary btn-lg">
    </div>
    
    
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap.js"></script>
    <script type="text/javascript">
	
		var rd_A = 0 , rd_B = 0;
		var p_mc_A = p_mc_B = p_mc_C = p_m1_A = p_m1_B = p_m1_C = p_m2_A = p_m2_B = p_m2_C = p_mcheck = p_mchecks = 0;
		var func_raising = cash_divide = S_borrow = L_borrow = 0;
		
        $(document).ready(function(){
			if(<?php echo $result['rd_A'] ?> == 1){
				document.getElementById("RD_A").checked = true;
			}
			if(<?php echo $result['rd_B'] ?> == 1){
				document.getElementById("RD_B").checked = true;
			}
            if(<?php echo $rd_A ?> == 1){
				document.getElementById("RD_A").checked = true;
				document.getElementById("RD_A").disabled = true;
			}
			if(<?php echo $rd_B ?> == 1){
				document.getElementById("RD_B").checked = true;
				document.getElementById("RD_B").disabled = true;
			}
			$("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					
					if(document.getElementById("RD_A").checked == true){
						rd_A = 1;
					}
					if(document.getElementById("RD_B").checked == true){
						rd_B = 1;
					}
					p_mc_A = document.getElementById("p_mc_A").value;
					p_mc_B = document.getElementById("p_mc_B").value;
					p_mc_C = document.getElementById("p_mc_C").value;
					p_m1_A = document.getElementById("p_m1_A").value;
					p_m1_B = document.getElementById("p_m1_B").value;
					p_m1_C = document.getElementById("p_m1_C").value;
					p_m2_A = document.getElementById("p_m2_A").value;
					p_m2_B = document.getElementById("p_m2_B").value;
					p_m2_C = document.getElementById("p_m2_C").value;
					p_mcheck = document.getElementById("p_mcheck").value;
					p_mchecks = document.getElementById("p_mchecks").value;
					fund_raising = document.getElementById("fund_raising").value;
					cash_divide = document.getElementById("cash_divide").value;
					S_borrow = document.getElementById("S_borrow").value;
					L_borrow = document.getElementById("L_borrow").value;
					
					
					$.ajax({
						url:"Budget_DB.php",
						type:"GET",
						dataType:"html",
						data:"type=admin&rd_A="+rd_A+"&rd_B="+rd_B+"&p_mc_A="+p_mc_A+"&p_mc_B="+p_mc_B+"&p_mc_C="+p_mc_C+"&p_m1_A="+p_m1_A+"&p_m1_B="+p_m1_B+"&p_m1_C="+p_m1_C+"&p_m2_A="+p_m2_A+"&p_m2_B="+p_m2_B+"&p_m2_C="+p_m2_C+"&p_mcheck="+p_mcheck+"&p_mchecks="+p_mchecks+"&fund_raising="+fund_raising+"&cash_divide="+cash_divide+"&S_borrow="+S_borrow+"&L_borrow="+L_borrow
						,
						error: function(){
							alert("fail");
							
						},
						success: function(){
							alert("success");
						}
					});
				}
				else{
					alert("每年一月才能進行編製");
				}
			});
        });//end of ready
		
		function addCommas(nStr){
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
    </script>
  </body>
</html>