<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
function logouttalk(){
	alert("登出!");
}

document.location="./player_login.php";		

logouttalk(this);

</script>

</head>

<body>

<?php

include("./connMysql.php");
foreach($_POST as $key => $value);


$_SESSION['ID'] = "";

?>



</body>
</html>