<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="js/jquery.js"></script>
        <link rel="stylesheet" href="css/style.css"/>  
        <script type="text/javascript">
		
		
        </script>       
</head>

<body color="#d0d0d0">
<div id="content" style="height:95%">
 <a class="back" href=""></a>
            <p class="head">
            Activity Based Costing Simulation System
            </p>
            <h1>信件夾&nbsp;
            	<font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            	* 信件*</font></h1>
             <table class="table1">
             <thead>
             	<tr>
             		<td colspan="2">寄信</td>
             	</tr>
             	  <tr>           
                        <th>公司</th>
                        <th>人</th>
                        <th>內容</th>                                                                  
                    </tr>
                    <tr>
                    	
                    	<td><select id="Company_Name" style="width:150px">
                    	<option>                   	                    	
                    	</option>
                    	</select></td>
                    	<td><select id="Company_People" style="width:150px">
                    	<option>                   	                    	
                    	</option>
                    	</select></td>               
                    	<td><TEXTAREA NAME="Message" ROWS=5 COLS=50 WRAP=VIRTUAL></TEXTAREA></td>
                    </tr>
             </thead>
                         
             <tfoot>
                <tr>
                    <td style="text-align:center"><br><input type="image" src="images/submit6.png" id="submit" style="width:100px">
                    		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
               </tr>
              </tfoot>
              
             
</body>

 <?php 
  include("connMysql.php");
  if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
  mysql_query("set names 'utf8'");
  $C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID` ASC");
  $C_code=array();
  $C_count=0;
  while($company=mysql_fetch_array($C_name))
  {
  	$C_code[$C_count]=$company[$C_count];
  	$C_count++;
  } 
  for($i=1;$i<count($C_code)+1;$i++)
  	{  	
	
  	echo "<script type=\"text/javascript\">";  	
  	echo "document.getElementById(\"Company_Name\").options[$i-1]=new Option(\"C0$i\",\"C0$i\");";  	
  	echo "</script>";
  	}
  	$C_People=array("CEO","CFO","COO","CTO","CMO");
  	for($i=0;$i<count($C_People);$i++)
  	{
  	
  	echo "<script type=\"text/javascript\">";
  	echo "document.getElementById(\"Company_People\").options[$i]=new Option(\"$C_People[$i]\",\"C0$i\");";
  	  	echo "</script>";
  	}
  	
?>


</html>
