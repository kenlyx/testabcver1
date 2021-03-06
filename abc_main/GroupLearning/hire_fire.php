<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>fund_raising</title>
    <?php 
			include("../connMysql.php");
			if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
			mysql_query("set names 'utf8'");
			$cid=$_SESSION['cid'];
			$year=$_SESSION['year'];
			$month=$_SESSION['month'];
			$round=$month+($year-1)*12;

			$correspondence=mysql_query("SELECT * FROM correspondence WHERE `name`='current_people'");
			$correspond=mysql_fetch_array($correspondence);			
			$correspondence = mysql_query("SELECT * FROM correspondence WHERE `name`='current_people_2'");
			$correspond2 = mysql_fetch_array($correspondence);			
			
		?>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.smartTab.js"></script>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/hire_fire.css" rel="stylesheet">
      
<script type="text/javascript">
            var f_hcount=0,r_hcount=0,s_hcount=0,e_hcount=0,d_hcount=0;
            var f_fcount=0,r_fcount=0,s_fcount=0,e_fcount=0,d_fcount=0;
            var current_f=0,current_e=0,current_s=0,current_h=0,current_r=0;
            $(document).ready(function(){
                
				//show fire costs
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"fire_money"},
					success: function(str){
						if(str!="::")
							var word=str.split(":");
							document.getElementById("get_fn_member_cost1").innerHTML=parseInt(word[0],10)*3;
							document.getElementById("get_rs_member_cost1").innerHTML=parseInt(word[1],10)*3;
							document.getElementById("get_ss_member_cost1").innerHTML=parseInt(word[2],10)*3;
							document.getElementById("get_ex_member_cost1").innerHTML=parseInt(word[3],10)*3;
							document.getElementById("get_rd_team_cost1").innerHTML=parseInt(word[4],10)*3*5;
					}
				});
				//show hire costs	
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"hire_money"},
					success: function(str){
						var word=str.split(":");
						var hire_money=parseInt(word[0],10);
						document.getElementById("get_fn_member_cost").innerHTML=hire_money;
						document.getElementById("get_rs_member_cost").innerHTML=hire_money;
						document.getElementById("get_ss_member_cost").innerHTML=hire_money;
						document.getElementById("get_ex_member_cost").innerHTML=hire_money;
						document.getElementById("get_rd_team_cost").innerHTML=hire_money*5;
						}
				});
				//get each member's current amount 
                $.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"finan"},
                    success: function(str){
						//alert(str);
                        arr=str.split("|");
                        current_f=parseInt(arr[0]);
						//總招解聘人數
                        f_hcount=parseInt(arr[1]);
                        f_fcount=parseInt(arr[2]);
						//show current member number
						document.getElementById("has_fn_member").innerHTML=current_f;
						document.getElementById("has_fn_member1").innerHTML=current_f;
						document.getElementById("fn_thismonth").innerHTML=f_hcount;
						document.getElementById("fn_thismonth1").innerHTML=f_fcount;
						}
                });
                $.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"equip"},
                    success: function(str){
                        arr=str.split("|");
                        current_e=parseInt(arr[0]);
                        e_hcount=parseInt(arr[1]);
                        e_fcount=parseInt(arr[2]);
						//current_e=e_hcount-e_fcount;
						//show current member number
						document.getElementById("has_rs_member").innerHTML=current_e;
						document.getElementById("has_rs_member1").innerHTML=current_e;
						document.getElementById("rs_thismonth").innerHTML=e_hcount;
						document.getElementById("rs_thismonth1").innerHTML=e_fcount;
                        }
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"sale"},
                    success: function(str){
                        arr=str.split("|");
                        current_s=parseInt(arr[0]);
                        s_hcount=parseInt(arr[1]);
                        s_fcount=parseInt(arr[2]);
						//current_s=s_hcount-s_fcount;
						//show current member number
						document.getElementById("has_ss_member").innerHTML=current_s;
						document.getElementById("has_ss_member1").innerHTML=current_s;
						document.getElementById("ss_thismonth").innerHTML=s_hcount;
						document.getElementById("ss_thismonth1").innerHTML=s_fcount;
                        }
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"human"},
                    success: function(str){
                        arr=str.split("|");
                        current_h=parseInt(arr[0]);
                        h_hcount=parseInt(arr[1]);
                        h_fcount=parseInt(arr[2]);
						//current_h=h_hcount-h_fcount;
						//show current member number
						document.getElementById("has_ex_member").innerHTML=current_h;
						document.getElementById("has_ex_member1").innerHTML=current_h;
						document.getElementById("ex_thismonth").innerHTML=h_hcount;
						document.getElementById("ex_thismonth1").innerHTML=h_fcount;
						}
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"research"},
                    success: function(str){
						//alert(str);
                        arr=str.split("|");
                       	current_r=parseInt(arr[0]);
                        r_hcount=parseInt(arr[1]);
                        r_fcount=parseInt(arr[2]);
						/*var year=arr[3];
						var month=arr[4];
						if(year=1 && month=1) get_rd disabled
						show current member number*/
						document.getElementById("has_rd_team").innerHTML=current_r;
						document.getElementById("has_rd_team1").innerHTML=current_r;
						document.getElementById("rd_thismonth").innerHTML=r_hcount;
						document.getElementById("rd_thismonth1").innerHTML=r_fcount;
						/*if(year==1 && month==1){
							document.getElementById("get_rd_team").disabled=true;
							document.getElementById("get_rd_team1").disabled=true;
						}*/ 
					}
                });	
				
			//hire submit button
			$("#hire").click(function(){
				f_hcount=document.getElementById("get_fn_member").value;
				e_hcount=document.getElementById("get_rs_member").value;
				s_hcount=document.getElementById("get_ss_member").value;
				h_hcount=document.getElementById("get_ex_member").value;
				r_hcount=document.getElementById("get_rd_team").value*5;
				current_f=document.getElementById("has_fn_member").innerHTML;
				current_r=document.getElementById("has_rs_member").innerHTML;
				current_s=document.getElementById("has_ss_member").innerHTML;
				current_e=document.getElementById("has_ex_member").innerHTML;
				current_d=document.getElementById("has_rd_team").innerHTML;
				
				var hc=new Array(f_hcount,e_hcount,s_hcount,h_hcount,r_hcount);
					 for(var i=0; i<hc.length; i++){	
						var isvalid=check_h(hc[i]);
						if(isvalid==false){
							alert("請確認招聘人數在有效範圍內!");
								break;
						}
			 		 }
				if(isvalid){ 
					$.ajax({
                        url:"human_resource.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"hire_submit",f:hc[0],e:hc[1],s:hc[2],h:hc[3],r:hc[4]}
					});
                	alert("Hire Success!!");
					location.href= ('./hire_fire.html'); 
			   }
			});
			
			//fire submit button
			$("#fire").click(function(){
				f_fcount=document.getElementById("get_fn_member1").value;
				e_fcount=document.getElementById("get_rs_member1").value;
				s_fcount=document.getElementById("get_ss_member1").value;
				h_fcount=document.getElementById("get_ex_member1").value;
				r_fcount=document.getElementById("get_rd_team1").value*5;
				current_f=document.getElementById("has_fn_member1").innerHTML;
				current_r=document.getElementById("has_rs_member1").innerHTML;
				current_s=document.getElementById("has_ss_member1").innerHTML;
				current_e=document.getElementById("has_ex_member1").innerHTML;
				current_d=document.getElementById("has_rd_team1").innerHTML;
				
				var fc=new Array(f_fcount,e_fcount,s_fcount,h_fcount,r_fcount);
				var cp=new Array(current_f,current_r,current_s,current_e,current_d);  
					 for(var i=0; i<fc.length; i++){
						var isvalid=check_f(fc[i],cp[i]);
						if(isvalid==false){
							alert("請確認解聘人數在有效範圍內!");
								break;
						}
			 		 }
				if(isvalid){ 
					$.ajax({
                        url:"human_resource.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"fire_submit",f:fc[0],e:fc[1],s:fc[2],h:fc[3],r:fc[4]}
                    });
                    alert("Fire Success!!");
					location.href= ('./hire_fire.html'); 	
				}
			});
				
		});//end ready func
		    
		function check_h(hnum){
			if(hnum>=0)
   				return true;
			else	
  				return false;
		} 
		function check_f(fnum,curp){
			if(fnum<=curp)
   				return true;
			else
  				return false;
		}
			
		function addCommas(nStr){	
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
			//-----------------------------------grayTips-----------------------------------
		function inputTipText(){    
    		$("input[class*=grayTips]")
	
			 //所有樣式名中含有grayTips的input  
			.each(function(){   
       			var oldVal=$(this).val();   //默認的提示性文字   
				$(this)   
				.css({"color":"#888"})
		  		//灰色
				.focus(function(){ 
		  
				if($(this).val()!=oldVal){$(this).css({"color":"#000"})}else{$(this).val("").css({"color":"#888"} )} 
			})
		
       	    .blur(function(){   
      		    if($(this).val()==""){$(this).val(oldVal).css({"color":"#888"})}
			})  
		 
			.keydown(function(){$(this).css({"color":"#000"})})   
			})   
		}   
  
		$(function(){   
		inputTipText(); //顯示   
	})	
			
			//update total hire cost
            function hire_total(){
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"hire_money"},
					success: function(str){
						var word=str.split(":");
						var hire_money=parseInt(word[0],10);
						var total_hcount=1*h_hcount+1*s_hcount+1*e_hcount+1*f_hcount+1*r_hcount;
						document.getElementById("hire_total").textContent=addCommas(total_hcount*hire_money);
						
					}
				});
            }
			//update total fire costs
            function fire_total(){
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"fire_money"},
					success: function(str){
						if(str!="::")
							var word=str.split(":");
						document.getElementById("fire_total").textContent=addCommas(f_fcount*parseInt(word[0],10)*3+e_fcount*parseInt(word[1],10)*3+s_fcount*parseInt(word[2],10)*3+h_fcount*parseInt(word[3],10)*3+r_fcount*parseInt(word[4],10)*3);
					}
				});
            }
			//by shiowgwei
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function change(){
				f_hcount=document.getElementById("get_fn_member").value;
				e_hcount=document.getElementById("get_rs_member").value;
				s_hcount=document.getElementById("get_ss_member").value;
				h_hcount=document.getElementById("get_ex_member").value;
				r_hcount=document.getElementById("get_rd_team").value*5;
				f_fcount=document.getElementById("get_fn_member1").value;
				e_fcount=document.getElementById("get_rs_member1").value;
				s_fcount=document.getElementById("get_ss_member1").value;
				h_fcount=document.getElementById("get_ex_member1").value;
				r_fcount=document.getElementById("get_rd_team1").value*5;
				hire_total();
				fire_total();
				}
			function setStyle(x){
				document.getElementById(x).value="";
			}	

        </script>
  
  </head>
  <body>
    <div class="container-fluid">
    <h1>招 / 解聘員工 <small style="color:#ff0000;">* 競賽初始已先幫各公司聘雇一研發團隊以便直接研發 * </small></h1>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2><i class="fa fa-user-plus"></i> 招聘</h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2><i class="fa fa-user-times"></i> 解聘</h2></a></li>
   
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">
    <div class="col-sm-9 text-center panel-padding">
      <div class="panel panel-info">
            <div class="panel-heading"><h3>招聘人員</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
                <th> </th>
                <th>人數</th>
                <th>招聘人數</th>
                <th>招聘</th>
            </tr>
            <tbody>
            <tr>
                <td>財務人員</td>
                <td><span id="has_fn_member"></span></td>
                <td><span id="fn_thismonth"></span></td>
                <td><input id="get_fn_member" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            <tr>
                <td>運籌人員</td>
                <td><span id="has_rs_member"> </span></td>
                <td><span id="rs_thismonth"></span></td>
                <td><input id="get_rs_member" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            <tr>
                <td>行銷與業務人員</td>
                <td><span id="has_ss_member"></td>
                <td><span id="ss_thismonth"></span></td>
                <td><input id="get_ss_member" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>               
            <tr>
                <td>行政人員</td>
                <td><span id="has_ex_member"></span></td>
                <td><span id="ex_thismonth"></span></td>
                <td><input  id="get_ex_member" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
             <tr>
                <tr>
                <td>研發團隊</td>
                <td><span id="has_rd_team"> </span></td>
                <td><span id="rd_thismonth"></span></td>
                <td><input id="get_rd_team" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            </tbody>
        </table>
        </div>
            <div class="col-sm-12 text-center"> <h2>總招聘費用 :$<span id ="hire_total">0</span></h2></div>
        </div>
      <!---------------------------注意事項區域----------------------->
    <div class="col-sm-3">
        <div class="panel panel-info panel-padding">
            <div class="panel-heading"><h2>注意事項</h2></div>
            <div class="panel-body">
                <h3>1.運籌的生產部門人員會隨著生生產總的購買而配置。其他部人數的多寡決定該部門營收的負荷量</h3>
                <h3>2.聘雇員工太少的部門會成為瓶頸</h3>
            </div>
        </div>
      </div>
     <div class="col-sm-12 col-xs-12 text-center">
    <input id="hire" class="btn btn-primary btn-lg" type="submit">
    </div>      
    </div>
