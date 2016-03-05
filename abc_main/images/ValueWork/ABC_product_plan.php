<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script language="JavaScript" src="../js/wz_jsgraphics.js"></script>
        <script type="text/javascript" src="../js/jsAnim.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type='text/javascript' src="../js/tooltip.js"></script>
        <script src="jquery.cluetip.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.query.js"></script>
        <script type="text/javascript" src="../js/jquery.cookie.js"></script>
        <script type="text/javascript" src="../js/tinybox.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/jquery.cluetip.css" type="text/css" />
    </head>
    <body class="noscript">
    	<?php
                /* 建立影像 (開始) */
				$image = imagecreate(120, 32);//建立一個影像大小為120*32的空白畫布
				$bgColor = imagecolorallocate($image, 240, 240, 240);
				$lineColor = imagecolorallocate($image, 87, 86, 74);  //定義線條顏色，此範例定為橘色
				imageline($image, 58, 2, 58, 28, $lineColor);  // 畫線

				imagejpeg($image, "draw.jpg");  //做成jpg圖檔並輸出
				imagedestroy($image);  //輸出完成後刪除掉原本暫存的圖檔 $image
				/* 建立影像 (結束) */ 
				/* 建立影像 (開始) */
				$image2 = imagecreate(120, 160);//建立一個影像大小為120*160的空白畫布
				$bgColor2 = imagecolorallocate($image2, 240, 240, 240);
				$lineColor2 = imagecolorallocate($image2, 87, 86, 74);  //定義線條顏色，此範例定為橘色
				imageline($image2, 58, 2, 58, 160, $lineColor2);  // 畫線

				imagejpeg($image2, "draw2.jpg");  //做成jpg圖檔並輸出
				imagedestroy($image2);  //輸出完成後刪除掉原本暫存的圖檔 $image
				/* 建立影像 (結束) */
		?>
                
        <div id="myCanvas"></div>
       <table class="process" align="left">
        	<tr>
            	<td></td>
                <td><img id="material_A" src="../images/material_A.png"></td>
                <td><img id="material_B" src="../images/material_B.png"></td>
                <td><img id="material_C" src="../images/material_C.png"></td>
            </tr>
            <tr>
            	<td></td>
                <td><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>人工檢料</td>
                <td><a href="#"><input type="button" name="button" value="人工小時" class="groovybutton1" id="monitor"></a></td>
                <td><a href="#"><input type="button" name="button" value="人工小時" class="groovybutton1" id="kernel"></a></td>
                <td><a href="#"><input type="button" name="button" value="人工小時" class="groovybutton1" id="keyboard"></a></td>
            </tr>
             <tr>
            	<td></td>
                <td><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>原料切割</td>
                <td colspan="3"><a href="#"><input type="button" name="button" value="切割次數" class="groovybutton3" id="cut"></a></td>
            </tr>
             <tr>
            	<td></td>
                <td><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
                <td rowspan="5"><img src = "./draw2.jpg"></td>
            </tr>
            <tr>
            	<td>組裝程序一</td>
                <td colspan="2"><input type="button" name="button" value="機具/小時" class="groovybutton3" id="combine1" /></td>
            </tr>
             <tr>
            	<td></td>
               <td colspan="2" align="center"><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>合成檢測</td>
                <td colspan="2"><a href="#"><input width="30%" type="button" name="button" value="檢驗次數" class="groovybutton1" id="check_s"></a></td>
            </tr>
             <tr>
            	<td></td>
                <td colspan="2" align="center"><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>組裝程序二</td>
                <td colspan="3"><a href="#"><input type="button" name="button" value="機具/小時" class="groovybutton3" id="combine2" /></a></td>
            </tr>
             <tr>
            	<td></td>
                <td colspan="2" align="center"><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>精密檢測</td>
                <td colspan="3"><a href="#"><input width="30%" type="button" name="button" value="檢驗次數" class="groovybutton1" id="check"></a></td>
            </tr>
            <tr>
            	<td></td>
                <td colspan="2" align="center"><img src = "./draw.jpg"></td>
                <td><img src = "./draw.jpg"></td>
            </tr>
            <tr>
            	<td>&nbsp;&nbsp;&nbsp;</td>
                <td align="center" colspan="2"><img id="product_B" src="../images/product_B.png"></td>
                <td align="center"><img id="product_A" src="../images/product_A.png"></td>
            </tr>
             <tr>
            	<td>&nbsp;&nbsp;</td>
                <td colspan="3" align="center"><br><input type="image" id="submit" src="../images/submit6.png" style="width:100px"></td>
            </tr>
        </table>   
    <!--    <a id="clue_monitor" rel="cluetip.php"><input type="image" width="14%" id="monitor" src="../images/monitor_human_hr.png"></a>
        <a id="clue_kernel" rel="cluetip.php"><input type="image" width="14%" id="kernel" src="../images/kernel_human_hr.png"></a>
        <a id="clue_keyboard" rel="cluetip.php"><input type="image" width="14%" id="keyboard" src="../images/keyboard_human_hr.png"></a>
        <input width="44%" type="image" id="cut" src="../images/cut_num.png">
        <input width="13%" type="image" id="combine1" src="../images/machine_hr_s_1.png">
        <a id="clue_check_s" rel="cluetip.php"><input width="13%" type="image" id="check_s" src="check_num_s.png"></a>
        <input width="13%" type="image" id="combine2" src="machine_hr_s_2.png">
        <a id="clue_check" rel="cluetip.php"><input width="42%" type="image" id="check" src="check_num.png"></a>
        
       
        
        <img width="13%" id="product_A" src="../images/product_A.png">
        <img width="13%" id="product_B" src="../images/product_B.png">
        <img width="13%" id="detect_0" src="../images/detect_0_name.png">
        <img width="13%" id="cut_name" src="../images/cut_name.png">
        <img width="13%" id="combine_1" src="../images/combine_1_name.png">
        <img width="13%" id="detect_1" src="../images/detect_1_name.png">
        <img width="13%" id="combine_2" src="../images/combine_2_name.png">
        <img width="13%" id="detect_2" src="../images/detect_2_name.png">-->
