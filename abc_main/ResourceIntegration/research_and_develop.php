<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <?php 
	$cid=$_SESSION['cid'];
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	
	$sql_year=mysql_query("SELECT MAX(`year`) FROM `state`");
	$year=mysql_fetch_array($sql_year);
	$year=$year[0];
	$sql_month=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year");
	$month=mysql_fetch_array($sql_month);
	$month=$month[0];
	//echo $year."|".$month."|".$cid;
	
	$state="* 單個月內只允許研發一項產品，請選擇任一產品予以研發 *";
	
	$sql_rdA=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_A_RD`='1' ");
	$rdA=mysql_fetch_array($sql_rdA);//研發過A的回合資料
	$rd_rowA=mysql_num_rows($sql_rdA);
	//echo $rd_rowA;
	
	$sql_rdB=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_B_RD`='1' ");
	$rdB=mysql_fetch_array($sql_rdB);//研發過B的回合資料
	$rd_rowB=mysql_num_rows($sql_rdB);
	//echo $rd_rowB;
	
//-----------------------------------------------------供應商a---------------------------------------------------//		

	$sql_aA1=mysql_query("SELECT * FROM `supplier_a` WHERE `cid` = '".$cid."'and `type`='A' and `source`='1'");
	$aA1_row=mysql_num_rows($sql_aA1);
	if($aA1_row!=0)
		$aA1=mysql_fetch_array($sql_aA1);//向供應商a研發過(A產品,panel)的回合資料
	else
		$aA1['quantity']=0;
	
	$sql_aA2=mysql_query("SELECT * FROM `supplier_a` WHERE `cid` = '".$cid."'and `type`='A' and `source`='2'");
	$aA2_row=mysql_num_rows($sql_aA2);
	if($aA2_row!=0)
		$aA2=mysql_fetch_array($sql_aA2);//向供應商a研發過(A產品,cpu)的回合資料
	else
		$aA2['quantity']=0;
	
	$sql_aA3=mysql_query("SELECT * FROM `supplier_a` WHERE `cid` = '".$cid."'and `type`='A' and `source`='3'");
	$aA3_row=mysql_num_rows($sql_aA3);
	if($aA3_row!=0)
		$aA3=mysql_fetch_array($sql_aA3);//向供應商a研發過(A產品,keyboard)的回合資料
	else
		$aA3['quantity']=0;
	
	$sql_aB1=mysql_query("SELECT * FROM `supplier_a` WHERE `cid` = '".$cid."'and `type`='B' and `source`='1' ");
	$aB1_row=mysql_num_rows($sql_aB1);
	if($aB1_row!=0)
		$aB1=mysql_fetch_array($sql_aB1);//向供應商a研發過(B產品,panel)的回合資料
	else
		$aB1['quantity']=0;
	
	$sql_aB2=mysql_query("SELECT * FROM `supplier_a` WHERE `cid` = '".$cid."'and `type`='B' and `source`='2' ");
	$aB2_row=mysql_num_rows($sql_aB2);
	if($aB2_row!=0)
		$aB2=mysql_fetch_array($sql_aB2);//向供應商a研發過(B產品,cpu)的回合資料
	else
		$aB2['quantity']=0;	
	
	
//-----------------------------------------------------供應商b---------------------------------------------------//		

	$sql_bA1=mysql_query("SELECT * FROM `supplier_b` WHERE `cid` = '".$cid."'and `type`='A' and `source`='1'");
	$bA1_row=mysql_num_rows($sql_bA1);
	if($bA1_row!=0)
		$bA1=mysql_fetch_array($sql_bA1);//向供應商b研發過(A產品,panel)的回合資料
	else
		$bA1['quantity']=0;		
	
	$sql_bA2=mysql_query("SELECT * FROM `supplier_b` WHERE `cid` = '".$cid."'and `type`='A' and `source`='2'");
	$bA2_row=mysql_num_rows($sql_bA2);
	if($bA2_row!=0)
		$bA2=mysql_fetch_array($sql_bA2);//向供應商b研發過(A產品,cpu)的回合資料
	else
		$bA2['quantity']=0;	
		
	$sql_bA3=mysql_query("SELECT * FROM `supplier_b` WHERE `cid` = '".$cid."'and `type`='A' and `source`='3'");
	$bA3_row=mysql_num_rows($sql_bA3);
	if($bA3_row!=0)
		$bA3=mysql_fetch_array($sql_bA3);//向供應商b研發過(A產品,keyboard)的回合資料
	else
		$bA3['quantity']=0;	
		
	$sql_bB1=mysql_query("SELECT * FROM `supplier_b` WHERE `cid` = '".$cid."'and `type`='B' and `source`='1' ");
	$bB1_row=mysql_num_rows($sql_bB1);
	if($bB1_row!=0)
		$bB1=mysql_fetch_array($sql_bB1);//向供應商b研發過(B產品,panel)的回合資料
	else
		$bB1['quantity']=0;	
	
	$sql_bB2=mysql_query("SELECT * FROM `supplier_b` WHERE `cid` = '".$cid."'and `type`='B' and `source`='2' ");
	$bB2_row=mysql_num_rows($sql_bB2);
	if($bB2_row!=0)
		$bB2=mysql_fetch_array($sql_bB2);//向供應商b研發過(B產品,cpu)的回合資料
	else
		$bB2['quantity']=0;	
		
	
