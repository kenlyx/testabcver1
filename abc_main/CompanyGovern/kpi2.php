<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        
		<style type="text/css">
		        
		@charset "utf-8";
			body{
				background-size:cover;
				text-align:center;
			}
			table{
				border-style:double;
				border-width:10px;
				border-color:000000;
				-webkit-border-radius: 10px;
				color:#000;
				font-family:微軟正黑體,Ariel;
			}

				@media screen and (max-width: 768px) {
					#kpisub{font-size: 15px;}
				}
			
		
		</style>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" >
        
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
    <?php
		$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
		$session=$_SESSION['month']-1+($_SESSION['year']-1)*12;
		mysql_select_db("testabc_login", $connect);
		$cid=$_SESSION['cid'];
		/*$temp=mysql_query("SELECT `Position` FROM `authority` WHERE `Account` = '{$_SESSION['user']}'",$connect);
		$result_temp=mysql_fetch_array($temp);
		$position=$result_temp[0];*/
	?>
  <div class="container">
  <div class="panel panel-success">
  <div class="panel-heading"><h1 body style="color:#6666FF;" id="kpisub">KPI 關鍵績效指標&nbsp;
            <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            * 將年度預測的KPI與公司實際營運的KPI做比對，達成率將列入競賽評分的標準 *</font></h1></div>
            
           

 <table class="table table-bordered table-striped">
	  <tr >
	    <th  scope="col" ><p align="center" >KPI名稱</th>
	    <th  scope="col"><p align="center">年度預測值</th>
	    <th  scope="col"><p align="center">實際營運值</th>
	    <th scope="col"><p align="center">狀態燈</th>
	  </tr>
	<?php 
		include './ConnectDB.php';//連主控台DB改帳密!!!!!
		
		$sql_kpiName = mysql_query("select * from kpi_abc");//這裡要改自己的table,kpi_inception或kpi_abc
		
		$num = mysql_num_rows($sql_kpiName);
		$kpinum = 0; 
		
		include('./ConnectMysql.php');//連自己DB
		$sql_kpi = mysql_query("select * from kpi_info where account='".$cid."' and session='".$session."'");
		//echo"select * from kpi_info where account='".$cid."' and session='".$session."'";
		$kpi = mysql_fetch_array($sql_kpi);
		
		while($kpiName = mysql_fetch_array($sql_kpiName)){
			$kpinum+=1;
		        if($kpi[$kpinum*2+1]!=0)
		            $proportion=round($kpi[$kpinum*2]/$kpi[$kpinum*2+1],2);
			else
		            $proportion=0;
		        $pro=$proportion*100;
			
			if($proportion<=0.5)
				$light="red";
			else if($proportion<=0.8)
				$light="yellow";
			else
				$light="green";
			echo'
		  <tr>
		    <th scope="row">'.$kpiName[0].'</th>
				
		    <td>
		      '.number_format($kpi[$kpinum*2+1]).'
		    </td>
		    <td>
		     '.number_format($kpi[$kpinum*2]).'
		   </td>
		   <td style="text-align:center;">
		      <!--<input name="light" type="image" src="./images/'.$light.'_light.png" id="light width="40" height="40" title="目前已達成'.$pro.'%"/>-->
				<img src="./images/'.$light.'_light.png" width="40" height="40" title="目前已達成'.$pro.'%" class="img-circle">
		    </td>
		  </tr>
			';	
		}
	?>
</table>

 </div><!-- end content -->
</body>
</html>