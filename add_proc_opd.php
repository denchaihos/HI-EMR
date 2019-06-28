<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");


$vn = $_POST['vn'];
$icd9ttm = $_POST['icd9ttm'];
$icd9ttmname = $_POST['icd9ttmname'];
$icd9price = $_POST['icd9price'];
$codeicd9id = $_POST['codeicd9id'];


$sql = "INSERT INTO oprt (vn,opdttm,an,icd9cm,icd9name,dct,orno,charge,oppnote,rcptno,codeicd9id)
            SELECT vn,vstdttm,'0','$icd9ttm','$icd9ttmname',dct,'0','$icd9price','','0','$codeicd9id' from ovst where vn=$vn";

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



