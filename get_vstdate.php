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

$hn = $_GET['hn'];
//$hn = 6105;
//$vn = 740778;

$sql = 'select o.vn,o.vstdttm ,time(o.vstdttm) as vstdttmtime,o.an,c.costcenter from ovst o JOIN cln c on c.cln=o.cln where o.hn = ' . $hn . ' order by vstdttm desc';
$result = mysql_query($sql, $con);

$data = array();

$result = mysql_query($sql, $con);
$x = 0;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['vn'] = $row['vn'];
    $row_array['an'] = $row['an'];
    $row_array['vstdttm'] = $row['vstdttm'];
    $row_array['vstdttmtime'] = $row['vstdttmtime'];
    $row_array['costcenter'] = $row['costcenter'];

    array_push($data,$row_array);

}
echo json_encode($data);
exit;

