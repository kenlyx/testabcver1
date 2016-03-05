<?php @session_start(); ?>
<?php    
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$month=$_SESSION['month'];
    $year=$_SESSION['year'];
        $supplier_arr=array("A","B","C");
        $supplier_arr2=array("a","b","c");

        $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_x';");
        $result=mysql_fetch_array($temp);
        $X=$result[0];
        $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_y';");
        $result=mysql_fetch_array($temp);
        $Y=$result[0];
        $reply="";

	switch ($_GET['type']){
		case 'A':
			//echo $_GET['decision1']."<br>1234567890-";
			$sql_pm=mysql_query("SELECT * FROM `purchase_materials` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month");
       		$pm=mysql_fetch_array($sql_pm);
				if($_GET['decision1']== -1)
					$_GET['decision1']=$pm['ma_supplier_a'];
				if($_GET['decision2']== -1)
					$_GET['decision2']=$pm['ma_supplier_b'];
				if($_GET['decision3']== -1)
					$_GET['decision3']=$pm['ma_supplier_c'];		
			    //echo $_GET['decision1']."//".$pm['ma_supplier_a']."::";
		    //purchase_materials- 更新數量
			mysql_query("UPDATE `purchase_materials` SET `ma_supplier_a`='".$_GET['decision1']."',`ma_supplier_b`='".$_GET['decision2']."',`ma_supplier_c`='".$_GET['decision3']."' WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			//materials_cost- 更新單位價格
			mysql_query("UPDATE materials_cost SET `ma_supplier_a`={$_GET['cost1']},`ma_supplier_b`={$_GET['cost2']},`ma_supplier_c`={$_GET['cost3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			//purchase_materials_price- 更新總價格(數量*價格)
			mysql_query("UPDATE purchase_materials_price SET `ma_supplier_a`={$_GET['price1']},`ma_supplier_b`={$_GET['price2']},`ma_supplier_c`={$_GET['price3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			echo "success";
			break;
		case 'B':
			$sql_pm=mysql_query("SELECT * FROM `purchase_materials` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month");
       		$pm=mysql_fetch_array($sql_pm);
				if($_GET['decision1']== -1)
					$_GET['decision1']=$pm['mb_supplier_a'];
				if($_GET['decision2']== -1)
					$_GET['decision2']=$pm['mb_supplier_b'];
				if($_GET['decision3']== -1)
					$_GET['decision3']=$pm['mb_supplier_c'];	
			mysql_query("UPDATE purchase_materials SET `mb_supplier_a`={$_GET['decision1']},`mb_supplier_b`={$_GET['decision2']},`mb_supplier_c`={$_GET['decision3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			mysql_query("UPDATE materials_cost SET `mb_supplier_a`={$_GET['cost1']},`mb_supplier_b`={$_GET['cost2']},`mb_supplier_c`={$_GET['cost3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			mysql_query("UPDATE purchase_materials_price SET `mb_supplier_a`={$_GET['price1']},`mb_supplier_b`={$_GET['price2']},`mb_supplier_c`={$_GET['price3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			echo "success";
			break;
		case 'C':
			$sql_pm=mysql_query("SELECT * FROM `purchase_materials` WHERE `cid`='$cid' AND `year`=$year AND `month`=$month");
       		$pm=mysql_fetch_array($sql_pm);
				if($_GET['decision1']== -1)
					$_GET['decision1']=$pm['mc_supplier_a'];
				if($_GET['decision2']== -1)
					$_GET['decision2']=$pm['mc_supplier_b'];
				if($_GET['decision3']== -1)
					$_GET['decision3']=$pm['mc_supplier_c'];	
			mysql_query("UPDATE purchase_materials SET `mc_supplier_a`={$_GET['decision1']},`mc_supplier_b`={$_GET['decision2']},`mc_supplier_c`={$_GET['decision3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			mysql_query("UPDATE materials_cost SET `mc_supplier_a`={$_GET['cost1']},`mc_supplier_b`={$_GET['cost2']},`mc_supplier_c`={$_GET['cost3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			mysql_query("UPDATE purchase_materials_price SET `mc_supplier_a`={$_GET['price1']},`mc_supplier_b`={$_GET['price2']},`mc_supplier_c`={$_GET['price3']} WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			echo "success";
			break;
	}//end switch
		
		//轉移到運作頁:P
		/*case 'getA':
                        //inventory
			$result=mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c` FROM `state` WHERE `year`=$year AND `month`=$month AND `cid`='$cid';");
			$temp=mysql_fetch_array($result);
			$reply=$temp['ma_supplier_a'].":".$temp['ma_supplier_b'].":".$temp['ma_supplier_c'].":";
			$result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=1 AND `cid`='$cid' AND `type`='A';");
			if($result2!=NULL)
				$temp2=mysql_fetch_array($result2);
			else
				$temp2=array(-1,-1,-1);
			$result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=1 AND `cid`='$cid' AND `type`='B';");
			if($result2!=NULL)
				$temp3=mysql_fetch_array($result2);
			else
				$temp3=array(-1,-1,-1);
			
            //price
            $result=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_a';");
            $result_1=mysql_fetch_array($result);
            $result=mysql_query("SELECT * FROM `supplier_satisfaction` WHERE `cid`='$cid';");
            $result_2=mysql_fetch_array($result);
            $result=mysql_query("SELECT `material_A_price` FROM `situation` WHERE `happening`>0;");
            $result_3=mysql_fetch_array($result);
                	for($i=0;$i<3;$i++){
						if($temp2[$i]==-1||$temp3[$i]==-1){//2012/02/24 &&改成|| 還有加上AB原料簽約判斷by Roy
							if($result_3[0]!=0)
								$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)*($result_3[0])).":";
							else
								$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)).":";
							}else{
								$detail1=split(":",$temp2[$i]);
								$detail2=split(":",$temp3[$i]);
								if($temp2[$i]==-1)
									$reply=$reply.$detail2[0].":";
								else if($temp3[$i]==-1)
									$reply=$reply.$detail1[0].":";
								else{
									$reply=$reply.number_format(($detail2[0]*$detail2[1]+$detail1[0]*$detail1[1])/($detail2[1]+$detail1[1]),1,'.','').":";
								}
							}
                        }

            //decision
			$result=mysql_query("SELECT `ma_supplier_a`,`ma_supplier_b`,`ma_supplier_c` FROM `purchase_materials` WHERE `year`=$year AND `month`=$month AND `cid`='$cid'") or die(mysql_error());
			$temp=mysql_fetch_array($result);
			$reply=$reply.$temp['ma_supplier_a'].":".$temp['ma_supplier_b'].":".$temp['ma_supplier_c'].":";
                        
                        //supplier_power
                        for($i=0;$i<3;$i++){
                            $supplier_temp=0;
                            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier_arr[$i]_power';");
                            $result=mysql_fetch_array($temp);
                            $supplier_temp=$result[0];
                            $temp=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier_arr2[$i]` WHERE `cid`<>'$cid' OR `source`<>1;") or die(mysql_error());
                            $result=mysql_fetch_array($temp);
                            if($result[0]!=NULL)
                                $supplier_temp-=$result[0];
                            $reply=$reply.$supplier_temp.":";
                        }
			echo "".$reply;
			break;
		case 'getB':
			$result=mysql_query("SELECT `mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c` FROM state WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
		$temp=mysql_fetch_array($result);
		$reply=$temp['mb_supplier_a'].":".$temp['mb_supplier_b'].":".$temp['mb_supplier_c'].":";
		$result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=2 AND `cid`='$cid' AND `type`='A';");
				if($result2!=NULL)
						$temp2=mysql_fetch_array($result2);
				else
						$temp2=array(-1,-1,-1);
						$result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=2 AND `cid`='$cid' AND `type`='B';");
				if($result2!=NULL)
						$temp3=mysql_fetch_array($result2);
				else
						$temp3=array(-1,-1,-1);
                        $result=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_b';");
                        $result_1=mysql_fetch_array($result);
                        $result=mysql_query("SELECT * FROM `supplier_satisfaction` WHERE `cid`='$cid';");
                        $result_2=mysql_fetch_array($result);
                        $result=mysql_query("SELECT `material_B_price` FROM `situation` WHERE `happening`>0;");
                        $result_3=mysql_fetch_array($result);
							for($i=0;$i<3;$i++){
								if($temp2[$i]==-1||$temp3[$i]==-1){
									if($result_3[0]!=0)
										$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)*($result_3[0])).":";
									else
										$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)).":";
									}else{
										$detail1=split(":",$temp2[$i]);
										$detail2=split(":",$temp3[$i]);
										if($temp2[$i]==-1)
											$reply=$reply.$detail2[0].":";
										else if($temp3[$i]==-1)
											$reply=$reply.$detail1[0].":";
										else{
											$reply=$reply.number_format(($detail2[0]*$detail2[1]+$detail1[0]*$detail1[1])/($detail2[1]+$detail1[1]),1,'.','').":";
										}
									}
								}
			$result=mysql_query("SELECT `mb_supplier_a`,`mb_supplier_b`,`mb_supplier_c` FROM purchase_materials WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			$temp=mysql_fetch_array($result);
			$reply=$reply.$temp['mb_supplier_a'].":".$temp['mb_supplier_b'].":".$temp['mb_supplier_c'].":";
                        for($i=0;$i<3;$i++){
                            $supplier_temp=0;
                            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier_arr[$i]_power';");
                            $result=mysql_fetch_array($temp);
                            $supplier_temp=$result[0];
                            $temp=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier_arr2[$i]` WHERE `cid`<>'$cid' OR `source`<>2;");
                            $result=mysql_fetch_array($temp);
                            if($result[0]!=NULL)
                                $supplier_temp-=$result[0];
                            $reply=$reply.$supplier_temp.":";
                        }
			echo "".$reply;
			break;
		case 'getC':
			$result=mysql_query("SELECT `mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c` FROM state WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			$temp=mysql_fetch_array($result);
			$reply=$temp['mc_supplier_a'].":".$temp['mc_supplier_b'].":".$temp['mc_supplier_c'].":";
			 $result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=3 AND `cid`='$cid' AND `type`='A';");
									if($result2!=NULL)
										$temp2=mysql_fetch_array($result2);
									else
										$temp2=array(-1,-1,-1);
									$result2=mysql_query("SELECT `supplier_A`,`supplier_B`,`supplier_C` FROM `r_d` WHERE `source`=3 AND `cid`='$cid' AND `type`='B';");
									if($result2!=NULL)
										$temp3=mysql_fetch_array($result2);
									else
										$temp3=array(-1,-1,-1);
                        $result=mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='purchase_material_c';");
                        $result_1=mysql_fetch_array($result);
                        $result=mysql_query("SELECT * FROM `supplier_satisfaction` WHERE `cid`='$cid';");
                        $result_2=mysql_fetch_array($result);
                        $result=mysql_query("SELECT `material_C_price` FROM `situation` WHERE `happening`>0;");
                        $result_3=mysql_fetch_array($result);
									for($i=0;$i<3;$i++){
										if($temp2[$i]==-1||$temp3[$i]==-1){//2012/02/24 &&改成|| 還有加上AB原料簽約判斷by Roy
											if($result_3[0]!=0)
												$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)*($result_3[0])).":";
											else
												$reply=$reply.(integer)(($result_1[$i]-(integer)(($result_2[$i]-50)/($X*100))*$Y)).":";
										}
										else{
											$detail1=split(":",$temp2[$i]);
											$detail2=split(":",$temp3[$i]);
											if($temp2[$i]==-1)
												$reply=$reply.$detail2[0].":";
											else if($temp3[$i]==-1)
												$reply=$reply.$detail1[0].":";
											else{
												$reply=$reply.number_format(($detail2[0]*$detail2[1]+$detail1[0]*$detail1[1])/($detail2[1]+$detail1[1]),1,'.','').":";
											}
										}
									}
			$result=mysql_query("SELECT `mc_supplier_a`,`mc_supplier_b`,`mc_supplier_c` FROM purchase_materials WHERE `year`=$year AND `month`=$month AND `cid`='$cid'");
			$temp=mysql_fetch_array($result);
			$reply=$reply.$temp['mc_supplier_a'].":".$temp['mc_supplier_b'].":".$temp['mc_supplier_c'].":";
                        for($i=0;$i<3;$i++){
                            $supplier_temp=0;
                            $temp=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='supplier_$supplier_arr[$i]_power';");
                            $result=mysql_fetch_array($temp);
                            $supplier_temp=$result[0];

                            $temp=mysql_query("SELECT SUM(`quantity`) FROM `supplier_$supplier_arr2[$i]` WHERE `cid`<>'$cid' OR `source`<>3;");
                            $result=mysql_fetch_array($temp);
                            if($result[0]!=NULL)
                                $supplier_temp-=$result[0];
                            $reply=$reply.$supplier_temp.":";
                        }
			echo "".$reply;
			break;
	}
*/
?>
