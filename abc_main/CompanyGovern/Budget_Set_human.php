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
    <link href="../js/bootstrap.min.js">
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
	$round=$month+($year-1)*12;+
	error_reporting(0);
	
	for($i=1;$i<13;$i++){
		
		if($i==1){
			$month_name = "month1";
		}
		elseif($i==2){
			$month_name = "month2";
		}
		elseif($i==3){
			$month_name = "month3";
		}
		elseif($i==4){
			$month_name = "month4";
		}
		elseif($i==5){
			$month_name = "month5";
		}
		elseif($i==6){
			$month_name = "month6";
		}
		elseif($i==7){
			$month_name = "month7";
		}
		elseif($i==8){
			$month_name = "month8";
		}
		elseif($i==9){
			$month_name = "month9";
		}
		elseif($i==10){
			$month_name = "month10";
		}
		elseif($i==11){
			$month_name = "month11";
		}
		elseif($i==12){
			$month_name = "month12";
		}
		
		$temp = mysql_query("SELECT * FROM `budget_hire` WHERE cid='$cid' AND year='$year' AND month='$i'");
		${$month_name} = mysql_fetch_array($temp);//$i=1時  此為$month1
		
		if(${$month_name}['equip']==""){
			${$month_name}['equip'] = 0;
		}
		if(${$month_name}['human']==""){
			${$month_name}['human'] = 0;
		}
		if(${$month_name}['research']==""){
			${$month_name}['research'] = 0;
		}
		if(${$month_name}['sale']==""){
			${$month_name}['sale'] = 0;
		}
		if(${$month_name}['finance']==""){
			${$month_name}['finance'] = 0;
		}
		if(${$month_name}['salary']==""){
			${$month_name}['salary'] = 0;
		}
			
	}
	
		
	$temp = mysql_query("SELECT `money2` FROM correspondence WHERE `name`='current_people'");
	$result = mysql_fetch_array($temp);
	$finance_salary = $result[0];
		
	$temp = mysql_query("SELECT `money3` FROM correspondence WHERE `name`='current_people'");
	$result = mysql_fetch_array($temp);
	$equip_salary = $result[0];
		
	$temp = mysql_query("SELECT `money` FROM correspondence WHERE `name`='current_people_2'");
	$result = mysql_fetch_array($temp);
	$sale_salary = $result[0];
		
	$temp = mysql_query("SELECT `money2` FROM correspondence WHERE `name`='current_people_2'");
	$result = mysql_fetch_array($temp);
	$human_salary = $result[0];
		
	$temp = mysql_query("SELECT `money3` FROM correspondence WHERE `name`='current_people_2'");
	$result = mysql_fetch_array($temp);
	$research_salary = $result[0];
	
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
    
    
    
