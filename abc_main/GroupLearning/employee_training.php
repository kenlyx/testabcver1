<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>employeetraining</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/employeetraining.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript">
	  	   var f_tcount=0,r_tcount=0,s_tcount=0,e_tcount=0,d_tcount=0;
		   var fn_trate=0,rs_trate=0,ss_trate=0,ex_trate=0,rd_trate=0;
		   $(document).ready(function(){
               initial_get();
               function initial_get(){
                  $.ajax({
                     url:"GET_training.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
						   //alert(str)
                           strs=str.split(":");
                        document.getElementById("has_financial_member").innerHTML=strs[0];
						document.getElementById("finan_efc").innerHTML=strs[1];
						document.getElementById("finan_stf").innerHTML=strs[2];
					    document.getElementById("has_resourcing_member").innerHTML=strs[3];
						document.getElementById("resour_efc").innerHTML=strs[4];
						document.getElementById("resour_stf").innerHTML=strs[5];
                        document.getElementById("has_sales_member").innerHTML=strs[6];
                        document.getElementById("sales_efc").innerHTML=strs[7];
                        document.getElementById("sales_stf").innerHTML=strs[8];
                        document.getElementById("has_execute_member").innerHTML=strs[9];
						document.getElementById("execu_efc").innerHTML=strs[10];
						document.getElementById("execu_stf").innerHTML=strs[11];
                        document.getElementById("has_rd_team").innerHTML=strs[12];
						document.getElementById("rd_efc").innerHTML=strs[13];	
                        document.getElementById("rd_stf").innerHTML=strs[14];
						var fn_trate=strs[15];
						var rs_trate=strs[16];
						var ss_trate=strs[17];
						var ex_trate=strs[18];
						var rd_trate=strs[19];
						 $('#rate1').rating('./employee_training.php',{maxvalue:3, emp:"fn_tcost",curvalue:fn_trate});
						 $('#rate2').rating('./employee_training.php',{maxvalue:3, emp:"rs_tcost",curvalue:rs_trate});
					     $('#rate3').rating('./employee_training.php',{maxvalue:3, emp:"ss_tcost",curvalue:ss_trate});
						 $('#rate4').rating('./employee_training.php',{maxvalue:3, emp:"ex_tcost",curvalue:ex_trate});
					     $('#rate5').rating('./employee_training.php',{maxvalue:3, emp:"rd_tcost",curvalue:rd_trate});
						   }
                        }
                    });
                }
				
			    $("#submit").click(function(){
					//alert(fn_trate);
					f_tcount=parseInt(document.getElementById("has_financial_member").innerHTML);
					r_tcount=parseInt(document.getElementById("has_resourcing_member").innerHTML);
					s_tcount=parseInt(document.getElementById("has_sales_member").innerHTML);
					e_tcount=parseInt(document.getElementById("has_execute_member").innerHTML);
					d_tcount=parseInt(document.getElementById("has_rd_team").innerHTML);
					var p=new Array(f_tcount,r_tcount,s_tcount,e_tcount,d_tcount);
					var r=new Array(fn_trate,rs_trate,ss_trate,ex_trate,rd_trate);
					
					for(var i=0; i<5; i++){
						var isvalid=check(p[i],r[i]);
						if(isvalid==false){
							alert("請確認部門人數在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
                   		$.ajax({
                       		url:"GET_training.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=update&decision1="+fn_trate+"&decision2="+rs_trate+"&decision3="+ss_trate+"&decision4="+ex_trate+"&decision5="+rd_trate,
                        	error:
                            	function(xhr) {alert('Ajax request 發生錯誤');},
                        	success: function(str){
								//alert(str);
                            	alert("Success!");
								location.href=('./employee_training.php');
								//journal();
                        	}
                    	});//end ajax
					 }
				});//end submit
            });//end ready func
			
			 function check(num,rate){
				if(num<1 && rate>0)
   					return false;
				else
  					return true;
			}

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
		function rate(field,rate){
			//alert(money);
			document.getElementById(field).innerHTML=money[(rate)];
			document.getElementById("show_cost").innerHTML=addCommas(parseInt(document.getElementById("fn_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("rs_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ss_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ex_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("rd_tcost").innerHTML.replace(/\,/g,'')));
			var f = field.replace("cost","rate");
			eval(f+"="+rate);
			}
        </script>
        <?php
        $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
        mysql_select_db("testabc_main", $connect);
		error_reporting(0);
        $temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='training';", $connect);
        $result = mysql_fetch_array($temp);
        $training = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);
		$cost=split('、',$training);
		echo $_GET["rate"];
		//echo $cost[0];
		echo "<script language=\"javascript\"> var money=new Array(\"0\",\"".$cost[0]."\",\"".$cost[1]."\",\"".$cost[2]."\");</script>";
		//echo $cost[0];
        ?>
  </head>
  <body>
    <div class="container-fluid">
    <h1>在職訓練</h1>
    <script type="text/javascript" src="../js/jquery_showstar.js"></script>
    	<script type="text/javascript" src="../star/training_jquery.rating.js"></script>
		<link href="../star/training_rating.css" rel="stylesheet"/>
    <div class="col-sm-12 col-sm-12 text-center" style="padding:0px;">
        <div class="hidden-xs col-sm-offset-2 col-sm-8 col-xs-12 ctm-divtable-top">
            <div class="col-sm-offset-2 col-sm-2 col-xs-12">
                <h3>員工人數</h3>
            </div>
            <div class="col-sm-2 col-xs-12">
                <h3>目前績效</h3>
            </div>
            <div class="col-sm-2 col-xs-12">
                <h3>滿意度</h3>
            </div>
            <div class="col-sm-2 col-xs-12">
                <h3>提升等級</h3>
            </div>
            <div class="col-sm-2 col-xs-12">
                <h3>費用</h3>
            </div>     
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-12 ctm-padding ctm-divpanel ctm-divtable-mid2">
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-head">
               <h3>財務人員</h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">人數</h3>
                <h3><span id="has_financial_member"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid2">
                <h3 class="visible-xs">績效</h3>
                <h3><span id="finan_efc"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">滿意度</h3>
                <h3><span id="finan_stf"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-btm">
                <h3 class="visible-xs">提升等級</h3>
                <h3><span class="rating" id="rate1"></span>
			     	<script type="text/javascript">
						$('#rate1').rating('./employee_training.php',{maxvalue:3, emp:"fn_tcost"});
                    </script></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding font-color">
                <h3>$ <span id="fn_tcost">0</span></h3>
            </div>     
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-12 ctm-padding ctm-divpanel ctm-divtable-mid">
            <div class="col-sm-2 col-xs-12 ctm-padding  ctm-divpanel-head">
               <h3>運籌人員</h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">人數</h3>
                <h3><span id="has_resourcing_member"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid2">
                <h3 class="visible-xs">績效</h3>
                <h3><span id="resour_efc"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">滿意度</h3>
                <h3><span id="resour_stf"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-btm">
                <h3 class="visible-xs">提升等級</h3>
                <h3><span class="rating" id="rate2"></span>
			        <script type="text/javascript">
						$('#rate2').rating('./employee_training.php',{maxvalue:3, emp:"rs_tcost"});
                    </script></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding font-color">
                <h3>$ <span id="rs_tcost">0</span></h3>
            </div>     
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-12 ctm-padding ctm-divpanel ctm-divtable-mid2">
            <div class="col-sm-2 col-xs-12 ctm-padding  ctm-divpanel-head">
               <h3>行銷業務</h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">人數</h3>
                <h3><span id="has_sales_member"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid2">
                <h3 class="visible-xs">績效</h3>
                <h3><span id="sales_efc"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">滿意度</h3>
                <h3><span id="sales_stf"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-btm">
                <h3 class="visible-xs">提升等級</h3>
                <h3><span class="rating" id="rate3"></span>
					<script type="text/javascript">	
						$('#rate3').rating('./employee_training.php',{maxvalue:3, emp:"ss_tcost"});
                    </script></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding font-color">
                <h3>$ <span id="ss_tcost">0</span></h3>
            </div>     
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-12 ctm-padding ctm-divpanel ctm-divtable-mid">
            <div class="col-sm-2 col-xs-12 ctm-padding  ctm-divpanel-head">
               <h3>行政人員</h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">人數</h3>
                <h3><span id="has_execute_member"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid2">
                <h3 class="visible-xs">績效</h3>
                <h3><span id="execu_efc"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">滿意度</h3>
                <h3><span id="execu_stf"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-btm">
                <h3 class="visible-xs">提升等級</h3>
                <h3><span class="rating" id="rate4"></span>
               		<script type="text/javascript">
						$('#rate4').rating('/employee_training.php',{maxvalue:3, emp:"ex_tcost"});
                    </script></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding font-color">
                <h3>$ <span id="ex_tcost">0</span></h3>
            </div>     
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-12 ctm-padding ctm-divpanel ctm-divtable-btm">
            <div class="col-sm-2 col-xs-12 ctm-padding  ctm-divpanel-head">
               <h3>研發團隊</h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">人數</h3>
                <h3><span id="has_rd_team"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid2">
                <h3 class="visible-xs">績效</h3>
                <h3><span id="rd_efc"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-4 ctm-padding ctm-divpanel-mid">
                <h3 class="visible-xs">滿意度</h3>
                <h3><span id="rd_stf"></span></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding ctm-divpanel-btm">
                <h3 class="visible-xs">提升等級</h3>
                <h3><span class="rating" id="rate5"></span>
		     		<script type="text/javascript">
						$('#rate5').rating('/employee_training.php',{maxvalue:3, emp:"rd_tcost"});
                    </script></h3>
            </div>
            <div class="col-sm-2 col-xs-12 ctm-padding font-color">
                <h3>$ <span id="rd_tcost">0</span></h3>
            </div>     
        </div>
        <div class="col-sm-12 col-xs-12 text-center margin-bottom">
            <h2>總訓練費用 : $<span id="show_cost">0</span></h2>
            <input id="submit" class="btn btn-danger" type="submit" value="Submit">
        </div>
        
        
        
        
    </div>    
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>