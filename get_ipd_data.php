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
$data = array();
$sql = "SELECT i.*,iw.nameidpm,b.namebedtyp,ia.bedno from ipt i
join idpm iw on iw.idpm=i.ward
JOIN iptadm ia on ia.an=i.an
join bedtype b on b.bedtype=ia.bedtype
 where i.vn='$vn'";


$result = mysql_query($sql, $con);


while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $data = "<input type='hidden' name='an1' id='an1' value='".$row['an']."'>";
    $data .=  "<span class='label label-default' id='title'>AN:&nbsp</span>";
    $data .="<span class='text_content'>".$row['an'] . " </span>";
    $data .="<span id='space'></span>";
    $data .=  "<span class='label label-default' id='title'>วันเวลา Admit:&nbsp</span>";
    $data .="<span class='text_content'>".$row['rgtdate'].":".$row['rgttime']." </span>";
    $data .="<span id='space'></span>";
    $data .=  "<span class='label label-default' id='title'>วันเวลา Discharge:&nbsp</span>";
    $data .="<span class='text_content'>".$row['dchdate'].":".$row['dchtime']." </span>";
    $data .="<span id='space'></span>";
    $data .=  "<span class='label label-default' id='title'>รวมวันนอน:&nbsp</span>";
    $data .="<span class='text_content'>".$row['daycnt']."   วัน</span>";
    $data .="<br>";
    $data .=  "<span class='label label-default' id='title'>ตึก:&nbsp</span>";
    $data .="<span class='text_content'>".$row['nameidpm']." </span>";

    $data .=  "<span class='label label-default' id='title'>ห้อง:&nbsp</span>";
    $data .="<span class='text_content'>".$row['namebedtyp']." </span>";

    $data .=  "<span class='label label-default' id='title'>เตียง:&nbsp</span>";
    $data .="<span class='text_content'>".$row['bedno']." </span>";
    $data .="<br>";
    $data .=  "<span class='label label-default' id='title'>drg:&nbsp</span>";
    $data .="<span class='text_content'>".$row['drg']." </span>";
    $data .=  "<span class='label label-default' id='title'>rw:&nbsp</span>";
    $data .="<span class='text_content'>".$row['rw']." </span>";
    $data .=  "<span class='label label-default' id='title'>adjrw:&nbsp</span>";
    $data .="<span class='text_content'>".$row['adjrw']." </span>";
    $data .=  "<span class='label label-default' id='title'>warning:&nbsp</span>";
    $data .="<span class='text_content'>".$row['warning']." </span>";
    $data .=  "<span class='label label-default' id='title'>actlos:&nbsp</span>";
    $data .="<span class='text_content'>".$row['actlos']." </span>";





}
echo $data;

exit;

