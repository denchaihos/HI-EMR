<html lang="th">
<head>
<meta http-equiv="Content-Language" content="th"> 
<meta http-equiv="content-Type" content="text/html; charset=window-874"> 
<meta http-equiv="content-Type" content="text/html; charset=tis-620"> 
<link rel="stylesheet" href="style.css">
</head>
<body> 
 <?php   
function num2wordsThai($num){   
    $num=str_replace(",","",$num);
    $num_decimal=explode(".",$num);
    $num=$num_decimal[0];
    $returnNumWord;   
    $lenNumber=strlen($num);   
    $lenNumber2=$lenNumber-1;   
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
    $kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="ยี่";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="สอง";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";   
                }   
            }   
        }   
        if($kaNumWord[$i]==0){   
            if($i!=6){
                $kaGroup[$i]="";   
            }
        }   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
    }      
    if(isset($num_decimal[1])){
        $returnNumWord.="บาท";
        if($num_decimal[1]="00"){
            $returnNumWord.="ถ้วน";
        } else {
            for($i=0;$i<strlen($num_decimal[1]);$i++){
                $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];  
            }
            $returnNumWord.="สตางค์";
        }
    }       
    return $returnNumWord;   
}   
?>     
<?php 
$servername = "192.168.10.11"; 
$username = "hiuser"; 
$password = "212224";
// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "select o.hn,concat(p.fname,' ',p.lname) as ptname,timestampdiff(year,p.brthdate,o.vstdttm) as age,p.pop_id as cid,male.namemale as sex,mrtlst.namemrt as mst,ipt.an,j.nameoccptn as job, ";
$sql = $sql." concat( date_format(o.vstdttm,'%d/%m/'),year(o.vstdttm)+543,date_format(o.vstdttm,' เวลา %H.%i น.')) as rgd, ";
$sql = $sql." if(o.an=0,concat(date_format((select max(srvdttm) from hi.ovstdr where o.vn=ovstdr.vn),'%d/%m/'),(select year(max(srvdttm)) from hi.ovstdr where o.vn=ovstdr.vn)+543, ";
$sql = $sql." date_format((select max(srvdttm) from hi.ovstdr where o.vn=ovstdr.vn),' เวลา %H.%i น.')), ";
$sql = $sql." concat(date_format(ipt.dchdate,'%d/%m/'),year(ipt.dchdate)+543,' ', date_format(time(dchtime*100),' เวลา %H.%i น.'))) as dcdate, ifnull(ipt.daycnt,'-') as losd, ";
$sql = $sql." (select namehosp from hi.insure inner join hi.hospcode on insure.hospmain=hospcode.off_id where o.hn=insure.hn and o.pttype=insure.pttype and insure.dateexp >= o.vstdttm order by notedate desc limit 1) as hmain,";
$sql = $sql." sum(case i.income when '01' then i.rcptamt else 0 end) as c1,sum(case i.income when '02' then i.rcptamt else 0 end) as c2,sum(case i.income when '03' then i.rcptamt else 0 end) as c3, ";
$sql = $sql." sum(case i.income when '04' then i.rcptamt else 0 end) as c4,sum(case when i.income='05' and cgd not in (55020,55021) then i.rcptamt else 0 end) as c5,sum(case i.income when '06' then i.rcptamt else 0 end) as c6, ";
$sql = $sql." sum(case i.income when '07' then i.rcptamt else 0 end) as c7,sum(case i.income when '08' then i.rcptamt else 0 end) as c8,sum(case i.income when '09' then i.rcptamt else 0 end) as c9, ";
$sql = $sql." sum(case i.income when '10' then i.rcptamt else 0 end) as c10,sum(case i.income when '11' then i.rcptamt else 0 end) as c11,sum(case i.income when '12' then i.rcptamt else 0 end) as c12, ";
$sql = $sql." sum(case i.income when '13' then i.rcptamt else 0 end) as c13,sum(case i.income when '14' then i.rcptamt else 0 end) as c14,sum(case i.income when '15' then i.rcptamt else 0 end) as c15, ";
$sql = $sql." sum(case i.income when '16' then i.rcptamt else 0 end) as c16,sum(case i.income when '17' then i.rcptamt else 0 end) as c17,sum(case i.income when '18' then i.rcptamt else 0 end) as c18, ";
$sql = $sql." sum(case i.income when '19' then i.rcptamt else 0 end) as c19,sum(case i.income when '20' then i.rcptamt else 0 end) as c20,sum(case when ( i.income='21' or (income='05' and cgd in (55020,55021))) then i.rcptamt else 0 end) as c21, ";
$sql = $sql." sum(case i.income when '22' then i.rcptamt else 0 end) as c22,sum(case i.income when '23' then i.rcptamt else 0 end) as c23,sum(i.rcptamt) as total,if(o.an=0,ovstost.nameovstos,dchtype.namedchtyp) as dc, ";
$sql = $sql." concat(dct.fname,' ',dct.lname) as doctor,dct.lcno,upper(c.icd10name) as diagnosis, (select namehosp from hi.orfro inner join hi.hospcode on orfro.rfrlct=hospcode.off_id where o.vn=orfro.vn limit 1) as referhosp ";
$sql = $sql." from hi.ovst as o inner join hi.pt as p on o.hn=p.hn  and o.hn=".$_GET["hn"]." left join hi.ipt on o.vn=ipt.vn inner join hi.ovstdx as ox on o.vn=ox.vn and ox.cnt=1 ";
$sql = $sql." inner join hi.male on p.male=male.male left join hi.iptdx as x on ipt.an=x.an and x.itemno=1 inner join hi.icd101 as c on if(o.an=0,ox.icd10=c.icd10,x.icd10=c.icd10) inner join hi.incoth as i on o.vn=i.vn ";
$sql = $sql." left join hi.dchtype on ipt.dchtype=dchtype.dchtype left join hi.mrtlst on p.mrtlst=mrtlst.mrtlst  left join hi.occptn as j on p.occptn=j.occptn left join hi.ovstost on o.ovstost=ovstost.ovstost ";
$sql = $sql." left join hi.dct on (CASE WHEN LENGTH(o.dct) = 5 THEN dct.lcno = o.dct 	WHEN LENGTH(o.dct) = 4 THEN dct.dct = substr(o.dct,3,2)  WHEN LENGTH(o.dct) = 2 THEN dct.dct = o.dct END ) ";
$sql = $sql." where o.hn= " . $_GET["hn"] . " and if(o.an=0,o.vstdttm = '" . $_GET["adate"] . "',ipt.rgtdate='". $_GET["adate"] ."') group by o.vn" ;


