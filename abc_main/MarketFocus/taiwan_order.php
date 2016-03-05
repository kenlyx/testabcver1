<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>接單</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="./css/smartTab5_order.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="./js/jquery.js"></script>
        <script type="text/javascript" src="./js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="./css/style.css"/>
        <script type="text/javascript">
            var f_count=0,e_count=0,s_count=0,h_count=0,r_count=0;
            var f_firecount=0,e_firecount=0,s_firecount=0,h_firecount=0,r_firecount=0;
            var current_f=0,current_e=0,current_s=0,current_h=0,current_r=0;
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});

				
				 var RD_done=0;
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
							//alert(str);
                            strs=str.split(",");
							
                            if(strs[0]+strs[1]==0){
							
                                document.getElementById("order_1").style.opacity=0.5;
                                document.getElementById("order_2").style.opacity=0.5;
                                RD_done=0;
                            }
                            else{
							
                                document.getElementById("order_1").style.opacity=1;
                                document.getElementById("order_2").style.opacity=1;
                                RD_done=1;
                            }
							if(RD_done==1){
                        //$("#content").load("order_B2B.html");
						alert("大量訂單的訂單訂貨量較多，須注意價格上的優勢~!!");
						
						
					}
                    else if(RD_done==0){
					alert("tt22");
                        alert("請先於研發介面研發產品！");
                    
                        document.getElementById("tabs-1").src="";
                         document.getElementById("tabs-2").src="";
                }
                        }
                });
               
                    
               
                   
                
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
    
        <div id="content" style="height:116%">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>接單</h1>
            
            
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                      <!--  <img class='logoImage2' border="0" width="20%" src="../images/small.png">
					  -->
                        <font id="order_2" size="4">小量訂單</font>
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <!--
						<img class='logoImage2' border="0" width="20%" src="../images/big.png">
                        -->
						<font id="order_1" size="4">大量訂單</font>
                    </a>
                </li>
            </ul>
            
                        
            <!-- div id="tabs-1" style="width:32%;height:76%; float:right">
            &nbsp;公司接單區 <input type="image" src="../images/submit6.png" id="submit" style="width:100px; float:right">
            </div>
            <div id="tabs-1" style="width:62.57%; height:76%;">
            市場訂單產生區
            </div --><!-- end tab-1 -->
            <!-- div id="tabs-2" style="width:32%;height:76%; float:right">
            &nbsp;公司接單區  <input type="image" src="../images/submit6.png" id="submit" style="width:100px; float:right">
            </div>
            <div id="tabs-2" style="width:62.57%; height:76%">
            市場訂單產生區
            </div --><!-- end tab-2 -->
            
            <!-- div id="tabs-1" style="width:94.57%;height:76%;background-image: url(images/order_bg.jpg);background-size:cover;"></div>
            <div id="tabs-2" style="width:900px;height:500px;background-image: url(images/order_bg.jpg);background-size:cover;"></div -->
            
            
            <iframe id="tabs-1" src="order_B2C.html" style="width:100%;height:76%"></iframe>
            
            <iframe id="tabs-2" src="order_B2B.html" style="width:100%;height:76%">
            </iframe>
            
            <br><br><br>
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>