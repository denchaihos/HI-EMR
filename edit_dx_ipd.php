<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$id_dx = $_POST['id_dx'];
$icd10 = $_POST['icd10'];
$icd10name = $_POST['icd10name'];


$sql = "select id from iptdx_original_dx where id=$id_dx";
$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
    $sql = "INSERT INTO iptdx_original_dx (id,an,itemno,icd10,icd10name,spclty,dct,date_update,flag_status)
            SELECT *,now(),'up' from iptdx where id=$id_dx";
    $result = mysql_query($sql);
    if($result)
    {
        echo "Insert Success<br>";
        $sql_update = "update iptdx set icd10 = '$icd10',icd10name = '$icd10name' where id=$id_dx ";
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
    $sql_update = "update iptdx set icd10 = '$icd10',icd10name = '$icd10name' where id=$id_dx ";
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