$proc = "select  concat(p.icd9name,'(',d.cgd,')') as item,if(p.qty=0,count(d.id),qty) as qty,d.pricecgd as unit_price,if(p.qty=0,sum(p.charge),p.charge) as total from  hi.ovst as o ";
$proc = $proc." inner join hi.oprt as p on o.vn=p.vn  inner join hi.prcd as d on p.codeicd9id=d.id where hn = " . $_GET["hn"] ." and o.vstdttm ='" . $_GET["adate"] ."'  group by d.id";
$proc = $proc." union ";
$proc = $proc."select concat(b.labname,'(',b.cgd,')') as item,count(l.ln) as qty,b.pricelab as unit_price,sum(b.pricelabcgd) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='01' ";
$proc = $proc."inner join hi.lbbk as l on i.codecheck=l.ln inner join hi.lab as b on l.labcode =b.labcode where o.hn=" . $_GET["hn"] ." and o.vstdttm ='" . $_GET["adate"] ."' group by b.labcode";
$proc = $proc." union ";
$proc = $proc." select concat(b.xryname,'(',b.cgd,')') as item,count(x.xan) as qty,b.pricexry as unit_price,sum(b.pricexry) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='02'";
$proc = $proc." inner join hi.xryrgt as x on substr(i.codecheck,2,5)=x.xan inner join hi.xray as b on x.xrycode =b.xrycode where o.hn=" . $_GET["hn"] ." and o.vstdttm ='" . $_GET["adate"] ."' group by b.xrycode ";
$proc = $proc." union ";
$proc = $proc." select m.`name` as item,sum(d.qty) as qty,m.price as unit_price,sum(d.charge) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='08' ";
$proc = $proc." inner join hi.prsc as p on substr(i.codecheck,2,8)=p.prscno inner join hi.prscdt as d on p.prscno=d.prscno inner join hi.meditem as m on d.meditem=m.meditem and m.type != 1 ";
$proc = $proc." where o.hn=" . $_GET["hn"] ." and o.vstdttm ='" . $_GET["adate"] ."'  group by m.meditem";

