<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>fund_raising</title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.smartTab.js"></script>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/fund_raising.css" rel="stylesheet">
      
      <script type="text/javascript">
            var now_cumlia=0,sto_now=0,treasurystock=0;
            var debit_now=0.0;
            var price01=0,price02=0,price03=0,price04=0,price05=0,price06=0;
            var clickable=0;
			var isvalid=true;
			var check_lia=0;
			var tressury=0;
			
            $(document).ready(function(){//在網頁DOM 文件下載完成後即觸發此函式(不用等文件內的元件例如圖檔下載完)
               				
               // $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                $.ajax({
                    url:"fundDB.php",
                    type: "GET",
                    async: false,
                    datatype: "html",
                    data: {type:"month"},
                    success: function(str){
                        month = parseInt(str);
                        if(month==1){
                            clickable=1;
                        }
//                    clickable=1;
                    }
                });
                $.ajax({
                    url:"fundDB.php",
                    type: "GET",
                    datatype: "html",
                    async: false,
                    data: {type:"set"},
                    success: function(str){
                        row=str.split("|");
                        //alert(str);
						
						now_can_debt=parseInt(row[12]);
						treasurystock=parseInt(row[13]);

						
                       	now_cumlia=parseInt(row[0]);
                        sto_now=parseInt(row[9]);
                        price06=parseInt(row[10]);
						now_fund=parseInt(row[11]);
						check_lia=parseInt(row[1]);

						stock_now=price06+sto_now;
						
						document.getElementById("now_fund").innerHTML=addCommas(now_fund);
                        document.getElementById("cum_lia").innerHTML=row[0];
                        document.getElementById("has_stock").innerHTML=addCommas(treasurystock);
                        document.getElementById("now_liaper").innerHTML=row[1]+"%";
                        document.getElementById("pre_liaper").innerHTML=row[8];
                        document.getElementById("ref_stockp").innerHTML=parseFloat(row[2]);
						document.getElementById("outside_stock").innerHTML=addCommas(stock_now);

						document.getElementById("company_stock").innerHTML =addCommas(sto_now);
						document.getElementById("market_stock").innerHTML =addCommas(price06);

						document.getElementById("can_loan").innerHTML=addCommas(now_can_debt);
					//	document.getElementById("buyable_stock").innerHTML=addCommas(treasurystock);			
						
                        if(row[3]!="")
                            document.getElementById("get_fundraise").innerHTML=parseFloat(row[3]);
                        if(row[4]!="")
                            document.getElementById("give_dividends").innerHTML=parseFloat(row[4]);
                        if(row[5]!="")
                            document.getElementById("get_shortlia").innerHTML=parseFloat(row[5]);
                        if(row[6]!="")
                            document.getElementById("get_longlia").innerHTML=parseFloat(row[6]);
                        if(row[7]!="")
                            document.getElementById("payback_longlia").innerHTML=parseFloat(row[7]);
                    }
                });
				
				//增資判斷部分
                $("#fund_add").click(function(){
                    if(clickable==1){ 
                        var get_f=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						if(get_f<20000000){ 
                        	get_f+=1000000; 
							now_f+=1000000;
						}else
                            alert("已達上限");
                        document.getElementById("get_fundraise").innerHTML=addCommas(get_f);
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
					else{
						alert("非年初，無法現金增資!!")
					}
                });
				  $("#fund_minus").click(function(){
                    if(clickable==1){ //只能在年初現金增資
                        var not_f=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
                        if(not_f<=0){//現金增資每次最低零元
                            alert("已達下限");
                        }else{
                            not_f-=1000000;//每點選一次減少一百萬
							now_f-=1000000;
                        }
                        text=price04.toString();
                        document.getElementById("get_fundraise").innerHTML=addCommas(not_f);//再把數字的逗點加回去
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
                });
				//股利部分
                $("#divi_add").click(function(){
                    if(clickable==1){//只能在年初發放股利
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						var now_s=parseInt(document.getElementById("has_stock").innerHTML.replace(/\,/g,''));
                        var get_d=parseFloat(document.getElementById("give_dividends").innerHTML);
                        if(get_d<10){//發放股利每次最多十元
                            get_d+=0.5;//股利每按一次增加0.5元
							now_f-=now_s*0.5;//目前資金每按一次減少0.5*庫藏股數
						}else
                            alert("已達上限");
                        document.getElementById("give_dividends").innerHTML=get_d;
						document.getElementById("now_fund").innerHTML=addCommas(now_f);//再把數字的逗點加回去
					}
					else{
						alert("非年初，無法發放股利!!")
					}
                });
              
                $("#divi_minus").click(function(){
                    if(clickable==1){//只能在年初發放股利
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						var now_s=parseInt(document.getElementById("has_stock").innerHTML.replace(/\,/g,''));
						var not_d=parseFloat(document.getElementById("give_dividends").innerHTML);
                        if(not_d<=0){//發放股利每次最小零元
                            alert("已達下限");
                        }else{
                            not_d-=0.5;//股利每按一次減少0.5元
							now_f+=now_s*0.5;//目前資金每按一次增加0.5*庫藏股數
                        }
                        document.getElementById("give_dividends").innerHTML=not_d;
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
                });
                $("#submit").click(function(){
					var get_cash1=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
					var get_cash2=parseFloat(document.getElementById("give_dividends").innerHTML);
					var short=document.getElementById("get_shortlia").value;
					var long=document.getElementById("get_longlia").value;
					var cumlia=parseInt(document.getElementById("cum_lia").innerHTML.replace(/\,/g,''));
					var payback=document.getElementById("payback_longlia").value;
					//var canbuy=parseInt(document.getElementById("buyable_stock").innerHTML.replace(/\,/g,''));
					var buystock=document.getElementById("buyback_stock").value;
					var sellstock=document.getElementById("sell_stock").value;
					
					var fr=new Array(get_cash1,get_cash2,short,long,payback,buystock,sellstock);
					
					for(var i=0; i<fr.length; i++){
						if(fr[i]==""){
							fr[i]=0;//把沒填的項目以零送出
						}
						if(i==4)//檢查償還長期借款<累積長期借款
							isvalid=checkpb(fr[i],cumlia);
						
						else//檢查其他各個項目>=0
						    isvalid=check(fr[i]);
						
						if(isvalid==false){//上面有檢查不合格的
							alert("請確認購買數量在有效範圍內(>0)!");
							break;
						}
			 		 }
						
					 if(isvalid){ 
                   		 $.ajax({
                       		 url:"fundDB.php",
                       		 type: "GET",
                      	 	 datatype: "html",
                        	 data: {type:"update",decision1:fr[2],decision2:fr[3],decision3:fr[4],
											      decision4:fr[0],decision5:fr[1],decision6:fr[5],
											      decision7:fr[6]},
                       		 success: function(str){
								 //alert(str);
                           		 alert("Success!");
								 location.href=('./fund_raising.php');
								 //journal();
                       		 }
                   		 });
				    }
                });
  
	}); // end ready func
	
	 function checkpb(num,cumlia){
		if(num>=0 && num<=cumlia)
   			return true;
		else
  			return false;
	}
	 function checkbs(num,canbuy){
		if(num>=0 && num<=canbuy)
   			return true;
		else
  			return false;
	}
	 function check(num){
		if(num>=0)
   			return true;
		else
  			return false;
	}
          
	//錢，三位一數加逗點			
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
				
	function check_2(){
		if(check_lia >= 80){
			alert("負債比過高  無法借款");//負債比率高於80%時則不能進行借款
			document.getElementById("get_shortlia").value = "";
			document.getElementById("get_longlia").value = "";
		}
		
	}

        </script>
  </head>
  <body>
    <div class="container-fluid">
    <h1>資金募集 <small style="color:#ff0000;">* 同一個月內所先作的決策會被後來的決策所取代，換言之，請在submit前，一次填完所有與決策之項目，否則等於用0取代先前之決策*</small></h1>
    <!--------------------------panel右半區域--------------------------->
    <div class="col-sm-6 ctm-padding"> 
        <!------------------參考值區域------------------------------------->
        <div class="panel panel-success">
            <div class="panel-heading"><h3>參考值</h3></div>

                <!-- Table -->
                <table class="table table-striped table-responsive text-center">
                    <tbody>
                    <tr>
                        <td>目前負債比率</td>
                        <td><span id="now_liaper"></span></td>
                    </tr>
                    <tr>
                        <td>預估負債比率</td>
                        <td><span id="pre_liaper"></span></td>
                    </tr>
                    <tr>
                        <td>股票參考價格</td>
                        <td><spa id="ref_stockp"></span></td>
                    </tr>
                    </tbody>
                </table>
        </div>
        <!------------------庫藏股區域------------------------------------->
        <div class="panel panel-success">
            <div class="panel-heading"><h3>庫藏股</h3></div>

                <!-- Table -->
                <table class="table table-striped table-responsive text-center">
                    <tbody>
                    <tr>
                        <td>在外流通股數</td>
                        <td><span id="outside_stock"></span></td>
                    </tr>
                    <tr>
                        <td>公司派</td>
                        <td><span id="company_stock"></td>
                    </tr>
                    <tr>
                        <td>市場派</td>
                        <td><span id="market_stock"></span></td>
                    </tr>
                    <tr>
                        <td>庫藏股</td>
                        <td><span id="has_stock"></span></td>
                    </tr>
                    <tr>
                        <td>買回庫藏股</td>
                        <td><input id="buyback_stock" class="form-control text-center" type="text" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>賣出庫藏股</td>
                        <td><input id="sell_stock" class="form-control text-center" type="text" placeholder="0"></td>
                    </tr>
                    </tbody>
                </table>
        </div>  
    </div>  
        <!--------------------------panel左半區域--------------------------->
        <div class="col-sm-6 ctm-padding"> 
        <!------------------增資區域------------------------------------->
        <div class="panel panel-success">
            <div class="panel-heading "><h3>增資</h3></div>

                <!-- Table -->
                <table class="table table-striped table-responsive text-center">
                    <tbody>
                    <tr>
                        <td class="ctm-padmag">現金增資</td>
                        <td>
                            <div class="col-sm-4"><button id="fund_minus" type="button" class="btn btn-success"><i class="fa fa-minus-circle"></i></button></div>
                            <div class="col-sm-4 ctm-contentpad"><span id="get_fundraise"></span></div>
                            <div class="col-sm-4"><button id="fund_add" type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i></button></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ctm-padmag">發放現金股利</td>
                        <td>
                            <div class="col-sm-4"><button id="divi_minus" type="button" class="btn btn-success"><i class="fa fa-minus-circle"></i></button></div>
                             <div class="col-sm-4 ctm-contentpad"><span id="give_dividends"></span></div>
                            <div class="col-sm-4"><button id="divi_add" type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i></button></div>
                        </td>
                    </tr>
                    <tr>
                        <td>加本次決策後的資金總額</td>
                        <td><span id="now_fund"></span></td>
                    </tr>
                    </tbody>
                </table>
        </div>
        <!------------------借款區域------------------------------------->
          <div class="panel panel-success">
            <div class="panel-heading"><h3>借款</h3></div>

                <!-- Table -->
              <div class="col-sm-7" style="padding:0px;">
                <table class="table table-striped table-responsive text-center ">
                    <tbody>
                    <tr>
                        <td>本月短期借款</td>
                        <td><input id="get_shortlia" class="form-control text-center" type="text" placeholder="0" onBlur="check_2()"></td>
                    </tr>
                    <tr>
                        <td>本月長期借款</td>
                        <td><input id="get_longlia" class="form-control text-center" type="text" placeholder="0" onBlur="check_2()"></td>
                    </tr>
                    <tr>
                        <td>可借貸上限</td>
                        <td><span id="can_loan"></span></td>
                    </tr>
                    <tr>
                        <td>累積長期借款</td>
                        <td><span id="cum_lia"></span></td>
                    </tr>
                    <tr>
                        <td>償還長期借款</td>
                        <td><input id="payback_longlia"  class="form-control text-center" type="text" placeholder="0"></td>
                    </tr>
                    </tbody>
                </table>
              </div>
              <div class="col-sm-5 ctm-loanpadding">
                  <h3>說明</h3>
               <ul>
                   <li><p>長短期年利率： 2%,4%</p></li>
                   <li><p>還款期限<br>短期借款： 6個月內<br>長期借款：18個月內</p></li>
                   <li><p>其他細節請詳閱手冊</p></li>
                </ul>
              </div>
        </div>            
    </div>    
    <!-----------------最底下的按鈕建-------------------------------->    
     <div class="col-sm-12 text-center">
    <a class="btn btn-primary btn-lg" id="submit" href="#" role="button">subimt</a>
    </div>      
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>