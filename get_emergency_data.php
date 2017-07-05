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
$sql = "SELECT e.*,aet.aetype_desc_th,aep.nameaeplace,tae.nametypein,veh.namevehicle from emergency e
JOIN l_aetype aet on aet.aetype_code=e.aetype_ae
JOIN l_aeplace aep on aep.aeplace=e.aeplace
JOIN l_typein_ae tae on tae.typein_ae=e.typein_ae
join l_vehicle veh on veh.vehicle=e.vehicle
where e.vn='$vn'";


$result = mysql_query($sql, $con);


while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data = "<input type='text' name='an' id='an' value='".$row['an']."'>";



}
echo $data;

exit;

