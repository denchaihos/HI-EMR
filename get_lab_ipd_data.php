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

$an = $_GET['an'];
//$an = '60000045';

$sql = "SELECT lb.labcode,lb.ln,l.dbf,CONCAT(l.dbf,l.dbfs) as tableResult,l.labname FROM lbbk lb JOIN lab l on l.labcode=lb.labcode WHERE an ='$an'  ";
$data = array();
//$group = array();
$labff = array();
$exclude_list = array("LCBC","LBUNCR");

$result = mysql_query($sql, $con);

while ($row = mysql_fetch_row($result)) {
    $tables =  "".$row[3]."";
    $tables_array = (explode(",",$tables));
    $group ="".$row[4]."";
    $group_array = (explode(",",$group));
    array_push($data,$group_array);
    foreach($tables_array as $tablesLab){

            $query3 = "SELECT * from  ".strtolower($tablesLab)."  where ln=".$row[1];
            $result3 = mysql_query($query3);
            $num_field = mysql_num_fields($result3);
            $row3 = mysql_fetch_row($result3);

                for($j=1 ; $j < $num_field; $j++){
                    $bb =array();

                   $field = mysql_field_name($result3, $j);
                   $labb = $row3[$j];
                    $query4 = "SELECT normal,unit from  lablabel  where labname='".$row[4]."' and fieldname = '$field' ";
                    $result4 = mysql_query($query4);
                    $row4 = mysql_fetch_row($result4);
                   array_push($bb,$field,$row[1],$labb,$row4[0],$row4[1]);
                   array_push($data,$bb);
                }
    }
}

echo json_encode($data);

exit;

