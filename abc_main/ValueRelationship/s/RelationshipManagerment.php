
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../../css/smartTab5.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../../css/style.css"/>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquery.smartTab.js"></script>
        <script type="text/javascript" src="./js/training_jquery.rating.js"></script>
		<link href="/cssrating.css" rel="stylesheet"/>
       	<script type="text/javascript">
			$(document).ready(function(){
				$('#tabs').smartTab({autoProgress: true,stopOnFocus:true,transitionEffect:'slide'});  // Smart Tab    	
	            function addCommas(nStr)
				{
					nStr += '';
					x = nStr.split('.');
					x1 = x[0];
					x2 = x.length > 1 ? '.' + x[1] : '';
					var rgx = /(\d+)(\d{3})/;
					while (rgx.test(x1)) {
						x1 = x1.replace(rgx, '$1' + ',' + '$2');
					}
				return x1 + x2;
				}
			});
		</script>
    </head>
    <body>   
    <div id="content">
        <h1>關係管理</h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer">
  			<ul>
  				<li>
                <a href="#tabs-1">
                	<img class='logoImage2' border="0" width="25px" src="images/Step1.png">
                	<h2>投資人</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-2">
                	<img class='logoImage2' border="0" width="25px" src="images/Step2.png">
               	<h2>員工<br />
               	</h2>
            	</a>
                </li>
  				<li>
                <a href="#tabs-3">
                    <img class='logoImage2' border="0" width="25px" src="images/Step3.png">
                <h2>顧客<br />
                </h2>
             	</a>
                </li>
                <li>
                <a href="#tabs-4">
                	<img border="0" width="25px" >
               	<h2>供應商<br />
               	</h2>
            	</a>
                </li>
                <li>
                <a href="#tabs-5">
                	<img border="0" width="25px" >
               	<h2>通路商<br />
               	</h2>
            	</a>
                </li>
  			</ul>
  			<div id="tabs-1">
            <h2>Tab 1 Content</h2>	  	
            <table class="table1">
                <thead>
				
                    <tr>
                        
                        <th scope="col">等級</th>
                        <th scope="col">費用</th>
                        <th scope="col">Re指數</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="row">目前的投資人等級為</th>
                        <td>2</td>
                        
                    </tr>
                </tfoot>
                    <tr>
                        <th scope="row">等級一</th>
                        <td>500,000元</td>
                        <td>11.5%</td>
                    </tr>
                    <tr>
                        <th scope="row">等級二</th>
                        <td>1,000,000元</td>
						<td>11%</td>
                    </tr>
                    <tr>
                        <th scope="row">等級三</th>
                        <td>2,000,000元</td>
						<td>10.5%</td>
                    </tr>
                 <tr>
                        <th scope="row">等級四</th>
                        <td>4,000,000元</td>
						<td>10%</td>
                    </tr>
<tr>
                        <th scope="row">等級五</th>
                        <td>8,000,000元</td>
						<td>9.5%</td>
                    </tr>
				
                   
                </tbody>
            </table>
<table class="table1">       
      <th scope="row">提升等級</th>


            </table> 			
			</div>
  			<div id="tabs-2">
            	<h2>Tab 2 Content</h2>	
            <table class="table1" width="60%">
                <thead>
                    <tr>
                        <th scope="col" width="25%">職稱</th>
                        <th scope="col" width="25%">薪水</th>
                        <th scope="col" width="25%">發放比例</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="row">發放比例為薪水的  0%~10% 百分比</th>
						
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th scope="row">行政</th>
                        <td>25,000</td>
                        <td><input name="MonitorinputA" type="text" size="4"/>%</td>
                        
                    </tr>
                    <tr>
                        <th scope="row">財務</th>
                        <td>29,000</td>
                        <td><input name="MonitoriniputB" type="text" size="4"/>%</td>                        
                    </tr>
                    <tr>
                        <th scope="row">行銷與業務</th>
                        <td>30,000</td>
                        <td><input name="MonitorinputC" type="text" size="4"/>%</td>                        
                    </tr>
                     <tr>
                        <th scope="row">研發團隊</th>
                        <td>32,000</td>
                        <td><input name="MonitorinputC" type="text" size="4"/>%</td>                        
                    </tr>
					 <tr>
                        <th scope="row">資源運籌</th>
                        <td>32,000</td>
                        <td><input name="MonitorinputC" type="text" size="4"/>%</td>                     
                    </tr>
                   
                </tbody>
            </table>
