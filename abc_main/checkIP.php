<?php
$currentIP="127.0.0.1";  //設定本機IP

/* 得到使用者IP */
if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	$ip=$_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else{
	$ip=$_SERVER['REMOTE_ADDR'];
}


if($ip==$currentIP){
}  // IP正確沒問題

else{
?>
<script>
	alert('您不允許進入此區');
	location.href='index.php';
</script>
<?php
}


?>