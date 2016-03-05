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
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$budget = mysql_fetch_array($temp);
	$require_p = $budget['produce_A'] + $budget['produce_B'];
	$require_k = $budget['produce_A'] + $budget['produce_B'];
	$require_kb = $budget['produce_A'];
	
	//計算期初存料(p)
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `product_b` WHERE `cid`='$cid'");
	$result7 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `product_b` WHERE `cid`='$cid'");
	$result8 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `product_b` WHERE `cid`='$cid'");
	$result9 = mysql_fetch_array($temp);
	
	$before_p = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0]-$result7[0]-$result8[0]-$result9[0];
	
	//計算期初存料(k)
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `product_b` WHERE `cid`='$cid'");
	$result7 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `product_b` WHERE `cid`='$cid'");
	$result8 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `product_b` WHERE `cid`='$cid'");
	$result9 = mysql_fetch_array($temp);
	
	$before_k = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0]-$result7[0]-$result8[0]-$result9[0];
	
	//計算期初存料(kb)
	$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$before_kb = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0];
	//-----------------------------------------------------------------------------------------------------------------
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
	$after_panel = $result['purchase_p'] + $before_p - $require_p;
	$after_kernel = $result['purchase_k'] + $before_k - $require_k;
	$after_keyboard = $result['purchase_kb'] + $before_kb - $require_kb;
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
    
    
    
