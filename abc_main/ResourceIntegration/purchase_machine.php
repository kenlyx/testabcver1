<!DOCTYPE html>
<?php session_start();?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>fund_raising</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
      
      <link href="../css/purchase_machine.css" rel="stylesheet">
      <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript">
            var cutA_count=0 ,cutB_count=0 ,cutC_count=0;
			var com1A_count=0,com1B_count=0,com1C_count=0;
            var com2A_count=0,com2B_count=0,com2C_count=0;
			var detA_count=0,detB_count=0;
			
			var cutA_price=0,cutB_price=0,cutC_price=0;
			var com1A_price=0,com1B_price=0,com1C_price=0;
			var com2A_price=0,com2B_price=0,com2C_price=0;
			var detA_price=0,detB_price=0;
			
			var p_cutA=0,p_cutB=0,p_cutC=0;
			var p_com1A=0,p_com1B=0,p_com1C=0;
			var p_com2A=0,p_com2B=0,p_com2C=0;
			var p_detA=0,p_detB=0;
			
            $(document).ready(function(){
				
				update_cut();
				update_combine1();
				update_combine2();
				update_detect();
				
            
					
				$("#submit_c").click(function(){
					cutA_count=document.getElementById("get_cutA_pnum").value;
					cutB_count=document.getElementById("get_cutB_pnum").value;
					cutC_count=document.getElementById("get_cutC_pnum").value;
					com1A_count=document.getElementById("get_com1A_pnum").value;
					com1B_count=document.getElementById("get_com1B_pnum").value;
					com1C_count=document.getElementById("get_com1C_pnum").value;
					com2A_count=document.getElementById("get_com2A_pnum").value;
					com2B_count=document.getElementById("get_com2B_pnum").value;
					com2C_count=document.getElementById("get_com2C_pnum").value;
					
					var c=new Array(cutA_count,cutB_count,cutC_count,com1A_count,com1B_count,com1C_count,com2A_count,com2B_count,com2C_count);
					for(var i=0; i<c.length; i++){
						var isvalid=check(c[i]);
						if(isvalid==false){
							alert("請確認購買數量在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
					//將inputs傳至DB檔
                    $.ajax({
                        url:"machineDB.php",
                        type: "GET",
                        datatype: "html",
                        data: {
							   type:"purchase",p_cutA:cutA_count,p_cutB:cutB_count,p_cutC:cutC_count,
						       				   p_com1A:com1A_count,p_com1B:com1B_count,p_com1C:com1C_count,
							   				   p_com2A:com2A_count,p_com2B:com2B_count,p_com2C:com2C_count},
                        success: function(str){
							//alert(str);
                            alert("Purchase Success!");
							location.href=('./purchase_machine.php');
                            //journal();
                        }
					});
					}
                })
				
				$("#submit_d").click(function(){
					detA_count=document.getElementById("get_detA_pnum").value;
					detB_count=document.getElementById("get_detB_pnum").value;
					var d=new Array(detA_count,detB_count);
					for(var i=0; i<d.length; i++){
						var isvalid=check(d[i]);
						if(isvalid==false){
							alert("請確認購買數量在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
					//將inputs傳至DB檔
                    $.ajax({
                        url:"machineDB.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"purchase",p_detA:detA_count,p_detB:detB_count},
                        success: function(str){
							//alert(str);
                            alert("Purchase Success!");
							location.href=('./purchase_machine.php');
                            //journal();
                        }
					});
					 }
                })

	}); // end ready func
           
		   //取得cut資訊，並顯示
           function update_cut(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"cut"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_cutA_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_cutB_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_cutC_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_cutA_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_cutB_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_cutC_price").innerHTML=addCommas(parseInt(strs[8]));
						
                    }
                });
            }
			 function check(num){
				if(num>=0)
   					return true;
				else
  					return false;
			}
			
		   //取得combine1資訊，並顯示
           function update_combine1(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"combine1"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_com1A_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_com1B_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_com1C_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_com1A_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_com1B_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_com1C_price").innerHTML=addCommas(parseInt(strs[8]));
                        var com1A_price=strs[6];
						var com1B_price=strs[7];
						var com1C_price=strs[8];
						
                    }
                });
            }
			
		   //取得combine2資訊，並顯示
           function update_combine2(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"combine2"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_com2A_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_com2B_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_com2C_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_com2A_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_com2B_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_com2C_price").innerHTML=addCommas(parseInt(strs[8]));
						var com2A_price=strs[6];
						var com2B_price=strs[7];
						var com2C_price=strs[8];	
                    }
                });
            }
			
			//取得detect資訊，並顯示
			function update_detect(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"detect"},
                    success: function(str){
						//alert(str);
                        strs=str.split("|");
                        document.getElementById("has_detA_num").innerHTML=parseInt(strs[0])+parseInt(strs[2]);
                        document.getElementById("has_detB_num").innerHTML=parseInt(strs[1])+parseInt(strs[3]);
                        document.getElementById("get_detA_price").innerHTML=addCommas(parseInt(strs[4]));
                        document.getElementById("get_detB_price").innerHTML=addCommas(parseInt(strs[5]));
						var detA_price=strs[4];
						var detB_price=strs[5];
                    }
                });
			}
			
			//計算此次決策的總費用
            function count(){
				//get price
				
				cutA_price=parseInt(document.getElementById("get_cutA_price").innerHTML.replace(/\,/g,''));
				cutB_price=parseInt(document.getElementById("get_cutB_price").innerHTML.replace(/\,/g,''));
				cutC_price=parseInt(document.getElementById("get_cutC_price").innerHTML.replace(/\,/g,''));
				com1A_price=parseInt(document.getElementById("get_com1A_price").innerHTML.replace(/\,/g,''));
				com1B_price=parseInt(document.getElementById("get_com1B_price").innerHTML.replace(/\,/g,''));
				com1C_price=parseInt(document.getElementById("get_com1C_price").innerHTML.replace(/\,/g,''));
				com2A_price=parseInt(document.getElementById("get_com2A_price").innerHTML.replace(/\,/g,''));
				com2B_price=parseInt(document.getElementById("get_com2B_price").innerHTML.replace(/\,/g,''));
				com2C_price=parseInt(document.getElementById("get_com2C_price").innerHTML.replace(/\,/g,''));
				detA_price=parseInt(document.getElementById("get_detA_price").innerHTML.replace(/\,/g,''));
				detB_price=parseInt(document.getElementById("get_detB_price").innerHTML.replace(/\,/g,''));
				var purchase_cut_total= cutA_price*cutA_count+cutB_price*cutB_count+cutC_price*cutC_count;
				var purchase_com1_total= com1A_price*com1A_count+com1B_price*com1B_count+com1C_price*com1C_count;
				var purchase_com2_total= com2A_price*com2A_count+com2B_price*com2B_count+com2C_price*com2C_count;
				var total_d= detA_price*detA_count+detB_price*detB_count;
				var total_c= purchase_cut_total + purchase_com1_total + purchase_com2_total;
			    document.getElementById("purchase_total_c").innerHTML=addCommas(total_c);
				document.getElementById("purchase_total_d").innerHTML=addCommas(total_d);
						}
			 //錢，三位一數			
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
			//by shiowgwei
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function total(){
				cutA_count=document.getElementById("get_cutA_pnum").value;
				cutB_count=document.getElementById("get_cutB_pnum").value;
				cutC_count=document.getElementById("get_cutC_pnum").value;
				com1A_count=document.getElementById("get_com1A_pnum").value;
				com1B_count=document.getElementById("get_com1B_pnum").value;
				com1C_count=document.getElementById("get_com1C_pnum").value;
				com2A_count=document.getElementById("get_com2A_pnum").value;
				com2B_count=document.getElementById("get_com2B_pnum").value;
				com2C_count=document.getElementById("get_com2C_pnum").value;
				detA_count=document.getElementById("get_detA_pnum").value;
				detB_count=document.getElementById("get_detB_pnum").value;
				count();
				}

        </script>
  </head>
  <body>
    <div class="container-fluid">
    <h1>購買資產 <small style="color:#ff0000;">* 有打星號的機具請至少買一件 *</small></h1>
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><h2>切割/組裝</h2></a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><h2>原料/檢測</h2></a></li>
   
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active " id="home">
    <div class="col-sm-6 text-center">
        <!----------切割原料區域----------------->
        <div class="panel panel-warning panel-padding">
            <div class="panel-heading"><h3>切割原料</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
            <th> </th>
            <th>現有數量</th>
            <th>機具單價</th>
            <th>購買數量</th>
            </tr>
            <tbody>
            <tr>
            <td>機具A</td>
            <td><span id="has_cutA_num"></span></td>
            <td><span id="get_cutA_price"></span></td>
            <td><input id="get_cutA_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具B</td>
            <td><span id="has_cutB_num"></span></td>
            <td><span id="get_cutB_price"></span></td>
            <td><input id="get_cutB_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具C</td>
            <td><span id="has_cutC_num"></span></td>
            <td><span id="get_cutC_price"></span></td>
            <td><input id="get_cutC_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            </tbody>
        </table>
        </div> 
    </div>
      <!-----------------第一層組裝區域--------------------->
    <div class="col-sm-6 text-center">
      <div class="panel panel-warning panel-padding">
            <div class="panel-heading"><h3>第一層組裝</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
            <th> </th>
            <th>現有數量</th>
            <th>機具單價</th>
            <th>購買數量</th>
            </tr>
            <tbody>
            <tr>
            <td>機具A</td>
            <td><span id="has_com1A_num"></span></td>
            <td><span id="get_com1A_price"></span></td>
            <td><input id="get_com1A_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具B</td>
            <td><span id="has_com1B_num"></span></td>
            <td><span id="get_com1B_price"></span></td>
            <td><input id="get_com1B_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具C</td>
            <td><span id="has_com1C_num"></span></td>
            <td><span id="get_com1C_price"></span></td>
            <td><input id="get_com1C_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    <!--------------第二層組裝區域-------------------->
    <div class="col-sm-6 text-center">
      <div class="panel panel-warning panel-padding">
            <div class="panel-heading"><h3>第二層組裝</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
            <th> </th>
            <th>現有數量</th>
            <th>機具單價</th>
            <th>購買數量</th>
            </tr>
            <tbody>
            <tr>
            <td>機具A</td>
            <td><span id="has_com2A_num"></span></td>
            <td><span id="get_com2A_price"></span></td>
            <td><input id="get_com2A_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具B</td>
            <td><span id="has_com2B_num"></span></td>
            <td><span id="get_com2B_price"></span></td>
            <td><input id="get_com2B_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>機具C</td>
            <td><span id="has_com2C_num"></span></td>
            <td><span id="get_com2C_price"></span></td>
            <td><input id="get_com2C_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>      
      <!----------------注意事項區域-------------------------->
      <div class="col-sm-6">
        <div class="panel panel-warning panel-padding">
            <div class="panel-heading"><h2>說明</h2></div>
            <div class="panel-body">
                <h3>請依規定購買機具，否則無法順利生產</h3>
                <h3>同一類型機具，當月所做的決策會被後來所做的決策取代</h3>
            </div>
        </div>
      </div>
    <!----------------------總經費------------------------>
    <div class="col-sm-12 text-center">
        <h1>總經費 : $<span id ="purchase_total_c">0</span></h1>
    </div> 
     <div class="col-sm-12 text-center">
        <input id="submit_c" class="btn btn-primary btn-lg" type="submit">
    </div>      
    </div>
  <div role="tabpanel" class="tab-pane fade" id="profile"> 
    <!-----------------檢測機具------------------->
         <div class="col-sm-6 col-sm-offset-3 text-center">
      <div class="panel panel-warning panel-padding">
            <div class="panel-heading"><h3>檢測機具</h3></div>
        <!-- Table -->
        <table class="table table-bordered">
            <tr>
            <th> </th>
            <th>現有數量</th>
            <th>機具單價</th>
            <th>購買數量</th>
            </tr>
            <tbody>
            <tr>
            <td>合格檢測*</td>
            <td><span id="has_detA_num"></span></td>
            <td><span id="get_detA_price"></span></td>
            <td><input id="get_detA_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            <tr>
            <td>精密檢測*</td>
            <td><span id="has_detB_num"></span></td>
            <td><span id="get_detB_price"></span></td>
            <td><input id="get_detB_pnum" class="form-control text-center" type="text" placeholder="0" onBlur="total()"></td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
      
      
     <div class="col-sm-12 col-xs-12 text-center ">
         <h2>總共費用 : $<span id ="purchase_total_d">0</span></h2>
    <input id="submit_d" class="btn btn-primary btn-lg" type="submit" >
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