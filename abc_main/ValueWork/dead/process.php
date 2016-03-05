<!--
To change this template, choose Tools | Templates
and open the template in the editor.-->
<?php
@session_start();
//require_once("../connMysql.php");
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'utf8'");
$cid=$_SESSION['cid'];

$month = $_SESSION['month'];
$year=$_SESSION['year'];
$month1 = $month + ($year-1)*12;
//echo $month;

//檢查有無機具，隨便抓購買的年月來相加，有值就代表有機具
$sql_machine = mysql_query("SELECT SUM(`buy_year`),SUM(`buy_month`) FROM  `machine` WHERE `cid`='$cid'", $connect);
                		$machine_result=mysql_fetch_array($sql_machine);
                           $total_machine = $machine_result[0]+$machine_result[1];


/*
//組裝機具I數量確認，後面表格若讀取到的機具數量=0，則不顯示radio button;若數量大於0，則顯示radio button，其他機具以此類推
$cp1_A_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'A'";
$cp1_A_result = mysql_query($cp1_A_query);
$cp1_B_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'B'";
$cp1_B_result = mysql_query($cp1_B_query);
$cp1_C_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine1' AND `type` = 'C'";
$cp1_C_result = mysql_query($cp1_C_query);
//$cp1_C_query = "SELECT * FROM machine WHERE `machine_name`='cp1_C'";
//$a= mysql_num_rows($cp1_A_result);
//$cp1_result = mysql_num_rows($cp1_A_result)+ mysql_num_rows($cp1_B_result)+ mysql_num_rows($cp1_C_result);

//組裝機具II數量確認
$cp2_A_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'A'";
$cp2_A_result = mysql_query($cp2_A_query);
$cp2_B_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'B'";
$cp2_B_result = mysql_query($cp2_B_query);
$cp2_C_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='combine2' AND `type` = 'C'";
$cp2_C_result = mysql_query($cp2_C_query);
//$cp2_result = mysql_num_rows($cp2_A_result)+ mysql_num_rows($cp2_B_result)+ mysql_num_rows($cp2_C_result);



//切割機具數量確認
$cut_mA_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'A'";
$cut_mA_result = mysql_query($cut_mA_query);
$cut_mB_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'B'";
$cut_mB_result = mysql_query($cut_mB_query);
$cut_mC_query = "SELECT * FROM machine WHERE `cid` = '$cid' AND `function`='cut' AND `type` = 'C'";
$cut_mC_result = mysql_query($cut_mC_query);
//$cut_result = mysql_num_rows($cut_mA_result) + mysql_num_rows($cut_mB_result)+ mysql_num_rows($cut_mC_result);

//$machine_result = $cp1_result + $cp2_result + $cut_result;*/

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
        <script src="jquery.cluetip.js" type="text/javascript"></script>
		<!--<script language="JavaScript" type="text/javascript">
 
function validate()
{
        var obj=document.getElementsByName("process[]");
        var len = obj.length;
        var checked = '';
        var num=0;

        for (i = 0; i < len; i++)
        {
            if (obj[i].checked == true)
            {
                //checked = true;
                num++;
                checked = checked + obj[i].value+' ';
                //break;
            }
        }
        if (num==0) {
        alert ("你沒有選擇任何選項,請重新選擇");
        return false;
        }
        else {
        //alert("你選擇了"+num+"項");
        alert("你選擇了"+checked);
        }
};
    
</script>-->
		
		
		
		
       	<!--<script type="text/javascript">
			$(document).ready(function(){
                    $("#clue_monitor").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_monitor_pi"}
                });
                $("#clue_kernel").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_kernel_pi"}
                });
                $("#clue_keyboard").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_keyboard_pi"}
                });
                $("#clue_check_s").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_s_pi"}
                });
                $("#clue_check").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_pi"}
                });
            });
		</script>
		<script>
