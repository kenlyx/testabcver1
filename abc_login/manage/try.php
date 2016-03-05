<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title>表格</title>
<link rel="stylesheet" type="text/css" href="./import.css" media="all" />
<script type="text/javascript" charset="utf-8" src="./jquery-1.3.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="./jquery_ticker.js"></script>
<script type="text/javascript">
function enter(){
	    //alert 123;
		<?php
		include("../connMysql.php");
		if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
		
		$sql_gname =mysql_query("SELECT GameName FROM `game`");
		$row = mysql_fetch_array($sql_gname);
		$gameName=$row[0];
			
		if($gameName=='0')
		{
			?>
			alert("尚未建立競賽!");
			<?php	
		}
		?>
		var gameNam=<?php echo $gameName; ?>;
		
		
		$.post("../control/changephp.php",{
			gameNamm:gameNam
			 },function(xml){
				  alert(gameNam);
				  window.open("timeset.php");
			   });
     	
		
     }
</script>
</head>

<body class="noscript">

<p style="height:4px;">
<div id="header">
<h1 style="color:#FFF;">管理會計 大學班</h1>
<!-- #header --></div>
<p style="height:4px; width:100%">

<div id="container" style="background-image: url(bg.png);">

<div id="navi" style="background-color:#FFF">
<ul>
<li class="onCounter">基本資訊</li><!--帳號管理-->
<li class="offCounter">
<a onClick="document.getElementById('contentiframe1').src='./cg_s2.php'">上傳學生名單</a>
</li>
<li class="offCounter">競賽重設</li>
<li class="offCounter">
<a onClick="document.getElementById('contentiframe2').src='../control/enterControl.php'">開啟主控台</a>
</li>
<li class="offCounter">系統參數管理</li>


</ul>
<!-- #navi --></div>

<div id="ticker" style="background-color:#ebebeb;">
<ul>
<li style="display: list-item;">
<div>
<h2>基本資訊</h2>
<dl>
</dl>
</div>
</li>
<li style="display: none;">
<div>
<h2>上傳學生名單</h2>
<p><iframe width='100%' height='95%' id="contentiframe1" marginheight='1' align='center' frameborder='0'></iframe></p>
<dl> 
</dl>
</div>
</li>
<li style="display: none;">
<div>
<h2>競賽重設</h2>
<dl>

</dl>
</div>
</li>
<li style="display: none;">
<div>
<h2>開啟主控台</h2>
<p><iframe width='100%' height='95%' id="contentiframe2" marginheight='1' align='center' frameborder='0'></iframe></p>

<dl>
</dl>
</div>
</li>
<li style="display: none;">
<div>
<h2>系統參數管理</h2>
<dl>

</dl>
</div>
</li>

<li style="display: none;">
<div>
<h2>建立競賽</h2>
<dl>

</dl>
</div>
</li>

<li style="display: none;">
<div>
<h2>建立競賽</h2>
<dl>

</dl>
</div>
</li>
<li style="display: none;">
<div>
<h2>建立競賽</h2>
<dl>

</dl>
</div>
</li>

</ul>
<!-- #ticker --></div>

<!-- #container --></div>

</body>
</html>
