<?php
    include("./connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`");
    $result_temp=mysql_fetch_array($temp);
    $year=$result_temp[0];
    $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year;");
    $result_temp=mysql_fetch_array($temp);
    $month=$result_temp[0];
    $index=0;

    $temp=mysql_query("SELECT `situation` from `situation_overview` WHERE `month`=$month;");
    $result=  mysql_fetch_array($temp);
    $index=$result[0];
    $temp_01=mysql_query("SELECT * FROM `situation` WHERE `index`=$index;");
    while($result=  mysql_fetch_array($temp_01)){
        if($result['order_quantity']!=0){
            $temp_result=mysql_query("SELECT `quantity`,`index` FROM `customer_state`");
            while($result_temp=  mysql_fetch_array($temp_result)){
                $result_temp['quantity']=$result_temp[0]*(1+$result['order_quantity']/100);
                mysql_query("UPDATE `customer_state` SET `quantity`={$result_temp['quantity']} WHERE `index` = {$result_temp['index']};");
            }
        }
        if($result['material_A_price']!=0||$result['material_B_price']!=0||$result['material_C_price']!=0)
            mysql_query("UPDATE `situation` SET `happening`=3 WHERE `index`=$index;");
        if($result['housing_cost']!=0){
            mysql_query("UPDATE `situation` SET `happening`=3 WHERE `index`=$index;");
            $temp_result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='housing_cost';");
            $result_temp=mysql_fetch_array($temp_result);
            $result_temp[0]=$result_temp[0]*(1+$result['housing_cost']/100);
            mysql_query("UPDATE `parameter_description` SET `value`={$result_temp[0]} WHERE `name`='housing_cost';");
        }
        if($result['bad_rate']!=0){
            $cor=array('supplierA_flaw','supplierB_flaw','supplierC_flaw');
            for($i=0;$i<count($cor);$i++){
                $temp_result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='{$cor[$i]}';");
                $result_temp=mysql_fetch_array($temp_result);
                $result_temp[0]=$result_temp[0]*(1+$result['bad_rate']/100);
                mysql_query("UPDATE `parameter_description` SET `value`={$result_temp[0]} WHERE `name`='{$cor[$i]}';");
            }
        }
        if($result['material_cost']!=0){
            $main_cor=array('purchase_materials_ma','purchase_materials_mb','purchase_materials_mc');
            $sub_cor=array('money','money2','money3');
            for($i=0;$i<count($main_cor);$i++)
                for($j=0;$j<count($sub_cor);$j++){
                    $temp_result=mysql_query("SELECT `{$sub_cor[$j]}` FROM `correspondence` WHERE `name`='{$main_cor[$i]}';");
                    $result_temp=mysql_fetch_array($temp_result);
                    $result_temp[0]=(integer)($result_temp[0]*(1+$result['material_cost']/100));
                    mysql_query("UPDATE `correspondence` SET `{$sub_cor[$j]}`={$result_temp[0]} WHERE `name`='{$main_cor[$i]}';");
                }
        }
        if($result['company_image']!=0){
            $temp_result=mysql_query("SELECT DISTINCT(`CompanyID`) FROM `state`;");
            while($result_temp=  mysql_fetch_array($temp_result)){
                $temp_02=mysql_query("SELECT `company_image` FROM `state` WHERE `year`=$year AND `month`=$month AND `cid`='{$result_temp[0]}';");
                $result_01=mysql_fetch_array($temp_02);
                $result_01[0]=$result_01[0]*(1+$result['company_image']/100);
                echo $result_01[0];
                mysql_query("UPDATE `state` SET `company_image`={$result_01[0]} WHERE `year`=$year AND `month`=$month AND `cid`='{$result_temp[0]}';");
            }
        }
        if($result['quit_rate']!=0){
            mysql_query("UPDATE `situation` SET `happening`=3 WHERE `index`=$index;");
            //調整離職率...
        }
    }
?>
