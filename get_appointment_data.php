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
//$vn = 958923;
$data = array();
$sql = "SELECT o.fudate,concat(d.fname,'   ',d.lname) as doctor,c.namecln,o.dscrptn from oapp o LEFT JOIN dct d on d.lcno=o.dct
LEFT JOIN cln c on c.cln=o.cln where o.vn='$vn' group  by o.id";


$result = mysql_query($sql, $con);

$data = "<span class='label label-default'>รายการนัดหมาย</span>&nbsp&nbsp";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data .= "<span id='appoint'>".$row['fudate'].",&nbsp&nbsp".$row['doctor'].",&nbsp&nbsp".$row['namecln'].",&nbsp&nbsp".$row['dscrptn']."</span><br>";



}
echo $data;

exit;

