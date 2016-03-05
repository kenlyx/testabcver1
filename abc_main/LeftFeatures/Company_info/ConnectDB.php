<?php 
    $link = mysql_connect('localhost','root','testabc') or die("不能連線");
	   if(!$link){
		  echo '<p>不能連線' . mysql_error() . '</p>';}


     mysql_query("SET NAMES 'utf8'",$link);
     mysql_query("SET CHARACTER_SET_database= utf8",$link);
     mysql_query("SET CHARACTER_SET_CLIENT= utf8",$link);
     mysql_query("SET CHARACTER_SET_RESULTS= utf8",$link); 
	
	 mysql_select_db('testabc_login',$link) or die("不能選擇資料庫");
	   if(!@mysql_select_db('testabc_login')){
		  echo '<p>不能連線' . mysql_error() . '</p>';}	
	
?>