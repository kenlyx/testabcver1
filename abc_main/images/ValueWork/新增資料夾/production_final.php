<!--
To change this template, choose Tools | Templates
and open the template in the editor.
--><?php
include("../connMysql.php");
if (!@mysql_select_db("abc_main")) die("資料庫選擇失敗!");
mysql_query("set names 'utf8'");
$cid='C03';
$sql_query = "SELECT * FROM `production`";
$result = mysql_query($sql_query);
$row_result=mysql_fetch_assoc($result);
$sum_query = "SELECT SUM(`SupA_Monitor` + `SupB_Monitor` + `SupC_Monitor`) FROM `production` WHERE `cid`='$cid'"; 
$updatesum_query = mysql_query("UPDATE `production` SET `Sum_SupABC_Monitor` WHERE `cid`='$cid'");
$sql_query = "SELECT * FROM `production`";
$result2 = mysql_query($updatesum_query);
$row_result2=mysql_fetch_assoc($result2);
//$sum_query = "SELECT SUM(`SupA_Monitor` + `SupB_Monitor` + `SupC_Monitor`) FROM `production` WHERE `cid`='$cid'"; 
//mysql_query("UPDATE `production` SET `Sum_SupABC_Monitor`={$_GET['monitor']}, `kernel`={$_GET['kernel']}, `keyboard`={$_GET['keyboard']}, `cut`={$_GET['cut']}, `combine1`={$_GET['combine1']},`check_s`={$_GET['check_s']}, `combine2`={$_GET['combine2']},`check`={$_GET['check']} WHERE `year`=$year AND `month`=$month AND `cid`='$company'",$connect);
//$sum_result = mysql_query($sum_query);
//$row_result2 = mysql_fetch_assoc($sum_result);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
        <link href="../css/smartTab.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/styleContent.css"/>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js" ></script>

        <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.smartTab.js"></script>
		<link rel="stylesheet" href="jquery.cluetip.css" type="text/css" />
        <script src="jquery.cluetip.js" type="text/javascript"></script>

       	<script type="text/javascript">
		//var RD_done_A=0;
		//if(RD_done_A==0)
				//	function RD_alert(){
               //  alert("請先進行研發!!!");
                 //          }
		//function RD_alert(){
		//if(RD_done_A==0)
               //  alert("請先進行研發!!!")
                   //        }
		//function machine_alert(){
              //   alert("請購買足夠的機具!!!")
                 //               }
		$(document).ready(function(){
				//get_RD();
                //get_machine();
                //$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                $("#tabs-2").click(function(){
                    //alert(machine_A);
                    /*if(RD_done_A>=1&&machine_A==1)
                        $("div#content2").load("product_A.html");
                    else
                        $("div#content2").html("");*/
                    if(RD_done_A==0)
					function RD_alert(){
                 window.alert("請先進行研發!!!");
                           }
                        $("div#content2").append("<font size=4>請先進行研發</font></br>");
                    if(machine_A==0)
                        $("div#content2").append("<font size=4>請購買足夠的機具</font></br>");
                });
                $("#tabs-3").click(function(){
                    //alert(machine_B);
                   /* if(RD_done_B>=1&&machine_B==1)
                        $("div#content2").load("product_B.html");
                    else
                        $("div#content2").html("");*/
                    if(RD_done_B==0)
                        $("div#content2").append("<font size=4>請先進行研發</font></br>");
                    if(machine_B==0)
                        $("div#content2").append("<font size=4>請購買足夠的機具</font></br>");
                });
                $("#clue_pA").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'fixed',
                    width: '150px',
                    topOffset: -40,
                    leftOffset: 60,
                    ajaxSettings:{data:"name=clue_pA"}
                });
                $("#clue_pB").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'fixed',
                    width: '150px',
                    topOffset: -40,
                    leftOffset: 60,
                    ajaxSettings:{data:"name=clue_pB"}
                });
            });
			$(document).ready(function(){
				$('#tabs').smartTab({autoProgress: true,stopOnFocus:true,transitionEffect:'slide'});  // Smart Tab    	
	
			});
			
			$(document).ready(function(){
                initial_get();
                $("#clue_monitor").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_monitor_pp"}
                });
                $("#clue_kernel").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_kernel_pp"}
                });
                $("#clue_keyboard").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_keyboard_pp"}
                });
                $("#clue_check_s").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_s_pp"}
                });
                $("#clue_check").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_pp"}
                });
            });
			
			 $("#cut").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=cut,'+count4,boxid:'frameless',width:400,height:150,style:"z-index:2; top:30px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
            $("#combine1").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=combine1,'+count5,boxid:'frameless',width:400,height:150,style:"z-index:2; top:30px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
            $("#combine2").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=combine2,'+count7,boxid:'frameless',width:400,height:150,style:"z-index:2; top:30px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
		</script>
    </head>
    <body>   
    <div id="content">
	<form action="" method="post" name="form1" action="hw5_984003536_output.php">
        <h1>生產規劃</h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer">
		
  			<ul>
  				<li>
                <a href="#tabs-1">
                	<!-- <img border="0" width="50px">-->
                	<h2>生產規劃</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-2"  onclick="RD_alert()">
                	<img class='logoImage2' border="0" width="50px" src="./images/product_A.png">
                	<h2>生產<br />
					筆記型電腦</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-3">
                    <img class='logoImage2' border="0" width="50px" src="./images/product_B.png">
                    <h2>生產<br />
                    平板電腦</h2>
             	</a>
                </li>
  			</ul>
