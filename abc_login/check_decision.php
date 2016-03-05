<?php
    session_start();

    include("../connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

    if(!strcmp($_GET['type'],"1")){
        $_SESSION['user']=$_GET['user'];
        $_SESSION['decision']=$_GET['decision'];
        unset($_SESSION['company']);
       
	    @mysql_select_db("testabc_main");
		mysql_query("SET NAMES 'utf8'");
        $temp=mysql_query("SELECT MAX(`year`) FROM `state`");
        $result_temp=mysql_fetch_array($temp);
        $_SESSION['year']=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`={$_SESSION['year']};");
        $result_temp=mysql_fetch_array($temp);
        $_SESSION['month']=$result_temp[0];
        echo $_SESSION['year']."/".$_SESSION['month'];
    }
    else if(!strcmp($_GET['type'],"2")){
        $name2=$_SESSION['user'];
        $args=split(',',$_SESSION['decision']);
        $name=$_GET['decision_name'];
        $success="no";
        if($name=="關係管理"){
            foreach($args as $num){
                if($num=='13'||$num=='14'||$num=='15'||$num=='16'){
                    $success="yes";
                    break;
                }
            }
        }
        else{
            $result_2 = @mysql_query("SELECT DecisionNo FROM info_decision WHERE DecisionName = '$name'");
            $decision_num=mysql_fetch_array($result_2);
            foreach($args as $num){
                if($num==$decision_num[0]){
                    $success="yes";
                    break;
                }
            }
        }
        echo $success;
		//*
        if($name=="資產處分")
		{
			$com_temp=$_SESSION['company'];
			$result_21 = @mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `abc_main`.`product_a` WHERE `cid` = '$com_temp'");
            $ma_num=mysql_fetch_array($result_21);
			$result_22 = @mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `abc_main`.`product_b` WHERE `cid` = '$com_temp'");
            $mb_num=mysql_fetch_array($result_22);
			$used=$ma_num[0]+$ma_num[1]+$ma_num[2]+$mb_num[0]+$mb_num[1];
			echo ",".$used;
		}//*/
    }
    else if(!strcmp($_GET['type'],"3")){
        $name=$_SESSION['user'];
        $args=split(',',$_SESSION['decision']);
        $str="";
        foreach($args as $num){
            if($num=='11'||$num=='12'||$num=='13'||$num=='14')
                    $str.=$num.",";
        }

        echo $str;
    }
    else if(!strcmp($_GET['type'],"4")){
        if(!strcmp($_GET['key'],"company")){
            if(!isset($_SESSION['company'])){
                $name=$_SESSION['user'];
				@mysql_select_db("testabc_login");
				
                $result = @mysql_query("SELECT CompanyID FROM account WHERE Account = '$name'");
                $company=mysql_fetch_array($result);
                $_SESSION['company']=$company[0];
                echo $company[0];
            }
            else
                echo $_SESSION['company'];
        }
        else if(!strcmp($_GET['key'],"account"))
            echo $_SESSION['user'];
        else if(!strcmp($_GET['key'],"month")){

            echo $_SESSION['year']."|".$_SESSION['month'];
        }
        else if(!strcmp($_GET['key'],"duty")){
            $names="";
            $row=0;
            $args=split(',',$_SESSION['decision']);
            foreach($args as $num){
                $result = @mysql_query("SELECT DecisionName FROM info_decision WHERE DecisionNo = '$num'");
                $name=mysql_fetch_array($result);
                $names.=$name[0];
                $row++;
                if($row%3==0)
                    $names.="<br/>";
                else
                    $names.=",  ";
            }
            echo $names;
        }
    }
    else if(!strcmp($_GET['type'],"5")){
        $str="?user=".$_SESSION['user']."&decision=".$_SESSION['decision'];
        echo $str;
    }
?>
