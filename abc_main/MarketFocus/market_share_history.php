<?php
	function printrow($array,$type,$flag,$j){//一個用來印出列中資料的方法
            for($i=0;$i<$j;$i++){
                if($array[$i]<0)
                    echo "<td>(".-$array[$i].")</td>";
                else
                    echo "<td>".$array[$i]."</td>";
            }
            if($flag==1)//控制下一列的背景色彩
                echo "</tr><tr style='background:#FFFFFF'>";
            else
                echo "</tr><tr>";
            $flag*=-1;
            return $flag;//將控制色彩的變數傳回主程式
	}
	function market_share_history($type,$month){//印出報表的主程式
            $year=(int)(($month-1)/12)+1;
            $first_month=$month%12;
            $change=0;                                                          //控制列為空值的變數，1代表不為空
            $flag=1;                                                            //控制列的背景色彩，1代表有色彩
            $connect=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());  //與資料庫進行連結
            $obj=mysql_connect("localhost","root","53g4ek7abc") or die(mysql_error());      //同上
            mysql_select_db("testabc_login", $connect);//讀ABC所有的公司名稱
            mysql_query("set names 'utf8'");
            $C_name=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account ORDER BY `CompanyID`",$connect);
            mysql_select_db("testabc_main",$connect);
			$type_name=array("A"=>"筆記型電腦","B"=>"平板電腦");
            echo "<table class='yellowtable' border:25px double style='text-align:right' cellspacing='0'
                    cellpadding= '0'><caption><font size='6'><b>".$type_name[$type]."</b></font></caption><tr><th>年份</th>";
            for($i=$month;$i<$month+12;$i++){//印出年份
                if($i%12==1||$i==$month)
                    echo "<th width =50>第".((int)(($i-1)/12)+1)."年</th>";
                else
                    echo "<th width =50></th>";
            }
            echo "</tr><tr><th>月份</th>";
            for($i=$first_month;$i<$first_month+12;$i++){//印出月份
                if($i%12==0)
                    echo "<th>第12月</th>";
                else
                    echo "<th>第".($i%12)."月</th>";
            }
            while($company=mysql_fetch_array($C_name)){
                $product=0;
                echo "</tr><tr><th>".$company[0]."</th>";
                for($i=$month;$i<$month+12;$i++){
                    if($i%12==0){
                        $month_now=12;
                    }
                    else{
                        $month_now=$i%12;
                    }
                        $year_now=(int)(($i-1)/12+1);
                    $result=mysql_query("SELECT * FROM `order_accept` WHERE `month`=$month_now AND `year`=$year_now AND `cid`='$company[0]' AND `accept`=1",$connect);
                    while($temp=mysql_fetch_array($result)){
                        if($temp!=NULL){
                            $sub=explode("_",$temp['order_no']);
                            if($sub[1]==$type)
                                $product+=$temp['quantity'];
                        }else
                            break;
                    }
                    echo "<th>".$product."</th>";
                    $product=0;
                }
            }
            echo "</tr></table>";
	}
	market_share_history(mysql_real_escape_string($_POST['type']),mysql_real_escape_string($_POST['month']));
?>