<?php
    session_start();
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
    $company=$_SESSION['cid'];
	$product=array("L"=>'1',"T"=>'2');
    $supplier_a1=array("A","B","C");
    $supplier_a2=array("a","b","c");
    $relate=array('A'=>'money','B'=>'money2','C'=>'money3');
    $r2=array('p'=>'a','c'=>'b','k'=>'c');//原料分類
    if(!strcmp($_GET['type'], "power")){
        for($i=0;$i<3;$i++){
            $supplier_temp=0;
            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier_a1[$i]_power';");
            $result=mysql_fetch_array($temp);
            $supplier_temp=$result[0];

            $temp=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier_a2[$i]`;");
            $result=mysql_fetch_array($temp);
            if($result[0]!="")
                $supplier_temp-=$result[0];
            echo $supplier_temp."|";
        }
    }
	//產品(L/T)，原料(p/c/k)，供應商(A/B/C)
    else if(!strcmp($_GET['type'], "price")){
		
		$rdtype=$_GET['rdtype'];
		
		//$gettype=array(split('.', $rdtype));
		//echo count($rdtype);
		for($i=0;$i<count($rdtype);$i++){
			
        list($product, $type, $supplier_a1) = explode('_', $rdtype[$i]);
		$temp=mysql_query("SELECT `$relate[$supplier_a1]` FROM `correspondence` WHERE `name`='purchase_materials_m$r2[$type]';");
		$result=mysql_fetch_array($temp);
        echo $result[0]."|";

        $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_x';");
        $result=mysql_fetch_array($temp);
        $X=$result[0];
        $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_y';");
        $result=mysql_fetch_array($temp);
        $Y=$result[0];
        $temp=mysql_query("SELECT `satisfaction_$supplier_a1` FROM `supplier_satisfaction` WHERE `cid`='$company';");
        $result=mysql_fetch_array($temp);
		//折扣，供應商滿意度上升1%折扣10元
		$dis=(int)(($result[0]-50)/$X)*$Y;
		if($dis>0)
			$dis=$dis;
        else
			$dis=0;
		echo $dis."|";
		}
	}

?>
