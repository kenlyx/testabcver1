<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>step 2</title>
</head>

<style>
body{
	color:#000;
}
a:link{
	color:#999;
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
include("../connMysql.php");
$game=$_GET['game'];
$seldb = mysql_select_db("102abc_admin");
if (!$seldb) die("資料庫選擇失敗！");
$sql_ginfo=mysql_query("SELECT * FROM `game` WHERE `gameName`='$game'");
$ginfo=mysql_fetch_array($sql_ginfo);

$fileDir = getcwd();
$seldb = mysql_select_db("testabc_login");
if (!$seldb) die("資料庫選擇失敗！");

if(isset($_GET["action"]) && $_GET["action"]=="upload"){
	
	if($_FILES["upload"]["error"]==0){
		echo '<script language=\"JavaScript\"> alert("上傳成功!");</script>';
		$filename=$_FILES["upload"]["name"];
		$s=explode('.',$_FILES["upload"]["name"]);
		$filenameonly=$s[0];
		move_uploaded_file($_FILES["upload"]["tmp_name"], mysql_real_escape_string($_POST["dir"])."\\uploads\\".$_FILES["upload"]["name"]);
	}else
		echo "上傳失敗，請重新設定! &nbsp;";
	//重新轉頁到目前目錄中
	//header("Location: ?dir=".mysql_real_escape_string($_POST["dir"]));
	
	// Test CVS
	require_once './Excel/reader.php';
	// ExcelFile($filename, $encoding);
	$data = new Spreadsheet_Excel_Reader();
	// Set output Encoding.
	//$data->setOutputEncoding('CP1251');
	$data->setOutputEncoding('utf-8');

	$data->read("./uploads/".$filename);
	$tablename="student_list";

	error_reporting(E_ALL ^ E_NOTICE);
	mysql_query("DROP TABLE IF EXISTS `testabc_login`.`$tablename`");
	
	for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		$sql=sprintf("CREATE TABLE %s (sid VARCHAR(10) NOT NULL, PRIMARY KEY(sid), sname VARCHAR(10), cid VARCHAR(3) NOT NULL, isCaptain TINYINT(1))",$tablename);
		mysql_query($sql);
		$sid = $data->sheets[0]['cells'][$i][1];
    	$sname = $data->sheets[0]['cells'][$i][2];
		$cid = $data->sheets[0]['cells'][$i][3];
		$isCaptain = $data->sheets[0]['cells'][$i][4];
		$sql = sprintf("INSERT INTO %s (sid,sname,cid,isCaptain) VALUES ('$sid','$sname','$cid','$isCaptain')",$tablename);
		if(!empty($sid) || !empty($sname) || !empty($cid) || !empty($isCaptain) )
   		mysql_query($sql);
	}//end for
	
	//找出此競賽有幾間公司
	$sql="Select * From `student_list` Where `isCaptain`='1'";
	$result = mysql_query($sql) or die("Query failed");
	$num = mysql_num_rows($result);	
	
 	$courseN=$ginfo["CourseName"];
	$courseT=$ginfo["CourseTeacher"];
	$gameN=$ginfo["GameName"];
	//echo $ginfo["CourseName"];
	$sql_query = "INSERT INTO `game` (`SystemName`,`CourseName`,`CourseTeacher`,`GameName`,`CompanyNum`) VALUES (";
		if($courseN!="" and $courseT!="" and $gameN!=""){
		   	 $sql_query .= "'ABC',";
			 $sql_query .= "'".$courseN."',";
			 $sql_query .= "'".$courseT."',";
		   	 $sql_query .= "'".$gameN."',";
	    	 $sql_query .= "'".$num."')";
	     	 mysql_query($sql_query);	 	
		}//end if
	//echo $sql_query;
	echo '<input type="hidden" name="$first">'; //設一個隱藏變數去讀取此段程式碼被執行的次數
	echo $first;
}//end if(action=upload)
	?>
	<body>
    <p>
	<?php   
		
		echo '<form action="?action=upload&game='.$_GET['game'].'" method="post" enctype="multipart/form-data" name="form1" id="form1">';
        
		//echo "SELECT * FROM `game` WHERE `gameName`='$game'";
		echo '<p>';
	    echo '課程名稱：<input type="text" size="16px" value= "'.$ginfo['CourseName'].'" name="courseName" disabled/><br>';
		echo '授課導師：<input type="text" size="16px" value= "'.$ginfo['CourseTeacher'].'" name="courseTeacher" disabled/><br>';
		echo '競賽名稱：<input type="text" size="16px" value= "'.$ginfo['GameName'].'" name="gameName" disabled/><br><br>';
		/*echo '課程名稱：<span id="courseName"></span><br>';
		echo '授課導師：<span id="courseTeacher"></span><br>';
		echo '競賽名稱：<span id="gameName"></span><br>';*/
		echo 'Excel中內容請依序填寫<font color="#FF3425"> 學號、姓名、組別(C01~C15)、組長(是填1，否填0) </font><br><br>';
		echo '上傳名單 <input type="file" name="upload" style="height:22px" />';
        
		echo '<input type="submit" name="button" style="height:20px" value="送出"/>';
		echo '<input name="dir" type="hidden" id="dir" value="'.$fileDir.'" /></form>';
       
$seldb = mysql_select_db("testabc_login");
if (!$seldb) die("資料庫選擇失敗！");
//echo $first;
if($first==1){	
	
	$sql="select * from $tablename";
	$result = @mysql_query($sql) or die("Query failed");
	$num_rows = mysql_num_rows($result);
	echo "<p>此名單內有".$num_rows."位學生";
	echo '<table border="1" align="center">
    <tr>
    	<th>學號</th>
		<th>姓名</th>
		<th>組別</th>
		<th>isCaptain</th>
  	</tr>';

	while($row=mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td align=\"center\">".$row[0]."</td>";
		echo "<td align=\"center\">".$row[1]."</td>";
		echo "<td align=\"center\">".$row[2]."</td>";
		echo "<td align=\"center\">".$row[3]."</td>";
		echo "</tr>";
	}

}
?>

</body>
</html>