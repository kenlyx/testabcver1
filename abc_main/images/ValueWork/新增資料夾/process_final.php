<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js" ></script>
        <script type="text/javascript" src="../js/tinybox.js"></script>
        <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery.smartTab.js"></script>
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
    <div id="content">
	
        <h1>流程改良</h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer">
  			<ul>
  				<li>
                <a href="#tabs-1">	
                	<h2>流程改良</h2>
            	</a>
                </li>
				<a href="#tabs-2">
                	<h2>檢視決策</h2>
            	</a>
                </li>
  			</ul>
  			<div id="tabs-1">
            <form method="POST" name="form1" action="process.php">
                        <table width="450" border="0" cellspacing="0" cellpadding="0">
            	<tr>
                	<td align="left" colspan="4">員工人數:
                    <?php
                    /*
					$all_people = mysql_query("SELECT * FROM `current_people` WHERE `CompanyName` = '$CompanyName';", $connect);
    				$people=0;
					while ($row = mysql_fetch_array($all_people)) {
						if ($row['department'] == "research") {
							if (($row['month']  < $month && $row['year'] = $year )|| $row['year'] < $year) {
								$people = $people + $row['hire_count'];
								$people = $people - $row['fire_count'];
							}
						}
					}
					$all_people=$people;
					*/
					?>
                    </td>
                </tr>	
                <tr> 
                    <td align="left" colspan="4">可改良次數:</td>
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
                    <!--<input type="image" src="../images/submit6.png" id="all_submit" style="width:100px" >-->
                    <input type="submit" id="all_submit">
                    </td>
				</tr>
			</table>    
            </form>	
			
    
<h2>檢視決策</h2>
<div id="showDiv"></div>
<input style="height:250px;weight:100px;" name="show" type="text" >
		
			</div>
  			 
		</div>    <!-- Tabs 結束 -->
        <!--<div id="tabs-2" style="width:98%;height:90%;">
                <div style="width:98%;height:95%;background-color:#E3E4FA;">
                    <table border="0" width="98%" height="95%">
                        <tr valign="top" style="width:100%;height:90%;"><td id="view"></td></tr>
                        <tr style="width:100%;height:10%;"><td style="text-align:right"><input type = "image" src = "images/submit.png" id = "all_submit">
                            </td></tr>
                    </table></div>-->
            </div>    
            
       
          -
      </div><!-- end content -->
    </body>
</html>