<!--------------------標頭區------------------------------->    
        <div class="col-sm-3 text-center panelpadding1">
        <table class="table table-bordered " style="margin-top:20px;">
            <tr class="info">
                <th class="hidden-xs">&nbsp;</th>
            </tr>
            <tbody>
            <tr>
                <td class="hidden-xs">耗用原料數量</td>
            </tr>
            <tr>
                <td class="hidden-xs">加：期末原料</td>
            </tr>
            <tr>
                <td class="hidden-xs">減：期初原料</td>
            </tr>
            <tr>
                <td class="hidden-xs">預計購料數量</td>
            </tr>
            <tr>
                <td class="hidden-xs">預計進貨金額</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-------------螢幕與面板-------------------------->
    <div class="col-sm-3 text-center panelpadding2 panelpadding1">
        <table class="table table-bordered" style="margin-top:20px;">
            <tr class="info">
                <th class="visible-xs"></th>
                <th>螢幕與面板</th>
            </tr>
            <tbody>
            <tr>
                <td class="visible-xs">耗用原料數量</td>
                <td id="require_p"><?php echo $require_p; ?></td>
            </tr>
            <tr>
                <td class="visible-xs">加：期末原料</td>
                <td><input id="after_panel" class="form-control text-center" type="text" placeholder="0" value="<?php echo $after_panel; ?>" onBlur="panel()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>

            </tr>
            <tr>
                <td class="visible-xs">減：期初原料</td>
                <td id="before_p"><?php echo $before_p; ?></td>

            </tr>
            <tr>
                <td class="visible-xs">預計購料數量</td>
                <td id="p_panel">0</td>
            </tr>
            <tr>
                <td class="visible-xs">預計進貨金額</td>
                <td id="pp_panel">0</td>
            </tr>
            </tbody>
        </table>
    </div>
 <!--------------------主機板與核心電路------------------->
    <div class="col-sm-3 text-center panelpadding2 panelpadding1">
        <table class="table table-bordered" style="margin-top:20px;">
            <tr class="info">
                <th class="visible-xs"></th>
                <th>主機板與核心電路</th>
            </tr>
            <tbody>
            <tr>
                <td class="visible-xs">耗用原料數量</td>
                <td id="require_k"><?php echo $require_k; ?></td>
            </tr>
            <tr>
                <td class="visible-xs">加：期末原料</td>
                <td><input id="after_kernel" class="form-control text-center" type="text" placeholder="0" value="<?php echo $after_kernel; ?>" onBlur="kernel()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>

            </tr>
            <tr>
                <td class="visible-xs">減：期初原料</td>
                <td id="before_k"><?php echo $before_k; ?></td>

            </tr>
            <tr>
                <td class="visible-xs">預計購料數量</td>
                <td id="p_kernel">0</td>
            </tr>
            <tr>
                <td class="visible-xs">預計進貨金額</td>
                <td id="pp_kernel">0</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--------------------------鍵盤基座------------------>
        <div class="col-sm-3 text-center panelpadding2">
        <table class="table table-bordered" style="margin-top:20px;">
            <tr class="info">
                <th class="visible-xs"></th>
                <th>鍵盤基座</th>
            </tr>
            <tbody>
            <tr>
                <td class="visible-xs">耗用原料數量</td>
                <td id="require_kb"><?php echo $require_kb; ?></td>
            </tr>
            <tr>
                <td class="visible-xs">加：期末原料</td>
                <td><input id="after_keyboard" class="form-control text-center" type="text" placeholder="0" value="<?php echo $after_keyboard; ?>" onBlur="keyboard()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>

            </tr>
            <tr>
                <td class="visible-xs">減：期初原料</td>
                <td id="before_kb"><?php echo $before_kb ?></td>

            </tr>
            <tr>
                <td class="visible-xs" >預計購料數量</td>
                <td id="p_keyboard">0</td>
            </tr>
            <tr>
                <td class="visible-xs">預計進貨金額</td>
                <td id="pp_keyboard">0</td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap.js"></script>
    <script type="text/javascript">
		
		
		var require_p = document.getElementById("require_p").innerHTML;
		var require_k = document.getElementById("require_k").innerHTML;
		var require_kb = document.getElementById("require_kb").innerHTML;
		var after_panel = document.getElementById("after_panel").value;
		var after_kernel = document.getElementById("after_kernel").value;
		var after_keyboard = document.getElementById("after_keyboard").value;
		var before_panel = document.getElementById("before_p").innerHTML;
		var before_kernel = document.getElementById("before_k").innerHTML;
		var before_keyboard = document.getElementById("before_kb").innerHTML;
		var p_panel = 0 , p_kernel = 0 , p_keyboard = 0;
		var pp_panel = 0 , pp_kernel = 0 , pp_keyboard = 0;
		
        $(document).ready(function() {
			
			if(parseInt(after_panel) + parseInt(require_p) > parseInt(before_panel)){
				document.getElementById("p_panel").innerHTML = p_panel = parseInt(after_panel) - parseInt(before_panel) + parseInt(require_p);
			}
			else{
				document.getElementById("p_panel").innerHTML = p_panel = 0;
			}
			
			if(parseInt(after_kernel) + parseInt(require_k) > parseInt(before_kernel)){
				document.getElementById("p_kernel").innerHTML = p_kernel = parseInt(after_kernel) - parseInt(before_kernel) + parseInt(require_k);
			}
			else{
				document.getElementById("p_kernel").innerHTML = p_kernel = 0;
			}
			
			if(parseInt(after_keyboard) + parseInt(require_kb) > parseInt(before_keyboard)){
				document.getElementById("p_keyboard").innerHTML = p_keyboard = parseInt(after_keyboard) - parseInt(before_keyboard) + parseInt(require_kb);
			}
			else{
				document.getElementById("p_keyboard").innerHTML = p_keyboard = 0;
			}
			
			document.getElementById("pp_panel").innerHTML = addCommas(parseInt(p_panel) * 1100);
			document.getElementById("pp_kernel").innerHTML = addCommas(parseInt(p_kernel) * 1500);
			document.getElementById("pp_keyboard").innerHTML = addCommas(parseInt(p_keyboard) * 1000);
			
			
			$("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					p_panel = document.getElementById("p_panel").innerHTML;
					p_kernel = document.getElementById("p_kernel").innerHTML;
					p_keyboard = document.getElementById("p_keyboard").innerHTML;
					
					after_panel = document.getElementById("after_panel").value;
					after_kernel = document.getElementById("after_kernel").value;
					after_keyboard = document.getElementById("after_keyboard").value;
					
					if(after_panel < 0 || after_kernel < 0 || after_keyboard < 0){
						alert("期末存料不可小於0");
					}
					else{
					
						$.ajax({
							url:"Budget_DB.php",
							type:"GET",
							dataType:"html",
							data:"type=purchase&p_panel="+p_panel+"&p_kernel="+p_kernel+"&p_keyboard="+p_keyboard
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
		
		function panel(){
			
			after_panel = document.getElementById("after_panel").value;
			before_panel = document.getElementById("before_p").innerHTML;
			
			if(parseInt(after_panel) + parseInt(require_p) > parseInt(before_panel)){
				document.getElementById("p_panel").innerHTML = p_panel = parseInt(after_panel) - parseInt(before_panel) + parseInt(require_p);
			}
			else{
				document.getElementById("p_panel").innerHTML = p_panel = 0;
			}
			
			document.getElementById("pp_panel").innerHTML = addCommas(parseInt(p_panel) * 1100);
			
		}
		
		function kernel(){
			
			after_kernel = document.getElementById("after_kernel").value;
			before_kernel = document.getElementById("before_k").innerHTML;
			
			if(parseInt(after_kernel) + parseInt(require_k) > parseInt(before_kernel)){
				document.getElementById("p_kernel").innerHTML = p_kernel = parseInt(after_kernel) - parseInt(before_kernel) + parseInt(require_k);
			}
			else{
				document.getElementById("p_kernel").innerHTML = p_kernel = 0;
			}
			
			document.getElementById("pp_kernel").innerHTML = addCommas(parseInt(p_kernel) * 1500);
			
		}
		
		function keyboard(){
			
			after_keyboard = document.getElementById("after_keyboard").value;
			before_keyboard = document.getElementById("before_kb").innerHTML;
			
			if(parseInt(after_keyboard) + parseInt(require_kb) > parseInt(before_keyboard)){
				document.getElementById("p_keyboard").innerHTML = p_keyboard = parseInt(after_keyboard) - parseInt(before_keyboard) + parseInt(require_kb);
			}
			else{
				document.getElementById("p_keyboard").innerHTML = p_keyboard = 0;
			}
			
			document.getElementById("pp_keyboard").innerHTML = addCommas(parseInt(p_keyboard) * 1000);
			
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