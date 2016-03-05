<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主控台</title>
</head>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.timers.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
<style type="text/css">
.show{
	color:#F60;
	}
input.groovybutton
{
   font-size:14px;
   font-weight:bold;
   color:#FFF;
   height:30px;
   background-color:#0077BB;
   border-style:none;
   font-size:0.4cm;
   font-family:Arial Unicode MS,微軟正黑體;
}

<!--
#div {
	background-color:#FFF;
	position:absolute;
	width:800px;
	top:88px;
	left:198px;
	text-align: center;
	font-weight:800;
	font-size:0.9cm;
	border: 3px dotted #f5f500;
	overflow: auto;
	height:500px;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	.a{
	text-align:left;
	font-size:0.5cm;
	margin-left:18%; 
	margin-right:18%; 
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	
    .b{
	margin-left:18%; 
	margin-right:18%; 
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	background-color:#ccddff;
	}
.body{
	background-color:#ccddff;
	}    

-->
</style>
<script>

 $(document).ready(function()
 {
	 $.ajax({						
		  url:"timesetDB.php",
		  type:"GET",
		  dataType:"html",
		  success:function(xml){
			    updatemessageini(xml);
		  }
	});
	 
	$('#gamestart').click(function(){
		gamestart();
	});	
	
	$('#continuegame').click(function(){
		continuegame();
		$("#continuegame").attr("disabled",false);	 	 
	});
	
	//將遊戲結束在下一回合
	$('#stopgame').click(function(){
		stopgame();
		$("#stopgame").attr("disabled",false);//讓功能顯示
	});	
	
	$('#closegame').click(function(){
		$.post("timesetDB.php",{closegame:1},function(xml){
		$("#closegame").attr("disabled",true);
		});
	});
	
	$('#modifyroundtime').click(function(){
		$.post("timesetDB.php",{modifyroundtime:$("#change").val()},function(xml){
			updatemessagecon(xml);
		});	 
	});	
	
	$('#modifygameyear').click(function(){
		$.post("timesetDB.php",{modifygameyear:$("#change3").val()},function(xml){
			updatemessagecon(xml);
		});
	});
	$('#cleargame').click(function(){
		$.post("timesetDB.php",{cleargame:1},function(xml){
			 alert("success!");
			 $("#gamestart").attr("disabled",false);
			 document.location.href="timeset.php";
		});
	});	
 });
	  //下面會改變的東西
   function updatemessagecon(xml){
	$("message",xml).each(function(id){
		message = $("message",xml).get(id);
		document.getElementById("nowroundtime").innerHTML =$("roundtime",message).text();
		document.getElementById("gameyear").innerHTML =$("gameyear",message).text();
   	 });
	}
     function updatemessageini(xml){
		$("message",xml).each(function(id){
			//alert("SHIT~!!");
			message = $("message",xml).get(id);
			document.getElementById("nowroundtime").innerHTML =$("roundtime",message).text();
			document.getElementById("gameyear").innerHTML =$("gameyear",message).text();
			document.getElementById("status").innerHTML =$("status",message).text();
			var isstart =$("isstart",message).text();
			if(isstart==1){
				gamestartdisabled();
				isgamestart();
			}
     	});//isstart==1 把按鈕鎖定
	}
	
	function gamestartdisabled()
	{
		
			$("#gamestart").attr("disabled",true);
			$("#continuegame").attr("disabled",false);
			$("#modifyroundtime").attr("disabled",true);
			$("#modifygameyear").attr("disabled",true);
			$("#modifyresttime").attr("disabled",true);
		
	}
	function gettime(xml){
		$("message",xml).each(function(id){
			message = $("message",xml).get(id);
			lefttime = $('lefttime',message).text();
		});
	}
	function gamestart() {
		isgamestart1();
    }
     
	  //繼續遊戲
	function continuegame(){
		$.post("timesetDB.php",{isgamecontinue:1},function(xml){ 
			gettime(xml);
			leftmin = parseInt(Math.floor(lefttime/60));
			leftsec = parseInt(lefttime % 60);
			alert(leftmin);
			alert(leftsec);
			clock();
			updatenow(xml);
		});	
     }
	function stopgame(){
		$.post("sql_stop.php",function(xml){
				alert("下回合遊戲將會停止");
		});
    }
    function isgamestart(){
		//alert("SHIT~!!");
		$.post("timesetDB.php",{isgamestart:3},function(xml){
             gettime(xml);
             leftmin = parseInt(Math.floor(lefttime/60));
             leftsec = parseInt(lefttime % 60);
             clock();
             updatenow(xml);
			 month_forward();
		});
   }
		  //上面會改變得
	function updatenow(xml){
		$("message",xml).each(function(id){
			message = $("message",xml).get(id);
			document.getElementById("nowt").innerHTML =$("nowt",message).text();
			document.getElementById("nowr").innerHTML =$("nowr",message).text();
			document.getElementById("status").innerHTML =$("status",message).text();
     	 });         
	}
		 
		//設定旗幟 
	 function clock(){
		if(leftsec !=0){
			leftsec = leftsec - 1;
			if(leftsec<0){
				document.getElementById("status").innerHTML ="遊戲結束";
				return;
			}
		}
		else if(leftmin==0 && leftsec==0){
			return run();
		}
		else{
			leftmin = leftmin -1;
			leftsec = 59;
		}
		document.getElementById("leftmin").innerHTML = leftmin;
		document.getElementById("leftsec").innerHTML = leftsec;
		setTimeout("clock()",1000);
	}
	    function run(){
			isgamestart();
		}
		function isgamestart1(){
	     $.post("timesetDB.php",{isgamestart:1},function(xml){
			gettime(xml);
			leftmin = parseInt(Math.floor(lefttime/60));
			leftsec = parseInt(lefttime % 60);
			clock();
			updatenow(xml);
			});
			month_forward();
         }
		 
		 var month_forward=function(){
			 //alert("SHIT~SHIT~!!");
                $.ajax({
                    url: '../../abc_main/month_forward.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//                        alert("month_forward success~!! "+str);
                        if(str!='1/1')
                            supplier_kernel();
                    }
                });
            }
            var supplier_kernel=function(str){
                $.ajax({
                    url: '../../abc_main/supplier_kernel.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("supplier_kernel success~!! "+str);
							order_forward();
						}
                });
            }
            var order_forward=function(){
                $.ajax({
                    url: '../../abc_main/order_forward.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("order_forward success~!!"+str);
							order_create();
						}
                });
            }
            var order_create=function(){
                $.ajax({
                    url: '../../abc_main/order_create.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("order_create success~!! "+str);
							order_calculate();
						}
                });
            }
            var order_calculate=function(){
                $.ajax({
                    url: '../../abc_main/order_calculate.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("order_calculate success~!! "+str);
							trend();
						}
                });
            }
            var trend=function(){
                $.ajax({
                    url: '../../abc_main/trend_record.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("trend_record success~!! "+str);
							marco_economy();
						}
                });
            }
            var marco_economy=function(){
                $.ajax({
                    url: '../../abc_main/macro_economy.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("marco_economy success~!! "+str);
							inventory_adjust();
						}
                });
            }
            var inventory_adjust=function(){
                $.ajax({
                    url: '../../abc_main/inventory_adjust.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("inventory_adjust success~!! "+str);
							influence();
						}
                });
            }
            var influence=function(){
                $.ajax({
                    url: '../../abc_main/influence.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("influence success~!! "+str);
							satisfaction();
						}
                });
            }
            var satisfaction=function(){
                $.ajax({
                    url: '../../abc_main/satisfaction.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("satisfaction success~!!"+str);
							produce();
						}
                });
            }
            var produce=function(){
                $.ajax({
                    url: '../../abc_main/produce.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("product success~!!"+str);
							fund();
						}
                });
            }
            var fund=function(){
                $.ajax({
                    url: '../../abc_main/fund.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("fund success~!!"+str);
							situation();
						}
                });
            }
            var situation=function(){
                $.ajax({
                    url: '../../abc_main/situation_effect.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("situation effect success~!!"+str);
							cost_calculation();
						}
                });
            }
            var cost_calculation=function(){
                $.ajax({
                    url: '../../abc_main/cost_calculation.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("cost_calculation success~!!"+str);
							journal_to_report();
						}
                });
            }
            var journal_to_report=function(){
                $.ajax({
                    url: '../../abc_main/journal_to_report.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("journal_to_report  success~!!"+str);
							stock_price();
						}
                });
            }
            var stock_price=function(str){
                $.ajax({
                    url: '../../abc_main/stock_price.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("stock_price success~!! "+str);
							kpi_calculation();
						}
                });
            }
            var kpi_calculation=function(){
                $.ajax({
                    url: '../../abc_main/kpi_calculation.php',
                    type:'POST',
                    error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
//							alert("kpi_calculation success~!!"+str);
						}
                });
            }
