<?php session_start();?>
<?php
function report($name,$type,$month){
	$args=array("operating"=>"營業活動現金流量", "operating_netin"=>"營業活動淨現金流入", 
		"sales_income"=>"銷貨收入收現", "purchase_product"=>"進貨付現",
		"operating_exp"=>"營業費用付現", "other_exp"=>"其他費用付現", "income_tax"=>"所得稅付現", "interest"=>"利息付現",
		"investing"=>"投資活動", "investing_netin"=>"投資活動淨現金流入",
		"assets_purchase"=>"購買不動產、廠房設備付現數","assets_sale"=>"出售不動產、廠房設備收現數",
		"financing"=>"籌資活動", "financing_netin"=>"籌資活動淨現金流入",
		"supplier_bonus"=>"支付供應商紅利", "empolyee_bonus"=>"支付員工福利",
		"short_pay"=>"短期借款新增(償還)", "long_pay"=>"長期借款新增(償還)",
		"cash_increase"=>"現金增資", "dividend"=>"發放現金股利", "treasury"=>"買回庫藏股",
		"current_cash_change"=>"本期現金增減數", "cash_balance_last"=>"加:期初現金及約當現金餘額",
		"cash_balance_now"=>"現金及約當現金期末餘額");

	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	$connect2=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	$connect3=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main",$connect);
    mysql_query("set names 'utf8'");
	
	global $count;//全域變數，"＄"專用
        $bgcolor=0;
        $last_month=0;
	$count=0;
	$change=0;
	$s_sum=array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"","6"=>"","7"=>"","8"=>"","9"=>"","10"=>"","11"=>"");//小結
	$t_sum=array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"","6"=>"","7"=>"","8"=>"","9"=>"","10"=>"","11"=>"");//最後總total
	$price_sum=0;
	$temp=0;
	$i=0;//多功能計數器...
	$round;
	$u=0;
	
	$detect_month=mysql_query("SELECT `month` FROM cash_balance_last WHERE `cid`='$name' order by `index` ,`month`",$connect);
	while($detect_array=mysql_fetch_array($detect_month))
		$last_month=MAX($detect_array);
	//echo $last_month;
	echo "<table cellspacing='0' class='ytable'>";//cellspacing去掉表格間的隔線
	echo "<thead><tr align='center'><td colspan='12'><b>現金流量表</b></td></tr></thead>";
	echo "<tr align='center'><td></td>";//最左上角的空格以及回合數置中
	if($type==1){//判斷報表種類
		$round=$month*3;
		if($last_month<$round)
			$month=(int)(($last_month-9)/3)+3;
		$query_command=	"`cid`='$name' and `month`>('$month'-1)*3 and `month`<=(9+'$month'*3) order by `index` ,`month`";
		$round=9+$month*3;
		for($i=($month-1)*3+1;$i<=$round;$i++){
			if($i%12==1){
				$y=(int)($i/12)+1;
				echo "<td style='border-right:0px'><b>第 ".$y." 年</b></td>";
			}
			else 
				echo "<td style='border-left:0px; border-right:0px'></td>";
		}
		echo "<thead><tr align='center'><th></th>";
		for($i=($month-1)*3+1;$i<=$round;$i++){
			$j=$i;
			if($i>11)
				$j=$i%12;
			if($j==0)
				$j=12;
			echo "<th width='60'><b>".$j." 月</b></th>";
		}
		echo "</tr></thead>";
		//$sum=12;
	}
	elseif($type==2){
		$round=(6+$month*6)/3;
		$last_season=(int)($last_month/3);
		if($last_season<$round)
			$month=(int)($last_month/6);

		$query_command="`cid`= '$name' AND (`month` > ($month-1)*6 AND `month` <= 6+$month*6) ORDER BY `index` ,`month`";
		$round=(6+$month*6)/3;
		if($round<4)
			$round=4;
		for($i=$round-3;$i<=$round;$i++){
			if($i%4==1){
				$y=(int)($i/4)+1;
				echo "<td style='border-right:0px'><b>第 ".$y." 年</b></td>";
			}
			else if($i%4==0)
				echo "<td style='border-left:0px;'></td>";
			else
				echo "<td style='border-left:0px; border-right:0px'></td>";
		}
		echo "<thead><tr align='center'><th></th>";
		for($i=$round-3;$i<=$round;$i++){
			$j=$i;
			if($i>4)
				$j=$i%4;
			if($j==0)
				$j=4;
			echo "<th width='210'><b>第 ".$j." 季</b></th>";
		}
		echo "</tr></thead>";
		//$sum=4;
	}
	elseif($type==3){
		$round=(24+$month*24)/12+1;
		$last_year=(int)($last_month/12);
		if($last_year<$round){
			if($last_year<=5){
				$month=1;
			}
			else{
				$month=$last_year;    //上一年
			}
		}				
		$query_command="`cid`= '$name' AND (`month` > 12*('$month'-1) AND `month` <= 12*('$month'+4)) ORDER BY `index` ,`month`";
		$round=(24+$month*24)/12+1;
		//echo $last_year.":".$round;
		for($i=$round-4;$i<=$round;$i++)
			echo "<td width='166'><b>第 ".$i." 年</b></td>";
		//$sum=5;
	}
	$first=mysql_query("SELECT * FROM cashflow ORDER BY `index`",$connect);
	while($title_b=mysql_fetch_array($first)){
		if($bgcolor%2==0)//交錯的底色(0,1互換)
			$bgc_string="class='odd'";
		else $bgc_string="";
		echo "<tr ".$bgc_string." align='right'><td align='left'><b>".$args["$title_b[title]"]."</b></td>";
		$bgcolor++;
		if($title_b['title']=="current_cash_change" or $title_b['title']=="cash_balance_last" or $title_b['title']=="cash_balance_now"){
			$change = 1;//若大標是最後三項則跳過搜尋中標
			if($title_b['title']!="cash_balance_last"){//不是上期餘額則print出$t_sum
				$count=0;
				for($i=0;$i<$round;$i++)
					//if($t_sum[$i]!=0)
						print_price($t_sum[$i],1,0);
				$i=0;
				$count+=1;
			}
			else{//若是上期餘額則從資料庫搜尋
				$final=mysql_query("SELECT * FROM $title_b[title] WHERE ".$query_command,$connect3);
				while($title_s=mysql_fetch_array($final)){//要搜尋、有price欄位的都用$title_s
					$i++;//每get一個數值就+1
					$j=$i;
					$tag=0;//縮短程式碼用
					if($type==1){
						$price_sum+=$title_s['price'];
						$j=$i;
						$tag=1;
					}
					elseif($type==2){
						if($i%3==1)
							$price_sum=$title_s['price'];
						elseif($i%3==0){
							$j=$i/3;
							$tag=1;
						}
					}
					elseif($type==3){
						if($i%12==1)
							$price_sum=$title_s['price'];
						elseif($i%12==0){
							$j=$i/12;
							$tag=1;
						}
					}
					if($tag==1){
						$j--;//"/="會無條件進位，故-1
						$s_sum[$j]+=$price_sum;
						$t_sum[$j]+=$s_sum[$j];
						$s_sum[$j]="";
						print_price($price_sum,1,1);
						$price_sum="";
					}
				}
			}
		}
		else{
			if($type==1){
				for($i=0;$i<$last_month-($month-1)*3;$i++){//大標後的空格
					if($i>11)
						break;
					if($i==($last_month-1))
						echo "<td style='border-left:0px;'></td>";	
					else
						echo "<td style='border-left:0px; border-right:0px'></td>";	
				}
			}else if($type==2){
				for($i=0;$i<$last_season-($month-1)*2;$i++){//大標後的空格
					if($i>3)
						break;
					if($i==($last_season-1))
						echo "<td style='border-left:0px;'></td>";	
					else
						echo "<td style='border-left:0px; border-right:0px'></td>";	
				}
			
			}else if($type==3){
				for($i=0;$i<$last_year-($month-1)*1;$i++){//大標後的空格
					if($i>4)     //5格
						break;
					if($i==($last_year-1))
						echo "<td style='border-left:0px;'></td>";	     
					else
						echo "<td style='border-left:0px; border-right:0px'></td>";	
				}
			
			}
			$change=0;
		}
		if($change==0){//搜尋中標
			$middle=mysql_query("SELECT * FROM $title_b[title] ORDER BY `index`",$connect2);
			while($title_m=mysql_fetch_array($middle)){
				$final=mysql_query("SELECT * FROM $title_m[title] WHERE ".$query_command,$connect3);
				$i=0;
				while($title_s=mysql_fetch_array($final)){
					if($temp!=$title_s['index']){//判斷科目是否換了
						if($bgcolor%2==0)//要echo科目時都要換色
							$bgc_string="class='odd'";
						else $bgc_string="";
						//細體字(小標)
						echo "<tr ".$bgc_string." align='right'><td align='left'>".$args["$title_s[name]"]."</td>";
						$i=0;
						$bgcolor++;
						$price_sum="";
					}
					if($title_s['name']=="income_tax" or $title_s['name']=="assets_sale" or $title_s['name']=="dividend")
						$u=1;//判斷是否底線
					if($title_s['name']=="sales_income")
						$count=0;//"＄"
					else $count=1;
					$temp=$title_s['index'];
					$price_sum+=$title_s['price'];
					$i++;
					$tag=0;
					if($type==1){
						$j=$i;
						$tag=1;
					}
					elseif($type==2 and $i%3==0){
						$j=$i/3;
						$tag=1;
					}
					elseif($type==3 and $i%12==0){
						$j=$i/12;
						$tag=1;
					}
					if($tag==1){
						$j--;
						print_price($price_sum,1,$u);
						$s_sum[$j]+=$price_sum;
						$price_sum="";
					}
					$u=0;
				}
				if($bgcolor%2==0)//print完小標後才換中標
					$bgc_string="class='odd'";//B4EEB4'";
				else $bgc_string="";
				//中標
				
				echo "<tr ".$bgc_string." align='right'><td align='left'><b>".$args["$title_m[title]"]."</b></td>";//之後才print netin
				$bgcolor++;
				if($title_s['price']=="")
					for($j=$j+1;$j<$round;$j++){
						$s_sum[$j]="";
						$t_sum[$j]="";
					}
				if($type==1){
					for($i=0;$i<$last_month-($month-1)*3;$i++){
						if($i>11)
							break;
						print_price($s_sum[$i],1,0);
						if($s_sum[$i]!="")
							$t_sum[$i]+=$s_sum[$i];
						$s_sum[$i]="";
					}
				}else if($type==2){
					for($i=0;$i<$last_season-($month-1)*2;$i++){
						if($i>3)
							break;
						print_price($s_sum[$i],1,0);
						if($s_sum[$i]!="")
							$t_sum[$i]+=$s_sum[$i];
						$s_sum[$i]="";
					}
				}else if($type==3){
					for($i=0;$i<$last_year-($month-1)*1;$i++){   //三大活動現金流入
						if($i>4)
							break;
						print_price($s_sum[$i],1,0);
						if($s_sum[$i]!="")
							$t_sum[$i]+=$s_sum[$i];   
						$s_sum[$i]="";
					}
				}
				$change=1;
			}
		}
	}
	echo "</table>";
	mysql_close($connect);
	mysql_close($connect2);
	mysql_close($connect3);
}
function print_price($num,$place,$underline){//$place判斷左右欄(最新版似乎用不到...code也都變了...)
	global $count;
	$echo_string1="";
	$echo_string2="";
	if($num=="")
		$count=1;
	if($num<0){//判斷+-號
		$echo_string1="(";
		$echo_string2=")";
		$num=$num*(-1);
	}
	//else $echo_string=number_format($num);
	if($underline==1){
		$echo_string1="<u>".$echo_string1;
		$echo_string2=$echo_string2."</u>";
	}
	if($place==1){
		if($count==0)
			$echo_string1="$".$echo_string1;
		$echo_string1="<td>".$echo_string1;//"<td>&nbsp&nbsp&nbsp".$echo_string."</td>";
		$echo_string2=$echo_string2."</td>";
	}
	echo $echo_string1.number_format($num).$echo_string2;
}
report($_SESSION['cid'],$_POST['type'],$_POST['month']);
?>