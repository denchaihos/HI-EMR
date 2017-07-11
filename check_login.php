<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta  charset="utf-8">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/alertifyjs/alertify.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link href="js/alertifyjs/css/alertify.min.css" rel="stylesheet" type="text/css"  media="screen" />
    <link href="js/alertifyjs/css/alertify.core.css" rel="stylesheet" type="text/css"  media="screen" />
   <link href="js/alertifyjs/css/alertify.default.css" rel="stylesheet" type="text/css"  media="screen" id="toggleCSS" />
    <link href="js/alertifyjs/css/alertify.bootstrap3.css" rel="stylesheet" type="text/css"  media="screen" id="toggleCSS" />

</head>
<body>
<?php
include 'connect.php';
include 'crc16.php';

echo crc16($_POST['password']);
$psswrd = crc16($_POST['password']);
//$strSQL = "SELECT * FROM dct WHERE dct = '".$_POST['username']."'";
//$strSQL = "SELECT * FROM dct WHERE dct = '".$_POST['username']."' and pssword = crc16('".$_POST['password']."')";
$strSQL = "SELECT * FROM dct WHERE dct = '".$_POST['username']."' and psswrd = '$psswrd'";
$objQuery = mysql_query($strSQL);

$objResult = mysql_fetch_array($objQuery, MYSQL_ASSOC);
if(empty($objResult)) {
    echo "Process Login";
    ?>

    <script>
        //alert  popup
        alertify.alert("ผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง กรุณา login อีกครั้ง", function (e) {
            if (e) {
                // user clicked "ok"
                window.location.replace("index.php");
            }

        });



    </script>
<?php
}else{
$_SESSION["fullname"] = $objResult['fname'];


session_write_close();
?>

    <script language="JavaScript">
        sec=1;
        function tplus() {
            sec-=1;
            if (sec==0) {
                //window.location.replace("index.php");
                window.location.replace("index.php");
            }
            if (sec>0) {
                setTimeout("tplus()",1000);
            }
        }
        setTimeout("tplus()",1000);
    </script>
<?php
}
//mysql_close($con);

?>
</body>
</html>