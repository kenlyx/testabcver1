<?php
function cluetip($name){
	$connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main",$connect);
	echo "<html><head><title></title><meta http-equiv='Content-Type' content='text/html' charset='utf-8'></head>";
	switch ($name){
		case 'clue_pA':
			echo "<b>筆記型電腦</b></br>每單位所需原料</br>螢幕與面板：1</br>主機板與核心電路：1</br>鍵盤基座：1";
			break;
		case 'clue_pB':
			echo "<b>平板電腦</b></br>每單位所需原料</br>螢幕與面板：1</br>主機板與核心電路：1";
			break;
		case 'clue_monitor_pp':
			echo "進行本流程所需成本: $ 1.05/個";
			break;
		case 'clue_keyboard_pp':
			echo "進行本流程所需成本: $ 1.05/個";
			break;
		case 'clue_kernel_pp':
			echo "進行本流程所需成本: $ 1.05/個";
			break;
		case 'clue_check_s_pp':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='product_plan'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "進行本流程所需成本：$".$correspond['money2'];
			break;
		case 'clue_check_pp':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='product_plan'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "進行本流程所需成本：$".$correspond['money3'];
			break;
		case 'clue_monitor_pi': 
			case 'clue_kernel_pi':
			case 'clue_keyboard_pi':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='process_improvement'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "改良本流程所需成本：$".$correspond['money'];
			break;
		case 'clue_check_s_pi':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='process_improvement'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "改良本流程所需成本：$".$correspond['money2'];
			break;
		case 'clue_check_pi':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='process_improvement'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "改良本流程所需成本：$".$correspond['money3'];
			break;
		case 'f_h_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>財務人員薪資：</b><br>$".$correspond['money2'];
			break;
		case 'e_h_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>運籌人員薪資：</b><br>$".$correspond['money3'];
			break;
		case 's_h_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>行銷與業務人員薪資：</b><br>$".$correspond['money'];
			break;
		case 'h_h_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>行政人員薪資：</b><br>$".$correspond['money2'];
			break;
		case 'r_h_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>研發團隊薪資：</b><br>$".$correspond['money3'];
			break;
		case 'f_f_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>財務人員資遣費：</b><br>$".$correspond['money2']*3;
			break;
		case 'e_f_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>運籌人員資遣費：</b><br>$".$correspond['money3']*3;
			break;
		case 's_f_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>行銷與業務人員資遣費：</b><br>$".$correspond['money']*3;
			break;
		case 'h_f_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>行政人員資遣費：</b><br>$".$correspond['money2']*3;
			break;
		case 'r_f_info':
			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'",$connect);
			$correspond=mysql_fetch_array($correspondence);
			echo "<b>研發團隊資遣費：</b><br>$".$correspond['money3']*3;
			break;
	}
}
cluetip($_GET['name']);
?>