<!------------------bootstrapcarousel----------------------->

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" style="margin:20px 0;">

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <table class="table table-bordered table-striped text-center">
        <tr class="success">
            <th class="text-center">月份</th>
            <th class="text-center">生產人員</th>
            <th class="text-center">行政人員</th>
        </tr>
        <tbody>
        <tr>
            <td>薪水(月)</td>
            <td><?php echo number_format($equip_salary); ?></td>
            <td><?php echo number_format($human_salary); ?></td>
        </tr>
        <tr>
            <td>一月</td>
            <td><input id="m1e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month1(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m1h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month1(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>二月</td>
            <td><input id="m2e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month2(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m2h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month2(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>三月</td>
            <td><input id="m3e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month3(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m3h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month3(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>四月</td>
            <td><input id="m4e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month4(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m4h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month4(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>五月</td>
            <td><input id="m5e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month5(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m5h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month5(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>六月</td>
            <td><input id="m6e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month6(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m6h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month6(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>七月</td>
            <td><input id="m7e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month7(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m7h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month7(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>八月</td>
            <td><input id="m8e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month8(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m8h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month8(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>九月</td>
            <td><input id="m9e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month9(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m9h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month9(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十月</td>
            <td><input id="m10e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month10(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m10h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month10(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十一月</td>
            <td><input id="m11e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month11(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m11h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month11(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十二月</td>
            <td><input id="m12e" class="form-control text-center" type="text" placeholder="0" value="" onblur="month12(),equip()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m12h" class="form-control text-center" type="text" placeholder="0" value="" onblur="month12(),human()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>總合</td>
            <td id="total_equip">0</td>
            <td id="total_human">0</td>
        </tr>
        </tbody>    
    </table>
    </div>
    <div class="item">
     <table class="table table-bordered table-striped text-center">
        <tr class="success">
            <th class="text-center">月份</th>
            <th class="text-center">研發團隊(每隊)</th>
            <th class="text-center">業務人員</th>
        </tr>
        <tbody>
        <tr>
            <td>薪水(月)</td>
            <td><?php echo number_format($research_salary*5); ?></td>
            <td><?php echo number_format($sale_salary); ?></td>
        </tr>
        <tr>
            <td>一月</td>
            <td><input id="m1r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month1(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m1s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month1(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>二月</td>
            <td><input id="m2r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month2(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m2s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month2(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>三月</td>
            <td><input id="m3r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month3(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m3s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month3(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>四月</td>
            <td><input id="m4r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month4(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m4s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month4(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>五月</td>
            <td><input id="m5r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month5(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m5s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month5(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>六月</td>
            <td><input id="m6r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month6(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m6s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month6(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>七月</td>
            <td><input id="m7r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month7(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m7s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month7(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>八月</td>
            <td><input id="m8r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month8(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m8s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month8(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>九月</td>
            <td><input id="m9r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month9(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m9s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month9(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十月</td>
            <td><input id="m10r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month10(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m10s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month10(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十一月</td>
            <td><input id="m11r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month11(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m11s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month11(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>十二月</td>
            <td><input id="m12r" class="form-control text-center" type="text" placeholder="0" value="" onblur="month12(),research()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td><input id="m12s" class="form-control text-center" type="text" placeholder="0" value="" onblur="month12(),sale()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
        </tr>
        <tr>
            <td>總合</td>
            <td id="total_research">0</td>
            <td id="total_sale">0</td>
        </tr>
        </tbody>    
    </table>
    </div>
    <div class="item">
             <table class="table table-bordered table-striped text-center">
        <tr class="success">
            <th class="text-center">月份</th>
            <th class="text-center">財務人員</th>
            <th class="text-center">該梯花費</th>
        </tr>
        <tbody>
        <tr>
            <td>薪水(月)</td>
            <td><?php echo number_format($finance_salary); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>一月</td>
            <td><input id="m1f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month1(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m1sa">0</td>
        </tr>
        <tr>
            <td>二月</td>
            <td><input id="m2f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month2(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m2sa">0</td>
        </tr>
        <tr>
            <td>三月</td>
            <td><input id="m3f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month3(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m3sa">0</td>
        </tr>
        <tr>
            <td>四月</td>
            <td><input id="m4f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month4(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m4sa">0</td>
        </tr>
        <tr>
            <td>五月</td>
            <td><input id="m5f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month5(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m5sa">0</td>
        </tr>
        <tr>
            <td>六月</td>
            <td><input id="m6f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month6(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m6sa">0</td>
        </tr>
        <tr>
            <td>七月</td>
            <td><input id="m7f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month7(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m7sa">0</td>
        </tr>
        <tr>
            <td>八月</td>
            <td><input id="m8f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month8(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m8sa">0</td>
        </tr>
        <tr>
            <td>九月</td>
            <td><input id="m9f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month9(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m9sa">0</td>
        </tr>
        <tr>
            <td>十月</td>
            <td><input id="m10f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month10(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m10sa">0</td>
        </tr>
        <tr>
            <td>十一月</td>
            <td><input id="m11f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month11(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m11sa">0</td>
        </tr>
        <tr>
            <td>十二月</td>
            <td><input id="m12f" class="form-control text-center" type="text" placeholder="0" value="" onblur="month12(),finance()" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td id="m12sa">0</td>
        </tr>
        <tr>
            <td>總合</td>
            <td id="total_finance">0</td>
            <td id="total_salary">0</td>
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
    
<!---------------------------submitbutton-------------------->
    <div class="col-sm-12 text-center">
    <input id="sub" type="submit" class="btn btn-primary btn-lg" >
    </div>
    
    
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.js"></script>
    <script type="text/javascript">

