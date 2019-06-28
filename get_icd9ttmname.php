<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$icd9ttm = $_GET['icd9ttm'];
$clinic = $_GET['clinic'];


/*$icd10 = "K08.1";
$cln = "40100";*/


$data = array();
if ($clinic == 'opd' || $clinic == 'ipd') {

    $sql = 'select id,codeprcd,nameprcd,priceprcd from prcd where codeprcd = "'.$icd9ttm.'"';
    $result = mysql_query($sql, $con);
    $numrow = mysql_num_rows($result);
    if ($numrow > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $row_array['codeprcd'] = $row['codeprcd'];
            $row_array['nameicd9'] = $row['nameprcd'];
            $row_array['price'] = $row['priceprcd'];
            $row_array['codeicd9id'] = $row['id'];
            array_push($data, $row_array);
        }
    } else {
        $row_array['codecdt2'] = 'ICD is not valid';
        $row_array['nameicd9'] = 'ICD is not valid';
        array_push($data, $row_array);
    }
} else {
    $sql = 'select codecdt2,namecdt2,pricedtt from cdt2 where codecdt2 = "' . $icd9ttm . '"';
    $result = mysql_query($sql, $con);
    $numrow = mysql_num_rows($result);
    if ($numrow > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $row_array['codecdt2'] = $row['codecdt2'];
            $row_array['nameicd9'] = $row['namecdt2'];
            $row_array['price'] = $row['pricedtt'];
            array_push($data, $row_array);
        }
    } else {
        $row_array['codecdt2'] = 'ICD is not valid';
        $row_array['nameicd9'] = 'ICD is not valid';
        array_push($data, $row_array);
    }
}
echo json_encode($data);

exit;
?>