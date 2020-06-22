<html lang="th">

<head>
	<meta http-equiv="Content-Language" content="th">
	<meta http-equiv="content-Type" content="text/html; charset=window-874">
	<meta http-equiv="content-Type" content="text/html; charset=tis-620">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
function num2wordsThai($num)
{
    $num = str_replace(",", "", $num);
    $num_decimal = explode(".", $num);
    $num = $num_decimal[0];
    $returnNumWord = '';
    $lenNumber = strlen($num);
    $lenNumber2 = $lenNumber - 1;
    $kaGroup = array("", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
    $kaDigit = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ต", "แปด", "เก้า");
    $kaDigitDecimal = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ต", "แปด", "เก้า");
    $ii = 0;
    for ($i = $lenNumber2; $i >= 0; $i--) {
        $kaNumWord[$i] = substr($num, $ii, 1);
        $ii++;
    }
    $ii = 0;
    for ($i = $lenNumber2; $i >= 0; $i--) {
        if (($kaNumWord[$i] == 2 && $i == 1) || ($kaNumWord[$i] == 2 && $i == 7)) {
            $kaDigit[$kaNumWord[$i]] = "ยี่";
        } else {
            if ($kaNumWord[$i] == 2) {
                $kaDigit[$kaNumWord[$i]] = "สอง";
            }
            if (($kaNumWord[$i] == 1 && $i <= 2 && $i == 0) || ($kaNumWord[$i] == 1 && $lenNumber > 6 && $i == 6)) {
                if ($kaNumWord[$i + 1] == 0) {
                    $kaDigit[$kaNumWord[$i]] = "หนึ่ง";
                } else {
                    $kaDigit[$kaNumWord[$i]] = "เอ็ด";
                }
            } elseif (($kaNumWord[$i] == 1 && $i <= 2 && $i == 1) || ($kaNumWord[$i] == 1 && $lenNumber > 6 && $i == 7)) {
                $kaDigit[$kaNumWord[$i]] = "";
            } else {
                if ($kaNumWord[$i] == 1) {
                    $kaDigit[$kaNumWord[$i]] = "หนึ่ง";
                }
            }
        }
        if ($kaNumWord[$i] == 0) {
            if ($i != 6) {
                $kaGroup[$i] = "";
            }
        }
        $kaNumWord[$i] = substr($num, $ii, 1);
        $ii++;
        $returnNumWord .= $kaDigit[$kaNumWord[$i]] . $kaGroup[$i];
    }
    if (isset($num_decimal[1])) {
        $returnNumWord .= "บาท";
        if ($num_decimal[1] = "00") {
            $returnNumWord .= "ถ้วน";
        } else {
            for ($i = 0; $i < strlen($num_decimal[1]); $i++) {
                $returnNumWord .= $kaDigitDecimal[substr($num_decimal[1], $i, 1)];
            }
            $returnNumWord .= "สตางค์";
        }
    }
    return $returnNumWord;
}
?>
	<?php
$servername = "192.168.10.11";
$username = "hiuser";
$password = "212224";
$db = "hi";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_vn = "select vn,an,cln from ovst where hn=" . $_GET["hn"] . " and vstdttm='" . $_GET["adate"] . "'";

// Fetch one and one row
if ($result_vn = mysqli_query($conn, $sql_vn)) {
    while ($row_vn = mysqli_fetch_assoc($result_vn)) {
        $vn = $row_vn["vn"];
        $an = $row_vn["an"];
        $cln = $row_vn["cln"];

    }
} else {
    echo "error" . mysqli_error($conn);
}
// Free result set
mysqli_free_result($result_vn);

$sql = "select o.hn,concat(p.fname,' ',p.lname) as ptname,timestampdiff(year,p.brthdate,o.vstdttm) as age,p.pop_id as cid,male.namemale as sex,mrtlst.namemrt as mst,ipt.an,j.nameoccptn as job, ";
$sql = $sql . " concat( date_format(o.vstdttm,'%d/%m/'),year(o.vstdttm)+543,date_format(o.vstdttm,' เวลา %H.%i น.')) as rgd, ";
$sql = $sql . " if(o.an=0,concat(date_format((select max(srvdttm) from hi.ovstdr where o.vn=ovstdr.vn),'%d/%m/'),(select year(max(srvdttm)) from hi.ovstdr where o.vn=ovstdr.vn)+543, ";
$sql = $sql . " date_format((select max(srvdttm) from hi.ovstdr where o.vn=ovstdr.vn),' เวลา %H.%i น.')), ";
$sql = $sql . " concat(date_format(ipt.dchdate,'%d/%m/'),year(ipt.dchdate)+543,' ', date_format(time(dchtime*100),' เวลา %H.%i น.'))) as dcdate, ifnull(ipt.daycnt,'-') as losd,ptt.namepttype, ";
$sql = $sql . " (select namehosp from hi.insure inner join hi.hospcode on insure.hospmain=hospcode.off_id where o.hn=insure.hn and o.pttype=insure.pttype and insure.notedate >= date(o.vstdttm) order by notedate desc limit 1) as hmain,";
/*$sql = $sql." sum(case i.income when '01' then i.rcptamt else 0 end) as c1,sum(case i.income when '02' then i.rcptamt else 0 end) as c2,sum(case i.income when '03' then i.rcptamt else 0 end) as c3, ";
$sql = $sql." sum(case i.income when '04' then i.rcptamt else 0 end) as c4,sum(case when i.income='05' and cgd not in (55020,55021) then i.rcptamt else 0 end) as c5,sum(case i.income when '06' then i.rcptamt else 0 end) as c6, ";
$sql = $sql." sum(case i.income when '07' then i.rcptamt else 0 end) as c7,sum(case i.income when '08' then i.rcptamt else 0 end) as c8,sum(case i.income when '09' then i.rcptamt else 0 end) as c9, ";
$sql = $sql." sum(case i.income when '10' then i.rcptamt else 0 end) as c10,sum(case i.income when '11' then i.rcptamt else 0 end) as c11,sum(case i.income when '12' then i.rcptamt else 0 end) as c12, ";
$sql = $sql." sum(case i.income when '13' then i.rcptamt else 0 end) as c13,sum(case i.income when '14' then i.rcptamt else 0 end) as c14,sum(case i.income when '15' then i.rcptamt else 0 end) as c15, ";
$sql = $sql." sum(case i.income when '16' then i.rcptamt else 0 end) as c16,sum(case i.income when '17' then i.rcptamt else 0 end) as c17,sum(case i.income when '18' then i.rcptamt else 0 end) as c18, ";
$sql = $sql." sum(case i.income when '19' then i.rcptamt else 0 end) as c19,sum(case i.income when '20' then i.rcptamt else 0 end) as c20,sum(case when ( i.income='21' or (income='05' and cgd in (55020,55021))) then i.rcptamt else 0 end) as c21, ";

$sql = $sql." sum(case i.income when '22' then i.rcptamt else 0 end) as c22,sum(case i.income when '23' then i.rcptamt else 0 end) as c23,
 */
$sql = $sql . " sum(case when i.income='05' and cgd not in (55020,55021) then i.rcptamt else 0 end) as c5, ";
$sql = $sql . " sum(case i.income when '16' then i.rcptamt else 0 end) as c16,sum(case i.income when '17' then i.rcptamt else 0 end) as c17,sum(case i.income when '18' then i.rcptamt else 0 end) as c18, ";
$sql = $sql . " sum(case i.income when '19' then i.rcptamt else 0 end) as c19,sum(case i.income when '20' then i.rcptamt else 0 end) as c20,sum(case when ( i.income='21' or (income='05' and cgd in (55020,55021))) then i.rcptamt else 0 end) as c21, ";
$sql = $sql . " sum(case i.income when '22' then i.rcptamt else 0 end) as c22,sum(case i.income when '23' then i.rcptamt else 0 end) as c23,";
$sql = $sql . " sum(i.rcptamt) as total, if(o.an=0,ovstost.nameovstos,dchtype.namedchtyp) as dc, ";
$sql = $sql . " concat(dct.fname,' ',dct.lname) as doctor,dct.lcno, (select namehosp from hi.orfro inner join hi.hospcode on orfro.rfrlct=hospcode.off_id where o.vn=orfro.vn limit 1) as referhosp ";
$sql = $sql . " from hi.ovst as o inner join hi.pt as p on o.hn=p.hn  and o.hn=" . $_GET["hn"] . " left join hi.ipt on o.vn=ipt.vn ";
$sql = $sql . " inner join hi.male on p.male=male.male   inner join hi.incoth as i on o.vn=i.vn ";
$sql = $sql . " left join hi.dchtype on ipt.dchtype=dchtype.dchtype left join hi.mrtlst on p.mrtlst=mrtlst.mrtlst  left join hi.occptn as j on p.occptn=j.occptn left join hi.ovstost on o.ovstost=ovstost.ovstost LEFT JOIN hi.pttype ptt on ptt.pttype=o.pttype ";
$sql = $sql . " left join hi.dct on (CASE WHEN LENGTH(o.dct) = 5 THEN dct.lcno = o.dct 	WHEN LENGTH(o.dct) = 4 THEN dct.dct = substr(o.dct,3,2)  WHEN LENGTH(o.dct) = 2 THEN dct.dct = o.dct END ) ";
$sql = $sql . " where if(o.an=0,o.vn =$vn ,ipt.vn=$vn) group by o.vn";
// echo $sql;

if ($an == 0) {
    if ($cln == '40100') {
        $sql_diag = "select concat(d.icdda,':',c.icd10name) as diagnosis from dt t left join dtdx d on d.dn=t.dn left join icd101 c on  REPLACE(d.icdda,'.','')=c.icd10  where t.vn=$vn limit 1";
    } else {
        $sql_diag = "select concat(ox.icd10,':',c.icd10name) as diagnosis  from ovstdx ox 	inner join icd101  c on ox.icd10=c.icd10 where ox.vn=$vn ";
    }

} else {
    $sql_diag = "select  concat(ix.icd10,':',c.icd10name ) as diagnosis from iptdx ix 	inner join icd101  c on ix.icd10=c.icd10 where ix.an=$an and itemno=1";
}

// Fetch one and one row
$diagnosis = array();
if ($result_dx = mysqli_query($conn, $sql_diag)) {
    while ($row_diag = mysqli_fetch_assoc($result_dx)) {
        // $diagnosis.push($row_diag["diagnosis"]);
        array_push($diagnosis, $row_diag["diagnosis"]);
        // print_r($diagnosis);

    }
} else {
    echo "error" . mysqli_error($conn);
}
// Free result set
mysqli_free_result($result_dx);

//lab
$lab = "select concat(b.labname,'(',b.cgd,')') as item,count(l.ln) as qty,b.pricelab as unit_price,sum(b.pricelabcgd) as total from hi.ovst as o ";
$lab = $lab . "inner join hi.lbbk as l on o.vn=l.vn inner join hi.lab as b on l.labcode =b.labcode where o.vn = '$vn'  group by b.labcode";
//xray
$xray = " select concat(b.xryname,'(',b.cgd,')') as item,count(x.xrycode) as qty,b.pricexry as unit_price,sum(x.charge) as total ";
$xray = $xray . "from hi.ovst as o inner join hi.xryrgt as x on o.vn=x.vn ";
$xray = $xray . "inner join hi.xray as b on x.xrycode =b.xrycode where o.vn = $vn  group by x.xrycode ";

// proceder op
$proc = "select  concat(p.icd9name,'(',d.cgd,')') as item,if(p.qty=0,count(d.id),qty) as qty,d.pricecgd as unit_price,if(p.qty=0,sum(p.charge),p.charge) as total from  hi.ovst as o ";
$proc = $proc . " left join hi.oprt as p on o.vn=p.vn  left join hi.prcd as d on p.icd9name=d.nameprcd where o.vn = $vn and d.income='04'    group by d.id";
$proc = $proc . " union all ";
// proceder physical
$proc = $proc . "select  concat(p.icd9name,'(',d.cgd,')') as item,if(p.qty=0,count(d.id),qty) as qty,d.pricecgd as unit_price,if(p.qty=0,sum(p.charge),p.charge) as total from  hi.ovst as o ";
$proc = $proc . " left join hi.oprt as p on o.vn=p.vn  left join hi.prcd as d on p.icd9name=d.nameprcd where o.vn = $vn and d.income='06'    group by d.id";
$proc = $proc . " union all ";
// proceder thai massage
$proc = $proc . "select  concat(p.icd9name,'(',d.cgd,')') as item,if(p.qty=0,count(d.id),qty) as qty,d.pricecgd as unit_price,if(p.qty=0,sum(p.charge),p.charge) as total from  hi.ovst as o ";
$proc = $proc . " left join hi.oprt as p on o.vn=p.vn  left join hi.prcd as d on p.icd9name=d.nameprcd where o.vn = $vn and d.income='07'    group by d.id";
$proc = $proc . " union all ";
//proceder dental
$proc = $proc . " select concat(i.nameicdda,':',dx.icdda,'(',i.cgd,')') as item,'' as qty,if(c.pricedtt=0,dx.charge,c.pricedtt) as unit_price,dx.charge as total from dt d ";
$proc = $proc . " left join dtdx dx on dx.dn=d.dn left join icdda i on i.codeicdda=dx.icdda left join cdt2 c on c.codecdt2=dx.dttx left join areacode a on a.codearea=dx.area ";
$proc = $proc . " where d.vn=$vn group by dx.id";
$proc = $proc . " union all ";
//proceder ipd
$proc = $proc . " select  concat(p.icd9name,'(',d.cgd,')') as item,if(p.qty=0,count(d.id),qty) as qty,d.pricecgd as unit_price,sum(p.charge) as total from  hi.ovst as o ";
$proc = $proc . " left join hi.ioprt as p on o.an=p.an   left join hi.prcd as d on p.icd9name=d.nameprcd where o.vn = $vn and d.income='04'   group by d.id ";

//drug
$drug = " select pd.nameprscdt as item,sum(pd.qty) as qty ,m.price as unit_price, sum(pd.charge) as total ";
$drug = $drug . " from prsc p join prscdt pd on pd.prscno=p.prscno join meditem m on m.meditem=pd.meditem ";
$drug = $drug . " where p.vn=$vn and m.type=1 GROUP BY pd.meditem  ";
//nondrug
$ndrug = " select pd.nameprscdt as item,sum(pd.qty) as qty ,m.price as unit_price, sum(pd.charge) as total ";
$ndrug = $ndrug . " from prsc p join prscdt pd on pd.prscno=p.prscno join meditem m on m.meditem=pd.meditem ";
$ndrug = $ndrug . " where p.vn=$vn and m.type<>1 GROUP BY pd.meditem  ";

// $drug = " select m.`name` as item,sum(d.qty) as qty,m.price as unit_price,sum(d.charge) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='08' ";
// $drug = $drug." inner join hi.prsc as p on substr(i.codecheck,2,8)=p.prscno inner join hi.prscdt as d on p.prscno=d.prscno inner join hi.meditem as m on d.meditem=m.meditem  ";
// $drug = $drug." where o.vn = '$vn'   group by m.meditem";
// $drug = $drug." union ";
// $drug = $drug." select m.`name` as item,sum(d.qty) as qty,m.price as unit_price,sum(d.charge) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='11' ";
// $drug = $drug." inner join hi.prsc as p on i.vn=p.vn inner join hi.prscdt as d on p.prscno=d.prscno inner join hi.meditem as m on d.meditem=m.meditem  ";
// $drug = $drug." where o.vn = '$vn'   group by m.meditem";

// mysql_query("SET NAMES TIS620");
mysqli_query($conn, "SET NAMES UTF8");

$result = mysqli_query($conn, $sql);
$r = mysqli_query($conn, $proc);
$d = mysqli_query($conn, $drug);
$nd = mysqli_query($conn, $ndrug);
$l = mysqli_query($conn, $lab);
$x = mysqli_query($conn, $xray);

include "header.php";

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        

        $c1 = isset($row["c1"]) ? $row["c1"] : 0;
        $c2 = isset($row["c2"]) ? $row["c2"] : 0;
        $c3 = isset($row["c3"]) ? $row["c3"] : 0;
        $c4 = isset($row["c4"]) ? $row["c4"] : 0;
        $c5 = isset($row["c5"]) ? $row["c5"] : 0;
        $c6 = isset($row["c6"]) ? $row["c6"] : 0;
        $c7 = isset($row["c7"]) ? $row["c7"] : 0;
        $c8 = isset($row["c8"]) ? $row["c8"] : 0;
        $c9 = isset($row["c9"]) ? $row["c9"] : 0;
        $c10 = isset($row["c10"]) ? $row["c10"] : 0;
        $c11 = isset($row["c11"]) ? $row["c11"] : 0;
        $c12 = isset($row["c12"]) ? $row["c12"] : 0;
        $c13 = isset($row["c13"]) ? $row["c13"] : 0;
        $c14 = isset($row["c14"]) ? $row["c14"] : 0;
        $c15 = isset($row["c15"]) ? $row["c15"] : 0;
        $c16 = isset($row["c16"]) ? $row["c16"] : 0;
        $c17 = isset($row["c17"]) ? $row["c17"] : 0;
        $c18 = isset($row["c18"]) ? $row["c18"] : 0;
        $c19 = isset($row["c19"]) ? $row["c19"] : 0;
        $c20 = isset($row["c20"]) ? $row["c20"] : 0;
        $c21 = isset($row["c21"]) ? $row["c21"] : 0;
        $c22 = isset($row["c22"]) ? $row["c22"] : 0;
        $c23 = isset($row["c23"]) ? $row["c23"] : 0;

        $drug = $c8 + $c9 + $c13;
        $rf = $c16 + $c17;
        $other = $c1 + $c2 + $c3 + $c4 + $c5 + $c6 + $c7 + $c10 + $c11 + $c12 + $c15 + $c18 + $c19 + $c20 + $c22;
        $df = $c21;
        $refer = $c23;
        $c5 = $c5;
        $c18 = $c18;
        $total = $row["total"];
        echo "<table border='-' align='center' size='5' ><tr><th colspan='7' align='left' style='padding:5px;'>";

        echo " <b>ชื่อ-สกุล :</b> " . $row["ptname"] . " <b>อายุ :</b> " . $row["age"] . " ปี  <b>HN : </b>" . $row["hn"] . "  <b>AN : </b> " . $row["an"] . " ";
        echo " <b>เลขบัตรประชาชน : </b> " . $row["cid"] . " <b>อาชีพ :</b>" . $row["job"] . " </br> ";
        echo "  <b> สิทธิ์การรักษา : </b>" . $row["namepttype"] . " <b> โรงพยาบาลคู่สัญญาหลัก : </b>" . $row["hmain"] . "<br>";
        echo " <b> วันที่รับไว้ : </b>" . $row["rgd"] . " <b> วันที่จำหน่าย : </b>" . $row["dcdate"] . " <b> รวม </b> " . $row["losd"] . " วัน <br>";
        foreach ($diagnosis as $key => $value) {
            // echo "$value <br>";
            if ($key == 0) {
                echo " <b> การวินิจฉัยหลัก : </b>";
            } else {
                echo " <b> การวินิจฉัยรอง/ร่วม : </b>";
            }
            echo iconv("tis-620", "utf-8", $value);
            echo "<br>";
            // echo " <b> การวินิจฉัยรอง/ร่วม : </b>" . iconv("tis-620", "utf-8", $diagnosis[1]) . "<br>";
        }

        echo " <b> แพทย์ผู้ตรวจ : </b> " . $row["doctor"] . " <b>เลขใบประกอบวิชาชีพ </b> " . $row["lcno"] . "<br>";
        echo " <b> สถานะภาพการจำหน่าย : </b>" . $row["dc"] . " <b> โรงพยาบาลที่ส่งต่อ :</b>" . $row["referhosp"] . "<br>";
        echo "</th></tr>";
    }
} else {
    // echo $sql;
    echo "no Pt  in List";
}
//echo $sql;
$n = 1;
echo "<tr><th>ลำดับ</th><th width='300'>รายการ</th><th width='50'>ราคาต่อหน่วย</th><th width='50'>จำนวน</th><th width='100'>ค่าใช้จ่าย(บาท)</th><th>จ่ายแล้ว</th><th  width='200'>หมายเหตุ</th></tr>";

