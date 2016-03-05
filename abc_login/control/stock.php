<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<link href="css/inceptiondev.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="js/inceptiondev.js"></script>
<style type="text/css">
	#DivLog{
		bottom:0;
		position: absolute;
		text-align:center;
		left:37%
		
	} 

	img{border: 0;}
	
	html,body{
		overflow-y:hidden; 

	}
     img{cursor:pointer;}
</style>	
<script>
	var datastock1 = [];	//股票市價
	var datastock2 = [];
	var datastock3 = [];
	var datastock4 = [];
	var datastock5 = [];
	var totalstockprice = new Array();
	for(var a=1;a<=5;a++){
		totalstockprice[a] = new Array(12);
	}
	var nowcompany;
$(document).ready(function() { 
 $.ajax({						
		  url:"chart_stock.php",
		  type:"GET",
		  dataType:"html",
		  success:function(xml){
			 
				updatestock(xml);

		  }
	});
	 
		function updatestock(xml){
		$("message",xml).each(function(id){
			message = $("message",xml).get(id);
			nowy = $('term',message).text();
			nowm = parseInt($('round',message).text());
			nowcompany = $('company',message).text();
		
			document.getElementById("chartchoosem").innerHTML = nowy;
			$('#containerstock'+nowy).show();
			if(nowy==1){
				for(i=1;i<=nowm;i++){
					num = "totalstockprice1"+i;
					totalstockprice[1][i] = parseInt($(num,message).text());	
				
								
				}
			}
			else{
				for(i=1;i<=nowm;i++){
					num = "totalstockprice"+nowy+i;
					totalstockprice[nowy][i] = parseInt($(num,message).text());	
								
				}
				for(j=1;j<nowy;j++){
					for(i=1;i<=12;i++){
						num = "totalstockprice"+j+i;
						totalstockprice[j][i] = parseInt($(num,message).text());	
									
					}
				}	
			
				
			}
		
		
				if(nowy>=1)
				{
					xmlstock1(nowm,nowy);
				}
				if(nowy>=2)
				{
					xmlstock2(nowm,nowy);
				}
				if(nowy>=3)
				{
					xmlstock3(nowm,nowy);
				}
				if(nowy>=4)
				{
					xmlstock4(nowm,nowy);
				}
				if(nowy>=5)
				{
					xmlstock5(nowm,nowy);
				}
				
			var term = $("term",message).text();
			for(i=1;i<=term;i++){
				 var text = "第"+i+"年";
				 var new_option = new Option(text,i);
				 document.formmonth.menumonth.options.add(new_option);
				 		 
			}
			document.formmonth.menumonth.options.selectedIndex = term-1;	
		
	
			
			
			});
	}	
	function xmlstock1(countm,county)
	{			
				var count;
				if(county==1)
				{
					count=countm;
				}
				else
				{
					count=12;
				}
				
				for(i=1;i<=count;i++)
				{
					
					datastock1.push(
						[i-1,totalstockprice[1][i]]
					)
					
					
				}
				return linestock(1,'containerstock1',datastock1);
	}
	function xmlstock2(countm,county)
	{			
				var count;
				if(county==2)
				{
					count=countm;
				}
				else
				{
					count=12;
				}
				
				for(i=1;i<=count;i++)
				{
					
					datastock2.push(
						[i-1,totalstockprice[2][i]]
					)
					
					
				}
				return linestock(2,'containerstock2',datastock2);
	}
	function xmlstock3(countm,county)
	{			
				var count;
				if(county==3)
				{
					count=countm;
				}
				else
				{
					count=12;
				}
				
				for(i=1;i<=count;i++)
				{
					
					datastock3.push(
						[i-1,totalstockprice[3][i]]
					)
					
					
				}
				return linestock(3,'containerstock3',datastock3);
	}
	function xmlstock4(countm,county)
	{			
				var count;
				if(county==4)
				{
					count=countm;
				}
				else
				{
					count=12;
				}
				
				for(i=1;i<=count;i++)
				{
					
					datastock4.push(
						[i-1,totalstockprice[4][i]]
					)
					
					
				}
				return linestock(4,'containerstock4',datastock4);
	}
	function xmlstock5(countm,county)
	{			
				var count;
				if(county==5)
				{
					count=countm;
				}
				else
				{
					count=12;
				}
				
				for(i=1;i<=count;i++)
				{
					
					datastock5.push(
						[i-1,totalstockprice[5][i]]
					)
					
					
				}
				return linestock(5,'containerstock5',datastock5);
	}
	function linestock(nowy,chartno,datat){ 
	  
	
	 chart = new Highcharts.Chart({
      chart: {
         renderTo: chartno,
         defaultSeriesType: 'line',
        
      },
      title: {
         text: '第'+nowy+'年-股票參考價格',
        
      },
      subtitle: {
         text: '',
        
      },
      xAxis: {
         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      yAxis: {
		  min: 0,
         title: {
            text: '價格',
			style: {
               color: '#000000'
            },
			margin: 60
         }, 
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }]
      },
      tooltip: {
         formatter: function() {
                   return '<b>'+ nowcompany +'</b><br/>'+
               this.x +': '+ this.y;
         }
      },
      legend: {
         layout: 'vertical',
         align: 'right',
         verticalAlign: 'top',
         x: -10,
         y: 100,
         borderWidth: 0
		 
      },plotOptions: {
					line: {
						dataLabels: {
            			   enabled: true
            			},
						
					}
				},
      series: [{
         name: '股票參考價格',
         data: datat
      }]
   });
	}//end
});//ready end
</script>	

<script language="javascript">

function swapDiv (){
var index = document.formmonth.menumonth.options
     [document.formmonth.menumonth
     .selectedIndex].value;


document.getElementById("chartchoosem").innerHTML = index;
$('div.chart').hide();

	$('#containerstock'+index).fadeIn();



}

</script>
<body>
<?php
	$company = $_SESSION['company_name'];
	
?>
<table align="center">
<tr>
<td>
<form id="formmonth" name="formmonth">
    <select name="menumonth" id="menumonth" onchange="swapDiv()">>
  
    
    </select>
</form>

<td>

<div id="containerstock1" class="chart" style="height:350px; width: 700px; margin: 0 auto; clear:both; display:none;"> 
</div> 
<div id="containerstock2" class="chart" style="height:350px; width: 700px; margin: 0 auto; clear:both; display:none;"> 
</div> 
<div id="containerstock3" class="chart" style="height:350px; width: 700px; margin: 0 auto; clear:both; display:none;"> 
</div> 
<div id="containerstock4" class="chart" style="height:350px; width: 700px; margin: 0 auto; clear:both; display:none;"> 
</div> 
<div id="containerstock5" class="chart" style="height:350px; width: 700px; margin: 0 auto; clear:both; display:none;"> 
</div> 


<span id="chartchoosem" style="display:none;" ></span>


</td>
</tr>
</table>
</body>
</html>