function chkIt() {
  document.all["show"].value = document.all["monitor"].checked + document.all["kernel"].checked + document.all["keyboard"].checked + document.all["check_s"].checked +document.all["check"].checked + 0;
}
</script>
<script>
function test(){ 
// 得到checkbox数组 
var elements = document.getElementsByName("processckb"); 
var str = ""; 
// 取得所选择的角色 
for(var i=0;i<elements.length;i++){ 
if(elements[i].checked){ 
str += "\n" + elements[i].value + "\n"; 
} 
} 
// 输出 

if(str == ""){ 
alert("您没有做任何流程改良！"); 
} 
else{ 
document.all["show"].value ="\n" + str;
//alert("您选择的角色为：\n\n" + str); 
} 
} -->
<script>
/*function myFunction()
{alert(<?php echo $_POST['process']?>);
var x;
var r=confirm("Press a button!");
if (r==true)
  {
  x="You pressed OK!";
  }
else
  {
  x="You pressed Cancel!";
  }
document.getElementById("demo").innerHTML=x;
}*/
var xmlHttp;

function showUser(str){ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request")
		return;
	} 
	var url="mysqlAction.php"
	var monitor = document.form1.monitor.value;  //取得表單中的monitor
	var kernel = document.form1.kernel.value;  //取得表單中的kernel
	var keyboard = document.form1.keyboard.value;//取得表單中的keyboard
	var check_s = document.form1.check_s.value;//取得表單中的check_s
	var check = document.form1.check.value;//取得表單中的check
	url=url+"?monitor="+monitor+"&kernel="+kernel+"&keyboard="+keyboard+"&check_s="+check_s+"&check="+check;
	xmlHttp.onreadystatechange=action 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
 }

function action() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
		xmlDoc=xmlHttp.responseXML;
	 	if(xmlDoc.getElementsByTagName("msg")[0].childNodes[0].nodeValue=='yes'){
			var show= 
		"成功<BR>姓名："+xmlDoc.getElementsByTagName("monitor")[0].childNodes[0].nodeValue + //螢幕原料檢驗
		"<BR>生日："+xmlDoc.getElementsByTagName("kernel")[0].childNodes[0].nodeValue +//kernel原料檢驗
		"<BR>生日："+xmlDoc.getElementsByTagName("keyboard")[0].childNodes[0].nodeValue +//鍵盤原料檢驗
		"<BR>生日："+xmlDoc.getElementsByTagName("check_s")[0].childNodes[0].nodeValue +//在製品檢驗
		"<BR>生日："+xmlDoc.getElementsByTagName("check")[0].childNodes[0].nodeValue +//成品檢驗
		document.getElementById("showDiv").innerHTML = show;
		}
		else{
			document.getElementById("showDiv").innerHTML = "失敗";
		}
		
	}  // end of if
}

function GetXmlHttpObject(){ 
	var objXMLHttp=null;
	if (window.XMLHttpRequest){
		objXMLHttp=new XMLHttpRequest();
  	}
 	else if (window.ActiveXObject){
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
  	}
 	return objXMLHttp;
}
if ( $("#monitor").attr('checked') ) {
something();
}    

