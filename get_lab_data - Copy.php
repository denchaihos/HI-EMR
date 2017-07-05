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

//$vn = $_GET['vn'];
$vn = 886222;

$sql = "SELECT lb.labcode,lb.ln,l.dbf,CONCAT(l.dbf,l.dbfs) as tableResult,l.labname FROM lbbk lb JOIN lab l on l.labcode=lb.labcode WHERE vn ='$vn' ";
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
       // if($tablesLab != 'LCBC' xor $tablesLab != 'LBUNCR'){
        if(!in_array($tablesLab, $exclude_list)){
            $query = "SELECT lb.fieldlabel, lc.*,lb.normal,lb.unit from lbbk l JOIN ".strtolower($tablesLab)." lc on lc.ln=l.ln
            join lablabel lb on lb.labcode=l.labcode and lb.filename='".strtolower($tablesLab)."' where l.ln=".$row[1];
            $result2 = mysql_query($query);
          //  $i = 1;
            while ($row2 = mysql_fetch_row($result2)) {
                array_push($data,$row2);
               // $i = $i + 1;
            }
        }else{
            $query3 = "SELECT * from  ".strtolower($tablesLab)."  where ln=".$row[1];
            $result3 = mysql_query($query3);
            $num_field = mysql_num_fields($result3);
            $row3 = mysql_fetch_row($result3);

            if($tablesLab == 'LCBC' ){
                for($j=2 ; $j < $num_field; $j++){
                    $bb =array();

                        $field = mysql_field_name($result3, $j);
                        $labb = $row3[$j];
                    array_push($bb,$field,$row[1],$labb,'normal','unit');
                    array_push($data,$bb);
                }
            }else{
                for($j=1 ; $j < $num_field; $j++){
                    $bb =array();
                    $field = mysql_field_name($result3, $j);
                    $labb = $row3[$j];
                    array_push($bb,$field,$row[1],$labb,'normal','unit');
                    array_push($data,$bb);
                }
            }



        }

    }

}

echo json_encode($data);





exit;

