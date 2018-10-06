<?php @session_start(); 

if (!strcmp(mysql_real_escape_string($_POST['year']), "now")) {
    $month = $_SESSION['month'];  //之後在這裡從資料庫中讀出確切月份
    $year=$_SESSION['year'];
	//$month = 5;
	//$year = 3;
    echo ($year-1)*12+(int)$month;
	//echo "3";
} 
?>

