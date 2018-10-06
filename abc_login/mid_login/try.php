<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="../css/menu.css"/>
<link rel="stylesheet" href="../css/drag.css"/>
</head>
<body>
<?php
  include("../connMysql.php");
  if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
  mysql_query("set names 'utf8'");/*
  $sql_year = mysql_query("SELECT MAX(`year`) FROM `state`");
  $result = mysql_fetch_array($sql_year);*/
  //$_SESSION['year']=$result[0];
  $year =$_SESSION['year'];
  
  /*$sql_month = mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`='$year'");
  $result = mysql_fetch_array($sql_month);*/
  //$_SESSION['month'] = $result[0];
  $month=$_SESSION['month'];
  
  $login_ceo=$_SESSION["user"];
	
	mysql_select_db("testabc_login"); 
	//join table, 把cid加進authority
	$sql_join = "SELECT b.*,`CompanyID` FROM `account` a JOIN `authority` b ON a.Account=b.Account";
	$result = mysql_query($sql_join);
	$join = mysql_fetch_array($result); //0=year,1=account,2=position,3=isceo,4=decision,5=cid   
    //取得競賽名稱
	$temp=mysql_query("SELECT `GameName` FROM `game`");
	$result_temp=mysql_fetch_array($temp);
	$gamename=$result_temp[0];
	
	if($year==1){
		//取得總經理資料
    	$sql_ceo = "SELECT * FROM `account` where `Account`='$login_ceo'";
		$result = mysql_query($sql_ceo);
    	$ceo= mysql_fetch_array($result);
		
		//取得公司非總經理的members
		$cid = $ceo['CompanyID'];
		$sql_all = mysql_query("SELECT `sid` FROM `student_list` WHERE `cid`='$cid' and `isCaptain`='0'");
		$num = mysql_num_rows($sql_all); //公司總人數-1(不算ceo)
		$cnum=$num+1; 
		
		//將此公司的所有帳號存進陣
		$acc[0]=$login_ceo;
		$i=1;
		while($member=mysql_fetch_array($sql_all)){
			$acc[$i]=$member[0];
			$i++;
			}
		//echo $acc[6];	
	}
	else{
		$sql_ceo = "SELECT * FROM `$join` where `Account`='$login_ceo' and `isceo`='1'";
		$result = mysql_query($sql_ceo);
    	$ceo= mysql_fetch_array($result);
		
		//取得公司members
		$cid = $ceo['CompanyID'];
		$sql_all = mysql_query("SELECT `Account` FROM `$join` WHERE `CompanyID`='$cid' and `isceo`='0'");
	    $num = mysql_num_rows($sql_all); //公司總人數-1
	    $cnum=$num+1; 
		
		//將此公司的所有帳號存進陣
		$acc[0]=$login_ceo;
		$i=1;
		while($member=mysql_fetch_array($sql_all)){
			$acc[$i]=$member[0];
			$i++;
			}
	}
//Submit Decisions
if(isset(mysql_real_escape_string($_POST["subdecision"]))&&mysql_real_escape_string($_POST["subdecision"])==true){
	$place1=split(",",mysql_real_escape_string($_POST["place1"]));
	$place2=split(",",mysql_real_escape_string($_POST["place2"]));
	$place3=split(",",mysql_real_escape_string($_POST["place3"]));
	$place4=split(",",mysql_real_escape_string($_POST["place4"]));
	$place5=split(",",mysql_real_escape_string($_POST["place5"]));
	$place6=split(",",mysql_real_escape_string($_POST["place6"]));
	$place7=split(",",mysql_real_escape_string($_POST["place7"]));
	$pos=split(",",mysql_real_escape_string($_POST["pos"]));
	$ceois=mysql_real_escape_string($_POST["ceo"]);
	echo $pos[1];
	for($i=2;$i<=$cnum;$i++){
		if($place{$i}==""){
			echo false;
			break;
		}
	}
	
	for($i=1;$i<=7;$i++){
			$j=$i-1;
			$temppos=$pos[$i-1];
		//Is CEO!
		if($i==$ceois){
     		$isceo=1;
			$sql="INSERT INTO `authority` (`Year`,`Account`,`Position`,`isceo`,`Decision`) VALUES ($year,$acc[$j],'$temppos','$isceo','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19')";
			mysql_query($sql);
		}
		else
			$isceo=0;
		$sql="INSERT INTO `authority` (`Year`,`Account`,`Position`,`isceo`,`Decision`) VALUES ($year,$acc[$j],'$temppos','$isceo','".implode(",",${place.$i})."')";
		if(is_numeric(${place.$i}[0]))
			mysql_query($sql);
		}
	
		
}
//將決策寫入資料庫 place1第一個人的決策區,C1-1(第一列第一個圖)...以此類推
$place=mysql_real_escape_string($_POST["place"]);
$job=mysql_real_escape_string($_POST["job"]);

