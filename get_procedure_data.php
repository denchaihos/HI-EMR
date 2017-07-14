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

$vn = $_GET['vn'];
//$vn = 923329;
include "myFunction/myFunction.php";
$data = array();
$data = "";
$sql = "select o.icd9cm,o.icd9name,o.charge,d.fname from oprt o JOIN dct d on d.lcno=o.dct where o.vn='$vn' ";

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
        <td>".$row['icd9cm']."</td>
        <td>".$row['icd9name']."</td>
        <td>".$row['charge']."</td>
        <td>".$row['fname']."</td>
        </tr>";

    }
    $data .="</table>";

echo $data;

exit;
?>
