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

$vn = $_GET['vn'];
//$vn = 923329;
include "myFunction/myFunction.php";
$data = array();
$data = "";
$sql = "SELECT * from (select o.id,o.icd9cm,o.icd9name,o.charge,d.fname from oprt o JOIN dct d on d.lcno=o.dct JOIN prcd p on p.codeprcd=o.icd9cm where o.vn=$vn and  p.income<>7 GROUP BY o.id UNION ALL
select o.id,o.icd9cm,o.icd9name,o.charge,d.fname from oprt o JOIN dct d on d.dct=left(o.dct,2) JOIN prcd p on p.codeprcd=o.icd9cm where o.vn=$vn and p.income<>7 GROUP BY o.id ) as cc GROUP BY id";

//e.vn='$vn'
$result = mysql_query($sql, $con);

    $data .= "<h5>หัตถการ</h5>";
    $data .="<ul class='emergency'>";
    $data .= "<table class='table table-hover' id='my_procedure'>";
    $data .="<thead class='mythead'>";
    $data .= "<tr></tr><th>icd9</th>";
    $data .= "<th>ชื่อหัตถการ</th>";
    $data .= "<th>ราคา</th>";
    $data .= "<th>ผู้ทำ</th></tr></thead>";
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        $data .= "<tr>
        <td><button type='button' id='".$row['id']."' class='btn btn-info editDx' onclick='popupEditProc(this.id)'>".$row['icd9cm']."</button></td>
        <td>".$row['icd9name']."</td>
        <td>".$row['charge']."</td>
        <td>".$row['fname']."</td>
        </tr>";

    }
    $data .="</table>";

echo $data;

exit;
?>
