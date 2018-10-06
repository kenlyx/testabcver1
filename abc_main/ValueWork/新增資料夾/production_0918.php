<?php
@session_start();
require_once("../connMysql.php");
mysql_select_db("testabc_main");
$cid=$_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;



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
//$check = "SELECT * FROM  process_improvement WHERE `cid` = '$cid' `year` = '$year' `month` = '$month' ";
//$checkresult = mysql_fetch_array(mysql_query($check));
//if ($checkresult['process']==null){
//echo "尚未進行流程改良，請先進行流程改良，才能進行生產規畫決策，系統將於5秒後為您跳轉";
//header("Location: http://localhost/102abc/abc_main/ValueWork/process.php ");


//header("refresh:4;URL='http://localhost/102abc/abc_main/ValueWork/process.php'");
//}
//計算原料庫存並更新總原料數量
$material = mysql_query("SELECT * FROM purchase_materials WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'-1");
    $row = mysql_fetch_array($material);
    $ma_suppliera=$row['ma_supplier_a'];
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
    $sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;





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
//('mysql_real_escape_string($_POST[firstname])','mysql_real_escape_string($_POST[lastname])','mysql_real_escape_string($_POST[age])')";



$sql="INSERT INTO production (SupA_ProductA ,SupB_ProductA ,SupC_ProductA ,SupA_ProductB ,SupB_ProductB,SupC_ProductB)
VALUES ('mysql_real_escape_string($_POST[SupA_ProductA])','mysql_real_escape_string($_POST[SupB_ProductA])','mysql_real_escape_string($_POST[SupC_ProductA])','mysql_real_escape_string($_POST[SupA_ProductB])','mysql_real_escape_string($_POST[SupB_ProductB])','mysql_real_escape_string($_POST[SupC_ProductB])')";

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
			$(document).ready(function(){
				$('#tabs').smartTab({autoProgress: true,stopOnFocus:true,transitionEffect:'slide'});  // Smart Tab    	
	
			});
			function chkform(formObj)
{
if(emptyRadioField(form1.machine_type))
alert("請選擇");
else if(emptyRadioField(form1.cp1machine_type))
alert("選擇你的性別");
else if(emptyRadioField(form1.cp2machine_type))
alert("選擇你的性別");


else return true;

return false;
}
			function emptyRadioField(Obj)
{
        for(var i=0 ;i<Obj.length;i++){
                if(Obj[i].checked){
                        return false;
                }
        }
        return true;
}
		</script>
    </head>
    <body>   
    <div id="content" style="height:auto">
        <h1>生產規劃&nbsp;
		<?php echo $state;?></h1>
        
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
                    <td><input type="text" size="8px" name="SupA_ProductA"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"id="supplyB">供應商B</th>         
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $ma_supplierb;?></td>
                    <td style="text-align:center" id="SupB_Kernel"><?php echo $mb_supplierb;?></td>
                    <td style="text-align:center" id="SupB_KeyBoard"><?php echo $mc_supplierb;?></td>
                    <td><input type="text" size="8px" name="SupB_ProductA"></td>                  
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                    <td style="text-align:center" id="SupC_Monitor"><?php echo $ma_supplierc;?></td>
                    <td style="text-align:center" id="SupC_Kernel"><?php echo $mb_supplierc;?></td>
                    <td style="text-align:center" id="SupC_KeyBoard"><?php echo $mc_supplierc;?></td>
                    <td><input type="text" size="8px" name="SupC_ProductA"></td>
                </tr>

				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						
                        <td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $sum_ma;?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $sum_mb;?></td>
						<td style="text-align:center" id="Sum_SupABC_KeyBoard"><?php echo $sum_mc;?></td>
                    </tr>
					
                </tbody>
				<tfoot class="tfoot1">
		        <td colspan="4"></td>
				<td><br><input type="image" src="../images/submit6.png" id="submit2" style="width:100px"></td>
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
                    <td><input type="text" size="8px" name="SupA_ProductB"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyB" >供應商B</th>
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $ma_supplierb;?></td>
                    <td style="text-align:center" id="SupB_Kernel"><?php echo $mb_supplierb;?></td>
                    <td><input type="text" size="8px" name="SupB_ProductB"></td>
                   

                   
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                    <td style="text-align:center" id="SupC_Monitor"><?php echo $ma_supplierc;;?></td>
                    <td style="text-align:center" id="SupC_Kernel"><?php echo $mb_supplierc;?></td>
                    <td><input type="text" size="8px" name="SupC_ProductB"></td>
                </tr>
              
				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						<td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $sum_ma;?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $sum_mb;?></td>
						
                    </tr>
					
                </tbody>
				<tfoot class="tfoot2">
                <td colspan="3"></td>
				<td ><br><input type="image" src="../images/submit6.png" id="submit3" style="width:100px"></td>
				</tfoot>
				<!--?php } ?>-->
            </table>	
			</form> 				          
       		</div>
		</div>    <!-- Tabs 結束 -->
            
            
       
    
      </div><!-- end content -->
    </body>
</html>