//-----------------------------------------------------供應商c---------------------------------------------------//		

	$sql_cA1=mysql_query("SELECT * FROM `supplier_c` WHERE `cid` = '".$cid."'and `type`='A' and `source`='1'");
	$cA1_row=mysql_num_rows($sql_cA1);
	if($cA1_row!=0)
		$cA1=mysql_fetch_array($sql_cA1);//向供應商c研發過(A產品,panel)的回合資料
	else
		$cA1['quantity']=0;	
		
	
	$sql_cA2=mysql_query("SELECT * FROM `supplier_c` WHERE `cid` = '".$cid."'and `type`='A' and `source`='2'");
	$cA2_row=mysql_num_rows($sql_cA2);
	if($cA2_row!=0)
		$cA2=mysql_fetch_array($sql_cA2);//向供應商c研發過(A產品,cpu)的回合資料
	else
		$cA2['quantity']=0;	
	
	$sql_cA3=mysql_query("SELECT * FROM `supplier_c` WHERE `cid` = '".$cid."'and `type`='A' and `source`='3'");
	$cA3_row=mysql_num_rows($sql_cA3);
	if($cA3_row!=0)
		$cA3=mysql_fetch_array($sql_cA3);//向供應商c研發過(A產品,keyboard)的回合資料
	else
		$cA3['quantity']=0;	
	
	$sql_cB1=mysql_query("SELECT * FROM `supplier_c` WHERE `cid` = '".$cid."'and `type`='B' and `source`='1' ");
	$cB1_row=mysql_num_rows($sql_cB1);
	if($cB1_row!=0)
		$cB1=mysql_fetch_array($sql_cB1);//向供應商c研發過(B產品,panel)的回合資料
	else
		$cB1['quantity']=0;	
	
	$sql_cB2=mysql_query("SELECT * FROM `supplier_c` WHERE `cid` = '".$cid."'and `type`='B' and `source`='2' ");
	$cB2_row=mysql_num_rows($sql_cB2);
	if($cB2_row!=0)
		$cB2=mysql_fetch_array($sql_cB2);//向供應商c研發過(B產品,cpu)的回合資料
	else
		$cB2['quantity']=0;	
	

