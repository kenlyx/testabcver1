<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>advertisement</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/advertisement.css" rel="stylesheet">
      <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
               initial_get_A();
			   initial_get_B();
			   
               function initial_get_A(){
                  $.ajax({
                     url:"adDB.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=getA",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_01=parseInt(word[0],10);
                              count_02=parseInt(word[1],10);
                              count_03=parseInt(word[2],10);
							  lnet_rate=count_01;
                              ltv_rate=count_02;
							  lnp_rate=count_03;
							  $('#rate1').rating('./advertisement.php',{maxvalue:3, emp:"lnet_cost",curvalue:count_01});
							  $('#rate2').rating('./advertisement.php',{maxvalue:3, emp:"ltv_cost",curvalue:count_02});
							  $('#rate3').rating('./advertisement.php',{maxvalue:3, emp:"lnp_cost",curvalue:count_03});
						   }
                        }
                    });
                }//end func(initial_A)
				   function initial_get_B(){
                  $.ajax({
                     url:"adDB.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=getB",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_04=parseInt(word[0],10);
                              count_05=parseInt(word[1],10);
                              count_06=parseInt(word[2],10);
							  tnet_rate=count_04;
							  ttv_rate=count_05;
							  tnp_rate=count_06;
							  $('#rate4').rating('./advertisement.php',{maxvalue:3, emp:"tnet_cost",curvalue:count_04});
							  $('#rate5').rating('./advertisement.php',{maxvalue:3, emp:"ttv_cost",curvalue:count_05});
							  $('#rate6').rating('./advertisement.php',{maxvalue:3, emp:"tnp_cost",curvalue:count_06});
						   }
                        }
                    });
                }//end func(initial_s)
				
				$("#submit_l").click(function(){
                    	$.ajax({
                        	url:"adDB.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=updateA&decision1="+lnet_rate+"&decision2="+ltv_rate+"&decision3="+lnp_rate,
                        	success: function(str){
                            	alert("Success!");
							//journal();
                        	}
                    	});
                });//end submit(d)
				
			    $("#submit_t").click(function(){
						$.ajax({
                       		url:"adDB.php",
                       		type: "GET",
                       		datatype: "html",
                       		data: "option=updateB&decision1="+tnet_rate+"&decision2="+ttv_rate+"&decision3="+tnp_rate,
                       		success: function(str){
                            alert("Success!");
						//journal();
                        	}
                    	});
                });//end submit(s)
            });
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
			
			//alert(money_a1);
			if(field=="lnet_cost")
				document.getElementById("lnet_cost").innerHTML=money_a1[(rate)];
			else if(field=="ltv_cost")	
				document.getElementById("ltv_cost").innerHTML=money_a2[(rate)];
			else if(field=="lnp_cost")
				document.getElementById("lnp_cost").innerHTML=money_a3[(rate)];
			else if(field=="tnet_cost")
				document.getElementById("tnet_cost").innerHTML=money_b1[(rate)];
			else if(field=="ttv_cost")
				document.getElementById("ttv_cost").innerHTML=money_b2[(rate)];
			else if(field=="tnp_cost")
				document.getElementById("tnp_cost").innerHTML=money_b3[(rate)];

			document.getElementById("lap_total").innerHTML=addCommas(parseInt(document.getElementById("lnet_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ltv_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("lnp_cost").innerHTML.replace(/\,/g,''))
															);
		    document.getElementById("tab_total").innerHTML=addCommas(parseInt(document.getElementById("tnet_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ttv_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("tnp_cost").innerHTML.replace(/\,/g,''))
			
													);
			var f = field.replace("cost","rate");
			eval(f+"="+rate);
			//eval(field+"_rate")=rate;
			//s.push(field+"："+rate);
			//alert(field+"："+rate);	
			//alert(field+":"+eval(field+"r"));
			//alert(field);
			}
						
        </script>
<?php
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
error_reporting(0);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a1';", $connect);
$result = mysql_fetch_array($temp);
$ad_a1 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a2';", $connect);
$result = mysql_fetch_array($temp);
$ad_a2 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a3';", $connect);
$result = mysql_fetch_array($temp);
$ad_a3 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b1';", $connect);
$result = mysql_fetch_array($temp);
$ad_b1 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b2';", $connect);
$result = mysql_fetch_array($temp);
$ad_b2 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b3';", $connect);
$result = mysql_fetch_array($temp);
$ad_b3 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

	echo $_GET["rate"];
	$cost_a1=split('、',$ad_a1);
	//echo $ad_a1[0]."|".$ad_a1[1]."|".$ad_a1[2];
	echo "<script language=\"javascript\"> var money_a1=new Array(\"0\",\"".$cost_a1[0]."\",\"".$cost_a1[1]."\",\"".$cost_a1[2]."\");</script>";
	
	$cost_a2=split('、',$ad_a2);
	echo "<script language=\"javascript\"> var money_a2=new Array(\"0\",\"".$cost_a2[0]."\",\"".$cost_a2[1]."\",\"".$cost_a2[2]."\");</script>";
		
	$cost_a3=split('、',$ad_a3);
	echo "<script language=\"javascript\"> var money_a3=new Array(\"0\",\"".$cost_a3[0]."\",\"".$cost_a3[1]."\",\"".$cost_a3[2]."\");</script>";
		
	$cost_b1=split('、',$ad_b1);
	echo "<script language=\"javascript\"> var money_b1=new Array(\"0\",\"".$cost_b1[0]."\",\"".$cost_b1[1]."\",\"".$cost_b1[2]."\");</script>";
		
	$cost_b2=split('、',$ad_b2);
	echo "<script language=\"javascript\"> var money_b2=new Array(\"0\",\"".$cost_b2[0]."\",\"".$cost_b2[1]."\",\"".$cost_b2[2]."\");</script>";
		
	$cost_b3=split('、',$ad_b3);
	//echo $cost[0];
	echo "<script language=\"javascript\"> var money_b3=new Array(\"0\",\"".$cost_b3[0]."\",\"".$cost_b3[1]."\",\"".$cost_b3[2]."\");</script>";
?>
      
  </head>
  <body>
    <div class="container-fluid">
    <h1>廣告促銷 <small style="color:#ff0000;">* 廣告促銷的效用為：知名度增加，企業形象依等級提升*</small></h1>
        <script type="text/javascript" src="../star/donate_jquery.rating.js"></script>
		<link href="../star/donate_rating.css" rel="stylesheet"/>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-laptop"></i> 筆記型電腦</h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2 class="tabfont"><i class="fa fa-tablet"></i> 平板電腦</h2></a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">
 <!---------------------------網路廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-globe"></i> 網路廣告</h1></div>
            <div class="panel-body">
                <p>在各大搜尋網站刊登廣告，增加曝光率
各等級花費：為$2,000、$4,000、$6,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate1"></span> 
						<script type="text/javascript">
							$('#rate1').rating('./advertisement.php',{maxvalue:3, emp:"lnet_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="lnet_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
    
 <!---------------------------電視廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-desktop"></i> 電視廣告</h1></div>
            <div class="panel-body">
                <p>讓您的產品上電視，成為推廣品牌的最佳利器
各等級花費：$4,000、$8,000、$12,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate2"></span> 
						<script type="text/javascript">
							$('#rate2').rating('./advertisement.php',{maxvalue:3, emp:"ltv_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="ltv_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div> <!---------------------------報章雜誌廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-newspaper-o"></i> 報章雜誌廣告</h1></div>
            <div class="panel-body">
                <p>讓產品出現在報章雜誌上，吸引潛在消費者
各等級花費：$10,000、$20,000、$30,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate3"></span> 
						<script type="text/javascript">
							$('#rate3').rating('./advertisement.php',{maxvalue:3, emp:"lnp_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="lnp_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
      
          <!----------------------------總費用和按鈕--------------------------------->
    <div class="col-sm-12 text-center"><h3>總費用 : $<span id ="lap_total">0</span></h3></div>
    <div class="col-sm-12 text-center subnitmargin"><input id="submit_d" class="btn btn-primary btn-lg" type="submit"></div>
      
    </div>

<!----------------------平板電腦-------------->
  <div role="tabpanel" class="tab-pane fade" id="profile"> 

   <!---------------------------網路廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-globe"></i> 網路廣告</h1></div>
            <div class="panel-body">
                <p>在各大搜尋網站刊登廣告，增加曝光率
各等級花費：為$2,000、$4,000、$6,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate4"></span> 
						<script type="text/javascript">
							$('#rate4').rating('./advertisement.php',{maxvalue:3, emp:"tnet_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="tnet_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
    
 <!---------------------------電視廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-desktop"></i> 電視廣告</h1></div>
            <div class="panel-body">
                <p>讓您的產品上電視，成為推廣品牌的最佳利器
各等級花費：$4,000、$8,000、$12,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 : <span class="rating" id="rate5"></span> 
						<script type="text/javascript">
							$('#rate5').rating('./advertisement.php',{maxvalue:3, emp:"ttv_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="ttv_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div> <!---------------------------報章雜誌廣告----------------------->
    <div class="col-sm-4  ctm-padding">
        <div class="panel panel-primary panel-margin">
            <!-- Default panel contents -->
            <div class="panel-heading"><h1><i class="fa fa-newspaper-o"></i> 報章雜誌廣告</h1></div>
            <div class="panel-body">
                <p>讓產品出現在報章雜誌上，吸引潛在消費者
各等級花費：$10,000、$20,000、$30,000</p>
            </div>
            <div class="panel-body ctm-padding" >
                <div class="alert alert-info" role="alert">等級 :<span class="rating" id="rate6"></span> 
						<script type="text/javascript">
							$('#rate6').rating('./advertisement.php',{maxvalue:3, emp:"tnp_cost"});
						</script></div>        
                <div class="alert alert-danger" role="alert">費用 : $<span id="tnp_cost">0</span></div>  
                
                
                
            </div> <!---------end panel body-------->
        </div> <!---------end panel------->
    </div>
      
          <!----------------------------總費用和按鈕--------------------------------->
    <div class="col-sm-12 text-center"><h3>總費用 : $<span id ="tab_total">0</span></h3></div>
    <div class="col-sm-12 text-center subnitmargin"><input id="submit_d" class="btn btn-primary btn-lg" type="submit"></div>
      
    </div>
    
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