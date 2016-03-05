<?php
    include("./connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
    $temp=mysql_query("SELECT * FROM `customer_state`") or die(mysql_error());
    while($arr=mysql_fetch_array($temp)){
        $index=$arr['index'];
        if($arr['b_or_c']==1){
            if($arr['initial']>=15)
                mysql_query("UPDATE `customer_state` SET `initial` = 0 WHERE `index` = '$index'") or die(mysql_error());
            else{
                $num=$arr['initial']+rand(0,$arr['step']);
                mysql_query("UPDATE `customer_state` SET `initial` = '$num' WHERE `index` = '$index'") or die(mysql_error());
            }
        }
        else{
            if($arr['initial']>=25)
                mysql_query("UPDATE `customer_state` SET `initial` = 0 WHERE `index` = '$index'") or die(mysql_error());
            else{
                $num=$arr['initial']+rand(0,$arr['step']);
                mysql_query("UPDATE `customer_state` SET `initial` = '$num' WHERE `index` = '$index'") or die(mysql_error());
            }
        }
    }
?>
