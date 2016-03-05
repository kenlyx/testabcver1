<?php @session_start(); ?>
<?php
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$month=$_SESSION['month'];
    $year=$_SESSION['year'];
	error_reporting(0);
	
	if($_GET['type']=='finance'){
		mysql_query("UPDATE `budget` SET `sell_A`={$_GET['sell_A']} , `sell_B`={$_GET['sell_B']} , `internet_A`={$_GET['internet_A']} , `TV_A`={$_GET['TV_A']} , `magazine_A`={$_GET['mag_A']} , `func1_A`={$_GET['func1_A']} , `func2_A`={$_GET['func2_A']} , `func3_A`={$_GET['func3_A']} , `internet_B`={$_GET['internet_B']} , `TV_B`={$_GET['TV_B']} , `magazine_B`={$_GET['mag_B']} , `func1_B`={$_GET['func1_B']} , `func2_B`={$_GET['func2_B']} , `func3_B`={$_GET['func3_B']} WHERE `year`='$year' AND `cid`='$cid'");
	}
	elseif($_GET['type']=='produce'){
		mysql_query("UPDATE `budget` SET `produce_A`={$_GET['f_pro_A']} , `produce_B`={$_GET['f_pro_B']} WHERE `year`='$year' AND `cid`='$cid'");
	}
	elseif($_GET['type']=='purchase'){
		mysql_query("UPDATE `budget` SET `purchase_p`={$_GET['p_panel']} , `purchase_k`={$_GET['p_kernel']} , `purchase_kb`={$_GET['p_keyboard']} WHERE `year`='$year' AND `cid`='$cid'");
	}
	elseif($_GET['type']=='admin'){
		mysql_query("UPDATE `budget` SET `rd_A`={$_GET['rd_A']} , `rd_B`={$_GET['rd_B']} , `p_mc_A`={$_GET['p_mc_A']} , `p_mc_B`={$_GET['p_mc_B']} , `p_mc_C`={$_GET['p_mc_C']} , `p_m1_A`={$_GET['p_m1_A']} , `p_m1_B`={$_GET['p_m1_B']} , `p_m1_C`={$_GET['p_m1_C']} , `p_m2_A`={$_GET['p_m2_A']} , `p_m2_B`={$_GET['p_m2_B']} , `p_m2_C`={$_GET['p_m2_C']} , `p_mcheck`={$_GET['p_mcheck']} , `p_mchecks`={$_GET['p_mchecks']} , `fund_raising`={$_GET['fund_raising']} , `cash_divide`={$_GET['cash_divide']} , `S_borrow`={$_GET['S_borrow']} , `L_borrow`={$_GET['L_borrow']}  WHERE `year`='$year' AND `cid`='$cid'");
	}
	elseif($_GET['type']=='human'){
		
		mysql_query("DELETE FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
		
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',1,{$_GET['m1e']},{$_GET['m1h']},{$_GET['m1r']},{$_GET['m1s']},{$_GET['m1f']},{$_GET['m1sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',2,{$_GET['m2e']},{$_GET['m2h']},{$_GET['m2r']},{$_GET['m2s']},{$_GET['m2f']},{$_GET['m2sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',3,{$_GET['m3e']},{$_GET['m3h']},{$_GET['m3r']},{$_GET['m3s']},{$_GET['m3f']},{$_GET['m3sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',4,{$_GET['m4e']},{$_GET['m4h']},{$_GET['m4r']},{$_GET['m4s']},{$_GET['m4f']},{$_GET['m4sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',5,{$_GET['m5e']},{$_GET['m5h']},{$_GET['m5r']},{$_GET['m5s']},{$_GET['m5f']},{$_GET['m5sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',6,{$_GET['m6e']},{$_GET['m6h']},{$_GET['m6r']},{$_GET['m6s']},{$_GET['m6f']},{$_GET['m6sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',7,{$_GET['m7e']},{$_GET['m7h']},{$_GET['m7r']},{$_GET['m7s']},{$_GET['m7f']},{$_GET['m7sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',8,{$_GET['m8e']},{$_GET['m8h']},{$_GET['m8r']},{$_GET['m8s']},{$_GET['m8f']},{$_GET['m8sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',9,{$_GET['m9e']},{$_GET['m9h']},{$_GET['m9r']},{$_GET['m9s']},{$_GET['m9f']},{$_GET['m9sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',10,{$_GET['m10e']},{$_GET['m10h']},{$_GET['m10r']},{$_GET['m10s']},{$_GET['m10f']},{$_GET['m10sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',11,{$_GET['m11e']},{$_GET['m11h']},{$_GET['m11r']},{$_GET['m11s']},{$_GET['m11f']},{$_GET['m11sa']})"); 
		mysql_query("INSERT INTO `budget_hire` VALUES('$cid','$year',12,{$_GET['m12e']},{$_GET['m12h']},{$_GET['m12r']},{$_GET['m12s']},{$_GET['m12f']},{$_GET['m12sa']})"); 
		
		
	}
	
?>