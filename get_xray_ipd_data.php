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

//$an = $_GET['an'];
$an = '60000045';
$data = array();
$sql = "SELECT xryname,vstdate,vsttime,pricexry from xryrqt x join xray xr on xr.xrycode=x.xrycode
where x.an='$an'  ";
$data = array();

$result = mysql_query($sql, $con);
$data = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_xray'>";
$data .= "<thead><tr><th colspan='2'>รายการ XRay</th></tr><tr><th>Xray Items</th><th>Date</th><th>time</th><th>price</th></tr></thead>";
$data .= "<tbody id='my_ipd_xray'>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  //  $row_array['xryname'] = $row['xryname'];
   // array_push($data,$row_array);
    $data .= "<tr>";
    $data .= "<td>".$row['xryname']."</td>";
    $data .= "<td>".$row['vstdate']."</td>";
    $data .= "<td>".$row['vsttime']."</td>";
    $data .= "<td>".$row['pricexry']."</td>";
    $data .= "</tr>";

}
$data .="</tbody></table>";
echo $data;

exit;

