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
//$vn = 923329;
$data = array();
$sql = "SELECT l.labname from lbbk lb JOIN lab l on l.labcode=lb.labcode
where lb.vn='$vn'";


$result = mysql_query($sql, $con);

$data = "<h4>รายการ Lab ส่งตรวจ</h4>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data .= "<span>".$row['labname'].",&nbsp&nbsp</span>";



}
echo $data;

exit;