if($place=="place1"){
	
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i-$j"){
				echo "<response><message><new>$job</new></message></response>" ;
			}
		}
	}
	
}

if($place=="place2"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition2[]=array("C$i_$j");		    
			}
		}
	}
}
if($place=="place3"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition3[]=array("C$i_$j");		    
			}
		}
	}
}
if($place=="place4"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition4[]=array("C$i_$j");		    
			}
		}
	}
}
if($place=="place5"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition5[]=array("C$i_$j");		    
			}
		}
	}
}
if($place=="place6"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition6[]=array("C$i_$j");		    
			}
		}
	}
}
if($place=="place7"){
	for($i=1;$i<=5;$i++){
		for($j=1;$j<=4;$j++){
			if($job=="C$i_$j"){
				 $decition7[]="C$i_$j";		    
			}
		}
	}
}

	
?>
<script src="../js/jquery-1.3.2.js"></script>
<script src="../js/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	if(<?php echo $cnum; ?> ==6){
	  $('#person7').hide();
	}
	if(<?php echo $cnum; ?> ==5){
	  $('#person7').hide();
	  $('#person6').hide();
	}
	if(<?php echo $cnum; ?> ==4){
	  $('#person7').hide();
	  $('#person6').hide();
	  $('#person5').hide();
	}

});

function inputTipText(){    
    $("input[class*=grayTips]")
	
	 //所有樣式名中含有grayTips的input  
	.each(function(){   
        var oldVal=$(this).val();   //默認的提示性文字   
		$(this)   
		.css({"color":"#888"})
		  //灰色
		.focus(function(){ 
			if($(this).val()!=oldVal){
				$(this).css({"color":"#000"})
			}else{$(this).val("").css({"color":"#888"} )} 
			
		})
		
        .blur(function(){   
        if($(this).val()==""){$(this).val(oldVal).css({"color":"#888"})}
		//check_pos();
		})  
		 
		.keydown(function(){$(this).css({"color":"#000"})})   
		})   
}   
  
$(function(){   
inputTipText(); //顯示   
})
</script>

<style type="text/css">
/* 25決策 */
.title {
	text-align:center;
	background-color:#FA6A3A;
	font-size:30px;
	font-weight:bolder;
	color:#FFF;
	padding:2px;
}
.title span{
	font-size:16px;
	color:#000;
}
.title_d {
	font-size:16px;
	font-weight:bolder;
	color:#000;
	text-align:left;
}
body{
	text-align:center;
	font-family:"Comic Sans MS", cursive;
}
.content {
	width:150px;
	font-family:"Comic Sans MS", cursive;
	font-size:14px;
	color:#CCC;
	overflow:scroll;
}
.menubar{
		float:right -30px;		
		margin-top:-235px;
		}	
