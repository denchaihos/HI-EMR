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
include "myFunction/myFunction.php";
$today = time();
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$hn = $_GET['hn'];
//$hn = 1;
//$vn = 740778;

$sql = 'select p.*,m.namemrt,o.nameoccptn,r.namerlgn,t.nametumb,a.nameampur,c.namechw,py.namepttype,nt.namentnlty '
    . 'from pt p left join mrtlst m on m.mrtlst = p.mrtlst '
    . 'left join occptn o on o.occptn = p.occptn '
    . 'left join rlgn r on r.rlgn = p.rlgn '
    . 'LEFT JOIN tumbon t on t.chwpart=p.chwpart and t.amppart=p.amppart and t.tmbpart=p.tmbpart '
    . 'LEFT JOIN ampur a on a.chwpart=p.chwpart and a.amppart=p.amppart '
    . 'LEFT JOIN changwat c on c.chwpart=p.chwpart '
    . 'left join pttype py on py.pttype = p.pttype '
    . 'left join ntnlty nt on nt.ntnlty = p.ntnlty'
    . ' where p.hn = ' . $hn . ' ';
$result = mysql_query($sql, $con);
$obj = mysql_fetch_object($result);


$data =  "<span class='label label-default' id='title'>ชื่อ-นามสกุล&nbsp</span>";
$data .="<span class='text_content'>".$obj->fname . "  &nbsp&nbsp" . $obj->lname."</span>";
$data .="<span id='space'></span>";
$data .="<span class='label label-default' id='title'>วันเดือนปีเกิด&nbsp</span>";
$data .="<span class='text_content'>". DateThai($obj->brthdate) . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>อายุ&nbsp</span>";
$data .="<span class='text_content'>". timespan(strtotime($obj->brthdate), $today) . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>เลขที่บัตรประชาชน&nbsp</span>";
$data .="<span class='text_content'>". $obj->pop_id . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>ชื่อมารดา&nbsp</span>";
$data .="<span class='text_content'>". $obj->mthname . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>ชื่อบิดา&nbsp</span>";
$data .="<span class='text_content'>". $obj->fthname . "  &nbsp&nbsp</span><br/>";

$data .="<span class='label label-default' id='title'>สถานภาพ&nbsp</span>";
$data .="<span class='text_content'>".$obj->namemrt . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>สัญชาติ&nbsp</span>";
$data .="<span class='text_content'>".$obj->namentnlty . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>อาชีพ&nbsp</span>";
$data .="<span class='text_content'>".$obj->nameoccptn . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>ศาสนา&nbsp</span>";
$data .="<span class='text_content'>". $obj->namerlgn . "  &nbsp&nbsp</span>";
$data .="<span class='label label-default' id='title'>กรุ๊ปเลือด&nbsp</span>";
$data .="<span class='text_content'>";

 if ($obj->bloodgrp == '') {
     $data .=" ไม่ระบุ  &nbsp&nbsp";
    } else {
     $data .=$obj->bloodgrp ."  &nbsp&nbsp";
    }
     $data .="</span>";
$data .="<span class='label label-default' id='title'>ประวัติการแพ้ยา&nbsp</span>";
$data .="<span class='text_content'>";
if ($obj->allergy == '' || $obj->allergy == null) {
    $data .=" ไม่ระบุ  &nbsp&nbsp";
    } else {
    $data .= $obj->allergy . "  &nbsp&nbsp";
    }
$data .="</span>";
$data .="<span class='label label-default' id='title'>สิทธิ์ประจำตัว&nbsp</span>";
$data .="<span class='text_content'>". $obj->namepttype . "  &nbsp&nbsp</span>";

$data .="<br>";

$data .="<span class='label label-default' id='title'>เลขที่&nbsp</span>";
$data .="<span class='text_content'> $obj->addrpart    &nbsp&nbsp; </span>";
$data .="<span class='label label-default' id='title'>หมู่&nbsp</span>";
$data .="<span class='text_content'> $obj->moopart    &nbsp&nbsp   </span>";
$data .="<span class='label label-default' id='title'>ตำบล&nbsp</span>";
$data .="<span class='text_content'> $obj->nametumb    &nbsp&nbsp   </span>";
$data .="<span class='label label-default' id='title'>อำเภอ&nbsp</span>";
$data .="<span class='text_content'> $obj->nameampur    &nbsp&nbsp   </span>";
$data .="<span class='label label-default' id='title'>จังหวัด&nbsp</span>";
$data .="<span class='text_content'> $obj->namechw    &nbsp&nbsp   </span>";
$data .="<span class='label label-default' id='title'>โทรศัพท์&nbsp</span>";
$data .="<span class='text_content'> $obj->infmtel  ,  $obj->hometel    &nbsp&nbsp   </span>";

echo $data;
?>