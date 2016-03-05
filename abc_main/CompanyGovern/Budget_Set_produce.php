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
	
	
	
	$temp = mysql_query("SELECT `sell_A`,`sell_B` FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$sell = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`batch`) FROM `product_quality` WHERE `cid`='$cid' AND `product`='A'");
	$batch_A = mysql_fetch_array($temp);
	if($batch_A[0] == ""){
		$batch_A[0] = 0;
	}
	$temp = mysql_query("SELECT SUM(`batch`) FROM `product_quality` WHERE `cid`='$cid' AND `product`='B'");
	$batch_B = mysql_fetch_array($temp);
	if($batch_B[0] == ""){
		$batch_B[0] = 0;
	}
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
	$pro_A = $result['produce_A'] + $batch_A[0] - $sell['sell_A'];
	$pro_B = $result['produce_B'] + $batch_B[0] - $sell['sell_B'];
	
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
    <!-------------筆電/平板區域-------------------------->
    <div class="col-sm-12 text-center">
        <table class="table table-bordered" style="margin-top:25px;s">
            <tr class="info">
                <th></th>
                <th>筆記型電腦</th>
                <th>平板電腦</th>
            </tr>
            <tbody>
            <tr>
                <td>預計銷售量</td>
                <td id="sell_A"><?php echo $sell['sell_A']; ?></td>
                <td id="sell_B"><?php echo $sell['sell_B']; ?></td>
            </tr>
            <tr>
                <td>加：期末存貨</td>
                <td><input id="pro_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $pro_A; ?>" onBlur="produce_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                <td><input id="pro_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $pro_B; ?>" onBlur="produce_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            </tr>
            <tr>
                <td>減：期末庫存</td>
                <td id="before_A"><?php echo $batch_A[0]; ?></td>
                <td id="before_B"><?php echo $batch_B[0]; ?></td>
            </tr>
            <tr>
                <td>預計生產量</td>
                <td id="produce_A">0</td>
                <td id="produce_B">0</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!---------------------------submitbutton-------------------->
    <div class="col-sm-12 text-center">
    <input id="sub" class="btn btn-primary btn-lg" type="submit" value="Submit">
    </div>
    
    
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap.js"></script>
    <script type="text/javascript">
		var pro_A = document.getElementById("pro_A").value;
		var pro_B = document.getElementById("pro_B").value;
		var before_A = document.getElementById("before_A").innerHTML;
		var before_B = document.getElementById("before_B").innerHTML;
		var sell_A = document.getElementById("sell_A").innerHTML;
		var sell_B = document.getElementById("sell_B").innerHTML;
		var f_pro_A = 0 , f_pro_B = 0;
		var after_A = after_B = 0;
		
        $(document).ready(function() {
			if(parseInt(pro_A) + parseInt(sell_A) > parseInt(before_A)){
				document.getElementById("produce_A").innerHTML = parseInt(pro_A) - parseInt(before_A) + parseInt(sell_A);
			}
			else{
				document.getElementById("produce_A").innerHTML = 0
			}
			if(parseInt(pro_B) + parseInt(sell_B) > parseInt(before_B)){
				document.getElementById("produce_B").innerHTML = parseInt(pro_B) - parseInt(before_B) + parseInt(sell_B);
			}
			else{
				document.getElementById("produce_B").innerHTML = 0
			}
			
            $("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					f_pro_A = document.getElementById("produce_A").innerHTML;
					f_pro_B = document.getElementById("produce_B").innerHTML;
					
					after_A = document.getElementById("pro_A").value;
					after_B = document.getElementById("pro_B").value;
					
					if(after_A < 0 || after_B < 0){
						alert("期末存貨不可小於0");
					}
					else{
						$.ajax({
							url:"Budget_DB.php",
							type:"GET",
							dataType:"html",
							data:"type=produce&f_pro_A="+f_pro_A+"&f_pro_B="+f_pro_B
							,
							error: function(){
								alert("fail");
							},
							success: function(){
								alert("success");
							}
						});
					}
				}
				else{
					alert("每年一月才能進行編製");
				}
			});
        });//end of ready
		
		function produce_A(){
			pro_A = document.getElementById("pro_A").value;
			before_A = document.getElementById("before_A").innerHTML;
			
			if(parseInt(pro_A) + parseInt(sell_A) > parseInt(before_A)){
				document.getElementById("produce_A").innerHTML = parseInt(pro_A) - parseInt(before_A) + parseInt(sell_A);
			}
			else{
				document.getElementById("produce_A").innerHTML = 0
			}
		}
		function produce_B(){
			pro_B = document.getElementById("pro_B").value;
			before_B = document.getElementById("before_B").innerHTML;
			if(parseInt(pro_B) + parseInt(sell_B) > parseInt(before_B)){
				document.getElementById("produce_B").innerHTML = parseInt(pro_B) - parseInt(before_B) + parseInt(sell_B);
			}
			else{
				document.getElementById("produce_B").innerHTML = 0
			}
		}
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