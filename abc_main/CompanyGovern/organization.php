<?php  @session_start();
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);  //連接資料表testabc_login
	mysql_query("set names 'utf8'");
	
	//讀取公司名稱
	$cid =$_SESSION['cid'];
	$name=$_SESSION['user'];
	//echo $cid."|".$name;
	
	//讀取總經理職位
	//總經理='總經理';
	$temp=mysql_query("SELECT `Account` FROM `authority` WHERE `cid`='$cid' AND `isceo`=1",$connect);
    $result_temp=mysql_fetch_array($temp);
    $ceo=$result_temp[0];
	
	/*//其他經理讀取
	$temp=mysql_query("SELECT * FROM `authority` WHERE cid='$cid' AND `ceo`=0 ORDER BY `Account`");
	//$result_temp=mysql_fetch_array($temp);
	//$position=$result_temp[0];*/

$result=mysql_query("SELECT * FROM `authority` WHERE `cid`='$cid'");
$stu_num=mysql_num_rows($result);

switch($stu_num){

case "4":
/* 建立影像 (開始) */
$image = imagecreate(400, 60);//建立一個影像大小為400*330的空白畫布，y最下面畫到50，保留10的邊界
$bgColor = imagecolorallocate($image, 255, 255, 255);
$lineColor = imagecolorallocate($image, 87, 86, 74);  //定義線條顏色，此範例定為橘色
imageline($image, 200, 10, 200, 30, $lineColor);  // 畫總經理下來的線
imageline($image, 50, 30, 350, 30, $lineColor);  // 畫橫線
imageline($image, 50, 30, 50, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 200, 30, 200, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 350, 30, 350, 50, $lineColor);  // 畫連到其他經理的線

imagejpeg($image, "draw4.jpg");  //做成jpg圖檔並輸出
imagedestroy($image);  //輸出完成後刪除掉原本暫存的圖檔 $image
/* 建立影像 (結束) */
?>
<html>
<table cellpadding=6 align="center">
<tr><td colspan=3 ALIGN=CENTER><img src = "./images/pred.png"></td></tr>
<tr><td colspan=5 ALIGN=CENTER>總經理</td>
<tr><td colspan=5 ALIGN=CENTER>帳號： <?php echo $ceo ?></td></tr>
<tr><td colspan=5 ALIGN=CENTER>擁有決策：所有決策</td></tr>
<tr><td colspan=3 ALIGN=CENTER><img src = "./draw4.jpg"></td></tr>
<tr>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
</tr>
<tr>
<?php	
	$position=mysql_query("SELECT * FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseposition=mysql_fetch_array($position)){
		echo "<td align='center'>".$Elseposition['Position']."</td>";
	}
?>
</tr>
<tr>
<?php	
	$account=mysql_query("SELECT DISTINCT(`Account`) FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseaccount=mysql_fetch_array($account)){
		echo "<td align='center'>帳號： ".$Elseaccount['Account']."</td>";
	}
?>
</tr>
<tr>
<?php	
	error_reporting(0);
	$select50 = "select distinct(Decision),Position from authority where cid = '$cid' and `Position`<>'總經理' order by Account ASC";/* 顯示玩家的決策 */
	$selectno50 = mysql_query($select50);
	while($selectvalue50 = mysql_fetch_array($selectno50)){
		$selectdata50 = $selectvalue50[0];
		//echo "<td align='center'>".$selectdata50."</td>";
		$decno = explode(",",$selectdata50); //數字陣列
		for($i=0;$i<sizeof($decno);$i++){ 
			$find51 = "select DecisionName from info_decision where DecisionNo = '$decno[$i]'";
			$findposition51 =  mysql_query($find51);/* 查詢DB裡的位置 */
			$findvalue51 = mysql_fetch_array($findposition51);
			$finddata51 = $findvalue51['DecisionName'];/* 第一筆資料 */
			$d.=$finddata51."<br>";
			//$p=$selectvalue50['Position'];
		}
		echo "<td align='center'>".$d."</td>";
		$d=null;
		//}
	} 
?>
</tr>
</table>
</html>  
<?php break;

  
  
 case "5":
/* 建立影像 (開始) */
$image = imagecreate(600, 60);//建立一個影像大小為400*330的空白畫布，y最下面畫到50，保留10的邊界
$bgColor = imagecolorallocate($image, 255, 255, 255);
$lineColor = imagecolorallocate($image, 87, 86, 74);  //定義線條顏色，此範例定為橘色
imageline($image, 300, 10, 300, 30, $lineColor);  // 畫總經理下來的線
imageline($image, 70, 30, 530, 30, $lineColor);  // 畫橫線
imageline($image, 70, 30, 70, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 223, 30, 223, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 380, 30, 380, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 530, 30, 530, 50, $lineColor);  // 畫連到其他經理的線

imagejpeg($image, "draw5.jpg");  //做成jpg圖檔並輸出
imagedestroy($image);  //輸出完成後刪除掉原本暫存的圖檔 $image
/* 建立影像 (結束) */
?>
<html>
<table cellpadding=6 align="center">
<tr><td colspan=4 ALIGN=CENTER><img src = "./images/pred.png"></td></tr>
<tr><td colspan=5 ALIGN=CENTER>總經理</td>
<tr><td colspan=5 ALIGN=CENTER>帳號： <?php echo $ceo ?></td></tr>
<tr><td colspan=5 ALIGN=CENTER>擁有決策：所有決策</td></tr>
<tr><td colspan=4 ALIGN=CENTER><img src = "./draw5.jpg"></td></tr>
<tr>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
</tr>
<tr>
<?php	
	$position=mysql_query("SELECT * FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseposition=mysql_fetch_array($position)){
		echo "<td align='center'>".$Elseposition['Position']."</td>";
	}
?>
</tr>
<tr>
<?php	
	$account=mysql_query("SELECT DISTINCT(`Account`) FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseaccount=mysql_fetch_array($account)){
		echo "<td align='center'>帳號： ".$Elseaccount['Account']."</td>";
	}
?>
</tr>
<tr>
<?php	
			$select50 = "select distinct(Decision),Position from authority where cid = '$cid' and `Position`<>'總經理' order by Account ASC";/* 顯示玩家的決策 */
	        $selectno50 = mysql_query($select50);
	        while($selectvalue50 = mysql_fetch_array($selectno50)){
				$selectdata50 = $selectvalue50[0];
				//echo "<td align='center'>".$selectdata50."</td>";
				$decno = explode(",",$selectdata50); //數字陣列
				for($i=0;$i<sizeof($decno);$i++){ 
					$find51 = "select DecisionName from info_decision where DecisionNo = '$decno[$i]'";
					$findposition51 =  mysql_query($find51);/* 查詢DB裡的位置 */
					$findvalue51 = mysql_fetch_array($findposition51);
					$finddata51 = $findvalue51['DecisionName'];/* 第一筆資料 */
					$d.=$finddata51."<br>";
					//$p=$selectvalue50['Position'];
				}
				echo "<td align='center'>".$d."</td>";
				$d=null;
				//}
			} 
			
			
?>
</tr>
</table>
</html>
<?php break;

  
  
case "6":
/* 建立影像 (開始) */
$image = imagecreate(640, 60);//建立一個影像大小為400*330的空白畫布，y最下面畫到50，保留10的邊界
$bgColor = imagecolorallocate($image, 255, 255, 255);
$lineColor = imagecolorallocate($image, 87, 86, 74);  //定義線條顏色，此範例定為橘色
imageline($image, 320, 10, 320, 30, $lineColor);  // 畫總經理下來的線
imageline($image, 30, 30, 610, 30, $lineColor);  // 畫橫線
imageline($image, 30, 30, 30, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 176, 30, 176, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 320, 30, 320, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 465, 30, 465, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 610, 30, 610, 50, $lineColor);  // 畫連到其他經理的線

imagejpeg($image, "draw6.jpg");  //做成jpg圖檔並輸出
imagedestroy($image);  //輸出完成後刪除掉原本暫存的圖檔 $image
/* 建立影像 (結束) */
?>
<html>
<table cellpadding=6 align="center">
<tr><td colspan=5 ALIGN=CENTER><img src = "./images/pred.png"></td></tr>
<tr><td colspan=5 ALIGN=CENTER>總經理</td>
<tr><td colspan=5 ALIGN=CENTER>帳號： <?php echo $ceo ?></td></tr>
<tr><td colspan=5 ALIGN=CENTER>擁有決策：所有決策</td></tr>
<tr><td colspan=5 ALIGN=CENTER><img src = "./draw6.jpg"></td></tr>
<tr>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
</tr>
<tr>
<?php	
	$position=mysql_query("SELECT * FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseposition=mysql_fetch_array($position)){
		echo "<td align='center'>".$Elseposition['Position']."</td>";
	}
?>
</tr>
<tr>
<?php	
	$account=mysql_query("SELECT DISTINCT(`Account`) FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseaccount=mysql_fetch_array($account)){
		echo "<td align='center'>帳號： ".$Elseaccount['Account']."</td>";
	}
?>
</tr>
<tr>
<?php	
			$select50 = "select distinct(Decision),Position from authority where cid = '$cid' and `Position`<>'總經理' order by Account ASC";/* 顯示玩家的決策 */
	        $selectno50 = mysql_query($select50);
	        while($selectvalue50 = mysql_fetch_array($selectno50)){
				$selectdata50 = $selectvalue50[0];
				//echo "<td align='center'>".$selectdata50."</td>";
				$decno = explode(",",$selectdata50); //數字陣列
				for($i=0;$i<sizeof($decno);$i++){ 
					$find51 = "select DecisionName from info_decision where DecisionNo = '$decno[$i]'";
					$findposition51 =  mysql_query($find51);/* 查詢DB裡的位置 */
					$findvalue51 = mysql_fetch_array($findposition51);
					$finddata51 = $findvalue51['DecisionName'];/* 第一筆資料 */
					$d.=$finddata51."<br>";
					//$p=$selectvalue50['Position'];
				}
				echo "<td align='center'>".$d."</td>";
				$d=null;
				//}
			} 
			
			
?>
</tr>

</table>
</html>     
<?php  break;
  
  
  
  case "7":
     /* 建立影像 (開始) */
$image = imagecreate(550, 60);//建立一個影像大小為400*330的空白畫布，y最下面畫到50，保留10的邊界
$bgColor = imagecolorallocate($image, 255, 255, 255);
$lineColor = imagecolorallocate($image, 87, 86, 74);  //定義線條顏色，此範例定為橘色
imageline($image, 260, 10, 260, 30, $lineColor);  // 畫總經理下來的線
imageline($image, 50, 30, 500, 30, $lineColor);  // 畫橫線
imageline($image, 50, 30, 50, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 140, 30, 140, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 220, 30, 220, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 300, 30, 300, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 380, 30, 380, 50, $lineColor);  // 畫連到其他經理的線
imageline($image, 500, 30, 500, 50, $lineColor);  // 畫連到其他經理的線

imagejpeg($image, "draw7.jpg");  //做成jpg圖檔並輸出
imagedestroy($image);  //輸出完成後刪除掉原本暫存的圖檔 $image
/* 建立影像 (結束) */
?>
<html>
<table cellpadding=6 align="center">
<tr><td colspan=6 ALIGN=CENTER><img src = "./images/pred.png"></td></tr>
<tr><td colspan=5 ALIGN=CENTER>總經理</td>
<tr><td colspan=5 ALIGN=CENTER>帳號： <?php echo $ceo ?></td></tr>
<tr><td colspan=5 ALIGN=CENTER>擁有決策：所有決策</td></tr>
<tr><td colspan=6 ALIGN=CENTER><img src = "./draw7.jpg"></td></tr>
<tr>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
<td ALIGN=CENTER><img src = "./images/people.png"></td>
</tr>
<tr>
<?php	
	$position=mysql_query("SELECT * FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseposition=mysql_fetch_array($position)){
		echo "<td align='center'>".$Elseposition['Position']."</td>";
	}
?>
</tr>
<tr>
<?php	
	$account=mysql_query("SELECT DISTINCT(`Account`) FROM authority WHERE `cid`='$cid' AND `Position` <> '總經理' ORDER BY `Account` ASC",$connect);
	mysql_select_db("testabc_login",$connect);
	while($Elseaccount=mysql_fetch_array($account)){
		echo "<td align='center'>帳號： ".$Elseaccount['Account']."</td>";
	}
?>
</tr>
<tr>
<?php	
			$select50 = "select distinct(Decision),Position from authority where cid = '$cid' and `Position`<>'總經理' order by Account ASC";/* 顯示玩家的決策 */
	        $selectno50 = mysql_query($select50);
	        while($selectvalue50 = mysql_fetch_array($selectno50)){
				$selectdata50 = $selectvalue50[0];
				//echo "<td align='center'>".$selectdata50."</td>";
				$decno = explode(",",$selectdata50); //數字陣列
				for($i=0;$i<sizeof($decno);$i++){ 
					$find51 = "select DecisionName from info_decision where DecisionNo = '$decno[$i]'";
					$findposition51 =  mysql_query($find51);/* 查詢DB裡的位置 */
					$findvalue51 = mysql_fetch_array($findposition51);
					$finddata51 = $findvalue51['DecisionName'];/* 第一筆資料 */
					$d.=$finddata51."<br>";
					//$p=$selectvalue50['Position'];
				}
				echo "<td align='center'>".$d."</td>";
				$d=null;
				//}
			} 
			
?>
</tr>
</table>
</html>  
  <?php  break;
 
 

}

?>