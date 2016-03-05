<?php
    session_start();
    $month1=$_SESSION['month'];
    $year1=$_SESSION['year'];
    $month1-=1;
    if($month1==0){
        $month1=12;
        $year1-=1;
    }
    $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main",$connect);
    mysql_query("set names 'utf8'");
    $C_name=mysql_query("SELECT distinct(`cid`) FROM `state` WHERE `month`=$month1 AND `year`=$year1",$connect);

    if(($_GET['type'])=="company_num"){
        $total_com=0;
        while($company_name=mysql_fetch_array($C_name)){
            $total_com+=1;
        }
        echo $total_com;
    }
    else if(($_GET['type'])=="time"){
        echo $year1."|".$month1;
    }
    else if(($_GET['type'])=="company_data"){
        while($company_name=mysql_fetch_array($C_name)){
            $product_A=0;
            $product_B=0;
            $result=mysql_query("SELECT * FROM `order_accept` WHERE `month`=$month1 AND `year`=$year1 AND `cid`='$company_name[0]' AND `accept` = 1",$connect);
            while($temp=mysql_fetch_array($result)){
                if($temp!=NULL){
                    $sub=explode("_",$temp['order_no']);
                    if($sub[1]=="A")
                        $product_A+=$temp['quantity'];
                    else
                        $product_B+=$temp['quantity'];
                }else
                    break;
            }
            echo $company_name[0].",".$product_A.",".$product_B.";";
        }
    }
?>