var m1e = m2e = m3e = m4e = m5e = m6e = m7e = m8e = m9e = m10e = m11e = m12e = 0;
var m1h = m2h = m3h = m4h = m5h = m6h = m7h = m8h = m9h = m10h = m11h = m12h = 0;
var m1r = m2r = m3r = m4r = m5r = m6r = m7r = m8r = m9r = m10r = m11r = m12r = 0;
var m1s = m2s = m3s = m4s = m5s = m6s = m7s = m8s = m9s = m10s = m11s = m12s = 0;
var m1f = m2f = m3f = m4f = m5f = m6f = m7f = m8f = m9f = m10f = m11f = m12f = 0;
var m1sa = m2sa = m3sa = m4sa = m5sa = m6sa = m7sa = m8sa = m9sa = m10sa = m11sa = m12sa = 0;
var total_equip = total_human = total_research = total_sale = total_finance = total_salary = 0;
var equip_salary = <?php echo $equip_salary; ?>;
var human_salary = <?php echo $human_salary; ?>;
var research_salary = <?php echo $research_salary * 5; ?>;
var sale_salary = <?php echo $sale_salary; ?>;
var finance_salary = <?php echo $finance_salary; ?>;



$(document).ready(function() {
    
	document.getElementById("m1e").value = <?php echo $month1['equip']; ?>;
	document.getElementById("m1h").value = <?php echo $month1['human']; ?>;
	document.getElementById("m1r").value = <?php echo $month1['research']; ?>;
	document.getElementById("m1s").value = <?php echo $month1['sale']; ?>;
	document.getElementById("m1f").value = <?php echo $month1['finance']; ?>;
	document.getElementById("m1sa").innerHTML = <?php echo number_format($month1['salary']); ?>;
	
	document.getElementById("m2e").value = <?php echo $month2['equip']; ?>;
	document.getElementById("m2h").value = <?php echo $month2['human']; ?>;
	document.getElementById("m2r").value = <?php echo $month2['research']; ?>;
	document.getElementById("m2s").value = <?php echo $month2['sale']; ?>;
	document.getElementById("m2f").value = <?php echo $month2['finance']; ?>;
	document.getElementById("m2sa").innerHTML = <?php echo number_format($month2['salary']); ?>;
	
	document.getElementById("m3e").value = <?php echo $month3['equip']; ?>;
	document.getElementById("m3h").value = <?php echo $month3['human']; ?>;
	document.getElementById("m3r").value = <?php echo $month3['research']; ?>;
	document.getElementById("m3s").value = <?php echo $month3['sale']; ?>;
	document.getElementById("m3f").value = <?php echo $month3['finance']; ?>;
	document.getElementById("m3sa").innerHTML = <?php echo number_format($month3['salary']); ?>;
	
	document.getElementById("m4e").value = <?php echo $month4['equip']; ?>;
	document.getElementById("m4h").value = <?php echo $month4['human']; ?>;
	document.getElementById("m4r").value = <?php echo $month4['research']; ?>;
	document.getElementById("m4s").value = <?php echo $month4['sale']; ?>;
	document.getElementById("m4f").value = <?php echo $month4['finance']; ?>;
	document.getElementById("m4sa").innerHTML = <?php echo number_format($month4['salary']); ?>;
	
	document.getElementById("m5e").value = <?php echo $month5['equip']; ?>;
	document.getElementById("m5h").value = <?php echo $month5['human']; ?>;
	document.getElementById("m5r").value = <?php echo $month5['research']; ?>;
	document.getElementById("m5s").value = <?php echo $month5['sale']; ?>;
	document.getElementById("m5f").value = <?php echo $month5['finance']; ?>;
	document.getElementById("m5sa").innerHTML = <?php echo number_format($month5['salary']); ?>;
	
	document.getElementById("m6e").value = <?php echo $month6['equip']; ?>;
	document.getElementById("m6h").value = <?php echo $month6['human']; ?>;
	document.getElementById("m6r").value = <?php echo $month6['research']; ?>;
	document.getElementById("m6s").value = <?php echo $month6['sale']; ?>;
	document.getElementById("m6f").value = <?php echo $month6['finance']; ?>;
	document.getElementById("m6sa").innerHTML = <?php echo number_format($month6['salary']); ?>;
	
	document.getElementById("m7e").value = <?php echo $month7['equip']; ?>;
	document.getElementById("m7h").value = <?php echo $month7['human']; ?>;
	document.getElementById("m7r").value = <?php echo $month7['research']; ?>;
	document.getElementById("m7s").value = <?php echo $month7['sale']; ?>;
	document.getElementById("m7f").value = <?php echo $month7['finance']; ?>;
	document.getElementById("m7sa").innerHTML = <?php echo number_format($month7['salary']); ?>;
	
	document.getElementById("m8e").value = <?php echo $month8['equip']; ?>;
	document.getElementById("m8h").value = <?php echo $month8['human']; ?>;
	document.getElementById("m8r").value = <?php echo $month8['research']; ?>;
	document.getElementById("m8s").value = <?php echo $month8['sale']; ?>;
	document.getElementById("m8f").value = <?php echo $month8['finance']; ?>;
	document.getElementById("m8sa").innerHTML = <?php echo number_format($month8['salary']); ?>;
	
	document.getElementById("m9e").value = <?php echo $month9['equip']; ?>;
	document.getElementById("m9h").value = <?php echo $month9['human']; ?>;
	document.getElementById("m9r").value = <?php echo $month9['research']; ?>;
	document.getElementById("m9s").value = <?php echo $month9['sale']; ?>;
	document.getElementById("m9f").value = <?php echo $month9['finance']; ?>;
	document.getElementById("m9sa").innerHTML = <?php echo number_format($month9['salary']); ?>;
	
	document.getElementById("m10e").value = <?php echo $month10['equip']; ?>;
	document.getElementById("m10h").value = <?php echo $month10['human']; ?>;
	document.getElementById("m10r").value = <?php echo $month10['research']; ?>;
	document.getElementById("m10s").value = <?php echo $month10['sale']; ?>;
	document.getElementById("m10f").value = <?php echo $month10['finance']; ?>;
	document.getElementById("m10sa").innerHTML = <?php echo number_format($month10['salary']); ?>;
	
	document.getElementById("m11e").value = <?php echo $month11['equip']; ?>;
	document.getElementById("m11h").value = <?php echo $month11['human']; ?>;
	document.getElementById("m11r").value = <?php echo $month11['research']; ?>;
	document.getElementById("m11s").value = <?php echo $month11['sale']; ?>;
	document.getElementById("m11f").value = <?php echo $month11['finance']; ?>;
	document.getElementById("m11sa").innerHTML = <?php echo number_format($month11['salary']); ?>;
	
	document.getElementById("m12e").value = <?php echo $month12['equip']; ?>;
	document.getElementById("m12h").value = <?php echo $month12['human']; ?>;
	document.getElementById("m12r").value = <?php echo $month12['research']; ?>;
	document.getElementById("m12s").value = <?php echo $month12['sale']; ?>;
	document.getElementById("m12f").value = <?php echo $month12['finance']; ?>;
	document.getElementById("m12sa").innerHTML = <?php echo number_format($month12['salary']); ?>;
	
	month1();
	month2();
	month3();
	month4();
	month5();
	month6();
	month7();
	month8();
	month9();
	month10();
	month11();
	month12();
	
	equip();
	human();
	research();
	sale();
	finance();
	
	
	
	$('#sub').click(function(){
		
		m1e = parseInt(document.getElementById("m1e").value);
		m1h = parseInt(document.getElementById("m1h").value);
		m1r = parseInt(document.getElementById("m1r").value);
		m1s = parseInt(document.getElementById("m1s").value);
		m1f = parseInt(document.getElementById("m1f").value);
		m2e = parseInt(document.getElementById("m2e").value);
		m2h = parseInt(document.getElementById("m2h").value);
		m2r = parseInt(document.getElementById("m2r").value);
		m2s = parseInt(document.getElementById("m2s").value);
		m2f = parseInt(document.getElementById("m2f").value);
		m3e = parseInt(document.getElementById("m3e").value);
		m3h = parseInt(document.getElementById("m3h").value);
		m3r = parseInt(document.getElementById("m3r").value);
		m3s = parseInt(document.getElementById("m3s").value);
		m3f = parseInt(document.getElementById("m3f").value);
		m4e = parseInt(document.getElementById("m4e").value);
		m4h = parseInt(document.getElementById("m4h").value);
		m4r = parseInt(document.getElementById("m4r").value);
		m4s = parseInt(document.getElementById("m4s").value);
		m4f = parseInt(document.getElementById("m4f").value);
		m5e = parseInt(document.getElementById("m5e").value);
		m5h = parseInt(document.getElementById("m5h").value);
		m5r = parseInt(document.getElementById("m5r").value);
		m5s = parseInt(document.getElementById("m5s").value);
		m5f = parseInt(document.getElementById("m5f").value);
		m6e = parseInt(document.getElementById("m6e").value);
		m6h = parseInt(document.getElementById("m6h").value);
		m6r = parseInt(document.getElementById("m6r").value);
		m6s = parseInt(document.getElementById("m6s").value);
		m6f = parseInt(document.getElementById("m6f").value);
		m7e = parseInt(document.getElementById("m7e").value);
		m7h = parseInt(document.getElementById("m7h").value);
		m7r = parseInt(document.getElementById("m7r").value);
		m7s = parseInt(document.getElementById("m7s").value);
		m7f = parseInt(document.getElementById("m7f").value);
		m8e = parseInt(document.getElementById("m8e").value);
		m8h = parseInt(document.getElementById("m8h").value);
		m8r = parseInt(document.getElementById("m8r").value);
		m8s = parseInt(document.getElementById("m8s").value);
		m8f = parseInt(document.getElementById("m8f").value);
		m9e = parseInt(document.getElementById("m9e").value);
		m9h = parseInt(document.getElementById("m9h").value);
		m9r = parseInt(document.getElementById("m9r").value);
		m9s = parseInt(document.getElementById("m9s").value);
		m9f = parseInt(document.getElementById("m9f").value);
		m10e = parseInt(document.getElementById("m10e").value);
		m10h = parseInt(document.getElementById("m10h").value);
		m10r = parseInt(document.getElementById("m10r").value);
		m10s = parseInt(document.getElementById("m10s").value);
		m10f = parseInt(document.getElementById("m10f").value);
		m11e = parseInt(document.getElementById("m11e").value);
		m11h = parseInt(document.getElementById("m11h").value);
		m11r = parseInt(document.getElementById("m11r").value);
		m11s = parseInt(document.getElementById("m11s").value);
		m11f = parseInt(document.getElementById("m11f").value);
		m12e = parseInt(document.getElementById("m12e").value);
		m12h = parseInt(document.getElementById("m12h").value);
		m12r = parseInt(document.getElementById("m12r").value);
		m12s = parseInt(document.getElementById("m12s").value);
		m12f = parseInt(document.getElementById("m12f").value);
		
		
		
		$.ajax({
			url:"Budget_DB.php",
			type:"GET",
			dataType:"html",
			data:
			{
			
			type:"human" ,
			m1e:m1e , m2e:m2e , m3e:m3e , m4e:m4e , m5e:m5e , m6e:m6e , 
			m7e:m7e , m8e:m8e , m9e:m9e , m10e:m10e , m11e:m11e , m12e:m12e	,
			m1h:m1h , m2h:m2h , m3h:m3h , m4h:m4h , m5h:m5h , m6h:m6h , 
			m7h:m7h , m8h:m8h , m9h:m9h , m10h:m10h , m11h:m11h , m12h:m12h	,
			m1r:m1r , m2r:m2r , m3r:m3r , m4r:m4r , m5r:m5r , m6r:m6r , 
			m7r:m7r , m8r:m8r , m9r:m9r , m10r:m10r , m11r:m11r , m12r:m12r	,
			m1s:m1s , m2s:m2s , m3s:m3s , m4s:m4s , m5s:m5s , m6s:m6s , 
			m7s:m7s , m8s:m8s , m9s:m9s , m10s:m10s , m11s:m11s , m12s:m12s	,
			m1f:m1f , m2f:m2f , m3f:m3f , m4f:m4f , m5f:m5f , m6f:m6f , 
			m7f:m7f , m8f:m8f , m9f:m9f , m10f:m10f , m11f:m11f , m12f:m12f	,
			m1sa:m1sa , m2sa:m2sa , m3sa:m3sa , m4sa:m4sa , m5sa:m5sa , m6sa:m6sa , 
			m7sa:m7sa , m8sa:m8sa , m9sa:m9sa , m10sa:m10sa , m11sa:m11sa , m12sa:m12sa	
			
			}
			,
			error: function(){
				alert("error1");
			},
			success: function(){
				alert("success");
			}
		});
		
	});
	
	
});//end of ready function


