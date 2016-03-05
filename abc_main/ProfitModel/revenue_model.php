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
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
            });
						
        </script>
    </head>
    <body>
    
        <div id="content">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>營收模式</h1>
            
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

        <div id="tabs-1" style="height:74%">
        	<table align="center" border="0" class="table1">
            <tfoot>
            <tr><td>
           <iframe style="margin-top:1%; left:-2%;" width='900px' height='700px' frameborder='0' src='./revenue_sources_A.html'></iframe>
        	</td></tr>
            </tfoot>
            </table>
        </div> <!-- end tab-1 -->
        <div id="tabs-2" style="height:74%">
           <table align="center" border="0" class="table1">
            <tfoot>
            <tr><td>
           <iframe style="margin-top:1%; left:-2%;" width='900px' height='700px' frameborder='0' src='./revenue_sources_B.html'></iframe>
        	</td></tr>
            </tfoot>
            </table>
         </div> <!-- end tab-2 -->
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>