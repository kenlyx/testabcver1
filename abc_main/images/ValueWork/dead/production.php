<?php
@session_start();
require_once("../connMysql.php");
mysql_select_db("testabc_main");
$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;
/*$_SESSION['productionplan_sumit']=0;
$_SESSION['productA_sumit']=0;
$_SESSION['productB_sumit']=0;*/
//生產防呆 在production表裡面加index 取MAX(index) 資料是否與cid year month相符合


//檢查是否已經研發
//NB_RD
    $sql_rdA=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_A_RD`='1' ");
	$rdA=mysql_fetch_array($sql_rdA);//研發過A的回合資料
	$rd_rowA=mysql_num_rows($sql_rdA);
	//echo $rd_rowA;
//Tablet_RD
	$sql_rdB=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_B_RD`='1' ");
	$rdB=mysql_fetch_array($sql_rdB);//研發過B的回合資料
	$rd_rowB=mysql_num_rows($sql_rdB);

	//if($rd_rowA==1){}
	//if($rd_rowB==1){}





//檢查是否有進行過流程改良，若沒有，則警告
/*$check = "SELECT * FROM  process_improvement WHERE `cid` = '$cid' `year` = '$year' `month` = '$month' ";
$checkresult = mysql_query($check);
if (mysql_num_rows($checkresult)=0){
<script language="JavaScript">

window.alert('尚未進行流程改良，請先進行流程改良，才能進行生產規畫決策!!!');

</script>
header("Location: http://localhost/102abc/abc_main/ValueWork/process.php ");
};*/

//if ($checkresult['process']==null){
//echo "尚未進行流程改良，請先進行流程改良，才能進行生產規畫決策，系統將於5秒後為您跳轉";
//header("Location: http://localhost/102abc/abc_main/ValueWork/process.php ");


