<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/sell_machine.css">
        
        <script type="text/javascript">
			
            $(document).ready(function(){
				var sell = new Array();
				
				$(".sell").click(function(){
					$("input:checked").each(function(i) {
					sell.push($(this).val());
					});
					alert(sell);
					var agree=confirm("處分後將無法復原，請問您確認要處理掉這些機具嗎?");
					if(agree){
						$.post("machineDB.php", {
 							sell:sell,
				    		},function(xml){ 
								//alert(xml);
							 	alert("Sell Success!");
								location.href=('./sell_machine2.php');
							}//end function(xml);
				    );//end post
					}
                }); //end sell click func
			}); // end ready func


        </script>
    </head>
   
    <body>
    
        <div id="content" class="container-fluid">
            <h1>處分資產 <small style="color:#ff0000;">* 處分掉機具將無法復原，請謹慎做決策 *</small></h1>
            <div class="panel panel-danger">
                <div class="panel-heading"><h2>處分公司機具</h2></div>
                    <table class="table table-bordered table-striped table-condensed tablefont">
            	       <thead>
                        <tr>
                            <th>購買日期</th>
                    	   <th>機具功能</th>
                            <th>機具型別</th>
                            <th>購買價格</th>
                            <th>累積折舊</th>
                            <th>處分</th>
                        </tr>
            	       </thead>
<?php
	include("../connMysql.php");
   	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round_now=12*($year-1)+$month;
		
	$func=array('cut'=>'原料切割','combine1'=>'第一層組裝','combine2'=>'第二層組裝','detect'=>'檢測機具');
	
	$get_cutprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
    $cutprice=mysql_fetch_array($get_cutprice);
	$get_com1price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
    $com1price=mysql_fetch_array($get_com1price);
	$get_com2price=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
    $com2price=mysql_fetch_array($get_com2price);
	$get_detprice=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
    $detprice=mysql_fetch_array($get_detprice);
	
	$type=array('A'=>1,'B'=>2,'C'=>3);
	
	$sql_machine=mysql_query("SELECT * FROM `machine` WHERE `cid`='$cid' and `sell_month`='99' and ((`buy_year`-1)*12+`buy_month`)<$round_now");
    $rows_m = mysql_num_rows($sql_machine); //總行數=未出售的機具總數
	$perpage = $rows_m; //每頁筆數=未出售的機具總數。
	$total_pages=ceil($rows_m/10); //總頁數
	$pages=" ";
	
	if (!isset($_GET['nowPage'])){ 
		$pages = 1; //預設為第1頁
	}else{
		$pages = $_GET['nowPage']; //點選的頁數
	}
	$start = ($pages -1)*$perpage; //資料庫取資料範圍的起始值。
	//2015.6.2這是林登庸改的(偷偷跟你們講這個code變數很亂我也不想改了 交給你們學弟去加油了 反正沒有bug啦 只是程式碼很醜)
	//不計算本回合機具
	$sql_machine2=mysql_query("SELECT * FROM `machine` WHERE `cid`='$cid' and `sell_month`='99' and ((`buy_year`-1)*12+`buy_month`)<$round_now ORDER BY `machine`.`index` ASC LIMIT $start,$rows_m");
    $rows_m2= mysql_num_rows($sql_machine2); //一頁行數=未出售的機具總數
	
	echo "<tbody>";
	if($rows_m!=0){
		$i=0;
		while($machine=mysql_fetch_array($sql_machine2)){
			echo "<tr>";
			//get machine detail
			$machine_num[$i]=$machine['index'];
			$machine_func[$i]=$machine['function'];
			$machine_type[$i]=$machine['type'];
			$machine_by[$i]=$machine['buy_year'];
			$machine_bm[$i]=$machine['buy_month'];
			$round_buy=($machine_by[$i]-1)*12+$machine_bm[$i];
			
			//echo
			//機具編號
			//echo "<td id='index'>".$machine_num[$i]."</td>";
            //購買年月
			echo "<td id='date'>第".$machine_by[$i]."年 ".$machine_bm[$i]."月</td>";
			//機具功能
			echo "<td id='func'>".$func[$machine_func[$i]]."</td>";
			
			//機具型別
			if($machine_func[$i]=='detect'){
				echo "<td id='type'>";
				if($machine_type[$i]=='A'){
					$type[$i]="合格檢測";
					echo $type[$i]."</td>";
				}else if($machine_type[$i]=='B'){
					$type[$i]="精密檢測";
					echo $type[$i]."</td>";}//end if type
			}else{
				$type[$i]=$machine_type[$i];
				echo "<td id='type'>".$type[$i]."</td>";
			}

			
			
			//購買價格、累計折舊
			if($machine_func[$i]=='cut'){
				$cutp1=$cutprice[$type[$machine_type[$i]]];
				$cutp2=number_format($cutprice[$type[$machine_type[$i]]]);
				echo "<td id='price_cut'>".$cutp2."</td>";
				$depre=number_format($cutp1*($round_now-$round_buy)/120,2);
				echo "<td id='depre'>".$depre."</td>";
			}else if($machine_func[$i]=='combine1'){
				$com1p1=$com1price[$type[$machine_type[$i]]];
				$com1p2=number_format($com1price[$type[$machine_type[$i]]]);
				echo "<td>".$com1p2."</td>";
				$depre=number_format($com1p1*($round_now-$round_buy)/120,2);
				echo "<td>".$depre."</td>";
			}else if($machine_func[$i]=='combine2'){
				$com2p1=$com2price[$type[$machine_type[$i]]];
				$com2p2=number_format($com2price[$type[$machine_type[$i]]]);
				echo "<td>".$com2p2."</td>";
				$depre=number_format($com2p1*($round_now-$round_buy)/120,2);
				echo "<td>".$depre."</td>";
			}else if($machine_func[$i]=='detect'){
				$detp1=$detprice[$type[$machine_type[$i]]];
				$detp2=number_format($detprice[$type[$machine_type[$i]]]);
				echo "<td>".$detp2."</td>";	
				$depre=number_format($detp1*($round_now-$round_buy)/120,2);
				echo "<td>".$depre."</td>";
			}
			
			echo "<td><input type='checkbox' name='check[]' value='".$machine_num[$i]."_".$func[$machine_func[$i]]."_".$type[$i]."'/></td></tr>";	
		
			
			$i++;
		}//end while
		

?>
   		</tbody>
            <tfoot id="tfoot">
                <tr class="text-center">
                   <td colspan="7">
                       <input class="btn btn-primary btn-lg sell" type="button" value="Submit">
                    </td>
                </tr>
                <!--<tr>
                  <th colspan="7"><br>
                        <?php /* echo "第 ";
					       for ($i=1;$i<= $total_pages;$i++){
						  echo ' <a href="sell_machine2.php?nowPage='.$i.'" > '.$i.'</a>                                  &nbsp;'; //列出所有頁碼。
					   }
					       echo "頁";*/ //這是前年學長想要做的功能(就是1頁面只顯示10個資產，並且可以用頁面選擇方式選擇資產)
				        ?>
                </th>
                </tr>-->
            </tfoot>    
        </table>
<?php		
	}else{
		echo "<td colspan='7'>... 本公司目前沒有機具以供處分 ...</td>";
		echo "</tbody></table>";	
	}

?>         
        </div> 
        </div><!-- end content -->
    </body>
</html>