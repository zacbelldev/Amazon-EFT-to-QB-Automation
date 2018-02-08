<?php
// PDO connect *********
function connect()
{
    $host = "127.0.0.1";
    $db_name = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    $db_user = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    $db_password = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    return new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $db_user, $db_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
