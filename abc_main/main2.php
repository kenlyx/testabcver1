<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="./css/bootstrap.css" rel="stylesheet">
<link href="./font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="./css/main.css" rel="stylesheet">
<title>ABC Decision</title>
<?php
	include("./connMysql.php");
	$cname=$_SESSION['CompanyName'];
	$cid=$_SESSION['cid'];
	$acc=$_SESSION['user'];
	if($acc=="")
		echo "<script language=\"JavaScript\"> alert('登入已過期，請從新登入!'); location.href=('../abc_login/player_login.php')</script>";
	
	mysql_select_db("testabc_main");
	$sql_year = "SELECT MAX(`year`) FROM `state`";
	$result = mysql_query($sql_year) or die("Query failed@month");	
	$rowy=mysql_fetch_array($result);
	$year=$rowy[0];
	
	$sql_month = "SELECT MAX(`month`) FROM `state` WHERE `year`=$rowy[0];";
	$result = mysql_query($sql_month) or die("Query failed@month");	
	$rowm=mysql_fetch_array($result);
	$month=$rowm[0];
	
	$_SESSION['year']=$year;
	$_SESSION['month']=$month;
	
	//error_reporting(0);
	$temp = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");
    $money = mysql_fetch_array($temp);
    $cash = $money[0];
	//echo $year."|".$month."|".$cid;
	mysql_select_db("testabc_login"); //get cid
	$sql_cid = mysql_query("SELECT `cid` FROM `authority` WHERE `account`='".$acc."'");
	$cid = mysql_fetch_array($sql_cid);
	$_SESSION['cid']=$cid[0];
	
	$sql_decision = mysql_query("SELECT `decision` FROM `authority` WHERE `account`='".$acc."'");
	$decision = mysql_fetch_array($sql_decision);
	
	$sql_gettime = mysql_query("SELECT * FROM `time` WHERE `id`='".(12*($year-1)+$month)."'");
	$gettime = mysql_fetch_array($sql_gettime);
	$endtime=$gettime['endtime'];
	//echo $endtime;
	
	$sql_gamestate = mysql_query("SELECT * FROM `timer` WHERE `id`=1");
	$gamestate = mysql_fetch_array($sql_gamestate);
	$gameyear=$gamestate['gameyear'];
	$gamestatus=$gamestate['status'];
	//echo $gamestatus;
	
	//decision
	$sql_infod= mysql_query("SELECT * FROM `info_decision`");
	$info_d=mysql_fetch_array($sql_infod);
	
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  

    </head>

<script type=text/javascript>
$(function(){
	clock();
});
</script>

<noscript>
		<style type="text/css">
			#dock { top: 0; left: 100px; }
			a.dock-item { position: relative; float: left; margin-right: 10px; }
			.dock-item span { display: block; }
			.stack { top: 0; }
			.stack ul li { position: relative; }
		</style>
</noscript>
	<script type="text/javascript" src="serverDate.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	
</head>
<body>
<!------------------siodebar area-------------------------->
  <div class="col-sm-1" style="padding:0;">
    <div class="sidebar-nav" >
      <div class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <span class="visible-xs navbar-brand">ABC Decision</span>
          <button id="togglebutton" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active hidden-xs"><a href="#">ABC Decision</a></li>
