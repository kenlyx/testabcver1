<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='product_A_size_ratio' ",$connect);
	$array = mysql_fetch_array($temp);
	$product_A_size_ratio = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='product_B_size_ratio' ",$connect);
	$array = mysql_fetch_array($temp);
	$product_B_size_ratio = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplierA_flaw' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplierA_flaw = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplierB_flaw' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplierB_flaw = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplierC_flaw' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplierC_flaw = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplier_A_power' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplier_A_power = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplier_B_power' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplier_B_power = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='supplier_C_power' ",$connect);
	$array = mysql_fetch_array($temp);
	$supplier_C_power = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='depreciation' ",$connect);
	$array = mysql_fetch_array($temp);
	$depreciation = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='housing_cost' ",$connect);
	$array = mysql_fetch_array($temp);
	$housing_cost = $array[0];
	
	$temp = mysql_query("Select `money2` From `correspondence` where `name`='current_people' ",$connect);
	$array = mysql_fetch_array($temp);
	$finance_salary = $array[0];
	
	$temp = mysql_query("Select `money` From `correspondence` where `name`='current_people_2' ",$connect);
	$array = mysql_fetch_array($temp);
	$sale_salary = $array[0];
	
	$temp = mysql_query("Select `money3` From `correspondence` where `name`='current_people_2' ",$connect);
	$array = mysql_fetch_array($temp);
	$research_salary = $array[0];
	
	$temp = mysql_query("Select `money2` From `correspondence` where `name`='current_people_2' ",$connect);
	$array = mysql_fetch_array($temp);
	$human_salary = $array[0];
	
	$temp = mysql_query("Select `money3` From `correspondence` where `name`='current_people' ",$connect);
	$array = mysql_fetch_array($temp);
	$equip_salary = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='finan_load' ",$connect);
	$array = mysql_fetch_array($temp);
	$finan_load = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='sale_load' ",$connect);
	$array = mysql_fetch_array($temp);
	$sale_load = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='research_load' ",$connect);
	$array = mysql_fetch_array($temp);
	$research_load = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='human_load' ",$connect);
	$array = mysql_fetch_array($temp);
	$human_load = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='detect_cost' ",$connect);
	$array = mysql_fetch_array($temp);
	$detect_cost = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='Capacity_detect1' ",$connect);
	$array = mysql_fetch_array($temp);
	$Capacity_detect1 = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='Capacity_detect2' ",$connect);
	$array = mysql_fetch_array($temp);
	$Capacity_detect2 = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='company_image_ratio_A' ",$connect);
	$array = mysql_fetch_array($temp);
	$company_image_ratio_A = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='company_image_ratio_B' ",$connect);
	$array = mysql_fetch_array($temp);
	$company_image_ratio_B = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='customer_satisfaction_ratio_A' ",$connect);
	$array = mysql_fetch_array($temp);
	$customer_satisfaction_ratio_A = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='customer_satisfaction_ratio_B' ",$connect);
	$array = mysql_fetch_array($temp);
	$customer_satisfaction_ratio_B = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='price_ratio_A' ",$connect);
	$array = mysql_fetch_array($temp);
	$price_ratio_A = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='price_ratio_B' ",$connect);
	$array = mysql_fetch_array($temp);
	$price_ratio_B = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='quality_ratio_A' ",$connect);
	$array = mysql_fetch_array($temp);
	$quality_ratio_A = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='quality_ratio_B' ",$connect);
	$array = mysql_fetch_array($temp);
	$quality_ratio_B = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='pp_monitor' ",$connect);
	$array = mysql_fetch_array($temp);
	$pp_monitor = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='pp_kernel' ",$connect);
	$array = mysql_fetch_array($temp);
	$pp_kernel = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='pp_keyboard' ",$connect);
	$array = mysql_fetch_array($temp);
	$pp_keyboard = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='pp_check_s' ",$connect);
	$array = mysql_fetch_array($temp);
	$pp_check_s = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='pp_check' ",$connect);
	$array = mysql_fetch_array($temp);
	$pp_check = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='monitor' ",$connect);
	$array = mysql_fetch_array($temp);
	$monitor = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='kernel' ",$connect);
	$array = mysql_fetch_array($temp);
	$kernel = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='keyboard' ",$connect);
	$array = mysql_fetch_array($temp);
	$keyboard = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='cut' ",$connect);
	$array = mysql_fetch_array($temp);
	$cut = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='combine1' ",$connect);
	$array = mysql_fetch_array($temp);
	$combine1 = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='combine2' ",$connect);
	$array = mysql_fetch_array($temp);
	$combine2 = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='check_s' ",$connect);
	$array = mysql_fetch_array($temp);
	$check_s = $array[0];
	
	$temp = mysql_query("Select `value` From `parameter_description` where `name`='check' ",$connect);
	$array = mysql_fetch_array($temp);
	$check = $array[0];
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ABC參數設定</title>
<script type="text/javascript" src="abc_main/js/jquery.js"></script>

