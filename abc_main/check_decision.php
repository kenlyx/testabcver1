<?php
    session_start();

    include("./connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
	
	@mysql_select_db("testabc_main");
	$sql_year=mysql_query("SELECT MAX(`year`) FROM state");
	$year=mysql_fetch_array($sql_year);
	$year=$year[0];
	$sql_month=mysql_query("SELECT MAX(`month`) FROM state WHERE `year`=$year");
	$month=mysql_fetch_array($sql_month);
	$month=$month[0];
	$thisround=($year-1)*12+$month;
	$cid=$_SESSION['cid'];
    if(!strcmp($_GET['type'],"1")){
        $_SESSION['user']=$_GET['user'];
        $_SESSION['decision']=$_GET['decision'];
        unset($_SESSION['cid']);
       
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
			$com_temp=$_SESSION['cid'];
			$result_21 = @mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `testabc_main`.`product_a` WHERE `cid` = '$com_temp'");
            $ma_num=mysql_fetch_array($result_21);
			$result_22 = @mysql_query("SELECT SUM(`mb_supplier_a`),SUM(`mb_supplier_b`),SUM(`mb_supplier_c`) FROM `testabc_main`.`product_b` WHERE `cid` = '$com_temp'");
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
            if(!isset($_SESSION['cid'])){
                $name=$_SESSION['user'];
				@mysql_select_db("testabc_login");
				
                $result = @mysql_query("SELECT CompanyID FROM account WHERE Account = '$name'");
                $company=mysql_fetch_array($result);
                $_SESSION['cid']=$company[0];
                echo $company[0];
            }
            else
                echo $_SESSION['cid'];
        }
        else if(!strcmp($_GET['key'],"account"))
            echo $_SESSION['user'];
        //左排列的檢驗結果
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
	//檢查研發
	else if(!strcmp($_GET['type'],"rd")){
        mysql_select_db("testabc_main");
		//是否研發筆電
		$sql_doneA=mysql_query("SELECT * FROM `state` WHERE `cid`='$cid' AND `product_A_RD`=1");
		$row_dA=mysql_num_rows($sql_doneA);
		$rdA=mysql_fetch_array($sql_doneA);
		//echo($row_dA);
		//是否研發平板
		$sql_doneB=mysql_query("SELECT * FROM `state` WHERE `cid`='$cid' AND `product_B_RD`=1");
		$row_dB=mysql_num_rows($sql_doneB);
		$rdB=mysql_fetch_array($sql_doneB);
		//echo($row_dB);
		$rdA_round=($rdA['year']-1)*12+$rdA['month'];
		$rdB_round=($rdB['year']-1)*12+$rdB['month'];
		
		if($row_dA==0&&$row_dB==0)
			 $success="undone";
		else if($row_dA==0 || $row_dB==0){
			if($rdA_round==$thisround || $rdB_round==$thisround)
			$success="notyet";
		}
		echo $success;	
    } 
	
	//檢查研發人員
	else if(!strcmp($_GET['type'],"e_rd")){
		mysql_select_db("testabc_main");
	
		//檢查研發人員
		//$sql_rdmember=mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `cid` = '".$cid."' AND `department`='research');
		$sql_rdmember=mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `cid` = '".$cid."' AND `department`='research' AND (`year`-1)*12+`month`<$thisround");
		$rdmember=mysql_fetch_array($sql_rdmember) or die(mysql_error());
		//echo $cid."|".$year."|".$month."|".$rdmember[0]."|".$rdmember[1]."|".$rdcount;
		$rdcount=$rdmember[0]-$rdmember[1]; //目前rd部門人數
		$success=var_dump($rdcount);
			if($rdcount<=0){
				 $success="NO";
			}
			echo $success;
		
    }  
?>
