<?php
$a=7/5;
//echo $a;
echo floor($a);




$sql_machine = mysql_query("SELECT SUM(`buy_year`) FROM  `machine` WHERE `cid`='$cid' AND `year`<=$year AND `month`<$month", $connect);
                		$machine_result=mysql_fetch_array($sql_machine);
                           $total_machine = $machine_result[0];
?>


                    
					
					