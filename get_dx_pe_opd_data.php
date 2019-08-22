<?php
// Start the session
//session_start();
//$_SESSION["vaccation_year"] = "59";
header('Content-Type: text/html; charset=utf-8');
function unset_n_reset(&$arr, $key)
{
    unset($arr[$key]);
    $arr = array_merge($arr);
}

include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$vn = $_GET['vn'];
//$vn = 922837;
$data = array();
$data2 = array();
$data3 = array();
$data4 = array();

$sql_count = "select vn from ovst where vn= $vn";
$result_count = mysql_query($sql_count);
$numrows = mysql_num_rows($result_count);
if ($numrows > 0) {
    $sql_pe = "select sign from sign where vn=" . $vn . " ";
    $result_pe = mysql_query($sql_pe);
    $data2 = "<span class='label label-default'>PE::</span>&nbsp&nbsp&nbsp&nbsp";

    while ($row_pe = mysql_fetch_array($result_pe, MYSQL_ASSOC)) {
        $data2 .= "<span>" . $row_pe['sign'] . "</span>&nbsp&nbsp&nbsp&nbsp";
    };


    $sql_pi = "select pillness from pillness where vn=" . $vn . " ";
    $result_pi = mysql_query($sql_pi);
    $data3 = "<span class='label label-default'>PI::</span>&nbsp&nbsp&nbsp&nbsp";

    while ($row_pi = mysql_fetch_array($result_pi, MYSQL_ASSOC)) {

        $data3 .= "<span>" . $row_pi['pillness'] . "</span>&nbsp&nbsp&nbsp&nbsp";
    };

//dianosis

    $sql = "select o.id,if(o.cnt=1,'PDX','Other') as dxtype,o.icd10,i.icd10name,i.name_t,concat(d.fname,' ' ,d.lname) as doctor "
        . " from  ovstdx o left outer join icd101  i on i.icd10=o.icd10 "
        . " JOIN ovst ot on ot.vn=o.vn "
        . " left JOIN dct d on d.lcno=ot.dct  "
        . " where o.vn=" . $vn . " ORDER BY o.cnt desc ";


    $result = mysql_query($sql, $con);
    $data = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_dx' width: 80%>";
    $data .= "<thead><tr><th colspan='5'>Diagnosis OPD<button type='button' id='addDx' class='btn btn-info addDx' onclick='popupEditDx(this.id)'>++</button></th></tr>
    <tr><th>Code</th><th>Dx Type</th><th>Name</th><th>Thai Name</th><th>Doctor</th><th>..</th></tr></thead>";
    $data .= "<tbody id='my_ipd_dx'>";
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        //  $row_array['xryname'] = $row['xryname'];
        // array_push($data,$row_array);
        $data .= "<tr>";
        $data .= "<td><button type='button' id='" . $row['id'] . "' class='btn btn-info editDx' onclick='popupEditDx(this.id)'>" . $row['icd10'] . "</button></td>";
        $data .= "<td>" . $row['dxtype'] . "</td>";
        $data .= "<td>" . $row['icd10name'] . "</td>";
        $data .= "<td>" . $row['name_t'] . "</td>";
        $data .= "<td>" . $row['doctor'] . "</td>";
        if($row['dxtype']=='PDX'){
            $data .= "<td></td>";
        }else{
            $data .= "<td><button type='button' id='" . $row['id'] . "' class='btn btn-danger btn-xs' onclick='delDx(this.id)'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
        }
        $data .= "</tr>";
    }
    $data .= "</tbody></table>";
//Procedure  opd

    $sql = "SELECT * from(select o.id,o.icd9cm,o.icd9name,o.charge,d.fname from oprt o JOIN dct d on d.lcno=o.dct where o.vn=$vn GROUP BY o.id UNION
select o.id,o.icd9cm,o.icd9name,o.charge,d.fname from oprt o JOIN dct d on d.dct=left(o.dct,2) where o.vn=$vn GROUP BY o.id ) as cc
GROUP BY id";

    $result = mysql_query($sql, $con);
    $data4 = "<table class='table table-hover' id='my_procedure'>";
    $data4 .= "<thead class='mythead'>";
    $data4 .= "<tr><th colspan='4'>Procedure OPD<button type='button' id='addProc' class='btn btn-info addProc' onclick='popupEditProc(this.id)'>++</button></th></tr>";
    $data4 .= "<tr></tr><th>icd9</th>";
    $data4 .= "<th>ชื่อหัตถการ</th>";
    $data4 .= "<th>ราคา</th>";
    $data4 .= "<th>ผู้ทำ</th><th>..</th></tr></thead>";

    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $data4 .= "<tr>
        <td><button type='button' id='" . $row['id'] . "' class='btn btn-info editDx' onclick='popupEditProc(this.id)'>" . $row['icd9cm'] . "</button></td>
        <td>" . $row['icd9name'] . "</td>
        <td>" . $row['charge'] . "</td>
        <td>" . $row['fname'] . "</td>
        <td><button type='button' id='".$row['id']."' class='btn btn-danger btn-xs' onclick='delProcedure(this.id)'><i class='fa fa-trash' aria-hidden='true'></i></button></td>
        </tr>";
    }
    $data4 .= "</table>";
    echo "<table width='80%' id='my_ipd_dx'><tr>";
    echo "<td width='50%' style='vertical-align: top'>" . $data3 . "</td><td width='50%' style='vertical-align: top'>" . $data2 . "</td>";
    echo "</tr></table>";
    echo $data;
    echo "<br>";
    echo $data4;
}else{
    $data = "";
    $data2 =  "";
    $data3 =  "";
    $data4 = "";
    echo $data;
}

?>

<script src="myFunction/get_dx_proc_ipd_data.js"></script>
<?php
exit;
?>


