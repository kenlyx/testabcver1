<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>無標題文件</title>
	<link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
    <link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
	<div id="content">
        <a class="back" href=""></a>
        <p class="head">
        Activity Based Costing Simulation System
        </p>
        <h1>預算編製
        <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
        * 進行每年花費之規劃 *</font></h1>
        <div align="center">
            <input type="image" src="../images/sell.png" id="finance" value="財務部門" />
            <input type="image" src="../images/right.png" />
            <input type="image" src="../images/produce2.png" id="produce" value="生產部門" />
            <input type="image" src="../images/right.png" />
            <input type="image" src="../images/purchase2.png" id="purchase" value="採購部門" />
            <input type="image" src="../images/right.png" />
            <input type="image" src="../images/human2.png" id="human" value="人力部門" />
            <input type="image" src="../images/right.png" />
            <input type="image" src="../images/admin2.png" id="admin" value="行政部門" />
        </div>
        <p>
       <table id="show" align="center" border="0">
            <iframe id="frame" width="98%" height="90%" marginwidth="0" marginheight="0" frameborder="0" src='./Budget_Set_finance.php'></iframe>	
       </table>
    </div><!-- end content -->

</body>
<script type="text/javascript">
	$(document).ready(function(){
        $('#finance').click(function() {
            document.getElementById("frame").src='./Budget_Set_finance.php';
			document.getElementById("finance").src='../images/sell.png';
			document.getElementById("produce").src='../images/produce2.png';
			document.getElementById("purchase").src='../images/purchase2.png';
			document.getElementById("human").src='../images/human2.png';
			document.getElementById("admin").src='../images/admin2.png';
        });
		$('#produce').click(function() {
            document.getElementById("frame").src='./Budget_Set_produce.php';
			document.getElementById("finance").src='../images/sell2.png';
			document.getElementById("produce").src='../images/produce.png';
			document.getElementById("purchase").src='../images/purchase2.png';
			document.getElementById("human").src='../images/human2.png';
			document.getElementById("admin").src='../images/admin2.png';
        });
		$('#purchase').click(function() {
            document.getElementById("frame").src='./Budget_Set_purchase.php';
			document.getElementById("finance").src='../images/sell2.png';
			document.getElementById("produce").src='../images/produce2.png';
			document.getElementById("purchase").src='../images/purchase.png';
			document.getElementById("human").src='../images/human2.png';
			document.getElementById("admin").src='../images/admin2.png';	
        });
		$('#human').click(function() {
			document.getElementById("frame").src='./Budget_Set_human.php';
			document.getElementById("finance").src='../images/sell2.png';
			document.getElementById("produce").src='../images/produce2.png';
			document.getElementById("purchase").src='../images/purchase2.png';
			document.getElementById("human").src='../images/human.png';
			document.getElementById("admin").src='../images/admin2.png';
		});
		$('#admin').click(function() {
            document.getElementById("frame").src='./Budget_Set_admin.php';
			document.getElementById("finance").src='../images/sell2.png';
			document.getElementById("produce").src='../images/produce2.png';
			document.getElementById("purchase").src='../images/purchase2.png';
			document.getElementById("human").src='../images/human2.png';
			document.getElementById("admin").src='../images/admin.png';
        });
    });
</script>
</html>