<!-------------------------------slidedown try---------------------------->
            <li><a data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-dashboard  fa-lg"></i> 願景</a></li>
              <div class="collapse " id="collapseExample1">
                  <a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/kpi2.php'"><div onclick="autoCloseNav()" class="ctmdrop">KPI關鍵績效指標</div></a>
                  <a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_Set_finance.php'"><div onclick="autoCloseNav()" class="ctmdrop">編制預算</div></a>
                  <a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_Check_admin.php'"><div onclick="autoCloseNav()" class="ctmdrop">成效檢視</div></a>
                  <a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_income.php'"><div onclick="autoCloseNav()" class="ctmdrop">預算報表</div></a>
                  <a href="#" onclick="check_authority(1,0)"><div onclick="autoCloseNav()" class="ctmdrop">銷貨成本分析</div></a>
                  <a href="#" onclick="check_authority(2,0)"><div onclick="autoCloseNav()" class="ctmdrop">營收來源</div></a>
              </div>
                          <li><a data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-magic fa-lg"></i> 創新</a></li>
              <div class="collapse " id="collapseExample2">
                  <a href="#" onclick="check_authority(8,0)"><div onclick="autoCloseNav()" class="ctmdrop">流程改良</div></a>
                  <a href="#" onclick="check_authority(4,0)"><div onclick="autoCloseNav()" class="ctmdrop">研究/開發</div></a>
                  <a href="#" onclick="check_authority(9,0)"><div onclick="autoCloseNav()" class="ctmdrop">產品功能</div></a>
              </div>
                          <li><a data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-shopping-cart fa-lg"></i> 投入</a></li>
              <div class="collapse " id="collapseExample3">
                  <a href="#" onclick="check_authority(3,0)"><div onclick="autoCloseNav()" class="ctmdrop">資金募集</div></a>
                  <a href="#" onclick="check_authority(10,0)"><div onclick="autoCloseNav()" class="ctmdrop">招/解聘員工</div></a>
                  <a href="#" onclick="check_authority(5,0)"><div onclick="autoCloseNav()" class="ctmdrop">資產購置</div></a>
                  <a href="#" onclick="check_authority(6,0)"><div onclick="autoCloseNav()" class="ctmdrop">資產處分</div></a>
                  <a href="#" onclick="check_authority(7,0)"><div onclick="autoCloseNav()" class="ctmdrop">購買/分配原料</div></a>
              </div>
                          <li><a data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-wrench fa-lg"></i> 流程</a></li>
              <div class="collapse " id="collapseExample4">
                  <a href="#" onclick="check_authority(9,0)"><div onclick="autoCloseNav()" class="ctmdrop">生產規劃</div></a>
                  <a href="#" onclick="check_authority(11,0)"><div onclick="autoCloseNav()" class="ctmdrop">在職訓練</div></a>
                  <a href="#" onclick="check_authority(12,0)"><div onclick="autoCloseNav()" class="ctmdrop">人員效率評估</div></a>
              </div>
                          <li><a data-toggle="collapse" href="#collapseExample5" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-truck fa-lg"></i> 產出</a></li>
              <div class="collapse " id="collapseExample5">
                  <a href="#" onclick="check_authority(14,0)"><div onclick="autoCloseNav()" class="ctmdrop">接單</div></a>
                  <a href="#" onclick="check_authority(17,0)"><div onclick="autoCloseNav()" class="ctmdrop">顧客訂單量</div></a>
                  <a href="#" onclick="check_authority(18,0)"><div onclick="autoCloseNav()" class="ctmdrop">售後顧客滿意度</div></a>
              </div>
                          <li><a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-comments fa-lg"></i> 關係</a></li>
              <div class="collapse " id="collapseExample6">
                  <a href="#" onclick="check_authority(19,1)"><div onclick="autoCloseNav()" class="ctmdrop">投資人關係管理</div></a>
                  <a href="#" onclick="check_authority(19,2)"><div onclick="autoCloseNav()" class="ctmdrop">員工關係管理</div></a>
                  <a href="#" onclick="check_authority(19,3)"><div onclick="autoCloseNav()" class="ctmdrop">顧客關係管理</div></a>
                  <a href="#" onclick="check_authority(19,4)"><div onclick="autoCloseNav()" class="ctmdrop">供應商關係管理</div></a>
              </div>
                          
                          <li><a data-toggle="collapse" href="#collapseExample7" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-bullhorn fa-lg"></i> 使命 </a></li>
              <div class="collapse " id="collapseExample7">
                  <a href="#" onclick="check_authority(13,0)"><div onclick="autoCloseNav()" class="ctmdrop">廣告促銷</div></a>
                  <a href="#" onclick="check_authority(16,1)"><div onclick="autoCloseNav()" class="ctmdrop">市場占有率</div></a>
                  <a href="#" onclick="check_authority(16,2)"><div onclick="autoCloseNav()" class="ctmdrop">市場需求變化</div></a>
              </div>
              
              <li><a data-toggle="collapse" href="#collapseExample8" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-fw fa-sitemap fa-lg"></i>  架構</a></li>
              <div class="collapse " id="collapseExample8">
                  <a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/organization2.php'"><div onclick="autoCloseNav()" class="ctmdrop">決策分配</div></a>
              </div>
              
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
<!------------------sixdimension area------------------------------>
  <div class="col-sm-11  ctm-six" >
    <span class="dropdown"><a href="#" class="btn ctm-btn btn-tiffany dropdown" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i> <span class="caret"></span></a>
        <ul class="dropdown-menu ctm-dpnmenu"  role="menu" aria-labelledby="dLabel" >
                        <li class="ctm-sbtxt"><i class="fa fa-user"></i><span>公司名稱: <?php echo $cname;?></span></li>
						<li class="ctm-sbtxt"><i class="fa fa-envelope"></i><span>公司帳號: <?php echo $cid[0];?></span></li>
						<li class="ctm-sbtxt"><i class="fa fa-picture-o"></i><span>個人帳號: <?php echo $acc;?></span></li>
						<li class="ctm-sbtxt"><i class="fa fa-tasks"></i><span>剩餘資金: <?php echo $cash;?></span></li>
						<li><a href="#" onclick="logout()"><i class="fa fa-power-off"></i><span>  登出系統</span></a></li>
        </ul>
      </span>  
      <span class="dropdown"><a href="#" class="btn ctm-btn btn-pink dropdown" data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell fa-lg"></i> <span class="caret"></span></a>
        <ul class="dropdown-menu ctm-dpnmenu" role="menu" aria-labelledby="dLabel">
     <li><a data-toggle="modal" data-toggle="modal" data-target="#myModal"><i class="fa fa-user"></i><span>本期新聞</span></a></li>
            
                        <li class="ctm-sbtxt"><i class="fa fa-envelope"></i><span>遊戲時間:<?php echo "&nbsp; 第 ".$year." 年 &nbsp;&nbsp;".$month."月";?></span></li>
                        <li class="ctm-sbtxt"><i class="fa fa-picture-o"></i><span>剩餘時間</span><span id="lefttime"></span></li>
        </ul>
      </span>
    <a href="#" onclick="information()" class="btn ctm-btn btn-info" role="button"><i class="fa fa-info-circle fa-lg"></i> 資訊</a>
    <a href="#" onclick="pre_report()" class="btn ctm-btn btn-success" role="button"><i class="fa fa-files-o fa-lg"></i> 財報</a>
    <a href="#" onclick="decision()" class="btn ctm-btn btn-warning" role="button"><i class="fa fa fa-list fa-lg"></i> 決策</a>
    <a href="#" onclick="dupont()" class="btn ctm-btn btn-danger" role="button"><i class="fa fa-usd fa-lg"></i> 價值</a>
    <a href="#" onclick="journal()" class="btn ctm-btn btn-primary" role="button"><i class="fa fa-calendar fa-lg"></i> 日記帳</a>
    <a href="#" onclick="rank()" class="btn ctm-btn btn-wisdom" role="button"><i class="fa fa-bar-chart fa-lg"></i> 排名</a>
    

      
  </div>     
