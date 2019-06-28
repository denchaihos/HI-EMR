<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$id_dx = $_POST['id_dx'];
$icd9ttm = $_POST['icd9ttm'];
$icd9ttmname = $_POST['icd9ttmname'];


$sql = "select id from tsu_oprt_original where id=$id_dx";
$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
    $sql = "INSERT INTO tsu_oprt_original (id,vn,opdttm,an,icd9cm,icd9name,dct,orno,charge,oppnote,rcptno,codeicd9id,date_update,flag_status)
            SELECT *,now(),'up' from oprt where id=$id_dx";
    $result = mysql_query($sql);
    if($result)
    {
        echo "Insert Success<br>";
        $sql_update = "update oprt set icd9cm = '$icd9ttm',icd9name = '$icd9ttmname' where id=$id_dx ";
        $result_update = mysql_query($sql_update);
        if($result_update)
        {
            echo "Update Success<br>";
        }
        else
        {
            echo "Update Error<br>";

        }
    }
    else
    {
        echo "INsert Error<br>";

    }
}else{
    $sql_update = "update oprt set icd9cm = '$icd9ttm',icd9name = '$icd9ttmname' where id=$id_dx ";
    $result_update = mysql_query($sql_update);
    if($result_update)
    {
        echo "Update Success<br>";
    }
    else
    {
        echo "Update Error";

    }
}