</style>
<script type="text/javascript">
			var place1=[];
			var place2=[];
			var place3=[];
			var place4=[];
			var place5=[];
			var place6=[];
			var place7=[];
			var totalcards=19;
        $(function () {
			
            //產生20個決策，c是陣列的指標（0~19）
            var cards = [], c = 0;
            for (var i = 1; i <= 5; i++) {
                for (var j = 1; j <= 4; j++) {
					if(i==5 && j==4)
						break;
					cards[c++] = i + "-" + j;
                }
            }

            //把決策放到固定位置
            var cardPool = $("#decision_table");
            $.each(cards, function(i, v) {
                cardPool.append(getCard(v));
            });
            
            //利用圖片座標位移顯示特定圖案
            function getCard(cardId) {
                var pos = cardId.split("-");
                return $(
                "<a href='javascript:void(0);' id='C" + cardId + "'>" +
                "<div class=picture>" +
                "<img src='../images/authorities2.gif' style='margin-left:" +
                (parseInt(pos[1]) - 1) * -102 + "px;margin-top:" +
                (parseInt(pos[0]) - 1) * -114 + "px;' /></div></a>");
            }

            //排列整齊成5*5
            $("#decision_table a").each(function(i) {
				$(this).css({
					"cursor":"move"
				});
				if(i<4){
					$(this).css({
                    	"left": (i * 102 +16)+ "px"
               		});
				}else if(i<8 && i>=4){
					$(this).css({
                    	"left": ((i-4) * 102 +16) + "px",
                		"top":136+"px"
					});
				}else if(i<12 && i>=8){
					$(this).css({
                    	"left": ((i-8) * 102 +16) + "px",
                		"top":252+"px"
					});
				}else if(i<16 && i>=12){
					$(this).css({
                    	"left": ((i-12) * 102 +16) + "px",
                		"top":368+"px"
					});
				}else if(i<20 && i>=16){
					$(this).css({
                    	"left": ((i-16) * 102 +16) + "px",
                		"top":484+"px"
					});
				}
            });

            //允許拖拉
            $("#decision_table a").draggable({
                revert: true, //拖完返回原始位置
                opacity: 0.50, //拖拉過程半透明
				
            });

            //接受放牌
            $(".place_area").droppable({
                over: function(evt, ui) {
                    //將隱藏的牌去除，以免影響計數
                    $(this).find("a:hidden").remove();
                },
                drop: function(evt, ui) {
						
                    var cardPack = $(this);
					//alert(cardPack.attr("id"));
					
					//找出放置區
					var str = $(this).attr("id");
					i = str.replace("place","");
					//alert(i);
					
					//if (document.getElementById("job"+i).value="總經理";)
						//cardPack.attr("maxcards")=0;
                    
					if (cardPack.find("a").length < parseInt(cardPack.attr("maxcards"))) {
						//複製到"墩"
                        ui.draggable.clone().appendTo(cardPack)
                        .css({ position: "", top: "", left: "", opacity: "" });
                        //原牌隱藏，直接刪除會影響draggable的結束事件
						ui.draggable.hide();
						
						//被拖到放置區時
						var cid = ui.draggable.attr("id").replace("C","").split("-");
						var pid = $(this).attr("id");
						var count = cardPack.find("a").length;
						
						var checkdup = 0;
						
						for(var i=1;i<=7;i++)
						{	
							//alert(i);
							checkdup=eval("place"+i).indexOf(parseInt((cid[0]-1)*4)+parseInt(cid[1]));
							if(checkdup!=-1){
								eval("place"+i).splice(checkdup,1);
								totalcards++;
							}
						}
						//eval(pid).push(parseInt((cid[0]-1)*4)+parseInt(cid[1]));
						
						eval(pid).push(parseInt((cid[0]-1)*4)+parseInt(cid[1]));
						eval(pid).sort(function(a,b){return a-b});
						// alert(pid+":"+eval(pid));
						//alert(ui.draggable.attr("id"));
						//alert(cardPack.find("a").length);
					
                    }// end if
					totalcards-=1;
					//alert(totalcards);
                }//end func(drop)
            });//end place_area
			
            //接受將牌拖回決策區
            $(".decision").droppable({
                drop: function(evt, ui) {
                    //如果該牌是要放回決策區
                    var cId = ui.draggable.attr("id");
                    var hdnCard = $(this).find("#" + cId + ":hidden");
                    if (hdnCard.length > 0) {
						ui.draggable.hide();
                        hdnCard.show();
						totalcards++;
						//alert(totalcards);
                    }
                }
            });
			
            //開放放置區內可排序
            $(".place_area").sortable();
				check_pos();
        	});
		
		function check_pos(){
			 for(var i=1; i<8; i++){
			 	if($('#ceo'+i).is(':checked')){
					document.getElementById("job"+i).value="總經理";
					document.getElementById("job"+i).disabled=true;
					
					
				}else{
					document.getElementById("job"+i).value="請輸入職務名稱";
					document.getElementById("job"+i).disabled=false;

				}//end if
			 }//end for
		}//end func(check_pos)
		
		/* $("#submit").click(function(){
			 if()
                   alert("分配尚未完成!")
             else
                   $.ajax({
                       url:"try.php",
                       type: "POST",
                       datatype: "html",
                       data: 
                       success: function(str){
                       //alert("SUCCESS~!!")
                       alert("Success!");
                      }
                   });
		});*/
		
		var notceo=[];
		function decision(){
			var nc=[]
			var pos=[];
			var ceo=0;
			var temp;
			for(var i=1; i<8; i++){
				if($('#ceo'+i).is(':checked')){
					ceo=i;
					pos.push('總經理');
				}else{
					temp=document.getElementById("job"+i).value;
					nc.push(i);
					if(temp=="請輸入職務名稱")
						pos.push('其他經理');
					else if(temp=="總經理"){
						alert("只能有一位總經理,請確認職務分配無誤!");
						return 0;
					}else
						pos.push(temp);
					}
			for()		
			}//end for
		
		function check_d(num){
			if(eval("place"+num).length==0)
				return false;
			else
				return true;
			
		}	
				
				//alert(pos);
				//alert(totalcards);
				if(totalcards!=0){
					alert("請將所有決策分配給總經理以外的人員!");
				}else if(eval("place"+ceo).length!=0){
					alert("總經理已擁有所有決策權,請將決策權分配給非總經理人員!");
				}else{
					var i=notceo.length;
					alert(i);
					for(var j=0; j<i; j++){
						var isvalid = check_d(notceo[j]);
						if(isvalid==false){
							alert("除了總經理外，每個人都必須分配到決策!");
								break;
						}
					}
					if(isvalid){
						$.post("try.php",{
										subdecision:true,
										ceo:ceo,
										place1:place1.toString(),
										place2:place2.toString(),
										place3:place3.toString(),
										place4:place4.toString(),
										place5:place5.toString(),
										place6:place6.toString(),
										place7:place7.toString(),
										pos:pos.toString(),
									},function(xml){ 
									    //alert(xml);
												}//end function(xml);
						);//end post
					alert("設定完成!");
				}
			}//end if
		}