</script>



<body class="body">


<div id=div >
<form>
<br/>
  <div class="b">
  競賽名稱： <span id="gname" class="show"></span><br/>  
  第<span id="nowt" class="show"></span>年<span id="nowr" class="show"></span>月 
  本回合剩下<span id="leftmin" class="show"></span>分<span id ="leftsec" class="show"></span>秒 <br/>
 
 
          <span id="status" class="show"></span></p>  
		  </div>
	          <input type="button"  id="gamestart"  class="groovybutton" value="競賽開始" /> 
              <input type="button"  id="continuegame"  class="groovybutton" value="繼續競賽" /> 
              <input type="button"  id="stopgame"  class="groovybutton" value="將競賽停在下一回合"/>
              <input type="button"  id="cleargame"  class="groovybutton" value="清除競賽時間" /></button>
	  <br/>
	  <br/>
<div class="a">
    <table border="0" align="center">
        <tr>
        	<td colspan="2">目前設定</td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">修改設定</td>
        </tr>
        <tr>
        	<td>競賽年限： </td><td><span id="gameyear" class="show"></span> 年</td>
            <td></td>
            <td></td>
            <td></td>
            <td><input name="text" type="text" id="change3" size="3" /></td>
            <td><input name="button" type="button" class="groovybutton" id="modifygameyear" value="修改" /></button></td>
        </tr>
        <tr>
        	<td> 每回合時間：</td><td><span id="nowroundtime" class="show"></span> 分鐘</td>
            <td></td>
            <td></td>
            <td></td>
            <td> <input type="text" size="3" id="change" /></td>
            <td><input type="button" id="modifyroundtime" class="groovybutton" value="修改" /></button></td>
        </tr>    
    </table>    

        <br/><br/>
        <font color="#ff3030">!!!競賽進行過程中，禁止將計時器視窗關閉或重新整理!!!</font>
		</div>	
</form>
</div>
</body>
</html>