</head>

<body>
<div id="tittle" align="center" style="font-size:30px">Activity Based Costing Simulation System 參數設定</div>
<hr />
<div id="table1">
<table width="750" border="0" cellpadding="10" align="center">
<!--
  <tr>
    <th scope="col" align="center">&nbsp;</th>
    <th scope="col" align="center">&nbsp;</th>
    <th scope="col" align="center">&nbsp;</th>
    <th scope="col" align="center">&nbsp;</th>
  </tr>
-->
  <tr>
    <td align="center">筆電佔市場總比例</td><!--會變-->
    <td align="center"><input id="product_A_size_ratio" value="<?php echo $product_A_size_ratio ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">平板佔市場總比例</td><!--會變-->
    <td align="center"><input id="product_B_size_ratio" value="<?php echo $product_B_size_ratio ?>"
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">供應商A瑕疵率</td><!--會變-->
    <td align="center"><input id="supplierA_flaw" value="<?php echo $supplierA_flaw ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">供應商A供貨量</td>
    <td align="center"><input id="supplier_A_power" value="<?php echo $supplier_A_power ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">供應商B瑕疵率</td><!--會變-->
    <td align="center"><input id="supplierB_flaw" value="<?php echo $supplierB_flaw ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">供應商B供貨量</td>
    <td align="center"><input id="supplier_B_power" value="<?php echo $supplier_B_power ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">供應商C瑕疵率</td><!--會變-->
    <td align="center"><input id="supplierC_flaw" value="<?php echo $supplierC_flaw ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">供應商C供貨量</td>
    <td align="center"><input id="supplier_C_power" value="<?php echo $supplier_C_power ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">機具折舊所需月數</td>
    <td align="center"><input id="depreciation" value="<?php echo $depreciation ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">倉儲成本</td><!--會變-->
    <td align="center"><input id="housing_cost" value="<?php echo $housing_cost ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">合成檢測機具負荷(每單位)</td>
    <td align="center"><input id="Capacity_detect1" value="<?php echo $Capacity_detect1 ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">精密檢測機具負荷(每單位)</td>
    <td align="center"><input id="Capacity_detect2" value="<?php echo $Capacity_detect2 ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">公司形象比重(產品A)</td>
    <td align="center"><input id="company_image_ratio_A" value="<?php echo $company_image_ratio_A ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">公司形象比重(產品B)</td>
    <td align="center"><input id="company_image_ratio_B" value="<?php echo $company_image_ratio_B ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr><tr>
    <td align="center">顧客滿意度比重(產品A)</td>
    <td align="center"><input id="customer_satisfaction_ratio_A" value="<?php echo $customer_satisfaction_ratio_A ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">顧客滿意度比重(產品B)</td>
    <td align="center"><input id="customer_satisfaction_ratio_B" value="<?php echo $customer_satisfaction_ratio_B ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">價格比重(產品A)</td>
    <td align="center"><input id="price_ratio_A" value="<?php echo $price_ratio_A ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">價格比重(產品B)</td>
    <td align="center"><input id="price_ratio_B" value="<?php echo $price_ratio_B ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">品質比重(產品A)</td>
    <td align="center"><input id="quality_ratio_A" value="<?php echo $quality_ratio_A ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">品質比重(產品B)</td>
    <td align="center"><input id="quality_ratio_B" value="<?php echo $quality_ratio_B ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">財務人員薪水</td>
    <td align="center"><input id="finance_salary" value="<?php echo $finance_salary ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">略過檢料瑕疵率(面板)</td>
    <td align="center"><input id="pp_monitor" value="<?php echo $pp_monitor ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">行銷人員薪水</td>
    <td align="center"><input id="sale_salary" value="<?php echo $sale_salary ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">略過檢料瑕疵率(核心)</td>
    <td align="center"><input id="pp_kernel" value="<?php echo $pp_kernel ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">研發團隊薪水(每人)</td>
    <td align="center"><input id="research_salary" value="<?php echo $research_salary ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">略過檢料瑕疵率(鍵盤)</td>
    <td align="center"><input id="pp_keyboard" value="<?php echo $pp_keyboard ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">人力資源人員薪水</td>
    <td align="center"><input id="human_salary" value="<?php echo $human_salary ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">略過合成檢測瑕疵率</td>
    <td align="center"><input id="pp_check_s" value="<?php echo $pp_check_s ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">運籌生產人員薪水</td>
    <td align="center"><input id="equip_salary" value="<?php echo $equip_salary ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">略過精密檢測瑕疵率</td>
    <td align="center"><input id="pp_check" value="<?php echo $pp_check ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">檢料瑕疵率(面板)</td>
    <td align="center"><input id="monitor" value="<?php echo $monitor ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">組合1瑕疵率</td>
    <td align="center"><input id="combine1" value="<?php echo $combine1 ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">檢料瑕疵率(核心)</td>
    <td align="center"><input id="kernel" value="<?php echo $kernel ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">組合2瑕疵率</td>
    <td align="center"><input id="combine2" value="<?php echo $combine2 ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">檢料瑕疵率(鍵盤)</td>
    <td align="center"><input id="keyboard" value="<?php echo $keyboard ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">合成檢測瑕疵率</td>
   <td align="center"><input id="check_s" value="<?php echo $check_s ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
    <td align="center">切割瑕疵率</td>
    <td align="center"><input id="cut" value="<?php echo $cut ?>" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">精密檢測瑕疵率</td>
    <td align="center"><input id="check" value="<?php echo $check ?>" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  <tr>
     <td align="center">檢料費用(每單位)</td><!--每單位原料所需檢料費用-->
    <td align="center"><input id="detect_cost" value="<?php echo $detect_cost ?>" 
    					align="middle" style="text-align:center"/></td>
    
  </tr>
  <tr>
    <td align="center"></td>
    <td align="center"><input id="submit" width="100" height="50" type="image" src="abc_main/images/CP_Submit.png" /></td>
    <td align="center"><input id="Default" width="100" height="50" type="image" src="abc_main/images/CP_Default.png"/></td>
    <td align="center"><input id="Claer" width="100" height="50" type="image" src="abc_main/images/CP_Clear.png"/></td>
  </tr>
  <!--空殼：加新列直接複製用
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center"><input id="" value="" 
    					align="middle" style="text-align:center"/></td>
    <td align="center">&nbsp;</td>
    <td align="center"><input id="" value="" 
    					align="middle" style="text-align:center"/></td>
  </tr>
  -->
