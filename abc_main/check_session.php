<?php
	session_start();
	if(!isset($_SESSION['cid']) && !isset($_SESSION['user']))
		echo "NO";
	else
		echo "YES";
?>