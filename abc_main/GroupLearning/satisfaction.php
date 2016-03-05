<?php
function satisfaction(){
    include("../connMysql.php");
    if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
    $C_name=mysql_query("SELECT DISTINCT(`cid`) FROM account");
    mysql_select_db("testabc_main");

    $temp=mysql_query("SELECT MAX(`year`) FROM `state`");
    $result=mysql_fetch_array($temp);
    $year=$result[0];
    $n_year=$result[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year");
    $result=mysql_fetch_array($temp);
    $month=$result[0]-1;
    $n_month=$result[0];
    if($month==0){
        $month=12;
        $year-=1;
    }
    while($company=mysql_fetch_array($C_name)){//每間公司
        $cid=$company['cid'];
        echo $cid;
        $relationship_decision=mysql_query("SELECT * FROM `relationship_decision` WHERE `cid` = '$cid' AND `year` = $year AND `month` = $month");
        while($decision=mysql_fetch_array($relationship_decision)){
            $step_s=1;
            $type=split("_",$decision['target']);
            if($type[0]=="supplier"){
                //$result=mysql_query("");//取得上期的淨利
                //$netIn_temp=mysql_fetch_array($result);
                $netIn_temp[0]=500000;//尚未詢問此值於報表何處，暫時寫死，得出結果後更改上述SQL語法即可。
                if($type[1]==0){
                    $result=mysql_query("SELECT `satisfaction_a` FROM `supplier_satisfaction` WHERE `cid`='$cid'");
                    $satisfaction=mysql_fetch_array($result);
                }
                else if($type[1]==1){
                    $result=mysql_query("SELECT `satisfaction_b` FROM `supplier_satisfaction` WHERE `cid`='$cid'");
                    $satisfaction=mysql_fetch_array($result);
                }
                else if($type[1]==2){
                    $result=mysql_query("SELECT `satisfaction_c` FROM `supplier_satisfaction` WHERE `cid`='$cid'");
                    $satisfaction=mysql_fetch_array($result);
                }
                if($satisfaction[0]>=100){
                    $step_s=0;
                }
                else if($satisfaction[0]>=90){
                    $step_s=0.5;
                }
                else if($satisfaction[0]>=80){
                    $step_s=0.8;
                }
                $satisfaction[0]+=$step_s*($decision['level']*$netIn_temp[0]/50000);
                if($type[1]==0) mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_a` = $satisfaction[0] WHERE `cid`='$cid'");
                else if($type[1]==1) mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_b` = $satisfaction[0] WHERE `cid`='$cid'");
                else if($type[1]==2) mysql_query("UPDATE `supplier_satisfaction` SET `satisfaction_c` = $satisfaction[0] WHERE `cid`='$cid'");
            }
            else if($type[0]=="customer"){
                $result=mysql_query("SELECT `name` FROM `customer_state` WHERE `index`=$type[1]");
                $customer_name=mysql_fetch_array($result);
                $result=mysql_query("SELECT `satisfaction` FROM `customer_satisfaction` WHERE `cid`='$cid' AND `customer`='$customer_name[0]'");
                $satisfaction=mysql_fetch_array($result);
                if($satisfaction[0]>=100){
                    $step_s=0;
                }
                else if($satisfaction[0]>=90){
                    $step_s=0.5;
                }
                else if($satisfaction[0]>=80){
                    $step_s=0.8;
                }
                $satisfaction[0]+=$step_s*$decision['level'];
                mysql_query("UPDATE `customer_satisfaction` SET `satisfaction` = $satisfaction[0] WHERE `cid`='$cid' AND `customer`='$customer_name[0]'");
            }
            else if($type[0]=="empolyee"){
                $result=mysql_query("SELECT `satisfaction` FROM `current_people` WHERE `cid`='$cid' AND `department`='$type[1]' AND `year` = $n_year AND `month` = $n_month");
                $satisfaction=mysql_fetch_array($result);
                if($satisfaction[0]>=100){
                    $step_s=0;
                }
                else if($satisfaction[0]>=90){
                    $step_s=0.5;
                }
                else if($satisfaction[0]>=80){
                    $step_s=0.8;
                }
                $satisfaction[0]+=$step_s*$decision['level']*0.01;
                mysql_query("UPDATE `current_people` SET `satisfaction` = $satisfaction[0] WHERE `cid`='$cid' AND `department`='$type[1]'");
            }
            else if($type[0]=="investor"){
                $satisfaction=$decision['level'];
                $result=mysql_query("UPDATE `investor_satisfaction` SET `satisfaction` = $satisfaction WHERE `cid`='$cid'");
            }
        }
    }
}
satisfaction();
?>