</table>
</div>


<div id="button" align="center">


</div>

</body>
</html>
<!--script放在table前會造成跑script時  table內還是null  無法讀值-->
<script type="text/javascript">
	
	$("#submit").click(function(){
		alert("開始save");
		
		var product_A_size_ratio , product_B_size_ratio = 0;
		var supplierA_flaw , supplierB_flaw , supplierC_flaw = 0;
		var supplier_A_power , supplier_B_power , supplier_C_power = 0;
		var depreciation , housing_cost , detect_cost = 0;
		var finance_salary , sale_salary , research_salary , human_salary , equip_salary = 0;
		var Capacity_detect1 , Capacity_detect2 = 0;
		var company_image_ratio_A , customer_satisfaction_ratio_A , price_ratio_A , quality_ratio_A = 0;
		var company_image_ratio_B , customer_satisfaction_ratio_B , price_ratio_B , quality_ratio_B = 0;
		var monitor , kernel , keyboard , cut , combine1 , combine2 , check_s , check = 0;
		var pp_monitor , pp_kernel , pp_keyboard , pp_check_s , pp_check = 0;
		
		
		product_A_size_ratio = document.getElementById("product_A_size_ratio").value;
		product_B_size_ratio = document.getElementById("product_B_size_ratio").value;
		supplierA_flaw = document.getElementById("supplierA_flaw").value;
		supplierB_flaw = document.getElementById("supplierB_flaw").value;
		supplierC_flaw = document.getElementById("supplierC_flaw").value;
		supplier_A_power = document.getElementById("supplier_A_power").value;
		supplier_B_power = document.getElementById("supplier_B_power").value;
		supplier_C_power = document.getElementById("supplier_C_power").value;
		depreciation = document.getElementById("depreciation").value;
		housing_cost = document.getElementById("housing_cost").value;
		detect_cost = document.getElementById("detect_cost").value;
		finance_salary = document.getElementById("finance_salary").value;
		sale_salary = document.getElementById("sale_salary").value;
		research_salary = document.getElementById("research_salary").value;
		human_salary = document.getElementById("human_salary").value;
		equip_salary = document.getElementById("equip_salary").value;
		Capacity_detect1 = document.getElementById("Capacity_detect1").value;
		Capacity_detect2 = document.getElementById("Capacity_detect2").value;
		company_image_ratio_A = document.getElementById("company_image_ratio_A").value;
		company_image_ratio_B = document.getElementById("company_image_ratio_B").value;
		customer_satisfaction_ratio_A = document.getElementById("customer_satisfaction_ratio_A").value;
		customer_satisfaction_ratio_B = document.getElementById("customer_satisfaction_ratio_B").value;
		price_ratio_A = document.getElementById("price_ratio_A").value;
		price_ratio_B = document.getElementById("price_ratio_B").value;
		quality_ratio_A = document.getElementById("quality_ratio_A").value;
		quality_ratio_B = document.getElementById("quality_ratio_B").value;
		monitor = document.getElementById("monitor").value;
		kernel = document.getElementById("kernel").value;
		keyboard = document.getElementById("keyboard").value;
		cut = document.getElementById("cut").value;
		combine1 = document.getElementById("combine1").value;
		combine2 = document.getElementById("combine2").value;
		check_s = document.getElementById("check_s").value;
		check = document.getElementById("check").value;
		pp_monitor = document.getElementById("pp_monitor").value;
		pp_kernel = document.getElementById("pp_kernel").value;
		pp_keyboard = document.getElementById("pp_keyboard").value;
		pp_check_s = document.getElementById("pp_check_s").value;
		pp_check = document.getElementById("pp_check").value;
		
		
		$.ajax({
			url:"Parameter_DB.php",
			type:"GET",
			dataType:"html",
			data:"type=A&product_A_size_ratio="+product_A_size_ratio+"&product_B_size_ratio="+product_B_size_ratio+"&supplier_A_power="+supplier_A_power+"&supplier_B_power="+supplier_B_power+"&supplier_C_power="+supplier_C_power+"&depreciation="+depreciation+"&supplierA_flaw="+supplierA_flaw+"&supplierB_flaw="+supplierB_flaw+"&supplierC_flaw="+supplierC_flaw+"&housing_cost="+housing_cost+"&detect_cost="+detect_cost+"&finance_salary="+finance_salary+"&sale_salary="+sale_salary+"&research_salary="+research_salary+"&human_salary="+human_salary+"&equip_salary="+equip_salary+"&Capacity_detect1="+Capacity_detect1+"&Capacity_detect2="+Capacity_detect2+"&company_image_ratio_A="+company_image_ratio_A+"&company_image_ratio_B="+company_image_ratio_B+"&customer_satisfaction_ratio_A="+customer_satisfaction_ratio_A+"&customer_satisfaction_ratio_B="+customer_satisfaction_ratio_B+"&price_ratio_A="+price_ratio_A+"&price_ratio_B="+price_ratio_B+"&quality_ratio_A="+quality_ratio_A+"&quality_ratio_B="+quality_ratio_B+"&monitor="+monitor+"&kernel="+kernel+"&keyboard="+keyboard+"&cut="+cut+"&combine1="+combine1+"&combine2="+combine2+"&check_s="+check_s+"&check="+check+"&pp_monitor="+pp_monitor+"&pp_kernel="+pp_kernel+"&pp_keyboard="+pp_keyboard+"&pp_check_s="+pp_check_s+"&pp_check="+pp_check
			
			,
			error: function(){
				alert("Save fail");
			},
			success:function(){
				alert("Save success!");
				location.href=('./Parameter_Set.php');
			}
		});
	});
	
	
	$("#Default").click(function(){
		$.ajax({
			url:"Parameter_DB.php",
			type:"GET",
			dataType:"html",
			data:"type=B"
			
			,
			error: function(){
				alert("Set fail");
			},
			success:function(){
				alert("Set success!");
				location.href=('./Parameter_Set.php');
			}
		});
	});
	
	$("#Claer").click(function(){
		$.ajax({
			url:"Parameter_DB.php",
			type:"GET",
			dataType:"html",
			data:"type=C"
			
			,
			error: function(){
				alert("Set fail");
			},
			success:function(){
				alert("Set success!");
				location.href=('./Parameter_Set.php');
			}
		});
	});

</script>
