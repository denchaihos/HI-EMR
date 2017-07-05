<?php
header("location:index.php");
session_start();
session_unset();
session_destroy();
echo "ออกจากระบบ เรียบร้อยแล้ว";
exit();
?>

