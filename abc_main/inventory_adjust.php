<?php
   include("./connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");

	mysql_query("set names 'utf8'");
    $name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account");
    mysql_select_db("testabc_main");
    $arr=array("0"=>"ma_supplier_a","1"=>"ma_supplier_b","2"=>"ma_supplier_c","3"=>"mb_supplier_a","4"=>"mb_supplier_b","5"=>"mb_supplier_c","6"=>"mc_supplier_a","7"=>"mc_supplier_b","8"=>"mc_supplier_c");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`");
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0]-1;
        if($month==0){
            $month=12;
            $year-=1;
        }
    $reply="";
    $adjust="";
    while($company=mysql_fetch_array($name)){//每間公司
		$cid=$company['CompanyID'];
		$result=mysql_query("SELECT * FROM state WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp1=mysql_fetch_array($result);
		$result=mysql_query("SELECT * FROM product_a WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp2=mysql_fetch_array($result);
		$result=mysql_query("SELECT * FROM product_b WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp3=mysql_fetch_array($result);
		$result=mysql_query("SELECT * FROM purchase_materials WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp4=mysql_fetch_array($result);
		for($i=0;$i<6;$i++)//原料AB和C分開處理，第一個for只跑到原料AB
			$reply=$reply.($temp1[$arr[$i]]-$temp2[$arr[$i]]-$temp3[$arr[$i]]+$temp4[$arr[$i]]).":";
		for($i=6;$i<9;$i++)//第二個for才跑後面C的部分
			$reply=$reply.($temp1[$arr[$i]]-$temp2[$arr[$i]]+$temp4[$arr[$i]]).":";
		$temp=explode(":",$reply);
		$adjust="SET `".$arr[0]."`=".$temp[0];//第一個不能加逗號
		//$adjust1="(`cid`,`year`,`month`,`".$arr[0]."`";
		//$adjust2="('".$cid."',".$year.",".($month+1).",".$temp[0];
		for($i=1;$i<9;$i++){
			//$adjust1=$adjust1.",`".$arr[$i]."`";
			//$adjust2=$adjust2.",".$temp[$i]."";
			$adjust=$adjust.",`".$arr[$i]."`=".$temp[$i];
		}
		//$adjust1=$adjust1.",`product_A_RD`,`product_B_RD`,`company_image`,`refresh`)";
		//$adjust2=$adjust2.",0,0,0,0)";
					if($month+1>12)
						mysql_query("UPDATE state $adjust WHERE `year`=$year+1 AND `month`=1 AND `cid`='$company[cid]'");
					else mysql_query("UPDATE state $adjust WHERE `year`=$year AND `month`=$month+1 AND `cid`='$company[cid]'");
			$adjust="";//歸零，否則字串會重複
		$reply="";
	}
?>