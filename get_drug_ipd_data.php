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
$data = array();
//$an = '60000045';


$sql_med_home = "SELECT max(prscno) as prscno from prsc where an='$an' and charge>0 ";
$result_med_home = mysql_query($sql_med_home, $con);
$prscno_med_home = mysql_fetch_array($result_med_home);
$prscno_med_home = $prscno_med_home['prscno'];


$sql = "SELECT ipr.namedrug,ipr.qty,p.charge,ipr.medusage,m.doseprn1,m.doseprn2,ipr.qty * mt.price as chargeprice
 from prsc p JOIN iprsc ipr on ipr.prscno=p.prscno
 JOIN meditem mt on mt.meditem=ipr.meditem
left join medusage m on m.dosecode=ipr.medusage
 where p.an='$an' GROUP BY p.prscno,ipr.meditem,ipr.medusage ";
$result = mysql_query($sql, $con);

$data = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_drug1'>";
$data .= "<thead><tr><th colspan='2'>ยาและอุปกรณ์ที่ใช้ในโรงพยาบาล</th></tr><tr><th>รายการยา</th><th>จำนวน</th><th>ราคา</th><th>วิธีกิน</th><th>เวลากิน</th></tr></thead>";
$data .= "<tbody id='my_ipd_drug'>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $data .="<tr>";
    $data .= "<td>".$row['namedrug']."</td>";
    $data .= "<td>".$row['qty']."</td>";
    $data .= "<td>".$row['chargeprice']."</td>";
    $data .= "<td>".$row['doseprn1']."</td>";
    $data .= "<td>".$row['doseprn2']."</td>";
    $data .="</tr>";
}
$data .="</tbody></table>";

$data2 = array();

$sql2 = "SELECT pd.nameprscdt,pd.qty,pd.charge,m.doseprn1,m.doseprn2
from prsc p JOIN ipt i on i.an=p.an
JOIN prscdt pd on pd.prscno=p.prscno
JOIN medusage m on m.dosecode=pd.medusage
where p.prscno='$prscno_med_home' and pd.qty>0
GROUP BY p.prscno,pd.meditem,pd.medusage
 ";


$result2 = mysql_query($sql2, $con);

$data2 = "<table class='table  col-md-10 table-hover table-striped' id='my_ipd_drughome1'>";
$data2 .= "<thead><tr><th colspan='5'>ยาและอุปกรณ์ที่นำไปใช้ที่บ้าน</th></tr><tr><th>รายการยา</th><th>จำนวน</th><th>ราคา</th><th>วิธีกิน</th><th>เวลากิน</th></tr></thead>";
$data2 .= "<tbody id='my_ipd_drughome'>";
while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)) {
    $data2 .="<tr>";
    $data2 .= "<td>".$row2['nameprscdt']."</td>";
    $data2 .= "<td>".$row2['qty']."</td>";
    $data2 .= "<td>".$row2['charge']."</td>";
    $data2 .= "<td>".$row2['doseprn1']."</td>";
    $data2 .= "<td>".$row2['doseprn2']."</td>";
    $data2 .="</tr>";

}
$data2 .="</tbody></table>";

echo $data;

echo $data2;

exit;