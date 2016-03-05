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
FROM purchase_materials WHERE `cid`='$cid' AND (`year`-1)*12+`month`<=$thisround");// AND `year`='$year' AND `month`='$newmonth'");
	//$usematerial = mysql_query("SELECT SUM(`SupA_Monitor`),SUM(`SupB_Monitor`),SUM(`SupC_Monitor`),SUM(`SupA_Kernel`),SUM(`SupB_Kernel`),SUM(`SupC_Kernel`),SUM(`SupA_KeyBoard`),SUM(`SupB_KeyBoard`),SUM(`SupC_KeyBoard`) FROM production WHERE `cid`='$cid' ");//AND `year`='$year' AND `month`='$newmonth'");
    
	$useA_material = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`),SUM(`mc_supplier_a`),SUM(`mc_supplier_b`),SUM(`mc_supplier_c`)
FROM product_a WHERE `cid`='$cid' AND (`year`-1)*12+`month`<=$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$useB_material = mysql_query("SELECT SUM(`ma_supplier_a`),SUM(`ma_supplier_b`),SUM(`ma_supplier_c`),SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`)
FROM product_b WHERE `cid`='$cid' AND (`year`-1)*12+`month`<=$thisround");// AND `year`='$year' AND `month`='$newmonth'");

	$row = mysql_fetch_array($buymaterial);
    $rowA = mysql_fetch_array($useA_material);
	$rowB = mysql_fetch_array($useB_material);

    $ma_suppliera=$row[0]-$rowA[0]-$rowB[0];
	$ma_supplierb=$row[1]-$rowA[1]-$rowB[1];
	$ma_supplierc=$row[2]-$rowA[2]-$rowB[2];
	$mb_suppliera=$row[3]-$rowA[3]-$rowB[3];
	$mb_supplierb=$row[4]-$rowA[4]-$rowB[4];
	$mb_supplierc=$row[5]-$rowA[5]-$rowB[5];
	//$mc_suppliera=$row[6]-$rowA[6];
	//$mc_supplierb=$row[7]-$rowA[7];
	//$mc_supplierc=$row[8]-$rowA[8];
    $sum_ma = $ma_suppliera + $ma_supplierb + $ma_supplierc;
    $sum_mb = $mb_suppliera + $mb_supplierb + $mb_supplierc;
    //$sum_mc = $mc_suppliera + $mc_supplierb + $mc_supplierc;
?>

