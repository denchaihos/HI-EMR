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
$sql = "SELECT i.an,i.hn from ipt i where i.vn='$vn'";


$result = mysql_query($sql, $con);


while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data = "<input type='text' name='an' id='an' value='".$row['an']."'>";



}
echo $data;

exit;

