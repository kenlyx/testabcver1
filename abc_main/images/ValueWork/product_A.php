<?php
session_start();

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_query("SET NAMEs 'utf8'");
    mysql_select_db("testabc_main", $connect);
	$cid=$_SESSION['cid'];
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
	$thisround=($year-1)*12+$month;
	$buymaterial = mysql_query("SELECT 	SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM purchase_materials WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");
	//$usematerial = mysql_query("SELECT SUM(`SupA_Monitor`),SUM(`SupB_Monitor`),SUM(`SupC_Monitor`),SUM(`SupA_Kernel`),SUM(`SupB_Kernel`),SUM(`SupC_Kernel`),SUM(`SupA_KeyBoard`),SUM(`SupB_KeyBoard`),SUM(`SupC_KeyBoard`) FROM production WHERE `cid`='$cid' ");//AND `year`='$year' AND `month`='$newmonth'");
    
	$useA_material = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM product_a WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$useB_material = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`)
FROM product_b WHERE `cid`='$cid' AND (`year`-1)*12+`month`<$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$row = mysql_fetch_array($buymaterial);
    $rowA = mysql_fetch_array($useA_material);
	$rowB = mysql_fetch_array($useB_material);

    $ma_suppliera=$row[0]-$rowA[0]-$rowB[0];
	$ma_supplierb=$row[1]-$rowA[1]-$rowB[1];
	$ma_supplierc=$row[2]-$rowA[2]-$rowB[2];
	$mb_suppliera=$row[3]-$rowA[3]-$rowB[3];
	$mb_supplierb=$row[4]-$rowA[4]-$rowB[4];
	$mb_supplierc=$row[5]-$rowA[5]-$rowB[5];
	$mc_suppliera=$row[6]-$rowA[6];
	$mc_supplierb=$row[7]-$rowA[7];
	$mc_supplierc=$row[8]-$rowA[8];
    $sum_ma = $ma_suppliera + $ma_supplierb + $ma_supplierc;
    $sum_mb = $mb_suppliera + $mb_supplierb + $mb_supplierc;
    $sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./for slider/jquery.ui.all.css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script src="./for slider/jquery-ui-1.8.14.slider.min.js"></script>
        <script type="text/javascript" src="../js/tinybox.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript">
            var amount=0,rest_m1=0,rest_m2=0,rest_m3=0,tra=0,trb=0,trc=0,percent=0;
            var r_aa=0,r_ba=0,r_ca=0,r_ab=0,r_bb=0,r_cb=0,r_ac=0,r_bc=0,r_cc=0;
            var i_aa=0,i_ba=0,i_ca=0,i_ab=0,i_bb=0,i_cb=0,i_ac=0,i_bc=0,i_cc=0;
			var sA=0,sB=0,sC=0,rest_amount=0
            var limit=0,count=0,power=0;
            var machine_limit=0,used=0;
			
			//var $ma_suppliera = ;
            $(document).ready(function(){
                initial();

                function initial(){
                    $.ajax({
                        url:"product_limit.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"A"},
                        success: function(str){
                            s_str=str.split("|")
                            used=parseInt(s_str[1]);
                            power=parseInt(s_str[0]);
                            initial_2();
                        }
                    });
                }
                function initial_2(){
                    $.ajax({
                        url:"../GroupLearning/hire_process.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"equip"},
                        success: function(str){
                            arr=str.split("|");
                            count=parseInt(arr[0]);
                            //alert(count);
                            limit=power*count-used;
                            initial_get();
                        }
                    });
                }
                function initial_get(){
                    $.ajax({
                        url:"GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: "option=get&type=A",
                        success: function(str){
							//alert(str);
                            var word=str.split(":");
							
							
							
							
                            i_aa=document.getElementById("A_inventoryA").textContent=<?php echo $ma_suppliera; ?>;//parseInt(word[0],10)-parseInt(word[18],10);
                            i_ba=document.getElementById("B_inventoryA").textContent=<?php echo $ma_supplierb; ?>;//parseInt(word[1],10)-parseInt(word[19],10);
                            i_ca=document.getElementById("C_inventoryA").textContent=<?php echo $ma_supplierc; ?>;//parseInt(word[2],10)-parseInt(word[20],10);
                            i_ab=document.getElementById("A_inventoryB").textContent=<?php echo $mb_suppliera; ?>;//parseInt(word[3],10)-parseInt(word[21],10);
                            i_bb=document.getElementById("B_inventoryB").textContent=<?php echo $mb_supplierb; ?>;//parseInt(word[4],10)-parseInt(word[22],10);
                            i_cb=document.getElementById("C_inventoryB").textContent=<?php echo $mb_supplierc; ?>;//parseInt(word[5],10)-parseInt(word[23],10);
                            i_ac=document.getElementById("A_inventoryC").textContent=<?php echo $mc_suppliera; ?>;//parseInt(word[6],10);
                            i_bc=document.getElementById("B_inventoryC").textContent=<?php echo $mc_supplierb; ?>;//parseInt(word[7],10);
                            i_cc=document.getElementById("C_inventoryC").textContent=<?php echo $mc_supplierc; ?>;//parseInt(word[8],10);
                            r_aa=document.getElementById("A_requireA").textContent=parseInt(word[9],10);
                            r_ba=document.getElementById("B_requireA").textContent=parseInt(word[10],10);
                            r_ca=document.getElementById("C_requireA").textContent=parseInt(word[11],10);
                            r_ab=document.getElementById("A_requireB").textContent=parseInt(word[12],10);
                            r_bb=document.getElementById("B_requireB").textContent=parseInt(word[13],10);
                            r_cb=document.getElementById("C_requireB").textContent=parseInt(word[14],10);
                            r_ac=document.getElementById("A_requireC").textContent=parseInt(word[15],10);
                            r_bc=document.getElementById("B_requireC").textContent=parseInt(word[16],10);
                            r_cc=document.getElementById("C_requireC").textContent=parseInt(word[17],10);
                            m1=document.getElementById("materialA").textContent=i_aa+i_ba+i_ca;
                            m2=document.getElementById("materialB").textContent=i_ab+i_bb+i_cb;
                            m3=document.getElementById("materialC").textContent=i_ac+i_bc+i_cc;
                            sA=rest_m1=Math.min((i_aa!=0)?i_aa:0,(i_ab!=0)?i_ab:0,(i_ac!=0)?i_ac:0);
                            sB=rest_m2=Math.min((i_ba!=0)?i_ba:0,(i_bb!=0)?i_bb:0,(i_bc!=0)?i_bc:0);
                            sC=rest_m3=Math.min((i_ca!=0)?i_ca:0,(i_cb!=0)?i_cb:0,(i_cc!=0)?i_cc:0);
                            tra=document.getElementById("total_requireA").textContent=r_aa+r_ba+r_ca;
                            trb=document.getElementById("total_requireB").textContent=r_ab+r_bb+r_cb;
                            trc=document.getElementById("total_requireC").textContent=r_ac+r_bc+r_cc;
                            amount=document.getElementById("quantity").textContent=tra;//要看產品的原料需求比例更改
							rest_amount=sA+sB+sC;
							//alert(sA+"@"+sB+"@"+sC)
                            if(amount==0)//直接用amount的話slider.value會有分母為零的情況
                                initial_amount=1;
                            else
                                initial_amount=amount;
                            percent=parseInt((r_aa+r_ba+r_ca)*1000/initial_amount,10);//+parseInt(r_ba*100/initial_amount,10)+parseInt(r_ca*100/initial_amount,10)
                            get_machine();
                        }
                    });
                }
                function get_machine(){
                    $.ajax({
                        url:"GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: {option:'get_machine',
                            type: 'A'},
                        success: function(str){
                            machine_limit=str;
                            //create_slider();
							click_set();
                        }
                    });
                }
                function click_set(){
					
                    $(".add").click(function(){
                        if(rest_amount>0&&(amount<limit)&&(amount<machine_limit)){
                            amount+=50;
                            rest_amount=sA+sB+sC-amount;
                            while(rest_amount<0||(amount>limit)||(amount>machine_limit)){
                                rest_amount++;
                                amount--;
                            }
                        }
                        else{
                            if(!(rest_amount>0))
                                alert("原料不足!!")
                            else if(amount>=machine_limit)
                                alert("產能不足!!")
                            else
                                alert("目前的員工無法負荷此工作量~!!");
                        }
                        document.getElementById("quantity").textContent=amount;
                    });
					
					$(".bigadd").click(function(){
						amount = sA+sB+sC;
						if(amount>=limit){
							amount = limit;
						}
						if(amount>=machine_limit){
							amount = machine_limit;
						}
						document.getElementById("quantity").textContent=amount;
					});

                    $(".sub").click(function(){
                        if(amount>0){
                            amount-=50;
                            rest_amount=sA+sB+sC-amount;
                            while(amount<0){
                                rest_amount--;
                                amount++;
                            }
                        }
                        else alert("沒得扣囉~")
                        document.getElementById("quantity").textContent=amount;
                    });
					
					$(".bigsub").click(function(){
							amount = 0;
							rest_amount=sA+sB+sC;
						document.getElementById("quantity").textContent=amount;
					});
					/*
					$(".clicka").click(function(){
						
					});
						
					$(".clickb").click(function(){
						
					});
					
					$(".clickc").click(function(){
						
					});
					*/
                    $(".submit").click(function(){
                        /*if(percent!=1000)
                            alert("分配不夠喔~")*/
						var r_aai , r_bbi , r_cci;
						r_aai = parseInt(document.getElementById("A_requireA").textContent);
						r_bbi = parseInt(document.getElementById("B_requireB").textContent);
						r_cci = parseInt(document.getElementById("C_requireC").textContent);
						//r_xx系列似乎未設定為int值，在四則運算上會出現亂碼(ex:50+0+0=5000)
						var TRequire = r_aai+r_bbi+r_cci;
						
                        if(amount == TRequire){
                        	$.ajax({
                            	url:"GET_product_plan.php",
                                type: "GET",
                                datatype: "html",
                                data: "option=update&type=A&a_supplyA="+r_aa+"&a_supplyB="+r_ba+"&a_supplyC="+r_ca+"&b_supplyA="+									r_ab+"&b_supplyB="+r_bb+"&b_supplyC="+r_cb+"&c_supplyA="+r_ac+"&c_supplyB="+r_bc+"&c_supplyC="+r_cc,
                                success: function(str){
                                    //alert("SUCCESS~!!")
                                    alert("Success!");
									//journal();
                                }
                        	});
						}
						else{
							alert("原料分配有誤!!!!"+("供應商a投入量：")+r_aa+("供應商b投入量：")+r_bb+("供應商c投入量：")+r_cc+("生產數量")+amount+("Total：")+TRequire);
						}
						
                    });//end of submit.click
                }
				
				/*表格即時更新功能(未完工) 以button暫時代替
				function supply(){	
					r_aa = document.getElementById("supA").value;
					r_ab = document.getElementById("supA").textContent;
					r_ac = document.getElementById("supA").textContent;
					
				
				}
					
				
				function change(){
					document.getElementById("A_requireA").textContent = document.getElementById("supA").value;
					r_ab = document.getElementById("supA").textContent;
					r_ac = document.getElementById("supA").textContent;
				}
				*/
				
				/* slider建制
                function create_slider(){
                    $( "#sliderA" ).slider({
                        value:r_aa*10000/initial_amount,min: 0,max: 10000,step: 1,	range: "min",
                        start: function( event, ui ) {
                            percent-=ui.value//slide之前先減掉自己的百分比
                        },
                        slide: function( event, ui ) {
                            r_aa=parseInt(ui.value*amount*0.0001)//下面判斷式用到的值的先給才不會超過就卡住
                            r_ab=parseInt(ui.value*amount*0.0001)
                            r_ac=parseInt(ui.value*amount*0.0001)
                            if(percent+ui.value>10000||r_aa>i_aa||r_ab>i_ab||r_ac>i_ac)//判斷另外兩個的%數加上自己的是否超過100，還有是否超過庫存
                                $().slider( value , ui.value ) //超過的話就停在現在的位置，$()裡面打什麼都沒差...看樣子執行到這一行就不會往下了0.0
                            tra=r_aa+parseInt(r_ba)+parseInt(r_ca)//不加parseInt的話會出現神奇的事情所以只好加了...
                            trb=r_ab+parseInt(r_bb)+parseInt(r_cb)//total要放在修正前才行喔~
                            trc=r_ac+parseInt(r_bc)+parseInt(r_cc)
                            if(percent+ui.value==10000&&tra/1!=amount){//誤差修正...
                                var qq=amount-tra/1
                                for(i=0;i<qq;i++){
                                    r_aa++;r_ab++;r_ac++;
                                }
                                tra+=i;trb+=i;trc+=i;
                            }
                            document.getElementById("A_requireA").textContent=r_aa ;//判斷過沒問題後才顯示
                            document.getElementById("A_requireB").textContent=r_ab ;
                            document.getElementById("A_requireC").textContent=r_ac ;
                            document.getElementById("total_requireA").textContent=tra;
                            document.getElementById("total_requireB").textContent=trb;
                            document.getElementById("total_requireC").textContent=trc;
                        },
                        stop: function( event, ui ) {
                            percent+=ui.value//之後才加上去
                            r_aa=document.getElementById("A_requireA").textContent;
                            r_ab=document.getElementById("A_requireB").textContent;
                            r_ac=document.getElementById("A_requireC").textContent;
                        }
                    });
                    $( "#sliderB" ).slider({
                        value:r_ba*10000/initial_amount,min: 0,max: 10000,step: 1,	range: "min",
                        start: function( event, ui ) {
                            percent-=ui.value
                        },
                        slide: function( event, ui ) {
                            r_ba=parseInt(ui.value*amount*0.0001)
                            r_bb=parseInt(ui.value*amount*0.0001)
                            r_bc=parseInt(ui.value*amount*0.0001)
                            if(percent+ui.value>10000||r_ba>i_ba||r_bb>i_bb||r_bc>i_bc)
                                $().slider( value , ui.value )
                            tra=parseInt(r_aa)+r_ba+parseInt(r_ca)
                            trb=parseInt(r_ab)+r_bb+parseInt(r_cb)
                            trc=parseInt(r_ac)+r_bc+parseInt(r_cc)
                            if(percent+ui.value==10000&&tra/1!=amount){
                                var qq=amount-tra/1
                                for(i=0;i<qq;i++){
                                    r_ba++;r_bb++;r_bc++;
                                }
                                tra+=i;trb+=i;trc+=i;
                            }
                            document.getElementById("B_requireA").textContent=r_ba ;
                            document.getElementById("B_requireB").textContent=r_bb ;
                            document.getElementById("B_requireC").textContent=r_bc ;
                            document.getElementById("total_requireA").textContent=tra;
                            document.getElementById("total_requireB").textContent=trb;
                            document.getElementById("total_requireC").textContent=trc;
                        },
                        stop: function( event, ui ) {
                            percent+=ui.value
                            r_ba=document.getElementById("B_requireA").textContent;
                            r_bb=document.getElementById("B_requireB").textContent;
                            r_bc=document.getElementById("B_requireC").textContent;
                        }
                    });
                    $( "#sliderC" ).slider({
                        value:r_ca*10000/initial_amount,min: 0,max: 10000,step: 1,	range: "min",
                        start: function( event, ui ) {
                            percent-=ui.value
                        },
                        slide: function( event, ui ) {
                            r_ca=parseInt(ui.value*amount*0.0001)
                            r_cb=parseInt(ui.value*amount*0.0001)
                            r_cc=parseInt(ui.value*amount*0.0001)
                            if(percent+ui.value>10000||r_ca>i_ca||r_cb>i_cb||r_cc>i_cc)
                                $().slider( value , ui.value )
                            tra=parseInt(r_aa)+parseInt(r_ba)+r_ca
                            trb=parseInt(r_ab)+parseInt(r_bb)+r_cb
                            trc=parseInt(r_ac)+parseInt(r_bc)+r_cc
                            if(percent+ui.value==10000&&tra/1!=amount){
                                var qq=amount-tra/1
                                for(i=0;i<qq;i++){
                                    r_ca++;r_cb++;r_cc++;
                                }
                                tra+=i;trb+=i;trc+=i;
                            }
                            document.getElementById("C_requireA").textContent=r_ca ;
                            document.getElementById("C_requireB").textContent=r_cb ;
                            document.getElementById("C_requireC").textContent=r_cc ;
                            document.getElementById("total_requireA").textContent=tra;
                            document.getElementById("total_requireB").textContent=trb;
                            document.getElementById("total_requireC").textContent=trc;
                        },
                        stop: function( event, ui ) {
                            percent+=ui.value
                            r_ca=document.getElementById("C_requireA").textContent;
                            r_cb=document.getElementById("C_requireB").textContent;
                            r_cc=document.getElementById("C_requireC").textContent;
                        }
                    });
                    click_set();
                }//end of all slider
				*/
                /*
				function journal(){
                    TINY.box.show({iframe:'journal.html',boxid:'frameless',width:800,height:500,style:"z-index:2; top:10px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
                }
				*/
				
				
            });
			
			function changea(){
				//先用3個變數存取值  用來進行if判斷
				r_aa = document.getElementById("supA").value;
				r_ab = document.getElementById("supA").value;
				r_ac = document.getElementById("supA").value;
				//判斷各種原料不足情況(最後為皆足)
				if(i_aa<r_aa){
					if(i_ab<r_ab){
						if(i_ac<r_ac){
							r_aa = document.getElementById("A_requireA").textContent;
							r_ab = document.getElementById("A_requireB").textContent;
							r_ac = document.getElementById("A_requireC").textContent;
							alert("螢幕與面板不足&主機板與核心電路不足&鍵盤基座不足")
						}
						else{
							r_aa = document.getElementById("A_requireA").textContent;
							r_ab = document.getElementById("A_requireB").textContent;
							r_ac = document.getElementById("A_requireC").textContent;
							alert("螢幕與面板不足&主機板與核心電路不足")
						}
					}
					else if(i_ac<r_ac){
						r_aa = document.getElementById("A_requireA").textContent;
						r_ab = document.getElementById("A_requireB").textContent;
						r_ac = document.getElementById("A_requireC").textContent;
						alert("螢幕與面板不足&鍵盤基座不足")
					}
					else{
						r_aa = document.getElementById("A_requireA").textContent;
						r_ab = document.getElementById("A_requireB").textContent;
						r_ac = document.getElementById("A_requireC").textContent;
						alert("螢幕與面板不足")
					}
				}
				else if(i_ab<r_ab){
					if(i_ac<r_ac){
						r_aa = document.getElementById("A_requireA").textContent;
						r_ab = document.getElementById("A_requireB").textContent;
						r_ac = document.getElementById("A_requireC").textContent;
						alert("主機板與核心電路不足&鍵盤基座不足")
					}
					else{
						r_aa = document.getElementById("A_requireA").textContent;
						r_ab = document.getElementById("A_requireB").textContent;
						r_ac = document.getElementById("A_requireC").textContent;
						alert("主機板與核心電路不足")
					}
				}
				else if(i_ac<r_ac){
					r_aa = document.getElementById("A_requireA").textContent;
					r_ab = document.getElementById("A_requireB").textContent;
					r_ac = document.getElementById("A_requireC").textContent;
					alert("鍵盤基座不足")
				}
				else{
					tra = parseInt(r_aa)+parseInt(r_ba)+parseInt(r_ca);
					trb = parseInt(r_ab)+parseInt(r_bb)+parseInt(r_cb);
					trc = parseInt(r_ac)+parseInt(r_bc)+parseInt(r_cc);
					document.getElementById("A_requireA").textContent = document.getElementById("supA").value;
					document.getElementById("A_requireB").textContent = document.getElementById("supA").value;
					document.getElementById("A_requireC").textContent = document.getElementById("supA").value;
					document.getElementById("total_requireA").textContent = tra;
                    document.getElementById("total_requireB").textContent = trb;
                    document.getElementById("total_requireC").textContent = trc;
				}
			}
			function changeb(){
				r_ba = document.getElementById("supB").value;
				r_bb = document.getElementById("supB").value;
				r_bc = document.getElementById("supB").value;
				
				if(i_ba<r_ba){
					if(i_bb<r_bb){
						if(i_bc<r_bc){
							r_ba = document.getElementById("B_requireA").textContent;
							r_bb = document.getElementById("B_requireB").textContent;
							r_bc = document.getElementById("B_requireC").textContent;
							alert("螢幕與面板不足&主機板與核心電路不足&鍵盤基座不足")
						}
						else{
							r_ba = document.getElementById("B_requireA").textContent;
							r_bb = document.getElementById("B_requireB").textContent;
							r_bc = document.getElementById("B_requireC").textContent;
							alert("螢幕與面板不足&主機板與核心電路不足")
						}
					}
					else if(i_bc<r_bc){
						r_ba = document.getElementById("B_requireA").textContent;
						r_bb = document.getElementById("B_requireB").textContent;
						r_bc = document.getElementById("B_requireC").textContent;
						alert("螢幕與面板不足&鍵盤基座不足")
					}
					else{
						r_ba = document.getElementById("B_requireA").textContent;
						r_bb = document.getElementById("B_requireB").textContent;
						r_bc = document.getElementById("B_requireC").textContent;
						alert("螢幕與面板不足")
					}
				}
				else if(i_bb<r_bb){
					if(i_bc<r_bc){
						r_ba = document.getElementById("B_requireA").textContent;
						r_bb = document.getElementById("B_requireB").textContent;
						r_bc = document.getElementById("B_requireC").textContent;
						alert("主機板與核心電路不足&鍵盤基座不足")
					}
					else{
						r_ba = document.getElementById("B_requireA").textContent;
						r_bb = document.getElementById("B_requireB").textContent;
						r_bc = document.getElementById("B_requireC").textContent;
						alert("主機板與核心電路不足")
					}
				}
				else if(i_bc<r_bc){
					r_ba = document.getElementById("B_requireA").textContent;
					r_bb = document.getElementById("B_requireB").textContent;
					r_bc = document.getElementById("B_requireC").textContent;
					alert("鍵盤基座不足")
				}
				else{
					tra = parseInt(r_aa)+parseInt(r_ba)+parseInt(r_ca);
					trb = parseInt(r_ab)+parseInt(r_bb)+parseInt(r_cb);
					trc = parseInt(r_ac)+parseInt(r_bc)+parseInt(r_cc);
					document.getElementById("B_requireA").textContent = document.getElementById("supB").value;
					document.getElementById("B_requireB").textContent = document.getElementById("supB").value;
					document.getElementById("B_requireC").textContent = document.getElementById("supB").value;
					document.getElementById("total_requireA").textContent = tra;
                    document.getElementById("total_requireB").textContent = trb;
                    document.getElementById("total_requireC").textContent = trc;
				}
			}
			function changec(){
				r_ca = document.getElementById("supC").value;
				r_cb = document.getElementById("supC").value;
				r_cc = document.getElementById("supC").value;
				
				if(i_ca<r_ca){
					if(i_cb<r_cb){
						if(i_cc<r_cc){
							r_ca = document.getElementById("C_requireA").textContent;
							r_cb = document.getElementById("C_requireB").textContent;
							r_cc = document.getElementById("C_requireC").textContent;
							alert("螢幕與面板不足&主機板與核心電路不足&鍵盤基座不足")
						}
						else{
							r_ca = document.getElementById("C_requireA").textContent;
							r_cb = document.getElementById("C_requireB").textContent;
							r_cc = document.getElementById("C_requireC").textContent;
							alert("螢幕與面板&主機板與核心電路不足")
						}
					}
					else if(i_cc<r_cc){
						r_ca = document.getElementById("C_requireA").textContent;
						r_cb = document.getElementById("C_requireB").textContent;
						r_cc = document.getElementById("C_requireC").textContent;
						alert("螢幕與面板不足&鍵盤基座不足")
					}
					else{
						r_ca = document.getElementById("C_requireA").textContent;
						r_cb = document.getElementById("C_requireB").textContent;
						r_cc = document.getElementById("C_requireC").textContent;
						alert("螢幕與面板不足")
					}
				}
				else if(i_cb<r_cb){
					if(i_cc<r_cc){
						r_ca = document.getElementById("C_requireA").textContent;
						r_cb = document.getElementById("C_requireB").textContent;
						r_cc = document.getElementById("C_requireC").textContent;
						alert("主機板與核心電路不足&鍵盤基座不足")
					}
					else{
						r_ca = document.getElementById("C_requireA").textContent;
						r_cb = document.getElementById("C_requireB").textContent;
						r_cc = document.getElementById("C_requireC").textContent;
						alert("主機板與核心電路不足")
					}
				}
				else if(i_cc<r_cc){
					r_ca = document.getElementById("C_requireA").textContent;
					r_cb = document.getElementById("C_requireB").textContent;
					r_cc = document.getElementById("C_requireC").textContent;
					alert("鍵盤基座不足")
				}
				else{
					tra = parseInt(r_aa)+parseInt(r_ba)+parseInt(r_ca);
					trb = parseInt(r_ab)+parseInt(r_bb)+parseInt(r_cb);
					trc = parseInt(r_ac)+parseInt(r_bc)+parseInt(r_cc);
					document.getElementById("C_requireA").textContent = document.getElementById("supC").value;
					document.getElementById("C_requireB").textContent = document.getElementById("supC").value;
					document.getElementById("C_requireC").textContent = document.getElementById("supC").value;
					document.getElementById("total_requireA").textContent = tra;
                    document.getElementById("total_requireB").textContent = trb;
                    document.getElementById("total_requireC").textContent = trc;
				}
			}
        </script>
        <style type="text/css">
            #total_material,#produce_amount,#supplyA,#supplyB,#supplyC{
                margin:0px;
                margin-left:auto;
                margin-right:auto;
                padding:5px;
                background:#e5eecc;
                border:solid 1px #c3c3c3;
                filter:alpha(opacity=80);
                -moz-opacity:0.8;
                opacity: 0.8;
            }
            #materialA,#materialB,#materialC,#total_requireA,#total_requireB,#total_requireC,
            #A_inventoryA,#A_inventoryB,#A_inventoryC,#B_inventoryA,#B_inventoryB,#B_inventoryC,#C_inventoryA,#C_inventoryB,#C_inventoryC,
            #A_requireA,#A_requireB,#A_requireC,#B_requireA,#B_requireB,#B_requireC,#C_requireA,#C_requireB,#C_requireC{
                margin:0px;
                margin-left:auto;
                margin-right:auto;
                padding:5px;
                background:ghostwhite;
                border:solid 1px #c3c3c3;
                filter:alpha(opacity=80);
                -moz-opacity:0.8;
                opacity: 0.8;
            }
            div.ui-slider{padding: 0;}	/*因為smart_tab.css的關係要加這兩行padding*/
            div.ui-widget-header {padding: 0;background:#F6921E;}	/*background是因為slider的range用min比較合理的感覺，不然可以像purchase_materialA那樣用*/
			/*slider gui
			<td width="30%"><div id="sliderA" style="width:90%;margin-left:15px;"></div></td>
			<td width="30%"><div id="sliderB" style="width:90%;margin-left:15px;"></div></td>
			<td width="30%"><div id="sliderC" style="width:90%;margin-left:15px;"></div></td>
			*/
        </style>
    </head>
    <body>
    
        <table align="center" width="100%" height="70%"><caption><font size="5">筆記型電腦</font></caption>
        
        	<tr><th>&nbsp;</th></tr>
            
            <tr><th>&nbsp;</th><th colspan=2>螢幕與面板</th><th colspan=2>主機板與核心電路</th><th colspan=2>鍵盤基座</th></tr>
            
            <tr><td>&nbsp;</td><td>庫存量</td><td>投入量</td><td>庫存量</td><td>投入量</td><td>庫存量</td><td>投入量</td></tr>
            
            <tr><td id="supplyA" width="10%">供應商A</td>
                <td id="A_inventoryA" width="10%">0</td>
                <td id="A_requireA" width="10%">0</td>
                <td id="A_inventoryB" width="10%">0</td>
                <td id="A_requireB" width="10%">0</td>
                <td id="A_inventoryC" width="10%">0</td>
                <td id="A_requireC" width="10%">0</td>
                <td width="10%"><input id="supA" class="supply" onBlur="changea()" style="text-align:right" width="10%"
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" >
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>
            
            <tr><td id="supplyB" width="10%">供應商B</td>
                <td id="B_inventoryA" width="10%">0</td>
                <td id="B_requireA" width="10%">0</td>
                <td id="B_inventoryB" width="10%">0</td>
                <td id="B_requireB" width="10%">0</td>
                <td id="B_inventoryC" width="10%">0</td>
                <td id="B_requireC" width="10%">0</td>
                <td width="10%"><input id="supB" class="supply" onBlur="changeb()" style="text-align:right" width="10%"
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>
            
            <tr><td id="supplyC" width="10%">供應商C</td>
                <td id="C_inventoryA" width="10%">0</td>
                <td id="C_requireA" width="10%">0</td>
                <td id="C_inventoryB" width="10%">0</td>
                <td id="C_requireB" width="10%">0</td>
                <td id="C_inventoryC" width="10%">0</td>
                <td id="C_requireC" width="10%">0</td>
                <td width="10%"><input id="supC" class="supply" onBlur="changec()" style="text-align:right" width="10%"
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>

            <tr><td id="total_material" width="10%">原料總數</td>
                <td id="materialA" width="10%">0</td>
                <td id="total_requireA" width="10%">0</td>
                <td id="materialB" width="10%">0</td>
                <td id="total_requireB" width="10%">0</td>
                <td id="materialC" width="10%">0</td>
                <td id="total_requireC" width="10%">0</td>
            </tr>
            
            <tr><td id="produce_amount" width="10%">生產數量</td>
            	<td align="center"><input type="image" src="../images/CP_Min.png" class="bigsub" width="70px"></td>
                <td align="center"><input type="image" src="../images/sub.png" class="sub"></td>
                <td align="center"><span id="quantity">0</span></td>
                <td align="center"><input type="image" src="../images/add.png" class="add"></td>
                <td align="center"><input type="image" src="../images/CP_Max.png" class="bigadd" width="70px"></td>
                <td align="center" colspan=3><input type="image" src="../images/submit6.png" class="submit" width="100px"></td>
            </tr>
            
            <tr><td>&nbsp;</td></tr>
            
        </table>
        
    </body>
</html>
