<?php
function influence(){
	include("./connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");//讀ABC所有的公司ID
    mysql_query("set names 'utf8'");
	$C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account");
	
	mysql_select_db("testabc_main");
	
	$image_sum=0;
	$satisfaction_sum=0;
	$month=0;
	$year=1;
	$step_i=1;//成長限制係數
	$step_s=1;
	$step_e_e=1;//step_empoly_efficiency五部門共用，用完記得歸位(?)
	$step_e_s=1;
        $value=0;

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
	$i=0;
	$j=0;
	$C_decision=array("0"=>"share","1"=>"donate","2"=>"ad_a","3"=>"ad_b");//$Company_decision
	$department=array("1"=>"finance","2"=>"equip","3"=>"sale","4"=>"human","5"=>"research");//資料庫的部門名稱改的話直接改這裡就好
	while($company=mysql_fetch_array($C_name)){//每間公司
                $CompanyID=$company['CompanyID'];
		if($month-1==0)
			$result=mysql_query("SELECT * FROM `state` WHERE `year`=$year-1 AND `month`=1 AND `cid`='$CompanyID'");
		else $result=mysql_query("SELECT * FROM `state` WHERE `year`=$year AND `month`=$month-1 AND `cid`='$CompanyID'");
		$temp=mysql_fetch_array($result);
		$image=$temp['company_image'];//先讀公司目前狀況，之後判斷用
		$satisfaction=$temp['satisfaction'];
		if($image>1)//限制提升
			$step_i=0;
		elseif($image>0.9)
			$step_i=0.5;
		elseif($image>0.8)
			$step_i=0.8;
		if($satisfaction>1)
			$step_s=0;
		elseif($satisfaction>0.9)
			$step_s=0.5;
		elseif($satisfaction>0.8)
			$step_s=0.8;
		while($decision_name=$C_decision[$j]){//每項影響形象和滿意度的決策
			$for_cal=mysql_query("SELECT * FROM `$decision_name` WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID' ORDER BY `year`, `month`");
			while($cal_array=mysql_fetch_array($for_cal)){
                                $value=0;
				for($i=3;$i<count($cal_array);$i++)//因為前三欄固定，$i從3開始，超出資料表欄位就結束
					$decision[$i-3]=$cal_array[$i];
				if($decision_name=="share"){//用這種方式一個個判斷或用switch
					for($i=0;$i<count($decision);$i++)
						if($decision[$i]==1){
							$image_sum+=0.01;
							$satisfaction_sum+=0.001;}
						elseif($decision[$i]==2){
							$image_sum+=0.03;
							$satisfaction_sum+=0.002;}
						elseif($decision[$i]==3){
							$image_sum+=0.05;
							$satisfaction_sum+=0.005;}
					$image+=$image_sum*0.01*$step_i;
					$satisfaction+=$satisfaction_sum*0.01*$step_s;
					mysql_query("UPDATE `state` SET `company_image`=$image,`satisfaction`=$satisfaction WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'");
				}
				elseif($decision_name=="donate"){
					for($i=0;$i<count($decision);$i++)
						if($decision[$i]==1){
							$image_sum+=0.01;
							$satisfaction_sum+=0.001;}
						elseif($decision[$i]==2){
							$image_sum+=0.03;
							$satisfaction_sum+=0.002;}
						elseif($decision[$i]==3){
							$image_sum+=0.05;
							$satisfaction_sum+=0.005;}
					$image+=$image_sum*0.01*$step_i;
					$satisfaction+=$satisfaction_sum*0.01*$step_s;
					mysql_query("UPDATE `state` SET `company_image`=$image,`satisfaction`=$satisfaction WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'");
				}
				elseif($decision_name=="ad_a"){
					for($i=0;$i<count($decision);$i++)
						if($decision[$i]==1){
							$image_sum+=0.1;
                                                        $value+=1;
                                                }
						elseif($decision[$i]==2){
							$image_sum+=0.3;
                                                        $value+=2;
                                                }
						elseif($decision[$i]==3){
							$image_sum+=0.5;
                                                        $value+=3;
                                                }
					$image+=$image_sum*0.01*$step_i;
					mysql_query("UPDATE `state` SET `company_image`=$image WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'");
                                        $temp_a=mysql_query("SELECT `value` FROM `product_famous` WHERE `product`='A';");
                                        $result_a=mysql_fetch_array($temp_a);
                                        $value+=$result_a[0];
                                        mysql_query("UPDATE `product_famous` SET `value`=$value WHERE `product`='A';");
				}
				elseif($decision_name=="ad_b"){
					for($i=0;$i<count($decision);$i++)
						if($decision[$i]==1){
							$image_sum+=0.2;
                                                        $value+=1;
                                                }
						elseif($decision[$i]==2){
							$image_sum+=0.4;
                                                        $value+=2;
                                                }
						elseif($decision[$i]==3){
							$image_sum+=0.6;
                                                        $value+=3;
                                                }
					$image+=$image_sum*0.01*$step_i;
					mysql_query("UPDATE state SET `company_image`=$image WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'");
                                        $temp_b=mysql_query("SELECT `value` FROM `product_famous` WHERE `product`='B';");
                                        $result_b=mysql_fetch_array($temp_b);
                                        $value+=$result_b[0];
                                        mysql_query("UPDATE `product_famous` SET `value`=$value WHERE `product`='B';");
				}
			}
			$image_sum=0;//記得要歸零...
			$satisfaction_sum=0;
			$j++;
		}
		$j=0;
		//month_forward建好下個月欄位=>讀這個月的值=>判斷限制係數=>讀決策值=>判斷各加多少=>值要存到下個月，這個月=最大月減一=$month，下個月=最大月=$month+1
		$result=mysql_query("SELECT * FROM `training` WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'");
		$cal_array=mysql_fetch_array($result);//決策值一次讀完，不用一直query
		for($i=1;$i<=5;$i++){//部門編號對應到決策欄位編號，所以$i從1開始
                        $value=0;
			$result=mysql_query("SELECT * FROM current_people WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID' AND `department`='$department[$i]';");
			$temp=mysql_fetch_array($result);
			$efficiency=$temp['efficiency'];
			$e_satisfaction=$temp['satisfaction'];
			if($efficiency>=100)//限制提升
				$step_e_e=0;
			elseif($efficiency>90)
				$step_e_e=0.5;
			elseif($efficiency>70)
				$step_e_e=0.8;
			if($e_satisfaction>100)
				$step_e_s=0;
			elseif($e_satisfaction>90)
				$step_e_s=0.5;
			elseif($e_satisfaction>70)
				$step_e_s=0.8;
			if($cal_array['decision'.$i]==1){
				$efficiency+=($efficiency/50+0.1)*$step_e_e;
				$e_satisfaction=($e_satisfaction+0.01)*$step_e_s;
                                }
			elseif($cal_array['decision'.$i]==2){
				$efficiency+=($efficiency/40+0.2)*$step_e_e;
				$e_satisfaction=($e_satisfaction+0.02)*$step_e_s;
                                }
			elseif($cal_array['decision'.$i]==3){
				$efficiency+=($efficiency/30+0.5)*$step_e_e;
				$e_satisfaction=($e_satisfaction+0.05)*$step_e_s;
                                }
                         else{
                                $e_satisfaction=$e_satisfaction-0.03;
                         }
			mysql_query("UPDATE `current_people` SET `efficiency`=$efficiency,`satisfaction`=$e_satisfaction WHERE (`year`-1)*12+`month`=($year-1)*12+$month+1 AND `cid`='$CompanyID' AND `department`='$department[$i]'");
                        if(!strcmp($department[$i],"sale")){
                            if($efficiency>60){
                                $image_sum+=0.1;
                                $value+=0.1;
                            }
                            else if($efficiency>70){
                                $image_sum+=0.2;
                                $value+=0.2;
                            }
                            else if($efficiency>80){
                                $image_sum+=0.3;
                                $value+=0.3;
                            }
                            else if($efficiency>90){
                                $image_sum+=0.4;
                                $value+=0.4;
                            }
                            $image+=$image_sum*0.01*$step_i;
                            mysql_query("UPDATE state SET `company_image`=$image WHERE `year`=$year AND `month`=$month AND `cid`='$CompanyID'",$connect2);
                            $temp_b=mysql_query("SELECT `value` FROM `product_famous` WHERE `product`='B';");
                            $result_b=mysql_fetch_array($temp_b);
                            $value+=$result_b[0];
                            mysql_query("UPDATE `product_famous` SET `value`=$value WHERE `product`='B';");
                        }
			$step_e_e=1;//歸位(?)
			$step_e_s=1;
		}
	}
}
influence();
?>