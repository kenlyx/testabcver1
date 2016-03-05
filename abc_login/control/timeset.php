<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主控台</title>
</head>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.timers.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
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
	width:76%;
	top:10%;
	left:12%;
	right:12%;
	text-align: center;
	font-weight:800;
	font-size:0.9cm;
	border: 3px dotted #f5f500;
	overflow: auto;
	height:80%;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	.a{
	text-align:left;
	font-size:0.5cm;
	margin-left:10%; 
	margin-right:10%; 
	color:#FFFFF;
	font-family:Arial Unicode MS,微軟正黑體;
	}
	
    .b{
	margin-left:10%; 
	margin-right:10%; 
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
var time=0;
var start_time;
var endtime;
var gname , roundtime , gameyear , status , nowr , nowt;
$(document).ready(function(){
	//載入頁面先從timesetDB中取基本值
	$.ajax({						
		url:"timesetDB.php",
		type:"GET",
		dataType:"html",
		data:{
			type:"ready"
		},
		error: function(){
			alert("讀取timesetDB失敗");
		},
		success:function(str){
			getall(str);
			document.getElementById("gname").innerHTML = gname;
			document.getElementById("nowroundtime").innerHTML = roundtime;
			document.getElementById("gameyear").innerHTML = gameyear;
			document.getElementById("status").innerHTML = status;
			if(isstart == 1){
				gamestartdisabled();
				updatenow();
				if(status == "競賽進行中"){
					leftmin = parseInt(Math.floor(lefttime/60));
					leftsec = parseInt(lefttime % 60);
					clock();
				}
			}
			
			
		}
	});
	
	//上側四個button   開始/繼續/暫停/清除    ------------------------------------------
	$('#gamestart').click(function(){
		gamestart();
		gamestartdisabled();
	});	
	
	$('#continuegame').click(function(){
		continuegame();
		//$("#continuegame").attr("disabled",false);	 	 
	});
	
	$('#stopgame').click(function(){
		pausegame();
		
		//$("#stopgame").attr("disabled",false);//讓功能顯示
	});	
	
	$('#cleargame').click(function(){
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"cleargame"
			},
			error: function(){
				alert("clear fail");
			},
			success: function(){
				alert("clear success");
				document.location.href="timeset.php";
			}
		});
		
	});	
	
	//-------------------------------------------------------------------------------
	
	//修改競賽年限&每合回時間的button---------------------------------------------------------------------
	$('#modifygameyear').click(function(){
		var gameyear = document.getElementById("input_gameyear").value;
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"change_gameyear" , gameyear:gameyear
			},
			error: function(){
				alert("修改競賽年限失敗");
			},
			success: function(){
				document.getElementById("gameyear").innerHTML = gameyear;
			}
		});
		
	});
	
	$('#modifyroundtime').click(function(){
		
		var roundtime = document.getElementById("input_roundtime").value;
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"change_roundtime" , roundtime:roundtime 
			},
			error: function(){
				alert("修改回合時間失敗");
			},
			success: function(){
				document.getElementById("nowroundtime").innerHTML = roundtime;
			}
			
		});
		
	});	
	//修改競賽年限&每合回時間的button---------------------------------------------------------------------
	
});//end of ready function
	
	//暫時沒使用這func----------------------------------
	function gamestartdisabled(){
		$("#gamestart").attr("disabled",true);
		$("#continuegame").attr("disabled",false);
		$("#stopgame").attr("disabled",false);
		$("#modifyroundtime").attr("disabled",true);
		$("#modifygameyear").attr("disabled",true);
	}
	//----------------------------------------------
	function gamestart() {
		
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"gamestart"
			},
			error: function(){
				alert("gamestart() error");
			},
			success: function(str){
				getall(str);
				updatenow();
				leftmin = parseInt(Math.floor(lefttime/60));
				leftsec = parseInt(lefttime % 60);
				month_forward();
				clock();
			}
		});
    }
	
	function getall(str){//取得回傳str裡的10個var
		//alert("in getall");
		gamedata = str.split("|");
		start_time = parseInt(gamedata[1]);//遊戲啟動時間
		gname = gamedata[2];//遊戲名稱
		endtime = gamedata[3];//該回合結束時間
		isstart = gamedata[4];//遊戲是否為啟動中(1=是,0=否)
		lefttime = gamedata[5];//該回合剩於時間
		roundtime = gamedata[6];//一回合幾分鐘
		gameyear = gamedata[7];//遊戲年限(玩幾年)
		status = gamedata[8];//遊戲狀態(競賽進行中,競賽暫停中,競賽結束)
		nowt = gamedata[9];//該回合為第nowt年
		nowr = gamedata[10];//該回合為第nowr月
	}
	
	function updatenow(){//更新 遊戲status  當前年  當前月
		//alert("in updatenow");
		document.getElementById("nowt").innerHTML = nowt;
		document.getElementById("nowr").innerHTML = nowr;
		document.getElementById("status").innerHTML = status;
     	       
	}
	
	function run(){
		//alert("in run");
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"run"
			},
			error: function(){
				alert("run() error");
			},
			success: function(str){
				getall(str);
				updatenow();
				month_forward();
				if(status == "競賽進行中"){
					leftmin = parseInt(Math.floor(lefttime/60));
					leftsec = parseInt(lefttime % 60);
					clock();
				}
			}
		});
		
	}
	
	function continuegame(){
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"continue"
			},
			error: function(){
				alert("continue error");
			},
			success: function(){
				alert("continue success");
				document.location.href="timeset.php";
			}
		});
    }
	
	function pausegame(){
		$.ajax({
			url:"timesetDB.php",
			type:"GET",
			dataType:"html",
			data:{
				type:"pausegame"
			},
			error: function(){
				alert("pausegame error");
			},
			success: function(){
				alert("pause success");
				document.location.href="timeset.php";
			}
		});
    }	 
	
	 
	 
	//設定旗幟 
	function clock(){
		//alert("in clock");
		time+=1000;
		if(leftsec !=0){
			leftsec = leftsec - 1;
			if(leftsec<0){
				document.getElementById("status").innerHTML = "競賽結束";
				return run();
			}
		}
		else if(leftmin==0 && leftsec==0){
			return run();
		}
		else{
			leftmin = leftmin - 1;
			leftsec = 59;
		}
		var ST = start_time * 1000;
		var t = parseInt(time);
		var diff = (new Date().getTime() - ST) - t;
		//201310月新設while迴圈 加快校正到正確值的時間
		
		while(diff > 1000){
			if(diff > 100000000){
				time+= 100000000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
			if(diff > 10000000){
				time+= 10000000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
			if(diff > 1000000){
				time+= 1000000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
			if(diff > 100000){
				time+= 100000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
			if(diff > 10000){
				time+= 10000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
			if(diff > 1000){
				time+= 1000;
				t=parseInt(time);
				diff=(new Date().getTime() - ST) - t;
			}
		}
		
		document.getElementById("leftmin").innerHTML = leftmin;
		document.getElementById("leftsec").innerHTML = leftsec;
		document.getElementById("diff").innerHTML = diff+" + "+ST+" + "+t+" + "+new Date().getTime();
		setTimeout("clock()",1000-diff);
		
	} 
		 
		 
		 
		 
	
		 
//-----------------------------------------------------------------------------------------------------------------------		 
		 
		 
		 
		 
		 
		 
		 
		 



		 
	var month_forward=function(){
		//alert("in month_forward");
		$.ajax({
			url: '../../abc_main/month_forward.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤1');},
			success:
				function(str){
							//alert("month_forward success~!! "+str);
				if(str!='1/1')
					supplier_kernel();
					
				}//end of fuction(str)
		});//end of ajax
	}
	var supplier_kernel=function(str){
				//alert(2);
		$.ajax({
			url: '../../abc_main/supplier_kernel.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤2');},
			success:
				function(str){
								//alert("supplier_kernel success~!! \n"+str);
					order_forward();
				}
		});
	}
	var order_forward=function(){
				//alert(3);
		$.ajax({
			url: '../../abc_main/order_forward.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤3');},
			success:
				function(str){
//							alert("order_forward success~!!"+str);
					order_create();
				}
		});
	}
	var order_create=function(){
				//alert(4);
		$.ajax({
			url: '../../abc_main/order_create.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤4');},
			success:
				function(str){
//							alert("order_create success~!! "+str);
					order_calculate();
				}
		});
	}
	var order_calculate=function(){
				//alert(5);
		$.ajax({
			url: '../../abc_main/order_calculate.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤5');},
			success:
				function(str){
							//alert("order_calculate success~!! "+str);
					trend();
			}
		});
	}
	var trend=function(){
				//alert(6);
		$.ajax({
			url: '../../abc_main/trend_record.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤6');},
			success:
				function(str){
//							alert("trend_record success~!! "+str);
					marco_economy();
				}
		});
	}
	var marco_economy=function(){
				//alert(7);
		$.ajax({
			url: '../../abc_main/macro_economy.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤7');},
			success:
				function(str){
//							alert("marco_economy success~!! "+str);
					inventory_adjust();
				}
		});
	}
	var inventory_adjust=function(){
				//alert(8);
		$.ajax({
			url: '../../abc_main/inventory_adjust.php',
 			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤8');},
			success:
				function(str){
//							alert("inventory_adjust success~!! "+str);
					influence();
				}
		});
	}
	var influence=function(){
				//alert(9);
		$.ajax({
			url: '../../abc_main/influence.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤9');},
			success:
				function(str){
//							alert("influence success~!! "+str);
					satisfaction();
				}
		});
	}
	var satisfaction=function(){
			   // alert(10);
		$.ajax({
			url: '../../abc_main/satisfaction.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤10');},
			success:
				function(str){
//							alert("satisfaction success~!!"+str);
					produce();
			}
		});
	}
	var produce=function(){
				//alert(11);
		$.ajax({
			url: '../../abc_main/produce.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤11');},
			success:
				function(str){
//							alert("product success~!!"+str);
					fund();
				}
		});
	}
	var fund=function(){
				//alert(12);
		$.ajax({
			url: '../../abc_main/fund.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤12');},
			success:
				function(str){
//							alert("fund success~!!"+str);
					situation();
				}
		});
	}
	var situation=function(){
				//alert(13);
		$.ajax({
			url: '../../abc_main/situation_effect.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤13');},
			success:
				function(str){
//							alert("situation effect success~!!"+str);
					cost_calculation();
				}
		});
	}
	var cost_calculation=function(){
				//alert(14);
		$.ajax({
			url: '../../abc_main/cost_calculation.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤14');},
			success:
				function(str){
							//alert("cost_calculation success~!!"+str);
					journal_to_report();
				}
		});
	}
	var journal_to_report=function(){
		//alert(15);
		$.ajax({
			url: '../../abc_main/journal_to_report.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤15');},
			success:
				function(str){
					//alert("journal_to_report  success~!!"+str);
					stock_price();
				}
		});
	}
	var stock_price=function(str){
		//alert(16);
		$.ajax({
			url: '../../abc_main/stock_price.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤16');},
			success:
				function(str){
//							alert("stock_price success~!! "+str);
					kpi_calculation();
				}
		});
	}
	var kpi_calculation=function(){
		//alert(17);
		$.ajax({
			url: '../../abc_main/kpi_calculation.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤17');},
			success:
				function(str){
//							alert("kpi_calculation success~!!"+str);
					rankcc();
				}
		});
	}
	 var rankcc=function(){
//				alert(17);
		$.ajax({
			url: '../../abc_main/LeftFeatures/rankchange.php',
			type:'POST',
			error:
				function(xhr) {alert('Ajax request 發生錯誤18');},
			success:
				function(str){
//						alert("rank success~!!"+str);
						dupont();
				}
		});	
	}
	var dupont=function(){
			//alert(15);
			$.ajax({
				url: '../../abc_main/LeftFeatures/dupont.php',
				type:'POST',
				error:
					function(xhr) {alert('Ajax request 發生錯誤19');},
				success:
					function(str){
						//alert("dupont  success~!!"+str);
					}
			});
		}
