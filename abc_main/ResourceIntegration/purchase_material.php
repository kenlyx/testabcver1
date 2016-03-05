<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <?php
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	$supplier=array("A","B","C","a","b","c");
	$temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_x';");
    $result=mysql_fetch_array($temp);
    $X=$result[0];
    $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_y';");
    $result=mysql_fetch_array($temp);
    $Y=$result[0];
	
	//decision-取出此月已做過的決策
	$sql_d=mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	$result_d=mysql_fetch_array($sql_d);
	$A_d=array($result_d['ma_supplier_a'],$result_d['ma_supplier_b'],$result_d['ma_supplier_c']);   
	
	//---------------------------------------------- case A (panel) --------------------------------------------------
	//price
    $sql_price_sa=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_a';");
    $result_psa=mysql_fetch_array($sql_price_sa);
    $sql_satis=mysql_query("SELECT * FROM `supplier_satisfaction` WHERE `cid`='$cid';");
    $result_s=mysql_fetch_array($sql_satis);
    $sql_costmore_ma=mysql_query("SELECT `material_A_price` FROM `situation` WHERE `happening`>0;");
    $result_cmma=mysql_fetch_array($sql_costmore_ma);
    for($i=0;$i<3;$i++){
		if($result_cmma[0]!=0){
			$price_ma=(integer)(($result_psa[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y)*($result_cmma[0]));
			$p_price[$i]=$price_ma;
		}else{
			$price_ma=(integer)(($result_psa[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y));
			$p_price[$i]=$price_ma;	
		}
	}//end for
	//decision- this month- panel
	$sql_tmp=mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	$tm_p=mysql_fetch_array($sql_tmp);
	$p_thismonth=array($tm_p['ma_supplier_a'],$tm_p['ma_supplier_b'],$tm_p['ma_supplier_c']);
	//inventories
	$sql_inp=mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE (`year`-1)*12+`month` < $round AND `cid`='$cid'");
	$in_p=mysql_fetch_array($sql_inp);
	//echo $in_p['ma_supplier_a'];
	$p_inventory=array($in_p[0],$in_p[1],$in_p[2]); //$in_p['ma_supplier_a'],$in_p['ma_supplier_b'],$in_p['ma_supplier_c']
	$sql_usedLp=mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`) FROM `product_a` WHERE (`year`-1)*12+`month` <= $round  AND `cid`='$cid'");
	$used_Lp=mysql_fetch_array($sql_usedLp);
	$p_Lused=array($used_Lp[0],$used_Lp[1],$used_Lp[2]); //$used_Lp['mb_supplier_a'],$used_Lp['mb_supplier_b'],$used_Lp['mb_supplier_c']
	$sql_usedTp=mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`) FROM `product_b` WHERE (`year`-1)*12+`month` <= $round  AND `cid`='$cid'");
	$used_Tp=mysql_fetch_array($sql_usedTp);
	$p_Tused=array($used_Tp[0],$used_Tp[1],$used_Tp[2]); //$used_Tp['ma_supplier_a'],$used_Tp['ma_supplier_b'],$used_Tp['ma_supplier_c']
	for($i=0;$i<3;$i++){
	 	$pfinal[$i]=$p_inventory[$i]-$p_Lused[$i]-$p_Tused[$i];
		//echo $pfinal[$i].">";
	}	
		
	//supplier_power
	$ppower=array();
    for($i=0;$i<3;$i++){
    	$panel=0;
        $sql_ppow=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier[$i]_power';");
        $ppow=mysql_fetch_array($sql_ppow);
        $panel=$ppow[0];
		$j=$i+3;
        //其他組跟廠商買panel的總數，others' panel quality
		$sql_opq=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier[$j]` WHERE `cid`<>'$cid' and `source`='1';");//ps:<>是不等於
        $opq=mysql_fetch_array($sql_opq);
        if($opq[0]!=NULL){
		    //各廠商總panel供貨量扣掉提供給其他組的量=剩餘供貨量(panel_power)
            $panel-=$opq[0];
			$ppower[$i]=$panel;
		}else
			$ppower[$i]=$ppow[0];
	}//end for
    //echo $ppow[0];		
	
	//---------------------------------------------- case B (cpu) --------------------------------------------------
	//price
    $sql_price_sb=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_b';");

    $result_psb=mysql_fetch_array($sql_price_sb);
    $sql_costmore_mb=mysql_query("SELECT `material_B_price` FROM `situation` WHERE `happening`>0;");
    $result_cmmb=mysql_fetch_array($sql_costmore_mb);
    for($i=0;$i<3;$i++){
		if($result_cmmb[0]!=0){
			$price_mb=(integer)(($result_psb[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y)*($result_cmmb[0]));
			$c_price[$i]=$price_mb;
		}else{
			$price_mb=(integer)(($result_psb[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y));
			$c_price[$i]=$price_mb;
		}
	}//end for
	
	//decision- this month- cpu
	$sql_tmc=mysql_query("SELECT `mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	$tm_c=mysql_fetch_array($sql_tmc);
	$c_thismonth=array($tm_c['mb_supplier_a'],$tm_c['mb_supplier_b'],$tm_c['mb_supplier_c']);
	//echo "|".$c_thismonth[0]."|";
	//inventories
	$sql_inc=mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE (`year`-1)*12+`month` < $round  AND `cid`='$cid'");
	$in_c=mysql_fetch_array($sql_inc);
	$c_inventory=array($in_c[0],$in_c[1],$in_c[2]); //$in_c['mb_supplier_a'],$in_c['mb_supplier_b'],$in_c['mb_supplier_c']
	
	$sql_usedLc=mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `product_a` WHERE (`year`-1)*12+`month` < $round  AND `cid`='$cid'");
	$used_Lc=mysql_fetch_array($sql_usedLc);
	$c_Lused=array($used_Lc[0],$used_Lc[1],$used_Lc[2]); //$used_Lc['mb_supplier_a'],$used_Lc['mb_supplier_b'],$used_Lk['mb_supplier_c']
	//echo $used_Lc[2]."+";
	$sql_usedTc=mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `product_b` WHERE (`year`-1)*12+`month` < $round  AND `cid`='$cid'");
	$used_Tc=mysql_fetch_array($sql_usedTc);
	$c_Tused=array($used_Tc[0],$used_Tc[1],$used_Tc[2]); //$used_Tc['mb_supplier_a'],$used_Tk['mb_supplier_b'],$used_Tk['mb_supplier_c']
	for($i=0;$i<3;$i++){
	 	$cfinal[$i]=$c_inventory[$i]-$c_Lused[$i]-$c_Tused[$i];
		//echo $cfinal[$i]."<";
	}
	//supplier_power
    $cpower=array();  
	for($i=0;$i<3;$i++){
    	$cpu=0;
        $sql_cpow=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier[$i]_power';");
        $cpow=mysql_fetch_array($sql_cpow);
        $cpu=$cpow[0];
		$j=$i+3;
        //其他組跟廠商買的原料總數，others' cpu quality
		$sql_ocq=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier[$j]` WHERE `cid`<>'$cid' and `source`='2';");
        $ocq=mysql_fetch_array($sql_ocq);
        if($ocq[0]!=NULL){
		    //廠商總供貨量扣掉提供給其他組的量=剩餘供貨量(supplierB_power)
            $cpu-=$ocq[0];
			$cpower[$i]=$cpu;
		}else
			$cpower[$i]=$cpow[0];
   }//end for		
   
	//---------------------------------------------- case C (keybqard) --------------------------------------------------
	//price
    $sql_price_sc=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_c';");
    $result_psc=mysql_fetch_array($sql_price_sc);
    $sql_costmore_mc=mysql_query("SELECT `material_C_price` FROM `situation` WHERE `happening`>0;");
    $result_cmmc=mysql_fetch_array($sql_costmore_mc);
    for($i=0;$i<3;$i++){
		if($result_cmmc[0]!=0){
			$price_mc=(integer)(($result_psc[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y)*($result_cmmc[0]));
			$k_price[$i]=$price_mc;
		}else{
			$price_mc=(integer)(($result_psc[$i]-(integer)(($result_s[$i]-50)/($X*100))*$Y));
			$k_price[$i]=$price_mc;
		}
	}//end for
	
	//decision- this month- keyboard
	$sql_tmk=mysql_query("SELECT `mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
	$tm_k=mysql_fetch_array($sql_tmk);
	$k_thismonth=array($tm_k['mc_supplier_a'],$tm_k['mc_supplier_b'],$tm_k['mc_supplier_c']);
	//inventories
	$sql_ink=mysql_query("SELECT SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE (`year`-1)*12+`month` < $round  AND `cid`='$cid'");
	$in_k=mysql_fetch_array($sql_ink);
	$k_inventory=array($in_k[0],$in_k[1],$in_k[2]); //$in_k['mc_supplier_a'],$in_k['mc_supplier_b'],$in_k['mc_supplier_c']
	$sql_usedLk=mysql_query("SELECT SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`) FROM `product_a` WHERE (`year`-1)*12+`month` < $round  AND `cid`='$cid'");
	$used_Lk=mysql_fetch_array($sql_usedLk);
	$k_used=array($used_Lk[0],$used_Lk[1],$used_Lk[2]); //$used_Lk['mc_supplier_a'],$used_Lk['mc_supplier_b'],$used_Lk['mc_supplier_c']
	for($i=0;$i<3;$i++){
	 	$kfinal[$i]=$k_inventory[$i]-$k_used[$i];
		//echo $kfinal[$i]."|";		
	}	
    //supplier_power
	$kpower=array();
    for($i=0;$i<3;$i++){
    	$keyboard=0;
        $sql_kpow=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier[$i]_power';");
        $kpow=mysql_fetch_array($sql_kpow);
        $keyboard=$kpow[0];
		$j=$i+3;
        //其他組跟廠商買的原料總數，others' keyboard quality
		$sql_okq=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier[$j]` WHERE `cid`<>'$cid' and `source`='3';");
        $okq=mysql_fetch_array($sql_okq);
        if($okq[0]!=NULL){
		    //廠商總供貨量扣掉提供給其他組的量=剩餘供貨量(supplierB_power)
            $keyboard-=$okq[0];
			$kpower[$i]=$keyboard;
		}else
			$kpower[$i]=$kpow[0];
   }//end for
   		
?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/purchasematerial.css" rel="stylesheet">
      
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript">
		
            var p_A=0,p_B=0,p_C=0;
			var c_A=0,c_B=0,c_C=0;
			var k_A=0,k_B=0,k_C=0;
			var pA_price=0; pB_price=0; pC_price=0;
			var cA_price=0; cB_price=0; cC_price=0;
			var kA_price=0; kB_price=0; kC_price=0;
			var purchase_p=0; purchase_c=0; purchase_c=0;
			
			$(document).ready(function(){
                
			
				
				//供貨能力
				document.getElementById("pA_power").innerHTML=<?php echo $ppower[0]?>;
				document.getElementById("pB_power").innerHTML=<?php echo $ppower[1]?>;
				document.getElementById("pC_power").innerHTML=<?php echo $ppower[2]?>;
				
				document.getElementById("cA_power").innerHTML=<?php echo $cpower[0]?>;
				document.getElementById("cB_power").innerHTML=<?php echo $cpower[1]?>;
				document.getElementById("cC_power").innerHTML=<?php echo $cpower[2]?>;				
				
				document.getElementById("kA_power").innerHTML=<?php echo $kpower[0]?>;
				document.getElementById("kB_power").innerHTML=<?php echo $kpower[1]?>;
				document.getElementById("kC_power").innerHTML=<?php echo $kpower[2]?>;
				
				//剩餘庫存量		
				document.getElementById("pA_inventory").innerHTML=<?php echo $pfinal[0]?>;
				document.getElementById("pB_inventory").innerHTML=<?php echo $pfinal[1]?>;
				document.getElementById("pC_inventory").innerHTML=<?php echo $pfinal[2]?>;
				
				document.getElementById("cA_inventory").innerHTML=<?php echo $cfinal[0]?>;
				document.getElementById("cB_inventory").innerHTML=<?php echo $cfinal[1]?>;
				document.getElementById("cC_inventory").innerHTML=<?php echo $cfinal[2]?>;
				
				document.getElementById("kA_inventory").innerHTML=<?php echo $kfinal[0]?>;
				document.getElementById("kB_inventory").innerHTML=<?php echo $kfinal[1]?>;
				document.getElementById("kC_inventory").innerHTML=<?php echo $kfinal[2]?>;
				
				//本月訂購量		
				document.getElementById("pA_thismonth").innerHTML=<?php echo $p_thismonth[0]?>;
				document.getElementById("pB_thismonth").innerHTML=<?php echo $p_thismonth[1]?>;
				document.getElementById("pC_thismonth").innerHTML=<?php echo $p_thismonth[2]?>;
				
				document.getElementById("cA_thismonth").innerHTML=<?php echo $c_thismonth[0]?>;
				document.getElementById("cB_thismonth").innerHTML=<?php echo $c_thismonth[1]?>;
				document.getElementById("cC_thismonth").innerHTML=<?php echo $c_thismonth[2]?>;
				
				document.getElementById("kA_thismonth").innerHTML=<?php echo $k_thismonth[0]?>;
				document.getElementById("kB_thismonth").innerHTML=<?php echo $k_thismonth[1]?>;
				document.getElementById("kC_thismonth").innerHTML=<?php echo $k_thismonth[2]?>;	
				
				//單價pA_price
				document.getElementById("pA_price").innerHTML=<?php echo $p_price[0]?>;
				document.getElementById("pB_price").innerHTML=<?php echo $p_price[1]?>;
				document.getElementById("pC_price").innerHTML=<?php echo $p_price[2]?>;
				
				document.getElementById("cA_price").innerHTML=<?php echo $c_price[0]?>;
				document.getElementById("cB_price").innerHTML=<?php echo $c_price[1]?>;
				document.getElementById("cC_price").innerHTML=<?php echo $c_price[2]?>;
				
				document.getElementById("kA_price").innerHTML=<?php echo $k_price[0]?>;
				document.getElementById("kB_price").innerHTML=<?php echo $k_price[1]?>;
				document.getElementById("kC_price").innerHTML=<?php echo $k_price[2]?>;
				
				pA_price=document.getElementById("pA_price").innerHTML;
				pB_price=document.getElementById("pB_price").innerHTML;
				pC_price=document.getElementById("pC_price").innerHTML;
				
				cA_price=document.getElementById("cA_price").innerHTML;
				cB_price=document.getElementById("cB_price").innerHTML;
				cC_price=document.getElementById("cC_price").innerHTML;
				
				kA_price=document.getElementById("kA_price").innerHTML;
				kB_price=document.getElementById("kB_price").innerHTML;
				kC_price=document.getElementById("kC_price").innerHTML;
<?php
    mysql_select_db("testabc_main");	
	//是否研發筆電
	$sql_doneA=mysql_query("SELECT * FROM `state` WHERE `cid`='$cid' AND `product_A_RD`=1");
	$row_dA=mysql_num_rows($sql_doneA);
	//echo $row_dA; 
	//是否研發平板
	$sql_doneB=mysql_query("SELECT * FROM `state` WHERE `cid`='$cid' AND `product_B_RD`=1");
	$row_dB=mysql_num_rows($sql_doneB);		
	
//判斷研發過產品
if($row_dA==1 && $row_dB==0)
	$state="* 已研發產品：筆記型電腦 *";
else if($row_dA==0 && $row_dB==1){
	//只研發平板沒研發筆電不能購買鍵盤
	$state="* 已研發產品：平板電腦 *";			   
    ?>	
	document.getElementById("tab3").style.opacity=0.5;
	document.getElementById("knum_A").disabled=true;
	document.getElementById("knum_B").disabled=true;
	document.getElementById("knum_C").disabled=true;
	$('.tfoot3').hide();     	
    <?php
}
else
	$state="* 已研發產品：筆記型電腦、平板電腦 *";
?>				 
                $("#submit_p").click(function(){//panel_submit
					
					p_A=document.getElementById("pnum_A").value;
					p_B=document.getElementById("pnum_B").value;
					p_C=document.getElementById("pnum_C").value;
					ppower_A=document.getElementById("pA_power").innerHTML;
					ppower_B=document.getElementById("pB_power").innerHTML;
					ppower_C=document.getElementById("pC_power").innerHTML;
					
					purchase_p = new Array(pA_price*p_A , pB_price*p_B , pC_price*p_C);	
					
					var pn = new Array(p_A,p_B,p_C);
					var ppower = new Array(ppower_A,ppower_B,ppower_C);
					var isvalid1 = false;
					var isvalid2 = false;
					var isvalid3 = false;
					for(var i=0; i<pn.length; i++){
						//alert(pn[i]);測試時使用的兩行
						//alert(ppower[i]);
						if(pn[i]==""){
							pn[i]=(0);
						}
						if(pn[i]<0||parseInt(pn[i])>parseInt(ppower[i])){
							alert("請確認訂購量的值在有效範圍"+ppower[i]+"內!");
							break;
						}
						else if(pn[i]>=0 && parseInt(pn[i])<=parseInt(ppower[i])){
							if(i==0){
								//alert("2-1");
								isvalid1=true;
							}
							else if(i==1){
								//alert("2-2");
								isvalid2=true;
							}
							else if(i==2){
								//alert("2-3");
								isvalid3=true;
							}
							else{
								alert("for loop error(line:345)");
								break;
							}
						}//end of else if
					}//end of for 
					if(isvalid1==true&&isvalid2==true&&isvalid3==true){
                   		$.ajax({
                      	 	url:"materialDB.php",
                        	type: "GET",
                       		datatype: "html",
                       		data: "type=A&decision1="+pn[0]+"&decision2="+pn[1]+"&decision3="+pn[2]+"&price1="+pA_price+"&price2="+pB_price+"&price3="+pC_price+"&cost1="+purchase_p[0]+"&cost2="+purchase_p[1]+"&cost3="+purchase_p[2],
                      		 success: function(str){
                             	//alert("Success!");
								//journal();
								location.href= ('./purchase_material.php');
                        	}
                   		});
					}
				});
				
				 $("#submit_c").click(function(){//cpu_submit
					c_A=document.getElementById("cnum_A").value;
					c_B=document.getElementById("cnum_B").value;
					c_C=document.getElementById("cnum_C").value;
					cpower_A=document.getElementById("cA_power").innerHTML;
					cpower_B=document.getElementById("cB_power").innerHTML;
					cpower_C=document.getElementById("cC_power").innerHTML;
					
					purchase_c = new Array(cA_price*c_A , cB_price*c_B , cC_price*c_C);
				    
					var cn = new Array(c_A,c_B,c_C);
					var cpower = new Array(cpower_A,cpower_B,cpower_C);
					
					for(var i=0; i<cn.length; i++){
						if(cn[i]==""){
							cn[i]=(0);
						}
						
						if(cn[i]<0||parseInt(cn[i])>parseInt(cpower[i])){
							alert("請確認訂購量的值在有效範圍"+cpower[i]+"內!");
							break;
						}
						else if(cn[i]>=0 && parseInt(cn[i])<=parseInt(cpower[i])){
							
							if(i==0){
								//alert("2-1");
								isvalid1=true;
							}
							else if(i==1){
								//alert("2-2");
								isvalid2=true;
							}
							else if(i==2){
								//alert("2-3");
								isvalid3=true;
							}
							else{
								alert("for loop error(line:402)");
								break;
							}
						}//end of else if
					}//end of for 
					if(isvalid1==true&&isvalid2==true&&isvalid3==true){
                    	$.ajax({
                       	    url:"materialDB.php",
                        	type: "GET",
                       		datatype: "html",
                        	data: 
						      "type=B&decision1="+cn[0]+"&decision2="+cn[1]+"&decision3="+cn[2]+"&price1="+cA_price+"&price2="+cB_price+"&price3="+cC_price+"&cost1="+purchase_c[0]+"&cost2="+purchase_c[1]+"&cost3="+purchase_c[2],
                        	success: function(str){
                          	  	//alert("Success!");
								//journal();
								history.go(0);
								//location.href= ('./purchase_material.php#tabs-2');
                       		}
                   		});
					}
                });
				
				 $("#submit_k").click(function(){//kernal_submit
					k_A=document.getElementById("knum_A").value;
					k_B=document.getElementById("knum_B").value;
					k_C=document.getElementById("knum_C").value;
					kpower_A=document.getElementById("kA_power").innerHTML;
					kpower_B=document.getElementById("kB_power").innerHTML;
					kpower_C=document.getElementById("kC_power").innerHTML;
					
					purchase_k = new Array(kA_price*k_A , kB_price*k_B , kC_price*k_C);
                    
					var kn = new Array(k_A,k_B,k_C);
					var kpower = new Array(kpower_A,kpower_B,kpower_C);
					
					for(var i=0; i<kn.length; i++){
						if(kn[i]==""){
							kn[i]=(0);
						}
						
						if(kn[i]<0||parseInt(kn[i])>parseInt(kpower[i])){
							alert("請確認訂購量的值在有效範圍"+kpower[i]+"內!");
							break;
						}
						else if(kn[i]>=0 && parseInt(kn[i])<=parseInt(kpower[i])){
							
							if(i==0){
								//alert("2-1");
								isvalid1=true;
							}
							else if(i==1){
								//alert("2-2");
								isvalid2=true;
							}
							else if(i==2){
								//alert("2-3");
								isvalid3=true;
							}
							else{
								alert("for loop error(line:461)");
								break;
							}
						}//end of else if
					}//end of for 
					
					if(isvalid1==true&&isvalid2==true&&isvalid3==true){
						$.ajax({
                     	   url:"materialDB.php",
                     	   type: "GET",
                    	   datatype: "html",
                     	   data: 
							  "type=C&decision1="+kn[0]+"&decision2="+kn[1]+"&decision3="+kn[2]+"&price1="+kA_price+"&price2="+kB_price+"&price3="+kC_price+"&cost1="+purchase_k[0]+"&cost2="+purchase_k[1]+"&cost3="+purchase_k[2],
                      	   success: function(str){
                      	      //alert("Success!");
							 //journal();
							 location.href= ('./purchase_material.php');
                           }
                    	});
					}
                });
				/*
				function check_p(num){
					if(num>=0&&num<=5000){
   						return true;
						//alert(123);
					}
					else
  						return false;
				}
				function check_c(num){
					if(num>=0&&num<=5000){
   						return true;
						//alert(123);
					}
					else
  						return false;
				}
				function check_k(num){
					if(num>=0&&num<=5000){
   						return true;
						//alert(123);
					}
					else
  						return false;
				}				
				*/
	   });//end ready func
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
				
		    //計算此次決策的總費用
            function count(){
				pA_price=document.getElementById("pA_price").innerHTML;
				pB_price=document.getElementById("pB_price").innerHTML;
				pC_price=document.getElementById("pC_price").innerHTML;
				
				cA_price=document.getElementById("cA_price").innerHTML;
				cB_price=document.getElementById("cB_price").innerHTML;
				cC_price=document.getElementById("cC_price").innerHTML;
				
				kA_price=document.getElementById("kA_price").innerHTML;
				kB_price=document.getElementById("kB_price").innerHTML;
				kC_price=document.getElementById("kC_price").innerHTML;
				
				purchase_p = pA_price*p_A + pB_price*p_B + pC_price*p_C;
				purchase_c = cA_price*c_A + cB_price*c_B + cC_price*c_C;
				purchase_k = kA_price*k_A + kB_price*k_B + kC_price*k_C;
				
			    document.getElementById("p_total").innerHTML=addCommas(parseInt(purchase_p));
				document.getElementById("c_total").innerHTML=addCommas(parseInt(purchase_c));
				document.getElementById("k_total").innerHTML=addCommas(parseInt(purchase_k));
			 }
			  
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function total(){
				p_A=document.getElementById("pnum_A").value;
				p_B=document.getElementById("pnum_B").value;
				p_C=document.getElementById("pnum_C").value;
				
				c_A=document.getElementById("cnum_A").value;
				c_B=document.getElementById("cnum_B").value;
				c_C=document.getElementById("cnum_C").value;
				
				k_A=document.getElementById("knum_A").value;
				k_B=document.getElementById("knum_B").value;
				k_C=document.getElementById("knum_C").value;
				count();
			}
			
        </script>
  </head>
  <body>
    <div class="container-fluid">
    <h1>購買原料 <small style="color:#ff0000;"><?php echo $state;?></small></h1>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-desktop"></i> 螢幕<span class="hidden-xs">/面板</span></h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-stack-overflow"></i> 主機<span class="hidden-xs">/核心電路</span></h2></a></li>
      <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-keyboard-o"></i> 鍵盤<span class="hidden-xs">基座</span></h2></a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">
    <div class="col-sm-9  ctm-padding">
        <div class="panel panel-success panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-desktop"></i></h1></div>
            <div class="panel-body" >
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3" style="padding:0px;"><h3>&nbsp;</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商A</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商B</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商C</h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>供貨能力</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pA_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pB_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pC_power">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>庫 存 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pA_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pB_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pC_inventory">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>本月購量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pA_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pB_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pC_thismonth">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table"  style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>單價</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pA_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="pB_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;" ><h3><span id="pC_price">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>購 買 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="pnum_A" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="pnum_B" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="pnum_C" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-8 text-center"><h3>總費用 : $<span id="p_total">0</span></h3></div>
        <div class="col-sm-4 text-center"><input id="submit_p" class="btn btn-success btn-lg" type="submit"></div>
    </div>
      

      <!---------------------------注意事項區域----------------------->
    <div class="col-sm-3 ctm-padding">
        <div class="panel panel-success panel-padding panel-margin">
            <div class="panel-heading"><h2>說明</h2></div>
            <div class="panel-body">
                <h3>1.供貨能力代表可以供給自家公司的能力</h3>
                <h3>2.組跟組之間不會有原料買斷的問題</h3>
            </div>
        </div>
      </div>    
    </div>
<!----------------------核心積體電路區域--------------------------->
  <div role="tabpanel" class="tab-pane fade" id="profile"> 
    <div class="col-sm-9  ctm-padding">
        <div class="panel panel-success panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-stack-overflow"></i></h1></div>
            <div class="panel-body" >
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3" style="padding:0px;"><h3>&nbsp;</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商A</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商B</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商C</h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>供貨能力</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cA_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cB_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cC_power">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>庫 存 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cA_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cB_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cC_inventory">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>本月購量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cA_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cB_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cC_thismonth">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table"  style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>單價</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cA_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="cB_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;" ><h3><span id="cC_price">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>購 買 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="cnum_A" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="cnum_B" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="cnum_C" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-8 text-center"><h3>總費用 : $<span id="c_total">0</span></h3></div>
        <div class="col-sm-4 text-center"><input id="submit_c" class="btn btn-success btn-lg" type="submit"></div>
    </div>
      

      <!---------------------------注意事項區域----------------------->
    <div class="col-sm-3 ctm-padding">
        <div class="panel panel-success panel-padding panel-margin">
            <div class="panel-heading"><h2>說明</h2></div>
            <div class="panel-body">
                <h3>1.供貨能力代表可以供給自家公司的能力</h3>
                <h3>2.組跟組之間不會有原料買斷的問題</h3>
            </div>
        </div>
      </div>      
    </div>
<!--------------------------------------------鍵盤區域---------------------------------->
    <div role="tabpanel" class="tab-pane" id="messages">.
        <div class="col-sm-9  ctm-padding">
        <div class="panel panel-success panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-keyboard-o"></i></h1></div>
            <div class="panel-body" >
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3" style="padding:0px;"><h3>&nbsp;</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商A</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商B</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop nonrap" style="padding:0px;"><h3>供應商C</h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>供貨能力</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kA_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kB_power">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kC_power">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>庫 存 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kA_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kB_inventory">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kC_inventory">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>本月購量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kA_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kB_thismonth">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kC_thismonth">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table"  style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>單價</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kA_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;"><h3><span id="kB_price">0</span></h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px;" ><h3><span id="kC_price">0</span></h3></div>
                </div>
                <div class="col-sm-2 col-xs-12 text-center ctm-table" style="padding:0px;">
                    <div class="col-sm-12 col-xs-3 nonrap" style="padding:0px;"><h3>購 買 量</h3></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="knum_A" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="knum_B" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                    <div class="col-sm-12 col-xs-3 ctm-tabletop ctm-tableright" style="padding:0px 3px;"><input id="knum_C" onBlur="total()" class="form-control text-center ctminputmag" type="text" placeholder="0"></div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-8 text-center"><h3>總費用 : $<span id="k_total">0</span></h3></div>
        <div class="col-sm-4 text-center"><input id="submit_k" class="btn btn-success btn-lg" type="submit"></div>
    </div>
      

      <!---------------------------注意事項區域----------------------->
    <div class="col-sm-3 ctm-padding">
        <div class="panel panel-success panel-padding panel-margin">
            <div class="panel-heading"><h2>說明</h2></div>
            <div class="panel-body">
                <h3>1.供貨能力代表可以供給自家公司的能力</h3>
                <h3>2.組跟組之間不會有原料買斷的問題</h3>
            </div>
        </div>
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