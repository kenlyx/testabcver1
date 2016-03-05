<?php
    session_start();
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$company=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	if(($_GET['option'])=="updateA"){
        $result=mysql_query("SELECT * FROM ad_a order by `year` ,`month` DESC");
		mysql_query("UPDATE ad_a SET `decision1`={$_GET['decision1']},`decision2`={$_GET['decision2']},`decision3`={$_GET['decision3']} WHERE `year`=$year AND `month`=$month AND `cid`='$company'");
		echo "updateA";
	}
	else if(($_GET['option'])=="updateB"){
        $result=mysql_query("SELECT * FROM ad_b order by `year` ,`month` DESC");
		mysql_query("UPDATE ad_b SET `decision1`={$_GET['decision1']},`decision2`={$_GET['decision2']},`decision3`={$_GET['decision3']} WHERE `year`=$year AND `month`=$month AND `cid`='$company'");
		echo "updateB";
	}
    else if(($_GET['option'])=="getA"){
		$result=mysql_query("SELECT * FROM ad_a WHERE `year`=$year AND `month`=$month AND `cid`='$company'");
		$temp=mysql_fetch_array($result);
		$reply=$temp['decision1'].":".$temp['decision2'].":".$temp['decision3'];
		echo "".$reply;
	}
	else if(($_GET['option'])=="getB"){
		$result=mysql_query("SELECT * FROM ad_b WHERE `year`=$year AND `month`=$month AND `cid`='$company'");
		$temp=mysql_fetch_array($result);
		$reply=$temp['decision1'].":".$temp['decision2'].":".$temp['decision3'];
		echo "".$reply;
	}
?>