</script>

    </head>
    <body>   
    <div id="content" style="height:auto">
	
        <h1>流程改良</h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer">
  			<ul>
  				<li>
                <a href="#tabs-1">	
                	<h2>流程改良</h2>
            	</a>
                </li>
				<!--<li>
				<a href="#tabs-2">
                	<h2>檢視決策</h2>
            	</a>
                </li>-->
  			</ul>
  			<div id="tabs-1">
            <form method="POST" name="form1" action="process_final.php">
                        <table width="450" border="0" cellspacing="0" cellpadding="0">
            	
				<tr>每個項目一個回合只能提升一級，每5個研發人員可提升一項目</tr>
				<tr>
                	<td align="left" colspan="4">員工人數:
                    <?php
					$sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='research' AND `cid`='$cid' AND `year`<=$year AND `month`<$month", $connect);
                		$exhf=mysql_fetch_array($sql_exhf);
                           $curp = $exhf[0]-$exhf[1];

					
					
					
					/*if ($month == 1){
					echo '您尚未聘請研發團隊!!!';
					}*/
                    //$getpeople="SELECT * FROM `current_people` WHERE `cid` = '$cid' AND `department`='research'";
					//$all_people = mysql_query("SELECT * FROM `current_people` WHERE `cid` = '$cid' AND `department`='research'");//, $connect);
					//$all_people = mysql_query($getpeople);
    				//$people=0;
						//while ($row = mysql_fetch_array($all_people)) {
                               // if ($row['department'] == "research") {
                                    //if (($row['month']  < $month && $row['year'] = $year )|| $row['year'] < $year) {
                                              //  $people = $people + $row['hire_count'];
                                                //$people = $people - $row['fire_count'];
          //  }
        //}
   // }
	                $all_people=$curp;    
					echo $all_people;
					?>
                    </td>
                </tr>	
                <tr> 
                    <td align="left" colspan="4">可改良次數:<?php
								
					$times=$all_people/5;
					$realtime=floor($times);
					echo $realtime;//無條件捨去小數點以下位數
					?></td>
                </tr>
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
                    <td align="center" bgcolor="FCFF19">
                    	<a id="clue_monitor" rel="cluetip.php">
                        <input name="process[]" id="monitor" type="checkbox" value="螢幕原料檢驗">人工小時</a>
                    </td>
                    <td align="center" bgcolor="FCFF19">
                        <a id="clue_kernel" rel="cluetip.php">
                        <input name="process[]" id="kernel" type="checkbox"  value="kernel原料檢驗">人工小時</a>
                    </td>
                    <td align="center" bgcolor="FCFF19">
                        <a id="clue_keyboard" rel="cluetip.php">
                        <input name="process[]" id="keyboard" type="checkbox"  value="鍵盤原料檢驗">人工小時</a>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><img src="../images/sline1.png" /></td>
                    <td><img src="../images/sline1.png" /></td>
                    <td><img src="../images/sline1.png" /></td>
                </tr>
				<tr>
                    <td>原料切割</td>
                    <td colspan="2" bgcolor="FCFF19"><center>切割次數</center></td>
                    <td BGCOLOR=><img src="../images/sline1.png" /></td>
				</tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><img src="../images/sline1.png" /></td>
                    <td><img src="../images/sline1.png" /></td>
                    <td><img src="../images/sline1.png" /></td>
                </tr>
                <tr>
                    <td>組裝一</td>
                    <td colspan="2" bgcolor="FCFF19"><center>機器小時</center></td>
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
                    <td colspan="2" bgcolor="FCFF19">
                    <a id="clue_check_s" rel="cluetip.php">
                        <center>
                        	<input name="process[]" id="check_s" type="checkbox"  value="在製品檢驗">檢驗次數
                        </center>
                    </a>
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
                    <td>組裝二</td>
                    <td><img src="../images/sline1.png" /></td>
                    <td colspan="2" bgcolor="FCFF19"><center>機器小時</center></td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="../images/sline1.png" /></td>
                    <td align="center"  colspan="2"><img src="../images/sline1.png" /></td>
				</tr>
                <tr>
                    <td>精密檢測</td>
                    <td colspan="3" bgcolor="FCFF19">
                    <a id="clue_check" rel="cluetip.php">
                        <center>
                            <input name="process[]" id="check" type="checkbox"  value="成品檢驗">檢驗次數
                        </center>
                    </a>
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
                	<td align="right" colspan="4">
                    <!--<input type="image" src="../images/submit6.png" id="all_submit" style="width:100px">-->
                     <?php if ($total_machine==0){
					 		  echo"您尚未購買機具，請先購買機具才可執行流程改良";
					 }				 
					 if($realtime==0 ){
					 					 		  echo"您尚未聘請研發團隊，請先聘請研發團隊才可執行流程改良";

					 }	 
					 else{
					 
					 
					 
					 echo'<input type="image" src="../images/submit6.png" id="all_submit" style="width:100px">';}
					 
					 
				// <input type="image" src="../images/submit6.png" id="all_submit" style="width:100px" onclick="javascript:return validate()">

					 
					 ?>
					 
					 
					 

					 </td>
            	</tr>
				<tr><td colspan="5"><h1>檢視決策</h1> 
					<h2>各項目目前檢驗等級</h2>
					<?php
					
					//header("Content-type: text/html; charset=utf-8"); 

require_once("../connMysql.php");
mysql_select_db("testabc_main");
					
					//讀取各流程改良累計次數
