<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>donate_share</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/donateshare.css" rel="stylesheet">
      <script type="text/javascript" src="../js/jquery.js"></script>
      <?php
        $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
        mysql_select_db("testabc_main", $connect);
		error_reporting(0);
		//donate
        $temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='donate';", $connect);
        $result = mysql_fetch_array($temp);
        $donate = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);
		$cost_d=split('、',$donate);
		echo $_GET["rate"];
		//echo $cost[0];
		echo "<script language=\"javascript\">var money_d=new Array(\"0\",\"".$cost_d[0]."\",\"".$cost_d[1]."\",\"".$cost_d[2]."\");</script>";
		
		//share1
		$sql_s1= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share1';", $connect);
        $s1 = mysql_fetch_array($sql_s1);
        $share1 = number_format($s1['money']) . "、" . number_format($s1['money2']) . "、" . number_format($s1['money3']);
		$cost_s1=split('、',$share1);
		echo "<script language=\"javascript\">var money_s1=new Array(\"0\",\"".$cost_s1[0]."\",\"".$cost_s1[1]."\",\"".$cost_s1[2]."\");</script>";
		//share2
		$sql_s2= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share2';", $connect);
        $s2 = mysql_fetch_array($sql_s2);
        $share2 = number_format($s2['money']) . "、" . number_format($s2['money2']) . "、" . number_format($s2['money3']);
		$cost_s2=split('、',$share2);
		echo "<script language=\"javascript\">var money_s2=new Array(\"0\",\"".$cost_s2[0]."\",\"".$cost_s2[1]."\",\"".$cost_s2[2]."\");</script>";
		//share3
		$sql_s3= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share3';", $connect);
        $s3 = mysql_fetch_array($sql_s3);
        $share3 = number_format($s3['money']) . "、" . number_format($s3['money2']) . "、" . number_format($s3['money3']);
		$cost_s3=split('、',$share3);
		echo "<script language=\"javascript\">var money_s3=new Array(\"0\",\"".$cost_s3[0]."\",\"".$cost_s3[1]."\",\"".$cost_s3[2]."\");</script>";
		
        ?>
      <script type="text/javascript">
             var count_01=0; count_02=0; count_03=0;
			 var count_04=0; count_05=0; count_06=0;
            
			$(document).ready(function(){
                
			   initial_get_d();
			   initial_get_s();
			   
               function initial_get_d(){
                  $.ajax({
                     url:"GET_donate.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_01=parseInt(word[0],10);
                              count_02=parseInt(word[1],10);
                              count_03=parseInt(word[2],10);
							  fa_rate=count_01;
                              op_rate=count_02;
							  ds_rate=count_03;
							  $('#rate1').rating('./donate_share.php',{maxvalue:3, emp:"fa_cost",curvalue:count_01});
							  $('#rate2').rating('./donate_share.php',{maxvalue:3, emp:"op_cost",curvalue:count_02});
							  $('#rate3').rating('./donate_share.php',{maxvalue:3, emp:"ds_cost",curvalue:count_03});
						   }
                        }
                    });
                }//end func(initial_d)
				   function initial_get_s(){
                  $.ajax({
                     url:"GET_share.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_04=parseInt(word[0],10);
                              count_05=parseInt(word[1],10);
                              count_06=parseInt(word[2],10);
							  cm_rate=count_04;
							  en_rate=count_05;
							  eh_rate=count_06;
							  $('#rate4').rating('./donate_share.php',{maxvalue:3, emp:"cm_cost",curvalue:count_04});
							  $('#rate5').rating('./donate_share.php',{maxvalue:3, emp:"en_cost",curvalue:count_05});
							  $('#rate6').rating('./donate_share.php',{maxvalue:3, emp:"eh_cost",curvalue:count_06});
						   }
                        }
                    });
                }//end func(initial_s)
				
				$("#submit_d").click(function(){
                    	$.ajax({
                        	url:"GET_donate.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=update&decision1="+fa_rate+"&decision2="+op_rate+"&decision3="+ds_rate,
                        	success: function(str){
                            	alert("Success!");
								location.href=('./donate_share.php');
							//journal();
                        	}
                    	});
                });//end submit(d)
				
			    $("#submit_s").click(function(){
						$.ajax({
                       		url:"GET_share.php",
                       		type: "GET",
                       		datatype: "html",
                       		data: "option=update&decision4="+cm_rate+"&decision5="+en_rate+"&decision6="+eh_rate,
                       		success: function(str){
                            	alert("Success!");
								location.href=('./donate_share.php');
						//journal();
                        	}
                    	});
                });//end submit(s)
				
            });//end ready func()
			 
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
				if(field=="fa_cost"|| field=="op_cost"|| field=="ds_cost"){
					document.getElementById(field).innerHTML=money_d[(rate)];
					//alert(field);
				}else{
					if(field=="cm_cost"){
						document.getElementById(field).innerHTML=money_s1[(rate)];
						//alert(field);
						}else
					if(field=="en_cost"){
						document.getElementById(field).innerHTML=money_s2[(rate)];
						//alert(field);
						}else
					if(field=="eh_cost"){
						document.getElementById(field).innerHTML=money_s3[(rate)];
						//alert(field);
						}
				}
				var f = field.replace("cost","rate");
				eval(f+"="+rate);
				//eval(field+"_rate")=rate;
				//s.push(field+"："+rate);
				//alert(field+"："+rate);	
				//alert(field+":"+eval(field+"r"));
				//alert(fa_rate);
				show_cost();	
			}
						
			function show_cost(){
				document.getElementById("show_cost_d").innerHTML=addCommas(
															parseInt(document.getElementById("fa_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("op_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ds_cost").innerHTML.replace(/\,/g,''))
															);
				document.getElementById("show_cost_s").innerHTML=addCommas(
															parseInt(document.getElementById("cm_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("en_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("eh_cost").innerHTML.replace(/\,/g,''))
															);		
			}
        </script>
  </head>
  <body>
    <div class="container-fluid">
    <h1>產品差異化 <small style="color:#ff0000;"> * 使企業產品、服務、企業形象等與競爭對手有明顯的區別，以獲得競爭優勢 *</small></h1>
        <script type="text/javascript" src="../star/donate_jquery.rating.js"></script>
		<link href="../star/donate_rating.css" rel="stylesheet"/>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-laptop"></i> 筆電差異化</h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-tablet"></i> 平板差異化</h2></a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">
 <!---------------------------半導體晶圓----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-connectdevelop"></i> 半導體晶圓</h1></div>
            <div class="panel-body">
                <p>1.晶圓越大，同一圓片上可生產的IC就越多，但對材料技術和生產技術的要求更高！<br>
2.各等級花費 ：$100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate1"></span><script type="text/javascript">
						$('#rate1').rating('./donate_share.php',{maxvalue:3, emp:"fa_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="fa_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
    
 <!---------------------------多核心處理器----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-server"></i> 多核心處理器</h1></div>
            <div class="panel-body">
                <p>1.核心可以獨立執行程式指令，利用平行計算的能力，可以加快程式的執行速度，提供多工能力。<br>
2.升級花費： $100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate2"></span>
						<script type="text/javascript">
						$('#rate2').rating('./donate_share.php',{maxvalue:3, emp:"op_cost"});
                    	</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="op_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div> <!---------------------------顯示器----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-desktop"></i> 顯示器</h1></div>
            <div class="panel-body">
                <p>1.提升螢幕品質，解析度、反應時間、對比度<br>
2.各等級花費 ：$100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate3">
						<script type="text/javascript">
						$('#rate3').rating('./donate_share.php',{maxvalue:3, emp:"ds_cost"});
                    	</script>
                        </span></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="ds_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
      
          <!----------------------------總費用和按鈕--------------------------------->
    <div class="col-sm-12 text-center"><h3>總費用 : $<span id ="show_cost_d">0</span></h3></div>
    <div class="col-sm-12 text-center subnitmargin"><input id="submit_d" class="btn btn-primary btn-lg" type="submit"></div>
      
    </div>

<!----------------------平板差異化-------------->
  <div role="tabpanel" class="tab-pane fade" id="profile"> 

     <!---------------------------觸控螢幕----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1 ><i class="fa fa-hand-o-down" style="border-bottom: solid 5px #fff;"></i> 觸控螢幕</h1></div>
            <div class="panel-body">
                <p>1.提升觸控靈敏度，多點觸控之準確性螢幕整體的解析度<br>
2.各等級花費 ： $100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate4"></span>
						<script type="text/javascript">
						$('#rate4').rating('./donate_share.php',{maxvalue:3, emp:"cm_cost"});
                    	</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="cm_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
    
 <!---------------------------記憶體----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-hdd-o"></i> 記憶體</h1></div>
            <div class="panel-body">
                <p>1.能同時間處理更多的工作，降低閃退、當機問題<br>
2.升級花費： $100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate5"></span>
						<script type="text/javascript">
						$('#rate5').rating('./donate_share.php',{maxvalue:3, emp:"en_cost"});
                    	</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="en_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div> <!---------------------------多核心處理器----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-server"></i> 多核心處理器</h1></div>
            <div class="panel-body">
                <p>1.核心可以獨立執行程式指令，利用平行計算的能力，可以加快程式的執行速度，提供多工能力！<br>
2.升級花費：$100,000 $200,000 $300,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate6"></span>
						<script type="text/javascript">
						$('#rate6').rating('./donate_share.php',{maxvalue:3, emp:"eh_cost"});
                    	</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="eh_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
      
          <!----------------------------總費用和按鈕--------------------------------->
    <div class="col-sm-12 text-center"><h3>總費用 : $<span id ="show_cost_s">0</span></h3></div>
    <div class="col-sm-12 text-center subnitmargin"><input id="submit_s" class="btn btn-primary btn-lg" href="#" type="submit"></div>
    
    
    
    
    </div>
</div>

        
</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>