<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
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
            var amount=0,rest_m1=0,rest_m2=0,tra=0,trb=0,percent=0;
            var r_aa=0,r_ba=0,r_ca=0,r_ab=0,r_bb=0,r_cb=0;
            var i_aa=0,i_ba=0,i_ca=0,i_ab=0,i_bb=0,i_cb=0;
			var sA=0,sB=0,sC=0,rest_amount=0
            var limit=0,count=0,power=0;
            var machine_limit=0,used=0,initial_amount=0;
            $(document).ready(function(){

                initial();

                function initial(){
                    $.ajax({
                        url:"product_limit.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"B"},
                        success: function(str){
                            //alert(123);
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
                            //alert(123);
							arr=str.split("|");
                            count=parseInt(arr[0]);
                            limit=power*count-used;
                            initial_get();
                        }
                    });
                }
               
                function initial_get(){
                    $.ajax({
                        url:"./GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: "&option=get&type=B",
                        success: function(str){
							//alert(str);
                            var word=str.split(":");
							//alert(parseInt(word[0],10));
                            i_aa=document.getElementById("A_inventoryA").textContent=<?php echo $ma_suppliera; ?>;//parseInt(word[0],10)-parseInt(word[12],10);
                            i_ba=document.getElementById("B_inventoryA").textContent=<?php echo $ma_supplierb; ?>;//parseInt(word[1],10)-parseInt(word[13],10);
                            i_ca=document.getElementById("C_inventoryA").textContent=<?php echo $ma_supplierc; ?>;//parseInt(word[2],10)-parseInt(word[14],10);
                            i_ab=document.getElementById("A_inventoryB").textContent=<?php echo $mb_suppliera; ?>;//parseInt(word[3],10)-parseInt(word[15],10);
                            i_bb=document.getElementById("B_inventoryB").textContent=<?php echo $mb_supplierb; ?>;//parseInt(word[4],10)-parseInt(word[16],10);
                            i_cb=document.getElementById("C_inventoryB").textContent=<?php echo $mb_supplierc; ?>;//parseInt(word[5],10)-parseInt(word[17],10);
                            r_aa=document.getElementById("A_requireA").textContent=parseInt(word[6],10);
                            r_ba=document.getElementById("B_requireA").textContent=parseInt(word[7],10);
                            r_ca=document.getElementById("C_requireA").textContent=parseInt(word[8],10);
                            r_ab=document.getElementById("A_requireB").textContent=parseInt(word[9],10);
                            r_bb=document.getElementById("B_requireB").textContent=parseInt(word[10],10);
                            r_cb=document.getElementById("C_requireB").textContent=parseInt(word[11],10);
                            m1=document.getElementById("materialA").textContent=i_aa+i_ba+i_ca;
                            m2=document.getElementById("materialB").textContent=i_ab+i_bb+i_cb;
                            sA=rest_m1=Math.min((i_aa+r_aa!=0)?i_aa+r_aa:0,(i_ab+r_ab!=0)?i_ab+r_ab:0);
                            sB=rest_m2=Math.min((i_ba+r_ba!=0)?i_ba+r_ba:0,(i_bb+r_bb!=0)?i_bb+r_bb:0);
                            sC=rest_m3=Math.min((i_ca+r_ca!=0)?i_ca+r_ca:0,(i_cb+r_cb!=0)?i_cb+r_cb:0);
                            tra=document.getElementById("total_requireA").textContent=r_aa+r_ba+r_ca;
                            trb=document.getElementById("total_requireB").textContent=r_ab+r_bb+r_cb;
                            amount=document.getElementById("amount").textContent=tra/1;//要看產品的原料需求比例更改
							rest_amount=sA+sB+sC;
                            if(amount==0)//直接用amount的話slider.value會有分母為零的情況
                                initial_amount=1;
                            else
                                initial_amount=amount;
                            percent=parseInt((r_aa+r_ba+r_ca)*1000/initial_amount,10);//+parseInt(r_ba*100/initial_amount,10)+parseInt(r_ca*100/initial_amount,10)
                            get_machine();
                            showtotalproduce();
                        }
                    });
                }
                function get_machine(){
                    $.ajax({
                        url:"GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: {option:'get_machine',
                            type: 'B'},
                        success: function(str){
                            machine_limit=str;
							//alert(str);
						    //create_slider()
							click_set()
                        }
                    });
                }
				
				function click_set(){
                	/*$(".add").click(function(){
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
                        //document.getElementById("materialA").textContent=rest_m1;
                        //document.getElementById("materialB").textContent=rest_m2;
                        document.getElementById("amount").textContent=amount;
                    });*/
					
					
						amount = sA+sB+sC;
						if(amount>=limit){
							amount = limit;
						}
						if(amount>=machine_limit){
							amount = machine_limit;
						}
						document.getElementById("amount").textContent=amount;
					
					
                    /*$(".sub").click(function(){
                        if(amount>0){
                            amount-=50;
                            rest_amount=sA+sB+sC-amount;
                            while(amount<0){
                                rest_amount--;
                                amount++;
                            }
                        }
                        else alert("沒得扣囉~")
                        //document.getElementById("materialA").textContent=rest_m1;
                        //document.getElementById("materialB").textContent=rest_m2;
                        document.getElementById("amount").textContent=amount;
                    });*/
					
					/*$(".bigsub").click(function(){
							amount = 0;
							rest_amount=sA+sB+sC;
						document.getElementById("amount").textContent=amount;
					});*/
					
					
					
                    $(".submit").click(function(){
                        /*if(percent!=1000)
                            alert("分配不夠喔~"+percent)*/
						var TRequire = parseInt(r_aa)+parseInt(r_ba)+parseInt(r_ca);
						if(amount < TRequire){
							alert("原料分配有誤!")
						}
                        else{
                        	$.ajax({
                                url:"GET_product_plan.php",
                                type: "GET",
                                datatype: "html",
                                data: "&option=update&type=B&a_supplyA="+r_aa+"&a_supplyB="+r_ba+"&a_supplyC="+r_ca+"&b_supplyA="+r_ab+"&b_supplyB="+r_bb+"&b_supplyC="+r_cb,
                                success: function(str){
                                    //alert("SUCCESS~!!")
                                    alert(str);
									
									//journal();
                                }
                        	});
							
						}//end of else
                    });//end of submit
                }//end of clickset()
				
				
                function journal(){
                    TINY.box.show({iframe:'journal.html',boxid:'frameless',width:800,height:500,style:"z-index:2; top:30px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
                }

                function show_Material(){                   //動態顯示總原料數&總生產數
                    var a = isNaN(parseInt(document.getElementById("supA").value))? 0:parseInt(document.getElementById("supA").value);
    				var b = isNaN(parseInt(document.getElementById("supB").value))? 0:parseInt(document.getElementById("supB").value);
    				var c = isNaN(parseInt(document.getElementById("supC").value))? 0:parseInt(document.getElementById("supC").value);
                    
                    document.getElementById("total_requireA").textContent = a+b+c;
                    document.getElementById("total_requireB").textContent = a+b+c;
                    
                    
                    document.getElementById("totalproduce").textContent = a+b+c;
                }


                function showtotalproduce()
                {
                    document.getElementById("totalproduce").textContent=document.getElementById("total_requireA").textContent;
                }

                
    			
                $("#supA").blur(function changea(){
                	$.ajax({
                        url:"./GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: "&option=get&type=B",
                        success: function(str){
    						//alert(str);
                            var word=str.split(":");


                          
                    
    				r_aa = isNaN(parseInt(document.getElementById("supA").value))? 0:parseInt(document.getElementById("supA").value);
    				r_ab = isNaN(parseInt(document.getElementById("supA").value))? 0:parseInt(document.getElementById("supA").value);

    				or_aa = parseInt(word[6],10);
    				or_ab = parseInt(word[9],10);
    				
    				if(i_aa+or_aa<r_aa){
    					if(i_ab+or_ab<r_ab){
    						r_aa = document.getElementById("A_requireA").textContent;
    						r_ab = document.getElementById("A_requireB").textContent;
    						alert("螢幕與面板不足&主機板與核心電路不足");
    					}
    					else{
    						r_aa = document.getElementById("A_requireA").textContent;
    						r_ab = document.getElementById("A_requireB").textContent;
    						alert("螢幕與面板不足");
    					}
    				}
    				else if(i_ab+or_ab<r_ab){
    					r_aa = document.getElementById("A_requireA").textContent;
    					r_ab = document.getElementById("A_requireB").textContent;
    					alert("主機板與核心電路不足");
    				}
    				else{
    					
    					document.getElementById("A_requireA").textContent = document.getElementById("supA").value;
    					document.getElementById("A_requireB").textContent = document.getElementById("supA").value;
    					show_Material();
    				}
                        }
    			});
                });

    			
                $("#supB").blur(function changeb(){
                	$.ajax({
                        url:"./GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: "&option=get&type=B",
                        success: function(str){
    						//alert(str);
                            var word=str.split(":");

                            
    				r_ba = isNaN(parseInt(document.getElementById("supB").value))? 0:parseInt(document.getElementById("supB").value);
    				r_bb = isNaN(parseInt(document.getElementById("supB").value))? 0:parseInt(document.getElementById("supB").value);

    				or_ba = parseInt(word[7],10);
    				or_bb = parseInt(word[10],10);
    				
    				
    				if(i_ba+or_ba<r_ba){
    					if(i_bb+or_bb<r_bb){
    						r_ba = document.getElementById("B_requireA").textContent;
    						r_bb = document.getElementById("B_requireB").textContent;
    						alert("螢幕與面板不足&主機板與核心電路不足");
    					}
    					else{
    						r_ba = document.getElementById("B_requireA").textContent;
    						r_bb = document.getElementById("B_requireB").textContent;
    						alert("螢幕與面板不足");
    					}
    				}
    				else if(i_bb+or_bb<r_bb){
    					r_ba = document.getElementById("B_requireA").textContent;
    					r_bb = document.getElementById("B_requireB").textContent;
    					alert("主機板與核心電路不足");
    				}
    				else{
    					
    					document.getElementById("B_requireA").textContent = document.getElementById("supB").value;
    					document.getElementById("B_requireB").textContent = document.getElementById("supB").value;
    					show_Material();
    				}
                        }
                	});
    			});

    			


    			
                $("#supC").blur(function changec(){
                	$.ajax({
                        url:"./GET_product_plan.php",
                        type: "GET",
                        datatype: "html",
                        data: "&option=get&type=B",
                        success: function(str){
    						//alert(str);
                            var word=str.split(":");
                    
    				r_ca = document.getElementById("supC").value;
    				r_cb = document.getElementById("supC").value;

    				or_ca = parseInt(word[8],10);
    				or_cb = parseInt(word[11],10);
    				
    				if(i_ca+or_ca<r_ca){
    					if(i_cb+or_cb<r_cb){
    						r_ca = document.getElementById("C_requireA").textContent;
    						r_cb = document.getElementById("C_requireB").textContent;
    						alert("螢幕與面板不足&主機板與核心電路不足");
    					}
    					else{
    						r_ca = document.getElementById("C_requireA").textContent;
    						r_cb = document.getElementById("C_requireB").textContent;
    						alert("螢幕與面板不足");
    					}
    				}
    				else if(i_cb+or_cb<r_cb){
    					r_ca = document.getElementById("C_requireA").textContent;
    					r_cb = document.getElementById("C_requireB").textContent;
    					alert("主機板與核心電路不足");
    				}
    				else{
    					
    					document.getElementById("C_requireA").textContent = document.getElementById("supC").value;
    					document.getElementById("C_requireB").textContent = document.getElementById("supC").value;
    					show_Material();
    				}
                        }
                	});
    			});
                
            });

            
        </script>
        <style type="text/css">
            #total_material,#produce_amount,#supplyA,#supplyB,#supplyC{
                margin:0px;
                margin-left:auto;
                margin-right:auto;
                width: 75px;
                padding:5px;
                background:#e5eecc;
                border:solid 1px #c3c3c3;
                filter:alpha(opacity=80);
                -moz-opacity:0.8;
                opacity: 0.8;
            }
            #materialA,#materialB,#total_requireA,#total_requireB,
            #A_inventoryA,#A_inventoryB,#B_inventoryA,#B_inventoryB,#C_inventoryA,#C_inventoryB,
            #A_requireA,#A_requireB,#B_requireA,#B_requireB,#C_requireA,#C_requireB{
                margin:0px;
                margin-left:auto;
                margin-right:auto;
                width: 60px;
                padding:5px;
                background:ghostwhite;
                border:solid 1px #c3c3c3;
                filter:alpha(opacity=80);
                -moz-opacity:0.8;
                opacity: 0.8;
            }
            div.ui-slider{padding: 0;}	/*因為smart_tab.css的關係要加這兩行padding*/
            div.ui-widget-header {padding: 0;background:#F6921E;}	/*background是因為slider的range用min比較合理的感覺，不然可以像purchase_materialA那樣用*/
        </style>
    </head>
    <body>
        <table align="center" width="100%" height="70%"><caption><font size="5">平板電腦</font></caption>
            <tr><th>&nbsp;</th><td></td></tr>
            <tr><th>&nbsp;</th><th colspan=2>螢幕與面板</th><th colspan=2>主機板與核心電路</th></tr>
            <tr><td>&nbsp;</td><td>庫存量</td><td>投入量</td><td>庫存量</td><td>投入量</td></tr>
            <tr><td id="supplyA" width="20%">供應商A</td>
                <td id="A_inventoryA" width="20%">0</td>
                <td id="A_requireA" width="20%">0</td>
                <td id="A_inventoryB" width="20%">0</td>
                <td id="A_requireB" width="20%">0</td>
                <!--<td width="30%"><div id="sliderA" style="width:90%;margin-left:15px;"></div></td>-->
                <td width="10%"><input id="supA" class="supply" onBlur="changea()" style="text-align:right" 
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>
            <tr><td id="supplyB" width="20%">供應商B</td>
                <td id="B_inventoryA" width="20%">0</td>
                <td id="B_requireA" width="20%">0</td>
                <td id="B_inventoryB" width="20%">0</td>
                <td id="B_requireB" width="20%">0</td>
                <!--<td width="30%"><div id="sliderB" style="width:90%;margin-left:15px;"></div></td>-->
                <td width="10%"><input id="supB" class="supply" onBlur="changeb()" style="text-align:right" 
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>
            <tr><td id="supplyC" width="20%">供應商C</td>
                <td id="C_inventoryA" width="20%">0</td>
                <td id="C_requireA" width="20%">0</td>
                <td id="C_inventoryB" width="20%">0</td>
                <td id="C_requireB" width="20%">0</td>
                <!--<td width="30%"><div id="sliderC" style="width:90%;margin-left:15px;"></div></td>-->
                <td width="10%"><input id="supC" class="supply" onBlur="changec()" style="text-align:right" 
                onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <!--上方行為限定輸入數字(不包含小數點)-->
                </td>
            </tr>

            <tr><td id="total_material" width="10%">原料總數</td>
                <td id="materialA" width="10%">0</td>
                <td id="total_requireA" width="10%">0</td>
                <td id="materialB" width="10%">0</td>
                <td id="total_requireB" width="10%">0</td>
                
            </tr>
            
            <tr><td id="produce_amount" width="10%">生產數量</td>
            	<td align="center"></td>
                <td align="center"></td>
                <td align="center"><span id="totalproduce">0</span></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center" colspan=3></td>
            </tr>

            <tr><td id="produce_amount" width="20%">最高生產量</td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"><span id="amount">0</span></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center" colspan=2><input type="image" src="../images/submit6.png" class="submit" width="100px"></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </body>
</html>