//每列加總計算
function month1(){
	
	m1e = parseInt(document.getElementById("m1e").value);
	m1h = parseInt(document.getElementById("m1h").value);
	m1r = parseInt(document.getElementById("m1r").value);
	m1s = parseInt(document.getElementById("m1s").value);
	m1f = parseInt(document.getElementById("m1f").value);
	
	m1e = m1e * equip_salary * 12;
	m1h = m1h * human_salary * 12;
	m1r = m1r * research_salary * 12;
	m1s = m1s * sale_salary * 12;
	m1f = m1f * finance_salary * 12;
	
	m1sa = m1e + m1h + m1r + m1s + m1f;
	document.getElementById("m1sa").innerHTML = addCommas(m1sa);
}

function month2(){
	
	m2e = parseInt(document.getElementById("m2e").value);
	m2h = parseInt(document.getElementById("m2h").value);
	m2r = parseInt(document.getElementById("m2r").value);
	m2s = parseInt(document.getElementById("m2s").value);
	m2f = parseInt(document.getElementById("m2f").value);
	
	m2e = m2e * equip_salary * 11;
	m2h = m2h * human_salary * 11;
	m2r = m2r * research_salary * 11;
	m2s = m2s * sale_salary * 11;
	m2f = m2f * finance_salary * 11;
	
	m2sa = m2e + m2h + m2r + m2s + m2f;
	document.getElementById("m2sa").innerHTML = addCommas(m2sa);
	
}

