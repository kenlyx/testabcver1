<!DOCTYPE html>
<html>
<head>
<title>ceo 賽前設定</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen"/>
 <script>
function changePage(strPage)
{
	parent.main.location.href = strPage; /*This line is the one that changes the baseFrame frame URL.  strPage can be substituded with a hardcoded string.*/
};
function check(){
	
	}
 </script>

    
<style type="text/css">
    .title{	
}
    body {
   background-color:#46A3FF;
	
}
    .content{
}
		
.picbar{
	background-image:url(../images/mid_titlebar.png);
	background-color:#46A3FF;
	height: 100px;
	width:1500px;
	}
.menubar{
		float:right -30px;		
		margin-top:-86px;
}	
   
	
}
</style>
    
</head>
    <body>
    <div class="content">   
    <div class="picbar"></div>
    <div class="menubar" align="right">
    	<ul id="topmenu">
   			 <li><a href="javascript:void(0);" onClick="changePage('./homepage.php')">進入競賽</a></li>
             <li><a href="javascript:void(0);" onClick="changePage('./try.php')">年度決策分配</a></li>
             <li><a href="javascript:void(0);" onClick="changePage('./KPI_ceo.php')">年度KPI預設</a></li>
        </ul>

    </div> 
   </div>
</body> 
</html>