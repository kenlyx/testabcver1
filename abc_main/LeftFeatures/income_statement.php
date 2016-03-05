<?php session_start();?>
<?php
	function printrow($array,$type,$flag,$j){//一個用來印出列中資料的方法
		for($i=0;$i<$j;$i++){
			if($array[$i]<0)
				echo "<td>(".number_format($array[$i]*(-1)).")</td>";
			else
				echo "<td>".number_format($array[$i])."</td>";
		}
		if($flag==1)//控制下一列的背景色彩
			echo "</tr><tr class='odd'>";
		else
			echo "</tr><tr>";
		$flag*=(-1);
		return $flag;//將控制色彩的變數傳回主程式
	}
	function report($cid,$type,$month){//印出報表的主程式
		$args=array("operating_revenue"=>"營業收入","41"=>"銷貨收入-A產品","42"=>"銷貨收入-B產品",    //用來顯示項目的陣列
		"operating_costs"=>"營業成本","5111"=>"銷貨成本-A產品","5112"=>"銷貨成本-B產品",
		"operating_expenses"=>"營業費用","516"=>"供應商合約費用","512"=>"薪資費用",
		"515"=>"推銷費用","525"=>"管理及總務費用","524"=>"研究發展費用","518"=>"處分資產損失",
		"other_revenue"=>"營業外利益","522"=>"處分資產利益","523"=>"什項收入",
		"other_expenses"=>"營業外費用","7"=>"財務成本","521"=>"什項費用",
		"income_taxes"=>"所得稅費用");
		$sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);  //用來儲存全部加總的陣列
		$s_sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);//用來儲存小項加總的陣列
		$before_tax=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);//用來儲存小項加總的陣列
		$time=array("1"=>"月","2"=>"季","3"=>"年");                       //儲存報表首列印出資料的陣列
		$time0=array("1"=>"","2"=>"第","3"=>"第");
		$change=0;                                                          //控制列為空值的變數，1代表不為空
                $last_month=0;
		$flag=1;                                                            //控制列的背景色彩，1代表有色彩
		$price=0;                                                           //儲存季/年報時單季/年的所有值的加總的變數
		$a=(int)($type*4/3)*3;                                              //輔助運算的變數    為各種報表單次移動所增加的回合數         當$type=1,2,3時,$a=3,6,12
		$b=($type%2)*2+(int)($type/3+1);                                    //輔助運算的變數    加1乘上a之後代表這張報表所有的月數     當$type=1,2,3時,$b=3,1,4
		$c=($type+(int)($type/2)+(int)($type/3)*8);                         //輔助運算的變數    為報表每欄所有的月數                  當$type=1,2,3時,$c=1,3,12     
		$d=12-(int)($type/2)*8+(int)($type/3);                              //輔助運算的變數    為各種報表印出的欄數                    當$type=1,2,3時,$d=12,4,5     
		$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());  //與資料庫進行連結
		$obj=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());      //同上
		mysql_select_db("testabc_main",$connect);
		mysql_query("set names 'utf8'");
		$result=mysql_query("SELECT * FROM income_statement ORDER BY `index`",$connect);
			echo "<table cellspacing='0' class='ytable'>";//cellspacing去掉表格間的隔線
	echo "<thead><tr align='center'><td colspan=13><b>綜合損益表</b></td></tr></thead>";

		while($row=mysql_fetch_array($result)){
			$get_all_month=mysql_query("SELECT `month` FROM $row[title] WHERE `cid`= '$cid'",$obj);
			while($all_month=mysql_fetch_array($get_all_month)){
				$last_month=max($all_month);
			}
			while((int)($last_month/$c)<=($month-1)*(4-$type))                 //判斷此表是否無數值
				$month-=1;
			mysql_select_db($row['title'],$obj);
			$final=mysql_query("SELECT * FROM $row[title] WHERE `cid`= '$cid' AND
					(`month` > '$a'*('$month'-1) AND `month` <= '$a'*('$month'+'$b')) ORDER BY `index` , `month`",$obj);
					
						$stock_result=mysql_query("SELECT stock FROM stock WHERE `cid`= '$cid' AND
								(`report_month` > '$a'*('$month'-1) AND `report_month` <= '$a'*('$month'+'$b')) ORDER BY `report_month`",$obj);
						$i=0;
						$temp=0;
						while($for_stock=mysql_fetch_array($stock_result)){
							$temp+=$for_stock[0]+2000000;
							$stock[$i]=$temp;
							$i++;
						}
						
			$j=min($d,(int)(($last_month-($month-1)*$a)/$c));  //代表印出的資料欄數
			echo "<tr>";	
			if($row['title'] == "operating_revenue"){//大項，主要架構
				echo "<td width='10%'>&nbsp;&nbsp;&nbsp;</td>";
				if($type!=3){
					for($i=0;$i<$d;$i++){
						echo "<td style='text-align:center'>";
						if(($i+(4-$type)*($month-1)+1)%$d==1||$i==0)
							echo "<b>第".((int)(($i+(4-$type)*($month-1)+1)/$d)+1)."年</b></td>";
						else
							echo "</td>";
					}
					if($flag==1)
						echo "</tr><thead><tr class='odd'><th>&nbsp;&nbsp;&nbsp;</th>";
					else
						echo "</tr><thead><tr><th>&nbsp;&nbsp;&nbsp;</th>";
					$flag*=-1;
				}
				for($i=0;$i<$d;$i++){
					echo "<th width = ".(920/$d)." style='text-align:center'>
						<b>".$time0[$type].(($i+(4-$type)*($month-1))%$d+1).$time[$type]."</b></th>";
				}
				if($flag==1)
					echo "</tr></thead><tr class='odd'>";
				else
					echo "</tr></thead><tr>";
				$flag*=-1;
			}
			
			if($flag == 1)
				echo "<tr class='odd'>";
			else
				echo "<tr>";
			$flag*=-1;
			
			if($row['title'] == "operating_costs"){
				$change=0;
				$s_sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);
			}
			if($row['title'] == "operating_expenses"){
				$change=0;
				echo "<td style='text-align:left'><b>營業毛利</b></td>";
				$flag=printrow($sum,$type,$flag,$j);
				$s_sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);
			}
			if($row['title'] == "other_revenue"){
				$change=0;
				echo "<td style='text-align:left'><b>營業費用合計</b></td>";
				$flag=printrow($s_sum,$type,$flag,$j);
				$s_sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);
				echo "<td style='text-align:left'><b>營業淨利</b></td>";
				$flag=printrow($sum,$type,$flag,$j);
			}
			if($row['title'] == "other_expenses"){
				$change=0;
				$s_sum=array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0);
			}
			if($row['title'] == "income_taxes"){
				$change=1;
				echo "<td style='text-align:left'><b>繼續營業部門稅前純益</b></td>";
				$flag=printrow($sum,$type,$flag,$j);
							for($i=0;$i<$j;$i++)
								$before_tax[$i]=$sum[$i];
			}
			if($row['title'] != "finance_costs")
				echo "<td style='text-align:left'><b>".$args["${row['title']}"]."</b></td>";
			else
				echo "<td style='text-align:left'>".$args["${row['title']}"]."</td>";
			if($change==0){
				for($i=0;$i<$j;$i++){
					echo "<td></td>";
				}
			}
			$temp1=0;
			$temp2=0;
			while($sub=mysql_fetch_array($final)){//讀取細項
				if($temp1!=$sub['index']||$temp2!=$row['title'])
					$price=0;
				$temp1=$sub['index'];
				$temp2=$row['title'];
				if($sub['month']%$c==0){
					$price+=$sub['price'];
					if($change == 0){
						if($sub['month']==$a*($month-1)+$c){
							if($flag == 1)
								echo "<tr class='odd'>";
							else
								echo "<tr>";
							$flag*=-1;
							echo "<td style='text-align:left'>".$args["$sub[name]"]."</td>";
						}
					}
					$sum[$sub['month']/$c-(4-$type)*$month+3-$type]+=$price;
					$s_sum[$sub['month']/$c-(4-$type)*$month+3-$type]+=$price;
					if($price<0)
						echo "<td>(".number_format($price*(-1)).")</td>";
					else
						echo "<td>".number_format($price)."</td>";
					$price=0;
				}
				else {
					$price+=$sub['price'];
				}
			}
		}
		if($flag==1)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		echo "<td style='text-align:left'><b>淨利</b></td>";
		for($i=0;$i<$j;$i++){
			if($sum[$i]<0)
				echo "<td>(".number_format($sum[$i]*(-1)).")</td>";
			else
				echo "<td>".number_format($sum[$i])."</td>";
		}
		
				echo "<tr><td>&nbsp</td></tr><tr class='odd'><td style='text-align:left'><b>其他綜合損益</b></td>";
				for($i=0;$i<$j;$i++)
					echo "<td>&nbsp</td>";
				echo "</tr><tr><td style='text-align:left'>匯兌損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr class='odd'><td style='text-align:left'>現金流量避險損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr><td style='text-align:left'>備供出售金融資產評價損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr class='odd'><td style='text-align:left'>不動產重估價損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr><td style='text-align:left'>確定給付辦法損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr class='odd'><td style='text-align:left'>按持股比例認列之關聯企業損益</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr><td style='text-align:left'>其他綜合損益組成要素之所得稅</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>0</td>";
				echo "</tr><tr class='odd'><td style='text-align:left'><b>本期綜合淨利(損)</b></td>";
				for($i=0;$i<$j;$i++){
					if($sum[$i]<0)
						echo "<td>(".number_format($sum[$i]*(-1)).")</td>";
					else
						echo "<td>".number_format($sum[$i])."</td>";
				}
				
				echo "<tr><td>&nbsp</td></tr><tr class='odd'><td style='text-align:left'><b>每股盈餘</b></td>";
				for($i=0;$i<$j;$i++)
					echo "<td>&nbsp</td>";
				echo "</tr><tr><td style='text-align:left'>本期淨利歸屬予母公司普通持有人之基本每股盈餘</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>".number_format($before_tax[$i]/$stock[$i],2)."</td>";
				echo "</tr><tr class='odd'><td style='text-align:left'>本期淨利歸屬予母公司普通持有人之稀釋每股盈餘</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>".number_format($before_tax[$i]/$stock[$i],2)."</td>";
				echo "</tr><tr><td style='text-align:left'><b>繼續營業單位每股盈餘</b></td>";
				echo "</tr><tr class='odd'><td style='text-align:left'>繼續營業單位淨利歸屬予母公司普通股持有人之基本每股盈餘</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>".number_format($sum[$i]/$stock[$i],2)."</td>";
				echo "</tr><tr><td style='text-align:left'>繼續營業單位淨利歸屬予母公司普通股持有人之稀釋每股盈餘</td>";
				for($i=0;$i<$j;$i++)
					echo "<td>".number_format($sum[$i]/$stock[$i],2)."</td>";
				echo "</tr>";
		
		echo "</table>";

		mysql_close($connect);
		mysql_close($obj);
	}
	report($_SESSION['cid'],$_POST['type'],$_POST['month']);
?>