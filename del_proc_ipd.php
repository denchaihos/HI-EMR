<?php
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$id_dx = $_POST['id_dx'];



$sql = "select id from tsu_ioprt_original where id=$id_dx";
$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
    $sql = "INSERT INTO tsu_ioprt_original
            SELECT *,now(),'del' from ioprt where id=$id_dx";
    $result = mysql_query($sql);
    if($result){
        $sql_del = "delete from ioprt  where id=$id_dx ";
        $result_del = mysql_query($sql_del);
        if($result_del)
        {
            echo "Delete Success<br>";
        }
        else
        {
            echo "Delete Error29<br>";
            echo mysql_error();
        }
    }else {
        echo "Delete Error35<br>";
        echo mysql_error();

    }
}else{
    $sql_del = "delete from ioprt  where id=$id_dx ";
    $result_del = mysql_query($sql_del);
    if($result_del)
    {
        echo "Delete Success";
    }
    else
    {
        echo "Delete Error";
        echo mysql_error();

    }
}

