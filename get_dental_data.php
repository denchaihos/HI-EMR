<?php
// Start the session
//session_start();
//$_SESSION["vaccation_year"] = "59";
function unset_n_reset(&$arr, $key){
    unset($arr[$key]);
    $arr = array_merge($arr);
}
include "connect.php";
include "myFunction/myFunction.php";
$today = time();
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$hn = $_GET['vn'];
//$hn = 1;
//$vn = 740778;
$data =  "<h5>ข้อมูลเบื้องต้น</h5>";
$sql = "SELECT dg.namedtt_gr,s.nameschool,concat(dnt.fname,'  ',dnt.lname) as dentist from dt d
LEFT JOIN dtt_grp dg on dg.codedtt_gr=d.grp
LEFT JOIN school s on s.codeschool=d.schl
LEFT JOIN dentist dnt on dnt.codedtt=d.dnt
where vn=958011";
$result = mysql_query($sql, $con);
$obj = mysql_fetch_object($result);

$data .=  "<span class='label label-default' id='title'>ทันตแพทย์ผู้ทำการตรวจ&nbsp</span>";
$data .="<span class='text_content'>".$obj->dentist . "  &nbsp&nbsp</span>";
$data .="<span id='space'></span>";
$data .="<span class='label label-default' id='title'>กลุ่มประชากร&nbsp</span>";
$data .="<span class='text_content'>". $obj->namedtt_gr . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>ประเภทกลุ่มเป้าหมาย&nbsp</span>";
$data .="<span class='text_content'>". $obj->nameschool . "  &nbsp&nbsp</span>";

/**************dx///////*/

$sql = "SELECT a.namearea,dx.icdda,dx.charge,dx.dtxtime,i.nameicdda from dt d
LEFT JOIN dtdx dx on dx.dn=d.dn
LEFT JOIN icdda i on i.codeicdda=dx.icdda
LEFT JOIN areacode a on a.codearea=dx.area
where d.vn=958011";
$result = mysql_query($sql, $con);

$data .= "<h5>การให้การรักษา</h5>";
$data .="<ul class='emergency'>";
$data .= "<table class='table table-hover' id='my_procedure'>";
$data .="<thead class='mythead'>";
$data .= "<tr></tr><th>ตำแหน่งฟัน</th>";
$data .= "<th>การวินิจฉัย</th>";
$data .= "<th>ชื่อหัตถการ</th>";
$data .= "<th>ราคา</th>";
$data .= "</tr></thead>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data .= "<tr>
    <td>".$row['namearea']."</td>
    <td>".$row['icdda']."</td>
    <td>".$row['nameicdda']."</td>
    <td>".$row['charge']."</td>
    </tr>";

}
$data .="</table>";




echo $data;
?>