?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>research_and_development</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/researchanddevelopment.css" rel="stylesheet">
      
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript">
		
			/*var canClick_A=1,canClick_B=1,RD_done_A=0,RD_done_B=0;*/
			
			var L_p_A=0, L_c_A=0, L_k_A=0; L_price_pA=0; L_price_cA=0; L_price_kA=0;
			var L_p_B=0, L_c_B=0, L_k_B=0; L_price_pB=0; L_price_cB=0; L_price_kB=0;
			var L_p_C=0, L_c_C=0, L_k_C=0; L_price_pC=0; L_price_cC=0; L_price_kC=0;
			var T_p_A=0, T_c_A=0; T_price_pA=0; T_price_cA=0;
			var T_p_B=0, T_c_B=0; T_price_pB=0; T_price_cB=0;
			var T_p_C=0, T_c_C=0; T_price_pC=0; T_price_cC=0;
		
			var getp=new Array();//取得價格
			var pass=true;
            
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
		   
            $(document).ready(function(){
                
				
				var rdtype=new Array("L_p_A","L_c_A","L_k_A","L_p_B","L_c_B","L_k_B","L_p_C","L_c_C","L_k_C",
				                      "T_p_A","T_c_A","T_p_B","T_c_B","T_p_C","T_c_C");	
					
				    $.ajax({
                            url: 'rd_para.php',
                            type:'GET',
							async:false,
                            data: {
                                type:"price",rdtype:rdtype
                            },
							error:
                                function(xhr) {alert('Ajax request 發生錯誤');},
                            success:
                                function(str){
									//alert(str);
                                    getp=str.split("|");
									initial(getp);
                                }
                    });
					
					function initial(getp){
						//lap
						document.getElementById("lapp_initialprice_A").innerHTML=getp[0];
                   		document.getElementById("lap_discount_A").innerHTML=getp[1];
                   		document.getElementById("lapp_afterdiscount_A").innerHTML=getp[0]-getp[1];
						document.getElementById("lapc_initialprice_A").innerHTML=getp[2];
                   		document.getElementById("lapc_afterdiscount_A").innerHTML=getp[2]-getp[1];
						document.getElementById("lapk_initialprice_A").innerHTML=getp[4];
                   		document.getElementById("lapk_afterdiscount_A").innerHTML=getp[4]-getp[1];
						
						document.getElementById("lapp_initialprice_B").innerHTML=getp[6];
                   		document.getElementById("lap_discount_B").innerHTML=getp[7];
                   		document.getElementById("lapp_afterdiscount_B").innerHTML=getp[6]-getp[7];
						document.getElementById("lapc_initialprice_B").innerHTML=getp[8];
                   		document.getElementById("lapc_afterdiscount_B").innerHTML=getp[8]-getp[7];
						document.getElementById("lapk_initialprice_B").innerHTML=getp[10];
                   		document.getElementById("lapk_afterdiscount_B").innerHTML=getp[10]-getp[7];
						
						document.getElementById("lapp_initialprice_C").innerHTML=getp[12];
                   		document.getElementById("lap_discount_C").innerHTML=getp[13];
                   		document.getElementById("lapp_afterdiscount_C").innerHTML=getp[12]-getp[13];
						document.getElementById("lapc_initialprice_C").innerHTML=getp[14];
                   		document.getElementById("lapc_afterdiscount_C").innerHTML=getp[14]-getp[13];
						document.getElementById("lapk_initialprice_C").innerHTML=getp[16];
                   		document.getElementById("lapk_afterdiscount_C").innerHTML=getp[16]-getp[13];
						
						//tab
						document.getElementById("tabp_initialprice_A").innerHTML=getp[18];
                   		document.getElementById("tab_discount_A").innerHTML=getp[19];
                   		document.getElementById("tabp_afterdiscount_A").innerHTML=getp[18]-getp[19];
						document.getElementById("tabc_initialprice_A").innerHTML=getp[20];
                   		document.getElementById("tabc_afterdiscount_A").innerHTML=getp[20]-getp[19];
						
						document.getElementById("tabp_initialprice_B").innerHTML=getp[22];
                   		document.getElementById("tab_discount_B").innerHTML=getp[23];
                   		document.getElementById("tabp_afterdiscount_B").innerHTML=getp[22]-getp[23];
						document.getElementById("tabc_initialprice_B").innerHTML=getp[24];
                   		document.getElementById("tabc_afterdiscount_B").innerHTML=getp[24]-getp[23];
						
						document.getElementById("tabp_initialprice_C").innerHTML=getp[26];
                   		document.getElementById("tab_discount_C").innerHTML=getp[27];
                   		document.getElementById("tabp_afterdiscount_C").innerHTML=getp[26]-getp[27];
						document.getElementById("tabc_initialprice_C").innerHTML=getp[28];
                   		document.getElementById("tabc_afterdiscount_C").innerHTML=getp[28]-getp[27];
					}//end getp
				document.getElementById("rd_total_l").innerHTML="1500,000";
				document.getElementById("rd_total_t").innerHTML="1500,000";
	<?php		
	//if有研發過A
	if($rd_rowA==1){
	?>
				document.getElementById("lapp_pnum_A").value=<?php echo $aA1['quantity']?>;			 
			 	document.getElementById("lapp_pnum_A").disabled=true;
				document.getElementById("lapc_pnum_A").value=<?php echo $aA2['quantity']?>;
				document.getElementById("lapc_pnum_A").disabled=true;
				document.getElementById("lapk_pnum_A").value=<?php echo $aA3['quantity']?>;
				document.getElementById("lapk_pnum_A").disabled=true;
					
				document.getElementById("lapp_pnum_B").value=<?php echo $bA1['quantity']?>;
				document.getElementById("lapp_pnum_B").disabled=true;
				document.getElementById("lapc_pnum_B").value=<?php echo $bA2['quantity']?>;
				document.getElementById("lapc_pnum_B").disabled=true;
				document.getElementById("lapk_pnum_B").value=<?php echo $bA3['quantity']?>;
				document.getElementById("lapk_pnum_B").disabled=true;
					
				document.getElementById("lapp_pnum_C").value=<?php echo $cA1['quantity']?>;
				document.getElementById("lapp_pnum_C").disabled=true;
				document.getElementById("lapc_pnum_C").value=<?php echo $cA2['quantity']?>;
				document.getElementById("lapc_pnum_C").disabled=true;
				document.getElementById("lapk_pnum_C").value=<?php echo $cA3['quantity']?>;
				document.getElementById("lapk_pnum_C").disabled=true;
				$('.tfoot1').hide();
	<?php 
	}
	//if有研發過B 
	if($rd_rowB==1){
	?>
			 	document.getElementById("tabp_pnum_A").value=<?php echo $aB1['quantity']?>;
				document.getElementById("tabp_pnum_A").disabled=true;
				document.getElementById("tabc_pnum_A").value=<?php echo $aB2['quantity']?>;
				document.getElementById("tabc_pnum_A").disabled=true;
					
				document.getElementById("tabp_pnum_B").value=<?php echo $bB1['quantity']?>;
				document.getElementById("tabp_pnum_B").disabled=true;
				document.getElementById("tabc_pnum_B").value=<?php echo $bB2['quantity']?>;
				document.getElementById("tabc_pnum_B").disabled=true;
					
				document.getElementById("tabp_pnum_C").value=<?php echo $cB1['quantity']?>;
				document.getElementById("tabp_pnum_C").disabled=true;
				document.getElementById("tabc_pnum_C").value=<?php echo $cB2['quantity']?>;
				document.getElementById("tabc_pnum_C").disabled=true;
				$('.tfoot2').hide();
	<?php 
	}
	//若是本月研發A，disabled所有B產品的inputs，隱藏產品B的tfoot
	//A在判定為研發過時已隱藏tfoot
if($rd_rowA!=0 || $rd_rowB!=0){
	 if($year==$rdA['year'] && $month==$rdA['month']){ 			   
	?>	
			document.getElementById("tab2").style.opacity=0.5;
			document.getElementById("tabp_pnum_A").disabled=true;
			document.getElementById("tabc_pnum_A").disabled=true;
					
			document.getElementById("tabp_pnum_B").disabled=true;
			document.getElementById("tabc_pnum_B").disabled=true;
					
			document.getElementById("tabp_pnum_C").disabled=true;
			document.getElementById("tabc_pnum_C").disabled=true;
			$('.tfoot2').hide();     
	<?php
			$state="* 單月內只允許研發一項產品，本月已研發過<font color=#000>筆記型電腦</font> *";
	//若是本月研發B，disabled所有A產品的inputs，隱藏產品A的tfoot
	//B在判定為研發過時已隱藏tfoot
	}else if($year==$rdB['year'] && $month==$rdB['month']){
	?>	
			document.getElementById("tab1").style.opacity=0.5;
			document.getElementById("lapp_pnum_A").disabled=true;
			document.getElementById("lapc_pnum_A").disabled=true;
			document.getElementById("lapk_pnum_A").disabled=true;
					
			document.getElementById("lapp_pnum_B").disabled=true;
			document.getElementById("lapc_pnum_B").disabled=true;
			document.getElementById("lapk_pnum_B").disabled=true;
				
			document.getElementById("lapp_pnum_C").disabled=true;
			document.getElementById("lapc_pnum_C").disabled=true;
			document.getElementById("lapk_pnum_C").disabled=true;
			$('.tfoot1').hide();     
	<?php
			$state="* 單月內只允許研發一項產品，本月已研發過<font color=#000>平板電腦 </font>*";
	}
}//end if(有研發過)
     
	 if($rd_rowA==1 && $rd_rowB==1)
	 		$state="* 兩樣產品均已研發完成! *";
	?>        
			
			 $("#submitA").click(function(){
				  //get price，Laptop
				  L_price_pA=document.getElementById("lapp_afterdiscount_A").innerHTML;
				  L_price_cA=document.getElementById("lapc_afterdiscount_A").innerHTML;
				  L_price_kA=document.getElementById("lapk_afterdiscount_A").innerHTML;
				  L_price_pB=document.getElementById("lapp_afterdiscount_B").innerHTML;
				  L_price_cB=document.getElementById("lapc_afterdiscount_B").innerHTML;
				  L_price_kB=document.getElementById("lapk_afterdiscount_B").innerHTML;
				  L_price_pC=document.getElementById("lapp_afterdiscount_C").innerHTML;
				  L_price_cC=document.getElementById("lapc_afterdiscount_C").innerHTML;
				  L_price_kC=document.getElementById("lapk_afterdiscount_C").innerHTML;
					
					//取得user輸入的inputs，產品(Laptop)_原料(panel/cpu/keyboard)_供應商(A/B/C)
					L_p_A=document.getElementById("lapp_pnum_A").value;
					L_c_A=document.getElementById("lapc_pnum_A").value;
					L_k_A=document.getElementById("lapk_pnum_A").value;
					
					L_p_B=document.getElementById("lapp_pnum_B").value;
					L_c_B=document.getElementById("lapc_pnum_B").value;
					L_k_B=document.getElementById("lapk_pnum_B").value;
					
					L_p_C=document.getElementById("lapp_pnum_C").value;
					L_c_C=document.getElementById("lapc_pnum_C").value;
					L_k_C=document.getElementById("lapk_pnum_C").value;
				
					var lv = new Array(L_p_A,L_c_A,L_k_A,L_p_B,L_c_B,L_k_B,L_p_C,L_c_C,L_k_C);
			
					for(var i=0; i<lv.length; i++){
						var isvalid=check(lv[i]);
						if(isvalid==false){
						alert("請確認訂購量的值在有效範圍 (0~1000) 內!");
								break;
						}
			 		}
					if(isvalid){
                        $.ajax({
                            url: 'rdDB.php',
                            type:'GET',
							//async:false,
                            data: {
                                product:"A",p_A:L_p_A, c_A:L_c_A, k_A:L_k_A,
								            p_B:L_p_B, c_B:L_c_B, k_B:L_k_B,
											p_C:L_p_C, c_C:L_c_C, k_C:L_k_C,
											price_pA:L_price_pA, price_cA:L_price_cA, price_kA:L_price_kA,
											price_pB:L_price_pB, price_cB:L_price_cB, price_kB:L_price_kB,
											price_pC:L_price_pC, price_cC:L_price_cC, price_kC:L_price_kC,
                            },
                            error:
                                function(xhr) {alert('Ajax request 發生錯誤');},
                            success:
                                function(str){
									//alert(str);
								alert("Success! 您已成功研發筆記型電腦!");
                                    //journal();
								location.href= ('./research_and_develop.php'); 	
                                }
                        });
					}
                        
	             });//end submitA
				 
			 $("#submitB").click(function(){
					 
				//get price，Tablet
				T_price_pA=document.getElementById("tabp_afterdiscount_A").innerHTML;
				T_price_cA=document.getElementById("tabc_afterdiscount_A").innerHTML;
				T_price_pB=document.getElementById("tabp_afterdiscount_B").innerHTML;
				T_price_cB=document.getElementById("tabc_afterdiscount_B").innerHTML;
				T_price_pC=document.getElementById("tabp_afterdiscount_C").innerHTML;
				T_price_cC=document.getElementById("tabc_afterdiscount_C").innerHTML;
				
				//取得user輸入的inputs，產品(Tablet)_原料(panel/cpu/keyboard)_供應商(A/B/C)	 
				T_p_A=document.getElementById("tabp_pnum_A").value;
				T_c_A=document.getElementById("tabc_pnum_A").value;
					
				T_p_B=document.getElementById("tabp_pnum_B").value;
			    T_c_B=document.getElementById("tabc_pnum_B").value;
					
				T_p_C=document.getElementById("tabp_pnum_C").value;
				T_c_C=document.getElementById("tabc_pnum_C").value;
					 
					 var tv=new Array(T_p_A,T_c_A,T_p_B,T_c_B,T_p_C,T_c_C);
					 
					 for(var i=0; i<tv.length; i++){
						var isvalid=check(tv[i]);
						if(isvalid==false){
							alert("請確認訂購量的值在有效範圍 (0~1000) 內!");
								break;
						}
			 		 }
					 if(isvalid){ 
                        $.ajax({
                            url: 'rdDB.php',
                            type:'GET',
							async:false,
                            data: {
                                product: "B",p_A:T_p_A, c_A:T_c_A, 
								             p_B:T_p_B, c_B:T_c_B,
											 p_C:T_p_C, c_C:T_c_C, 
											 price_pA:T_price_pA, price_cA:T_price_cA,
											 price_pB:T_price_pB, price_cB:T_price_cB,
											 price_pC:T_price_pC, price_cC:T_price_cC,
                            },
                            error:
                                function(xhr) {alert('Ajax request 發生錯誤');},
                            success:
                                function(str){
								//alert(str);
								alert("Success! 您已成功研發平板電腦!");
                                //journal();
								location.href= ('./research_and_develop.php'); 	
                                }
                        });
			 }
                       //done("B");
                });//end submitB
			
});//end ready(func)
            function check(num){
				if(num>=0&&num<=1000)
   					return true;
				else
  					return false;
			}
				
		   /* //計算此次決策的總費用
            function count(){
				//get price，Laptop
				L_price_pA=document.getElementById("lapp_afterdiscount_A").innerHTML;
				L_price_cA=document.getElementById("lapc_afterdiscount_A").innerHTML;
				L_price_kA=document.getElementById("lapk_afterdiscount_A").innerHTML;
				L_price_pB=document.getElementById("lapp_afterdiscount_B").innerHTML;
				L_price_cB=document.getElementById("lapc_afterdiscount_B").innerHTML;
				L_price_kB=document.getElementById("lapk_afterdiscount_B").innerHTML;
				L_price_pC=document.getElementById("lapp_afterdiscount_C").innerHTML;
				L_price_cC=document.getElementById("lapc_afterdiscount_C").innerHTML;
				L_price_kC=document.getElementById("lapk_afterdiscount_C").innerHTML;
				//get price，Tablet
				T_price_pA=document.getElementById("tabp_afterdiscount_A").innerHTML;
				T_price_cA=document.getElementById("tabc_afterdiscount_A").innerHTML;
				T_price_pB=document.getElementById("tabp_afterdiscount_B").innerHTML;
				T_price_cB=document.getElementById("tabc_afterdiscount_B").innerHTML;
				T_price_pC=document.getElementById("tabp_afterdiscount_C").innerHTML;
				T_price_cC=document.getElementById("tabc_afterdiscount_C").innerHTML;
				
				//alert(T_price_pA);
				var purchase_LA_total= L_price_pA*L_p_A+L_price_cA*L_c_A+L_price_kA*L_k_A;
				var purchase_LB_total= L_price_pB*L_p_B+L_price_cB*L_c_B+L_price_kB*L_k_B;
				var purchase_LC_total= L_price_pC*L_p_C+L_price_cC*L_c_C+L_price_kC*L_k_C;
				var purchase_TA_total= T_price_pA*T_p_A+T_price_cA*T_c_A;
				//alert(purchase_TA_total);
				var purchase_TB_total= T_price_pB*T_p_B+T_price_cB*T_c_B;
				var purchase_TC_total= T_price_pC*T_p_C+T_price_cC*T_c_C;
				var total_l= purchase_LA_total+purchase_LB_total+purchase_LC_total;
				var total_t= purchase_TA_total+purchase_TB_total+purchase_TC_total;
			    //alert(purchase_TB_total);
				document.getElementById("rd_total_l").innerHTML=addCommas(total_l);
				document.getElementById("rd_total_t").innerHTML=addCommas(total_t);
			 }
			  
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function total(){
				L_p_A=document.getElementById("lapp_pnum_A").value;
				L_c_A=document.getElementById("lapc_pnum_A").value;
				L_k_A=document.getElementById("lapk_pnum_A").value;
					
				L_p_B=document.getElementById("lapp_pnum_B").value;
				L_c_B=document.getElementById("lapc_pnum_B").value;
				L_k_B=document.getElementById("lapk_pnum_B").value;
					
				L_p_C=document.getElementById("lapp_pnum_C").value;
				L_c_C=document.getElementById("lapc_pnum_C").value;
				L_k_C=document.getElementById("lapk_pnum_C").value;
				
				T_p_A=document.getElementById("tabp_pnum_A").value;
				T_c_A=document.getElementById("tabc_pnum_A").value;
					
				T_p_B=document.getElementById("tabp_pnum_B").value;
				T_c_B=document.getElementById("tabc_pnum_B").value;
					
				T_p_C=document.getElementById("tabp_pnum_C").value;
				T_c_C=document.getElementById("tabc_pnum_C").value;
				count();
				}*/
			 		 	
        </script>
  </head>
  <body>
    <div class="container-fluid">
    <h1>研究開發 <small style="color:#ff0000;"><?php echo $state;?></small></h1>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-laptop"></i> 筆記型電腦</h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-tablet"></i> 平板電腦</h2></a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">
 <!---------------------------研發主機電腦區域----------------------->
    <div class="col-sm-12  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-laptop"></i> 研發主機電腦</h1></div>
            <div class="panel-body ctm-padding" >
                <!-----------------螢幕與面板------------------------>
                <div class="col-sm-4 ctm-padding">
                    <div class="panel panel-info panel-padding text-center">
                        <div class="panel-heading"><i class="fa fa-desktop"></i> 螢幕與面板</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td></td>
                                    <td>原定價</td>
                                    <td>優惠價</td>
                                    <td>訂購量</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>供應商A</td>
                                    <td><span id="lapp_initialprice_A"></span></td>
                                    <td><span id="lapp_afterdiscount_A"></span></td>
                                    <td><input id="lapp_pnum_A" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商B</td>
                                    <td><span id="lapp_initialprice_B"></span></td>
                                    <td><span id="lapp_afterdiscount_B"></span></td>
                                    <td><input id="lapp_pnum_B" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商C</td>
                                    <td><span id="lapp_initialprice_C"></span></td>
                                    <td><span id="lapp_afterdiscount_C"></span></td>
                                    <td><input id="lapp_pnum_C" onBlur="total()"  class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                </div>
                <!-----------------------------主機與核心電路------------------------------------->
                <div class="col-sm-4 ctm-padding">
                    <div class="panel panel-info panel-padding text-center">
                        <div class="panel-heading"><i class="fa fa-stack-overflow"></i> 主機/核心電路</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td></td>
                                    <td>原定價</td>
                                    <td>優惠價</td>
                                    <td>訂購量</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>供應商A</td>
                                    <td><span id="lapc_initialprice_A"></span></td>
                                    <td><span id="lapc_afterdiscount_A"></span></td>
                                    <td><input id="lapc_pnum_A" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商B</td>
                                    <td><span id="lapc_initialprice_B"></span></td>
                                    <td><span id="lapc_afterdiscount_B"></span></td>
                                    <td><input id="lapc_pnum_B" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商C</td>
                                    <td><span id="lapc_initialprice_C"></span></td>
                                    <td><span id="lapc_afterdiscount_C"></span></td>
                                    <td><input id="lapc_pnum_C" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                </div>
                <!-----------------------------鍵盤基座------------------------------------->
                <div class="col-sm-4 ctm-padding">
                    <div class="panel panel-info panel-padding  text-center">
                        <div class="panel-heading"><i class="fa fa-keyboard-o"></i> 鍵盤基座</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td></td>
                                    <td>原定價</td>
                                    <td>優惠價</td>
                                    <td>訂購量</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>供應商A</td>
                                    <td><span id="lapk_initialprice_A"></span></td>
                                    <td><span id="lapk_afterdiscount_A"></span></td>
                                    <td><input id="lapk_pnum_A" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商B</td>
                                    <td><span id="lapk_initialprice_B"></span></td>
                                    <td><span id="lapk_afterdiscount_B"></span></td>
                                    <td><input id="lapk_pnum_B" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商C</td>
                                    <td><span id="lapk_initialprice_C"></span></td>
                                    <td><span id="lapk_afterdiscount_C"></span></td>
                                    <td><input id="lapk_pnum_C" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                </div>    
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
      

