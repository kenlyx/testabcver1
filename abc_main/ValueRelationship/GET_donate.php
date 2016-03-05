<?php
    session_start();
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	if(($_GET['option'])=="update"){
        $result=mysql_query("SELECT * FROM donate order by `year` ,`month` DESC");
		mysql_query("UPDATE donate SET `decision1`={$_GET['decision1']},`decision2`={$_GET['decision2']},`decision3`={$_GET['decision3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		echo "update";
	}
    elseif(($_GET['option'])=="get"){
		$result=mysql_query("SELECT * FROM donate WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp=mysql_fetch_array($result);
		$reply=$temp['decision1'].":".$temp['decision2'].":".$temp['decision3'];
		echo "".$reply;
	}
?>
