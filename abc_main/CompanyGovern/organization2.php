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
  
	}); // end ready func
          
			 //錢，三位一數			
			 function addCommas(nStr)
				{
					nStr += '';
					x = nStr.split('.');
					x1 = x[0];
					x2 = x.length > 1 ? '.' + x[1] : '';
					var rgx = /(\d+)(\d{3})/;
					while (rgx.test(x1)) {
						x1 = x1.replace(rgx, '$1' + ',' + '$2');
					}
					return x1 + x2;
				} 

        </script>
    </head>
   
    <body>
    
        <div id="content" style="height:auto">
            <a class="back" href=""></a>
            <p class="head">
            Activity Based Costing Simulation System
            </p>
            <h1>組織架構和決策分配&nbsp;
            <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            * 這部分已在年初時由總經理代表全公司做下決策 *</font></h1>
            <p>
           <table align="center" border="0">
                <iframe width="98%" height="92%" marginwidth="0" marginheight="0" frameborder="0" src='./organization.php'></iframe>	
           </table>
        </div><!-- end content -->
    </body>
</html>