function month3(){
	
	m3e = parseInt(document.getElementById("m3e").value);
	m3h = parseInt(document.getElementById("m3h").value);
	m3r = parseInt(document.getElementById("m3r").value);
	m3s = parseInt(document.getElementById("m3s").value);
	m3f = parseInt(document.getElementById("m3f").value);
	
	m3e = m3e * equip_salary * 10;
	m3h = m3h * human_salary * 10;
	m3r = m3r * research_salary * 10;
	m3s = m3s * sale_salary * 10;
	m3f = m3f * finance_salary * 10;
	
	m3sa = m3e + m3h + m3r + m3s + m3f;
	document.getElementById("m3sa").innerHTML = addCommas(m3sa);
	
}

function month4(){
	
	m4e = parseInt(document.getElementById("m4e").value);
	m4h = parseInt(document.getElementById("m4h").value);
	m4r = parseInt(document.getElementById("m4r").value);
	m4s = parseInt(document.getElementById("m4s").value);
	m4f = parseInt(document.getElementById("m4f").value);
	
	m4e = m4e * equip_salary * 9;
	m4h = m4h * human_salary * 9;
	m4r = m4r * research_salary * 9;
	m4s = m4s * sale_salary * 9;
	m4f = m4f * finance_salary * 9;
	
	m4sa = m4e + m4h + m4r + m4s + m4f;
	document.getElementById("m4sa").innerHTML = addCommas(m4sa);
	
}