<table class="table1">
                               
               
    
               
      <th scope="row">發放獎金</th>



            </table> 
        	</div>                      
  			<div id="tabs-3">
           
            	<h2> 年分
  				<?php /*?><Select name="year">
    			<option value="">請選擇 </Option>
    			<?php
					include("connMysql.php");
					if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
					$sql_year=("SELECT MAX(`Year`) From `authority` ");
					$result=mysql_query($sql_year) or die("取年份失敗!");
					$find = mysql_num_rows($result) ;
					$n=1;
					while($n <= $find){
						echo "<Option Value=第 ".$n." 年> 第 ".$n." 年</Option>";
					    $n++;
					}
				?>
  				</Select><?php */?>
  				</h2>	
            <table class="table1">
			<h2>大量訂單</h2>
                <thead>
				
                    <tr>
                        <th style="width:95px"></th>
                        <th scope="col" style="width:85px"> 滿意度 </th>
                        <th scope="col" colspan="2" style="width:190px">提升等級</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">顧客A</th>
                        <td>0.07452</td>
                        <td colspan="2"><span class="rating" id="rate1"></span>
			     	    <script type="text/javascript">
							$('#rate1').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusA_relationship"});
                        </script>
				        </td>
                    </tr>
                    <tr>
                        <th scope="row">顧客B</th>
                        <td>0.04222</td>
                        <td colspan="2"><span class="rating" id="rate2"></span>
			     	    <script type="text/javascript">
							$('#rate2').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusB_relationship"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客C</th>
                        <td>0.25896</td>
                        <td colspan="2"><span class="rating" id="rate3"></span>
			     	    <script type="text/javascript">
							$('#rate3').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusC_relationship"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客D</th>
                        <td>0.01475</td>
                        <td colspan="2"><span class="rating" id="rate4"></span>
			     	    <script type="text/javascript">
							$('#rate4').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusD_relationship"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客E</th>
                        <td>0.02368</td>
                        <td colspan="2">
						</td>
                    </tr>
					 <tr>
                        <th scope="row">顧客F</th>
                        <td>0.05874</td>
                        <td colspan="2">
						</td>
                    </tr>
                    </tbody>
            </table>
			 <table class="table1">
			<h2>小量訂單</h2>
                <thead>
				
                    <tr>
                        <th style="width:95px"></th>
                        <th scope="col" style="width:85px"> 滿意度 </th>
                        <th scope="col" colspan="2" style="width:190px">提升等級</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">顧客A</th>
                        <td>0.02474</td>
                        <td colspan="2">
                 
				        </td>
                    </tr>
                    <tr>
                        <th scope="row">顧客B</th>
                        <td>0.03352</td>
                        <td colspan="2">
						<!--<div id="rate2" align="center"></div>
						<script type="text/javascript">
						
						$('#rate2').rater(options);
                        </script>--></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客C</th>
                        <td>0.06662</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客D</th>
                        <td>0.03445</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <th scope="row">顧客E</th>
                        <td>0.01152</td>
                        <td colspan="2">
						</td>
                    </tr>
					 <tr>
                        <th scope="row">顧客F</th>
                        <td>0.02755</td>
                        <td colspan="2">
						</td>
                    </tr>
                    </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <td></td>
                       
                    </tr>
                    <tr><td></td></tr> 
                    <tr><td></td><td colspan="3" align="center">
                    <input  type="image" src="../images/resume.png" id="resume" onClick="location.href='RelationshipManagerment.php#tabs-3'" style="width:100px">
                    <input type="image" src="../images/submit6.png" id="submit" style="width:100px"></td></tr>
                </tfoot>
            </table>         				          
       		</div>
            <div id="tabs-4">
            	<h2>Tab 4 Content</h2>	
                 <table class="table1" width="60%">
                <thead>
				
                    <tr>
					    <th width="25%"></th>
                        <th scope="col" width="25%">上期營收</th>
                        <th scope="col" width="25%">發放比例</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="row">發放比例為上期營收的  0%~10% 百分比</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th scope="row" >供應商A</th>
                        <td>25,000</td>
                        <td><input name="MonitorinputA" type="text" size="4"/>%</td>                     
                    </tr>
                    <tr>
                        <th scope="row">供應商B</th>
                        <td>29,000</td>
                        <td><input name="MonitoriniputB" type="text" size="4"/>%</td>                   
                    </tr>
                    <tr>
                        <th scope="row">供應商C</th>
                        <td>30,000</td>
                        <td><input name="MonitorinputC" type="text" size="4"/>%</td>  
                    </tr>
                     
					
                   
                </tbody>
            </table>
<table class="table1">
                               
               
    
               
      <th scope="row">分紅</th>



            </table>                				          
       		</div>
            <div id="tabs-5">
            	<h2>Tab 5 Content</h2>	
                <table class="table1" width="60%">
                <thead>
				
                    <tr>
					    <th width="25%"></th>
                        <th scope="col" width="25%">上期營收</th>
                        <th scope="col" width="25%">發放比例</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="row">發放比例為上期營收的  0%~10% 百分比</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th scope="row" >供應商A</th>
                        <td>25,000</td>
                        <td><input name="MonitorinputA" type="text" size="4"/>%</td>
                        
                    </tr>
                    <tr>
                        <th scope="row">供應商B</th>
                        <td>29,000</td>
                        <td><input name="MonitoriniputB" type="text" size="4"/>%</td>
                        
                    </tr>
                    <tr>
                        <th scope="row">供應商C</th>
                        <td>30,000</td>
                        <td><input name="MonitorinputC" type="text" size="4"/>%</td>
                        
                    </tr>
                     
					
                   
                </tbody>
            </table>
<table class="table1">
                               
               
    
               
      <th scope="row">分紅</th>



            </table>                 				          
       		</div>
		</div>    <!-- Tabs 結束 -->
            
            
       
          -
      </div><!-- end content -->
    </body>
</html>