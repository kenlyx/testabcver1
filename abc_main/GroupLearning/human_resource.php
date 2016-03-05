<?php session_start();?>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);

$cid = $_SESSION['cid'];
$month = $_SESSION['month'];
$year=$_SESSION['year'];
$round = ($year - 1) * 12 + $month;
$hire_count = 0;
$fire_count = 0;
$thismonth_hire = 0;
$thismonth_fire = 0;
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");

if (!strcmp($_GET['type'], "finan")) {
	//排除本回合決策，總招解聘人數
    $sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='finance' AND `cid`='$cid' AND (`year`-1)*12+`month`<$round", $connect);
	$exhf=mysql_fetch_array($sql_exhf);
	if($exhf[0]==NULL)//累計招聘
		$exhf[0]=0;
	if($exhf[1]==NULL)//累計解聘
		$exhf[1]=0;		
		
	//本回合招解聘人數
    $sql_nowhf= mysql_query("SELECT * FROM  `current_people` WHERE `department`='finance' AND `cid`='$cid' AND `year`=$year AND `month`=$month", $connect);
    $nowhf=mysql_fetch_array($sql_nowhf);
	$nowhire=$nowhf['hire_count'];
	$nowfire=$nowhf['fire_count'];
	
	//包含本回合，總招解聘人數，目前公司總人數
//	$total_hire=$hire_count+$exhire[0];
//	$total_fire=$fire_count;
    $curp = $exhf[0]-$exhf[1];
	
    echo $curp . "|" . $nowhire . "|" . $nowfire;

} else if (!strcmp($_GET['type'], "equip")) {
    $sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='equip' AND `cid`='$cid' AND (`year`-1)*12+`month`<$round", $connect);
	$exhf=mysql_fetch_array($sql_exhf);
	if($exhf[0]==NULL)//累計招聘
		$exhf[0]=0;
	if($exhf[1]==NULL)//累計解聘
		$exhf[1]=0;		
		
	//本回合招解聘人數
    $sql_nowhf= mysql_query("SELECT * FROM  `current_people` WHERE `department`='equip' AND `cid`='$cid' AND `year`=$year AND `month`=$month", $connect);
    $nowhf=mysql_fetch_array($sql_nowhf);
	$nowhire=$nowhf['hire_count'];
	$nowfire=$nowhf['fire_count'];
	
	//包含本回合，總招解聘人數，目前公司總人數
//	$total_hire=$hire_count+$exhire[0];
//	$total_fire=$fire_count;
    $curp = $exhf[0]-$exhf[1];
	
    echo $curp . "|" . $nowhire . "|" . $nowfire;

} else if (!strcmp($_GET['type'], "sale")) {
    $sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='sale' AND `cid`='$cid' AND (`year`-1)*12+`month`<$round", $connect);
	$exhf=mysql_fetch_array($sql_exhf);
	if($exhf[0]==NULL)//累計招聘
		$exhf[0]=0;
	if($exhf[1]==NULL)//累計解聘
		$exhf[1]=0;		
		
	//本回合招解聘人數
    $sql_nowhf= mysql_query("SELECT * FROM  `current_people` WHERE `department`='sale' AND `cid`='$cid' AND `year`=$year AND `month`=$month", $connect);
    $nowhf=mysql_fetch_array($sql_nowhf);
	$nowhire=$nowhf['hire_count'];
	$nowfire=$nowhf['fire_count'];
	
	//包含本回合，總招解聘人數，目前公司總人數
//	$total_hire=$hire_count+$exhire[0];
//	$total_fire=$fire_count;
    $curp = $exhf[0]-$exhf[1];
	
    echo $curp . "|" . $nowhire . "|" . $nowfire;

} else if (!strcmp($_GET['type'], "human")) {
    $sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='human' AND `cid`='$cid' AND (`year`-1)*12+`month`<$round", $connect);
	$exhf=mysql_fetch_array($sql_exhf);
	if($exhf[0]==NULL)//累計招聘
		$exhf[0]=0;
	if($exhf[1]==NULL)//累計解聘
		$exhf[1]=0;		
		
	//本回合招解聘人數
    $sql_nowhf= mysql_query("SELECT * FROM  `current_people` WHERE `department`='human' AND `cid`='$cid' AND `year`=$year AND `month`=$month", $connect);
    $nowhf=mysql_fetch_array($sql_nowhf);
	$nowhire=$nowhf['hire_count'];
	$nowfire=$nowhf['fire_count'];
	
	//包含本回合，總招解聘人數，目前公司總人數
//	$total_hire=$hire_count+$exhire[0];
//	$total_fire=$fire_count;
    $curp = $exhf[0]-$exhf[1];
	
    echo $curp . "|" . $nowhire . "|" . $nowfire;
	
} else if (!strcmp($_GET['type'], "research")) {
	$sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM `current_people` WHERE `department`='research' AND `cid`='$cid' AND(`year`-1)*12+`month`<$round", $connect);
	$exhf=mysql_fetch_array($sql_exhf);
	if($exhf[0]==NULL)//累計招聘
		$exhf[0]=0;
	if($exhf[1]==NULL)//累計解聘
		$exhf[1]=0;		
	//本回合招解聘人數
    $sql_nowhf= mysql_query("SELECT * FROM  `current_people` WHERE `department`='research' AND `cid`='$cid' AND `year`=$year AND `month`=$month", $connect);
    $nowhf=mysql_fetch_array($sql_nowhf);
	$nowhire=$nowhf['hire_count'];
	$nowfire=$nowhf['fire_count'];
	
	//包含本回合，總招解聘人數，目前公司總人數
//	$total_hire=$hire_count+$exhire[0];
//	$total_fire=$fire_count;
    $curp = $exhf[0]-$exhf[1];
	
    echo $curp . "|" . $nowhire . "|" . $nowfire;

} else if (!strcmp($_GET['type'], "hire_submit")) {
	$round=($year-1)*12+$month;
	$department=array("0"=>"finance","1"=>"equip","2"=>"sale","3"=>"human",4=>"research");
	//$department2=array("finance","equip","sale","human","research");
	$d=array("f","e","s","h","r");
 /*	$sql_curp = mysql_query("SELECT * FROM `current_people` WHERE `year`=$year AND `month`=$month");
    $curp = mysql_fetch_array($sql_curp);
	
	if (empty($curp)) {
        mysql_query("INSERT INTO `current_people` VALUES ($year,$month,'$cid','finance',0,0,0,0);", $connect);
        mysql_query("INSERT INTO `current_people` VALUES ($year,$month,'$cid','equip',0,0,0,0);", $connect);
        mysql_query("INSERT INTO `current_people` VALUES ($year,$month,'$cid','sale',0,0,0,0);", $connect);
        mysql_query("INSERT INTO `current_people` VALUES ($year,$month,'$cid','human',0,0,0,0);", $connect);
        mysql_query("INSERT INTO `current_people` VALUES ($year,$month,'$cid','research',0,0,0,0);", $connect);
    }
	
    mysql_query("UPDATE `current_people` SET `hire_count`=`hire_count`+{$_GET['f']},`efficiency`=$curp[efficiency],`satisfaction`=$curp[satisfaction] WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='finance'", $connect);
    mysql_query("UPDATE `current_people` SET `hire_count`=`hire_count`+{$_GET['e']},`efficiency`=$curp[efficiency],`satisfaction`=$curp[satisfaction] WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='equip'", $connect);
    mysql_query("UPDATE `current_people` SET `hire_count`=`hire_count`+{$_GET['s']},`efficiency`=$curp[efficiency],`satisfaction`=$curp[satisfaction] WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='sale'", $connect);
    mysql_query("UPDATE `current_people` SET `hire_count`=`hire_count`+{$_GET['h']},`efficiency`=$curp[efficiency],`satisfaction`=$curp[satisfaction] WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='human'", $connect);
    mysql_query("UPDATE `current_people` SET `hire_count`=`hire_count`+{$_GET['r']},`efficiency`=$curp[efficiency],`satisfaction`=$curp[satisfaction] WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='research'", $connect);*/
	for($i=0;$i<5;$i++){
		if(isset($_GET[$d[$i]]))
			$hire=$_GET[$d[$i]];
		else 
			$hire=0;
		if($round==1){
			mysql_query("UPDATE `current_people` SET `hire_count`=$hire,`efficiency`=50,`satisfaction`=50 WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='$department[$i]'");
		}else{
			if($month==1)	
				$sql_exp = mysql_query("SELECT * FROM `current_people` WHERE `year`=($year-1) AND `month`=12");
    		else
				$sql_exp = mysql_query("SELECT * FROM `current_people` WHERE `year`=$year AND `month`=($month-1)");
			//抓上一回合資料
			$exp = mysql_fetch_array($sql_exp);				
			
			//公司總員工
			$sql_exhf = mysql_query("SELECT SUM(`hire_count`),SUM(`fire_count`) FROM  `current_people` WHERE `department`='$department[$i]' AND `cid`='$cid' AND `year`<=$year AND `month`<$month", $connect);
			$exhf=mysql_fetch_array($sql_exhf);
			$exall=$exhf[0]-$exhf[1];
			if($_GET[$d[$i]]!=0){
				$efficiency = ($exall*$exp['efficiency']+$_GET[$d[$i]]*50)/($exall+$_GET[$d[$i]]);
				$satisfy  = ($exall*$exp['satisfaction']+$_GET[$d[$i]]*50)/($exall+$_GET[$d[$i]]);
			
				mysql_query("UPDATE `current_people` SET `hire_count`=$hire,`efficiency`=$efficiency,`satisfaction`=$satisfy WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='$department[$i]'");
				echo "UPDATE `current_people` SET `hire_count`=$hire,`efficiency`=$efficiency,`satisfaction`=$satisfy WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='$department[$i]'"."<br>";
				//mysql_query("UPDATE `current_people` SET `cid`='".$aabb."' WHERE `cid`=321 AND `year`=1 AND `month`=1 AND `department`='human'");
			}
		}
	}
} else if (!strcmp($_GET['type'], "fire_submit")) {
    mysql_query("UPDATE `current_people` SET `fire_count`={$_GET['f']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='finance'", $connect);
    mysql_query("UPDATE `current_people` SET `fire_count`={$_GET['e']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='equip'", $connect);
    mysql_query("UPDATE `current_people` SET `fire_count`={$_GET['s']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='sale'", $connect);
    mysql_query("UPDATE `current_people` SET `fire_count`={$_GET['h']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='human'", $connect);
    mysql_query("UPDATE `current_people` SET `fire_count`={$_GET['r']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='research'", $connect);
} else if (!strcmp($_GET['type'], "hire_money")) {
	$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
	$correspond=mysql_fetch_array($correspondence);
	echo $correspond['money'];
} else if (!strcmp($_GET['type'], "fire_money")) {
	$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
	$correspond=mysql_fetch_array($correspondence);
	$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
	$correspond2=mysql_fetch_array($correspondence);
	echo $correspond['money2'].":".$correspond['money3'].":".$correspond2['money'].":".$correspond2['money2'].":".$correspond2['money3'];
} else if (!strcmp($_GET['type'], "sale_service")){
	$result = mysql_query("SELECT * FROM `current_people` WHERE `department` = 'sale';", $connect);
    while ($row = mysql_fetch_array($result)) {
        if ($row['cid'] == $cid) {
            if ((($row['year'] - 1) * 12 + $row['month'] ) < $round) {
                $hire_count = $hire_count + $row['hire_count'];
                $fire_count = $fire_count + $row['fire_count'];
            } elseif ((($row['year'] - 1) * 12 + $row['month'] ) == $round) {
                $thismonth_hire = $thismonth_hire + $row['hire_count'];
                $thismonth_fire = $thismonth_fire + $row['fire_count'];
            }
        }
    }
    $num = $hire_count - $fire_count;
	$result = mysql_query("SELECT `efficiency` FROM `current_people` WHERE `year`=$year AND `month`=$month AND `cid`='$cid' AND `department`='sale'",$connect);
	$temp = mysql_fetch_array($result);
	$sale_limit=$num*$temp[0]/250;
	if($sale_limit>=1250)
		$s_limit=1;
	else if($sale_limit>=1000)
		$s_limit=2;
	else if($sale_limit>=750)
		$s_limit=3;
	else if($sale_limit>=500)
		$s_limit=4;
	else
		$s_limit=5;
	echo $s_limit;
}

?>
