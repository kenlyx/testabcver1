<?php session_start();?>
<?php
$cid = $_SESSION['cid'];

$reply = "";
$price = 0;
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
mysql_query("set names 'utf8'");
$people = mysql_query("SELECT * FROM `current_people` WHERE `month`<>0 AND `cid`='$cid';", $connect);

if (($_GET['option']) == "hire") {
    while ($row = mysql_fetch_array($people)) {
        if ($row['cid'] == $cid) {
            if ((integer) $row['hire_count'] != 0) {
                $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",";
                if ($row['department'] == "finance") {
                    $reply = $reply . "'財務人員',";
                    $price = 300 * (integer) $row['hire_count'];
                } elseif ($row['department'] == "sale") {
                    $reply = $reply . "'行銷與業務人員',";
                    $price = 300 * (integer) $row['hire_count'];
                } elseif ($row['department'] == "equip") {
                    $reply = $reply . "'資源運籌人員',";
                    $price = 300 * (integer) $row['hire_count'];
                } elseif ($row['department'] == "human") {
                    $reply = $reply . "'行政人員',";
                    $price = 300 * (integer) $row['hire_count'];
                } elseif ($row['department'] == "research") {
                    $reply = $reply . "'研發人員',";
                    $price = 300 * (integer) $row['hire_count'];
                }
                $reply = $reply . $row['hire_count'] . "," . $price . "],";
            }
        }
    }
} elseif (($_GET['option']) == "fire") {
    $correspondence = mysql_query("SELECT * FROM `correspondence` WHERE `name`='current_people'", $connect);
    $correspond = mysql_fetch_array($correspondence);
    $correspondence = mysql_query("SELECT * FROM `correspondence` WHERE `name`='current_people_2'", $connect);
    $correspond2 = mysql_fetch_array($correspondence);
    while ($row = mysql_fetch_array($people)) {
        if ($row['cid'] == $cid) {
            if ((integer) $row['fire_count'] != 0) {
                $reply = $reply . "[" . $row['year'] . "," . $row['month'] . ",";
                if ($row['department'] == "finance") {
                    $reply = $reply . "'財務人員',";
                    $price = ($correspond['money2'] * 3) * (integer) $row['fire_count'];
                } elseif ($row['department'] == "sale") {
                    $reply = $reply . "'行銷與業務人員',";
                    $price = ($correspond2['money'] * 3) * (integer) $row['fire_count'];
                } elseif ($row['department'] == "equip") {
                    $reply = $reply . "'資源運籌人員',";
                    $price = ($correspond['money3'] * 3) * (integer) $row['fire_count'];
                } elseif ($row['department'] == "human") {
                    $reply = $reply . "'行政人員',";
                    $price = ($correspond2['money2'] * 3) * (integer) $row['fire_count'];
                } elseif ($row['department'] == "research") {
                    $reply = $reply . "'研發人員',";
                    $price = ($correspond2['money3'] * 3) * (integer) $row['fire_count'];
                }
                $reply = $reply . $row['fire_count'] . "," . $price . "],";
            }
        }
    }
} elseif (($_GET['option']) == "train") {
    $correspondence = mysql_query("SELECT * FROM `correspondence` WHERE `name`='training'", $connect);
    $correspond = mysql_fetch_array($correspondence);
    $train = mysql_query("SELECT * FROM `training` WHERE `cid`='$cid'", $connect);
    while ($row = mysql_fetch_array($train)) {
        if ((int) $row['decision1'] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'財務人員'," . (int) $correspond['money'] . "],";
        } elseif ((int) $row['decision1'] == 2) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'財務人員'," . (int) $correspond['money2'] . "],";
        } elseif ((int) $row['decision1'] == 3) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'財務人員'," . (int) $correspond['money3'] . "],";
        }
        if ((int) $row['decision2'] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'資源運籌人員'," . (int) $correspond['money'] . "],";
        } elseif ((int) $row['decision2'] == 2) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'資源運籌人員'," . (int) $correspond['money2'] . "],";
        } elseif ((int) $row['decision2'] == 3) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'資源運籌人員'," . (int) $correspond['money3'] . "],";
        }
        if ((int) $row['decision3'] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行銷與業務人員'," . (int) $correspond['money'] . "],";
        } elseif ((int) $row['decision3'] == 2) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行銷與業務人員'," . (int) $correspond['money2'] . "],";
        } elseif ((int) $row['decision3'] == 3) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行銷與業務人員'," . (int) $correspond['money3'] . "],";
        }
        if ((int) $row['decision4'] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行政人員'," . (int) $correspond['money'] . "],";
        } elseif ((int) $row['decision4'] == 2) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行政人員'," . (int) $correspond['money2'] . "],";
        } elseif ((int) $row['decision4'] == 3) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'行政人員'," . (int) $correspond['money3'] . "],";
        }
        if ((int) $row['decision5'] == 1) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'研發人員'," . (int) $correspond['money'] . "],";
        } elseif ((int) $row['decision5'] == 2) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'研發人員'," . (int) $correspond['money2'] . "],";
        } elseif ((int) $row['decision5'] == 3) {
            $reply = $reply . "[" . $row['year'] . "," . $row['month'] . "," . "'研發人員'," . (int) $correspond['money3'] . "],";
        }
    }
}

echo "[" . $reply . "]";
?>