</script>

</head>
<body>

<?php /*?><?php
if($subceo[3]=="1"){echo "營收來源、";}
if($subceo[4]=="1"){echo "銷貨成本分析、";}
if($subceo[5]=="1"){echo "資本結構、";}
if($subceo[6]=="1"){echo "投資人關係管理、";}
if($subceo[7]=="1"){echo "員工關係管理、";}
if($subceo[8]=="1"){echo "供應商關係管理、";}
if($subceo[9]=="1"){echo "部門員工能力指數、";}
if($subceo[10]=="1"){echo "員工訓練、";}
if($subceo[11]=="1"){echo "招聘/解僱員工、";}
if($subceo[12]=="1"){echo "代工廠簽約、";}
if($subceo[13]=="1"){echo "營運資金管理、";}
if($subceo[14]=="1"){echo "資本預算、";}
if($subceo[15]=="1"){echo "原料採購、";}
if($subceo[16]=="1"){echo "企業社會責任、";}
if($subceo[17]=="1"){echo "生產規劃、";}
if($subceo[18]=="1"){echo "ERP投資系統決策、";}
if($subceo[19]=="1"){echo "顧客服務指數、";}
if($subceo[20]=="1"){echo "市場產品需求變化、";}
if($subceo[21]=="1"){echo "產品差異化、";}
if($subceo[22]=="1"){echo "服務品質、";}
if($subceo[23]=="1"){echo "維修效率、";}
if($subceo[24]=="1"){echo "市占率、";}
if($subceo[25]=="1"){echo "產品定價、";}
if($subceo[26]=="1"){echo "廣告及促銷活動、";}
if($subceo[27]=="1"){echo "通路商關係管理";}
?>
</h2></td></tr><?php */?>
<!--<tr><td><h2><a href="../abc_main/index.html">進入遊戲</a></h2></td></tr>-->
<div id="decision">
<div class="title">決策分配 <span><?php  echo "第".$year."年 &nbsp;".$month."月"; ?></span></div>
<?php echo ' 公司名稱：'.$cid.'&nbsp;&nbsp;競賽名稱：'.$gamename; ?>
<!--決策區-->
<div id="decision_table" class="decision" style="position:absolute; top:10%;"></div>

