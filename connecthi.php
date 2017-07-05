<?php
$host = "192.168.10.12";
$uname = "hiuser";
$passwd = "212224";
$dbname = "hi";
$con = mysql_connect($host,$uname,$passwd);
//$con = mysql_connect('192.168.11.5', 'hiuser', '212224');
//$con = mysql_connect('192.168.10.12', 'hiuser', '212224');
If (!$con) {
    echo "<h3> error  :  Can not coonect databse</h3>";
    exit();
}else{
//echo "success";
mysql_select_db("hi");
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
}
?>