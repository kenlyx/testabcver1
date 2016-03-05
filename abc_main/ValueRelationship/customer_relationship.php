<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../star/training_jquery.rating.js"></script>
        <link href="../star/customer_rating.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
		 	var cus=new Array(); 
			var isvalid=true;
			
			$(document).ready(function(){
			   
			   $("#submit").click(function(){
	
					/*for(var i=0; i<cus.length; i++){
						var isvalid=check(p[i],r[i]);
						if(isvalid==false){
							alert("請確認部門人數在有效範圍內(>0)!");
								break;
						}
			 		 }*/
					 if(cus.length>0){
						for(var i=0;i<cus.length;i++){
                   			$.ajax({
                       			url:"relationship.php",
                        		type: "GET",
                        		datatype: "html",
                        		data: "option=update&decision="+cus[i],
                        		error:
                            		function(xhr) {alert('Ajax request 發生錯誤');},
                        		success: function(str){
									//alert(str);
                            		alert("Success!");
									location.href=('./customer_relationship.php');
                        		}
                    		});//end ajax
					 	}
					 }//end if
				});//end submit
			 });
		function rate(customer,rate){
			var l; //同一顧客在陣列中的位置
			isvalid=true;
			//alert(customer+"&"+rate);
			
			//檢查陣列中是否已有該顧客
			for(var x=0;x<cus.length;x++){
				//陣列中資料存customer_rate，但只需比對顧客，故切割
				var c=cus[x].split("_");
				if(c[0]==customer){
					isvalid=false;
					l=x;
					break;
				}	
			}
			
			if(isvalid)
				cus.push(customer+"_"+rate); //陣列中尚未有此顧客，加一筆新資料
			else
				cus[l]=customer+"_"+rate;    //陣列中已有此顧客，取代舊資料的rate	
			
			//alert(cus[0]+"|"+cus[1]+"|"+cus[2]);	
			//alert(cus.length);
			//alert(eval(c+"="+rate));
			}
          
        </script>
    </head>
   
<?php
	include("../connMysql.php");
   	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$thisround=12*($year-1)+$month;
	$cusarray="";
	error_reporting(0);
	
    //UPDATE -------------------------------------------------------------------------------------------------------------------------
	if(!strcmp($_GET['type'],"update")){	
		$sql_allcus=mysql_query("SELECT `customer` FROM `customer_satisfaction` WHERE `cid`=$cid");
		$allcus=mysql_fetch_array($sql_allcus);
		$dicision=$GET['stars'];
	}
	//大訂單join table-----------------------------------------------------------------------------------------------------------------
	$b_customer1=mysql_query("SELECT distinct `order_accept`.`b_or_c`,`customer_satisfaction`.* FROM `customer_satisfaction` LEFT JOIN `order_accept` on `order_accept`.`customer`=`customer_satisfaction`.`customer` WHERE `order_accept`.`b_or_c`=1 ");
	$b_c= mysql_num_rows($b_customer1); //總行數=所有接到的單
	
	$perpage = 10; //每頁筆數。
	$b_total_pages=ceil($b_c/10); //總頁數
	$b_pages=" ";
	
	if (!isset($_GET['nowPage'])){ 
		$b_pages = 1; //預設為第1頁
	}else{
		$b_pages = $_GET['nowPage']; //點選的頁數
	}
	$b_start = ($b_pages -1)*$perpage; //資料庫取資料範圍的起始值。
	
	//不計算本回的顧客，b_or_c=0代表小量訂單
	$b_customer2=mysql_query("SELECT distinct `order_accept`.`b_or_c`,`customer_satisfaction`.* FROM `customer_satisfaction` LEFT JOIN `order_accept` on `order_accept`.`customer`=`customer_satisfaction`.`customer` WHERE `order_accept`.`b_or_c`=1 ORDER BY `customer_satisfaction`.`satisfaction` DESC LIMIT $b_start,$perpage");
    $b_c2= mysql_num_rows($b_customer2); //一頁行數(10)
	
	//小訂單join table-----------------------------------------------------------------------------------------------------------------
	$s_customer1=mysql_query("SELECT distinct `order_accept`.`b_or_c`,`customer_satisfaction`.* FROM `customer_satisfaction` LEFT JOIN `order_accept` on `order_accept`.`customer`=`customer_satisfaction`.`customer` WHERE `order_accept`.`b_or_c`=0 ");
	$s_c= mysql_num_rows($s_customer1); //總行數=所有接到的單
    //echo $s_c;	
	$perpage = 10; //每頁筆數。
	$s_total_pages=ceil($s_c/10); //總頁數
	$s_pages=" ";
	
	if (!isset($_GET['nowPage']))
		$s_pages = 1; //預設為第1頁
	else
		$s_pages = $_GET['nowPage']; //點選的頁數
	
	$s_start = ($s_pages -1)*$perpage; //資料庫取資料範圍的起始值。
	
	//不計算本回的顧客，b_or_c=0代表小量訂單
	$s_customer2=mysql_query("SELECT distinct `order_accept`.`b_or_c`,`customer_satisfaction`.* FROM `order_accept` LEFT JOIN `customer_satisfaction` on `order_accept`.`customer`=`customer_satisfaction`.`customer` WHERE `order_accept`.`b_or_c`=0 ORDER BY `customer_satisfaction`.`satisfaction` DESC LIMIT $s_start,$perpage");
    $s_c2= mysql_num_rows($s_customer2); //一頁行數(10)	
	