<!--        <table border="0"align="right">
            <tr><td><img id="pA" src="product_A.png"></td>
                <td>總成本：</td><td width=50><span id="costA">0</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><img id="pB" src="product_B.png"></td>
                <td>總成本：</td><td width=50><span id="costB">0</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td width=100></td><td><input type="image" id="submit" src="submit.png"></td></tr>
        </table>
        <br/><br/><br/><br/><br/>
        <table width="20%" height="20%">
        <tr><td><a href="" title="可針對生產作業流程進行規劃，廢除掉無經濟附加價值的作業流程，降低成本，提升公司價值。"><img width="100%" align="right" src="images/guide.png"></a></td></tr>
        <tr><td><input width="40%" type="image" id="submit" src="../images/submit6.png"></td></tr>
        </table>-->
       <script type="text/javascript">
            $(document).ready(function(){
                initial_get();
                $("#clue_monitor").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_monitor_pp"}
                });
                $("#clue_kernel").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_kernel_pp"}
                });
                $("#clue_keyboard").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_keyboard_pp"}
                });
                $("#clue_check_s").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_s_pp"}
                });
                $("#clue_check").cluetip({
                    cluetipClass: 'rounded',
                    dropShadow: false,
                    positionBy: 'mouse',
                    width: '150px',
                    ajaxSettings:{dataType:"html",data:"name=clue_check_pp"}
                });
            });
            function initial_get(){
                $.ajax({
                    url:"GET_product_plan.php",
                    type: "GET",
                    datatype: "html",
                    data: "option=get&type=pp",
                    success: function(str){
                        var word=str.split(":");
                        count1=word[0]
                        count2=word[1]
                        count3=word[2]
                        count4=word[3]
                        count5=word[4]
                        count6=word[5]
                        count7=word[6]
                        count8=word[7]
                        if(count1!=1)	_1.style.opacity=0.5;
                        if(count2!=1)	_2.style.opacity=0.5;
                        if(count3!=1)	_3.style.opacity=0.5;
                        if(count6!=1)	_6.style.opacity=0.5;
                        if(count8!=1)	_8.style.opacity=0.5;
                        cal_cost();
                    }
                });
            }
            var manager=new jsAnimManager(40);
            var _A=document.getElementById("material_A");
            var _B=document.getElementById("material_B");
            var _C=document.getElementById("material_C");
            var _1=document.getElementById("monitor");
            var _2=document.getElementById("kernel");
            var _3=document.getElementById("keyboard");
            var _4=document.getElementById("cut");
            var _5=document.getElementById("combine1");
            var _6=document.getElementById("check_s");
            var _7=document.getElementById("combine2");
            var _8=document.getElementById("check");
            var _PA=document.getElementById("product_A");
            var _PB=document.getElementById("product_B");
            var _N1=document.getElementById("detect_0");
            var _N2=document.getElementById("cut_name");
            var _N3=document.getElementById("combine_1");
            var _N4=document.getElementById("detect_1");
            var _N5=document.getElementById("combine_2");
            var _N6=document.getElementById("detect_2");
            var count1=1,count2=1,count3=1,count6=1,count8=1
            $("#monitor").click(function(){
                if(count1==1){
                    _1.style.opacity=0.5
                    count1=0
                }
                else{
                    _1.style.opacity=1
                    count1=1
                }
                cal_cost();
            });
            $("#kernel").click(function(){
                if(count2==1){
                    _2.style.opacity=0.5
                    count2=0
                }
                else{
                    _2.style.opacity=1
                    count2=1
                }
                cal_cost();
            });
            $("#keyboard").click(function(){
                if(count3==1){
                    _3.style.opacity=0.5
                    count3=0
                }
                else{
                    _3.style.opacity=1
                    count3=1
                }
                cal_cost();
            });
            $("#check_s").click(function(){
                if(count6==1){
                    _6.style.opacity=0.5
                    count6=0
                }
                else{
                    _6.style.opacity=1
                    count6=1
                }
                cal_cost();
            });
            $("#check").click(function(){
                if(count8==1){
                    _8.style.opacity=0.5
                    count8=0
                }
                else{
                    _8.style.opacity=1
                    count8=1
                }
                cal_cost();
            });
            $("#cut").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=cut,'+count4,boxid:'frameless',width:500,height:200,style:"z-index:2; top:20px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
            $("#combine1").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=combine1,'+count5,boxid:'frameless',width:500,height:200,style:"z-index:2; top:20px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
            $("#combine2").click(function(){
                TINY.box.show({iframe:'select_machine.html?type=combine2,'+count7,boxid:'frameless',width:500,height:200,style:"z-index:2; top:20px",fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){closeJS()}});
            });
            $("#submit").click(function(){
                var year_now=1,month_now=1;
                if($.cookie("cut"))
                    count4=$.cookie("cut");
                if($.cookie("combine1"))
                    count5=$.cookie("combine1");
                if($.cookie("combine2"))
                    count7=$.cookie("combine2");
                $.ajax({
                    url:"GET_product_plan.php",
                    type: "GET",
                    datatype: "html",
                    data: "option=update&type=pp&monitor="+count1+"&kernel="+count2+"&keyboard="+count3+"&cut="+count4+"&combine1="+count5+"&check_s="+count6+"&combine2="+count7+"&check="+count8,
                    success: function(str){
                        alert("SUCCESS~!!");
                        parent.get_RD();
                        parent.get_machine();
                    }
                });
            });
            function cal_cost(){
                $.ajax({
                    url:"GET_product_plan.php",
                    type: "GET",
                    datatype: "html",
                    data: "option=fix_cost&type=pp&monitor="+count1+"&kernel="+count2+"&keyboard="+count3+"&cut="+count4+"&combine1="+count5+"&check_s="+count6+"&combine2="+count7+"&check="+count8,
                    success: function(str){
                        cost=str.split(";");
                        document.getElementById("costA").textContent=cost[1];
                        document.getElementById("costB").textContent=cost[0];
                    }
                })
            }
         /*   manager.registerPosition("material_A",false);
            _A.setPosition(-150,0);
            manager.registerPosition("material_B",false);
            _B.setPosition(-30,0);
            manager.registerPosition("material_C",false);
            _C.setPosition(80,0);
            manager.registerPosition("monitor",false);
            _1.setPosition(-135,60);
            manager.registerPosition("kernel",false);
            _2.setPosition(-20,60);
            manager.registerPosition("keyboard",false);
            _3.setPosition(95,60);
            manager.registerPosition("cut",false);
            _4.setPosition(-20,100);
            manager.registerPosition("combine1",false);
            _5.setPosition(-80,140);
            manager.registerPosition("check_s",false);
            _6.setPosition(-40,180);
            manager.registerPosition("combine2",false);
            _7.setPosition(0,215);
            manager.registerPosition("check",false);
            _8.setPosition(-20,255);
            manager.registerPosition("product_B",false);
            _PB.setPosition(-100,290);
            manager.registerPosition("product_A",false);
            _PA.setPosition(10,290);
            manager.registerPosition("detect_0",false);
            _N1.setPosition(-250,60);
            manager.registerPosition("cut_name",false);
            _N2.setPosition(-250,100);
            manager.registerPosition("combine_1",false);
            _N3.setPosition(-250,140);
            manager.registerPosition("detect_1",false);
            _N4.setPosition(-250,180);
            manager.registerPosition("combine_2",false);
            _N5.setPosition(-250,220);
            manager.registerPosition("detect_2",false);
            _N6.setPosition(-250,260);

            var cnv=document.getElementById("myCanvas");
            var jg=new jsGraphics(cnv);
            jg.setColor('#0000FF');
            jg.setStroke(2);
            jg.drawLine(200,35,200,160);
            jg.paint();
            jg.drawLine(200,160,240,160);
            jg.paint();
            jg.drawLine(310,35,310,160);
            jg.paint();
            jg.drawLine(310,160,290,160);
            jg.paint();
            jg.drawLine(420,35,420,240);
            jg.paint();
            jg.drawLine(420,240,360,240);
            jg.paint();
            jg.drawLine(280,200,280,240);
            jg.paint();
            jg.drawLine(280,240,320,240);
            jg.paint();
            jg.drawLine(240,180,240,330);
            jg.paint();
            jg.drawLine(240,200,290,200);
            jg.paint();
            jg.drawLine(340,250,340,330);
            jg.paint();*/
        </script>
    </body>
</html>
