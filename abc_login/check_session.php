<?php
	session_start();
	if(!isset($_SESSION['company']))
		echo "NO";
	else
		echo "YES";
?>