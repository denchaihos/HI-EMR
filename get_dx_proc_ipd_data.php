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
$data = array();
$data2 = array();

//dianosis
$sql = "SELECT ix.id,ix.icd10,i.icd10name,i.name_t,concat(d.fname,' ' ,d.lname) as doctor
from iptdx ix JOIN icd101 i on i.icd10=ix.icd10
JOIN dct d on d.lcno=ix.dct
where ix.an='$an' ";
$data = array();

$result = mysql_query($sql, $con);
$data = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_dx'>";
$data .= "<thead><tr><th colspan='2'>Diagnosis IPD</th></tr><tr><th>Code</th><th>Name</th><th>Thai Name</th><th>Doctor</th></tr></thead>";
$data .= "<tbody id='my_ipd_dx'>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
  //  $row_array['xryname'] = $row['xryname'];
   // array_push($data,$row_array);
    $data .= "<tr>";
    $data .= "<td><button type='button' id='".$row['id']."' class='btn btn-info editDx' onclick='popupEditDx(this.id)'>".$row['icd10']."</button></td>";
    $data .= "<td>".$row['icd10name']."</td>";
    $data .= "<td>".$row['name_t']."</td>";
    $data .= "<td>".$row['doctor']."</td>";
    $data .= "</tr>";

}
$data .="</tbody></table>";


//Procedure
$sql = "SELECT i.id,i.icd9cm,i.icd9name,i.date,i.time,i.charge FROM ioprt i join prcd p on p.codeprcd=i.icd9cm  where p.income='04' and  i.an='$an' GROUP BY i.id ";
$data2 = array();

$result = mysql_query($sql, $con);
$data2 = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_dx'>";
$data2 .= "<thead><tr><th colspan='2'>Procedure IPD</th></tr><tr><th>Code</th><th>Name</th><th>Date</th><th>Time</th><th>Price</th></tr></thead>";
$data2 .= "<tbody id='my_ipd_proc'>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    //  $row_array['xryname'] = $row['xryname'];
    // array_push($data,$row_array);
    $data2 .= "<tr>";
    $data2 .= "<td><button type='button' id='".$row['id']."' class='btn btn-info editDx' onclick='popupEditProc(this.id)'>".$row['icd9cm']."</button></td>";
    $data2 .= "<td>".$row['icd9name']."</td>";
    $data2 .= "<td>".$row['date']."</td>";
    $data2 .= "<td>".$row['time']."</td>";
    $data2 .= "<td>".$row['charge']."</td>";
    $data2 .= "</tr>";

}
$data .="</tbody></table>";





echo $data;
echo $data2;
?>

<script src="myFunction/get_dx_proc_ipd_data.js"></script>
<?php
exit;
?>