</script>



<body class="body">


<div id=div >
<form>
    <div align="center"><br/>
    </div>
    <div class="b">
      <div align="center">競賽名稱： <span id="gname" class="show"></span><br/>  
        第<span id="nowt" class="show"></span>年<span id="nowr" class="show"></span>月 
        本回合剩下<span id="leftmin" class="show"></span>分<span id ="leftsec" class="show"></span>秒 <br/>
        
        
        <span id="status" class="show"></span>
        </p>  
      </div>
    </div>
	<div align="center">
        <input type="button"  id="gamestart"  class="groovybutton" value="競賽開始" /> 
        <input type="button"  id="continuegame"  class="groovybutton" value="繼續競賽" /> 
        <input type="button"  id="stopgame"  class="groovybutton" value="暫停競賽"/>
        <input type="button"  id="cleargame"  class="groovybutton" value="清除競賽時間" /></button>
        <br/>
        <br/>
    </div>
    <div class="a">
      <div align="center">
        <table border="0" align="center">
          <tr>
              <td colspan="2">目前設定</td>
              <td id="test"></td>
              <td></td>
              <td></td>
              <td colspan="2">修改設定</td>
          </tr>
          <tr>
              <td>競賽年限： </td><td><span id="gameyear" class="show"></span> 年</td>
              <td></td>
              <td></td>
              <td></td>
              <td><input name="text" type="text" id="input_gameyear" size="3" /></td>
              <td><input name="button" type="button" class="groovybutton" id="modifygameyear" value="修改" /></button></td>
          </tr>
          <tr>
              <td> 每回合時間：</td><td><span id="nowroundtime" class="show"></span> 分鐘</td>
              <td></td>
              <td></td>
              <td></td>
              <td> <input type="text" size="3" id="input_roundtime" /></td>
              <td><input type="button" id="modifyroundtime" class="groovybutton" value="修改" /></button></td>
          </tr>    
        </table>    
	              
          <br/><br/>
          <font color="#ff3030">!!!競賽進行過程中，禁止將計時器視窗關閉!!!<span id ="diff" class="show"></span></font>
      </div>
    </div>	
</form>
</div>
<div align="center"></div>
</body>
</html>
