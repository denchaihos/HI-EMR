<?php
// Start the session
//session_start();
//$_SESSION["vaccation_year"] = "59";
header('Content-Type: text/html; charset=utf-8');
function unset_n_reset(&$arr, $key){
    unset($arr[$key]);
    $arr = array_merge($arr);
}
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$vn = $_GET['vn'];
//$vn = 863114;
$data = array();
/*pt inform*/
$sql = "SELECT count(vn) as inform FROM ovst where sbp is not null and vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['inform'] = $row['inform'];
    array_push($data,$row_array);
}
/*doctor diag*/
$sql = "SELECT count(vn) as doctor FROM ovstdx where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['doctor'] = $row['doctor'];
    array_push($data,$row_array);
}
/*drug*/
$sql = "SELECT count(p.vn) as drug from prsc p JOIN prscdt pd on pd.prscno=p.prscno where p.vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['drug'] = $row['drug'];
    array_push($data,$row_array);
}
/*emergency*/
$sql = "SELECT e.emergency from(
SELECT count(e.vn) as emergency FROM emergency e where  e.vn=$vn
UNION
SELECT count(p.vn) as emergency FROM oprt p where  p.vn=$vn
) as e where e.emergency>0   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['emergency'] = $row['emergency'];
    array_push($data,$row_array);
}
/*dental*/
$sql = "SELECT count(vn) as dental FROM dt where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['dental'] = $row['dental'];
    array_push($data,$row_array);
}
/*ipd*/
$sql = "SELECT count(vn) as ipd FROM ipt where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['ipd'] = $row['ipd'];
    array_push($data,$row_array);
}
/*lab*/
$sql = "SELECT count(vn) as lab FROM lbbk where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['lab'] = $row['lab'];
    array_push($data,$row_array);
}
/*xray*/
$sql = "SELECT count(vn) as xray FROM xryrqt where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['xray'] = $row['xray'];
    array_push($data,$row_array);
}
/*cost*/
$sql = "SELECT sum(rcptamt) as cost FROM incoth where  vn=$vn   ";
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['cost'] = $row['cost'];
    array_push($data,$row_array);
}
echo json_encode($data);

exit;

