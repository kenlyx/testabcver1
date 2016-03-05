


<?php
header("Content-type: text/html; charset=utf-8"); 
require_once("connMysql_ABC.php");
$process = $_POST['process'];
$allprocess = implode (",",$process);
//echo $process;
echo "<br>";
echo $allprocess;
$number=count($process);
echo count($allprocess);
for($i=0;$i<=$number;$i++){
$sql_query="INSERT INTO `process_improvement`
(`process`)
VALUES(";
$sql_query .="'".$process."')";
$result = mysql_query($sql_query);
}
?>