<?php @session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../css/tableyellow.css" type="text/css" />
        <script type="text/javascript" src="../js/jquery.js"></script>
<?php
    $month=$_SESSION['month'];
	$year=$_SESSION['year'];
	//取上一回合來report，ex. 1年5月 => reportm = 4 ,reports = 1, reporty = 0;
	$reportm=12*($year-1)+$month-1;
?>        
		<script type="text/javascript">
            var type=1;
            var month=1;
            $(document).ready(function(){
				    var re_m=<?php echo $reportm ?>;					
					if(re_m<3){
						document.getElementById("season").style.opacity=0.5;
						document.getElementById("year").style.opacity=0.5;
					}else if(re_m<12)
						document.getElementById("year").style.opacity=0.5;
					else{
						document.getElementById("season").style.opacity=1;
						document.getElementById("year").style.opacity=1;
					}
							
                	$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
               		$("#right").click(function(){
						month+=1;
                   		$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
               		});
                	$("#left").click(function(){
						if(month-1> 0)
                        	month-=1;
                    	else
                        	alert("前面沒東西了啦~!!");
                    	$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
                	});
                	$("#month").click(function(){
                    	type=1;
                    	month=1;
                    	$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
               		});
                	$("#season").click(function(){
                    	type=2;
                    	month=1;
						if(re_m>2)
                    	$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
						else
							alert("尚未有季報以供參閱!");
                	});
                	$("#year").click(function(){
                    	type=3;
                   		month=1;
						if(re_m>11)
                    	$("#s_div").load("./cashflow.php",{'type':""+type, 'month':""+month});
						else
							alert("尚未有年報以供參閱!");
                	});
                	$("#back").click(function(){
                    	location.href="./pre_report_3.php";
                	});
				//}
            });
        </script>
    </head>
   
    <body>
        <table border="0" height="85%">
            <tr><th colspan="3" height="60">
                    <input id="month" type="image" src="../images/report_month.png" title="月報" width="50" >
                    <input id="season" type="image" src="../images/report_season.png" title="季報" width="50">
                    <input id="year" type="image" src="../images/report_year.png" title="年報" width="50">
                    <input id="back" type="image" src="../images/next.png" title="重新選擇" width="50">
            </tr>
            <tr Valign="top"><th ><input type="image" id="left" src="../images/left.png"></th>
                <th ><div id="s_div"></div></th>
                <th ><input type="image" id="right" src="../images/right.png"></th></tr>
        </table>
    </body>
</html>
