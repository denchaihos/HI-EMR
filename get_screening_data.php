<?php
header('Content-Type: text/html; charset=utf-8');
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
//$vstdttm =$_GET['vstdttm'];
//$hn = $_GET['hn'];
$vn = $_GET['vn'];
$sql = "select o.*,time(o.vstdttm) as vstdttm from ovst o "
    . " where o.vn = '$vn'   order by o.vstdttm desc ";
$data = array();

$result = mysql_query($sql, $con);
$numrows = mysql_num_rows($result);
if ($numrows > 0) {
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $data = "  <span class='label label-default' id='title'>น้ำหนัก&nbsp</span>
                                                    <span id='bw' class='text_content'>" . $row['bw'] . "</span>
                                                    <span class='label label-default' id='title'>ส่วนสูง&nbsp</span>
                                                    <span id='height' class='text_content'>" . $row['height'] . " </span>
                                                    <span class='label label-default' id='title'>รอบเอว&nbsp</span>
                                                    <span id='waist_cm' class='text_content'>" . $row['waist_cm'] . "</span>
                                                    <span class='label label-default' id='title'>BMI&nbsp</span>
                                                    <span id='bmi' class='text_content'>" . $row['bmi'] . " </span>
                                                    <span class='label label-default' id='title'>อุณหภูมิ&nbsp</span>
                                                    <span id='tt' class='text_content'>" . $row['tt'] . " </span>
                                                    <span class='label label-default' id='title'>pr&nbsp</span>
                                                    <span id='pr' class='text_content'> " . $row['pr'] . " </span>
                                                    <span class='label label-default' id='title'>rr&nbsp</span>
                                                    <span id='rr' class='text_content'> " . $row['rr'] . "</span>
                                                    <span class='label label-default' id='title'>BP&nbsp</span>
                                                    <span id='sbp' class='text_content'> " . $row['sbp'] . "/" . $row['dbp'] . "</span>
                                                    <br/> ";

        //cc////////
        $sql_cc = 'select symptom from symptm where vn="' . $row['vn'] . '"  ';
        $result_cc = mysql_query($sql_cc);
        $row_array['cc'] = "-";
        while ($row_cc = mysql_fetch_array($result_cc, MYSQL_ASSOC)) {
            $row_array['cc'] = $row_array['cc'] . $row_cc['symptom'];

        };
        $data .= "<span class='label label-default' id='title'>CC&nbsp</span>
                                                    <span id='cc_h' class='text_content'> " . $row_array['cc'] . "</span><br>";


        //pi////////
        $sql_pi = "select pillness from pillness where vn=" . $row['vn'] . " ";
        $result_pi = mysql_query($sql_pi);
        $row_array['pi'] = "-";
        while ($row_cc = mysql_fetch_array($result_pi, MYSQL_ASSOC)) {
            $row_array['pi'] = $row_array['pi'] . $row_cc['pillness'];

        };
        $data .= "<span class='label label-default' id='title'>PI&nbsp</span>
                                                    <span id='cc_h' class='text_content'> " . $row_array['pi'] . "</span>";


    }
} else {
    $data = 'No Data';
}
echo $data;

?>