<div id="tabs-1">
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
    <td align="center" BGCOLOR=FCFF19><a id="clue_monitor" rel="cluetip.php"><input name="monitor" type="checkbox" value="螢幕原料檢驗">人工小時</a></td>
    <td align="center" BGCOLOR=FCFF19><a id="clue_kernel" rel="cluetip.php"><input name="kernel" type="checkbox"  value="kernel原料檢驗">人工小時</a></td>
    <td align="center" BGCOLOR=FCFF19><a id="clue_keyboard" rel="cluetip.php"><input name="keyboard" type="checkbox"  value="鍵盤原料檢驗">人工小時</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>原料切割</a></td>
    <td colspan="2" BGCOLOR=FCFF19><center>切割次數</center>
	機具等級&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</br>
	現有數量</br>	
	使用機具&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cut_mA" type="radio"  value="cut_mA">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cut_mB" type="radio"  value="cut_mB">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cut_mC" type="radio"  value="cut_mC">
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
    <td colspan="2" BGCOLOR=FCFF19><center>機器小時</center>
	機具等級&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</br>
	現有數量</br>	
	使用機具&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp1_A" type="radio"  value="cp1_A">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp1_B" type="radio"  value="cp1_B">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp1_C" type="radio"  value="cp1_C">
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
    <td colspan="2" BGCOLOR=FCFF19><a id="clue_check_s" rel="cluetip.php"><center><input name="check_s" type="checkbox"  value="在製品檢驗">檢驗次數</center></a></td>
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
    <td colspan="2" BGCOLOR=FCFF19><center>機器小時</center>
	機具等級&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C</br>
	現有數量</br>	
	使用機具&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp2_A" type="radio"  value="cp2_A">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp2_B" type="radio"  value="cp2_B">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cp2_C" type="radio"  value="cp2_C">
	</td>
  </tr>
  <tr>
    <td></td>
    <td><img src="../images/sline1.png" /></td>
        <td align="center"  colspan="2"><img src="../images/sline1.png" /></td>

  </tr>
  <tr>
    <td>精密檢測</td>
    <td colspan="3" BGCOLOR=FCFF19><a id="clue_check" rel="cluetip.php"><center><input name="check" type="checkbox"  value="成品檢驗">檢驗次數</center></a></td>
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
				<td><br><input type="image" src="../images/submit6.png" id="submit" style="width:100px" onClick="test();"></td>
				</tr>
				
