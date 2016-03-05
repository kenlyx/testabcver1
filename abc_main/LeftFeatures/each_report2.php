<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style_report.css"/>
        <script type="text/javascript">
            var type="A";
			var type="B";
            var month=1;
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                
            });
		</script>
    </head>
       <body>
    
        <div id="content">
            <a class="back" href=""></a><!--
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>報表</h1>-->
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                        <font size="4">現金流量表</font>
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <font size="4">財務狀況表</font>
                    </a>
                </li>
				<li>
                    <a href="#tabs-3">
                        <font size="4">綜合損益表</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
        	<iframe style=" margin-left:0px; margin-top:3px;" width='100%' height='90%' marginwidth='0' marginheight='0' align='center' frameborder='0' src='./pre_report_3.php'></iframe>
        </div> 
              <div id="tabs-2">
              <iframe style=" margin-left:0px; margin-top:3px;"  width='100%' height='90%' marginwidth='0' marginheight='0' align='center' frameborder='0' src='./pre_report_2.php'></iframe>
            </div>
			<div id="tabs-3">
            <iframe style=" margin-left:0px; margin-top:3px;"  width='100%' height='90%' marginwidth='0' marginheight='0' align='center' frameborder='0' src='./pre_report.php'></iframe>
            </div>
		   
    
        </div><!--end of tabs -->
       </div><!-- end content -->
    </body>
</html>