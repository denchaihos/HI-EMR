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
//$vn = 770461;
$data = array();
$sql = "SELECT xr.xryname from xryrqt x join xray xr on xr.xrycode=x.xrycode
where x.vn='$vn'  ";
$data = array();

$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['xryname'] = $row['xryname'];

    array_push($data,$row_array);
}
echo json_encode($data);

exit;

