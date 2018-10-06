<?php
    session_start();
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
	{
	error_reporting(0);
	
	/*cid="C01";
	$month=5;
	$year=1;*/
    $cid=$_SESSION['cid'];
    $month=$_SESSION['month'];
    //$month=1;
	$year=$_SESSION['year'];
    $month_temp=$month+($year-1)*12;
	//若得到的type為purchase
	if(!strcmp($_GET['type'], "purchase")){
		
		//echo $_GET['type'];
        //找出下一筆machine資料的index為何
		$result=mysql_query("SELECT MAX(`index`) FROM `machine`;");
        $row=mysql_fetch_array($result);
        $next_index=$row[0]+1;
		//若得到的func為cut
        if ($_GET['p_cutA']||$_GET['p_cutB']||$_GET['p_cutC']) {
			//將當回合已insert過的資料刪除
            mysql_query("DELETE FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`=$month AND `function`='cut';");
            
			//insert當回合的決策
			for($i=0;$i<$_GET['p_cutA'];$i++){
				//買了幾個cutA就insert幾筆，以此類推
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'cut','A');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_cutB'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'cut','B');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_cutC'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'cut','C');");
                $next_index+=1;
            }
        }
		//若得到的func為combine1
        if ($_GET['p_com1A']||$_GET['p_com1B']||$_GET['p_com1C']) {
            mysql_query("DELETE FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`=$month AND `function`='combine1';");
            for($i=0;$i<$_GET['p_com1A'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine1','A');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_com1B'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine1','B');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_com1C'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine1','C');");
                $next_index+=1;
            }
        }
		//若得到的func為combine2
        if ($_GET['p_com2A']||$_GET['p_com2B']||$_GET['p_com2C']) {
            mysql_query("DELETE FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`=$month AND `function`='combine2';");
            for($i=0;$i<$_GET['p_com2A'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine2','A');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_com2B'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine2','B');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_com2C'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'combine2','C');");
                $next_index+=1;
            }
        }
       /* else if (!strcmp($_GET['func'], "package")) {
            mysql_query("DELETE FROM `machine` WHERE `cid`='$cid' AND `purchase_month`=$month_temp AND `function`='package';");
            for($i=0;$i<$_GET['p_A'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$month_temp,999,'package','A');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_B'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$month_temp,999,'package','B');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_C'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$month_temp,999,'package','C');");
                $next_index+=1;
            }
        }*/
		
		//若得到的func為detect
        if ($_GET['p_detA']||$_GET['p_detB']) {
            mysql_query("DELETE FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`=$month AND `function`='detect';");
            for($i=0;$i<$_GET['p_detA'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'detect','A');");
                $next_index+=1;
            }
            for($i=0;$i<$_GET['p_detB'];$i++){
                mysql_query("INSERT INTO `machine` VALUES ($next_index,'$cid',$year,$month,99,99,'detect','B');");
                $next_index+=1;
            }
        }
    }//end if(type=purchase)
	else if(mysql_real_escape_string($_POST["sell"])){
		$sell_machine=mysql_real_escape_string($_POST['sell']);
		$count=count($sell_machine);
		//echo $sell_machine[0]."|".$sell_machine[1];
		$i=0;
		while($count!=0){
			$machine=$sell_machine[$i];
			//echo $machine."<br>";
			$details = explode("_", $machine); //存成多個機具描述的陣列(0=>index,1=>func,2=>type,3=>buy_date)
	        //賣!
			//echo $details[0]."|";
		    $sql_sell=mysql_query("UPDATE `machine` SET `sell_year`=$year,`sell_month`=$month WHERE `cid`='$cid' AND `index`=$details[0]");	
			$count--;
			$i++;
			}
	
	}//end post
	
	/*//若得到的type為sell
    else if(!strcmp($_GET['type'], "sell")){
        if (!strcmp($_GET['func'], "cut")) {
            mysql_query("UPDATE `machine` SET `sell_month` = 999 WHERE `cid`='$cid' AND `sell_month` = $month_temp AND `function`='cut';");
            for($i=0;$i<$_GET['s_A'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='cut' AND `type`='A' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_B'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='cut' AND `type`='B' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_C'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='cut' AND `type`='C' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
        }
        else if (!strcmp($_GET['func'], "combine1")) {
            mysql_query("UPDATE `machine` SET `sell_month` = 999 WHERE `cid`='$cid' AND `sell_month` = $month_temp AND `function`='combine1';");
            for($i=0;$i<$_GET['s_A'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine1' AND `type`='A' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_B'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine1' AND `type`='B' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_C'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine1' AND `type`='C' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
        }
        else if (!strcmp($_GET['func'], "combine2")) {
            mysql_query("UPDATE `machine` SET `sell_month` = 999 WHERE `cid`='$cid' AND `sell_month` = $month_temp AND `function`='combine2';");
            for($i=0;$i<$_GET['s_A'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine2' AND `type`='A' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_B'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine2' AND `type`='B' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_C'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='combine2' AND `type`='C' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
        }
        else if (!strcmp($_GET['func'], "package")) {
            mysql_query("UPDATE `machine` SET `sell_month` = 999 WHERE `cid`='$cid' AND `sell_month` = $month_temp AND `function`='package';");
            for($i=0;$i<$_GET['s_A'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='package' AND `type`='A' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_B'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='package' AND `type`='B' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_C'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='package' AND `type`='C' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
        }
        else if (!strcmp($_GET['func'], "detect")) {
            mysql_query("UPDATE `machine` SET `sell_month` = 999 WHERE `cid`='$cid' AND `sell_month` = $month_temp AND `function`='detect';");
            for($i=0;$i<$_GET['s_A'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='detect' AND `type`='A' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
            for($i=0;$i<$_GET['s_B'];$i++){
                $result=mysql_query("SELECT MAX(`index`) FROM `machine` WHERE `cid`='$cid' AND `function`='detect' AND `type`='B' AND `sell_month` = 999 AND `purchase_month` < $month_temp;");
                $row=mysql_fetch_array($result);
                mysql_query("UPDATE `machine` SET `sell_month` = $month_temp WHERE `index` = $row[0]");
            }
        }
    }*/
    else if (!strcmp($_GET['type'], "purchase_show")) {
        if (!strcmp($_GET['func'], "cut")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND (`buy_year`-1)*12+`buy_month`<($year-1)*12+$month AND `sell_month`=99 AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND (`buy_year`-1)*12+`buy_month`=($year-1)*12+$month AND `sell_month`=99 AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "combine1")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`<($year-1)*12+$month AND `sell_month`=99 AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`=($year-1)*12+$month AND `sell_month`=99 AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "combine2")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`<($year-1)*12+$month AND `sell_month`=99 AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`=($year-1)*12+$month AND `sell_month`=99 AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "package")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`<($year-1)*12+$month AND `sell_month`=99 AND `function`='package' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`=($year-1)*12+$month AND `sell_month`=99 AND `function`='package' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
        }
        else if (!strcmp($_GET['func'], "detect")) {
            $array=array('A','B');//A表示合成檢測機器，B表示精密檢測機器
            for($i=0;$i<2;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND (`buy_year`-1)*12+`buy_month`<($year-1)*12+$month AND `sell_month`=99 AND `function`='detect' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<2;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid'  AND (`buy_year`-1)*12+`buy_month`=($year-1)*12+$month AND `sell_month`=99 AND `function`='detect' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|";
        }
    }
    /*else if (!strcmp($_GET['type'], "sell_show")) {
        if (!strcmp($_GET['func'], "cut")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `purchase_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `sell_month`=$month_temp AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_cut'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "combine1")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `purchase_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `sell_month`=$month_temp AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine1'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "combine2")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `purchase_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `sell_month`=$month_temp AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_combine2'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|".$temp[3]."|";
        }
        else if (!strcmp($_GET['func'], "package")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `purchase_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='package' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `sell_month`=$month_temp AND `function`='package' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
        }
        else if (!strcmp($_GET['func'], "detect")) {
            $array=array('A','B');
            for($i=0;$i<2;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `purchase_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='detect' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            for($i=0;$i<2;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `sell_month`=$month_temp AND `function`='detect' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
                echo $row[0]."|";
            }
            $result=mysql_query("SELECT * FROM `correspondence` WHERE `name`= 'machine_detect'");
            $temp=mysql_fetch_array($result);
            echo $temp[1]."|".$temp[2]."|";
        }
    }*/
    else if(!strcmp($_GET['type'], "pp")){
        $machine_A=1;$machine_B=1;
        $machine_array=array("cut","combine1","combine2");
        $type_array=array("A","B","C");
		
        for($i=0;$i<3;$i++){
            $result=mysql_query("SELECT `$machine_array[$i]` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;");
            $temp_type=mysql_fetch_array($result);
            $type=$type_array[$temp_type[0]];
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`<$year AND `sell_month`=99 AND `function`='$machine_array[$i]' AND `type` = '$type'");
            $row=mysql_fetch_array($result);
			$row1 = $row[0];
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='$machine_array[$i]' AND `type` = '$type'");
            $row=mysql_fetch_array($result);
			$row2 = $row[0];
			$tot = $row1 + $row2;
			
			//$temp_machine_amount=mysql_fetch_array($result);
            if($tot==0){
                $machine_A=0;
                if($i!=2){
                    $machine_B=0;
                }
            }
        }
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`<$year AND `sell_month`=99 AND `function`='detect' AND `type`='A'");
        $row=mysql_fetch_array($result);
		$row1 = $row[0];
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='detect' AND `type` = 'A'");
        $row=mysql_fetch_array($result);
	    $row2 = $row[0];
		$tot = $row1 + $row2;
		//$temp_machine_amount=mysql_fetch_array($result);
		
        if($tot==0){
            $result=mysql_query("SELECT `check_s` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;");
            $temp=mysql_fetch_array($result);
            if($temp[0]==1)
                $machine_A=0;
        }
		
		
		
		
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`<$year AND `sell_month`=99 AND `function`='detect' AND `type`='B'");
        $row=mysql_fetch_array($result);
		$row1 = $row[0];
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='detect' AND `type` = 'B'");
        $row=mysql_fetch_array($result);
	    $row2 = $row[0];
		$tot = $row1 + $row2;
		//$temp_machine_amount=mysql_fetch_array($result);
        if($tot==0){
            $result=mysql_query("SELECT `check` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;");
            $temp=mysql_fetch_array($result);
            if($temp[0]==1){
                $machine_A=0;
                $machine_B=0;
            }
        }
        echo $machine_A.",".$machine_B;
    }
	/*else if(!strcmp($_GET['type'], "pp")){
        $machine_A=1;$machine_B=1;
        $machine_array=array("cut","combine1","combine2");
        $type_array=array("A","B","C");
        for($i=0;$i<3;$i++){
            $result=mysql_query("SELECT `$machine_array[$i]` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;",$connect);
            $temp_type=mysql_fetch_array($result);
            $type=$type_array[$temp_type[0]];
            $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='$machine_array[$i]' AND `type` = '$type'",$connect);
            $temp_machine_amount=mysql_fetch_array($result);
            if($temp_machine_amount[0]==0){
                $machine_A=0;
                if($i!=2){
                    $machine_B=0;
                }
            }
        }
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_month`<$month_temp AND `sell_month`=$month_temp AND `function`='detect' AND `type`='A'",$connect);
        $temp_machine_amount=mysql_fetch_array($result);
        if($temp_machine_amount[0]==0){
            $result=mysql_query("SELECT `check_s` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;",$connect);
            $temp=mysql_fetch_array($result);
            if($temp[0]==1)
                $machine_A=0;
        }
        $result=mysql_query("SELECT COUNT(`index`) FROM `machine` WHERE `cid`='$cid' AND  `buy_month`<$month_temp AND `sell_month`>=$month_temp AND `function`='detect' AND `type`='B'",$connect);
        $temp_machine_amount=mysql_fetch_array($result);
        if($temp_machine_amount[0]==0){
            $result=mysql_query("SELECT `check` FROM `product_plan` WHERE  `cid`='$cid' AND `month`=$month AND `year` =$year;",$connect);
            $temp=mysql_fetch_array($result);
            if($temp[0]==1){
                $machine_A=0;
                $machine_B=0;
            }
        }
        echo $machine_A.",".$machine_B;
    }*/
	
	//切割/組裝1/組裝2 machine使用設定
    else if(!strcmp($_GET['type'], "show")){
        if (!strcmp($_GET['func'], "cut")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`<$year AND `sell_month`=99 AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row1 = $row[0];
				$result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='cut' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row2 = $row[0];
				$tot = $row1 + $row2;
                echo $tot."|";
            }
        }
        else if (!strcmp($_GET['func'], "combine1")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`<$year AND `sell_month`=99 AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row1 = $row[0];
				$result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='combine1' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row2 = $row[0];
				$tot = $row1 + $row2;
                echo $tot."|";
            }
        }
        else if (!strcmp($_GET['func'], "combine2")) {
            $array=array('A','B','C');
            for($i=0;$i<3;$i++){
                $result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`<$year AND `sell_month`=99 AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row1 = $row[0];
				$result=mysql_query("SELECT COUNT(`type`) FROM `machine` WHERE `cid`='$cid' AND `buy_year`=$year AND `buy_month`<$month AND `sell_month`=99 AND `function`='combine2' AND `type`='$array[$i]';");
                $row=mysql_fetch_array($result);
				$row2 = $row[0];
				$tot = $row1 + $row2;
                echo $tot."|";
            }
        }
    }
	
}
?>
