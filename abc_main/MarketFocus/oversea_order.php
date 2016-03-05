<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>接單</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript">
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
				}

        </script>
    </head>
    <body>
    
        <div id="content">
            <a class="back" href=""></a>
            <span class="scroll"></span>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>接單 <font size="5px">- 國外訂單</font></h1>
            
            
        <div id="tabs" class="stContainer" style="width:99%;height:72%">
            <ul style="width: 99%">`
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="20%" src="../images/small.png">
                        <font size="4">小量訂單</font>
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <img class='logoImage2' border="0" width="20%" src="../images/big.png">
                        <font size="4">大量訂單</font>
                    </a>
                </li>
            </ul>
            <div id="tabs-1" style="width:33.4%;height:97%; float:right">
            &nbsp;公司接單區 <input type="image" src="../images/submit6.png" id="submit" style="width:100px; float:right">
            </div>
            <div id="tabs-1" style="width:61.4%; height:97%;">
            市場訂單產生區
            </div><!-- end tab-1 -->
            <div id="tabs-2" style="width:33.4%;height:100%; float:right">
            &nbsp;公司接單區  <input type="image" src="../images/submit6.png" id="submit" style="width:100px; float:right">
            </div>
            <div id="tabs-2" style="width:61.4%; height:100%">
            市場訂單產生區
            </div><!-- end tab-2 -->
            <br><br><br>
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>