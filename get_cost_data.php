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
$sql = "SELECT ic.namecost,sum(i.rcptamt) as rcptamt from incoth i JOIN income ic on ic.costcenter=i.income
where i.vn='$vn' group  by i.income";


$result = mysql_query($sql, $con);
$data = "<table class='table  col-md-10 table-hover table-striped' id='my_cost'>";
$data .= "<thead><tr><th>กลุ่มค่าใช้จ่าย</th><th>จำนวนเงิน</th></tr></thead>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $data .= "<tbody><tr>";
    $data .= "<td>".$row['namecost']."</td>";
    $data .= "<td>".$row['rcptamt']."</td>";
    $data .="</tr></tbody>";

}
echo $data;

exit;