$drug = " select m.`name` as item,sum(d.qty) as qty,m.price as unit_price,sum(d.charge) as total from hi.ovst as o inner join hi.incoth as i on o.vn=i.vn and i.income='08' ";
$drug = $drug." inner join hi.prsc as p on substr(i.codecheck,2,8)=p.prscno inner join hi.prscdt as d on p.prscno=d.prscno inner join hi.meditem as m on d.meditem=m.meditem and m.type = 1 ";
$drug = $drug." where o.hn=" . $_GET["hn"] ." and o.vstdttm ='" . $_GET["adate"] ."'  group by m.meditem";

// mysql_query("SET NAMES TIS620");
mysqli_query($conn, "SET NAMES UTF8");

$result = mysqli_query($conn, $sql);
$r = mysqli_query($conn, $proc);
$d = mysqli_query($conn, $drug);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { 
?><div align="right"><font size="3">
    (แบบฟอร์ม พรบ.002/2560)</font>
  </div>
    <div  align="center"><font size="4">
	    <h4>โรงพยาบาลทุ่งศรีอุดม จังหวัดอุบลราชธานี <br>
            แบบฟอร์มสรุปค่ารักษาพยาบาลและใบแจ้งหนี้การรักษาพยาบาล<br>
         
        
            <b>ชื่อหน่วยบริการ : </b> โรงพยาบาลทุ่งศรีอุดม อำเภอทุ่งศรีอุดม จังหวัดอุบลราชธานี 
        </h4>
    </div>
<?php 
    $drug=$row["c8"]+$row["c9"]+$row["c13"];
    $rf = $row["c16"]+$row["c17"];
    $other = $row["c1"]+$row["c2"]+$row["c3"]+$row["c4"]+$row["c5"]+$row["c6"]+$row["c7"]+$row["c10"]+$row["c11"]+$row["c12"]+$row["c15"]+$row["c18"]+$row["c19"]+$row["c20"]+$row["c22"];
    $df = $row["c21"];
    $refer = $row["c23"];
    $total=$row["total"];
    echo "<table border='-' align='center' size='5' ><tr><th colspan='7' align='left' style='padding:5px;'>";

    echo " <b>ชื่อ-สกุล :</b> ".$row["ptname"]." <b>อายุ :</b> " .$row["age"]." ปี  <b>HN : </b>". $row["hn"]."  <b>AN : </b> ".$row["an"]." ";
    echo " <b>เลขบัตรประชาชน : </b> ".$row["cid"]. " <b>อาชีพ :</b>".$row["job"]." </br> "; 
    echo " <b> โรงพยาบาลคู่สัญญาหลัก : </b>".$row["hmain"]."<br>";
    echo " <b> วันที่รับไว้ : </b>".$row["rgd"]." <b> วันที่จำหน่าย : </b>".$row["dcdate"]." <b> รวม </b> ".$row["losd"]." วัน <br>";
    echo " <b> การวินิจฉัย : </b>".$row["diagnosis"]."<br>";
    echo " <b> แพทย์ผู้ตรวจ : </b> ".$row["doctor"]." <b>เลขใบประกอบวิชาชีพ </b> ".$row["lcno"]."<br>";
    echo " <b> สถานะภาพการจำหน่าย : </b>".$row["dc"]." <b> โรงพยาบาลที่ส่งต่อ :</b>".$row["referhosp"]."<br>";
    echo "</th></tr>";
    }
} else {
    // echo $sql;
    echo "no Pt  in List";
}
    //echo $sql;
    $n=1;
    echo "<tr><th>ลำดับ</th><th width='300'>รายการ</th><th width='50'>ราคาต่อหน่วย</th><th width='50'>จำนวน</th><th width='100'>ค่าใช้จ่าย(บาท)</th><th>จ่ายแล้ว</th><th  width='200'>หมายเหตุ</th></tr>";
    echo "<tr><td colspan=7  align='center'> รายการให้บริการทางการแพทย์, หัตถการ, Lab, X-Ray, ตรวจพิเศษอื่นๆ และ เวชภัณฑ์มิใช่ยา</td></tr>";
    if (mysqli_num_rows($r) > 0) {
        // output data of each row
        while($rows = mysqli_fetch_assoc($r)) { 
            echo "<tr><td align='center'>".$n."</td><td>".iconv(  'TIS-620','UTF-8'  ,$rows["item"])."</td><td align='right'>".$rows["unit_price"]."</td><td align='right'>".$rows["qty"]."</td><td align='right'>".$rows["total"]."</td><td></td><td></td></tr>";       
        $n++;
        }
} else {
    echo $list;
}
echo "<tr><td colspan=7  align='center'> รายการยา  </td></tr>";
if (mysqli_num_rows($d) > 0) {
    // output data of each row
    while($rows = mysqli_fetch_assoc($d)) { 
        echo "<tr><td align='center'>".$n."</td><td>".$rows["item"]."</td><td align='right'>".$rows["unit_price"]."</td><td align='right'>".$rows["qty"]."</td><td align='right'>".$rows["total"]."</td><td></td><td></td></tr>";       
    $n++;
    }
} else {
echo $list;
}
echo "<tr><td align='center'>".$n."</td><td>ค่าบริการทางการแพทย์</td><td></td><td></td><td align='right'>".number_format($df,2,'.',',')."</td><td></td><td></td></tr>";
    $n++;
    echo "<tr><td align='center'>".$n."</td><td>ค่าห้อง/ค่าอาหาร</td><td></td><td></td><td align='right'>".number_format($rf,2,'.',',')."</td><td></td><td></td></tr>";
    $n++;
    echo "<tr><td align='center'>".$n."</td><td>ค่าบริการพาหนะขนส่ง</td><td></td><td></td><td align='right'>".number_format($refer,2,'.',',')."</td><td></td><td></td></tr>";
	echo "<tr><td></td><td><b>รวม</b></td><td></td><td></td><td align='right'>".number_format($total,2,'.',',')."</td><td></td><td></td></tr>";
    echo "</table>"; 
    echo "<p></p>";
    echo "<div align='center'>รวมเป็นเงินทั้งสิ้น ".number_format($total,2,'.',','). " บาท  (".num2wordsThai($total).")</div></p>"	;
    echo "<div align='center'>ข้าพเจ้าขอยืนยันว่าได้รับบริการตามรายการนี้จริงและได้รับทราบรายการหลักฐานเอกสารที่ต้องนำส่งเพื่อขอรับค่ารักษาพยาบาลจากบริษัทประกันภัยแล้ว</div>";
?>
    <p><br>
    <div align="center">  &nbsp &nbsp ลงชื่อ ...................................... ผู้ตรวจสอบ </div>
    <div align="center">(นายอนุชา  แสงหิรัญ)   </div>
    <div align="center">นักวิชาการสาธารณสุขปฏิบัติการ<br>
    หัวหน้ากลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์  </div>
    </div>
</p>
<p style="page-break-after: always;"></p>
<p style="page-break-before: always;"></p>

</font>
</body></html>
<?php
mysqli_close($conn);

?>
</body>
</html>