if (mysqli_num_rows($r) > 0) {
    // echo $proc;
    echo "<tr><td colspan=7  align='center'>  หัตถการ,แผนไทย,กายภาพ,  ตรวจพิเศษอื่นๆ </td></tr>";
    // output data of each row
    while ($rows = mysqli_fetch_assoc($r)) {
        echo "<tr><td align='center'>" . $n . "</td><td>" . $rows["item"] . "</td><td align='right'>" . $rows["unit_price"] . "</td><td align='right'>" . $rows["qty"] . "</td><td align='right'>" . $rows["total"] . "</td><td></td><td></td></tr>";
        $n++;
    }
} else {
    //echo $list;
    //echo $proc;
}
//Lab
if (mysqli_num_rows($l) > 0) {
    echo "<tr><td colspan=7  align='center'> รายการให้บริการ Lab </td></tr>";
    // output data of each row
    while ($rows = mysqli_fetch_assoc($l)) {
        echo "<tr><td align='center'>" . $n . "</td><td>" . $rows["item"] . "</td><td align='right'>" . $rows["unit_price"] . "</td><td align='right'>" . $rows["qty"] . "</td><td align='right'>" . $rows["total"] . "</td><td></td><td></td></tr>";
        $n++;
    }
} else {
    //echo $list;
}
//Lab
if (mysqli_num_rows($x) > 0) {
    echo "<tr><td colspan=7  align='center'> รายการให้บริการ Xray </td></tr>";
    // output data of each row
    while ($rows = mysqli_fetch_assoc($x)) {
        echo "<tr><td align='center'>" . $n . "</td><td>" . $rows["item"] . "</td><td align='right'>" . $rows["unit_price"] . "</td><td align='right'>" . $rows["qty"] . "</td><td align='right'>" . $rows["total"] . "</td><td></td><td></td></tr>";
        $n++;
    }
} else {
    //echo $list;
}

