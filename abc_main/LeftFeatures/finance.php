<?php
session_start();
	function report($cid, $type, $month) {
		$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
		//$enu = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
		//$obj = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());

		$change = 0; //總標題用，不須變動
		$flag = 1;
		$args = array(//資料庫用變數
			"fixed_assets" => "非流動資產", "141" => "不動產、廠房及設備", "142" => "減：累計折舊",
			"current_assets" => "流動資產", "115" => "遞延所得稅資產", "117" => "其它流動資產", "112" => "應收票據", "113" => "應收帳款與其它應收款", "114" => "存貨", "111" => "現金、約當現金",
			"equity" => "權益", "31" => "普通股股本", "32" => "資本公積-股本溢價", "35" => "保留盈餘", "33" => "庫藏股",
			"long-term_liabilities" => "非流動負債", "232" => "其他非流動負債", "216" => "應付所得稅", "212" => "長期借款",
			"current_liabilities" => "流動負債", "211" => "短期借款", "213215" => "應付帳款與其他應付款", "214" => "其他流動負債");
		
		$sum_temp = array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, "10" => 0, "11" => 0, "12" => 0);
		$sum_liabilities = array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, "10" => 0, "11" => 0, "12" => 0);
		$sum_equity = array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, "10" => 0, "11" => 0, "12" => 0);
		$sum_asset = array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, "10" => 0, "11" => 0, "12" => 0);
        $end_tip=0;

		echo "<table style='text-align:right' cellspacing='0' cellpadding='0' class='ytable'>";
		echo "<thead><tr align='center'><td colspan='12'><b>財務狀況表</b></td></tr></thead>";

		mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
		$result = mysql_query("SELECT * FROM `financial_position` ORDER BY `index`", $connect);
		while ($row = mysql_fetch_array($result)) {
			//mysql_select_db($row['title'], $connect);//$enu);
			$fin = mysql_query("SELECT MAX(`month`) FROM `$row[title]` WHERE `cid` = '$cid'", $connect);//$enu);
			$temp = mysql_fetch_array($fin);
			$end_tip = $temp[0];
			/*while ($rowl = mysql_fetch_array($fin)) {
				$end_tip = max($rowl);
			}*/
		}
		$end_tip2 = intval($end_tip / 3);
		$end_tip3 = intval($end_tip / 12);

		if ($type == 1) {
			$start_p = 3 * $month - 2;
			if ($start_p >= $end_tip) {
				$start_p = $end_tip;
			}
			$end_p = $start_p + 11;
		} elseif ($type == 2) {
			$start_p = 2 * $month - 1;
			if ($start_p >= $end_tip2) {
				$start_p = $end_tip2;
				if($start_p==0){
					//等待你處理
				}else{
					if (($start_p % 2) == 0) {
					$start_p = $start_p - 1;
				}
				}
			}
			$end_p = $start_p + 3;
		} elseif ($type == 3) {
			$start_p = $month;
			if ($start_p >= $end_tip3) {
				$start_p = $end_tip3;
				if($start_p==0){
					//等待你處理
				}
			}
			$end_p = $start_p + 4;
		}

		echo "<tr>";
		echo "<td>&nbsp</td>";
		if ($type == 1) {
			$s_year = intval($start_p / 12) + 1;
			for ($j = $start_p; $j <= $end_p; $j++) {
				if ($j == $start_p) {
					echo "<td style='border-right:0px'><b>第 ".$s_year." 年</b></td>";
					$s_year = $s_year + 1;
				} elseif (($j % 12) == 1 & $j != $start_p) {
					echo "<td style='border-right:0px'><b>第 ".$s_year." 年</b></td>";
					$s_year = $s_year + 1;
				} else {
					echo "<td style='border-left:0px; border-right:0px'></td>";
				}
			}
			echo "</tr>";
			echo "<thead><tr><th width='98'>&nbsp;&nbsp;&nbsp;&nbsp;</th>";
			for ($i = $start_p; $i <= $end_p; $i++) {
				if (($i % 12) == 0) {
					echo "<th width='68'>12 月</th>";
				} else {
					echo "<th width='68'>" . $i % 12 . " 月</th>";
				}
			}
			echo "</tr></thead>";
		} elseif ($type == 2) {

			$s_year = intval($start_p / 4) + 1;
			for ($j = $start_p; $j <= $end_p; $j++) {
				if ($j == $start_p) {
					echo "<td  width=250 style='border-right:0px'><b>第 ".$s_year." 年</b></td>";
					$s_year = $s_year + 1;
				} elseif (($j % 4) == 1 && $j != $start_p) {
					echo "<td  width=250 style='border-right:0px'><b>第 ".$s_year." 年</b></td>";
					$s_year = $s_year + 1;
				} else {
					echo "<td width=250 style='border-left:0px; border-right:0px'></td>";
				}
			}
			echo "<tr>";
			echo "<thead><tr><th width='98'>&nbsp;&nbsp;&nbsp;&nbsp;</th>";
			for ($i = $start_p; $i <= $end_p; $i++) {
				if (($i % 4) == 0) {
					echo "<th>第 " . 4 . " 季</th>";
				} else {
					echo "<th>第 " . $i % 4 . " 季</th>";
				}
			}
			echo "</tr></thead>";
		} elseif ($type == 3) {

			for ($i = $start_p; $i <= $end_p; $i++) {
				echo "<td  width=216>第" . $i . "年</td>";
			}
		}//end 顯示時間
		//mysql_select_db("report_2", $connect);
		$result = mysql_query("SELECT * FROM `financial_position` ORDER BY `index`", $connect);

		while ($row = mysql_fetch_array($result)) {//標題 資產 權益與負債
			if ($row['title'] == "equity" | $row['title'] == "current_liabilities" | $row['title'] == "long-term_liabilities") {
				if ($change == 2) {
					$change = 1;
				}
			}
			//echo $end_p."@".$end_tip."@".$change."@".$flag."</br>";
			if ($change == 0) {
				if ($flag == 0) {
					echo "<tr style='background:floralwhite'><td style='text-align:left'><b>資產</b></td>";
					if ($type == 1) {
						$suit = min($end_p, $end_tip);
					} elseif ($type == 2) {
						$suit = min($end_p, $end_tip2);
					} elseif ($type == 3) {
						$suit = min($end_p, $end_tip3);
					}
					for ($i = $start_p; $i <= $suit; $i++) {
						echo"<td></td>";
					}
					echo "</tr>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>資產</b></td>";
					if ($type == 1) {
						$suit = min($end_p, $end_tip);
					} elseif ($type == 2) {
						$suit = min($end_p, $end_tip2);
					} elseif ($type == 3) {
						$suit = min($end_p, $end_tip3);
					}
					for ($i = $start_p; $i <= $suit; $i++) {
						echo"<td></td>";
					}
					echo "</tr>";
					$flag = 0;
				}
				$change = 2;
			} else if ($change == 1) {
				if ($flag == 0) {
					echo "<tr style='background:floralwhite'><td style='text-align:left'><b>權益與負債</b></td>";
					if ($type == 1) {
						$suit = min($end_p, $end_tip);
					} elseif ($type == 2) {
						$suit = min($end_p, $end_tip2);
					} elseif ($type == 3) {
						$suit = min($end_p, $end_tip3);
					}
					for ($i = $start_p; $i <= $suit; $i++) {
						echo"<td></td>";
					}
					echo "</tr>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<td style='text-align:left'><b>權益與負債</b></td>";
					if ($type == 1) {
						$suit = min($end_p, $end_tip);
					} elseif ($type == 2) {
						$suit = min($end_p, $end_tip2);
					} elseif ($type == 3) {
						$suit = min($end_p, $end_tip3);
					}
					for ($i = $start_p; $i <= $suit; $i++) {
						echo"<td></td>";
					}
					echo "<tr></tr>";
					$flag = 0;
				}
				$change = 3;
			}//end 標題 資產 權益與負債

			if ($flag == 0) {
				echo "<tr class='odd'><td style='text-align:left'><b>" . $args["$row[title]"] . "</b></td>";
				if ($type == 1) {
					$suit = min($end_p, $end_tip);
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2);
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3);
				}
				for ($i = $start_p; $i <= $suit; $i++) {
					echo"<td></td>";
				}
				echo"</tr>";
				$flag = 1;
			} elseif ($flag == 1) {
				echo "<tr><td style='text-align:left'><b>" . $args["{$row['title']}"] . "</b></td>";
				if ($type == 1) {
					$suit = min($end_p, $end_tip);
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2);
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3);
				}
				for ($i = $start_p; $i <= $suit; $i++) {
					echo"<td></td>";
				}
				echo"</tr>";
				$flag = 0;
			}
			//mysql_select_db($row['title'], $obj);
			$final = mysql_query("SELECT * FROM `$row[title]` WHERE `cid` = '$cid'  ORDER BY `index`, `month`", $connect);//$obj);
			while ($sub = mysql_fetch_array($final)) {
				if ($sub['month'] == $start_p) {
					$count = 0;
					if ($flag == 0) {
						echo "<tr class='odd'><td style='text-align:left'>" . $args["{$sub['name']}"] . "</td>";
						$flag = 1;
					} else if ($flag == 1) {
						echo "<tr><td style='text-align:left'>" . $args["{$sub['name']}"] . "</td>";
						$flag = 0;
					}
				}
				if ($type == 1) {
					for ($i = $start_p; $i <= $end_p; $i++) {
						if ($sub['month'] == $i) {
							if ($sub['price'] >= 0) {
								echo "<td>" . number_format($sub['price']) . "</td>";
							} else {
								echo "<td>(" . number_format($sub['price']*(-1)) . ")</td>";
							}
							$sum_temp[$count] = $sum_temp[$count] + $sub['price'];
							$count++;
						}
					}
				} else if ($type == 2) {
					for ($i = $start_p; $i <= $end_p; $i++) {
						$j = $i * 3;
						if ($sub['month'] == $j) {
							if ($sub['price'] >= 0) {
								echo "<td>" . number_format($sub['price']) . "</td>";
							} else {
								echo "<td>(" . number_format($sub['price']*(-1)) . ")</td>";
							}
							$sum_temp[$count] = $sum_temp[$count] + $sub['price'];
							$count++;
						}
					}
				} else if ($type == 3) {
					for ($i = $start_p; $i <= $end_p; $i++) {
						$j = $i * 12;
						if ($sub['month'] == $j) {
							if ($sub['price'] >= 0) {
								echo "<td>" . number_format($sub['price']) . "</td>";
							} else {
								echo "<td>(" . number_format($sub['price']*(-1)) . ")</td>";
							}
							$sum_temp[$count] = $sum_temp[$count] + $sub['price'];
							$count++;
						}
					}
				}
			}//end while
			//sum_handle
			if ($row['title'] == "fixed_assets") {
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>非流動資產總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>非流動資產總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_temp[$i]>= 0) {
						echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_temp[$i]*(-1)) . ")</td>";
					}
					//echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					$sum_asset[$i] = $sum_asset[$i] + $sum_temp[$i];
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_temp[$i] = 0;
				}
				echo "</tr>";
			} else if ($row['title'] == "current_assets") {
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>流動資產總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>流動資產總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_temp[$i]>= 0) {
						echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_temp[$i]*(-1)) . ")</td>";
					}
					//echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					$sum_asset[$i] = $sum_asset[$i] + $sum_temp[$i];
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_temp[$i] = 0;
				}
				echo "</tr>";
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>總資產</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>總資產</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_asset[$i]>= 0) {
						echo "<td><u>$" . number_format($sum_asset[$i]) . "<u></td>";
					} else {
						echo "<td><u>$(" . number_format($sum_asset[$i]*(-1)) . ")<u></td>";
					}
					//echo "<td><u>$" . number_format($sum_asset[$i]) . "<u></td>";
				}
				echo "</tr>";
			} else if ($row['title'] == "equity") {
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>權益總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>權益總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_temp[$i]>= 0) {
						echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_temp[$i]*(-1)) . ")</td>";
					}
					//echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					$sum_equity[$i] = $sum_equity[$i] + $sum_temp[$i];
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_temp[$i] = 0;
				}
				echo "</tr>";
			} else if ($row['title'] == "long-term_liabilities") {
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>非流動負債總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>非流動負債總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_temp[$i]>= 0) {
						echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_temp[$i]*(-1)) . ")</td>";
					}
					//echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					$sum_liabilities[$i] = $sum_liabilities[$i] + $sum_temp[$i];
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_temp[$i] = 0;
				}
				echo "</tr>";
			} else if ($row['title'] == "current_liabilities") {
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>流動負債總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>流動負債總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_temp[$i]>= 0) {
						echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_temp[$i]*(-1)) . ")</td>";
					}
					//echo "<td>" . number_format($sum_temp[$i]) . "</td>";
					$sum_liabilities[$i] = $sum_liabilities[$i] + $sum_temp[$i];
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_temp[$i] = 0;
				}
				echo "</tr>";

				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>總負債</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>總負債</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					if ($sum_liabilities[$i]>= 0) {
						echo "<td>" . number_format($sum_liabilities[$i]) . "</td>";
					} else {
						echo "<td>(" . number_format($sum_liabilities[$i]*(-1)).")</td>";
					}
					//echo "<td>" . number_format($sum_liabilities[$i]) . "</td>";
				}
				if ($flag == 0) {
					echo "<tr class='odd'><td style='text-align:left'><b>權益與負債總額</b></td>";
					$flag = 1;
				} else if ($flag == 1) {
					echo "<tr><td style='text-align:left'><b>權益與負債總額</b></td>";
					$flag = 0;
				}
				if ($type == 1) {
					$suit = min($end_p, $end_tip) - $start_p;
				} elseif ($type == 2) {
					$suit = min($end_p, $end_tip2) - $start_p;
				} elseif ($type == 3) {
					$suit = min($end_p, $end_tip3) - $start_p;
				}
				for ($i = 0; $i <= $suit; $i++) {
					$sum_right[$i] = $sum_equity[$i] + $sum_liabilities[$i];
					if ($sum_right[$i]>= 0) {
						echo "<td><u>$" . number_format($sum_right[$i]) . "</u></td>";
					} else {
						echo "<td><u>$(" . number_format($sum_right[$i]*(-1)) . ")</u></td>";
					}
					//echo "<td><u>$" . number_format($sum_right[$i]) . "</u></td>";
				}
				echo "</tr>";
			}//end sum_handle
		}
		echo "</table><p><p><p>";
		mysql_close($connect);
		//mysql_close($obj);
		//mysql_close($enu);
	}
	report($_SESSION['cid'], mysql_real_escape_string($_POST['type']), mysql_real_escape_string($_POST['month']));
?>
