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
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="style.css"/>
        <script type="text/javascript">
		  /* function(str){
                            s_str=str.split("|");
                            paople_str=s_str[0].split(",");
                            employee=parseInt(paople_str[0]);
							C_employee=parseInt(paople_str[1]);
                            flag_str=s_str[1].split(",");
							$('#tExt').append("<fieldset style='width:40%;'><legend><font size='2'><b>員工人數/可改良次數</b></font></legend><font size='3'>"+employee+"人/"+(parseInt(employee/5))+"次</font></fieldset>");
                            for(i=0;i<5;i++){
                                flag[i]=parseInt(flag_str[i]);
								if(flag[i]==1){
									$('#view').append("<br/><font size=\"4\">&nbsp&nbsp"+process[i]+"上升了一級</font>");
								}
							}
                        }
            var f_count=0,e_count=0,s_count=0,h_count=0,r_count=0;
            var f_firecount=0,e_firecount=0,s_firecount=0,h_firecount=0,r_firecount=0;
            var current_f=0,current_e=0,current_s=0,current_h=0,current_r=0;
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
				//show current member number
				document.getElementById("has_financial_member").value=current_f;
				document.getElementById("has_resourcing_member").value=current_e;
				document.getElementById("has_sales_member").value=current_s;
				document.getElementById("has_executive_member").value=current_h;
				document.getElementById("has_r&d_team").value=current_r;
				document.getElementById("has_financial_member1").value=current_f;
				document.getElementById("has_resourcing_member1").value=current_e;
				document.getElementById("has_sales_member1").value=current_s;
				document.getElementById("has_executive_member1").value=current_h;
				document.getElementById("has_r&d_team1").value=current_r;
			            });
			//by shiowgwei
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function change(){
				f_count=document.getElementById("get_financial_member").value;
				e_count=document.getElementById("get_resourcing_member").value;
				s_count=document.getElementById("get_sales_member").value;
				h_count=document.getElementById("get_executive_member").value;
				r_count=document.getElementById("get_r&d_team").value*5;
				f_firecount=document.getElementById("get_financial_member1").value;
				e_firecount=document.getElementById("get_resourcing_member1").value;
				s_firecount=document.getElementById("get_sales_member1").value;
				h_firecount=document.getElementById("get_executive_member1").value;
				r_firecount=document.getElementById("get_r&d_team1").value*5;
				hire_total();
				fire_total();
				}*/
        var f_count=0,e_count=0,s_count=0,h_count=0,fire_cost=0,fire=new Array(),machine_A,machine_B;
            $(document).ready(function(){
				get_RD();
                get_machine();
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                $("#pA").click(function(){
                    //alert(machine_A);
                    if(RD_done_A>=1&&machine_A==1)
                        $("div#content2").load("product_A.html");
                    else
                        $("div#content2").html("");
                    if(RD_done_A==0)
                        $("div#content2").append("<font size=4>請先進行研發</font></br>");
                    if(machine_A==0)
                        $("div#content2").append("<font size=4>請購買足夠的機具</font></br>");
                });
                $("#pB").click(function(){
                    //alert(machine_B);
                    if(RD_done_B>=1&&machine_B==1)
                        $("div#content2").load("product_B.html");
                    else
                        $("div#content2").html("");
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
            function get_machine(){
                $.ajax({
                    url: 'machine.php',
                    type:'GET',
                    data: {
                        type: "pp"
                    },
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
                            strs=str.split(",");
                            machine_A=strs[0];
                            machine_B=strs[1];
                            if(strs[0]==0)
                                document.getElementById("pA").style.opacity=0.5;
                            if(strs[1]==0)
                                document.getElementById("pB").style.opacity=0.5;
                        }
                });
            };
            function get_RD(){
                $.ajax({
                    url: 'R&D_kernel.php',
                    type:'GET',
                    data: {
                        result: "detail"
                    },
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							document.getElementById("pA").style.opacity=1;
							document.getElementById("pB").style.opacity=1;
                            strs=str.split(",");
                            RD_done_A=strs[0];
                            RD_done_B=strs[1];
                            if(strs[0]==0)
                                document.getElementById("pA").style.opacity=0.5;
                            if(strs[1]==0)
                                document.getElementById("pB").style.opacity=0.5;
                        }
                });
            };
            function journal(){
                TINY.box.show({iframe:'journal.html',boxid:'frameless',width:800,height:500,style:"z-index:2; top:30px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
                get_machine();
            }
        </script>
    </head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: normal;
            letter-spacing: normal;
            background: #f0f0f0;
        }
        #content{
            background-color:#fff;
            width:780px;
			height:830px;
            padding:40px;
            margin:0 auto;
            border-left:30px solid #1D81B6;
            border-right:1px solid #ddd;
            -moz-box-shadow:0px 0px 16px #aaa;
        }
        .head{
            font-family:Helvetica,Arial,Verdana;
            text-transform:uppercase;
            font-weight:bold;
            font-size:12px;
            font-style:normal;
            letter-spacing:3px;
            color:#888;
            border-bottom:3px solid #f0f0f0;
            padding-bottom:5px;
            margin-bottom:5px;
        }
        .head a{
            color:#1D81B6;
            text-decoration:none;
            float:right;
            text-shadow:1px 1px 1px #888;
        }
        .head a:hover{
            color:#f0f0f0;
        }
        #content h1{
            font-family:"Trebuchet MS",sans-serif;
            color:#1D81B6;
            font-weight:normal;
            font-style:normal;
            font-size:40px;
            text-shadow:1px 1px 1px #aaa;
        }
        #content h2{
            font-family:"Trebuchet MS",sans-serif;
            font-size:28px;
            font-style:normal;
            background-color:#f0f0f0;
            margin:35px 0px 30px -10px;
            padding:0px 40px;
            clear:both;
            float:left;
            width:20%;
            color:#aaa;
            text-shadow:1px 1px 1px #fff;
        }

    </style>
    <body>
    
        <div id="content">
            <a class="back" href=""></a>
            <span class="scroll"></span>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>流程改良</h1>
            
            
        <div id="tabs" class="stContainer" style="width:100%;height:98%">
            <ul style="width: 100%">`
                <li>
                    <a href="#tabs-1">
                        
                        <font size="4">流程改良</font>
   
                    </a>
                </li>
				
            </ul>
			
<div id="tabs-1" style="width:98%;height:600px">


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
    <td align="center"><input type="checkbox">人工小時</td>
    <td align="center"><input type="checkbox">人工小時</td>
    <td align="center"><input type="checkbox">人工小時</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
    <td><img src="../images/sline1.png" /></td>
  </tr>
  <tr>
    <td>原料切割</td>
    <td colspan="2" BGCOLOR=FCFF19><center><input type="checkbox">切割次數</center></td>
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
    <td colspan="2" BGCOLOR=FCFF19><center><input type="checkbox">機器小時</center></td>
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
    <td colspan="2" BGCOLOR=FCFF19><center><input type="checkbox">檢驗次數</center></td>
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
    <td colspan="2" BGCOLOR=FCFF19><center><input type="checkbox">機器小時</center></td>
  </tr>
  <tr>
    <td></td>
    <td><img src="../images/sline1.png" /></td>
        <td align="center"  colspan="2"><img src="../images/sline1.png" /></td>

  </tr>
  <tr>
    <td>精密檢測</td>
    <td colspan="3" BGCOLOR=FCFF19><center><input type="checkbox">檢驗次數</center></td>
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
				<td><br><input type="image" src="../images/submit6.png" id="submit" style="width:100px"></td>
				</tr>
</table>
            
<h2>檢視決策</h2>
            

            </div>
     

         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>