if (mysqli_num_rows($d) > 0) {
    echo "<tr><td colspan=7  align='center'> รายการยา  </td></tr>";
    // output data of each row
    while ($rows = mysqli_fetch_assoc($d)) {
        echo "<tr><td align='center'>" . $n . "</td><td>" . $rows["item"] . "</td><td align='right'>" . $rows["unit_price"] . "</td><td align='right'>" . $rows["qty"] . "</td><td align='right'>" . $rows["total"] . "</td><td></td><td></td></tr>";
        $n++;
    }
} else {
    //echo $list;

}
if (mysqli_num_rows($nd) > 0) {
    echo "<tr><td colspan=7  align='center'> เวชภัณฑ์มิใช่ยา  </td></tr>";
    // output data of each row
    while ($rows = mysqli_fetch_assoc($nd)) {
        echo "<tr><td align='center'>" . $n . "</td><td>" . $rows["item"] . "</td><td align='right'>" . $rows["unit_price"] . "</td><td align='right'>" . $rows["qty"] . "</td><td align='right'>" . $rows["total"] . "</td><td></td><td></td></tr>";
        $n++;
    }
} else {
    //echo $list;

}
echo "<tr><td colspan=7  align='center'> ค่าบริการอื่น ๆ </td></tr>";
echo "<tr><td align='center'>" . $n . "</td><td>ค่าบริการทางการแพทย์</td><td></td><td></td><td align='right'>" . number_format($df, 2, '.', ',') . "</td><td></td><td></td></tr>";
$n++;
echo "<tr><td align='center'>" . $n . "</td><td>ค่าบริการทางการพยาบาล</td><td></td><td></td><td align='right'>" . number_format($c5, 2, '.', ',') . "</td><td></td><td></td></tr>";
$n++;
echo "<tr><td align='center'>" . $n . "</td><td>ค่าห้อง/ค่าอาหาร</td><td></td><td></td><td align='right'>" . number_format($rf, 2, '.', ',') . "</td><td></td><td></td></tr>";
$n++;
echo "<tr><td align='center'>" . $n . "</td><td>ค่าบริการพาหนะขนส่ง</td><td></td><td></td><td align='right'>" . number_format($refer, 2, '.', ',') . "</td><td></td><td></td></tr>";
$n++;
echo "<tr><td align='center'>" . $n . "</td><td>ค่าบริการอื่นๆที่ไม่เกี่ยวกับการรักษาพยาบาลโดยตรง</td><td></td><td></td><td align='right'>" . number_format($c18, 2, '.', ',') . "</td><td></td><td></td></tr>";
echo "<tr><td></td><td><b>รวม</b></td><td></td><td></td><td align='right'>" . number_format($total, 2, '.', ',') . "</td><td></td><td></td></tr>";
echo "</table>";
echo "<p></p>";
echo "<div align='center'>รวมเป็นเงินทั้งสิ้น " . number_format($total, 2, '.', ',') . " บาท  (" . num2wordsThai($total) . ")</div></p>";
echo "<div align='center'>ข้าพเจ้าขอยืนยันว่าได้รับบริการตามรายการนี้จริงและได้รับทราบรายการหลักฐานเอกสารที่ต้องนำส่งเพื่อขอรับค่ารักษาพยาบาลจากบริษัทประกันภัยแล้ว</div>";

include "footer.php";
?>

</body>

</html>
<?php
mysqli_close($conn);

?>
</body>

</html>