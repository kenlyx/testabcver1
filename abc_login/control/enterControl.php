<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>進入主控台</title>

<link rel="stylesheet" type="text/css" href="css/select/styles.css" />
<link rel="stylesheet" type="text/css" href="css/select/jquery.tzSelect.css" />
<script src="js/select/jquery-1.4.2.js"></script>
<script src="js/select/jquery.tzSelect.js"></script>
<script src="js/select/script.js"></script>
			
<script type="text/javascript">
     function enter(){ 
		
		var gameNam=$("#selectgame").val();
		
		$.post("change.php",{
		gameNamm:gameNam
		 },function(xml){
				   
				  alert(gameNam);
				  window.open("timeset.php");
				  
			   });
     	
		
     }
 </script>
    
</head>
<body>
		  

			  
<?php 			  	 
  	$account='984003008';//$_SESSION['ID'];
			
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
			
	$result0 =mysql_query("SELECT GameName FROM `game`");
	$row1 = mysql_fetch_array($result0);
	$gameName=$row1[0];
			
	if($gameName=='0')
		{
		?>
		<script type="text/javascript">
			alert("您尚未建立遊戲!");
		</script>
		<?php
		}
		
	$gameName_array=explode(",",$gameName); 
	$numArr=sizeof($gameName_array); //切割完放入陣列 看他裡面有幾個遊戲
	
	$i=0; //下面的變數		
?>
<div id="page">
        <form name="form" id="form" >
          <select class="regularSelect" id="selectgame" name="selectgame" >
		      <option value="0" selected="selected" >請選擇要進入的遊戲主控台</option>
              <?php
			  while($i<=$numArr){
			         $GameName = $gameName_array[$i];	
					 $i++; ?>
			  <option value="<?php echo $GameName ;?>"> <?php echo '<p>' . $GameName .'</p>';}?> </option>
           </select><br/><br/> </form>	
          <input type="button" name="enter" id="enter" value="進入主控台"  onclick="enter(this)" ></input>
        
        
		 </br>
</div>




</body>
</html>
