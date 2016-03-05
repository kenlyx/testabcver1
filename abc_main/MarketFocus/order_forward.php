<?php
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $temp=mysql_query("SELECT * FROM `customer_state`",$connect) or die(mysql_error());
    while($arr=mysql_fetch_array($temp)){
        $index=$arr['index'];
        if($arr['b_or_c']==1){
            if($arr['initial']>=15)
                mysql_query("UPDATE `customer_state` SET `initial` = 0 WHERE `index` = '$index'",$connect) or die(mysql_error());
            else{
                $num=$arr['initial']+rand(0,$arr['step']);
                mysql_query("UPDATE `customer_state` SET `initial` = '$num' WHERE `index` = '$index'",$connect) or die(mysql_error());
            }
        }
        else{
            if($arr['initial']>=25)
                mysql_query("UPDATE `customer_state` SET `initial` = 0 WHERE `index` = '$index'",$connect) or die(mysql_error());
            else{
                $num=$arr['initial']+rand(0,$arr['step']);
                mysql_query("UPDATE `customer_state` SET `initial` = '$num' WHERE `index` = '$index'",$connect) or die(mysql_error());
            }
        }
    }
?>
