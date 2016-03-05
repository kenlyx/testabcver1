<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上傳名單</title>
</head>

<style>
body{
	background:url(./bg.png);
	color:#FFF;
}
a:link{
	color:#F00;
}
</style>
<script> 
function deletetable(n){
	location.href="listupload.php?d=" + n;
}
function seperate(list){
	alert(list);
	var a = document.getElementById('cutafter').value;
	var n = document.getElementById('newname').value;
	alert(n);
	location.href="listupload.php?s="+ list+"&a="+a+"&n="+n;
}function viewlist(s){  
    var c = s; 
    location.href="listupload.php?c=" + c;
}
</script> 
<?php
include("../mysql_connect.inc.php");
$fileDir = getcwd();
$seldb = mysql_select_db("102abc_admin");
if (!$seldb) die("資料庫選擇失敗！");


if(isset($_GET["action"])&&$_GET["action"]=="upload"){
	if($_FILES["upload"]["error"]==0){
		$filename=$_FILES["upload"]["name"];
		$s=explode('.',$_FILES["upload"]["name"]);
		$filenameonly=$s[0];
		move_uploaded_file($_FILES["upload"]["tmp_name"], $_POST["dir"]."\\uploads\\".$_FILES["upload"]["name"]);
	}
	//重新轉頁到目前目錄中
	//header("Location: ?dir=".$_POST["dir"]);
	
	
// Test CVS
require_once 'file:///C|/test/Excel/reader.php';
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
// Set output Encoding.
//$data->setOutputEncoding('CP1251');
$data->setOutputEncoding('utf-8');

$data->read("./uploads/".$filename);


error_reporting(E_ALL ^ E_NOTICE);

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

	mysql_query("DROP TABLE IF EXISTS `102abc_admin`.`$filenameonly`");
	$sql=sprintf("CREATE TABLE %s (sid VARCHAR(10) NOT NULL, PRIMARY KEY(sid), sname VARCHAR(10), cid VARCHAR(3) NOT NULL, ceo TINYINT(1))",$filenameonly);
	mysql_query($sql);
	$sid = $data->sheets[0]['cells'][$i][1];
    $sname = $data->sheets[0]['cells'][$i][2];
	$cid = $data->sheets[0]['cells'][$i][3];
	$ceo = $data->sheets[0]['cells'][$i][4];
	$sql = sprintf("INSERT INTO %s (sid,sname,cid,ceo) VALUES ('$sid','$sname','$cid','$ceo')",$filenameonly);
	echo $sql."\n";
	if(!empty($sid) || !empty($sname) || !empty($cid) || !empty($ceo) )
    mysql_query($sql);
}
}

$result = mysql_list_tables("102abc_admin") or die("Query failed");
$num_rows = mysql_num_rows($result);

for($i=0;$i<$num_rows;$i++){
	$tb_names[$i] = mysql_tablename ($result, $i); 
	}	
mysql_free_result($result);	

?>
<body>
<p>匯入學生名單<br />
  
Excel中內容請依序填寫 學號、姓名、組別(C01~C15)、是否為CEO(是填1，否填0) <br />
<?php
echo '<form action="?action=upload" method="post" enctype="multipart/form-data" name="form1" id="form1">';
echo '上傳名單 <input type="file" name="upload" style="height:20px" />';
echo '<input type="submit" name="button" style="height:20px" value="送出" />';
echo '<input name="dir" type="hidden" id="dir" value="'.$fileDir.'" /></form>';
?>
 名單瀏覽
  <Select name="classes" onchange="viewlist(this.options[this.options.selectedIndex].value)">
  <option value="">請選擇 </Option>
<?php
	foreach($tb_names as $n){
		echo "<Option Value=".$n.">".$n."</Option>";
	}
?>
  </Select>
</p>


<?php

$sql="select * from $filenameonly";
$result = mysql_query($sql) or die("Query failed");
$num_rows = mysql_num_rows($result);
echo $chosentable.", 此名單內有".$num_rows."位學生";
echo '<table border="1" align="center">
  <tr>
    <th>學號</th>
	<th>姓名</th>
	<th>組別</th>
	<th>CEO</th>
  </tr>';

	while($row=mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td align=\"center\">".$row[0]."</td>";
		echo "<td align=\"center\">".$row[1]."</td>";
		echo "<td align=\"center\">".$row[2]."</td>";
		echo "<td align=\"center\">".$row[3]."</td>";
		echo "</tr>";
	}


?>

</body>
</html>