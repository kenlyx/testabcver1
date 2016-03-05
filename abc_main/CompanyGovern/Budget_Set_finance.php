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
    <!-------------筆記型電腦-------------------------->
    <div class="col-sm-6 panelpadding1" >
        <div class="panel panel-danger">
            <div class="panel-heading text-center">筆記型電腦</div>
            <!-- Table -->
            <table class="table table-bordered">
                <tbody>
                    <tr class="active">
                        <td colspan="3">預計銷售量</td>
                    </tr>
                    <tr>
                        <td colspan="2">20000元/每單位</td>
                        <td><input id="sell_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['sell_A']?>" onBlur="count_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="2">預計收入</td>
                        <td id="revenue_A" class="text-center">0</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="success">行銷策略</td>
                    </tr>
                    <tr>
                        <td>網路(小)</td>
                        <td>2,000元/每單位</td>
                        <td><input id="internet_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['internet_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>電視(中)</td>
                        <td>4,000元/每單位</td>
                        <td><input id="TV_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['TV_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>雜誌(大)</td>
                        <td>10,000元/每單位</td>
                        <td><input id="mag_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['magazine_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="info">產品功能定位</td>
                    </tr>
                                        <tr>
                        <td>半導體晶圓</td>
                        <td>100,000元 / 每單位</td>
                        <td><input id="func1_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func1_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>多核心處理器</td>
                        <td>100,000元 / 每單位</td>
                        <td><input id="func2_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func2_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>顯示器</td>
                        <td>100,000元 / 每單位	</td>
                        <td><input id="func3_A" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func3_A']?>" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="warning">預計管銷費用</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td id="man_A" class="text-center">0</td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>
    
    <!-------------平板電腦-------------------------->
    <div class="col-sm-6 panelpadding2">
            <div class="panel panel-danger">
            <div class="panel-heading text-center">平板電腦</div>
            <!-- Table -->
            <table class="table table-bordered">
                <tbody>
                    <tr class="active">
                        <td colspan="3">預計銷售量</td>
                    </tr>
                    <tr>
                        <td colspan="2">15000元/每單位</td>
                        <td><input id="sell_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['sell_B']?>" onBlur="count_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="2">預計收入</td>
                        <td id="revenue_B" class="text-center">0</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="success">行銷策略</td>
                    </tr>
                    <tr>
                        <td>網路(小)</td>
                        <td>2,000元/每單位</td>
                        <td><input id="internet_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['internet_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>電視(中)</td>
                        <td>4,000元/每單位</td>
                        <td><input id="TV_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['TV_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>雜誌(大)</td>
                        <td>10,000元/每單位</td>
                        <td><input id="mag_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['magazine_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="info">產品功能定位</td>
                    </tr>
                                        <tr>
                        <td>觸控螢幕</td>
                        <td>100,000元 / 每單位</td>
                        <td><input id="func1_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func1_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>記憶體</td>
                        <td>100,000元 / 每單位</td>
                        <td><input id="func2_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func2_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td>多核心處理器</td>
                        <td>100,000元 / 每單位	</td>
                        <td><input id="func3_B" class="form-control text-center" type="text" placeholder="0" value="<?php echo $result['func3_B']?>" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="warning">預計管銷費用</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td id="man_B" class="text-center">0</td>
                    </tr>
                </tbody>
            </table>
        </div>       
    </div>
    <!---------------------------submitbutton-------------------->
    <div class="col-sm-12 text-center">
    <input id="sub" class="btn btn-primary btn-lg" type="submit">
    </div>
    
    
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap.js"></script>
    <script type="text/javascript">
		var sell_A = 0 , sell_B = 0;
		var revenue_A = 0 , revenue_B = 0;
		var internet_A = 0 , TV_A = 0 , mag_A = 0;
		var func1_A = 0 , func2_A = 0 , func3_A = 0;
		var internet_B = 0 , TV_B = 0 , mag_B = 0;
		var func1_B = 0 , func2_B = 0 , func3_B = 0;
		var money_A = 0 , money_B = 0;
			
        $(document).ready(function() {
			
			sell_A = document.getElementById("sell_A").value;
			revenue_A = sell_A * 20000;
			document.getElementById("revenue_A").innerHTML = addCommas(parseInt(revenue_A));
			
			sell_B = document.getElementById("sell_B").value;
			revenue_B = sell_B * 15000;
			document.getElementById("revenue_B").innerHTML = addCommas(parseInt(revenue_B));
			
			internet_A = document.getElementById("internet_A").value;
			TV_A = document.getElementById("TV_A").value;
			mag_A = document.getElementById("mag_A").value;
			func1_A = document.getElementById("func1_A").value;
			func2_A = document.getElementById("func2_A").value;
			func3_A = document.getElementById("func3_A").value;
			money_A =(internet_A*4000)+(TV_A*6000)+(mag_A*12000)+((parseInt(func1_A)+parseInt(func2_A)+parseInt(func3_A))*100000);
			document.getElementById("man_A").innerHTML = addCommas(parseInt(money_A));
					
			internet_B = document.getElementById("internet_B").value;
			TV_B = document.getElementById("TV_B").value;
			mag_B = document.getElementById("mag_B").value;
			func1_B = document.getElementById("func1_B").value;
			func2_B = document.getElementById("func2_B").value;
			func3_B = document.getElementById("func3_B").value;
			money_B =(internet_B*4000)+(TV_B*6000)+(mag_B*12000)+((parseInt(func1_B)+parseInt(func2_B)+parseInt(func3_B))*100000);
			document.getElementById("man_B").innerHTML = addCommas(parseInt(money_B));
			
			
            $("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					sell_A = document.getElementById("sell_A").value;
					sell_B = document.getElementById("sell_B").value;
					
					internet_A = document.getElementById("internet_A").value;
					TV_A = document.getElementById("TV_A").value;
					mag_A = document.getElementById("mag_A").value;
					func1_A = document.getElementById("func1_A").value;
					func2_A = document.getElementById("func2_A").value;
					func3_A = document.getElementById("func3_A").value;
					
					internet_B = document.getElementById("internet_B").value;
					TV_B = document.getElementById("TV_B").value;
					mag_B = document.getElementById("mag_B").value;
					func1_B = document.getElementById("func1_B").value;
					func2_B = document.getElementById("func2_B").value;
					func3_B = document.getElementById("func3_B").value;
					
					
					
					
					
					$.ajax({
						url:"Budget_DB.php",
						type:"GET",
						dataType:"html",
						data:"type=finance&sell_A="+sell_A+"&sell_B="+sell_B+"&internet_A="+internet_A+"&TV_A="+TV_A+"&mag_A="+mag_A+"&func1_A="+func1_A+"&func2_A="+func2_A+"&func3_A="+func3_A+"&internet_B="+internet_B+"&TV_B="+TV_B+"&mag_B="+mag_B+"&func1_B="+func1_B+"&func2_B="+func2_B+"&func3_B="+func3_B
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
		function count_A(){
			sell_A = document.getElementById("sell_A").value;
			revenue_A = sell_A * 20000;
			document.getElementById("revenue_A").innerHTML = addCommas(parseInt(revenue_A));
		}
		
		function count_B(){
			sell_B = document.getElementById("sell_B").value;
			revenue_B = sell_B * 15000;
			document.getElementById("revenue_B").innerHTML = addCommas(parseInt(revenue_B));
		}
		
		function count2_A(){
			
			internet_A = document.getElementById("internet_A").value;
			TV_A = document.getElementById("TV_A").value;
			mag_A = document.getElementById("mag_A").value;
			func1_A = document.getElementById("func1_A").value;
			func2_A = document.getElementById("func2_A").value;
			func3_A = document.getElementById("func3_A").value;
			money_A =(internet_A*4000)+(TV_A*6000)+(mag_A*12000)+((parseInt(func1_A)+parseInt(func2_A)+parseInt(func3_A))*100000);
			document.getElementById("man_A").innerHTML = addCommas(parseInt(money_A));
		}
		
		function count2_B(){
			
			internet_B = document.getElementById("internet_B").value;
			TV_B = document.getElementById("TV_B").value;
			mag_B = document.getElementById("mag_B").value;
			func1_B = document.getElementById("func1_B").value;
			func2_B = document.getElementById("func2_B").value;
			func3_B = document.getElementById("func3_B").value;
			money_B =(internet_B*4000)+(TV_B*6000)+(mag_B*12000)+((parseInt(func1_B)+parseInt(func2_B)+parseInt(func3_B))*100000);
			document.getElementById("man_B").innerHTML = addCommas(parseInt(money_B));
		}
		
    </script>
  </body>
</html>