function month5(){
	
	m5e = parseInt(document.getElementById("m5e").value);
	m5h = parseInt(document.getElementById("m5h").value);
	m5r = parseInt(document.getElementById("m5r").value);
	m5s = parseInt(document.getElementById("m5s").value);
	m5f = parseInt(document.getElementById("m5f").value);
	
	m5e = m5e * equip_salary * 8;
	m5h = m5h * human_salary * 8;
	m5r = m5r * research_salary * 8;
	m5s = m5s * sale_salary * 8;
	m5f = m5f * finance_salary * 8;
	
	m5sa = m5e + m5h + m5r + m5s + m5f;
	document.getElementById("m5sa").innerHTML = addCommas(m5sa);
	
}

function month6(){
	
	m6e = parseInt(document.getElementById("m6e").value);
	m6h = parseInt(document.getElementById("m6h").value);
	m6r = parseInt(document.getElementById("m6r").value);
	m6s = parseInt(document.getElementById("m6s").value);
	m6f = parseInt(document.getElementById("m6f").value);
	
	m6e = m6e * equip_salary * 7;
	m6h = m6h * human_salary * 7;
	m6r = m6r * research_salary * 7;
	m6s = m6s * sale_salary * 7;
	m6f = m6f * finance_salary * 7;
	
	m6sa = m6e + m6h + m6r + m6s + m6f;
	document.getElementById("m6sa").innerHTML = addCommas(m6sa);
	
}

function month7(){
	
	m7e = parseInt(document.getElementById("m7e").value);
	m7h = parseInt(document.getElementById("m7h").value);
	m7r = parseInt(document.getElementById("m7r").value);
	m7s = parseInt(document.getElementById("m7s").value);
	m7f = parseInt(document.getElementById("m7f").value);
	
	m7e = m7e * equip_salary * 6;
	m7h = m7h * human_salary * 6;
	m7r = m7r * research_salary * 6;
	m7s = m7s * sale_salary * 6;
	m7f = m7f * finance_salary * 6;
	
	m7sa = m7e + m7h + m7r + m7s + m7f;
	document.getElementById("m7sa").innerHTML = addCommas(m7sa);
	
}

