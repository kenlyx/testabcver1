<div align=center style="z-index: 1">
  <font size='4'>5. 影響接單的四個因素：公司形象、產品品質、價格、顧客滿意度</font>
  <table>
  <tr><td align=center><font size='7' color='gold' face='標楷體'>歡迎進入ABC決策模擬系統</font></td></tr>
  <tr><td><font size='4'>競賽注意事項：</font></td></tr>
  <tr>
  <?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);  //連接資料表testabc_login
	$result=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account");
	$stu_manager_num=mysql_num_rows($result);
	echo "<td><font size='4'>1. 目前共有".$stu_manager_num."家公司正在參與競賽</font></td>";
  ?></tr>
  <tr><td><font size='4'>2. 只有在每年年初才可進行現金增資，每次增資上限為20,000,000</font></td></tr>
  <tr><td><font size='4'>3. 在進行生產前，須先與原料供應商簽約，確保每個月得到的原料數及品質，也須先購買足夠機具，並進行流程改良，才可生產</font></td></tr>
  <tr><td><font size='4'>4. 每個月只能開發一種新產品</font></td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr></tr>
  <tr><td></br></br></br><font size='5' color='gold' face='標楷體'>本月新聞：</font></td></tr>    
  <tr>
  <?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);  //連接資料表testabc_login
	mysql_query("set names 'utf8'");
	$month=$_SESSION['month'];
    $temp=mysql_query("SELECT `situation` FROM `situation_overview` WHERE `month`='2'");
    $result=  mysql_fetch_array($temp);
    $temp_01=mysql_query("SELECT `name`,`description` FROM `situation` WHERE `index`={$result['situation']};",$connect);
    $result=  mysql_fetch_array($temp_01);
	echo "<td><font size='4'>".$result['name'].",".$result['description']."</font></td>";
  ?>	</tr>
	</table>
</div>
