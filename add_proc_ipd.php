<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");


$vn = $_POST['vn']; 
$an = $_POST['an']; 
$icd9ttm = $_POST['icd9ttm'];
$icd9ttmname = $_POST['icd9ttmname'];
$icd9price = $_POST['icd9price'];
$codeicd9id = $_POST['codeicd9id'];

// $sql_check_proc = "select id from ioprt where an=$an";
// $result_check = mysql_query($sql_check_proc);

// if (mysql_num_rows($result_check) == 0) {
//     $orno = 1;
// }


$sql = "INSERT INTO ioprt (an,hn,date,time,dct,orno,icd9cm,icd9name,optype,charge,rcptno,codeicd9id,oppnote,qty)
            SELECT '$an',hn,date(vstdttm),TIME_FORMAT(vstdttm, '%H%i'),dct,'0','$icd9ttm','$icd9ttmname','','$icd9price',rcptno,'$codeicd9id','','' from ovst where vn=$vn";

$result = mysql_query($sql);
if($result)
{
    echo "Insert Success<br>";

}
else
{
    echo "INsert Error<br>";
    echo mysql_error();

}



