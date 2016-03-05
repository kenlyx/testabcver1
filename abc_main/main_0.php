<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="css/all-examples.css">
<title>ABC Decision</title>
<?php
include("./connMysql.php");
	//$cid='C03';
	$cid=$_SESSION['cid'];
	//$acc='984003008';
	
	$acc=$_SESSION['user'];
	if($acc=="")
		echo "<script language=\"JavaScript\"> alert('登入已過期，請從新登入!'); location.href=('../abc_login/player_login.php')</script>";
		mysql_select_db("testabc_main");
	$sql_year = "SELECT MAX(`year`) FROM `state`";
		$result = mysql_query($sql_year) or die("Query failed@year");	
		$rowy=mysql_fetch_array($result);
		$year=$rowy[0];
		$sql_month = "SELECT MAX(`month`) FROM `state` WHERE `year`=$rowy[0];";
		$result = mysql_query($sql_month) or die("Query failed@month");	
		$rowm=mysql_fetch_array($result);
		$month=$rowm[0];
	$_SESSION['year']=$year;
	$_SESSION['month']=$month;
	
	mysql_select_db("testabc_login");
	
	$sql_gettime = mysql_query("SELECT * FROM `time` WHERE `id`='".(12*($year-1)+$month)."'");
	$gettime = mysql_fetch_array($sql_gettime);
	$endtime=$gettime['endtime'];
	//echo $endtime;
	
	$sql_gamestate = mysql_query("SELECT * FROM `timer` WHERE `id`=1");
	$gamestate = mysql_fetch_array($sql_gamestate);
	$gameyear=$gamestate['gameyear'];
	$gamestatus=$gamestate['status'];
	//echo $gamestatus;
?>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type=text/javascript>
$(function(){
	clock();
	$('#webmenu li').hover(function(){
		$(this).children('ul').stop(true,true).show('slow');
	},function(){
		$(this).children('ul').stop(true,true).hide('slow');
	});
	
	$('#webmenu li').hover(function(){
		$(this).children('div').stop(true,true).show('slow');
	},function(){
		$(this).children('div').stop(true,true).hide('slow');
	});
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
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/fisheye-iutil.min.js"></script>
	<script type="text/javascript" src="js/dock-example1.js"></script>
	<script type="text/javascript" src="js/jquery.jqDock.min.js"></script>
	<script type="text/javascript">
	  
		$(function(){
			var jqDockOpts = {align: 'left', duration: 200, labels: 'tc', size: 50, distance: 90};
			$('#jqDock').jqDock(jqDockOpts);
		});
		function clock(){
			if('<?php echo $gamestatus; ?>' == '競賽暫停')
				document.getElementById("lefttime").innerHTML = "競賽暫停";
			else if("<?php echo $gamestatus; ?>" == '競賽結束')
				document.getElementById("lefttime").innerHTML = "競賽結束";
			else if("<?php echo $gamestatus; ?>" == '競賽未啟動')
				document.getElementById("lefttime").innerHTML = "競賽未啟動";
			else{
				var roundEndTime=<?php echo $endtime; ?>;
				//此回合剩餘秒數
				var TimeLeft=(roundEndTime*1000-(new Date().getTime()))/1000;
				if(TimeLeft<0)
					history.go(0);
//                  location.href="./main.php";					
				document.getElementById("lefttime").innerHTML = Math.floor((TimeLeft/3600)) + ' 時'+' '+ Math.floor((TimeLeft%3600)/60)+' 分'+' '+Math.floor(TimeLeft%60)+' 秒';
				setTimeout("clock()",1000);
			}
		}
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
							//if(A或B都沒有研發過)
							if(str === 'NO')
								alert('請先至研發處研發產品!');
							else{ 
								document.getElementById('contentiframe').width="100%";
								document.getElementById('contentiframe').src='./ResourceIntegration/purchase_material.php';
							}
						}	
				
					});
		}
		
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
			
	</script>

</head>
<body>
  <table width=100% height="12%">
      <td width="1%"></td> 
      <td width="2%" title="back"><a href="javascript:history.back()"><img src="images/1-navigation-back.png" width="32" height="34" /></a></td>
      <td width="2%" title="forward"><a href="javascript:history.forward()"><img src="images/1-navigation-forward.png" width="32" height="34" /></a></td>
      <td width="2%" title="main"><a href="main.php"><img src="images/12-hardware-dock.png" width="32" height="34" /></a></td>
      <td width="2%"></td>
      <td width="13%"> 公司名稱： <strong><font color=#ff6><?php echo $cid;?></font></strong></td>
      <td width="16%"> 帳號：<strong><font color=#ff6><?php echo $acc;?> </font></strong></td>
      <td width="40%"></td>
      <td width="12%">倒數： <strong><font color=#ff6><span id="lefttime"></span></font></strong></td>
      <td width="9%" align="right" title="logout"><img src="images/logout.png" width="32" height="32" onclick="logout()"/></td>
      <td width="1%"></td>

  </table>
