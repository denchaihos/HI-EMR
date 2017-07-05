<?php
// Start the session
//session_start();
//$_SESSION["vaccation_year"] = "59";
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
$sql = "SELECT o.fudate,concat(d.fname,'   ',d.lname) as doctor,c.namecln from oapp o LEFT JOIN dct d on d.lcno=o.dct
LEFT JOIN cln c on c.cln=o.cln where o.vn='$vn'";


$result = mysql_query($sql, $con);

$data = "<h4>รายการนัดหมาย</h4>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data .= "<span>".$row['fudate'].",&nbsp&nbsp".$row['doctor'].",&nbsp&nbsp".$row['namecln']."</span><br>";



}
echo $data;

exit;

