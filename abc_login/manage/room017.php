<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管二017</title>
<style type="text/css">
body{
	position: relative;
	
}
.table {
	font-family: Arial, Helvetica, sans-serif;
}
.table tr td {
	height: 34px;
	width: 40px;
	text-align:center;
	font-size:16px;
}
#door {
	font-size: 18px;
}
</style>
</head>
<body <?php if(isset($_GET["sbg"])) echo "background=\"bg.png\"";?>>
<b><font size="+3" <?php if(isset($_GET["sbg"])) echo "color=\"#FFF\"";?>> &nbsp;管理會計大學班</font></b>
<p>
<div>
<div id="door" align="right"></div>
<table class="table" border="1px" bordercolor="#999999" width="98%" height="88%" align="center">  
<td align="center" colspan="18" bgcolor="#999999" height="50px">
    <table align="center" border="1px" bgcolor="#FFFFFF" width="68%" height="66%">
        <th>講台</th>
    </table>
	   
</td>
<?php
$txt=array("");
if(isset($_GET["c"])){
	$chosentable=$_GET["c"];
include("phpfinal_connMysql.php");
$seldb = mysql_select_db("test");
if (!$seldb) die("資料庫選擇失敗！");
	$sql="select * from $chosentable";
$result = mysql_query($sql) or die("Query failed");
if($_GET["d"]==1)
	$divide=true;
$i=0;
while($row=mysql_fetch_array($result)){
	$txt[$i]=$row[0]."<br>".$row[1];
	$i++;
	}

}
function gettext(){
	global $txt;
	while($r=rand()%sizeof($txt)){
		if($txt[$r]!="none"){
		$t=$txt[$r];
		$txt[$r]="none";
		return $t;
		}		
	}
}
if($divide==true){
	for($i=1; $i<=9; $i++){	   
		if($i==1){
        	echo '<tr>';
        	for($j=1; $j<=18; $j++){
	        	if($j==4 || $j==15){
		        	echo '<td rowspan="9" bgcolor="#999999">走<br><br>道</td>'; 
			    }else{
					if($j<15&&$j%2==1){
						$a=gettext();
						if(empty($a))
							$a=gettext();
						echo '<td>'.$a.'</td>';
					}elseif($j>15&&$j%2==0){
						$a=gettext();
						if(empty($a))
							$a=gettext();
						echo '<td>'.$a.'</td>';
				}else{
					echo '<td></td>';
				}
		   }
        }
	    	echo '</tr>';	
	}else if($i==9){
	    echo '<tr>';
		for($j=1;$j<=12;$j++){
		    if($j==1 || $j==12)
		        echo '<td colspan="3" bgcolor="#999999"></td>';
		    else{
				if($j%2==0){
					$a=gettext();
				if(empty($a))
					$a=gettext();
				echo '<td>'.$a.'</td>';
				}else{
					echo '<td></td>';
				}
			}

		}
		echo '</tr>';
	}else{
	    echo '<tr>';
		for($j=1;$j<=16;$j++){
			if(($j<4 && $j%2==1)){
				$a=gettext();
	        if(empty($a)){
				$a=gettext();}
		 	if(empty($a)){
				$a=gettext();}
			if(empty($a)){
				$a=gettext();}
			echo '<td>'.$a.'</td>';
			}elseif($j>=4 && $j%2==0){
					$a=gettext();
			    if(empty($a)){
					$a=gettext();}
				if(empty($a)){
					$a=gettext();}
				if(empty($a)){
					$a=gettext();}
				echo '<td>'.$a.'</td>';
			}else{
				echo '<td></td>';
			}
		   
	    }
	    echo '</tr>';
	}
}
	
}else{
for($i=1; $i<=9; $i++){	   
	if($i==1){
        echo '<tr>';
        for($j=1; $j<=18; $j++){
	        if($j==4 || $j==15){
		        echo '<td rowspan="9" bgcolor="#999999">走<br><br>道</td>'; 
		    }else{
				$a=gettext();
				if(empty($a))
					$a=gettext();
				echo '<td>'.$a.'</td>';
		    }
        }
	    echo '</tr>';	
	}else if($i==9){
	    echo '<tr>';
		for($j=1;$j<=12;$j++){
		    if($j==1 || $j==12)
		        echo '<td colspan="3" bgcolor="#999999"></td>';
		    else {
				$a=gettext();
				if(empty($a))
					$a=gettext();
				echo '<td>'.$a.'</td>';}

		}
		echo '</tr>';
	}else{
	    echo '<tr>';
		for($j=1;$j<=16;$j++){
		   $a=gettext();
		   if(empty($a)){
				$a=gettext();}
		 	if(empty($a)){
				$a=gettext();}
			if(empty($a)){
				$a=gettext();}
			echo '<td>'.$a.'</td>';
	    }
	    echo '</tr>';
	}
}
}
?>
 
</table>
</div>
</body>
</html>