?>

    <body style="overflow:hidden">
    
        <div id="content"  style="overflow:scroll; height:92%">
            <a class="back" href=""></a>
            <p class="head">
                Activity Based Costing Simulation System
            </p>
            <h1>關係管理&nbsp;
            	<font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            	*  *</font></h1>
			<div id="tabs" class="stContainer">
             <ul>
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="22%" src="../images/r3.png">
                        <font size="4">顧客</font>
   
                    </a>
                </li>
            </ul>
            <div id="tab-1">
                <table class="table1" style="float:right" width="48%">
            	<thead>
                	<tr>
                    	<td colspan="2"><img border="0" width="12%" src="../images/big.png">大量訂單</td>
                    	<td align="right"><br>
                	<?php  echo "第 ";
						for ($i=1;$i<= $b_total_pages;$i++){
							echo ' <a href="customer_relationship.php?nowPage='.$i.'" > '.$i.'</a> &nbsp;'; //列出所有頁碼。
						}
						echo "頁";
					?>
                	</td></tr>
                    <tr>
                    	<th>顧客名稱</th>
                    	<th>滿意度</th>
                        <th colspan="2">提升等級</th>
                    </tr>
            	</thead>
	<?php
	
	echo "<tbody>";
	if($b_c!=0){
		$i=1;
		while($b_customer=mysql_fetch_array($b_customer2)){
			echo "<tr>";
			//get customer detail
			//$bc_index[$i]=$b_customer['index'];
			$bc_name[$i]=$b_customer['customer'];
			$bc_satisfaction[$i]=$b_customer['satisfaction'];
			
			//顧客名稱
			echo "<td id='b_name'>".$bc_name[$i]."</td>";
			
		    //顧客滿意度
			echo "<td id='b_stf'>".$bc_satisfaction[$i]."</td>";
?>		
			<td colspan="2" width="30%"><span class="rating" id="b_rate<?php echo $i?>"></span>
			     <script type="text/javascript">
					$('#b_rate<?php echo $i?>').rating('./customer_relationship.php',{maxvalue:3, emp:"<?php echo $bc_name[$i]?>"});
                 </script>
		    </td> 
<?php	
		
		$i++;
		}//end while
		echo "</tbody></table>";

    }else{
		echo "<td colspan='7'>... 本公司尚未接到訂單喔 ...</td>";
		echo "</tbody></table>";	
	}
?>        
            <table class="table1" width="48%">
            	<thead>
                	<tr>
                    	<td colspan="2"><img border="0" width="12%" src="../images/small.png">小量訂單</td>
                    	<td align="right"><br>
                	<?php  echo "第 ";
						for ($i=1;$i<= $s_total_pages;$i++){
							echo ' <a href="customer_relationship.php?nowPage='.$i.'" > '.$i.'</a> &nbsp;'; //列出所有頁碼。
						}
						echo "頁";
					?>
                	</td></tr>
                    <tr>
                    	<th>顧客名稱</th>
                    	<th>滿意度</th>
                        <th colspan="2">提升等級</th>
                    </tr>
            	</thead>
	<?php
	
	
	echo "<tbody>";
	if($s_c!=0){
		$j=1;	
		while($s_customer=mysql_fetch_array($s_customer2)){
				//get customer detail
				$sc_name[$j]=$s_customer['customer'];
				$sc_satisfaction[$j]=$s_customer['satisfaction'];
			
				echo "<tr>";
				//顧客名稱
				echo "<td id='name$j'>".$sc_name[$j]."</td>";
			
		    	//顧客滿意度
				echo "<td id='stf$j'>".$sc_satisfaction[$j]."</td>";
				?>		
				<td colspan="2" width="30%"><span class="rating" id="rate<?php echo $j;?>"></span>
			    <script type="text/javascript">
					$('#rate<?php echo $j;?>').rating('./customer_relationship.php',{maxvalue:3, emp:"<?php echo $sc_name[$j]?>"});
                 </script>
		    	</td> 
				<?php
			$j++;
		}//end while
		echo "</tbody></table>";	
		
    }else{
		echo "<td colspan='7'>... 本公司尚未接到訂單喔 ...</td>";
		echo "</tbody></table>";	
	}
?>
    <table class="table1" width="96%" align="center">
        <tfoot id="tfoot">
        	<tr>
            	<td colspan="7"><br>
                   	<input type="image" src="../images/submit6.png" id="submit" style="width:100px"></td>
            </tr>
        </tfoot>    
   	</table>   
        </div>
        </div>
        </div><!-- end content -->
    </body>
</html>