<div id="header2">
  <ul id="webmenu" class="first-menu">
 <li><a style="color:#ff6; background:none; border:none; font-size:13px;" target="_self"><strong><?php echo "第 ".$year." 年 &nbsp;&nbsp;".$month."月";?></strong></a></li>
 <li><a target="_self">公司治理</a></li>
   <li><a href="#" target="_self">獲利模式</a>
    <ul style="display: none;" id="subMusic" class="second-menu">
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ProfitModel/selling_cost_analyzing.php'; 
      							document.getElementById('contentiframe').width='100%';">銷貨成本分析</a></li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ProfitModel/revenue_model.php';
      							document.getElementById('contentiframe').width='100%';">營收來源</a> </li>
    </ul>
  </li>
   <li><a href="#" class="arrow" target="_self">資源整合</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ResourceIntegration/fund_raising.php';
    							 document.getElementById('contentiframe').width='100%';" >資金募集</a></li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ResourceIntegration/research_and_develop.php';
      							document.getElementById('contentiframe').width='100%';">研究 / 開發</a>
      </li>
      <li><a href="#" class="arrow" target="_self">資產購置 / 處分</a>
        <ul class="third-menu">
          <li><a href="#" onclick="document.getElementById('contentiframe').src='./ResourceIntegration/purchase_machine.php';
          							document.getElementById('contentiframe').width='100%';">購買資產</a>
          </li>
          <li><a href="#" onclick="document.getElementById('contentiframe').src='./ResourceIntegration/sell_machine2.php';
          							document.getElementById('contentiframe').width='100%';">處分資產</a>
          </li>
        </ul>
      </li>
      <li><a href="#" onclick="checkm_rd()">購買 / 分配原料</a>
      </li>
    </ul>
  </li> 
  <li><a href="#" class="arrow" target="_self">價值作業</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
	<li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueWork/process.php';
      							document.getElementById('contentiframe').width='100%';">流程改良</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueWork/production.php';
      							document.getElementById('contentiframe').width='100%';">生產規劃</a>
      </li>
      
     
    </ul>
  </li> <li><a href="#" class="arrow" target="_self">團隊學習</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./GroupLearning/hire_fire.html';
      							document.getElementById('contentiframe').width='100%';">招 / 解聘員工</a>
      </li>
      <li> <a href="#" onclick="document.getElementById('contentiframe').src='./GroupLearning/employee_training.php';
      							document.getElementById('contentiframe').width='100%';">在職訓練</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./GroupLearning/efficiency_evaluate.html';
      							document.getElementById('contentiframe').width='100%';">人員效率評估</a> 
      </li> 
    </ul>
  </li>
  <li><a href="#" class="arrow" target="_self">市場聚焦</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
      <li><a href="#"  onclick="document.getElementById('contentiframe').src='./MarketFocus/advertisement.php';
      							document.getElementById('contentiframe').width='100%';">廣告促銷</a></li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./MarketFocus/taiwan_order.php';
      							document.getElementById('contentiframe').width='100%';">接單</a></li>
 	  <li><a href="#" class="arrow" target="_self">市場狀態</a>
        <ul class="third-menu">
          <li><a href="#" onclick="document.getElementById('contentiframe').src='./MarketFocus/market_share.html';
          							document.getElementById('contentiframe').width='100%';">市場占有率</a></li>
          <li><a href="#" onclick="document.getElementById('contentiframe').src='./MarketFocus/market_share_history.html';
          							document.getElementById('contentiframe').width='100%';">市場需求變化</a></li>
        </ul>
	 </li>
    </ul>
  </li>
    <li><a href="#" target="_self">價值主張</a>
    <ul id="subNews" class="second-menu">
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueProposition/order_result.html';
      							document.getElementById('contentiframe').width='100%';">顧客訂單量</a>
      </li>
      <li> 
      <a onclick="document.getElementById('contentiframe').src='./ValueProposition/customer_satisfaction.php';
      				document.getElementById('contentiframe').width='100%';">顧客滿意度</a>
      </li>
     </ul>
  </li>
  <li><a href="#" class="arrow" target="_self">價值關係</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
     
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/donate_share.php';
      							document.getElementById('contentiframe').width='100%';">企業社會責任</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=1';
      							document.getElementById('contentiframe').width='100%';">投資人</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=2';
      							document.getElementById('contentiframe').width='100%';">員工</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=3';
      							document.getElementById('contentiframe').width='100%';">顧客</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=4';
      							document.getElementById('contentiframe').width='100%';">供應商</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=5';
      							document.getElementById('contentiframe').width='100%';">通路商</a>
      </li>
    </ul>
  </li>
</ul>
</div>
<div>
<?php
include ("test.php");

?>

</div>
<!-- BEGIN DOCK 2 ============================================================ 
onclick="document.getElementById('contentiframe').src='./LeftFeatures/Company_info/companyinfo.php'"
-->
	<div id="dockContainer">
		<ul id="jqDock">
            <p><p><p>  
			<li class="content"></li>
			<li class="content"></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/5-content-paste.png" alt="Home" align="absmiddle" title="公&nbsp;司&nbsp;資&nbsp;訊" onclick="information()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/5-content-copy.png" alt="Contact" align="absmiddle" title="報&nbsp;表" onclick="pre_report()"/></a></li>
            <li class="content"><a href="#" class="dockItem"><img src="images/4-checklist.png" alt="Contact" align="absmiddle" title="決&nbsp;策&nbsp;總&nbsp;覽"  onclick="decision()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/4-collections-view-as-list.png" alt="portfolio" align="absmiddle" title="企&nbsp;業&nbsp;價&nbsp;值&nbsp;分&nbsp;析" onclick="dupont()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/4-collections-go-to-today.png" alt="music" align="absmiddle" title="日&nbsp;記&nbsp;帳" onclick="journal()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/6-social-cc-bcc.png" alt="video" align="absmiddle" title="競&nbsp;賽&nbsp;排&nbsp;名" onclick="rank()"/></a></li>
			
		</ul>
</div><!-- end div #dockContainer -->
	<!-- END DOCK 2 ============================================================ -->
    
<div id="content" style="z-index:10;">
    <iframe id="contentiframe" width="95%" height="91%" marginwidth="8" marginheight="0" frameborder="0" scrolling="auto" style="
    margin:0;
    padding:0;
    border:0 solid;" >
	</iframe>

    
</div>
</body>
</html>