<!--放置區-->
<div id="place_table" style="position:absolute; left:470px; top:10%;">

<p style="height:2%;">
<div id="person1">
<div class="title_d">
帳號：<?php echo $login_ceo; ?> &nbsp;<input type="radio" name="總經理" id="ceo1" checked onClick="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job1" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place1" class="place_area" maxcards="8"></div>
</div>

<div id="person2">
<div class="title_d">
帳號：<?php echo $acc[1]; ?> &nbsp;<input type="radio" name="總經理" id="ceo2" onClick="check_pos()"> 總經理 &nbsp;
  職務：<input name="job" id="job2" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place2" class="place_area" maxcards="8"></div>
</div>

<div id="person3">
<div class="title_d">
帳號：<?php echo $acc[2]; ?> &nbsp;<input type="radio" name="總經理" id="ceo3" onClick="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job3" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place3" class="place_area" maxcards="8"></div>
</div>

<div id="person4">
<div class="title_d">
帳號：<?php echo $acc[3]; ?> &nbsp;<input type="radio" name="總經理" id="ceo4" onClick="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job4" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place4" class="place_area" maxcards="8"></div>
</div>

<div id="person5">
<div class="title_d">
<p style="height:15px;">
帳號：<?php echo $acc[4]; ?> &nbsp;<input type="radio" name="總經理" id="ceo5" onClick="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job5" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place5" class="place_area" maxcards="8"></div>
</div>

<div id="person6">
<div class="title_d">
<p style="height:15px;">
帳號：<?php echo $acc[5]; ?> &nbsp;<input type="radio" name="總經理" id="ceo6" onClick="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job6" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place6" class="place_area" maxcards="8"></div>
</div>

<div id="person7">
<div class="title_d">
<p style="height:15px;">
帳號：<?php echo $acc[5]; ?> &nbsp;<input type="radio" name="總經理" id="ceo7" onChange="check_pos()"> 總經理&nbsp;
  職務：<input name="job" id="job7" class="grayTips" type="text" value="請輸入職務名稱" size="10px"/>
</div>
<div id="place7" class="place_area" maxcards="8"></div>
</div>
<p style="height:3%;">
<div>
<input type="hidden" name="action" value="add" />
<input type="image" src="../images/submit6.png" id="submit"  onclick="decision()"style="width:100px">
<p style="height:3%;">
</div><!--end submit-->
</div><!--end place_table-->
</div><!--end place_decition-->

</body>
</html>