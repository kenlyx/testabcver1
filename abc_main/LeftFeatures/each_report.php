<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="jquery.js"></script>
        <style type="text/css">
             div.month{
                 margin:0px;
                margin-left:auto;
                margin-right:auto;
                width: 80px;
                padding:5px;
                background:#e5eecc;
                border:solid 1px #c3c3c3;
            }
            .drag{
                position: absolute;
            }
            .close{
                float: right; margin: 3px; border: 0px;
            }
            #d1{
                left: 50px;
                top: 60px;
                filter: alpha(opacity=85,style=0);
                -moz-opacity: 0.85;
                opacity: 0.85;
                border: 1px solid #ccc;
                z-index: 3;
                background-color: #dfd;
                padding: 3px;
            }
            #d2{
                left: 140px;
                top: 80px;
                filter: alpha(opacity=75,style=0);
                -moz-opacity: 0.75;
                opacity: 0.75;
                border: 1px solid #ccc;
                z-index: 3;
                background-color: #ddf;
                padding: 3px;
            }
            #d3{
                left: 90px;
                top: 140px;
                filter: alpha(opacity=95,style=0);
                -moz-opacity: 0.95;
                opacity: 0.95;
                border: 1px solid #ccc;
                z-index: 3;
                background-color: #fdd;
                padding: 3px;
            }
            .comment{
                background-color: #fff;
                margin: 3px 0 0;
            }
        </style>
        <script type="text/javascript">
            function anime(id){
                if(id == "d3"){
                    $("#d1").fadeOut(500);
                    $("#d2").fadeOut(500);
                    $("#d3").animate({width:1200},"slow");
                    $("#d3").animate({height:1250},"slow");
                }
                if(id == "d2"){
                    $("#d1").fadeOut(500);
                    $("#d3").fadeOut(500);
                    $("#d2").animate({width:1230},"slow");
                    $("#d2").animate({height:925},"slow");
                }
                if(id == "d1"){
                    $("#d2").fadeOut(500);
                    $("#d3").fadeOut(500);
                    $("#d1").animate({width:1150},"slow");
                    $("#d1").animate({height:900},"slow");
                }
                
            }

            $(document).ready(function(){
               $("#open_d3").click(function(){
                   $("#d3").load("pre_report.html");
               });
               $("#open_d2").click(function(){
                   $("#d2").load("pre_report_2.html");
               });
               $("#open_d1").click(function(){
                   $("#d1").load("pre_report_3.html");
               });
            });
        </script>
    </head>
    <body background="images/bigreport_bg.jpg">
        <div id="d2" class="drag" style="height:300px;width:300px;left:30px;top:30px">
            <font size='4' color='darkslateblue' face='標楷體'>財務狀況表</font><a href="javascript:anime('d2');"><input type="image" id="open_d2" src="images/enter.png" alt="關閉" class="close"/></a>
        </div>
        <div id="d3" class="drag" style="height:300px;width:300px;left:60px;top:80px">
            <font size='4' color='darkslateblue' face='標楷體'>綜合損益表</font><a href="javascript:anime('d3');"><input type="image" id="open_d3" src="images/enter.png" alt="關閉" class="close"/></a>
        </div>
        <div id="d1" class="drag" style="height:300px;width:300px;left:90px;top:130px">
            <font size='4' color='darkslateblue' face='標楷體'>現金流量表</font><a href="javascript:anime('d1');"><input type="image" id="open_d1" src="images/enter.png" alt="關閉" class="close"/></a>
        </div>
     </body>
</html>