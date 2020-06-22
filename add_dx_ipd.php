<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$an = $_POST['vn'];//if ipd type  vn  is a an
$icd10 = $_POST['icd10'];
$icd10name = $_POST['icd10name'];

$sql_check_pdx = "SELECT * FROM iptdx join ipt on ipt.an=iptdx.an WHERE ipt.an = '$an' AND iptdx.itemno= 1 ";
$result_check_pdx = mysql_query($sql_check_pdx);

if (mysql_num_rows($result_check_pdx) == 0) {
    $sql = "INSERT INTO iptdx(an,itemno,dct,icd10,icd10name,spclty) values ('$an','1','c45c','$icd10','$icd10name','')";
}else{
    $sql = "INSERT INTO iptdx(an,itemno,dct,icd10,icd10name,spclty) values ('$an','2','c45c','$icd10','$icd10name','')";
}
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