function month8(){
	
	m8e = parseInt(document.getElementById("m8e").value);
	m8h = parseInt(document.getElementById("m8h").value);
	m8r = parseInt(document.getElementById("m8r").value);
	m8s = parseInt(document.getElementById("m8s").value);
	m8f = parseInt(document.getElementById("m8f").value);
	
	m8e = m8e * equip_salary * 5;
	m8h = m8h * human_salary * 5;
	m8r = m8r * research_salary * 5;
	m8s = m8s * sale_salary * 5;
	m8f = m8f * finance_salary * 5;
	
	m8sa = m8e + m8h + m8r + m8s + m8f;
	document.getElementById("m8sa").innerHTML = addCommas(m8sa);
	
}

function month9(){
	
	m9e = parseInt(document.getElementById("m9e").value);
	m9h = parseInt(document.getElementById("m9h").value);
	m9r = parseInt(document.getElementById("m9r").value);
	m9s = parseInt(document.getElementById("m9s").value);
	m9f = parseInt(document.getElementById("m9f").value);
	
	m9e = m9e * equip_salary * 4;
	m9h = m9h * human_salary * 4;
	m9r = m9r * research_salary * 4;
	m9s = m9s * sale_salary * 4;
	m9f = m9f * finance_salary * 4;
	
	m9sa = m9e + m9h + m9r + m9s + m9f;
	document.getElementById("m9sa").innerHTML = addCommas(m9sa);
	
}

function month10(){
	
	m10e = parseInt(document.getElementById("m10e").value);
	m10h = parseInt(document.getElementById("m10h").value);
	m10r = parseInt(document.getElementById("m10r").value);
	m10s = parseInt(document.getElementById("m10s").value);
	m10f = parseInt(document.getElementById("m10f").value);
	
	m10e = m10e * equip_salary * 3;
	m10h = m10h * human_salary * 3;
	m10r = m10r * research_salary * 3;
	m10s = m10s * sale_salary * 3;
	m10f = m10f * finance_salary * 3;
	
	m10sa = m10e + m10h + m10r + m10s + m10f;
	document.getElementById("m10sa").innerHTML = addCommas(m10sa);
	
}

function month11(){
	
	m11e = parseInt(document.getElementById("m11e").value);
	m11h = parseInt(document.getElementById("m11h").value);
	m11r = parseInt(document.getElementById("m11r").value);
	m11s = parseInt(document.getElementById("m11s").value);
	m11f = parseInt(document.getElementById("m11f").value);
	
	m11e = m11e * equip_salary * 2;
	m11h = m11h * human_salary * 2;
	m11r = m11r * research_salary * 2;
	m11s = m11s * sale_salary * 2;
	m11f = m11f * finance_salary * 2;
	
	m11sa = m11e + m11h + m11r + m11s + m11f;
	document.getElementById("m11sa").innerHTML = addCommas(m11sa);
	
}

function month12(){
	
	m12e = parseInt(document.getElementById("m12e").value);
	m12h = parseInt(document.getElementById("m12h").value);
	m12r = parseInt(document.getElementById("m12r").value);
	m12s = parseInt(document.getElementById("m12s").value);
	m12f = parseInt(document.getElementById("m12f").value);
	
	m12e = m12e * equip_salary * 1;
	m12h = m12h * human_salary * 1;
	m12r = m12r * research_salary * 1;
	m12s = m12s * sale_salary * 1;
	m12f = m12f * finance_salary * 1;
	
	m12sa = m12e + m12h + m12r + m12s + m12f;
	document.getElementById("m12sa").innerHTML = addCommas(m12sa);
	
}
//每欄加總
function equip(){
	
	m1e = document.getElementById("m1e").value;
	m2e = document.getElementById("m2e").value;
	m3e = document.getElementById("m3e").value;
	m4e = document.getElementById("m4e").value;
	m5e = document.getElementById("m5e").value;
	m6e = document.getElementById("m6e").value;
	m7e = document.getElementById("m7e").value;
	m8e = document.getElementById("m8e").value;
	m9e = document.getElementById("m9e").value;
	m10e = document.getElementById("m10e").value;
	m11e = document.getElementById("m11e").value;
	m12e = document.getElementById("m12e").value;
	total_equip = parseInt(m1e) + parseInt(m2e) + parseInt(m3e) + parseInt(m4e) + parseInt(m5e) + parseInt(m6e) + parseInt(m7e) + parseInt(m8e) + parseInt(m9e) + parseInt(m10e) + parseInt(m11e) + parseInt(m12e);
	
	document.getElementById("total_equip").innerHTML = addCommas(total_equip);
	sum_salary()
	
	
}

