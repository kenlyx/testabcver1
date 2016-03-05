<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/tableyellow1.css"/>
        <script type="text/javascript">
           	var type="A";
			var type="B";
            var month=1;
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                
				$("#s_div").load("./cost_of_sales.php",{'type':"A", 'month':""+month});
                $("#right").click(function(){
                    month+=3;
                    $("#s_div").load("./cost_of_sales.php",{'type':"A", 'month':""+month});
                });
                $("#left").click(function(){
                    if(month-1 > 0)
                        month-=3;
                    else
                        alert("前面沒東西了啦~!!");
                    $("#s_div").load("./cost_of_sales.php",{'type':"A", 'month':""+month});
				
                });
				$("#s_div2").load("./cost_of_sales.php",{'type':"B", 'month':""+month});
                
				$("#right2").click(function(){
                    month+=3;
                    $("#s_div2").load("./cost_of_sales.php",{'type':"B", 'month':""+month});
                });
                
				$("#left2").click(function(){
                    if(month-1 > 0)
                        month-=3;
                    else
                        alert("前面沒東西了啦~!!");
                    $("#s_div2").load("./cost_of_sales.php",{'type':"B", 'month':""+month});
                });
            });
						
        </script>
    </head>
    <body>
    
        <div id="content" style="height:auto">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>銷貨成本分析</h1>
            
            
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="20%" src="../images/product_A.png">
                        <font size="4">筆記型電腦</font>
   
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <img class='logoImage2' border="0" width="20%" src="../images/product_B.png">
                        <font size="4">平板電腦</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
             <table border="0" align="center" width="99%">
             <tr>
                <th height="5%"><input type="image" id="left" src="../images/left.png"></th>
                <th><span id="s_div"></span></th>
                <th height="5%"><input type="image" id="right" src="../images/right.png"></th>
             </tr>
        	 </table>
        </div> <!-- end tab-1 -->
        <div id="tabs-2">
            <table border="0" align="center" width="99%">
            <tr>
                <th height="5%"><input type="image" id="left2" src="../images/left.png"></th>
                <th><span id="s_div2"></span></th>
                <th height="5%"><input type="image" id="right2" src="../images/right.png"></th>
            </tr>
            </table>
         </div> <!-- end tab-2 -->
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>