</table>
  </form>	
			</div>	

  			<div id="tabs-2">
			
			  	<form action="" method="post" name="form2" action="hw5_984003536_output.php">

            	<table class="table1">
		<!--	?php	 
				while($row_result=mysql_fetch_assoc($Product)){?>  --> 
            <thead>
                <tr>
				<td>			</td>

                    <td  style="width:145px; text-align:center;"><img border="0" width="22%" src="./images/material_A.png">螢幕與面板</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="22%" src="./images/material_B.png">主機板與核心電路</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="22%" src="./images/material_C.png">鍵盤基座</td>
                </tr>
                <tr>
                    <td></td>  
        
                  
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">投入數量</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">供應商A</th>s
                
                    <td style="text-align:center" id="SupA_Monitor"><?php echo $row_result["SupA_Monitor"];?></td>
                    <td style="text-align:center" id="SupA_Kernel"><?php echo $row_result["SupA_Kernel"];?></td>
                    <td style="text-align:center" id="SupA_KeyBoard"><?php echo $row_result["SupA_KeyBoard"];?></td>
                    <td><input type="text" size="8px" id="SupA_ProductA"><?php  $row_result2["$SupA_ProductA"];?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"id="supplyB">供應商B</th>
                    
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $row_result["SupB_Monitor"];?></td>
                    <td style="text-align:center" id="SupB1_ProductA"><?php echo $row_result["SupB_Kernel"];?></td>
                    <td style="text-align:center" id="SupB2_ProductA"><?php echo $row_result["SupB_KeyBoard"];?></td>
                    <td><input type="text" size="8px" id="SupB_ProductA"><?php $row_result2["SupB_ProductA"];?></td>

                   
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                 
                    <td style="text-align:center" id="SupC0_ProductA"><?php echo $row_result["SupC_Monitor"];?></td>
                    <td style="text-align:center" id="SupC1_ProductA"><?php echo $row_result["SupC_Kernel"];?></td>
                    <td style="text-align:center" id="SupC2_ProductA"><?php echo $row_result["SupC_KeyBoard"];?></td>
                    <td><input type="text" size="8px" id="SupC_ProductA"><?php $row_result2["$SupC_ProductA"];?></td>
 
                </tr>

				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						<?php
						
						        $Sum_SupABC_Monitor=$SupA_Monitor+$SupB_Monitor+$SupC_Monitor; 
								$Sum_SupABC_Kernel=$SupA_Kernel+$SupB_Kernel+$SupC_Kernel;
								$Sum_SupABC_KeyBoard=$SupA_KeyBoard+$SupB_KeyBoard+$SupC_KeyBoard;
								
								?>
                        <td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $row_result2["Sum_SupABC_Monitor"];?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $row_result2["Sum_SupABC_Kernel"];?></td>
						<td style="text-align:center" id="Sum_SupABC_KeyBoard"><?php echo $row_result2["Sum_SupABC_KeyBoard"];?></td>
                    </tr>
					
                </tbody>
				<tfoot>
		        <td colspan="4"></td>
				<td><br><input type="image" src="./images/submit6.png" id="submit" style="width:100px"></td>
				</tfoot>
				<!--?php } ?>-->
            </table>	
            </form>
        	</div>                      
			
			
  			<div id="tabs-3">
				<form action="" method="post" name="form3" action="hw5_984003536_output.php">

            	 <table class="table1">
				 <!--	?php	 
		while($row_result=mysql_fetch_assoc($Product)){?>  --> 
            <thead>
                <tr>
				<td>			</td>

                    <td  style="width:145px; text-align:center;"><img border="0" width="22%" src="./images/material_A.png">螢幕與面板</td>
                    <td  style="width:145px; text-align:center;"><img border="0" width="22%" src="./images/material_B.png">主機板與核心電路</td>
                </tr>
                <tr>
                    <td></td>  
        
                  
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">庫存數量</th>
                    <th scope="col" style="width:70px">投入數量</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">供應商A</th>
                
                    <td style="text-align:center" id="SupA_Monitor"><?php echo $row_result["SupA_Monitor"];?></td>
                    <td style="text-align:center" id="SupA_Kernel"><?php echo $row_result["SupA_Kernel"];?></td>
                    <td><input type="text" size="8px" id="SupA_ProductB"><?php $row_result2["SupA_ProductB"]?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyB" >供應商B</th>
                    <td style="text-align:center" id="SupB_Monitor"><?php echo $row_result["SupB_Monitor"];?></td>
                    <td style="text-align:center" id="SupB_Kernel"><?php echo $row_result["SupB_Kernel"];?></td>
                    <td><input type="text" size="8px" id="SupB_ProductB"><?php $row_result2["SupB_ProductB"]?></td>
                   

                   
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">供應商C</th>
                    <td style="text-align:center" id="SupC_Monitor"><?php echo $row_result["SupC_Monitor"];?></td>
                    <td style="text-align:center" id="SupC_Kernel"><?php echo $row_result["SupC_Kernel"];?></td>
                    <td><input type="text" size="8px" id="SupC_ProductB"><?php $row_result2["SupC_ProductB"]?></td>
                </tr>
              
				
                    <tr>
                        <th scope="row" id="total_material">原料總數</th>
						<?php
						
						        $Sum_SupABC_Monitor=$SupA_Monitor+$SupB_Monitor+$SupC_Monitor; 
								$Sum_SupABC_Kernel=$SupA_Kernel+$SupB_Kernel+$SupC_Kernel;
								
						
						?>
                        <td style="text-align:center" id="Sum_SupABC_Monitor"><?php echo $row_result2["Sum_SupABC_Monitor"];?></td>
                        <td style="text-align:center" id="Sum_SupABC_Kernel"><?php echo $row_result2["Sum_SupABC_Kernel"];?></td>
						<td style="text-align:center" id="Sum_SupABC_KeyBoard"><?php echo $row_result2["Sum_SupABC_KeyBoard"];?></td>
                    </tr>
					
                </tbody>
				<tfoot>
                <td colspan="3"></td>
				<td ><br><input type="image" src="./images/submit6.png" id="submit" style="width:100px"></td>
				</tfoot>
				<!--?php } ?>-->
            </table>	
			</form>
			                 