function human(){
	
	m1h = document.getElementById("m1h").value;
	m2h = document.getElementById("m2h").value;
	m3h = document.getElementById("m3h").value;
	m4h = document.getElementById("m4h").value;
	m5h = document.getElementById("m5h").value;
	m6h = document.getElementById("m6h").value;
	m7h = document.getElementById("m7h").value;
	m8h = document.getElementById("m8h").value;
	m9h = document.getElementById("m9h").value;
	m10h = document.getElementById("m10h").value;
	m11h = document.getElementById("m11h").value;
	m12h = document.getElementById("m12h").value;
	total_human = parseInt(m1h) + parseInt(m2h) + parseInt(m3h) + parseInt(m4h) + parseInt(m5h) + parseInt(m6h) + parseInt(m7h) + parseInt(m8h) + parseInt(m9h) + parseInt(m10h) + parseInt(m11h) + parseInt(m12h);
	
	document.getElementById("total_human").innerHTML = addCommas(total_human);
	sum_salary()
}

function research(){
	
	m1r = document.getElementById("m1r").value;
	m2r = document.getElementById("m2r").value;
	m3r = document.getElementById("m3r").value;
	m4r = document.getElementById("m4r").value;
	m5r = document.getElementById("m5r").value;
	m6r = document.getElementById("m6r").value;
	m7r = document.getElementById("m7r").value;
	m8r = document.getElementById("m8r").value;
	m9r = document.getElementById("m9r").value;
	m10r = document.getElementById("m10r").value;
	m11r = document.getElementById("m11r").value;
	m12r = document.getElementById("m12r").value;
	total_research = parseInt(m1r) + parseInt(m2r) + parseInt(m3r) + parseInt(m4r) + parseInt(m5r) + parseInt(m6r) + parseInt(m7r) + parseInt(m8r) + parseInt(m9r) + parseInt(m10r) + parseInt(m11r) + parseInt(m12r);
	
	document.getElementById("total_research").innerHTML = addCommas(total_research);
	sum_salary()
}

function sale(){
	
	m1s = document.getElementById("m1s").value;
	m2s = document.getElementById("m2s").value;
	m3s = document.getElementById("m3s").value;
	m4s = document.getElementById("m4s").value;
	m5s = document.getElementById("m5s").value;
	m6s = document.getElementById("m6s").value;
	m7s = document.getElementById("m7s").value;
	m8s = document.getElementById("m8s").value;
	m9s = document.getElementById("m9s").value;
	m10s = document.getElementById("m10s").value;
	m11s = document.getElementById("m11s").value;
	m12s = document.getElementById("m12s").value;
	total_sale = parseInt(m1s) + parseInt(m2s) + parseInt(m3s) + parseInt(m4s) + parseInt(m5s) + parseInt(m6s) + parseInt(m7s) + parseInt(m8s) + parseInt(m9s) + parseInt(m10s) + parseInt(m11s) + parseInt(m12s);
	
	document.getElementById("total_sale").innerHTML = addCommas(total_sale);
	sum_salary()
}

function finance(){
	
	m1f = document.getElementById("m1f").value;
	m2f = document.getElementById("m2f").value;
	m3f = document.getElementById("m3f").value;
	m4f = document.getElementById("m4f").value;
	m5f = document.getElementById("m5f").value;
	m6f = document.getElementById("m6f").value;
	m7f = document.getElementById("m7f").value;
	m8f = document.getElementById("m8f").value;
	m9f = document.getElementById("m9f").value;
	m10f = document.getElementById("m10f").value;
	m11f = document.getElementById("m11f").value;
	m12f = document.getElementById("m12f").value;
	total_finance = parseInt(m1f) + parseInt(m2f) + parseInt(m3f) + parseInt(m4f) + parseInt(m5f) + parseInt(m6f) + parseInt(m7f) + parseInt(m8f) + parseInt(m9f) + parseInt(m10f) + parseInt(m11f) + parseInt(m12f);
	
	document.getElementById("total_finance").innerHTML = addCommas(total_finance);
	sum_salary()
}

//總花費加總
function sum_salary(){
	//使用每月計算出來的sa值(尚末加過commas)
	total_salary = parseInt(m1sa) + parseInt(m2sa) + parseInt(m3sa) + parseInt(m4sa) + parseInt(m5sa) + parseInt(m6sa) + parseInt(m7sa) + parseInt(m8sa) + parseInt(m9sa) + parseInt(m10sa) + parseInt(m11sa) + parseInt(m12sa);
	
	document.getElementById("total_salary").innerHTML = addCommas(total_salary);
	
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