<!---------------------------供應商資訊區域----------------------->
    <div class="col-sm-6 ctm-padding">
        <div class="panel panel-primary panel-padding panel-margin">
            <div class="panel-heading"><h2><i class="fa fa-university"></i> 供應商資訊</h2></div>
                <table class="table table-bordered">
                    <tr>
                        <td></td>
                        <td>品質</td>
                        <td>最大供應量</td>
                        <td>關係優惠</td>
                    </tr>
                    <tbody>
                    <tr>
                        <td>供應商A</td>
                        <td>高</td>
                        <td><span id="lap_maxpnum_A">1000</span></td>
                        <td><span id="lap_discount_A"></span></td>
                    </tr>
                    <tr>
                        <td>供應商B</td>
                        <td>中</td>
                        <td><span id="lap_maxpnum_B">1000</span></td>
                        <td><span id="lap_discount_B"></span></td>
                    </tr>
                    <tr>
                        <td>供應商C</td>
                        <td>低</td>
                        <td><span id="lap_maxpnum_C">1000</span></td>
                        <td><span id="lap_discount_C"></span></td>
                    </tr>
                                
                    </tbody>
            </table>
        </div>
      </div>
    <!---------------------------說明事項區域----------------------->
    <div class="col-sm-6 ctm-padding">
        <div class="panel panel-primary panel-padding panel-margin">
            <div class="panel-heading"><h2>說明</h2></div>
            <div class="panel-body">
                <h3>1.建議的契約訂購量為500，最大值為1000</h3>
                <h3>2.請務必研發將要生產產品的各種原料，否則將無法生產</h3>
            </div>
        </div>
      </div>
      
          <!----------------------------總費用和按鈕--------------------------------->
    <div class="col-sm-8 text-center"><h3>總費用 : $<span id ="rd_total_l">0</span></h3></div>
    <div class="col-sm-4 text-center subnitmargin"><input id="submitA" class="btn btn-primary btn-lg" type="button" value="submit"></div>
      
    </div>

