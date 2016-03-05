<?php session_start(); ?>
<html>

<?php 
    include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$state="* 單個月內只允許研發一項產品，請選擇任一產品予以研發 *";
	
	$sql_rdA=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_A_RD`='1' ");
	$rdA=mysql_fetch_array($sql_rdA);//研發過A的回合資料
	$rd_rowA=mysql_num_rows($sql_rdA);
	//echo $rd_rowA;
	
	$sql_rdB=mysql_query("SELECT * FROM `state` WHERE `cid` = '".$cid."'and `product_B_RD`='1' ");
	$rdB=mysql_fetch_array($sql_rdB);//研發過B的回合資料
	$rd_rowB=mysql_num_rows($sql_rdB);
	
?>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/rd_tab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript">
				       
		   
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
				
					<?php		
	//if有研發過A
	if($rd_rowA==1){
	?>
				document.getElementById("SupA_ProductA").value=<?php echo $aA1['quantity']?>;			 
			 	document.getElementById("SupA_ProductA").disabled=true;
				document.getElementById("SupB_ProductA").value=<?php echo $aA2['quantity']?>;
				document.getElementById("SupB_ProductA").disabled=true;
				document.getElementById("SupC_ProductA").value=<?php echo $aA3['quantity']?>;
				document.getElementById("SupC_ProductA").disabled=true;
					
				document.getElementById("lapp_pnum_B").value=<?php echo $bA1['quantity']?>;
				document.getElementById("lapp_pnum_B").disabled=true;
				document.getElementById("lapc_pnum_B").value=<?php echo $bA2['quantity']?>;
				document.getElementById("lapc_pnum_B").disabled=true;
				document.getElementById("lapk_pnum_B").value=<?php echo $bA3['quantity']?>;
				document.getElementById("lapk_pnum_B").disabled=true;
					
				document.getElementById("lapp_pnum_C").value=<?php echo $cA1['quantity']?>;
				document.getElementById("lapp_pnum_C").disabled=true;
				document.getElementById("lapc_pnum_C").value=<?php echo $cA2['quantity']?>;
				document.getElementById("lapc_pnum_C").disabled=true;
				document.getElementById("lapk_pnum_C").value=<?php echo $cA3['quantity']?>;
				document.getElementById("lapk_pnum_C").disabled=true;
				$('.tfoot1').hide();
	<?php 
	}
	//if有研發過B 
	if($rd_rowB==1){
	?>
			 	document.getElementById("tabp_pnum_A").value=<?php echo $aB1['quantity']?>;
				document.getElementById("tabp_pnum_A").disabled=true;
				document.getElementById("tabc_pnum_A").value=<?php echo $aB2['quantity']?>;
				document.getElementById("tabc_pnum_A").disabled=true;
					
				document.getElementById("tabp_pnum_B").value=<?php echo $bB1['quantity']?>;
				document.getElementById("tabp_pnum_B").disabled=true;
				document.getElementById("tabc_pnum_B").value=<?php echo $bB2['quantity']?>;
				document.getElementById("tabc_pnum_B").disabled=true;
					
				document.getElementById("tabp_pnum_C").value=<?php echo $cB1['quantity']?>;
				document.getElementById("tabp_pnum_C").disabled=true;
				document.getElementById("tabc_pnum_C").value=<?php echo $cB2['quantity']?>;
				document.getElementById("tabc_pnum_C").disabled=true;
				$('.tfoot2').hide();
	<?php 
	}
	//若是本月研發A，disabled所有B產品的inputs，隱藏產品B的tfoot
	//A在判定為研發過時已隱藏tfoot
if($rd_rowA!=0 || $rd_rowB!=0){
	 if($year==$rdA['year'] && $month==$rdA['month']){ 			   
	?>	
				document.getElementById("tab3").style.opacity=0.5;
				document.getElementById("SupA_ProductB").disabled=true;
				document.getElementById("SupB_ProductB").disabled=true;
				document.getElementById("SupC_ProductB").disabled=true;
				
				$('.tfoot2').hide();     
	<?php
				$state="* 尚未研發<font color=#000>平板電腦</font>，請先研發後才能開始生產!!! *";
	//若是本月研發B，disabled所有A產品的inputs，隱藏產品A的tfoot
	//B在判定為研發過時已隱藏tfoot
	}else if($year==$rdB['year'] && $month==$rdB['month']){
	?>	
				document.getElementById("tab2").style.opacity=0.5;
				document.getElementById("SupA_ProductA").disabled=true;
				document.getElementById("SupB_ProductA").disabled=true;
				document.getElementById("SupC_ProductA").disabled=true;
					
				$('.tfoot1').hide();     
	<?php
				$state="* 尚未研發<font color=#000>筆記型電腦</font>，請先研發後才能開始生產!!! *";
	}
}//end if(有研發過)
     
	 if($rd_rowA==1 && $rd_rowB==1)
	 	$state="* 兩樣產品均已研發完成! *";
	?>        
						
});//end ready(func)
            
			 	
        </script>
    </head>
    <body>
    
        <div id="content" style="height:auto">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>研究開發&nbsp;
            <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            <?php echo $state;?></font></h1>
            
            
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1" id="tab1">
                        <img class='logoImage2' border="0" width="20%" src="../images/product_A.png">
                        <font size="4">筆記型電腦</font>
   
                    </a>
                </li>
                <li>
                    <a href="#tabs-2" id="tab2">
                        <img class='logoImage2' border="0" width="20%" src="../images/product_B.png">
                        <font size="4">平板電腦</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
        	 <li style="float:right; width:36%; height:44%; margin-right:2%; background-image:url(../images/note06.png); background-repeat:no-repeat;">
            <p style="height:7%"><p>
    <!--   <table align="right" border="0" style="width:83%; font-size:20px; font-family:'華康秀風體W3'; font-weight:bold; text-align:left;">
            <tr>
            	<td rowspan="4"></td><td colspan="3">說明：<br><br></td><td rowspan="4">&nbsp;<td>
            </tr>
            <tr>
            	<td style="vertical-align:top"><font color=#ff3030>1.</font></td>
                <td colspan="2">建議的契約訂購量為500<br></td>
            </tr>
            <tr>    
                <td style="vertical-align:top"><font color=#ff3030>2.</font></td>
                <td colspan="2">請務必研發將要生產產品的各種原料，否則將無法生產<br></td>
            </tr>
             <tr>    
                <td style="vertical-align:top"><font color=#ff3030>3.</font></td>
                <td colspan="2">若要重訂契約，須支付一筆違約金<br></td>
            </tr>
       </table>   -->
            </li>
        <table class="table1" >
            <thead>
                <tr>
                    <td style="text-align:center">供應商資訊</td>
                    <td style="text-align:center" colspan="2"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>  
                    <th scope="col" style="width:22%">品質</th>
                    <th scope="col">契約最大供應量</th>
                    <th scope="col">關係優惠</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px; width:22%;">供應商A</th>
                    <td style="text-align:center">高</td>
                    <td style="text-align:center"><span id="lap_maxpnum_A">500</span></td>
                    <td style="text-align:center"><span id="lap_discount_A"></span></td>
               </tr>
                <tr>
                    <th scope="row" style="height:45px; width:22%;">供應商B</th>
                    <td style="text-align:center">中</td>
                    <td style="text-align:center"><span id="lap_maxpnum_B">500</span></td> 
                    <td style="text-align:center"><span id="lap_discount_B"></span></td>   
                </tr>
                <tr>
                    <th scope="row" style="height:45px; width:22%;">供應商C</th>
                    <td style="text-align:center">低</td>
                    <td style="text-align:center"><span id="lap_maxpnum_C">500</span></td>
                    <td style="text-align:center"><span id="lap_discount_C"></span></td>
                </tr>
           </tbody> 
           </table>
            <br><br><br>

            <table class="table1">
            <thead>
                <tr>
                    <td  style="text-align:center">研發主機電腦</td>
                    <td  style="text-align:center;"" colspan="3"><img border="0" width="22%" src="../images/material_A.png">螢幕與面板</td>
                    <td  style="text-align:center;" colspan="3"><img border="0" width="22%" src="../images/material_B.png">主機板與核心電路</td>
                    <td  style="text-align:center;" colspan="3"><img border="0" width="22%" src="../images/material_C.png">鍵盤基座</td>
                </tr>
                <tr>
                    <td></td>  
                    <th scope="col">原定價</th>
                    <th scope="col">優惠價</th>
                    <th scope="col">訂購量</th>
                    <th scope="col">原定價</th>
                    <th scope="col">優惠價</th>
                    <th scope="col">訂購量</th>
                    <th scope="col">原定價</th>
                    <th scope="col">優惠價</th>
                    <th scope="col">訂購量</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px"> 供應商A</th>
                    <td style="text-align:center"><span id="lapp_initialprice_A"></span></td>
                    <td style="text-align:center"><span id="lapp_afterdiscount_A"></span></td>
                    <td><input type="text" size="3px" id="lapp_pnum_A" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapc_initialprice_A"></span></td>
                    <td style="text-align:center"><span id="lapc_afterdiscount_A"></span></td>
                    <td><input type="text" size="3px" id="lapc_pnum_A" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapk_initialprice_A"></span></td>
                    <td style="text-align:center"><span id="lapk_afterdiscount_A"></span></td>
                    <td><input type="text" size="3px" id="lapk_pnum_A" onBlur="total()" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"> 供應商B</th>
                     <td style="text-align:center"><span id="lapp_initialprice_B"></span></td>
                    <td style="text-align:center"><span id="lapp_afterdiscount_B"></span></td>
                    <td><input type="text" size="3px" id="lapp_pnum_B" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapc_initialprice_B"></span></td>
                    <td style="text-align:center"><span id="lapc_afterdiscount_B"></span></td>
                    <td><input type="text" size="3px" id="lapc_pnum_B" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapk_initialprice_B"></span></td>
                    <td style="text-align:center"><span id="lapk_afterdiscount_B"></span></td>
                    <td><input type="text" size="3px" id="lapk_pnum_B" onBlur="total()" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"> 供應商C</th>
                    <td style="text-align:center"><span id="lapp_initialprice_C"></span></td>
                    <td style="text-align:center"><span id="lapp_afterdiscount_C"></span></td>
                    <td><input type="text" size="3px" id="lapp_pnum_C" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapc_initialprice_C"></span></td>
                    <td style="text-align:center"><span id="lapc_afterdiscount_C"></span></td>
                    <td><input type="text" size="3px" id="lapc_pnum_C" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="lapk_initialprice_C"></span></td>
                    <td style="text-align:center"><span id="lapk_afterdiscount_C"></span></td>
                    <td><input type="text" size="3px" id="lapk_pnum_C" onBlur="total()" style="text-align:right"></td>
                </tr>
                </tbody>
                <tfoot class="tfoot1">
                <tr>
                    <td colspan="3"></td>
                    <th scope="row"><br>研發總費用</th>
                    <td colspan="2"style="text-align:right"><br>$<span id ="rd_total_l">0</span></td>
                    <td colspan="2"><br><input type="image" src="../images/submit6.png" id="submitA" style="width:100px"></td>
                    </tr>
                </tfoot>    
            </table>

            </div> 
              <div id="tabs-2">
            <p>
                <table class="table1" >
            <thead>
                <tr>
                    <td style="text-align:center">供應商資訊</td>
                    <td  style="text-align:center" colspan="3"></td>
                    <td  style="width:130px"></td>
                    <td  style="width:130px"></td>
                </tr>
                 <tr>
                    <td></td>  
                    <th scope="col" style="width:130px">品質</th>
                    <th scope="col" style="width:140px">契約最大供應量</th>
                    <th scope="col" style="width:130px">關係優惠</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px; width:11.5%;">供應商A</th>
                    <td style="text-align:center">高</td>
                    <td style="text-align:center"><span id="tab_maxpnum_A">500</span></td>
                    <td style="text-align:center"><span id="tab_discount_A"></span></td>
               </tr>
                <tr>
                    <th scope="row" style="height:45px; width:11.5%;">供應商B</th>
                    <td style="text-align:center">中</td>
                    <td style="text-align:center"><span id="tab_maxpnum_B">500</span></td> 
                    <td style="text-align:center"><span id="tab_discount_B"></span></td>   
                </tr>
                <tr>
                    <th scope="row" style="height:45px; width:11.5%;">供應商C</th>
                    <td style="text-align:center">低</td>
                    <td style="text-align:center"><span id="tab_maxpnum_C">500</span></td>
                    <td style="text-align:center"><span id="tab_discount_C"></span></td>
                </tr>
           </tbody> 
           </table>
            <br><br><br>

           <table class="table1">
            <thead>
                <tr>
                   <td  style="text-align:center">研發平板電腦</td>
                    <td  style="width:145px; text-align:center;"" colspan="3"><img border="0" width="22%" src="../images/material_A.png">螢幕與面板</td>
                    <td  style="width:145px; text-align:center;" colspan="3"><img border="0" width="22%" src="../images/material_B.png">主機板與核心電路</td>
                </tr>
                <tr>
                    <td></td>
                    <th scope="col">原定價</th>
                    <th scope="col">優惠價</th>
                    <th scope="col">訂購量</th>
                    <th scope="col">原定價</th>
                    <th scope="col">優惠價</th>
                    <th scope="col">訂購量</th>
                </tr>
            </thead>  
            <tbody>
                <tr>
                    <th scope="row" style="height:45px"> 供應商A</th>
                    <td style="text-align:center"><span id="tabp_initialprice_A"></span></td>
                    <td style="text-align:center"><span id="tabp_afterdiscount_A"></span></td>
                    <td><input type="text" size="3px" id="tabp_pnum_A" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="tabc_initialprice_A"></span></td>
                    <td style="text-align:center"><span id="tabc_afterdiscount_A"></span></td>
                    <td><input type="text" size="3px" id="tabc_pnum_A" onBlur="total()" style="text-align:right"></td>
                 </tr>
                <tr>
                    <th scope="row" style="height:45px"> 供應商B</th>
                    <td style="text-align:center"><span id="tabp_initialprice_B"></span></td>
                    <td style="text-align:center"><span id="tabp_afterdiscount_B"></span></td>
                    <td><input type="text" size="3px" id="tabp_pnum_B" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="tabc_initialprice_B"></span></td>
                    <td style="text-align:center"><span id="tabc_afterdiscount_B"></span></td>
                    <td><input type="text" size="3px" id="tabc_pnum_B" onBlur="total()" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px"> 供應商C</th>
                   <td style="text-align:center"><span id="tabp_initialprice_C"></span></td>
                    <td style="text-align:center"><span id="tabp_afterdiscount_C"></span></td>
                    <td><input type="text" size="3px" id="tabp_pnum_C" onBlur="total()" style="text-align:right"></td>
                    <td style="text-align:center"><span id="tabc_initialprice_C"></span></td>
                    <td style="text-align:center"><span id="tabc_afterdiscount_C"></span></td>
                    <td><input type="text" size="3px" id="tabc_pnum_C" onBlur="total()" style="text-align:right"></td>
                </tr>
           </tbody>
               <tfoot class="tfoot2">
                <tr>
                    <td ></td>
                    <th scope="row"><br>研發總費用</th>
                    <td style="text-align:right" colspan="2"><br>$<span id ="rd_total_t">0</span></td>
                    <td colspan="2"><br><input type="image" src="../images/submit6.png" id="submitB" style="width:100px"></td>
                    </tr>
                 <tr>
                 <td></td>
                 </tr>   
                </tfoot>     
            </table>
         </div> <!-- end tab-2 -->
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>