$monitor_query = "SELECT * FROM process_improvement WHERE `cid` = '$cid' AND `process`='螢幕原料檢驗'";
$monitor_result = mysql_query($monitor_query);
$kernel_query = "SELECT * FROM process_improvement WHERE `cid` = '$cid' AND `process`='kernel原料檢驗'";
$kernel_result = mysql_query($kernel_query);
$keyboard_query = "SELECT * FROM process_improvement WHERE `cid` = '$cid' AND `process`='鍵盤原料檢驗'";
$keyboard_result = mysql_query($keyboard_query);
$check_s_query = "SELECT * FROM process_improvement WHERE `cid` = '$cid' AND `process`='在製品檢驗'";
$check_s_result = mysql_query($check_s_query);
$check_query = "SELECT * FROM process_improvement WHERE `cid` = '$cid' AND `process`='成品檢驗'";
$check_result = mysql_query($check_query);
//統計各流程改良累計次數
/*echo "螢幕原料檢驗目前的等級為:".mysql_num_rows($monitor_result)."級"."<BR><BR>";
echo "Kernel原料檢驗目前的等級為:".mysql_num_rows($kernel_result)."級"."<BR><BR>";
echo "鍵盤原料檢驗目前的等級為:".mysql_num_rows($keyboard_result)."級"."<BR><BR>";
echo "在製品檢驗目前的等級為:".mysql_num_rows($check_s_result)."級"."<BR><BR>";
echo "成品檢驗目前的等級為:".mysql_num_rows($check_result)."級";*/
?>
	<table class="table1">
		
            <thead>
               
                <tr>
                    <td></td>                
                    <th scope="col" style="width:150px">目前檢驗等級</th>                  
					</tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">螢幕原料</th>
                    <td style="text-align:center" id="SupA_Monitor"><?php echo mysql_num_rows($monitor_result)."  級";?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"id="supplyB">Kernel原料</th>         
                    <td style="text-align:center" id="SupB_Monitor"><?php echo mysql_num_rows($kernel_result)."  級";?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">鍵盤原料</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php echo mysql_num_rows($keyboard_result)."  級";?></td>
                </tr>
				<tr>
                    <th scope="row" style="height:45px" id="supplyC">在製品</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php echo mysql_num_rows($check_s_result)."  級";?></td>
                </tr>
				<tr>
                    <th scope="row" style="height:45px" id="supplyC">成品</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php echo mysql_num_rows($check_result)."  級";?></td>
                </tr>
				
				</table>				
					<!--                    <iframe id="showframe" width="450" height="180" marginwidth="10" marginheight="0" frameborder="0">
<a href="http://localhost/projectTest/ABCmain/process.php#tabs-2"  target="框架名稱"></a>

					<h2>進行各項目流程所需成本</h2>

<table class="table1">
		
            <thead>
               
                <tr>
                    <td></td>                
                    <th scope="col" style="width:150px">所需成本</th>                  
					</tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px" id="supplyA">螢幕原料</th>
                    <td style="text-align:center" id="SupA_Monitor"><?php?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"id="supplyB">Kernel原料</th>         
                    <td style="text-align:center" id="SupB_Monitor"><?php?></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px" id="supplyC">鍵盤原料</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php?></td>
                </tr>
				<tr>
                    <th scope="row" style="height:45px" id="supplyC">在製品</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php?></td>
                </tr>
				<tr>
                    <th scope="row" style="height:45px" id="supplyC">成品</th>
                    <td style="text-align:center" id="SupC0_ProductA"><?php?></td>
                </tr>
				
				</table>


-->
					
					
					</iframe>

				</td></tr>
			</table>    
            </form>	
		</div> <!--tab1 end-->
		  			
			</div><!-- Tabs 結束 -->	
    </div><!-- end content -->
<!--<h2>檢視決策</h2>
<div id="showDiv"></div>
<input style="height:250px;weight:100px;" name="show" type="text" >
	
-->
						
		
  			    <!-- Tabs 結束 -->
        
                
            
       
          
      <!-- end content -->
    </body>
</html>
<!--<div id="tabs-2">
                <div style="width:98%;height:95%;background-color:#E3E4FA;">
                    <table border="0" width="98%" height="95%">
                        <tr valign="top" style="width:100%;height:90%;"><td id="view"></td></tr>
                        <tr style="width:100%;height:10%;"><td style="text-align:right"><input type = "image" src = "images/submit.png" id = "all_submit">
                            </td></tr>
                    </table></div>-->
				<!--tab2 end-->
				


