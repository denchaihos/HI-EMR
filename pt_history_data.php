<?php
header('Content-Type: text/html; charset=utf-8');
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
//$vstdttm =$_GET['vstdttm'];
//$hn = $_GET['hn'];
$vn = $_GET['vn'];
 $sql ="select o.*,od.id as id_dx,time(o.vstdttm) as vstdttm,concat(od.icd10,':',i.icd10name) as pdx,od.cnt from ovst o "
         . " left outer join ovstdx od on od.vn=o.vn   "
         . " left outer join icd101 i on i.icd10=od.icd10   "
         . " where o.vn = '$vn'  and od.cnt=1 order by o.vstdttm desc ";
$data = array();
$result = mysql_query($sql,$con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['bw'] = $row['bw'];
    $row_array['height'] = $row['height'];
    $row_array['waist_cm'] = $row['waist_cm'];
    $row_array['bmi'] = $row['bmi'];
    $row_array['tt'] = $row['tt'];
    $row_array['pr'] = $row['pr'];
    $row_array['rr'] = $row['rr'];
    $row_array['sbp'] = $row['sbp'];
    $row_array['dbp'] = $row['dbp'];
    //cc////////
    $sql_cc = 'select symptom from symptm where vn="'.$row['vn'].'"  ';
    $result_cc = mysql_query($sql_cc);
    $row_array['cc'] = "-";
    while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
             $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];     
    };



    array_push($data,$row_array);   
}
echo json_encode($data);
exit;
?>