<!----------------------解聘人員區域--------------------------->
  <div role="tabpanel" class="tab-pane fade" id="profile"> 
     <div class="col-sm-9 text-center panel-padding">
      <div class="panel panel-info">
            <div class="panel-heading"><h3>解聘人員</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
                <th> </th>
                <th>人數</th>
                <th>解聘人數</th>
                <th>解聘</th>
            </tr>
            <tbody>
            <tr>
                <td>財務人員</td>
                <td><span id="has_fn_member1"></span></td>
                <td><span  id="fn_thismonth1"></span></td>
                <td><input id="get_fn_member1" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            <tr>
                <td>運籌人員</td>
                <td><span id="has_rs_member1"></span></td>
                <td><span  id="rs_thismonth1"></span></td>
                <td><input id="get_rs_member1" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            <tr>
                <td>行銷與業務人員</td>
                <td><span id="has_ss_member1" ></td>
                <td><span  id="ss_thismonth1"></span></td>
                <td><input id="get_ss_member1" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>               
            <tr>
                <td>行政人員</td>
                <td><span id="has_ex_member1"></span></td>
                <td><span  id="ex_thismonth1"></span></td>
                <td><input id="get_ex_member1" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
             <tr>
                <tr>
                <td>研發團隊</td>
                <td><span id="has_rd_team1"></span></td>
                <td><span  id="rd_thismonth1"></span></td>
                <td><input id="get_rd_team1" class="form-control text-center" type="text" placeholder="0" onChange="change()"></td>
            </tr>
            </tbody>
        </table>
        </div>
            <div class="col-sm-12 text-center"> <h2>總解聘費用 :$<span id ="fire_total">0</span></h2></div>
        </div>
      <!---------------------------注意事項區域----------------------->
    <div class="col-sm-3">
        <div class="panel panel-info panel-padding">
            <div class="panel-heading"><h2>注意事項</h2></div>
            <div class="panel-body">
                <h3>1.資遣員工須負「3個月」薪資資遣費</h3>
            </div>
        </div>
      </div>
     <div class="col-sm-12 col-xs-12 text-center">
    <input id="fire" class="btn btn-primary btn-lg" type="submit">
    </div>

</div>
        
        
        
    <!-----------------最底下的按鈕建-------------------------------->    
    
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>