//header("refresh:4;URL='http://localhost/102abc/abc_main/ValueWork/process.php'");
//}
//計算原料庫存並更新總原料數量
$newmonth=$month-1;
    //$buymaterial = mysql_query("SELECT * SUM()FROM purchase_materials WHERE `cid`='$cid' AND `year`='$year' AND `month`='$newmonth'");
    
	//mysql_query("DELETE FROM `material_result` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");

	$buymaterial = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM purchase_materials WHERE `cid`='$cid'");// AND `year`='$year' AND `month`='$newmonth'");
	//$usematerial = mysql_query("SELECT SUM(`SupA_Monitor`),SUM(`SupB_Monitor`),SUM(`SupC_Monitor`),SUM(`SupA_Kernel`),SUM(`SupB_Kernel`),SUM(`SupC_Kernel`),SUM(`SupA_KeyBoard`),SUM(`SupB_KeyBoard`),SUM(`SupC_KeyBoard`) FROM production WHERE `cid`='$cid' ");//AND `year`='$year' AND `month`='$newmonth'");
    
	$useA_material = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM product_a WHERE `cid`='$cid'");// AND `year`='$year' AND `month`='$newmonth'");

	$useB_material = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`)
FROM product_b WHERE `cid`='$cid'");// AND `year`='$year' AND `month`='$newmonth'");

	$row = mysql_fetch_array($buymaterial);
    $rowA = mysql_fetch_array($useA_material);
	$rowB = mysql_fetch_array($useB_material);

	 	 	 	
	
	
    $ma_suppliera=$row[0]-$rowA[0]-$rowB[0];
	$ma_supplierb=$row[1]-$rowA[1]-$rowB[1];
	$ma_supplierc=$row[2]-$rowA[2]-$rowB[2];
	$mb_suppliera=$row[3]-$rowA[3]-$rowB[3];
	$mb_supplierb=$row[4]-$rowA[4]-$rowB[4];
	$mb_supplierc=$row[5]-$rowA[5]-$rowB[5];
	$mc_suppliera=$row[6]-$rowA[6];
	$mc_supplierb=$row[7]-$rowA[7];
	$mc_supplierc=$row[8]-$rowA[8];
    $sum_ma = $ma_suppliera + $ma_supplierb + $ma_supplierc;
    $sum_mb = $mb_suppliera + $mb_supplierb + $mb_supplierc;
    $sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;
	//echo $mc_supplierc;
	mysql_query("INSERT INTO `material_result` (`cid`,`year`,`month`,`ma_sa`,`ma_sb`,`ma_sc`,`mb_sa`,`mb_sb`,`mb_sc`,`mc_sa`,`mc_sb`,`mc_sc`)
VALUES ('$cid' , $year, $month ,$ma_suppliera,$ma_supplierb,$ma_supplierc,$mb_suppliera,$mb_supplierb,$mb_supplierc,$mc_suppliera,$mc_supplierb,$mc_supplierc)");
	
	
	                  //  mysql_query("INSERT INTO `material_result` VALUES ($index,$year,$month,'$cid','A',$batch,$quality,$rank);");//, $connect);

	

 /*$ma_suppliera=$row['ma_supplier_a']-$row[''];
	$ma_supplierb=$row['ma_supplier_b'];
	$ma_supplierc=$row['ma_supplier_c'];
	$mb_suppliera=$row['mb_supplier_a'];
	$mb_supplierb=$row['mb_supplier_b'];
	$mb_supplierc=$row['mb_supplier_c'];
	$mc_suppliera=$row['mc_supplier_a'];
	$mc_supplierb=$row['mc_supplier_b'];
	$mc_supplierc=$row['mc_supplier_c'];
    $sum_ma = $ma_suppliera + $ma_supplierb + $ma_supplierc;
    $sum_mb = $mb_suppliera + $mb_supplierb + $mb_supplierc;
    $sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;*/



/*
$sum_query = "SELECT * FROM `production` WHERE `cid`='$cid'"; 
$row_resultM = mysql_fetch_array(mysql_query($sum_query));
//Monitor
$sum_Monitor_query = $row_resultM['SupA_Monitor']+$row_resultM['SupB_Monitor']+$row_resultM['SupC_Monitor'];
$updatesumM_query = "UPDATE production SET Sum_SupABC_Monitor='$sum_Monitor_query' WHERE `cid`='$cid'";
$result_sum = mysql_query($updatesumM_query);
//Kernel
$sum_Kernel_query = $row_resultM['SupA_Kernel']+$row_resultM['SupB_Kernel']+$row_resultM['SupC_Kernel'];
$updatesumK_query = "UPDATE production SET Sum_SupABC_Kernel='$sum_Kernel_query' WHERE `cid`='$cid'";
$result_sum = mysql_query($updatesumK_query);
//KeyBoard
$sum_KeyBoard_query = $row_resultM['SupA_KeyBoard']+$row_resultM['SupB_KeyBoard']+$row_resultM['SupC_KeyBoard'];
$updatesumKB_query = "UPDATE production SET Sum_SupABC_KeyBoard='$sum_KeyBoard_query' WHERE `cid`='$cid'";
$result_sum = mysql_query($updatesumKB_query);
*/


$sql_query = "SELECT * FROM `production`";
$result = mysql_query($sql_query);
$row_result = mysql_fetch_assoc($result);

//組裝機具I數量確認，後面表格若讀取到的機具數量=0，則不顯示radio button;若數量大於0，則顯示radio button，其他機具以此類推
$cp1_A_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'A'";
$cp1_A_result = mysql_query($cp1_A_query);
$cp1_B_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'B'";
$cp1_B_result = mysql_query($cp1_B_query);
$cp1_C_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'C'";
$cp1_C_result = mysql_query($cp1_C_query);
//$cp1_C_query = "SELECT * FROM machine WHERE `machine_name`='cp1_C'";

//組裝機具II數量確認
$cp2_A_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'A'";
$cp2_A_result = mysql_query($cp2_A_query);
$cp2_B_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'B'";
$cp2_B_result = mysql_query($cp2_B_query);
$cp2_C_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'C'";
$cp2_C_result = mysql_query($cp2_C_query);


//切割機具數量確認
$cut_mA_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'A'";
$cut_mA_result = mysql_query($cut_mA_query);
$cut_mB_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'B'";
$cut_mB_result = mysql_query($cut_mB_query);
$cut_mC_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'C'";
$cut_mC_result = mysql_query($cut_mC_query);
//echo mysql_num_rows($machine_result);



/*$machine_query = "SELECT type, COUNT(machine_name) FROM machine GROUP BY type";  
$machine_result = mysql_query($machine_query) or die(mysql_error());
$row_machine = mysql_fetch_array($machine_result);*/

//$result_machine = mysql_fetch_array(mysql_query($machinesql_query));







//echo "There are ". $row['COUNT(machine_name)'] ." ". $row['type'] ." items.";

//$row_result2 = mysql_fetch_assoc($result_machine);
//$sql="INSERT INTO Persons (FirstName, LastName, Age)
//VALUES
//('$_POST[firstname]','$_POST[lastname]','$_POST[age]')";



$sql="INSERT INTO production (SupA_ProductA ,SupB_ProductA ,SupC_ProductA ,SupA_ProductB ,SupB_ProductB,SupC_ProductB)
VALUES ('$_POST[SupA_ProductA]','$_POST[SupB_ProductA]','$_POST[SupC_ProductA]','$_POST[SupA_ProductB]','$_POST[SupB_ProductB]','$_POST[SupC_ProductB]')";

/*$result_spAM = mysql_query($spAM_query);
$spBM_query = "SELECT `SupB_Monitor` FROM `production` WHERE `cid`='Test'"; 
$result_spBM = mysql_query($spBM_query);
$spCM_query = "SELECT `SupC_Monitor` FROM `production` WHERE `cid`='Test'"; 
$result_spCM = mysql_query($spCM_query);
$sum_spABCM_query = $result_spAM + $result_spBM+ $result_spCM;
$updatesum_query = "UPDATE `production` SET `Sum_SupABC_Monitor` AS $sum_spABCM_query WHERE `cid`='Test'";*/




//$sum_query = "SELECT SUM(`SupA_Monitor` + `SupB_Monitor` + `SupC_Monitor`) FROM `production` WHERE `cid`='Test'"; 
//$result2 = mysql_query($sum_query);
//$row_result2=mysql_fetch_assoc($result2);
//$updatesum_query = "UPDATE `production` SET `Sum_SupABC_Monitor` WHERE `cid`='Test'";
//$result3 = mysql_query($updatesum_query);
//$row_result3=mysql_fetch_assoc($result3);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		 <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
       	<script type="text/javascript">
		     var SA_MA=0,SA_MB=0,SA_MC=0;
		     var SB_MA=0,SB_MB=0,SB_MC=0;
		     var SC_MA=0,SC_MB=0,SC_MC=0;
		
		    var TSA_PA=0,TSB_PA=0,TSC_PA=0;
			var TSA_PB=0,TSB_PB=0,TSC_PB=0;
			var PA=0,PB=0;
			$(document).ready(function(){
				$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});  // Smart Tab    	

			});
			
			function compareA(){
						var MAX;
			    //供應商A
			    SA_MA=parseInt(document.getElementById("SupA_Monitor").innerHTML);
				SA_MB=parseInt(document.getElementById("SupA_Kernel").innerHTML);
				SA_MC=parseInt(document.getElementById("SupA_KeyBoard").innerHTML);
				      MAX = SA_MA;
				         if(SA_MB > MAX)
				            MAX = SA_MB;
				         if(SA_MC > MAX)
				            MAX = SA_MC;
				TSA_PA=parseInt(document.getElementById("SupA_ProductA").value);
				if(TSA_PA>MAX)
				  alert("原料不足，請重新分配!!!");
		
			}
			function compareB(){
						var MAX;

						//供應商B
				SB_MA=parseInt(document.getElementById("SupB_Monitor").innerHTML);
				SB_MB=parseInt(document.getElementById("SupB_Kernel").innerHTML);
				SB_MC=parseInt(document.getElementById("SupB_KeyBoard").innerHTML);
				      MAX = SB_MA;
				         if(SB_MB > MAX)
				            MAX = SB_MB;
				         if(SB_MC > MAX)
				            MAX = SB_MC;
							TSB_PA=parseInt(document.getElementById("SupB_ProductA").value);
				if(TSB_PA>MAX)
								  alert("原料不足，請重新分配!!!");					
							}
			function compareC(){
						var MAX;

			//供應商C
				SC_MA=parseInt(document.getElementById("SupC_Monitor").innerHTML);
				SC_MB=parseInt(document.getElementById("SupC_Kernel").innerHTML);
				SC_MC=parseInt(document.getElementById("SupC_KeyBoard").innerHTML);
				      MAX = SC_MA;
				         if(SC_MB > MAX)
				            MAX = SC_MB;
				         if(SC_MC > MAX)
				            MAX = SC_MC;
			
				TSC_PA=parseInt(document.getElementById("SupC_ProductA").value); 
				if(TSC_PA>MAX)
								  alert("原料不足，請重新分配!!!");
			}

			
			
			/*function count(){
				SA_PA=document.getElementById("SupA_ProductA").innerHTML;
				SB_PA=document.getElementById("SupB_ProductA").innerHTML;
				SC_PA=document.getElementById("SupC_ProductA").innerHTML;
				
				SA_PB=document.getElementById("SupA_ProductB").innerHTML;
				SB_PB=document.getElementById("SupB_ProductB").innerHTML;
				SC_PB=document.getElementById("SupC_ProductB").innerHTML;  
				
				
				
				inputA = SupA_ProductA + SupB_ProductA + SupC_ProductA;
				inputB = SupA_ProductB + SupB_ProductB + SupC_ProductB;
				
				
			    document.getElementById("product_A").innerHTML=addCommas(parseInt(inputA));
				document.getElementById("product_B").innerHTML=addCommas(parseInt(inputB));
			 }*/
			
			
			
	//輸入值(離開textbox or 按Enter)後，生產數量total立即變動
			/*function total(){
				TSA_PA=document.getElementById("SupA_ProductA").value;
				TSB_PA=document.getElementById("SupB_ProductA").value;
				TSC_PA=document.getElementById("SupC_ProductA").value;
				
				TSA_PB=document.getElementById("SupA_ProductB").value;
				TSB_PB=document.getElementById("SupB_ProductB").value;
				TSC_PB=document.getElementById("SupC_ProductB").value;
				
				PA=document.getElementById("product_A").value;
				PB=document.getElementById("product_B").value;
				count();
			}*/
            
		
		
		
		</script>
    </head>
    <body>   
    <div id="content" style="height:auto">
        <h1>生產規劃&nbsp;
		<?php //echo $newmonth;?></h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer">
  			<ul>
  				<li>
                <a href="#tabs-1">
                	<!-- <img class='logoImage2' border="0" width="50px" src="images/Step1.png">-->
                	<h2>生產規劃</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-2">
                	<img class='logoImage2' border="0" width="50px" src="../images/product_A.png">
                	<h2>生產<br />
                	筆記型電腦</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-3">
                    <img class='logoImage2' border="0" width="50px" src="../images/product_B.png">
                    <h2>生產<br />
                    平板電腦</h2>
             	</a>
                </li>
  			</ul>
  			<div id="tabs-1">
            <h2>生產規劃</h2>	  	
            <form method="post" name="form1" action="production_final.php">
<table width="450" border="0" cellspacing="0" cellpadding="0">
	
  <tr>
    <td>&nbsp;</td>
    <td align="center"><img src="../images/material_A.png" /></td>
    <td align="center"><img src="../images/material_B.png" /></td>
    <td align="center"><img src="../images/material_C.png" /></td>

  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>人工檢料</td>
    <td align="center" BGCOLOR=FCFF19><a id="clue_monitor" rel="cluetip.php"><input name="production_plan[]" id="monitor" type="checkbox" value="螢幕原料檢驗">人工小時</a></td>
    <td align="center" BGCOLOR=FCFF19><a id="clue_kernel" rel="cluetip.php"><input name="production_plan[]" id="kernel" type="checkbox"  value="kernel原料檢驗">人工小時</a></td>
    <td align="center" BGCOLOR=FCFF19><a id="clue_keyboard" rel="cluetip.php"><input name="production_plan[]" id="keyboard" type="checkbox"  value="鍵盤原料檢驗">人工小時</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>原料切割</a></td>
    <td colspan="2" BGCOLOR=FCFF19>
	      <table>
	         <tr><td></td><td></td><td colspan="2">切割次數</td></tr>
	         <tr><td>機具等級</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</td>	</tr>
	         <tr><td>現有數量</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cut_mA_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cut_mB_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cut_mC_result);?></td>	</tr>
	         <tr><td>使用機具</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<?phpif (mysql_num_rows($cut_mA_result)>0) echo'<input name="machine_type" type="radio"  value="cut_mA">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cut_mB_result)>0) echo'<input name="machine_type" type="radio"  value="cut_mB">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cut_mC_result)>0) echo'<input name="machine_type" type="radio"  value="cut_mC">';?></td>	</tr>
	      </table>
		</td>
	<td BGCOLOR=><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>組裝一</a></td>
    <td colspan="2" BGCOLOR=FCFF19>
	      <table>
	         <tr><td></td><td></td><td colspan="2">機器小時</td></tr>
	         <tr><td>機具等級</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</td>	</tr>
	         <tr><td>現有數量</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp1_A_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp1_B_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp1_C_result);?></td>	</tr>
	         <tr><td>使用機具</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<?phpif (mysql_num_rows($cp1_A_result)>0) echo'<input name="cp1machine_type" type="radio"  value="cp1_A">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cp1_B_result)>0) echo'<input name="cp1machine_type" type="radio"  value="cp1_B">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cp1_C_result)>0) echo'<input name="cp1machine_type" type="radio"  value="cp1_C">';?></td>	</tr>
	      </table>
	</td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>合成檢測</td>
    <td colspan="2" BGCOLOR=FCFF19>
		<a id="clue_check_s" rel="cluetip.php"><center><input name="production_plan[]" id="check_s" type="checkbox"  value="在製品檢驗">檢驗次數</center></a>
	</td>
    <td><img src="../images/sline1.png" /></td>
	
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>組裝二</a></td>
    <td><img src="../images/sline1.png" /></td>
    <td colspan="2" BGCOLOR=FCFF19>
	      <table>
	         <tr><td></td><td></td><td colspan="2">機器小時</td></tr>
	         <tr><td>機具等級</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</td>	</tr>
	         <tr><td>現有數量</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp2_A_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp2_B_result);?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo mysql_num_rows($cp2_C_result);?></td>	</tr>
	         <tr><td>使用機具</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<?phpif (mysql_num_rows($cp2_A_result)>0) echo'<input name="cp2machine_type" type="radio"  value="cp2_A">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cp2_B_result)>0) echo'<input name="cp2machine_type" type="radio"  value="cp2_B">';?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	         <?phpif (mysql_num_rows($cp2_C_result)>0) echo'<input name="cp2machine_type" type="radio"  value="cp2_C">';?></td>	</tr>

	      </table>
	</td>
  </tr>
  <tr>
    <td></td>
    <td><img src="../images/sline1.png" /></td>
	<td align="center"  colspan="2"><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>精密檢測</td>
    <td colspan="3" BGCOLOR=FCFF19>
	<a id="clue_check" rel="cluetip.php"><center><input name="production_plan[]" id="check" type="checkbox"  value="成品檢驗">檢驗次數</center></a>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td align="center"  colspan="2"><img src="../images/sline1.png" /></td>  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td align="center"  colspan="2"><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><img src="../images/product_A.png" /></td>
    <td align="center" colspan="2"><img src="../images/product_B.png" /></td>
  </tr>
  <tr>
	<td colspan="2"></td>
	<td><br>
    <input type="image" src="../images/submit6.png" id="submit1" style="width:100px">
    </td>
  </tr>
				
	</table>
</form>			
			</div>
  			<div id="tabs-2">
            	<h2>生產<br />
                	筆記型電腦</h2>	
            <form method="POST" name="form2" action="productA.php">

            	<table class="table1">
		
            <thead>
                <tr>
				    <td></td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="35%" src="../images/material_A.png">螢幕與面板</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="33%" src="../images/material_B.png">主機板與核心電路</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="35%" src="../images/material_C.png">鍵盤基座</td>
                </tr>
                <tr>
                    <td></td>                
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">投入數量</th>
					<tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">供應商A</th>
                    <td style="text-align:center" id="SupA_Monitor"><?php echo $ma_suppliera;?></td>
                    <td style="text-align:center" id="SupA_Kernel"><?php echo $mb_suppliera;?></td>
                    <td style="text-align:center" id="SupA_KeyBoard"><?php echo $mc_suppliera;?></td>
                    <td><input type="text" size="8px" id="SupA_ProductA" name="SA_PA" onBlur="compareA()"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"id="supplyB">供應商B</th>         
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $ma_supplierb;?></td>
                    <td style="text-align:center" id="SupB_Kernel"><?php echo $mb_supplierb;?></td>
                    <td style="text-align:center" id="SupB_KeyBoard"><?php echo $mc_supplierb;?></td>
                    <td><input type="text" size="8px" id="SupB_ProductA" name="SB_PA" onBlur="compareB()"></td>                  
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                    <td style="text-align:center" id="SupC_Monitor"><?php echo $ma_supplierc;?></td>
                    <td style="text-align:center" id="SupC_Kernel"><?php echo $mb_supplierc;?></td>
                    <td style="text-align:center" id="SupC_KeyBoard"><?php echo $mc_supplierc;?></td>
                    <td><input type="text" size="8px" id="SupC_ProductA" name="SC_PA" onBlur="compareC()"></td>
                </tr>

				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						
                        <td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $sum_ma;?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $sum_mb;?></td>
						<td style="text-align:center" id="Sum_SupABC_KeyBoard"><?php echo $sum_mc;?></td>
                    </tr>
					<!--<tr>
                        <th scope="row" id="total_material">生產數量</th>
						
                    <td><input type="text" size="8px" id="product_A"></td>
                    </tr>>-->
                </tbody>
				<tfoot class="tfoot1">
		        <td colspan="4"></td>
				<td><br><?php if($rd_rowA!=0){echo'<input type="image" src="../images/submit6.png" id="submit2" style="width:100px">';
				               }else{
				                      echo '尚未研發<font color=#FF0000>筆記型電腦</font>，請先研發後才能開始生產!!!';}?></td>
				</tfoot>
				
            </table>	
            </form>
        	</div>                      
  			<div id="tabs-3">
            	<h2>生產<br />
                    平板電腦</h2>	
                    <form method="post" name="form3" action="productB.php">

            	 <table class="table1">
				 <!--	?php	 
		while($row_result=mysql_fetch_assoc($Product)){?>  --> 
            <thead>
                <tr>
				<td>			</td>

                    <td  style="width:145px; text-align:center;"><img border="0" width="35%" src="../images/material_A.png">螢幕與面板</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="33%" src="../images/material_B.png">主機板與核心電路</td>
                </tr>
                <tr>
                    <td></td>  
        
                  
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">投入數量</th>
					                </tr>

            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">供應商A</th>
                
                    <td style="text-align:center" id="SupA_Monitor"><?php echo $ma_suppliera;?></td>
                    <td style="text-align:center" id="SupA_Kernel"><?php echo $mb_suppliera;?></td>
                    <td><input type="text" size="8px" id="SupA_ProductB"  name="SA_PB" onBlur="compareA()"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyB" >供應商B</th>
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $ma_supplierb;?></td>
                    <td style="text-align:center" id="SupB_Kernel"><?php echo $mb_supplierb;?></td>
                    <td><input type="text" size="8px" id="SupB_ProductB"  name="SB_PB" onBlur="compareB()"></td>
                   

                   
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                    <td style="text-align:center" id="SupC_Monitor"><?php echo $ma_supplierc;;?></td>
                    <td style="text-align:center" id="SupC_Kernel"><?php echo $mb_supplierc;?></td>
                    <td><input type="text" size="8px" id="SupC_ProductB"  name="SC_PB" onBlur="compareC()"></td>
                </tr>
              
				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						<td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $sum_ma;?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $sum_mb;?></td>
						
                    </tr>
					<!--<tr>
                        <th scope="row" id="total_material">生產數量</th>
                    <td><input type="text" size="8px" id="product_B"></td>
                    </tr>-->
                </tbody>
				<tfoot class="tfoot2">
                <td colspan="3"></td>
				<td ><br><?php if($rd_rowB!=0){echo'<input type="image" src="../images/submit6.png" id="submit2" style="width:100px">';
				                }else{
				                      echo '尚未研發<font color=#FF0000>平板電腦</font>，請先研發後才能開始生產!!!';}?></td>
				</tfoot>
				<!--?php } ?>-->
            </table>	
			</form> 				          
       		</div>
		</div>    <!-- Tabs 結束 -->
            
            
       
    
      </div><!-- end content -->
    </body>
</html>