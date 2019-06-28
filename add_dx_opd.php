<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$vn = $_POST['vn'];
$icd10 = $_POST['icd10'];
$icd10name = $_POST['icd10name'];

$sql_check_pdx = "SELECT * FROM ovstdx WHERE vn = '$vn' AND cnt= 1 ";
$result_check_pdx = mysql_query($sql_check_pdx);

if (mysql_num_rows($result_check_pdx) == 0) {
    $sql = "INSERT INTO ovstdx(vn,icd10,icd10name,cnt,consultid) values ('$vn','$icd10','$icd10name','1','0')";
}else{
    $sql = "INSERT INTO ovstdx(vn,icd10,icd10name,cnt,consultid) values ('$vn','$icd10','$icd10name','0','0')";
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



