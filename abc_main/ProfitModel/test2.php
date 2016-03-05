<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
 <script type="text/javascript" src="../../../../../Users/carter/Downloads/js/stockprice_lineChart.js"></script>
<script>
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '股價折線圖',
                //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: '股價 (元)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '元'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: '公司股價',
                data: [20.0, 19.9, 18.6, 17.7, 21.2, 15.3, 23.1, 24.2, 23.3, 18.3]
            },  ]
        });
    });
    

</script>

</head>
<body>
<?php    

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    
mysql_select_db("testabc_main", $connect);
    
mysql_query("set names 'utf8'");

$test=mysql_query("SELECT `value` from `parameter_description` ") or die(mysql_error());
$result_temp=mysql_fetch_array($test);

echo $result_temp[0]+'fuk u';

?>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</body>
</html>