$query_insert = "INSERT INTO `102stuinfo` (`SupA_ProductB` ,`SupB_ProductB` ,`SupC_ProductB` ) VALUES (";

		$query_insert .= "'".$_POST["SupA_ProductB"]."',";
		$query_insert .= "'".$_POST["SupB_ProductB"]."',";
		$query_insert .= "'".$_POST["SupC_ProductB"]."')";	
		mysql_query($query_insert);

?
			
			
			
             if ( $("#monitor").attr('checked') ) {
something();
}    
             if ( $("#kernel").attr('checked') ) {
something();
}      
             if ( $("#keyboard").attr('checked') ) {
something();
}      
             if ( $("#check_s").attr('checked') ) {
something();
}      
             if ( $("#check").attr('checked') ) {
something();
}       


判斷checkbox是否被選取

$("#your-checkbox-id").attr('checked',true)

加上判斷可以用
if($("input#your-checkbox-id").attr('checked'))這種
  

另外取出radio的值用
$("input:radio[name='name_not_id']:checked").val()



[checkbox 賦值]
$("#chk1").attr("checked",''); //設定不打勾
$("#chk2").attr("checked",true); //設定打勾

[checkbox 取值]
var x=$("input[name='fetion']").is(":checked"));
x=true有被打勾，否則為 false

[radio 賦值]
$('input[name="si"]')[1].checked = true; //radio 賦值==>第二個選項選取
$("input[name=state][value='2']").attr('checked',true); //radio 賦值==>值為2的那個選取

[radio 取值]
$("input[name='inputname']:checked").val();

if( typeof(method) == "undefined") // 注意檢查完全沒有選取的寫法   				          
       		</div>
		</div>    <!-- Tabs 結束 -->
            
            
       
          
      </div><!-- end content -->
    </body>
</html>
