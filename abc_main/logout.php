<?php 
session_start();
session_destroy();
if(count($_SESSION) == 0)
{
	$_SESSION=array();
	session_destroy();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
function logouttalk(){
	alert("您已經登出!");
}

document.location="../abc_login/player_login.php";		

logouttalk(this);

</script>

</head>

<body><?php /*?>

<?php

include ("./connMysql.php");
foreach($_POST as $key => $value);

$_SESSION['user'] ="";

?><?php */?>



</body>
</html>