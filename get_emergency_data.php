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
$sql = "SELECT e.sickdate,e.sicktime,aet.aetype_desc_th,aep.nameaeplace,tae.nametypein,veh.namevehicle,
CASE e.traffic
WHEN '1' THEN 'ผู้ขับขี่'
WHEN '2' THEN 'ผู้โดยสาร'
WHEN '3' THEN 'คนเดินเท้า'
WHEN '8' THEN 'อื่น ๆ'
ELSE 'อื่น ๆ'
END AS traffic,
CASE e.alochol
WHEN '1' THEN 'ดื่ม'
WHEN '2' THEN 'ไม่ดื่ม'
WHEN '9' THEN 'ไม่ทราบ'
END AS alochol,
CASE e.nacrotic
WHEN '1' THEN 'ใช้'
WHEN '2' THEN 'ไม่ใช้'
WHEN '9' THEN 'ไม่ทราบ'
END AS nacrotic,

CASE e.belt
WHEN '1' THEN 'คาด'
WHEN '2' THEN 'ไม่คาด'
WHEN '9' THEN 'ไม่ทราบ'
END AS belt,

CASE e.helmet
WHEN '1' THEN 'สวม'
WHEN '2' THEN 'ไม่สวม'
WHEN '9' THEN 'ไม่ทราบ'
END AS helmet,

CASE e.airway
WHEN '1' THEN 'มีการดูแลการหายใจก่อนมาถึง'
WHEN '2' THEN 'ไม่มีการดูแลการหายใจก่อนมาถึง'
WHEN '3' THEN 'ไม่จำเป็น'
END AS airway,

CASE e.stopbleed
WHEN '1' THEN 'มีการดูแลการหายใจก่อนมาถึง'
WHEN '2' THEN 'ไม่มีการดูแลการหายใจก่อนมาถึง'
WHEN '3' THEN 'ไม่จำเป็น'
END AS stopbleed,

CASE e.splint
WHEN '1' THEN 'มีการใส่ splint หรือ slab ก่อนมาถึง'
WHEN '2' THEN 'ไม่มีการใส่ splint หรือ slab ก่อนมาถึง'
WHEN '3' THEN 'ไม่จำเป็น'
END AS splint,

CASE e.fluid
WHEN '1' THEN 'มีการให้ IV fluid ก่อนมาถึง'
WHEN '2' THEN 'ไม่มีการให้ IV fluid ก่อนมาถึง'
WHEN '3' THEN 'ไม่จำเป็น'
END AS fluid,
t.nametri,
CASE e.coma_eye
WHEN '1' THEN 'ไม่ลืมตาเลย(ไม่มีการสตอบสนอง) No eye opening'
WHEN '2' THEN 'ลืมตาเมื่อได้รับการกระตุ้น Eye openig to pain'
WHEN '3' THEN 'ลืมตาเมื่อถูกเรียก Eye opening to verbal command'
WHEN '3' THEN 'ลืมตาได้เอง Eyes open spontaeously'
END AS coma_eye,
CASE e.coma_speak
WHEN '1' THEN 'ไม่เป็นคำพูดเลย No verbal response'
WHEN '2' THEN 'เปล่งเสียงได้แต่ไม่เป็นคำพูด หรือเสียงอยู่ในลำคอ Incomprehensible sound Or Innapropriate word'
WHEN '3' THEN 'พูดเป็นคำ ๆ Innapropriate word'
WHEN '4' THEN 'พูดสับสนไม่รู้เรื่อง Confused'
WHEN '5' THEN 'พูดได้เองถูกต้องเป็นประโยค Orientated'
END AS coma_speak,
CASE e.coma_move
WHEN '1' THEN 'ไม่เคลื่อนไหวโต้ตอบ No meter response'
WHEN '2' THEN 'แขนเหยียดผิดปกติ Extension to pain'
WHEN '3' THEN 'แขนหงอผิดปกติ (ชัก) flesion to pain'
WHEN '4' THEN 'ชักแขนขาหนึเมื่อได้รับการกระตุ้น Withdrawal from pain'
WHEN '5' THEN 'ทราบตำแหน่งที่ได้รับบาดเจ็บ Localising pain'
END AS coma_move,
e.d_update,e.note from emergency e
LEFT JOIN l_aetype aet on aet.aetype_code=e.aetype_ae
LEFT JOIN l_aeplace aep on aep.aeplace=e.aeplace
LEFT JOIN l_typein_ae tae on tae.typein_ae=e.typein_ae
LEFT JOIN l_vehicle veh on veh.vehicle=e.vehicle
LEFT JOIN optriage ot on ot.vn=e.vn
LEFT JOIN triage t on t.codetri=ot.triage
where e.vn=$vn ";

$result = mysql_query($sql, $con);
//e.vn='$vn'  e.vn=958010

//echo mysql_num_rows($result);

    $data .= "<h5>การคัดกรองทางอุบัติเหตุ</h5>";
    $data .="<ul class='emergency'>";
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $data .= "<li class='emergency'><span class='emergencyLabel'>วันที่เกิดเหตุ</span><span>".DateThai($row['sickdate'])."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>เวลาเกิดเหตุ</span><span>".$row['sicktime']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ประเภทอุบัติเหตุ</span><span>".$row['aetype_desc_th']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>สถานที่เกิดอุบัติเหตุ</span><span>".$row['nameaeplace']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>วิธีการนำสั่งตัว</span><span>".$row['nametypein']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ประเภทยานพาหนะ</span><span>".$row['namevehicle']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ประเภทผู้บาดเจ็บ</span><span>".$row['traffic']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การดื่มแอลกอฮอล์</span><span>".$row['alochol']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การใช้ยาเสพติด</span><span>".$row['nacrotic']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การคาดเข็มขัดนิรภัย</span><span>".$row['belt']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การสวมหมวกนิรภัย</span><span>".$row['helmet']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การดูแลการหายใจ</span><span>".$row['airway']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การห้ามเลือด</span><span>".$row['stopbleed']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การใส splint/slab</span><span>".$row['splint']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>การให้น้ำเกลือ/slab</span><span>".$row['fluid']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ระดับความเร่งด่วน/slab</span><span>".$row['nametri']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ระดับความรู้สึกทางตา</span><span>".$row['coma_eye']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ระดับความรู้สึกทางด้านการพูด</span><span>".$row['coma_speak']."</span></li>";
        $data .= "<li class='emergency'><span class='emergencyLabel'>ระดับความรู้สึกทางการเคลือนไหว</span><span>".$row['coma_move']."</span></li>";



    }

    $data .="</ul>";

echo $data;

exit;
?>