<!------------------iframe area------------------------------> 
      
  <div class="col-sm-11" style="padding:0;">
  <iframe id="contentiframe" class="embed-responsive-item ctm-iframe"></iframe>

  </div>
      
      
<!------------------weekends news area------------------------------>       
      
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">本期新聞</h3>
      </div>
      <div class="modal-body">
        <?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);  //連接資料表testabc_login
	mysql_query("set names 'utf8'");
	$month=$_SESSION['month'];
    $temp=mysql_query("SELECT `situation` FROM `situation_overview` WHERE `month`='2'");
    $result=  mysql_fetch_array($temp);
    $temp_01=mysql_query("SELECT `name`,`description` FROM `situation` WHERE `index`={$result['situation']};",$connect);
    $result=  mysql_fetch_array($temp_01);
	echo "<td><font size='4'>".$result['name'].",".$result['description']."</font></td>";
  ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
	  /*
		$(function(){
			var jqDockOpts = {align: 'left', duration: 200, labels: 'tc', size: 50, distance: 90};
			$('#jqDock').jqDock(jqDockOpts);
		});
		
		var xmlHttp;
function srvTime(){
	try {
		//FF, Opera, Safari, Chrome
		xmlHttp = new XMLHttpRequest();
	}
	catch (err1) {
		//IE
		try {
			xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
		}
		catch (err2) {
			try {
				xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			catch (eerr3) {
				//AJAX not supported, use CPU time.
				alert("AJAX not supported");
			}
		}
	}
	xmlHttp.open('HEAD',window.location.href.toString(),false);
	xmlHttp.setRequestHeader("Content-Type", "text/html");
	xmlHttp.send('');
	return xmlHttp.getResponseHeader("Date");
}		
*/
		var st = srvTime();
			    var serverTimeMillisGMT = Date.parse(new Date(Date.parse(st)).toUTCString());
				var localtime = new Date().getTime();
				var distance = localtime -serverTimeMillisGMT;
		function clock(){
			if('<?php echo $gamestatus; ?>' == '競賽暫停中')
				document.getElementById("lefttime").innerHTML = "競賽暫停中";
			else if("<?php echo $gamestatus; ?>" == '競賽結束')
				document.getElementById("lefttime").innerHTML = "競賽結束";
			else if("<?php echo $gamestatus; ?>" == '競賽未啟動')
				document.getElementById("lefttime").innerHTML = "競賽未啟動";
			else{
				var roundEndTime=<?php echo $endtime; ?>;
				//var st = srvTime();
			    //var serverTimeMillisGMT = Date.parse(new Date(Date.parse(st)).toUTCString());
				//var localtime = new Date().getTime();
				//var distance = localtime -serverTimeMillisGMT;
				//此回合剩餘秒數
				//var TimeLeft=(roundEndTime*1000-(serverTimeMillisGMT))/1000;
				var TimeLeft=(roundEndTime*1000-(new Date().getTime())+distance)/1000;
				if(TimeLeft>0){			
			var hour = Math.floor((TimeLeft/3600));
			document.getElementById("lefttime").innerHTML = hour + ' 時  \t'+ Math.floor((TimeLeft%3600)/60)+' 分  \t'+' '+Math.floor(TimeLeft%60)+' 秒';
			setTimeout("clock()",1000);
							
			    }
			else{
					location.href="./main2.php";
					//location.href="./main.php";					
					
}

			
			}
		}//end clock
		
		function check_authority(dnum, order){
			var isvalid=false;
//   		alert(dnum+":"+order);
			var dec="<?php echo $decision[0];?>";
			var d=dec.split(",");
	
			for(var i=0;i< d.length;i++){
				
				if(dnum == d[i]){
					isvalid=true;
					break;		
				}
				else
					isvalid=false;
			}//end for
			
			if(isvalid){
				if(dnum==1)
					document.getElementById('contentiframe').src='./ProfitModel/selling_cost_analyzing.php';
				else if(dnum==2){
					document.getElementById('contentiframe').src='./ProfitModel/revenue_model.php';
				}
				else if(dnum==3)
					document.getElementById('contentiframe').src='./ResourceIntegration/fund_raising.php';
				else if(dnum==4)
					checkrd_emp();
				else if(dnum==5)
					document.getElementById('contentiframe').src='./ResourceIntegration/purchase_machine.php';
				else if(dnum==6)
					document.getElementById('contentiframe').src='./ResourceIntegration/sell_machine.php';
				else if(dnum==7)
					checkm_rd();
				else if(dnum==8)
					document.getElementById('contentiframe').src='./ValueWork/process.php';
				else if(dnum==9)
					document.getElementById('contentiframe').src='./ValueWork/product_plan.html';//!!!
				else if(dnum==10)
					document.getElementById('contentiframe').src='./GroupLearning/hire_fire.php';
				else if(dnum==11)
					document.getElementById('contentiframe').src='./GroupLearning/employee_training.php';
				else if(dnum==12)
					document.getElementById('contentiframe').src='./GroupLearning/efficiency_evaluate.html'; 
				else if(dnum==13)
					document.getElementById('contentiframe').src='./MarketFocus/advertisement.php';
				else if(dnum==14)
					document.getElementById('contentiframe').src='./MarketFocus/taiwan_order.php';
				else if(dnum==15)
					/*document.getElementById('contentiframe').src='./';*/
                    alert("功能建置中");
				
				else if(dnum==16){
					if(order==1)
						document.getElementById('contentiframe').src='./MarketFocus/market_occupy.html';
					else
						document.getElementById('contentiframe').src='./MarketFocus/market_trend.html';
				}
                else if(dnum==17)
					document.getElementById('contentiframe').src='./ValueProposition/order_result.html';
				else if(dnum==18)
					document.getElementById('contentiframe').src='./ValueProposition/customer_satisfaction.php';
				
				else if(dnum==19){
                    if(order==1)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=1';
					else if(order==2)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=2';
					else if(order==3)
						document.getElementById('contentiframe').src='./ValueRelationship/customer_relationship.php';
					else if(order==4)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=4';
					else if(order==5)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=5';
				}
                else if(dnum==20)
					alert("功能建置中");
						
				//end 判斷dnum
															
			document.getElementById('contentiframe').width='100%';		
			}//end isvalid
			else{
				alert("您沒有此決策的權限!");
				//document.location.href="./main.php";
			}//end notvalid
		}//end function check authority
		
		//有研發才可購買原料
		function checkm_rd(){
			 $.ajax({
                    url: './check_decision.php',
					type:'GET',
					async:false,
					data: {type:'rd'},
					error:
					function(xhr) {alert('Ajax request 發生錯誤');},
					success:
						function(str){
							//alert(str);		
							//if(A或B都沒有研發過)

							var s=str.split("|");
							if(str === 'undone')
								alert('請先至研發處研發產品!');
							else if(str === 'notyet')
								alert('研發一產品為期一個月，請等候產品研發完成!');
							else	
								document.getElementById('contentiframe').src='./ResourceIntegration/purchase_material.php';	
						}	
			 });
		}
		
		

		
		//有聘僱研發人員才可研發
		function checkrd_emp(){
			 $.ajax({
                    url: './check_decision.php',
					type:'GET',
					async:false,
					data: {type:'e_rd'},
					error:
					function(xhr) {alert('Ajax request 發生錯誤');},
					success:
						function(str){
							//alert(str);		
							//if(沒有聘僱研發人員)
							if(str === 'NO')
								alert('請先聘僱研發人員!');
							else
								document.getElementById('contentiframe').src='./ResourceIntegration/research_and_develop.php';	
						}	
			 });
		}
		/*
		function money(){
			$.ajax({				
				url: './money.php',
                type:'GET',
				async:false,
				data: {type:'cash'},
				success:
					function(str){
						document.getElementById("money").innerHTML = parseInt(str);
					}
			});
		}
		*/
		 function logout(){
			 document.location.href="./logout.php";
			 }	
		 	function transfer(url){
                frames[1].location.href=url;
            }
           //驗證
		   function pre_report(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: './check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有報表!")//(′．ω．‵)
										else {
											document.getElementById('contentiframe').width="100%";
											document.getElementById('contentiframe').src='./LeftFeatures/each_report2.php';
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
				});
                
            }

            function dupont(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: 'check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有資料可以分析!");
										else{ 
											document.getElementById('contentiframe').width="100%";
											document.getElementById('contentiframe').src='./LeftFeatures/dupont.php'
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function rank(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: 'check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有資料可以分析!");
										else{ 
											document.getElementById('contentiframe').width="100%"; 
											document.getElementById('contentiframe').src='./LeftFeatures/rank2.php';
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
				   });
            }
            function home(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
				                frames[0].location.href="anime.html";
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function decision(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
				                document.getElementById('contentiframe').src='./LeftFeatures/decision.php';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
								
							}
						}
					});
            }
            function information(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                   	   success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
								document.getElementById('contentiframe').src='./LeftFeatures/Company_info/companyinfo2.php';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function journal(){
					jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
 				                document.getElementById('contentiframe').src='./LeftFeatures/journal.html';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});				
            }//end func(journal)
			
      
      
        function autoCloseNav(){
            document.getElementById("togglebutton").click();
        }
	</script>
    
      
      
      
      
      
      
      
      
      
</body>