<!----------------------核心積體電路區域--------------------------->
  <div role="tabpanel" class="tab-pane fade" id="profile"> 
    <div class="col-sm-8  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-tablet"></i> 研發平板電腦</h1></div>
            <div class="panel-body ctm-padding">
                
                                <!-----------------螢幕與面板------------------------>
                <div class="col-sm-6 ctm-padding">
                    <div class="panel panel-info panel-padding text-center">
                        <div class="panel-heading"><i class="fa fa-desktop"></i> 螢幕與面板</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td></td>
                                    <td>原定價</td>
                                    <td>優惠價</td>
                                    <td>訂購量</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>供應商A</td>
                                    <td><span id="tabp_initialprice_A"></span></td>
                                    <td><span id="tabp_afterdiscount_A"></span></td>
                                    <td><input id="tabp_pnum_A" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商B</td>
                                    <td><span id="tabp_initialprice_B"></span></td>
                                    <td><span id="tabp_afterdiscount_B"></span></td>
                                    <td><input id="tabp_pnum_B" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商C</td>
                                    <td><span id="tabp_initialprice_C"></span></td>
                                    <td><span id="tabp_afterdiscount_C"></span></td>
                                    <td><input id="tabp_pnum_C" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                </div>
                <!-----------------------------主機與核心電路------------------------------------->
                <div class="col-sm-6 ctm-padding">
                    <div class="panel panel-info panel-padding text-center">
                        <div class="panel-heading"><i class="fa fa-stack-overflow"></i> 主機/核心電路</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td></td>
                                    <td>原定價</td>
                                    <td>優惠價</td>
                                    <td>訂購量</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>供應商A</td>
                                    <td><span id="tabc_initialprice_A"></span></td>
                                    <td><span id="tabc_afterdiscount_A"></span></td>
                                    <td><input id="tabc_pnum_A" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商B</td>
                                    <td><span id="tabc_initialprice_B"></span></td>
                                    <td><span id="tabc_afterdiscount_B"></span></td>
                                    <td><input id="tabc_pnum_B" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                <tr>
                                    <td>供應商C</td>
                                    <td><span id="tabc_initialprice_C"></span></td>
                                    <td><span id="tabc_afterdiscount_C"></span></td>
                                    <td><input id="tabc_pnum_C" onBlur="total()" class="form-control text-center" type="text" placeholder="0"></td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                </div>
                
                
                
                
                
            </div>
        </div>
    </div>
    <!---------------------------供應商資訊區域----------------------->
                <div class="col-sm-4 ctm-padding">
                            <div class="panel panel-primary panel-padding panel-margin">
                                <div class="panel-heading"><h2><i class="fa fa-university"></i> 供應商資訊</h2></div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td></td>
                                            <td>品質</td>
                                            <td>最大供應量</td>
                                            <td>關係優惠</td>
                                        </tr>
                                        <tbody>
                                            <tr>
                                                <td>供應商A</td>
                                                <td>高</td>
                                                <td><span id="tab_maxpnum_A">1000</span></td>
                                                <td><span id="tab_discount_A"></span></td>
                                            </tr>
                                            <tr>
                                                <td>供應商B</td>
                                                <td>中</td>
                                                <td><span id="tab_maxpnum_B">1000</span></td>
                                                <td><span id="tab_discount_B"></span></td>
                                            </tr>
                                            <tr>
                                                <td>供應商C</td>
                                                <td>低</td>
                                                <td><span id="tab_maxpnum_C">1000</span></td>
                                                <td><span id="tab_discount_C"></span></td>
                                            </tr>
                                
                                        </tbody>
                                </table>
                            </div>
                </div>
    <!------------------------按鈕總費用區域----------------------------->  
    <div class="col-sm-8 text-center"><h3>總費用 : $<span id ="rd_total_t">0</span></h3></div>
    <div class="col-sm-4 text-center subnitmargin"><input id="submitB" class="btn btn-primary btn-lg" type="button" value="submit"></div>
    </div>
</div>

        
</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>