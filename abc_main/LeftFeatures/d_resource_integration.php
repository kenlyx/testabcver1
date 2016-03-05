<?php

session_start();
$cid = $_SESSION['cid'];
$year_now=$_SESSION['year'];
$month_now = $_SESSION['month'];
$sum=$month_now+($year_now-1)*12;
$reply = "";

$year = 0;
$month = 0;
$cut_a = 0;
$cut_b = 0;
$cut_c = 0;
$combine1_a = 0;
$combine1_b = 0;
$combine1_c = 0;
$combine2_a = 0;
$combine2_b = 0;
$combine2_c = 0;
$detect_a = 0;
$detect_b = 0;
$detect_c = 0;

$A = 0;
$B = 0;

$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'utf8'");
$connect2 = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect2);

if (($_GET['option']) == "buy") {

    for ($index = 1; $index <= $sum; $index++) {
        $year = (integer) ($index / 12) + 1;
        $month = $index % 12;
        if ($month == 0) {
            $month = 12;
        }
        $machine = mysql_query("SELECT * FROM machine", $connect);
        while ($row = mysql_fetch_array($machine)) {
            if ($row['cid'] == $cid && $row['buy_year'] == $year && $row['buy_month'] == $month) {
                if ($row['function'] == "cut") {
                    if ($row['type'] == "A") {
                        $cut_a++;
                    } elseif ($row['type'] == "B") {
                        $cut_b++;
                    } elseif ($row['type'] == "C") {
                        $cut_c++;
                    }
                } elseif ($row['function'] == "combine1") {
                    if ($row['type'] == "A") {
                        $combine1_a++;
                    } elseif ($row['type'] == "B") {
                        $combine1_b++;
                    } elseif ($row['type'] == "C") {
                        $combine1_c++;
                    }
                } elseif ($row['function'] == "combine2") {
                    if ($row['type'] == "A") {
                        $combine2_a++;
                    } elseif ($row['type'] == "B") {
                        $combine2_b++;
                    } elseif ($row['type'] == "C") {
                        $combine2_c++;
                    }
                } elseif ($row['function'] == "detect") {
                    if ($row['type'] == "A") {
                        $detect_a++;
                    } elseif ($row['type'] == "B") {
                        $detect_b++;
                    } elseif ($row['type'] == "C") {
                        $detect_c++;
                    }
                }
            }
        }
        if ($cut_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','A'," . $cut_a . "],";
        }
        if ($cut_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','B'," . $cut_b . "],";
        }
        if ($cut_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','C'," . $cut_c . "],";
        }
        if ($combine1_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','A'," . $combine1_a . "],";
        }
        if ($combine1_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','B'," . $combine1_b . "],";
        }
        if ($combine1_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','C'," . $combine1_c . "],";
        }
        if ($combine2_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','A'," . $combine2_a . "],";
        }
        if ($combine2_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','B'," . $combine2_b . "],";
        }
        if ($combine2_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','C'," . $combine2_c . "],";
        }
        if ($detect_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','A'," . $detect_a . "],";
        }
        if ($detect_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','B'," . $detect_b . "],";
        }
        if ($detect_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','C'," . $detect_c . "],";
        }
        $cut_a = 0;
        $cut_b = 0;
        $cut_c = 0;
        $combine1_a = 0;
        $combine1_b = 0;
        $combine1_c = 0;
        $combine2_a = 0;
        $combine2_b = 0;
        $combine2_c = 0;
        $detect_a = 0;
        $detect_b = 0;
        $detect_c = 0;
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "sell") {

    for ($index = 1; $index < $sum; $index++) {
        $year = (integer) ($index / 12) + 1;
        $month = $index % 12;
        if ($month == 0) {
            $month = 12;
        }
        $machine = mysql_query("SELECT * FROM machine", $connect);
        while ($row = mysql_fetch_array($machine)) {
            if ($row['cid'] == $cid && $row['sell_month'] == $index) {
                if ($row['function'] == "cut") {
                    if ($row['type'] == "A") {
                        $cut_a++;
                    } elseif ($row['type'] == "B") {
                        $cut_b++;
                    } elseif ($row['type'] == "C") {
                        $cut_c++;
                    }
                } elseif ($row['function'] == "combine1") {
                    if ($row['type'] == "A") {
                        $combine1_a++;
                    } elseif ($row['type'] == "B") {
                        $combine1_b++;
                    } elseif ($row['type'] == "C") {
                        $combine1_c++;
                    }
                } elseif ($row['function'] == "combine2") {
                    if ($row['type'] == "A") {
                        $combine2_a++;
                    } elseif ($row['type'] == "B") {
                        $combine2_b++;
                    } elseif ($row['type'] == "C") {
                        $combine2_c++;
                    }
                } elseif ($row['function'] == "detect") {
                    if ($row['type'] == "A") {
                        $detect_a++;
                    } elseif ($row['type'] == "B") {
                        $detect_b++;
                    } elseif ($row['type'] == "C") {
                        $detect_c++;
                    }
                }
            }
        }
        if ($cut_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','A'," . $cut_a . "],";
        }
        if ($cut_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','B'," . $cut_b . "],";
        }
        if ($cut_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料切割','C'," . $cut_c . "],";
        }
        if ($combine1_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','A'," . $combine1_a . "],";
        }
        if ($combine1_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','B'," . $combine1_b . "],";
        }
        if ($combine1_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第一層組裝','C'," . $combine1_c . "],";
        }
        if ($combine2_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','A'," . $combine2_a . "],";
        }
        if ($combine2_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','B'," . $combine2_b . "],";
        }
        if ($combine2_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'第二層組裝','C'," . $combine2_c . "],";
        }
        if ($detect_a != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','A'," . $detect_a . "],";
        }
        if ($detect_b != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','B'," . $detect_b . "],";
        }
        if ($detect_c != 0) {
            $reply = $reply . "[" . $year . "," . $month . ",'原料&在製品檢驗','C'," . $detect_c . "],";
        }
        $cut_a = 0;
        $cut_b = 0;
        $cut_c = 0;
        $combine1_a = 0;
        $combine1_b = 0;
        $combine1_c = 0;
        $combine2_a = 0;
        $combine2_b = 0;
        $combine2_c = 0;
        $detect_a = 0;
        $detect_b = 0;
        $detect_c = 0;
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "money") {
    $money = mysql_query("SELECT * FROM fund_raising WHERE `cid`='$cid' ORDER BY `year`,`month`", $connect);
    while ($row = mysql_fetch_array($money)) {
        if ($row['cash_increase'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'現金增資',".$row['cash_increase']."],";
        }
        if ($row['short'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'短期借款',".$row['short']."],";
        }
        if ($row['long'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'長期借款',".$row['long']."],";
        }
        if ($row['repay'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'還款(長期借款)',".$row['repay']."],";
        }
        if ($row['short_repay'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'還款(短期借款)',".$row['short_repay']."],";
        }
        if($row['dividend'] != 0) {
            $reply=$reply."[".$row['year'].",".$row['month'].",'發放現金股利','每股".$row['dividend']."元'],";
        }
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
} elseif (($_GET['option']) == "research") {
    $r_d = mysql_query("SELECT * FROM r_d WHERE `cid`='$cid'", $connect);
    while ($row = mysql_fetch_array($r_d)) {
        if ($row['type'] == "A") {
            $year = $row['year'];
            $month = $row['month'];
            if ((int) $row['source'] == 1) {
                $resource = mysql_query("SELECT * FROM supplier_a", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "A") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','螢幕與面板','供應商A',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','主機板與核心電路','供應商A',";
                                } elseif ((int) $col['source'] == 3) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','鍵盤基座','供應商A',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            } elseif ((int) $row['source'] == 2) {
                $resource = mysql_query("SELECT * FROM supplier_b", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "A") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','螢幕與面板','供應商B',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','主機板與核心電路','供應商B',";
                                } elseif ((int) $col['source'] == 3) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','鍵盤基座','供應商B',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            } elseif ((int) $row['source'] == 3) {
                $resource = mysql_query("SELECT * FROM supplier_c", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "A") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','螢幕與面板','供應商C',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','主機板與核心電路','供應商C',";
                                } elseif ((int) $col['source'] == 3) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'筆記型電腦','鍵盤基座','供應商C',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            }
        } elseif ($row['type'] == "B") {
            $year = $row['year'];
            $month = $row['month'];
            if ((int) $row['source'] == 1) {
                $resource = mysql_query("SELECT * FROM supplier_a", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "B") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','螢幕與面板','供應商A',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','主機板與核心電路','供應商A',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            } elseif ((int) $row['source'] == 2) {
                $resource = mysql_query("SELECT * FROM supplier_b", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "B") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','螢幕與面板','供應商B',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','主機板與核心電路','供應商B',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            } elseif ((int) $row['source'] == 3) {
                $resource = mysql_query("SELECT * FROM supplier_c", $connect2);
                while ($col = mysql_fetch_array($resource)) {
                    if ($col['cid'] == $cid) {
                        if ($col['year'] == $year && $col['month'] == $month) {
                            if ($col['type'] == "B") {
                                if ((int) $col['source'] == 1) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','螢幕與面板','供應商C',";
                                } elseif ((int) $col['source'] == 2) {
                                    $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",'平板電腦','主機板與核心電路','供應商C',";
                                }
                                $reply = $reply . $col['price'] . "," . $col['quantity'] . "],";
                            }
                        }
                    }
                }
            }
        }
    }
	$_SESSION['year']=$year_now;
	$_SESSION['month']=$month_now;
}
echo "[" . $reply . "]";
?>
