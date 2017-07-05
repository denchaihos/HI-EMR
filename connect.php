<?php
include 'readConfig.php';
$host = trim($config['host']);
$uname = trim($config['username']);
$passwd = trim($config['password']);
$dbname = trim($config['db']);
$con = mysql_connect($host,$uname,$passwd);
//$con = mysql_connect('192.168.11.5', 'hiuser', '212224');
//$con = mysql_connect('localhost', 'root', '123456');
If (!$con) {
    echo "<h3> error  :  Can not conect databse</h3>";
    exit();
}else{
//echo "success";
mysql_select_db($dbname);
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
}
?>